<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) { // Suponiendo que el ID del rol 'admin' es 1
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el producto de la base de datos
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);

    echo "Producto eliminado con éxito";
    header('Location: admin_productos.php');
    exit();
}
?>
