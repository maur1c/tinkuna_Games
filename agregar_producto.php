<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) { // Suponiendo que el ID del rol 'admin' es 1
    header('Location: login.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Subir imagen
    $imagen = $_FILES['imagen']['name'];
    $ruta_imagen = 'imagenes/' . basename($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);

    // Insertar producto en la base de datos
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $precio, $imagen]);

    echo "Producto añadido con éxito";
    header('Location: lista_producto.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar Producto</h1>
        <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <input type="text" name="descripcion" placeholder="Descripción" required>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required>
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit">Agregar Producto</button>
         </form>

</body>
</html>
