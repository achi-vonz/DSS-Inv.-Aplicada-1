<?php
$host = "localhost"; 
$user = "root"; // Usuario de MySQL
$password = ""; 
$database = "investigacionaplicada"; 

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
