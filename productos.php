<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}


// Consultar productos desde la base de datos
$query = $conn->query("SELECT * FROM productos");
$productos = $query->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los productos
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <header> <!-- Esta parte es la cabezera de la pagina seccion productos   -->
      <div class="menu logo-nav">
        <a href="index.php" class="logo">TINKUNAGAMES</a>
        <label class="menu-icon"><span class="fas fa-bars icomin"></span></label>
        <nav class="navigation">
          <ul>
            <li><a href="nosotros.php">Nosotros</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li class="search-icon">
              <input type="search" placeholder="Buscar">
              <label class="icon">
                <span class="fas fa-search"></span>
              </label>
            </li>
            <li class="car">
              <a href="carrito.php" class="bi bi-cart3"><i class="fas fa-shopping-cart"></i></a>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <main>
        <h1>Lista de Productos</h1>
        <div class="container-productos" id="lista-productos">
            <?php foreach ($productos as $producto): ?>
              <div class="card">
                <img src="imagenes/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="card-img">
                <h5><?php echo $producto['nombre']; ?></h5>
                <p>SKU: <?php echo $producto['descripcion']; ?></p>
                <p>S/.<small class="precio"><?php echo $producto['precio']; ?></small></p>

                <!-- Formulario para agregar producto al carrito -->
                <form action="carrito.php" method="POST">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                    <input type="hidden" name="cantidad" value="1"> <!-- Cantidad por defecto: 1 -->
                    <button type="submit" class="button agregar-carrito">Comprar</button>
                </form>
              </div>
            <?php endforeach; ?>
        </div>
    </main>

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
    <script src="assets/js/iconos.js"></script>

  </body>
</html>
