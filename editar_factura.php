<?php
session_start();
include "conexion.php";
include "functions.php";

// Verificar si el formulario fue enviado
if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre_cliente']) || empty($_POST['nit_ci_cliente']) || empty($_POST['descripcion_producto']) || empty($_POST['fecha_emision']) || empty($_POST['precio_unitario']) || empty($_POST['cantidad'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $idfactura = $_POST['idfactura'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $nit_cliente = $_POST['nit_ci_cliente'];
        $descripcion = $_POST['descripcion_producto'];
        $fecha_emision = $_POST['fecha_emision'];
        $precio_unitario = $_POST['precio_unitario'];
        $cantidad = $_POST['cantidad'];
        $subtotal = $precio_unitario * $cantidad; // Calcular el subtotal

        try {
            // Actualizar datos de la factura
            $sql_update = $conn->prepare("UPDATE facturacion SET 
                nombre_cliente = :nombre_cliente, 
                nit_ci_cliente = :nit_cliente, 
                descripcion_producto = :descripcion, 
                fecha_emision = :fecha_emision,
                precio_unitario = :precio_unitario,
                cantidad = :cantidad,
                subtotal = :subtotal 
                WHERE id = :idfactura");

            $sql_update->bindParam(':nombre_cliente', $nombre_cliente);
            $sql_update->bindParam(':nit_cliente', $nit_cliente);
            $sql_update->bindParam(':descripcion', $descripcion);
            $sql_update->bindParam(':fecha_emision', $fecha_emision);
            $sql_update->bindParam(':precio_unitario', $precio_unitario, PDO::PARAM_INT);
            $sql_update->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $sql_update->bindParam(':subtotal', $subtotal, PDO::PARAM_INT);
            $sql_update->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);

            if ($sql_update->execute()) {
                $alert = '<p class="msg_save">Factura actualizada correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar la factura.</p>';
            }
        } catch (PDOException $e) {
            $alert = '<p class="msg_error">Error: ' . $e->getMessage() . '</p>';
        }
    }
}

// Mostrar datos de la factura
if (empty($_REQUEST['id'])) {
    header('Location: lista_facturas.php');
    exit;
}

$idfactura = $_REQUEST['id'];

try {
    // Consultar los datos de la factura
    $sql = $conn->prepare("SELECT * FROM facturacion WHERE id = :idfactura");
    $sql->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);
    $sql->execute();

    if ($sql->rowCount() == 0) {
        header('Location: lista_facturas.php');
        exit;
    } else {
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $nombre_cliente = $data['nombre_cliente'];
        $nit_cliente = $data['nit_ci_cliente'];
        $descripcion = $data['descripcion_producto'];
        $fecha_emision = $data['fecha_emision'];
        $precio_unitario = $data['precio_unitario'];
        $cantidad = $data['cantidad'];
        $subtotal = $data['subtotal'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Actualizar Factura</title>
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
    <div class="form_register">
        <h1><i class="far fa-edit"></i> Actualizar Factura</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
            <input type="hidden" name="idfactura" value="<?php echo $idfactura; ?>">
            <label for="nombre_cliente">Nombre Cliente</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre del Cliente" value="<?php echo $nombre_cliente; ?>">
            <label for="nit_ci_cliente">NIT/CI Cliente</label>
            <input type="text" name="nit_ci_cliente" id="nit_ci_cliente" placeholder="NIT o CI del Cliente" value="<?php echo $nit_cliente; ?>">
            <label for="descripcion_producto">Descripción Producto</label>
            <input type="text" name="descripcion_producto" id="descripcion_producto" placeholder="Descripción del Producto" value="<?php echo $descripcion; ?>">
            <label for="fecha_emision">Fecha de Emisión</label>
            <input type="date" name="fecha_emision" id="fecha_emision" value="<?php echo $fecha_emision; ?>">
            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" name="precio_unitario" id="precio_unitario" placeholder="Precio Unitario" value="<?php echo $precio_unitario; ?>" step="0.01">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" value="<?php echo $cantidad; ?>">
            <label for="subtotal">Subtotal</label>
            <input type="number" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>" readonly>

            <button type="submit" class="btn_save"> <i class="far fa-edit"></i> Actualizar Factura</button>
        </form>
    </div>
</section>
<script>
    const precioInput = document.getElementById('precio_unitario');
    const cantidadInput = document.getElementById('cantidad');
    const subtotalInput = document.getElementById('subtotal');

    precioInput.addEventListener('input', updateSubtotal);
    cantidadInput.addEventListener('input', updateSubtotal);

    function updateSubtotal() {
        const precio = parseFloat(precioInput.value) || 0;
        const cantidad = parseInt(cantidadInput.value) || 0;
        subtotalInput.value = (precio * cantidad).toFixed(2);
    }
</script>
<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
