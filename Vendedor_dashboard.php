<?php
session_start();
include 'functions.php'; // Incluir el archivo con la función de fecha

// Verificar si el usuario tiene el rol de "vendedor" (rol_id = 2)
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header(header: 'Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/admin.css"> <!-- Enlace a CSS -->
    <title>Panel de Vendedor</title>
</head>
<body>
<header> 
    <div class="logo">Sistema TinkunaGames</div>
    
    <div class="user-info">
        <span>Bolivia, <?php echo fechaC(); ?> | 
            <?php 
            // Mostrar el rol basado en el rol_id
            if ($_SESSION['rol_id'] == 1) {
                echo 'ADMIN';
            } elseif ($_SESSION['rol_id'] == 2) {
                echo 'VENDEDOR';
            } else {
                echo 'USUARIO'; // O cualquier otro rol que tengas
            }
            ?>
            - <?php echo $_SESSION['nombre']; ?> - <?php echo $_SESSION['correo']; ?>
        </span>
        <img src="assets/img/user.png" alt="User Icon" class="user-icon">
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Logout"></a>
    </div>
</header>


    <!-- Incluir el archivo nav.php para el menú de navegación -->
    <?php include 'nav.php'; ?>

    <section id="container">
        <h1>Bienvenido al sistema</h1>
    </section>
    
    <main>
        <h2>Estadísticas</h2>
        <div class="stats">
            <p>Total de Usuarios: <?php // echo $total_usuarios; ?></p>
            <p>Total de Productos: <?php // echo $total_productos; ?></p>
        </div>
    </main>
</body>
</html>
<!-- termina el codigo vendedor -->
