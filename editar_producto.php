<?php
include 'conexion.php';
include "functions.php";
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header('Location: login.php');
    exit();
}

$nombre = $descripcion = $precio = $imagen = '';
$publicado = 0;  // Campo para verificar si el producto está publicado

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del producto desde la tabla juegos_de_mesa
    $stmt = $conn->prepare("SELECT * FROM juegos_de_mesa WHERE id_juego = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $nombre = $producto['nombre'];
        $descripcion = $producto['descripcion'];
        $precio = $producto['precio'];
        $publicado = $producto['publicado'];

        // Obtener la imagen desde la tabla productos
        $stmt_imagen = $conn->prepare("SELECT imagen FROM productos WHERE id_juego = ?");
        $stmt_imagen->execute([$id]);
        $producto_imagen = $stmt_imagen->fetch(PDO::FETCH_ASSOC);

        // Si hay una imagen asociada al producto
        if ($producto_imagen && !empty($producto_imagen['imagen'])) {
            $imagen = $producto_imagen['imagen'];
        } else {
            $imagen = 'default.jpg';
        }
    } else {
        echo "Producto no encontrado.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
    
        // Procesar la imagen, si se ha subido una nueva
        if ($_FILES['imagen']['name']) {
            // Obtener el nombre original de la imagen y su extensión
            $imagen_nombre = $_FILES['imagen']['name'];
            $imagen_tmp = $_FILES['imagen']['tmp_name'];

            // Generar un nombre único para la imagen usando el tiempo actual y el nombre original
            $imagen_nombre_unico = time() . '_' . $imagen_nombre;
            $imagen_destino = 'imagenes/' . $imagen_nombre_unico;

            // Mover la imagen a la carpeta de destino con el nombre único
            move_uploaded_file($imagen_tmp, $imagen_destino);

            // Actualizar la variable $imagen con el nuevo nombre de la imagen
            $imagen = $imagen_nombre_unico;
        }
    
        // Actualizar la tabla juegos_de_mesa
        $stmt_update_juego = $conn->prepare("UPDATE juegos_de_mesa SET nombre = ?, descripcion = ?, precio = ?, publicado = ? WHERE id_juego = ?");
        $stmt_update_juego->execute([$nombre, $descripcion, $precio, $publicado, $id]);
    
        // Actualizar la tabla productos, independientemente del estado de publicación
        $stmt_update_producto = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ? WHERE id_juego = ?");
        $stmt_update_producto->execute([$nombre, $descripcion, $precio, $imagen, $id]);
    
        header('Location: lista_producto.php');
        exit();
    }
} else {
    header('Location: lista_producto.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<header> 
    <div class="logo">Sistema TinkunaGames</div>
    <div class="user-info">
        <span>Bolivia, <?php echo fechaC(); ?> | 
            <?php echo $_SESSION['rol_id'] == 1 ? 'ADMIN' : 'USUARIO'; ?>
            - <?php echo $_SESSION['nombre']; ?> - <?php echo $_SESSION['correo']; ?>
        </span>
        <img src="assets/img/user.png" alt="User Icon" class="user-icon">
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Logout"></a>
    </div>
</header>

<?php include 'nav.php'; ?>

<section id="container">
    <div class="form_register">
        <h1><i class="far fa-edit"></i> Actualizar producto</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Producto" value="<?php echo htmlspecialchars($nombre); ?>">

            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del Producto" value="<?php echo htmlspecialchars($descripcion); ?>">

            <label for="precio">Precio</label>
            <input type="text" name="precio" id="precio" placeholder="Precio" value="<?php echo htmlspecialchars($precio); ?>">

            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen">
            <p>Imagen actual: <img src="<?php echo 'imagenes/' . htmlspecialchars($imagen); ?>" alt="Imagen del producto" width="100"></p> <!-- Mostrar la imagen actual -->

            <button type="submit" class="btn_save"> <i class="far fa-edit"></i> Actualizar Producto</button>
        </form>

        <!-- Botón para publicar el producto, si no está publicado -->
        <?php if ($publicado == 0): ?>
            <form action="publicar_cliente_producto.php" method="post" style="display:inline;">
                <input type="hidden" name="id_juego" value="<?php echo $id; ?>">
                <button type="submit" class="btn_publish">Publicar</button>
            </form>
        <?php else: ?>
            <p>Este producto ya está publicado.</p>
        <?php endif; ?>
    </div>
</section>
</body>
</html>
