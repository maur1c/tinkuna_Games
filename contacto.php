<?php
include 'conexion.php';

$mensajeEnviado = ''; // Variable para almacenar el mensaje de éxito

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    // Insertar el mensaje en la base de datos
    $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$nombre, $email, $asunto, $mensaje])) {
        $mensajeEnviado = "Mensaje enviado con éxito. ¡Gracias por contactarnos!";
    } else {
        $mensajeEnviado = "Error al enviar el mensaje. Intenta nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <style>
        .mensaje-exito {
            color: green;
            font-weight: bold;
            margin: 20px 0;
        }
        .mensaje-error {
            color: red;
            font-weight: bold;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="menu logo-nav">
            <a href="index.php" class="logo">TINKUNAGAMES</a>
            <label class="menu-icon"><span class="fas fa-bars icomin"></span></label>
            <nav class="navigation">
                <ul>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="productos.php">Productos</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                    <li class="car"><a href="carrito.php">
                        <svg class="bi bi-cart3" width="2em" height="2em" viewBox="0 0 16 16" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                        </svg></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
  
    <div class="container-contacto">
        <h2>CONTACTO</h2>
        <?php if ($mensajeEnviado): ?>
            <div class="mensaje-exito"><?php echo $mensajeEnviado; ?></div>
            <script>
                setTimeout(function() {
                    window.location.href = "contacto.php"; // Redirige después de 3 segundos
                }, 3000);
            </script>
        <?php endif; ?>
        <form action="contacto.php" method="POST">
            <input type="text" name="nombre" placeholder="Ingrese su Nombre" required>
            <input type="email" name="email" placeholder="Ingrese su Correo" required>
            <input type="text" name="asunto" placeholder="Asunto" required>
            <textarea name="mensaje" placeholder="Escriba su Mensaje" required></textarea>
            <input type="submit" value="ENVIAR" class="button">
        </form>
    </div>

    <footer class="footer-section">
        <div class="copyright-area">
            <div class="container-footer">
                <div class="row-footer">
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>TinkunaGames &copy; 2024, todos los derechos reservados <a href="index.php">TinkunaGames</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="https://www.facebook.com/profile.php?id=61562278854386" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook"></i> Facebook</a></li>
                                <li><a href="https://www.instagram.com/elpobladobtg/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i> Instagram</a></li>
                                <li><a href="https://www.tiktok.com/@el.poblado.by.tin" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="fab fa-tiktok"></i> TikTok</a></li>
                                <li><a href="https://wa.me/+59177958996" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>  

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/emailjs-com@2/dist/email.min.js"></script>
    <script src="assets/js/iconos.js"></script>
    <script src="assets/js/contacto.js"></script>
</body>
</html>
