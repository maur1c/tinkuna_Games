<?php 
session_start();
if ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2) {
    header("Location: login.php");
    exit;
}

include "conexion.php";

if (!empty($_POST)) {
    $alert = '';
    
    // Validación de campos vacíos
    if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        // Variables para la consulta
        $proveedor = $_POST['proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $usuario_id = $_SESSION['rol_id'];  // Corrección realizada aquí
        
        try {
            // Consulta con PDO
            $query_insert = $conn->prepare("INSERT INTO proveedor (proveedor, contacto, telefono, direccion, usuario_id)
                                            VALUES (:proveedor, :contacto, :telefono, :direccion, :usuario_id)");
            $query_insert->bindParam(':proveedor', $proveedor);
            $query_insert->bindParam(':contacto', $contacto);
            $query_insert->bindParam(':telefono', $telefono);
            $query_insert->bindParam(':direccion', $direccion);
            $query_insert->bindParam(':usuario_id', $usuario_id);

            if ($query_insert->execute()) {
                $alert = '<p class="msg_save">Proveedor guardado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al guardar el Proveedor.</p>';
            }
        } catch (PDOException $e) {
            $alert = '<p class="msg_error">Error: ' . $e->getMessage() . '</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Registro Proveedor</title>
</head>
<body>
<header> 
    <div class="logo">Sistema TinkunaGames</div>
    
    <div class="user-info">
        <span>Bolivia, <?php echo date('Y-m-d'); ?> | 
            <?php 
            // Mostrar el rol basado en el rol_id
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
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Logout"></a>
    </div>
</header>

<!-- Incluir el archivo nav.php -->
<?php include 'nav.php'; ?>

<section id="container">
    <div class="form_register">
        <h1><i class="far fa-building"></i> Registro Proveedor</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
            <label for="proveedor">Proveedor</label>
            <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor">
            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto">
            <label for="telefono">Telefono</label>
            <input type="number" name="telefono" id="telefono" placeholder="Telefono">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion completa">
            <button type="submit" class="btn_save"> <i class="far fa-save"></i> Guardar Proveedor</button>
        </form>
    </div>
</section>

<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>

</body>
</html>
