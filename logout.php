<?php
session_start(); // Inicia la sesión para acceder a las variables existentes
session_destroy(); // Destruye todas las variables de sesión y termina la sesión
header('Location: usuarios/login.php'); // Redirige al login
exit(); // Termina la ejecución del script
?>
