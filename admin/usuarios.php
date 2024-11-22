<?php
require_once '../bd/conexion.php'; // Conexión a la base de datos
session_start(); // Inicia la sesión

// Verifica si el usuario está logueado y es Administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['cargo'] !== 'administrador') {
    header('Location: ../index.php');
    exit();
}

// Función para obtener todos los usuarios
function obtenerUsuarios($conexion) {
    $query = "SELECT id, nombres, apellidos, cargo FROM usuarios";
    return $conexion->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Si se envió el formulario para agregar un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $cargo = trim($_POST['cargo']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $password = trim($_POST['password']);

    if (!empty($id) && !empty($nombres) && !empty($apellidos) && !empty($cargo) && !empty($password)) {
        try {
            // Encripta la contraseña en MD5
            $passwordHash = md5($password);

            // Inserta el nuevo usuario en la base de datos
            $query = "INSERT INTO usuarios (id, nombres, apellidos, cargo, contraseña, direccion, telefono) 
                      VALUES (:id, :nombres, :apellidos, :cargo, :password, :direccion, :telefono)";
            $stmt = $conexion->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':cargo', $cargo); // Cargo: Administrador o Usuario
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);

            $stmt->execute();
            $mensaje = "Usuario registrado exitosamente.";
        } catch (PDOException $e) {
            $mensaje = "Error al registrar el usuario: " . $e->getMessage();
        }
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}

// Obtiene la lista de usuarios
$usuarios = obtenerUsuarios($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include '../modules/header.php'; ?>
    <main>
        <h1>Gestión de Usuarios</h1>

        <!-- Mensaje de éxito o error -->
        <?php if (!empty($mensaje)): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <!-- Formulario para crear nuevo usuario -->
        <section>
            <h2>Registrar Nuevo Usuario</h2>
            <form action="" method="POST">
                <label for="id">ID:</label>
                <input type="text" name="id" id="id" required><br>

                <label for="nombres">Nombres:</label>
                <input type="text" name="nombres" id="nombres" required><br>

                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" required><br>

                <label for="cargo">Cargo:</label>
                <select name="cargo" id="cargo" required>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuario">Usuario</option>
                </select><br>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required><br>

                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion"><br>

                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono"><br>

                <button type="submit">Registrar</button>
                <button type="reset">Limpiar</button>
            </form>
        </section>

        <!-- Listado de usuarios -->
        <section>
            <h2>Usuarios Registrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cargo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombres']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['cargo']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
