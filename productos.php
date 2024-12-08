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
        background-image: url('assets//imag/Products_Header.png'); /* Sustituye esta URL por la imagen que desees */
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
      justify-content: center; /* Centrar horizontalmente */
      gap:10px; /* Espacio entre los elementos */
      background-image: url('imagenes/Img_Paralax.png'); /* Aquí debes poner la URL de tu imagen */
      background-size: cover; /* Asegura que la imagen cubra todo el área */
      background-position: center; /* Centra la imagen */
      padding: 20px;
      min-height: 180px; /* Asegura que haya suficiente altura */
      text-align: center; /* Centra el texto dentro del contenedor */
    }

    .subscribe-text {
      color: white; /* Texto blanco */
      font-size: 1.3rem;
      font-weight: bold;
      flex-basis: 10%; /* Asegura que ocupe toda la línea */
    }

    .input-field {
      border: 2px solid white; /* Borde blanco */
      background-color: transparent; /* Fondo completamente transparente */
      color: white; /* Texto blanco */
      padding: 10px;
      border-radius: 5px; /* Bordes redondeados */
      font-size: 1rem;
      outline: none; /* Quitar el borde azul al enfocar */
      width: 325px; /* Ancho predeterminado */
    }

    .input-field::placeholder {
      color: white; /* Color blanco para el placeholder */
      opacity: 0.7; /* Un poco más tenue */
    }

    .subscribe-button {
      background-color: white; /* Fondo blanco */
      color: orange; /* Texto naranja */
      padding: 10px;
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
<style>
    /* Estilo general para el cuerpo de la página */
    body {
      margin: 0; /* Elimina márgenes predeterminados del navegador */
      font-family: Arial, sans-serif; /* Fuente estándar para texto */
      
    }

    /* Estilo personalizado para la barra de navegación */
 

    /* Lista de navegación con elementos centrados */
    .navbar-nav {
  padding: 0; /* Elimina relleno adicional */
  margin: auto; /* Centra horizontalmente el menú */
  display: flex; /* Hace que los elementos del menú sean flexibles */
  justify-content: center; /* Centra los elementos del menú horizontalmente */
  align-items: center; /* Centra verticalmente los elementos del menú */
}
    /* Estilo para el logo en la barra de navegación */
    .navbar-brand.logo {
      font-size: 1.8rem; /* Tamaño grande para destacar el logo */
      font-weight: bold; /* Texto en negrita */
      margin-right: 2rem; /* Espacio entre el logo y los enlaces */
      text-decoration: none; /* Elimina el subrayado del texto */
      color: white; /* Color negro para el texto del logo */
    }

    /* Estilo para los elementos individuales de la lista */
    .nav-item {
      list-style: none; /* Elimina viñetas de la lista */
      margin: 0 1rem; /* Espaciado horizontal entre elementos */
    }

    /* Estilo para los enlaces dentro de la lista */
    .nav-link {
      text-decoration: none; /* Sin subrayado para los enlaces */
      color: white; /* Texto en negro */
      font-size: 1rem; /* Tamaño estándar del texto */
      transition: color 0.3s; /* Efecto de transición para el color */
    }

    /* Cambia el color del enlace al pasar el cursor */
    .nav-link:hover {
      color: orangered; /* Azul al pasar el cursor */
    }

    /* Contenido del encabezado centrado */
    .header-content {
      margin-top: 1rem; /* Espacio superior para separarlo de la barra */
      text-align: center; /* Centra el texto horizontalmente */
    }

    /* Estilo para el título principal del encabezado */
    .header-title {
      font-size: 3.5rem; /* Tamaño grande para destacar */
      font-weight: bold; /* Texto en negrita */
      margin: 0; /* Sin margen adicional */
    }

    /* Estilo para el subtítulo del encabezado */
    .header-subtitle {
      font-size:1.2rem; /* Tamaño menor que el título */
      color: white; /* Color gris claro */
      margin-top: 0.5rem; /* Espacio entre el título y el subtítulo */
    }
  </style>
<style>

/*productos-card*/
.container-productos{
    width: 100%;
    max-width: 1000px;
    height: auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin: auto;
    background-color: #f2f2f2;
}

.container-productos .card:hover{
    transform: translateY(-15px);
    box-shadow: 0 12px 16px rgba(0,0,0,0.2);
}
.container-productos .card img{
    width: 220px;
    height: 150px;
    cursor: pointer;
}
.container-productos .card h5{
    font-weight: 600;
    padding: 5px;
}
.container-productos .card p{
    padding-top: 5px;
}
.container-productos .card a{
    padding:10px;
    display: block;
    width: 50%;
    margin: 0 auto;
}

  
.container-productos .card{
  width: 220px;
  height: 360px;
  background: white;
  color:black;
  border-radius: 8px;
  border:1px solid whitesmoke;
  box-shadow: rgba(0,0,0,0.2);
  overflow: hidden;
  margin: 20px;
  text-align: center;
  align-items: center;
  transition: all 0.25s;
}


</style>
<style>
.navbar .nav-link {
  color: white !important; /* Cambia el color de los links a blanco */
}

.navbar .logo {
  color: white !important; /* Cambia el color del logo a blanco */
}

</style>
<style>
/* Quitar el subrayado y agregar el efecto de color naranja */
.navbar .nav-link,
.navbar-brand.logo {
  text-decoration: none; /* Elimina el subrayado */
  color: white; /* Color inicial */
  transition: color 0.3s ease; /* Efecto de transición suave */
}

.navbar .nav-link:hover,
.navbar-brand.logo:hover {
  color: #ff6600 !important; /* Cambia a naranja al pasar el cursor */
  text-decoration: none; /* Asegura que no haya subrayado */
}

/* Estilo para los enlaces */
.navbar .nav-link {
  text-transform: capitalize; /* Solo la primera letra en mayúscula */
}
</style>

<style>
/* Estilo para el botón Aplicar Filtros */
button.btn.btn-primary.btn-sm.mt-3.w-100 {
  background-color: white; /* Fondo blanco */
  color: black; /* Texto negro */
  border: 1px solid black; /* Borde naranja */
  transition: all 0.3s ease-in-out; /* Efecto de transición */
}

button.btn.btn-primary.btn-sm.mt-3.w-100:hover {
  background-color: orangered; /* Fondo naranja al pasar el mouse */
  color: white; /* Texto blanco al pasar el mouse */
  border-color: #FF7F00; /* Borde ligeramente más oscuro */
}




/* Estilo base para los checkboxes */
form input[type="checkbox"] {
  appearance: none; /* Elimina el estilo predeterminado del navegador */
  width: 20px; /* Ancho del checkbox */
  height: 20px; /* Alto del checkbox */
  border:1px solid black; /* Borde naranja */
  border-radius: 3px; /* Bordes ligeramente redondeados */
  background-color: white; /* Fondo blanco por defecto */
  cursor: pointer; /* Cambia el cursor al pasar sobre el checkbox */
  display: inline-block;
  position: relative;
  transition: all 0.3s ease-in-out; /* Suaviza la transición */
}

/* Al seleccionar el checkbox */
form input[type="checkbox"]:checked {
  background-color: orangered; /* Fondo naranja */
  border-color: #FF7F00; /* Borde ligeramente más oscuro */
}

/* Estilo para la marca de verificación (✔️) */
form input[type="checkbox"]:checked::after {
  content: '✔'; /* Icono de marca */
  color: white; /* Color blanco para la marca */
  font-size: 14px; /* Tamaño de la marca */
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); /* Centra la marca dentro del checkbox */
  font-weight: bold; /* Marca más gruesa */
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
          <li class="nav-item"><a class="nav-link" href="">Blog</a></li>
        </ul>
       <!-- <form class="d-flex" method="GET" action="productos.php">
          <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar">
          <button class="btn btn-outline-success" type="submit">
            <span class="fas fa-search"></span>
          </button>
        </form>-->
        <a href="carrito.php" class="btn btn-outline-primary ms-2"><i class="fas fa-shopping-cart"></i></a>
      </div>
    </div>
  </nav>
  <div class="header-content">
    <h1 class="header-title">PRODUCTOS</h1>
    <p class="header-subtitle">Tinkuna Games</p>
  </div>
</header>

<main>
  <div class="container">
    <div class="row">
      <!-- Filtros a la derecha -->
      <div class="col-md-3">
        <div class="filter-panel">
          <h4 class="d-flex justify-content-between align-items-center">
            <span>FILTROS</span>
            <i class="fas fa-sliders-h"></i> <!-- Ícono al lado derecho -->
          </h4>
          <div class="navleft p-3 mb-3 bg-white rounded shadow-sm">
            <h5>Categorías</h5>
            <form id="category-filter-form">
              <label><input type="checkbox" name="category" value="juegos-estrategia"> Juegos de Estrategia</label><br>
              <label><input type="checkbox" name="category" value="juegos-familia"> Juegos Familiares</label><br>
              <label><input type="checkbox" name="category" value="juegos-accion"> Juegos de Cartas</label><br>
              <label><input type="checkbox" name="category" value="juegos-accion"> Juegos de Habilidad</label><br>
              <label><input type="checkbox" name="category" value="juegos-accion"> Juegos de Mesa Clásicos</label><br>
              <label><input type="checkbox" name="category" value="juegos-accion"> Juegos de Miniatura</label><br>
              <label><input type="checkbox" name="category" value="juegos-accion"> Juegos de Rol</label><br>
              <label><input type="checkbox" name="category" value="juegos-accion"> Juegos Competitivos</label><br>
            </form>
          </div>

          <div class="navleft p-3 mb-3 bg-white rounded shadow-sm">
            <h5>Precio</h5>
            <form>
              <input type="range" class="form-range" id="precioRange" min="0" max="500" step="10">
              <div>
                <span>S/ 40$</span> - <span>S/ 200$</span>
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-3 w-100">Aplicar Filtros</button>
            </form>
          </div>

          <div class="navleft p-3 mb-3 bg-white rounded shadow-sm">
            <h5>Tags</h5>
            <form id="tags-filter-form">
              <label><input type="checkbox" name="tags" value="juegos-estrategia"> Medieval</label><br>
              <label><input type="checkbox" name="tags" value="juegos-familia"> Familiar</label><br>
              <label><input type="checkbox" name="tags" value="juegos-accion"> Fantasía</label><br>
              <label><input type="checkbox" name="tags" value="juegos-accion"> Ciencia Ficción</label><br>
              <label><input type="checkbox" name="tags" value="juegos-accion"> Puzzle</label><br>
            </form>
          </div>
        </div>
      </div>

      <!-- Productos -->
      <div class="col-md-9">
        <!-- Mini-navegador de filtros -->
        <div class="mini-nav">
          <select class="form-select" onchange="location = this.value;">
            <option value="productos.php?order=relevantes">Más relevantes</option>
            <option value="productos.php?order=precio_asc">Precio: Bajo a Alto</option>
            <option value="productos.php?order=precio_desc">Precio: Alto a Bajo</option>
            <option value="productos.php?order=valoracion">Mejor valorados</option>
          </select>
        </div>

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
      </div>
    </div>
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
