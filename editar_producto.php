<?php
include 'conexion.php';
include "functions.php";
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header('Location: login.php');
    exit();
}

$nombre = $descripcion = $precio = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del producto
    $stmt = $conn->prepare("SELECT * FROM juegos_de_mesa WHERE id_juego = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $nombre = $producto['nombre'];
        $descripcion = $producto['descripcion'];
        $precio = $producto['precio'];
    } else {
        echo "Producto no encontrado.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];

        // Actualizar el producto en la base de datos
        $stmt = $conn->prepare("UPDATE juegos_de_mesa SET nombre = ?, descripcion = ?, precio = ? WHERE id_juego = ?");
        $stmt->execute([$nombre, $descripcion, $precio, $id]);

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

        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Producto" value="<?php echo htmlspecialchars($nombre); ?>">

            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del Producto" value="<?php echo htmlspecialchars($descripcion); ?>">

            <label for="precio">Precio</label>
            <input type="text" name="precio" id="precio" placeholder="Precio" value="<?php echo htmlspecialchars($precio); ?>">

            <button type="submit" class="btn_save"> <i class="far fa-edit"></i> Actualizar Producto</button>
        </form>
    </div>
</section>
</body>
</html>
