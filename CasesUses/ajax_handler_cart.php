<?php
require_once '../Controllers/CartController.php';

// Leer el cuerpo JSON de la solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);  // Decodifica el JSON a un array asociativo

// Comprobar si la solicitud es válida
if ($data && isset($data['action'])) {
    $action = $data['action'];  // Acción a ejecutar

    // Crear una instancia del controlador
    $controller = new CartController();
    // Llamar a la función correspondiente dependiendo de la acción
    if (method_exists($controller, $action)) {
        // Llamar a la función del controlador pasando los datos
        switch ($action) {
            case 'addToCart':
                if (isset($data['user_id'], $data['item_id'], $data['quantity'])) {
                    // Llamar a addToCart con los datos necesarios
                    $controller->$action($data['user_id'], $data['item_id'], $data['quantity']);
                    echo json_encode(['status' => 'success', 'message' => 'Articulo añadido al carrito correctamente']);
                    exit();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Faltan datos para añadir el articulo al carrito']);
                    exit();
                }
                break;
            case 'getCartNum':
                    if (isset($data['user_id'])) {
                        // Llamar a getCartNum con los datos necesarios
                        $data = $controller->$action($data['user_id']);
                        echo json_encode(['status' => 'success', 'message' => 'Cantidad de articulos en el carrito añadida correctamente', 'datos' => $data]);
                        exit();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al mostrar la cantidad de articulos en el carrito ']);
                        exit();
                    }
                    break;
            case 'getCart':
                
                if (isset($data['user_id'])) {
                    // Llamar a getCart con los datos necesarios
                    $data = $controller->$action($data['user_id']);
                    echo json_encode(['status' => 'success', 'message' => 'Cantidad de articulos en el carrito añadida correctamente', 'datos' => $data]);
                    exit();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al mostrar la cantidad de articulos en el carrito ']);
                    exit();
                }
                break;
                case 'checkout':
                
                    if (isset($data['user_id'])) {
                        // Llamar a checkout con los datos necesarios
                        $data = $controller->$action($data['user_id']);
                        echo json_encode(['status' => 'success', 'message' => 'Checkout realizado correctamente', 'datos' => $data]);
                        exit();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al realizar el checkout ']);
                        exit();
                    }
                    break;
            // Aquí podrías añadir otros casos según las acciones que necesites
            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
                exit();
                break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida: ' . $action]);
        exit();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos válidos']);
    exit();
}