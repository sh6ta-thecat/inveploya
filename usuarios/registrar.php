<?php
require_once '../bd/conexion.php'; // Incluye la conexión a la base de datos

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']);
    $nombres = trim($_POST['nombres']);
    $apellido = trim($_POST['apellido']);
    $cargo = trim($_POST['cargo']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $password = trim($_POST['password']);

    // Verifica que los campos no estén vacíos
    if (!empty($id) && !empty($nombres) && !empty($apellido) && !empty($cargo) && !empty($password)) {
        try {
            // Encripta la contraseña en MD5
            $passwordHash = md5($password);

            // Inserta el nuevo usuario en la base de datos
            $query = "INSERT INTO usuarios (id, nombres, apellido, cargo, contraseña, direccion, telefono) 
                      VALUES (:id, :nombres, :apellido, :cargo, :password, :direccion, :telefono)";
            $stmt = $conexion->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':cargo', $cargo); // Cargo: Administrador o Usuario
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);

            $stmt->execute();
            echo "Registro exitoso. <a href='login.php'>Ir al login</a>";
        } catch (PDOException $e) {
            echo "Error al registrar el usuario: " . $e->getMessage();
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="" method="POST">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" required><br>

        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" id="nombres" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required><br>

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
        <a href="login.php">Cancelar</a>
    </form>
</body>
</html>
