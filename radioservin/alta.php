<?php
$host = 'localhost'; // Dirección IP del servidor de la base de datos
$port = '5432'; // Puerto de la base de datos de PostgreSQL
$dbname = 'radio'; // Nombre de la base de datos
$user = 'postgres'; // Nombre de usuario de la base de datos
$pass = 'ZXCV'; // Contraseña de la base de datos

// Realizar la conexión a la base de datos
$conexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

if (!$conexion) {
    die("Error de conexión: " . pg_last_error()); // Si no se puede conectar, mostrar un mensaje de error y salir del script
}

$nombre = $_POST['nombre']; // Obtener el nombre del formulario
$correo = $_POST['correo']; // Obtener el correo electrónico del formulario
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Encriptar la contraseña utilizando el algoritmo de hash

$query = "INSERT INTO radio (nombre_usuario, correo_electronico, contrasena) VALUES ('$nombre', '$correo', '$contrasena')";
// Crear una consulta SQL para insertar los datos en la tabla "radio"

$consulta = pg_query($conexion, $query); // Ejecutar la consulta en la base de datos

if ($consulta) {
    // Si la consulta se ejecutó con éxito, redirigir al usuario a la página de inicio
    header("Location: index.html");
    exit(); // Asegurarse de que el script se detiene después de la redirección
} else {
    echo 'Error al registrar usuario: ' . pg_last_error(); // Si hay un error en la consulta, mostrar un mensaje de error
}

pg_close($conexion); // Cerrar la conexión a la base de datos al final del script
?>