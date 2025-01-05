<?php
// Archivo de conexión a la base de datos

$host = 'localhost';   // Dirección del servidor de base de datos
$dbname = 'tienda_prueba_dwes';    // Nombre de la base de datos
$username = 'root';    // Usuario de la base de datos
$password = '';        // Contraseña de la base de datos

try {
    // Crear la conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
