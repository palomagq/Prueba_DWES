<?php
require_once '../Controllers/ItemController.php';

// Leer el cuerpo JSON de la solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);  // Decodifica el JSON a un array asociativo

// Comprobar si la solicitud es válida
if ($data && isset($data['action'])) {
    $action = $data['action'];  // Acción a ejecutar

    // Crear una instancia del controlador
    $controller = new ItemController();
    // Llamar a la función correspondiente dependiendo de la acción
    if (method_exists($controller, $action)) {
        // Llamar a la función del controlador pasando los datos
        switch ($action) {
            case 'updateItem':
                if (isset($data['name'], $data['price'], $data['description'])) {
                    // Llamar a updateItem con los datos necesarios
                    $controller->$action($data['name'], $data['price'], $data['description']);
                    echo json_encode(['status' => 'success', 'message' => 'Articulo actualizado correctamente']);
                    exit();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Faltan datos para actualizar el articulo']);
                    exit();
                }
                break;
            case 'deleteItem':
                    if (isset($data['id'])) {
                        // Llamar a deleteItem con los datos necesarios
                        $controller->$action($data['id']);
                        echo json_encode(['status' => 'success', 'message' => 'Usuario eliminado correctamente']);
                        exit();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el usuario ']);
                        exit();
                    }
                    break;
            case 'createItem':
                
                    if (isset($data['name'], $data['price'], $data['description'])) {
                        // Llamar a createItem con los datos necesarios
                        $controller->$action($data['name'], $data['price'], $data['description']);
                        echo json_encode(['status' => 'success', 'message' => 'Articulo creado correctamente']);
                         exit();
                    } else {
                         echo json_encode(['status' => 'error', 'message' => 'Faltan datos para añadir el articulo ']);
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