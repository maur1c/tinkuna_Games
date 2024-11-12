<?php
session_start();
if ($_SESSION['rol_id'] != 1) {
    header("location: login.php");
    exit;
}

include "conexion.php";
include "functions.php";

if (!empty($_POST)) {
    if (empty($_POST['idproducto'])) {
        header("location: lista_producto.php");
        exit;
    }

    $idproducto = $_POST['idproducto'];

    try {
        // Cambiar el estatus del producto a 0 para "eliminarlo" lógicamente
        $query_delete = $conn->prepare("UPDATE juegos_de_mesa SET estatus = 0 WHERE id_juego = :idproducto");
        $query_delete->bindParam(':idproducto', $idproducto, PDO::PARAM_INT);
        $query_delete->execute();
        
        if ($query_delete->rowCount() > 0) {
            header("location: lista_producto.php");
        } else {
            echo "Error al eliminar";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (empty($_REQUEST['id'])) {
    header("location: lista_producto.php");
    exit;
} else {
    $idproducto = $_REQUEST['id'];

    try {
        $query = $conn->prepare("SELECT * FROM juegos_de_mesa WHERE id_juego = :idproducto AND estatus = 1");
        $query->bindParam(':idproducto', $idproducto, PDO::PARAM_INT);
        $query->execute();
        
        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $producto = $data['nombre'];
        } else {
            header("location: lista_producto.php");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Eliminar Producto</title>
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

<!-- Incluir el archivo nav.php -->
<?php include 'nav.php'; ?>

<section id="container">
    <div class="data_delete">
        <i class="fas fa-gamepad fa-7x" style="color:#e66262"></i>
        <br><br>
        <h2>¿Está seguro de eliminar el siguiente producto?</h2>
        <p>Nombre del Producto: <span><?php echo htmlspecialchars($producto); ?></span></p>

        <form method="post" action="">
            <input type="hidden" name="idproducto" value="<?php echo htmlspecialchars($idproducto); ?>">
            <a href="lista_producto.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
            <button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
        </form>
    </div>
</section>

<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>

</body>
</html>
