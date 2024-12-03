<?php
session_start();
include 'conexion.php';
include 'functions.php'; 

// Verificar si se recibe un ID
if (!isset($_GET['id'])) {
    die("Error: ID de factura no especificado.");
}

$id = $_GET['id'];

// Obtener los datos de la factura
$query = $conn->prepare("SELECT * FROM facturacion WHERE id = :id");
$query->execute([':id' => $id]);
$factura = $query->fetch(PDO::FETCH_ASSOC);

if (!$factura) {
    die("Error: Factura no encontrada.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/ver_factura.css">
    <title>Ver Factura</title>
</head>
<body>

<header>
    <div class="logo">Sistema TinkunaGames</div>
    <div class="user-info">
        <span>Bolivia, <?php echo date('Y-m-d'); ?> | 
            <?php 
            // Mostrar el rol del usuario
            if ($_SESSION['rol_id'] == 1) {
                echo 'ADMIN';
            } elseif ($_SESSION['rol_id'] == 2) {
                echo 'VENDEDOR';
            } else {
                echo 'USUARIO';
            }
            ?>
            - <?php echo $_SESSION['nombre']; ?> - <?php echo $_SESSION['correo']; ?>
        </span>
        <img src="assets/img/user.png" alt="User Icon" class="user-icon">
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Salir"></a>
    </div>
</header>

<!-- Incluir el archivo nav.php para la navegación -->
<?php include 'nav.php'; ?>

<section id="container">
    <div class="title_page">
        <h1><i class="fas fa-file-invoice"></i> Factura</h1>
    </div>
    
    <div class="datos_factura">
        <h2><?php echo $factura['nombre_empresa']; ?></h2>
        <p>Dirección: <?php echo $factura['direccion']; ?></p>
        <p>Teléfono: <?php echo $factura['telefono']; ?></p>
        <p>Cliente: <?php echo $factura['nombre_cliente']; ?> (NIT/CI: <?php echo $factura['nit_ci_cliente']; ?>)</p>
        <p>Fecha de Emisión: <?php echo $factura['fecha_emision']; ?></p>
        <p>Producto: <?php echo $factura['descripcion_producto']; ?></p>
        <p>Cantidad: <?php echo $factura['cantidad']; ?></p>
        <p>Subtotal: S/. <?php echo number_format($factura['subtotal'], 2); ?></p>
    </div>

    <a href="generar_factura.php?id=<?php echo $factura['id']; ?>" class="btn btn_download">Descargar PDF</a>
</section>

<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
