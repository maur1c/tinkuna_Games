<?php
$host = 'localhost';
$db = 'tinkuna123';
$user = 'root';  // Usuario por defecto de XAMPP
$password = '';  // Contraseña por defecto en XAMPP es vacía

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    // Establecer el modo de errores de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "¡Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

