<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("Error: ID de factura no especificado.");
}

$id = $_GET['id'];

// Consulta para obtener los datos de la factura
$query = $conn->prepare("SELECT * FROM facturacion WHERE id = :id");
$query->execute([':id' => $id]);
$factura = $query->fetch(PDO::FETCH_ASSOC);

if (!$factura) {
    die("Error: Factura no encontrada.");
}

// Genera el contenido HTML de la factura
?>
<div style="display: flex; align-items: center; padding: 10px; font-family: Arial, sans-serif;">
    <!-- Logo de la empresa al lado izquierdo -->
    <div style="flex: 1; text-align: left;">
        <img src="assets/imag/logo2.jpeg" alt="Logo Empresa" style="width: 80px; height: auto;">
    </div>
    
    <!-- Información de la empresa al centro -->
    <div style="flex: 3s; text-align: center;">
        <h2 style="margin: 0;"><?php echo htmlspecialchars($factura['nombre_empresa']); ?></h2>
        <p style="margin: 5px 0;"><?php echo htmlspecialchars($factura['direccion']); ?></p>
        <p style="margin: 5px 0;">Teléfono: <?php echo htmlspecialchars($factura['telefono']); ?></p>
        <p style="margin: 5px 0;">NIT: <?php echo htmlspecialchars($factura['nit_empresa']); ?></p>
    </div>
</div>

<hr>

<!-- Información de la factura -->
<div style="text-align: left; font-family: Arial, sans-serif;">
    <h3>Factura #<?php echo htmlspecialchars($factura['id']); ?></h3>
    <p>Cliente: <?php echo htmlspecialchars($factura['nombre_cliente']); ?></p>
    <p>NIT/CI: <?php echo htmlspecialchars($factura['nit_ci_cliente']); ?></p>
    <p>Fecha de Emisión: <?php echo htmlspecialchars($factura['fecha_emision']); ?></p>
</div>

<hr>

<!-- Tabla de productos -->
<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="border: 1px solid #ddd; padding: 8px;">Descripción</th>
            <th style="border: 1px solid #ddd; padding: 8px;">Cantidad</th>
            <th style="border: 1px solid #ddd; padding: 8px;">Precio Unitario</th>
            <th style="border: 1px solid #ddd; padding: 8px;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($factura['descripcion_producto']); ?></td>
            <td style="border: 1px solid #ddd; padding: 8px;"><?php echo htmlspecialchars($factura['cantidad']); ?></td>
            <td style="border: 1px solid #ddd; padding: 8px;">Bs/. <?php echo number_format($factura['precio_unitario'], 2); ?></td>
            <td style="border: 1px solid #ddd; padding: 8px;">Bs/. <?php echo number_format($factura['subtotal'], 2); ?></td>
        </tr>
    </tbody>
</table>

<hr>

<!-- Total -->
<h3 style="text-align: right; font-family: Arial, sans-serif;">Total: Bs/. <?php echo number_format($factura['subtotal'], 2); ?></h3>


