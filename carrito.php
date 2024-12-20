<?php
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Manejo de la adición de productos al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Insertar producto en el carrito
    $stmt = $conn->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
    $stmt->execute([$usuario_id, $producto_id, $cantidad]);

    echo "Producto añadido al carrito";
}

// Obtener el contenido del carrito
$stmt = $conn->prepare("SELECT p.nombre, p.precio, c.cantidad 
                        FROM carrito c
                        JOIN productos p ON c.producto_id = p.id
                        WHERE c.usuario_id = ?");
$stmt->execute([$usuario_id]);
$carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inicializar el total del carrito
$totalCarrito = 0;

foreach ($carrito as $item) {
    $subtotal = $item['precio'] * $item['cantidad'];
    $totalCarrito += $subtotal;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
  rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/estilos.css" rel="stylesheet" type="text/css"> <!-- CSS personalizado -->
  <link href="assets/css/estilosproductos.css">
</head>
<body>
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
    .nav {
      padding: 0; /* Elimina relleno adicional */
      margin: 0; /* Elimina márgenes adicionales */
      display: flex; /* Establece un contenedor flexible */
      justify-content: center; /* Centra elementos horizontalmente */
      align-items: center; /* Centra elementos verticalmente */
    }

    /* Estilo para el logo en la barra de navegación */
    .navbar-brand.logo {
      font-size: 1.8rem; /* Tamaño grande para destacar el logo */
      font-weight: bold; /* Texto en negrita */
      margin-right: 2rem; /* Espacio entre el logo y los enlaces */
      text-decoration: none; /* Elimina el subrayado del texto */
      color: #000; /* Color negro para el texto del logo */
    }

    /* Estilo para los elementos individuales de la lista */
    .nav-item {
      list-style: none; /* Elimina viñetas de la lista */
      margin: 0 1rem; /* Espaciado horizontal entre elementos */
    }

    /* Estilo para los enlaces dentro de la lista */
    .nav-link {
      text-decoration: none; /* Sin subrayado para los enlaces */
      color: #000; /* Texto en negro */
      font-size: 1rem; /* Tamaño estándar del texto */
      transition: color 0.3s; /* Efecto de transición para el color */
    }

    /* Cambia el color del enlace al pasar el cursor */
    .nav-link:hover {
      color: #007bff; /* Azul al pasar el cursor */
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


  /* Contenedor del Carrito (Izquierda) */
  .container-carrito {
      width: 65%; /* Ajuste de tamaño para que quepa junto al resumen */
      padding: 20px;
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }


  .container-carrito {
  max-width: 350px; /* Aumenté el max-width para que se vea más espacioso */
  margin: 0px auto;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

  /* Tabla del carrito */
  .tabla {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
  }
  /* Tabla de productos */
.tabla {
  width:200%;
  margin-bottom: 20px;
}


  .tabla th, .tabla td {
      border: 1px solid #ccc;
      padding: 100px;
      text-align: center;
  }

  .botones-envio .button, .button-procesar {
      padding: 10px 20px;
      background-color: orangered;
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      cursor: pointer;
     
  }

  .botones-envio .button:hover, .button-procesar:hover {
      background-color: green;
  }
  
</style>


<style>


  
.tabla th, .tabla td {
  padding: 20px; /* Aumenté el padding para que las celdas tengan más espacio */
  text-align: left;
}

.tabla thead th {
  background-color: #D3D3D3;
  color: black;
  font-weight: bold;
  text-transform: uppercase;
}

.tabla tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

.tabla tbody tr:hover {
  background-color: #f1f1f1;
}

.tabla tfoot th {
  text-align: right;
  background-color: #f5f5f5;
  font-weight: bold;
}

</style>




<style>

  /* Estilos generales del contenedor */
.contenedor-pagina {
    display: flex; /* Asegura que los elementos estén en línea */
    justify-content: space-between;
    gap: 0px; /* Espacio entre la tabla y el resumen */
    margin-top: 20px;
    flex-wrap: wrap; /* Permite que los elementos se ajusten si no caben */
}

/* Resumen del Pedido (Derecha) */
.subtotal-box {
    width: 100%; /* Ajuste de tamaño para que quepa junto a la tabla */
    padding: 30px;
    background-color: #D3D3D3;
    color: black;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
    top:55px; /* Para alinearlo un poco más hacia el lado derecho */
}

/* Estilo para los títulos y textos del resumen */
.subtotal-box h3 {
    font-size: 1.3em;
    margin-bottom: 10px;
    margin-top: -15px; /* Reduce el espacio arriba para acercarlo a la tabla */
    font-weight: bold;
    color: black;
    text-align: left; /* Alineación a la izquierda */
}

.subtotal-box p {
    font-size: 1em;
    margin-bottom: 10px;
    color: black;
    text-align: left; /* Alineación a la izquierda */
}

.subtotal-box h2 {
    font-size: 1.5em;
    margin-bottom: 20px;
    font-weight: bold;
    color: #000;
    text-align: left; /* Alineación a la izquierda */
}

/* Botón de finalizar pedido */
.finalizar-button {
    padding: 10px 20px;
    background-color: yellow;
    color: black;
    font-weight: bold;
    font-size: 1em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.finalizar-button:hover {
    background-color: gold;
}


/* Resumen alineado a la derecha */
.resumen {
  text-align: right;
  position: relative; /* Esto permite moverlo con left o right */
  left: -300px; /* Mueve el resumen 20px a la izquierda para acercarlo a la tabla */
}

</style>

<style>
/* Sección del total */
.total-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f8f9fa;
  padding: 20px 40px; /* Aumenté el padding para más espacio */
  border: 1px solid #ddd;
  border-radius: 25px;
  margin-bottom: 30px; /* Aumenté el margen inferior */
  gap: 200px; /* Añadí espacio entre los elementos internos */
  width: 200%; /* Hago que ocupe el ancho completo del contenedor */
}

/* Botones */
.botones-envio {
  display: flex;
  justify-content: space-evenly; /* Distribuye los botones con más espacio entre ellos */
  align-items: center;
  gap: 100px; /* Aumenté el espacio entre los botones */
  padding: 10px 0; /* Agregué un padding vertical para separarlos del contenido de arriba */
  width: 200%; /* Asegura que ocupe el ancho completo del contenedor */
}

</style>



</head>
<body>
<header>
  <nav class="navbar custom-navbar">
    <div class="container">
      <!-- Logo y menú centrados -->
      <ul class="nav justify-content-center align-items-center">
        <li class="nav-item">
          <a href="index.php" class="navbar-brand logo">TINKUNAGAMES</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="nosotros.php">Nosotros</a></li>
        <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Blog</a></li>
      </ul>
    </div>
  </nav>
  <div class="header-content text-center">
    <!-- Encabezado debajo del navbar -->
    <h1 class="header-title">TU CARRITO</h1>
    <p class="header-subtitle">Tinkuna Games</p>
  </div>
</header>


<main>
    <div class="contenedor-pagina">
        <div class="container-carrito">
            <form id="procesar-pago" action="conf_paipay.php?total=<?php echo number_format($totalCarrito, 2, '.', ''); ?>" method="POST">
                <div id="carrito" class="contenido">
                    <table class="tabla" id="lista-compra">
                        <thead>
                            <tr>
                                <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($item['precio']); ?> Bs</td>
                                <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                                <td><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?> Bs</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carrito as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($item['precio']); ?> Bs</td>
                                    <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                                    <td><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?> Bs</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Sección del Total -->
                <div class="total-section">
                    <span class="total-text">TOTAL:</span>
                    <span class="total-amount"><?php echo number_format($totalCarrito, 2); ?> Bs</span>
                </div>

                <!-- Botones de acción -->
                <div class="botones-envio">
                    <a href="productos.php" class="button" id="volver">Seguir comprando</a>
                    <input type="submit" class="button-procesar" value="Realizar compra">
                </div>
            </form>
        </div>

        <!-- Resumen alineado a la derecha -->
        <div class="resumen">
            <div class="subtotal-box">
                <h3 class="subtotal-title">Subtotal</h3>
                <p class="productos-count">(<?php echo count($carrito); ?> productos)</p>
                <h2 class="total-price"><?php echo number_format($totalCarrito, 2); ?> Bs</h2>
                <form id="procesar-pago" action="conf_paipay.php?total=<?php echo number_format($totalCarrito, 2, '.', ''); ?>" method="POST">
                    <input type="submit" class="finalizar-button" value="Finalizar Pedido">
                </form>
            </div>
        </div>
    </div>
</main>


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


    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="assets/js/iconos.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
