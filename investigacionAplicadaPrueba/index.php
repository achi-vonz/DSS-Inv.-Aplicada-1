<?php
// Definir la raíz del proyecto
define('ROOT', __DIR__);

// Configurar el tipo de respuesta JSON
header("Content-Type: application/json");

// Incluir el archivo de rutas
require_once ROOT . '/routes/api.php';