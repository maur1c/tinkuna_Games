<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario
    $nombre_empresa = $_POST['nombre_empresa'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nit_empresa = $_POST['nit_empresa'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $nit_ci_cliente = $_POST['nit_ci_cliente'];
    $fecha_emision = $_POST['fecha_emision'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $cantidad = (int)$_POST['cantidad'];
    $precio_unitario = (float)$_POST['precio_unitario'];
    $subtotal = $cantidad * $precio_unitario; // Calcular subtotal
    $leyenda = "Esta factura contribuye al desarrollo del país, su uso ilícito será sancionado de acuerdo a ley.";

    try {
        // Insertar datos en la base de datos
        $query = $conn->prepare("
            INSERT INTO facturacion (
                nombre_empresa, direccion, telefono, nit_empresa,
                nombre_cliente, nit_ci_cliente, fecha_emision,
                descripcion_producto, cantidad, precio_unitario, subtotal, leyenda
            ) VALUES (
                :nombre_empresa, :direccion, :telefono, :nit_empresa,
                :nombre_cliente, :nit_ci_cliente, :fecha_emision,
                :descripcion_producto, :cantidad, :precio_unitario, :subtotal, :leyenda
            )
        ");

        $query->execute([
            ':nombre_empresa' => $nombre_empresa,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':nit_empresa' => $nit_empresa,
            ':nombre_cliente' => $nombre_cliente,
            ':nit_ci_cliente' => $nit_ci_cliente,
            ':fecha_emision' => $fecha_emision,
            ':descripcion_producto' => $descripcion_producto,
            ':cantidad' => $cantidad,
            ':precio_unitario' => $precio_unitario,
            ':subtotal' => $subtotal,
            ':leyenda' => $leyenda
        ]);

        // Redirigir a la lista de facturas
        header("Location: lista_facturas.php");
        exit();

    } catch (PDOException $e) {
        // Mostrar error si ocurre
        echo "Error al guardar la factura: " . $e->getMessage();
    }
} else {
    // Mostrar mensaje si no se accede mediante POST
    echo "Acceso no válido.";
}
?>
