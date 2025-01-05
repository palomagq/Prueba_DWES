<?php
// Inicia la sesión
session_start();

// Importar la conexión a la base de datos
require_once 'db.php';

class ItemController {
    // Crear un nuevo ítem
    public function createItem($name, $price, $description) {
        // Verificar si el usuario está autenticado y tiene permisos de administrador
       /* if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        $sql = "INSERT INTO items (name, price, description) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $price, $description]);
    }

    // Modificar un ítem
    public function updateItem($id, $name, $price, $description) {
        // Verificar si el usuario está autenticado y tiene permisos de administrador
        /*if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        $sql = "UPDATE items SET name = ?, price = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $price, $description, $id]);
    }

    // Eliminar un ítem
    public function deleteItem($id) {
        // Verificar si el usuario está autenticado y tiene permisos de administrador
        /*if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        $sql = "DELETE FROM items WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    // Obtener todos los ítems (sin necesidad de permisos)
    public function getAllItems() {
        global $pdo;
        $sql = "SELECT * FROM items";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un ítem por su ID (sin necesidad de permisos)
    public function getItemById($id) {
        global $pdo;
        $sql = "SELECT * FROM items WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

