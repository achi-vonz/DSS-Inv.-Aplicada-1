<?php
// Incluir la conexión a la base de datos y el controlador
require_once ROOT . '/config/database.php';
require_once ROOT . '/controllers/UsuarioController.php';

$conexion = require ROOT . '/config/database.php';
$controlador = new UsuarioController($conexion);

// Obtener el método HTTP y la ruta
$metodo = $_SERVER['REQUEST_METHOD'];
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$buscarId = explode('/', $path);
$id = ($path !== '/') ? end($buscarId) : null;

// Manejar las rutas RESTful
switch ($path) {
    case '/registro':
        if ($metodo === 'POST') {
            $controlador->registrar();
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    case '/login':
        if ($metodo === 'POST') {
            $controlador->login();
        } else {
            echo json_encode(['error' => 'Método no permitido']);
        }
        break;

    default:
        switch ($metodo) {
            case 'GET':
                $controlador->consultar($id); // Requiere autenticación
                break;
            case 'POST':
                $controlador->insertar(); // No requiere autenticación
                break;
            case 'PUT':
                $controlador->actualizar($id); // Requiere autenticación
                break;
            case 'DELETE':
                $controlador->borrar($id); // Requiere autenticación
                break;
            default:
                echo json_encode(['error' => 'Método no permitido']);
                break;
        }
}