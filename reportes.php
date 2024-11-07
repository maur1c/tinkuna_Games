<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] != 1) { 
    header('Location: login.php');
    exit();
}

// Obtener todos los pedidos
$stmt = $conn->query("SELECT p.id, p.total, u.nombre, p.fecha 
                      FROM pedidos p 
                      JOIN usuarios u ON p.usuario_id = u.id");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Ventas</title>
</head>
<body>
    <h1>Reportes de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?php echo $pedido['id']; ?></td>
                <td><?php echo $pedido['nombre']; ?></td>
                <td><?php echo $pedido['total']; ?> Bs</td>
                <td><?php echo $pedido['fecha']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
