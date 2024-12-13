<?php
session_start();

// Verificar roles permitidos
if ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 4) {
    header("location: ./");
    exit();
}

include "conexion.php";
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['idfactura'])) {
        header("location: lista_facturas.php");
        exit();
    }

    $idfactura = $_POST['idfactura'];

    try {
        // Eliminar físicamente la factura
        $query_delete = $conn->prepare("DELETE FROM facturacion WHERE id = :idfactura");
        $query_delete->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);

        if ($query_delete->execute()) {
            header("location: lista_facturas.php");
        } else {
            echo "Error al eliminar la factura.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif (empty($_GET['id'])) {
    header("location: lista_facturas.php");
    exit();
} else {
    $idfactura = $_GET['id'];

    try {
        // Consulta para obtener los datos de la factura sin usar `estatus`
        $query = $conn->prepare("SELECT nombre_cliente, nit_ci_cliente, descripcion_producto, subtotal 
                                 FROM facturacion 
                                 WHERE id = :idfactura");
        $query->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);
        $query->execute();
        $factura = $query->fetch(PDO::FETCH_ASSOC);

        if (!$factura) {
            header("location: lista_facturas.php");
            exit();
        }

        // Asignar valores a las variables para mostrarlos en el formulario
        $nombre_cliente = $factura['nombre_cliente'];
        $nit_cliente = $factura['nit_ci_cliente'];
        $descripcion = $factura['descripcion_producto'];
        $subtotal = $factura['subtotal'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Eliminar Factura</title>
</head>
<body>
<header> 
    <div class="logo">Sistema TinkunaGames</div>
    
    <div class="user-info">
        <span>Bolivia, <?php echo fechaC(); ?> | 
            <?php 
            if ($_SESSION['rol_id'] == 1) {
                echo 'ADMIN';
            } elseif ($_SESSION['rol_id'] == 4) {
                echo 'SUPERVISOR';
            } else {
                echo 'USUARIO';
            }
            ?>
            - <?php echo $_SESSION['nombre']; ?> - <?php echo $_SESSION['correo']; ?>
        </span>
        <img src="assets/img/user.png" alt="User Icon" class="user-icon">
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Logout"></a>
    </div>
</header>

    <?php include 'nav.php'; ?>
    <section id="container">
        <div class="data_delete">
            <i class="fas fa-file-invoice fa-7x" style="color:#e66262"></i>
            <br>
            <br>
            <h2>¿Está seguro de eliminar el siguiente registro?</h2>
            <p>Cliente: <span><?php echo htmlspecialchars($nombre_cliente); ?></span></p>
            <p>NIT/CI: <span><?php echo htmlspecialchars($nit_cliente); ?></span></p>
            <p>Producto: <span><?php echo htmlspecialchars($descripcion); ?></span></p>
            <p>Subtotal: <span><?php echo htmlspecialchars($subtotal); ?> Bs</span></p>

            <form method="post" action="">
                <input type="hidden" name="idfactura" value="<?php echo $idfactura; ?>">
                <a href="lista_facturas.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
            </form>
        </div>
    </section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
