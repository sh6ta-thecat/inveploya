<?php
require_once 'modules/sesion.php'; // Verifica que el usuario esté logueado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'modules/head.php'; // Incluye el <head> compartido ?>
    <title>Dashboard - Sistema de Inventario</title>
</head>
<body>
    <?php include 'modules/header.php'; // Incluye el header compartido ?>

    <main>
        <h1>Bienvenido al Dashboard</h1>
        <p>Usuario logueado: <?php echo $_SESSION['usuario']['id']; ?></p> <!-- Muestra el ID del usuario logueado -->

        <div class="buttons">
            <a href="productos/listar.php">Ver Productos</a> <!-- Enlace al módulo de productos -->
            <a href="inventario/index.php">Ver Inventario</a> <!-- Enlace al módulo de inventario -->
            <a href="usuarios/listar.php">Gestión de Usuarios</a> <!-- Enlace al módulo de usuarios -->
            <a href="logout.php">Cerrar Sesión</a> <!-- Enlace para cerrar sesión -->
        </div>
    </main>

    <?php include 'modules/footer.php'; // Incluye el footer compartido ?>
</body>
</html>
