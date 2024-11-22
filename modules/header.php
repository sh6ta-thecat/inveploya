<?php
// Obtiene los datos del usuario logueado
$usuario = $_SESSION['usuario'];
$cargo = $usuario['cargo']; // Cargo del usuario: Administrador o Usuario
?>

<header>
    <h1>Bienvenido, <?php echo htmlspecialchars($usuario['nombres']); ?></h1>
    <nav>
        <ul>
            <li><a href="../dashboard.php">Inicio</a></li>
            <?php if ($cargo === 'administrador'): ?>
                <li><a href="admin/usuarios.php">Gestión de Usuarios</a></li>
                <li><a href="admin/reportes.php">Reportes</a></li>
            <?php endif; ?>
            <li><a href="productos/listar.php">Productos</a></li>
            <li><a href="inventario/index.php">Inventario</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
</header>