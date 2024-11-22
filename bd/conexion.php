<?php
// Configuración de conexión a la base de datos
$host = 'localhost'; // Dirección del servidor de la base de datos
$dbname = 'sistema_inventario'; // Nombre de la base de datos
$user = 'root'; // Usuario de la base de datos
$password = ''; // Contraseña del usuario (vacía por defecto en XAMPP)

// Establecer conexión con la base de datos usando PDO
try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura PDO para que lance excepciones en caso de error
} catch (PDOException $e) {
    // Si ocurre un error, muestra un mensaje y termina la ejecución
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>
