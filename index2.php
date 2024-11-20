<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mockup Tinkuna Games</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">

    <style>
        /* Estilos personalizados */
        .banner {
            position: relative;
            background-image: url(../imag/Ark Nova.jpg); /* Ruta a la imagen de fondo */
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Efecto de superposición */
        }
        .banner-content {
            position: relative;
            z-index: 2;
        }
        .banner h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .banner p {
            font-size: 1.2rem;
            margin-top: 15px;
        }
        .banner-buttons a {
            margin: 10px;
        }

        /* Botones grandes con fondo */
        .large-buttons {
            margin: 50px 0;
            display: flex;
            gap: 20px;
            justify-content: center;
        }
        .large-button {
            position: relative;
            width: 300px;
            height: 200px;
            text-align: center;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .large-button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }
        .large-button::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Oscurecimiento */
            z-index: 1;
        }
        .large-button span {
            position: relative;
            z-index: 2;
            font-size: 1.5rem;
        }

        /* Fondos específicos para cada botón */
        .btn-juegos {
            background-image: url('juegos.jpg'); /* Ruta a imagen de Juegos de Mesa */
        }
        .btn-accesorios {
            background-image: url(../imag/logo2.jpeg); /* Ruta a imagen de Accesorios */
        }
        .btn-eventos {
            background-image: url('eventos.jpg'); /* Ruta a imagen de Eventos */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Tinkuna Games</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner -->
    <div class="banner">
        <div class="banner-overlay"></div>
        <div class="banner-content">
            <p class="text-uppercase">Juego de Mesa, Estrategia</p>
            <h1>CATAN PARA INICIANTES</h1>
            <p>Una guía completa para nuevos jugadores de Catan. Aprende las reglas básicas, estrategias iniciales y consejos útiles para comenzar tu aventura en la isla de Catan.</p>
            <div class="banner-buttons">
                <a href="#" class="btn btn-primary">Descubre Más</a>
                <a href="#" class="btn btn-outline-light">Comprar Ahora</a>
            </div>
        </div>
    </div>

    <!-- Botones grandes -->
    <div class="large-buttons">
        <a href="#" class="large-button btn-juegos">
            <span>Juegos de Mesa</span>
        </a>
        <a href="#" class="large-button btn-accesorios">
            <span>Accesorios</span>
        </a>
        <a href="#" class="large-button btn-eventos">
            <span>Eventos</span>
        </a>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container my-5">
 
  <!-- Botones de filtros -->
  <div class="text-center mb-4">
    <div class="btn-group" role="group" aria-label="Filtros de Productos">
      <button type="button" class="btn btn-outline-primary active">Todos</button>
      <button type="button" class="btn btn-outline-primary">Juegos de Mesa</button>
      <button type="button" class="btn btn-outline-primary">Juegos de Cartas</button>
      <button type="button" class="btn btn-outline-primary">Estrategia</button>
      <button type="button" class="btn btn-outline-primary">Gestión de Recursos</button>
      <button type="button" class="btn btn-outline-primary">Temáticos</button>
    </div>
  </div>

  <!-- Tarjetas de productos -->
  <div class="row">
    <!-- Tarjeta 1 -->
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="card">
        <img src="assets\imag\imagesCATAN.jpeg" class="card-img-top" alt="Catan">
        <div class="card-body text-center">
          <h5 class="card-title">CATAN</h5>
          <p class="card-text">
            <span class="badge bg-warning text-dark">Juego de Mesa, Estrategia</span><br>
            Lorem ipsum dolor sit amet.
          </p>
        </div>
      </div>
    </div>
    <!-- Tarjeta 2 -->
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="card">
        <img src="assets\imag\zombicide.jpg" class="card-img-top" alt="zombicide">
        <div class="card-body text-center">
          <h5 class="card-title">zombicide</h5>
          <p class="card-text">
            <span class="badge bg-warning text-dark">Juego de Mesa</span><br>
            Lorem ipsum dolor sit amet.
          </p>
        </div>
      </div>
    </div>
    <!-- Tarjetas adicionales aquí -->
  </div>

  <!-- Botón de navegación -->
  <div class="text-center mt-4">
    <button class="btn btn-primary btn-lg">Todos los Juegos</button>
  </div>
 </div>
 <section class="buscar-juego">
  <!-- Navegador de búsqueda -->
  <div class="container-fluid bg-orange py-4">
    <div class="container">
      <h2 class="text-white text-uppercase text-center mb-4">Buscar Juego</h2>
      <form class="row g-3">
        <div class="col-md-3">
          <input type="text" class="form-control" placeholder="Palabras Claves">
        </div>
        <div class="col-md-2">
          <select class="form-select">
            <option selected>Plataforma</option>
            <option value="1">PC</option>
            <option value="2">Consola</option>
            <option value="3">Tablero</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="form-select">
            <option selected>Género</option>
            <option value="1">Estrategia</option>
            <option value="2">Acción</option>
            <option value="3">Aventura</option>
          </select>
        </div>
        <div class="col-md-2">
          <select class="form-select">
            <option selected>Idioma</option>
            <option value="1">Español</option>
            <option value="2">Inglés</option>
            <option value="3">Otros</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-light w-100">Buscar</button>
        </div>
      </form>
    </div>
  </div>
 </section>

 <section class="banner-publicitario my-5">
  <div class="banner-container position-relative">
    <!-- Imagen de fondo -->
    <div class="banner-fondo"></div>
    <!-- Contenido sobrepuesto -->
    <div class="container position-relative text-white py-5">
      <div class="row align-items-center">
        <div class="col-md-6">
          <img src="assets\imag\zombicide.jpg" alt="Ark Nova" class="img-fluid banner-img">
        </div>
        <div class="col-md-6">
          <h3 class="text-uppercase fw-bold">Explorando <span class="text-warning">zombicide</span></h3>
          <p>Sumérgete en el fascinante mundo de zombicide, donde la estrategia y la creatividad se combinan para ofrecerte una experiencia única. Aprende a diseñar el zoológico perfecto.</p>
          <a href="#" class="btn btn-primary">Descubre más</a>
        </div>
      </div>
    </div>
  </div>
 </section>


</body>
</html>
