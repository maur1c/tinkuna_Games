<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

try {
    // Iniciar una transacción para asegurar la integridad de los datos
    $conn->beginTransaction();

    // Recuperar los artículos del carrito antes de borrarlos
    $stmt = $conn->prepare("
        SELECT c.producto_id, c.cantidad, p.precio 
        FROM carrito c
        JOIN productos p ON c.producto_id = p.id
        WHERE c.usuario_id = ?
    ");
    $stmt->execute([$usuario_id]);
    $carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($carrito)) {
        throw new Exception("El carrito está vacío.");
    }

    // Insertar cada artículo en historial_de_compra
    $stmt_historial = $conn->prepare("
        INSERT INTO historial_de_compra (usuario_id, producto_id, cantidad, precio, fecha_compra)
        VALUES (?, ?, ?, ?, NOW())
    ");

    foreach ($carrito as $item) {
        $stmt_historial->execute([
            $usuario_id,
            $item['producto_id'],
            $item['cantidad'],
            $item['precio']
        ]);
    }

    // Opcional: Insertar datos de la tarjeta en targetas_guardadas
    // Nota: Este bloque debe ser manejado con extrema seguridad
    if (isset($_SESSION['tarjeta'])) {
        $tarjeta = $_SESSION['tarjeta']; // Asegúrate de que estos datos estén encriptados
        $stmt_tarjeta = $conn->prepare("
            INSERT INTO targetas_guardadas (usuario_id, tipo_tarjeta, numero_tarjeta, fecha_expiracion, nombre_tarjeta, fecha_guardada)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt_tarjeta->execute([
            $usuario_id,
            $tarjeta['tipo'],
            password_hash($tarjeta['numero'], PASSWORD_DEFAULT), // Encriptación de ejemplo
            $tarjeta['expiracion'],
            $tarjeta['nombre']
        ]);
    }

    // Vaciar el carrito
    $stmt_delete = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    $stmt_delete->execute([$usuario_id]);

    // Confirmar la transacción
    $conn->commit();

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollBack();
    // Manejar el error apropiadamente
    die("Error al procesar la compra: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra Completada</title>
</head>
<style>
      body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #4CAF50;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
</style>
<body>
    <h1>Gracias por su compra</h1>
    <p>Su compra ha sido completada exitosamente.</p>
    <a href="carrito.php">Volver al carrito</a>
</body>
</html>
