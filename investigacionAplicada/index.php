<?php
header("Location: login.php");
exit();

require_once 'config/database.php';
require_once 'controllers/usuarios.php';
require_once 'controllers/auth.php';

header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD'];
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$buscarId = explode('/', $path);
$id = ($path !== '/') ? end($buscarId) : null;

if ($path === '/login') {
    if ($metodo === 'POST') {
        loginUsuario($conexion);
    }
} elseif ($path === '/registro') {
    if ($metodo === 'POST') {
        insertar($conexion);
    }
} else {
    switch ($metodo) {
        case 'GET':
            consultar($conexion, $id);
            break;
        case 'POST':
            insertar($conexion);
            break;
        case 'PUT':
            actualizar($conexion, $id);
            break;
        case 'DELETE':
            borrar($conexion, $id);
            break;
        default:
            echo json_encode(array('mensaje' => 'Método no permitido'));
            break;
    }
}
?>
