<?php include 'carritoOverlay.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Overlay</title>

    
</head>
    <!-- Enlaza los estilos CSS que ya tenemos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css"> <!-- Tu archivo de estilos principal -->
    <link rel="stylesheet" href="assets/css/carrito.css"> <!-- El CSS específico del overlay -->

</head>
<body>
    <!-- Contenido de la página -->
    <div class="container">
        <h1>Prueba del Overlay del Carrito</h1>
        <!-- Botón para abrir el overlay -->
        <button id="abrir-overlay" class="btn btn-outline-primary">Abrir Carrito</button>
    </div>

    <!-- Scripts JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/carrito.js"></script> <!-- Archivo JS con la lógica del overlay -->
</body>
</html>
