<?php
// Verificar si la sesión no está iniciada, si es así, iniciarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Iniciar la sesión
}
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

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

<!-- overlay_carrito.php -->
<div id="overlay-bg" class="overlay-bg hidden"></div> <!-- Capa de fondo oscurecido -->

<div id="carrito-overlay" class="overlay-carrito hidden"> <!-- Añadimos 'hidden' aquí para ocultarlo al inicio -->
    <div class="overlay-contenido">
        <!-- Botón de cierre -->
        <button id="cerrar-overlay" class="cerrar-overlay">&times;</button>

        <!-- Título -->
        <h2>Carrito de Compras</h2>

        <!-- Lista de productos (se genera dinámicamente con PHP) -->
        <div id="carrito-productos" class="carrito-productos">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                            <td><?php echo number_format($item['precio'], 2); ?> Bs</td>
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
            <a href="carrito.php" class="button" id="Ver Carrito">Ver Carrito</a>
            <form action="conf_paipay.php?total=<?php echo number_format($totalCarrito, 2, '.', ''); ?>" method="POST">
                <input type="submit" class="button-procesar" value="Realizar compra">
            </form>
        </div>
    </div>
</div>

<script src="assets/js/carrito.js" defer></script>
