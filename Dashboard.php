<?php
session_start(); // Iniciar la sesión
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 3) {
    // Verificar si el usuario no está autenticado o si no es cliente (rol_id = 3)
    header('Location: login.php'); // Redirigir al login si no tiene permiso
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        .dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        a {
            display: block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
    <div class="dashboard">
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="contados.php">Contactos</a>
        <a href="carrito.php">Carrito</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>

</body>
</html>
