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

    // Obtener los datos del producto a editar
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $imagen = $_POST['imagen'];

        // Actualizar el producto en la base de datos
        $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ? WHERE id = ?");
        $stmt->execute([$nombre, $descripcion, $precio, $imagen, $id]);

        echo "Producto actualizado con éxito";
        header('Location: admin_productos.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="editar_producto.php?id=<?php echo $producto['id']; ?>" method="POST">
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
        <input type="text" name="descripcion" value="<?php echo $producto['descripcion']; ?>" required>
        <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>
        <input type="text" name="imagen" value="<?php echo $producto['imagen']; ?>">
        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
