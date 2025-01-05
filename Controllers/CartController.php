<?php
// Inicia la sesión
session_start();

// Importar la conexión a la base de datos
require_once '../db.php';

class CartController {
    // Agregar un artículo al carrito
    public function addToCart($userId, $itemId, $quantity) {
        // Verificar si el usuario está autenticado
       /* if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        $sql = "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $itemId, $quantity]);
    }

    // Numero de articulos en el carrito
    public function getCartNum($userId) {
        // Verificar si el usuario está autenticado
        /*if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        // Obtener la cantidad de los artículos del carrito
        $sql = "SELECT  COALESCE(sum(quantity),0)  as cantidad FROM cart WHERE user_id = ? and confirmado = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Muestra  el carrito
    public function getCart($userId) {
        // Verificar si el usuario está autenticado
        /*if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        // Obtener los artículos del carrito
        $sql = " SELECT i.name,i.price, count(c.quantity) as cantidad, sum(i.price * c.quantity) as total FROM `cart` as c inner join items as i on c.item_id=i.id INNER join users as u on c.user_id=u.id WHERE c.user_id = ? and c.confirmado = 0 GROUP by i.name, i.price";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Eliminar un artículo del carrito
    public function removeFromCart($userId, $itemId) {
        // Verificar si el usuario está autenticado
        /*if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }*/

        global $pdo;
        $sql = "DELETE FROM cart WHERE user_id = ? AND item_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $itemId]);
    }

        // Checkout compra
        public function checkout($userId) {
            // Verificar si el usuario está autenticado
            /*if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit();
            }*/
    
            global $pdo;
            // Obtener los artículos del carrito
            $sql = "UPDATE cart SET confirmado=1 WHERE user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
}
?>
