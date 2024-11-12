<?php 
session_start();
include "conexion.php";
include "functions.php"; 

// Verificar si el formulario fue enviado
if (!empty($_POST)) {
    $alert = '';

    // Verificar que los campos requeridos no estén vacíos
    if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['categoria']) || empty($_POST['precio'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $usuario_id = $_SESSION['usuario_id'];

        try {
            // Insertar el juego de mesa en la base de datos
            $stmt_insert = $conn->prepare("INSERT INTO juegos_de_mesa (nombre, descripcion, categoria, precio) VALUES (:nombre, :descripcion, :categoria, :precio)");
            $stmt_insert->bindParam(':nombre', $nombre);
            $stmt_insert->bindParam(':descripcion', $descripcion);
            $stmt_insert->bindParam(':categoria', $categoria);
            $stmt_insert->bindParam(':precio', $precio);

            if ($stmt_insert->execute()) {
                $alert = '<p class="msg_save">Producto guardado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al guardar el juego de mesa.</p>';
            }
        } catch (PDOException $e) {
            $alert = '<p class="msg_error">Error en la base de datos: ' . $e->getMessage() . '</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Registro Producto</title>
</head>
<body>
<header> 
    <div class="logo">Sistema TinkunaGames</div>
    
    <div class="user-info">
        <span>Bolivia, <?php echo fechaC(); ?> | 
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
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Logout"></a>
    </div>
</header>

<?php include 'nav.php'; ?>
<section id="container">
    <div class="form_register">
        <h1><i class="fas fa-dice"></i> Registro Producto</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
            <label for="nombre">Nombre del Juego</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Juego de Mesa" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
            
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción del juego"><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?></textarea>
            
            <label for="categoria">Categoría</label>
            <input type="text" name="categoria" id="categoria" placeholder="Ej. Estrategia, Familiar" value="<?php echo isset($_POST['categoria']) ? $_POST['categoria'] : ''; ?>">
            
            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" placeholder="Precio en Bolivianos" step="0.01" value="<?php echo isset($_POST['precio']) ? $_POST['precio'] : ''; ?>">
            
            <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Producto</button>
        </form>
    </div>
</section>
<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
