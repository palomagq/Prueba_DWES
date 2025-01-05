<?php
session_start();

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db.php';
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['telephone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertar datos en la base de datos
    $sql = "INSERT INTO users (name, surname, telephone, email, password, role) VALUES (?, ?, ?, ?, ?, 'cliente')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $surname, $telephone, $email, $password]);

    header("Location: login.php"); // Redirigir a la página de inicio de sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center;">Registro</h2>
            <form method="post" action="../blade/register.php">
                <div class="row">
                    <div class="field-group">
                        <label for="name">Nombre:</label>
                        <br/>
                        <input type="text" id="name" name="name" placeholder="Tu nombre" required>
                    </div>
                    <div class="field-group">
                        <label for="surname">Apellidos:</label>
                        <br/>
                        <input type="text" id="surname" name="surname" placeholder="Tus apellidos" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="field-group">
                        <label for="phone">Teléfono (opcional):</label>
                        <input type="text" id="phone" name="phone" placeholder="Tu teléfono">
                    </div>
                    <div class="field-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" id="email" name="email" placeholder="Tu correo" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="field-group">
                        <label for="password">Contraseña:</label>
                        <br/>
                        <input type="password" id="password" name="password" placeholder="Tu contraseña" required>
                    </div>
                    <div class="field-group">
                        <label for="confirm_password">Confirmar contraseña:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirma tu contraseña" required>
                    </div>
                </div>
                
                <input type="submit" value="Registrarse">
            </form>
            <p style="font-size: 15px;">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>
    </div>
</body>
</html>
