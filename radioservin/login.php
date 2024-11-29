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


$correo = $_POST['correo']; // Obtener el correo electrónico del formulario
$contrasena = $_POST['contrasena']; // Obtener la contraseña del formulario

$query = "SELECT * FROM radio WHERE correo_electronico = '$correo'";
// Crear una consulta SQL para seleccionar un usuario por su correo electrónico

$consulta = pg_query($conexion, $query); // Ejecutar la consulta en la base de datos
$usuario = pg_fetch_assoc($consulta); // Obtener los resultados de la consulta como un arreglo asociativo

if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
    // Si se encontró un usuario y la contraseña coincide con la contraseña almacenada
    
    session_start(); // Iniciar una sesión
    $_SESSION['user_id'] = $usuario['id']; // Almacenar el ID de usuario en la sesión
    header("Location: index.html"); // Redireccionar al usuario a la página principal
// } else {
//     echo 'Credenciales incorrectas'; // Si las credenciales son incorrectas, mostrar un mensaje de error
// }
} else {
    // Credenciales incorrectas, establece una variable de sesión de error
    session_start();
    $_SESSION['error_message'] = 'Credenciales incorrectas';
    header("Location: sesion.html"); // Redirige nuevamente a la página de inicio de sesión
}
pg_close($conexion); // Cerrar la conexión a la base de datos al final del script
?>
