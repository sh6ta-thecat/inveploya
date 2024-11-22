<?php
session_start(); // Inicia la sesión para acceder a variables de sesión

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) { // Si no hay una variable de sesión 'usuario'
    header('Location: usuarios/login.php'); // Redirige al login
    exit(); // Termina la ejecución del script
}
?>
