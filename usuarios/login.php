<?php
session_start(); // Inicia la sesión para manejar las variables de sesión
require_once '../bd/conexion.php'; // Incluye la conexión a la base de datos

$error = ''; // Inicializa la variable para almacenar errores

// Procesa el formulario al enviar datos mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id']); // Obtiene y limpia el valor del campo 'id'
    $password = trim($_POST['password']); // Obtiene y limpia el valor del campo 'password'

    if (!empty($id) && !empty($password)) { // Verifica que ambos campos estén completos
        try {
            // Prepara la consulta para buscar al usuario en la base de datos
            // Se utiliza MD5 en la comparación de la contraseña
            $query = "SELECT * FROM usuarios WHERE id = :id AND contraseña = :password";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id', $id); // Asigna el valor de 'id' al parámetro de la consulta
            $stmt->bindParam(':password', md5($password)); // Aplica MD5 al campo 'password' para compararlo con la base de datos
            $stmt->execute(); // Ejecuta la consulta
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC); // Obtiene el resultado como un arreglo asociativo

            if ($usuario) {
                $_SESSION['usuario'] = $usuario; // Guarda los datos del usuario en la sesión
                header('Location: ../dashboard.php'); // Redirige al dashboard
                exit(); // Termina la ejecución
            } else {
                $error = 'Usuario o contraseña incorrectos.'; // Error de autenticación
            }
        } catch (PDOException $e) {
            $error = 'Error al intentar iniciar sesión.'; // Error en la consulta
        }
    } else {
        $error = 'Por favor, completa todos los campos.'; // Error por campos vacíos
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <?php include '../modules/head.php'; ?>
    <title>Login - Sistema de Inventario</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="" method="POST">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            
            <div class="buttons">
                <button type="submit">Ingresar</button>
                <a href="registro.php"><button type="button">Registro Usuario</button></a>
                <a href="../index.php"><button type="button">Salir</button></a>
            </div>
        </form>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    </div>
</body>
</html>
