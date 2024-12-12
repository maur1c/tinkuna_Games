<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}

// Capturar el valor del buscador
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consultar productos desde la base de datos, solo los publicados
$query = $conn->prepare("
    SELECT p.*, j.publicado 
    FROM productos p 
    JOIN juegos_de_mesa j ON p.id_juego = j.id_juego
    WHERE j.publicado = 1 AND p.nombre LIKE :nombre
");
$query->execute([':nombre' => $buscar . '%']);
$productos = $query->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los productos filtrados
include 'carritoOverlay.php';
?>


<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="assets/css/estilosproductos.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/css/estilos.css" rel="stylesheet" type="text/css"> <!-- CSS personalizado -->
   <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
  rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    


    <style>
      /* Estilo para el header con imagen de fondo */
      header {
        position: relative;
        background-image: url('assets//imag/UI3.jpg'); /* Sustituye esta URL por la imagen que desees */
        background-size: cover;
        background-position: center;
        height: 280px; /* Puedes ajustar la altura */
        color: white;
      }

      /* Estilo para el contenido dentro del header */
      .header-content {
        position: relative;
        top: 45%;
        left: 25%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 20; /* Asegura que el texto esté encima del fondo */
      }

      .header-title {
        font-size: 4rem;
        font-weight: bold;
      }

      .header-subtitle {
        font-size: 1.5rem;
      }
.custom-navbar {
  backdrop-filter: blur(5px); /* Efecto suave */
  z-index: 10;
}


.navbar .nav-link:hover {
  color: #ff6600; /* Color anaranjado para hover */
}

/* Logo destacado */
.navbar .logo {
  color: #ff6600; /* Naranja para destacar */
  font-weight: bold;
  font-size: 1.25rem;
}
/* Botón hamburguesa */
.navbar-toggler {
  border: none; /* Sin borde */
}

.navbar-toggler-icon {
  filter: invert(1); /* Blanco para ícono */
}

/* Botón de carrito */
.btn-outline-primary {
  border-color: #ff6600;
  color: #ff6600;
}

.btn-outline-primary:hover {
  background-color: #ff6600;
  color: white;
}
.navbar .nav-link {
    color:white;
    font-size: 1rem;
    font-weight:500;
  }
    </style>





<style>
    .subscription-row {
      display: flex; /* Alinear los elementos en una fila */
      align-items: center; /* Centrar verticalmente */
      gap:150px; /* Espacio entre los elementos */
      background-color: orange; /* Fondo naranja para la fila */
      padding: 50px;
      
    }

    .subscribe-text {
      
      color: white; /* Texto blanco */
      font-size: 1.3rem;
      font-weight: bold;
    }

    .input-field {
      border: 2px solid white; /* Borde blanco */
      background-color: orange; /* Fondo naranja */
      color: white; /* Texto blanco */
      padding: 10px;
      border-radius: 5px; /* Bordes redondeados */
      font-size: 1rem;
      outline: none; /* Quitar el borde azul al enfocar */
      width: 350px; /* Ancho predeterminado */
    }

    .input-field::placeholder {
      color: white; /* Color blanco para el placeholder */
      opacity: 0.7; /* Un poco más tenue */
    }

    .subscribe-button {
      background-color: white; /* Fondo blanco */
      color: orange; /* Texto naranja */
      padding:  10px;
      border: 2px solid orange; /* Borde naranja */
      border-radius: 5px; /* Bordes redondeados */
      font-size: 1rem;
      cursor: pointer; /* Cambiar a cursor de mano */
      font-weight: bold;
    }

    .subscribe-button:hover {
      background-color: orange; /* Fondo naranja al pasar el mouse */
      color: white; /* Texto blanco */
      transition: 0.3s; /* Suavizar la transición */
    }
  </style>



  </head>
  <body>
  <header>
  <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    <div class="container-fluid">
      <a href="index.php" class="navbar-brand logo">TINKUNAGAMES</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="nosotros.php">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
          <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        </ul>
        <form class="d-flex" method="GET" action="productos.php">
          <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar">
          <button class="btn btn-outline-success" type="submit">
            <span class="fas fa-search"></span>
          </button>
        </form>
        <a href="#" id="abrir-overlay" class="btn btn-outline-primary ms-2"><i class="fas fa-shopping-cart"></i></a>
      </div>
    </div>
  </nav>
  <div class="header-content">
    <h1 class="header-title">PRODUCTOS</h1>
    <p class="header-subtitle">Tinkuna Games</p>
  </div>
</header>

    <main>
        <div class="container-productos" id="lista-productos">
            <?php if (empty($productos)): ?>
              <p>No se encontraron productos.</p>
            <?php else: ?>
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
            <?php endif; ?>
        </div>
    </main>

    <div class="subscription-row">
  <span class="subscribe-text">SUSCRIBETE</span>
  <input type="text" placeholder="Correo" class="input-field">
  <input type="text" placeholder="Nombre" class="input-field">
  <input type="text" placeholder="Apellido" class="input-field">
  <button class="subscribe-button">Suscribirse</button>
</div>
  <!-- Footer Social -->
  <footer class="footer">
    <div class="social-icons">
      <!-- Facebook -->
      <a href="https://www.facebook.com/profile.php?id=61562278854386" target="_blank" class="social-link">
        <img src="assets\imag\facebook-svgrepo-com.svg" alt="Facebook" class="icon">
        <span>Facebook</span>
      </a>
      <!-- Instagram -->
      <a href="https://www.instagram.com/elpobladobtg/" target="_blank" class="social-link">
        <img src="assets\imag\instagram-167-svgrepo-com.svg" alt="Instagram" class="icon">
        <span>Instagram</span>
      </a>
      <!-- TikTok -->
      <a href="https://www.tiktok.com/@el.poblado.by.tin" target="_blank" class="social-link">
        <img src="assets\imag\tiktok-svgrepo-com.svg" alt="TikTok" class="icon">
        <span>TikTok</span>
      </a>
    </div>
  </footer>

    <footer class="footer-container">
        <div class="container">
            <div class="row">
                <!-- Columna 1: Texto -->
                <div class="col-md-4 mb-4">
                    <h5>COLUMNA_FOOTER1</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin at turpis ut neque consequat pellentesque. 
                        Integer eget mauris vitae magna bibendum interdum non eu nunc. Sed efficitur velit a nulla blandit, sed tincidunt
                        risus dictum. Curabitur dictum magna id eros fermentum, nec ultrices lacus suscipit. Cras vulputate, sapien sed 
                        consequat.</p>

                    <!-- Listas debajo del párrafo -->
                    <div class="d-flex">
                        <!-- Lista duplicada a la izquierda -->
                        <ul class="custom-list" style="margin-right: 10px;"> <!-- Ajuste de margen -->
                            <li>Ipsum </li>
                            <li>Ipsum </li>
                            <li>Ipsum </li>
                            <li>Ipsum </li>
                        </ul>

                        <!-- Lista original a la derecha -->
                        <ul class="custom-list">
                            <li>Ipsum </li>
                            <li>Ipsum </li>
                            <li>Ipsum </li>
                            <li>Ipsum </li>
                        </ul>
                    </div>
                </div>

                <!-- Columna 2: Imágenes con títulos y texto -->
                <div class="col-md-4 mb-4">
                    <h5>COLUMNA_FOOTER2</h5>
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <img src="imagenes/Ajedrez.jpeg" alt="Juego 1" class="me-3" style="width: 115px; height: 100px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold">TOP 5 JUEGOS DE MESA PARA PRINCIPIANTES</h6>
                                <p class="mb-0">El clásico juego de estrategia para todas las edades.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <img src="imagenes/video juegos.png" alt="Juego 2" class="me-3" style="width: 115px; height: 100px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold">JUEGOS DE MESA IDEALES PARA APRENDER EN FAMILIA</h6>
                                <p class="mb-0">Explora mundos fantásticos en este emocionante juego.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-start">
                            <img src="imagenes/video juegos.png" alt="Juego 3" class="me-3" style="width: 115px; height: 100px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold">COMO ORGANIZAR UNA NOCHE DE JUEGOS INOLVIDABLE</h6>
                                <p class="mb-0">Desafía a tus amigos con este juego de habilidad.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna 3: Texto -->
                <div class="col-md-4 mb-4">
                    <h5>COLUMNA_FOOTER3</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin at turpis ut neque consequat pellentesque. 
                        Integer eget mauris vitae magna bibendum interdum non eu nunc. Sed efficitur velit a nulla blandit, sed tincidunt
                        risus dictum. Curabitur dictum magna id eros fermentum, nec ultrices lacus suscipit. Cras vulputate, sapien sed 
                        consequat.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mini Footer / Subfooter -->
<div class="footer-mini-container">
    <div class="container">
        <div>
            <h5 class="footer-mini-text">TINKUNA <span>games</span></h5>
        </div>
        <div>
            <p class="copyright">&copy; 2024 Todos los derechos reservados</p>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="assets/js/iconos.js"></script>

  </body>
</html>
