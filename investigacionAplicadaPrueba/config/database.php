<?php
$host = "localhost";
$usuario = "root";
$password = "";
$basededatos = "investigacionaplicada";

$conexion = new mysqli($host, $usuario, $password, $basededatos);

if ($conexion->connect_error) {
    die("Conexión no establecida: " . $conexion->connect_error);
}

return $conexion;