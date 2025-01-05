<?php
require_once '../Controllers/UserController.php';

// Leer el cuerpo JSON de la solicitud
$input = file_get_contents('php://input');
$data = json_decode($input, true);  // Decodifica el JSON a un array asociativo

// Comprobar si la solicitud es válida
if ($data && isset($data['action'])) {
    $action = $data['action'];  // Acción a ejecutar

    // Crear una instancia del controlador
    $controller = new UserController();
    // Llamar a la función correspondiente dependiendo de la acción
    if (method_exists($controller, $action)) {
        // Llamar a la función del controlador pasando los datos
        switch ($action) {
            case 'updateClient':
                if (isset($data['name'], $data['surname'], $data['phone'], $data['email'])) {
                    // Llamar a updateClient con los datos necesarios
                    $controller->$action($data['name'], $data['surname'], $data['phone'], $data['email']);
                    echo json_encode(['status' => 'success', 'message' => 'Usuario actualizado correctamente']);
                    exit();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Faltan datos para actualizar el usuario']);
                    exit();
                }
                break;
            case 'deleteClient':
                    if (isset($data['id'])) {
                        // Llamar a deleteClient con los datos necesarios
                        $controller->$action($data['id']);
                        echo json_encode(['status' => 'success', 'message' => 'Usuario eliminado correctamente']);
                        exit();
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al eliminart el usuario ']);
                        exit();
                    }
                    break;
            case 'createUser':
                
                    if (isset($data['name'], $data['surname'], $data['phone'], $data['email'],$data['password'])) {
                        // Llamar a createUser con los datos necesarios
                        $controller->$action($data['name'], $data['surname'], $data['phone'], $data['email'],$data['password']);
                        echo json_encode(['status' => 'success', 'message' => 'Usuario creado correctamente']);
                         exit();
                    } else {
                         echo json_encode(['status' => 'error', 'message' => 'Faltan datos para añadir el usuario ']);
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