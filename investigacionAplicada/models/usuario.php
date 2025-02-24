<?php
function obtenerUsuarioPorEmail($conexion, $email) {
    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $resultado = $conexion->query($sql);
    return $resultado->fetch_assoc();
}
?>
