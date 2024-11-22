<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está logueado
if (isset($_SESSION['usuario'])) { // Si ESTA LOGUeado
    header('Location: dashboard.php'); // Redirige al dashboard
    exit(); // Termina la ejecución del script
} else {
    header('Location: usuarios/login.php'); // Si no está logueado, redirige al login
    exit(); // Termina la ejecución del script
}
?>
