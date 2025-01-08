<?php
//session_start();
require_once '../db.php';

// Verificar si el usuario es administrador
/*if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}*/
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Obtener datos de clientes y artículos
function getClients($pdo) {
    $sql = "SELECT * FROM users WHERE role = 'cliente'";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getItems($pdo) {
    $sql = "SELECT * FROM items";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$clients = getClients($pdo);
$items = getItems($pdo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="../css/index_admin.css" rel="stylesheet" />
</head>
<body>
    <!-- Barra de navegación -->
     
    <nav class="navbar">
        <div class="nav-links">
            <a href="#" id="showClients">Clientes</a>
            <a href="#" id="showItems">Artículos</a>
        </div>

        <!-- boton cerrar sesion-->
        <div class="d-flex flex-row order-lg-last align-items-center">
            <button 
                class="btn btn-outline-dark flex-center navbar-toggler order-last collapsed" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbar" 
                aria-expanded="false" 
                aria-controls="navbar" 
                onclick="window.location.href='login.php'">
                <i class=""></i> Cerrar Sesión
            </button>
        </div>
        
        <div class="profile">
            <span>Admin</span>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container">

<!--------------------------------------- Tabla de Clientes ------------------------------------------------------------------------------------------>
        <div id="clientsTable" class="table-container">
            <h2>Clientes</h2>
            <table id="clientsDataTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($client['id']); ?></td>
                            <td><?php echo htmlspecialchars($client['name']); ?></td>
                            <td><?php echo htmlspecialchars($client['surname']); ?></td>
                            <td><?php echo htmlspecialchars($client['email']); ?></td>
                            <td><?php echo htmlspecialchars($client['telephone'] ?? 'N/A'); ?></td>
                            <td>
                                <button class="edit-btn-client">Editar</button>
                                <button class="delete-btn-client">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Botón para añadir cliente -->
            <button class="add-client-btn" id="addClientBtn">+</button>

        

        <!-- Modales -->

        <!-- Modal Añadir Cliente -->
        <div class="modal" id="addClientModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Añadir Nuevo Cliente</h2>
                    <button class="close-btn" id="closeAddClientModal">&times;</button>
                </div>
                <form id="addClientForm">

                    <div class="row">
                        <div class="field-group">
                            <label for="addName">Nombre:</label>
                            <br/>
                            <input type="text" id="addName" name="addName" placeholder="Tu nombre" required>
                        </div>
                        <div class="field-group">
                            <label for="addSurname">Apellidos:</label>
                            <br/>
                            <input type="text" id="addSurname" name="addSurname" placeholder="Tus apellidos" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="field-group">
                            <label for="addPhone">Teléfono (opcional):</label>
                            <br/>
                            <input type="text" id="addPhone" name="addPhone" placeholder="Tu teléfono">
                        </div>
                        <div class="field-group">
                            <label for="addEmail">Correo electrónico:</label>
                            <br/>
                            <input type="email" id="addEmail" name="addEmail" placeholder="Tu correo" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="field-group">
                            <label for="addPassword">Contraseña:</label>
                            <br/>
                            <input type="text" id="addPassword" name="addPassword" placeholder="Contraseña" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="accept-btn">Guardar</button>
                        <button type="button" class="cancel-btn" id="cancelAddClient">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Editar Cliente-->
        <div class="modal" id="editModalClient">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Editar Cliente</h2>
                    <button class="close-btn" id="closeEditModalClient">&times;</button>
                </div>
                <form id="editFormClient">
                    <input type="hidden" id="editId">
                        <div class="row">
                            <div class="field-group">
                                <label for="editName">Nombre:</label>
                                <br/>
                                <input type="text" id="editName" name="editName" placeholder="Nombre" required>
                            </div>
                            <div class="field-group">
                                <label for="editSurname">Apellidos:</label>
                                <br/>
                                <input type="text" id="editSurname" name="editSurname" placeholder="Apellidos" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="field-group">
                                <label for="editPhone">Teléfono (opcional):</label>
                                <br/>
                                <input type="text" id="editPhone" name="editPhone" placeholder="Teléfono">
                            </div>
                            <div class="field-group">
                                <label for="editEmail">Correo electrónico:</label>
                                <br/>
                                <input type="email" id="editEmail" name="editEmail" placeholder="Email" required>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="accept-btn">Aceptar</button>
                        <button type="button" class="cancel-btn" id="cancelEditModalClient">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Eliminar Cliente-->
        <div class="modal" id="deleteModalClient">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Eliminar Cliente</h2>
                    <button class="close-btn" id="closeDeleteModalClient">&times;</button>
                </div>
                <p>¿Está seguro de que desea eliminar este cliente?</p>
                <div class="modal-footer">
                    <button class="accept-btn" type="submit" id="deleteClient" >Aceptar</button>
                    <button class="cancel-btn" id="cancelDeleteModalClient">Cancelar</button>
                </div>
            </div>
        </div>

<!------------------------------------------------ Tabla de Artículos ---------------------------------------------------------------------------------->
        <div id="itemsTable" class="table-container" style="display: none;">
            <h2>Artículos</h2>
            <table id="itemsDataTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['id']); ?></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['description']); ?></td>
                            <td>
                                <button class="edit-btn-item">Editar</button>
                                <button class="delete-btn-item">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

            <!-- Botón para añadir item -->
            <button class="hidden add-item-btn" id="addItemBtn">+</button>


    <!-- Modales -->

            <!-- Modal Añadir Item -->
            <div class="modal" id="addItemModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Añadir Nuevo Artículo</h2>
                    <button class="close-btn" id="closeAddItemModal">&times;</button>
                </div>
                <form id="addItemForm">
                        <div class="row">
                            <div class="field-group">
                                <label for="addNameItem">Nombre:</label>
                                <br/>
                                <input type="text" id="addNameItem" name="addNameItem" placeholder="Nombre" required>
                            </div>
                            <div class="field-group">
                                <label for="addPrice">Precio:</label>
                                <br/>
                                <input type="number" id="addPrice" name="addPrice" placeholder="Precio" required>
                            </div>
                            <div class="field-group">
                                <label for="addDescription">Descripción:</label>
                                <br/>
                                <input type="text" id="addDescription" name="addDescription" placeholder="Descripción">
                            </div>
                        </div>
                        
                    <div class="modal-footer">
                        <button type="submit" class="accept-btn">Guardar</button>
                        <button type="button" class="cancel-btn" id="cancelAddItem">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

            <!-- Modal Editar Item -->

    <div class="modal" id="editModalItem">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Editar Articulo</h2>
                    <button class="close-btn" id="closeEditModalItem">&times;</button>
                </div>
                <form id="editFormItem">
                <input type="hidden" id="editItemId">

                        <div class="row">
                            <div class="field-group">
                                <label for="editNameItem">Nombre:</label>
                                <br/>
                                <input type="text" id="editNameItem" name="editNameItem" placeholder="Nombre" required>
                            </div>
                            <div class="field-group">
                                <label for="editPrice">Precio:</label>
                                <br/>
                                <input type="number" id="editPrice" name="editPrice" placeholder="Precio" required>
                            </div>
                            <div class="field-group">
                                <label for="editDescription">Descripción:</label>
                                <br/>
                                <input type="text" id="editDescription" name="editDescription" placeholder="Descripción">
                            </div>
                        </div>
                        
                    <div class="modal-footer">
                        <button type="submit" class="accept-btn" >Aceptar</button>
                        <button type="button" class="cancel-btn" id="cancelEditModalClient">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

                    <!-- Modal Eliminar Item -->

        <div class="modal" id="deleteModalItem">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Eliminar Articulo</h2>
                    <button class="close-btn" id="closeDeleteModalItem">&times;</button>
                </div>
                <p>¿Está seguro de que desea eliminar este artículo?</p>
                <div class="modal-footer">
                    <button class="accept-btn"  type="submit" id="deleteItem">Aceptar</button>
                    <button class="cancel-btn" id="cancelDeleteModalItem">Cancelar</button>
                </div>
            </div>
        </div>



<!----------------------------- jQuery ------------------------------------------------------------>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../js/index_admin.js"></script>

    <script>
        // Inicializar DataTables
        $(document).ready(function () {
            $('#clientsDataTable').DataTable();
            $('#itemsDataTable').DataTable();
        });

        // Manejo de navegación entre tablas
        document.getElementById('showClients').addEventListener('click', function() {
            document.getElementById('clientsTable').style.display = 'block';
            document.getElementById('itemsTable').style.display = 'none';
            document.getElementById('addClientBtn').classList.toggle('hidden');
            document.getElementById('addItemBtn').classList.toggle('hidden');

        });

        document.getElementById('showItems').addEventListener('click', function() {
            document.getElementById('clientsTable').style.display = 'none';
            document.getElementById('itemsTable').style.display = 'block';
            document.getElementById('addClientBtn').classList.toggle('hidden');
            document.getElementById('addItemBtn').classList.toggle('hidden');

        });
    </script>


</body>
</html>
