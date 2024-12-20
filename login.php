<?php
include 'conexion.php'; // Conexión a la base de datos
include 'functions.php';
session_start(); // Iniciar la sesión

$alert = ''; // Variable para almacenar alertas o errores

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Verificar si el usuario existe en la base de datos
    $stmt = $conn->prepare("
        SELECT u.*, r.nombre_rol 
        FROM usuarios u
        INNER JOIN roles r ON u.rol_id = r.id
        WHERE u.email = ?
    ");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si la contraseña es correcta
    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        // Guardar información del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario['id']; // Guardar el ID del usuario
        $_SESSION['nombre'] = $usuario['nombre']; // Guardar el nombre del usuario
        $_SESSION['rol_id'] = $usuario['rol_id']; // Guardar el ID del rol
        $_SESSION['correo'] = $usuario['email'];  // Guardar el correo del usuario

        // Redirigir según el rol usando el ID del rol
        if ($usuario['rol_id'] == 1) { // Supongamos que el ID del rol 'admin' es 1
            header('Location: admin_dashboard.php'); // Redirigir al panel de admin
        } elseif ($usuario['rol_id'] == 2) { // Supongamos que el ID del rol 'vendedor' es 2
            header('Location: vendedor_dashboard.php'); // Redirigir al panel de vendedor
        } else {
            header('Location: index.php'); // Redirigir a la página de productos para clientes
        }
        exit();
    } else {
        $alert = "Correo o contraseña incorrectos"; // Mostrar el error si no coincide
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema TinkunaGames</title>
     <!-- Link de FontAwesome para el ícono de casita -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<body>
      <!-- Botón en la esquina superior derecha en forma de casita -->
      <div style="position: fixed; top: 20px; right: 20px;">
        <a href="index.php" style="text-decoration: none; color: white;">
            <i class="fas fa-home" style="font-size: 30px; color: #fff; background-color: #000000; padding: 10px; border-radius: 50%;"></i>
        </a>
    </div>
    <section id="container">
        <form action="login.php" method="POST">
            <h3>Iniciar Sesión</h3>
            <img src="assets/img/login.png" alt="Login">
            
            <!-- Campo para el email -->
            <input type="email" name="email" placeholder="Email" required>
            
            <!-- Campo para la contraseña -->
            <input type="password" name="contraseña" placeholder="Contraseña" required>

            <!-- Mensaje de error si hay alguno -->
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <!-- Botón de submit -->
            <input type="submit" value="INGRESAR">
        </form>
    </section>
</body>
</html>
