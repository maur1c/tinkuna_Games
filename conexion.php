<?php
$host = 'localhost';
$db = 'tinkuna_games';
$user = 'root';  // Usuario por defecto de XAMPP
<<<<<<< HEAD
$password = '';  // Contraseña por defecto en XAMPP es vacía
=======
$password = 'oliver123';  // Contraseña por defecto en XAMPP es vacía
>>>>>>> 8ab0643a6ec8047642fae0b2dddd2a324a4c4ca7

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    // Establecer el modo de errores de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "¡Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

