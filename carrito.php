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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
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
                        <svg class="bi bi-cart3" width="2em" height="2em" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5z"/>
                        </svg></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container-carrito">
            <h2>Carrito de Compras</h2>
            <form id="procesar-pago" action="conf_paipay.php?total=<?php echo number_format($totalCarrito, 2, '.', ''); ?>" method="POST">
                <div id="carrito" class="contenido">
                    <table class="tabla" id="lista-compra">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Sub Total</th>
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
                        <tfoot>
                            <tr>
                                <th colspan="3" scope="col">TOTAL:</th>
                                <th><?php echo number_format($totalCarrito, 2); ?> Bs</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="botones-envio">
                    <a href="productos.php" class="button" id="volver">Seguir comprando</a>
                    <input type="submit" class="button" id="procesar-compra" value="Realizar compra">
                </div>
            </form>
        </div>
    </main>

    <footer class="footer-section">
        <div class="copyright-area">
            <div class="container-footer">
                <p style="color: #fff">TinkunaGames &copy; 2024, todos los derechos reservados</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="assets/js/iconos.js"></script>
</body>
</html>
