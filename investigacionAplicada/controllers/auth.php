<?php
session_start();

function verificarAutenticacion() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
        header("Location: login.php");
        exit();
    }
}
?>
