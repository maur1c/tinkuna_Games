<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header('Location: login.php');
    exit();
}

// Verificar que se reciban los parámetros necesarios
if (isset($_GET['id']) && isset($_GET['estado'])) {
    // Obtener el ID del producto y el nuevo estado de publicación
    $id_juego = $_GET['id'];
    $nuevo_estado = $_GET['estado'];

    // Actualizar el estado de 'publicado' en la tabla juegos_de_mesa
    $stmt_update = $conn->prepare("UPDATE juegos_de_mesa SET publicado = :nuevo_estado WHERE id_juego = :id_juego");
    $stmt_update->bindParam(':nuevo_estado', $nuevo_estado, PDO::PARAM_INT);
    $stmt_update->bindParam(':id_juego', $id_juego, PDO::PARAM_INT);
    $stmt_update->execute();

    // Redirigir de vuelta a la lista de productos
    header('Location: lista_producto.php');
    exit();
} else {
    echo "Parámetros no válidos.";
}
?>
