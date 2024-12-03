<?php 
session_start();
include "conexion.php";
include "functions.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Facturación</title>
</head>
<body>

<header>
    <div class="logo">Sistema TinkunaGames</div>
    <div class="user-info">
        <span>Bolivia, <?php echo date('Y-m-d'); ?> | 
            <?php 
            if ($_SESSION['rol_id'] == 1) {
                echo 'ADMIN';
            } elseif ($_SESSION['rol_id'] == 2) {
                echo 'VENDEDOR';
            } else {
                echo 'USUARIO';
            }
            ?>
            - <?php echo $_SESSION['nombre']; ?> - <?php echo $_SESSION['correo']; ?>
        </span>
        <img src="assets/img/user.png" alt="User Icon" class="user-icon">
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Salir"></a>
    </div>
</header>

<?php include 'nav.php'; ?>

<section id="container">
    <div class="form_register">
        <h1><i class="fas fa-dice"></i> Generar Factura</h1>
        <hr>
        <div class="alert"></div>
        
        <form method="POST" action="guardar_factura.php">
            <label for="nombre_empresa">Nombre de la Empresa</label>
            <input type="text" name="nombre_empresa" id="nombre_empresa" placeholder="Ingrese el nombre de la empresa" required>

            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion" placeholder="Ingrese la dirección" required>

            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" placeholder="Ingrese el número de teléfono" required>

            <label for="nit_empresa">NIT de la Empresa</label>
            <input type="text" name="nit_empresa" id="nit_empresa" placeholder="Ingrese el NIT de la empresa" required>

            <label for="nombre_cliente">Nombre del Cliente</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Ingrese el nombre del cliente" required>

            <label for="nit_ci_cliente">NIT o CI del Cliente</label>
            <input type="text" name="nit_ci_cliente" id="nit_ci_cliente" placeholder="Ingrese el NIT o CI del cliente" required>

            <label for="fecha_emision">Fecha de Emisión</label>
            <input type="date" name="fecha_emision" id="fecha_emision" required>

            <label for="descripcion_producto">Descripción del Producto</label>
            <textarea name="descripcion_producto" id="descripcion_producto" placeholder="Describa el producto" required></textarea>

            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" placeholder="Ingrese la cantidad" min="1" required>

            <label for="precio_unitario">Precio Unitario</label>
            <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" placeholder="Ingrese el precio unitario" required>

            <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Factura</button>
        </form>
    </div>
</section>


<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
