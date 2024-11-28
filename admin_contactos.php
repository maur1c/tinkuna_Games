<?php
include 'conexion.php';
session_start();

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) { // Suponiendo que el ID del rol 'admin' es 1
    header('Location: login.php');
    exit();
}

// Obtener todos los mensajes de contacto
$stmt = $conn->query("SELECT * FROM contactos");
$contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto</title>
</head>
<body>
    <h1>Mensajes de Contacto</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contactos as $contacto): ?>
            <tr>
                <td><?php echo $contacto['id']; ?></td>
                <td><?php echo $contacto['nombre']; ?></td>
                <td><?php echo $contacto['email']; ?></td>
                <td><?php echo $contacto['asunto']; ?></td>
                <td><?php echo $contacto['mensaje']; ?></td>
                <td><?php echo $contacto['fecha']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
