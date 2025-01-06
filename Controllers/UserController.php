<?php

// Inicia la sesión
session_start();

// Importar la conexión a la base de datos
require_once '../db.php';

class UserController {
    // Crear un nuevo usuario
    public function createUser($name, $surname, $telephone, $email, $password) {
        // Verificar si el usuario está autenticado y tiene permisos de administrador
        /*if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: login.php");
            exit();
        }*/

        
        global $pdo;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, surname, telephone, email, password, role) VALUES (?, ?, ?, ?, ?, 'cliente')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name,$surname, $telephone, $email, $hashedPassword]);
    }

    // Modificar un usuario
    public function updateClient($name, $surname, $telephone, $email,$id) {
        // Verificar si el usuario está autenticado y tiene permisos de administrador
       /* if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        $sql = "UPDATE users SET name = ?, surname = ?, telephone = ?, email = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $surname, $telephone, $email, $id]);
    }

    // Eliminar un usuario
    public function deleteClient($id) {
        // Verificar si el usuario está autenticado y tiene permisos de administrador
       /* if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
?>

