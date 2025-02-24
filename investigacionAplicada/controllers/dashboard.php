<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$token = $_SESSION['token'];
?>

<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="../style.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido al Dashboard</h2>
    <p>Tu token de sesión es:</p>
    <textarea readonly rows="3" cols="50"><?php echo htmlspecialchars($token); ?></textarea>
    <br><br>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
