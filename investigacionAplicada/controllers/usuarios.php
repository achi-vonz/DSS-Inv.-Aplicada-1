<?php
require_once '../config/database.php';

header('Content-Type: application/json');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    insertar($conexion);
} elseif ($metodo === 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    consultar($conexion, $id);
}

function consultar($conexion, $id) {
    $sql = ($id === null) ? "SELECT * FROM usuarios" : "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    if ($id !== null) {
        $stmt->bind_param('i', $id);
    }
    $stmt->execute();
    $resultado = $stmt->get_result();
    $datos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }
    echo json_encode($datos);
}

function insertar($conexion) {
    $dato = json_decode(file_get_contents('php://input'), true);
    $nombre = $dato['nombre'] ?? '';
    $email = $dato['email'] ?? '';
    $password = $dato['password'] ?? '';
    $telefono = $dato['telefono'] ?? '';

    if (empty($nombre) || empty($email) || empty($password) || empty($telefono)) {
        echo json_encode(['error' => 'Todos los campos son obligatorios']);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password, telefono) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $nombre, $email, $passwordHash, $telefono);
    
    if ($stmt->execute()) {
        echo json_encode(['mensaje' => 'Registro exitoso']);
    } else {
        echo json_encode(['error' => 'Error al registrar usuario']);
    }
}
