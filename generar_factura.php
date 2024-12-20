<?php
require('libreria_pdf/fpdf.php');
include 'conexion.php';

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

// Crear el PDF
//$pdf = new FPDF();
//$pdf->AddPage();

// Crear el PDF con ancho estándar de hoja carta y altura reducida
$pdf = new FPDF('P', 'mm', array(210, 220)); // Ancho estándar, altura a la mitad de una hoja carta
$pdf->AddPage();



// Encabezado
$pdf->Image('assets/imag/logo2.jpeg', 10, 10, 30); // Reemplaza con la ruta a tu logo
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, mb_convert_encoding($factura['nombre_empresa'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, mb_convert_encoding($factura['direccion'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell(0, 10, 'Telefono: ' . $factura['telefono'], 0, 1, 'C');
$pdf->Cell(0, 10, 'NIT: ' . $factura['nit_empresa'], 0, 1, 'C');
$pdf->Ln(5);

// Datos del cliente
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Cliente:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nombre: ' . mb_convert_encoding($factura['nombre_cliente'], 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 10, 'NIT/CI: ' . $factura['nit_ci_cliente'], 0, 1);
$pdf->Cell(0, 10, 'Fecha de Emision: ' . $factura['fecha_emision'], 0, 1);
$pdf->Ln(5);

// Detalles del producto (tabla)
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255); // Color de fondo de la cabecera
$pdf->Cell(80, 10, 'Descripcion', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Precio Unitario', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Subtotal', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(80, 10, mb_convert_encoding($factura['descripcion_producto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
$pdf->Cell(30, 10, $factura['cantidad'], 1, 0, 'C');
$pdf->Cell(40, 10, 'Bs/. ' . number_format($factura['precio_unitario'], 2), 1, 0, 'R');
$pdf->Cell(40, 10, 'Bs/. ' . number_format($factura['subtotal'], 2), 1, 1, 'R');

// Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, 'Total:', 1, 0, 'R');
$pdf->Cell(40, 10, 'Bs/. ' . number_format($factura['subtotal'], 2), 1, 1, 'R');

// Leyenda
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->MultiCell(0, 10, mb_convert_encoding($factura['leyenda'], 'ISO-8859-1', 'UTF-8'), 0, 'C');

// Salida del PDF
$pdf->Output('D', 'Factura_' . $factura['id'] . '.pdf');
?>
