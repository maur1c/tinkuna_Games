<<<<<<< HEAD
<?php 
=======
<?php
>>>>>>> main
session_start();
include "conexion.php";
include "functions.php"; 

// Verificar si el formulario fue enviado
if (!empty($_POST)) {
    $alert = '';

    // Verificar que los campos requeridos no estén vacíos
<<<<<<< HEAD
    if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['categoria']) || empty($_POST['precio'])) {
=======
    if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['categoria']) || empty($_POST['precio']) || empty($_FILES['imagen']['name'])) {
>>>>>>> main
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $usuario_id = $_SESSION['usuario_id'];

<<<<<<< HEAD
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
=======
        // Subir imagen
        $imagen = $_FILES['imagen']['name'];
        $ruta_imagen = 'imagenes/' . basename($imagen);
        
        // Intentar mover la imagen al directorio adecuado
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            $alert = '<p class="msg_error">Error al cargar la imagen.</p>';
        } else {
            try {
                // Insertar el juego de mesa en la base de datos
                $stmt_insert_juego = $conn->prepare("INSERT INTO juegos_de_mesa (nombre, descripcion, categoria, precio, publicado) VALUES (:nombre, :descripcion, :categoria, :precio, :publicado)");
                $stmt_insert_juego->bindParam(':nombre', $nombre);
                $stmt_insert_juego->bindParam(':descripcion', $descripcion);
                $stmt_insert_juego->bindParam(':categoria', $categoria);
                $stmt_insert_juego->bindParam(':precio', $precio);
                $publicado = 0; // Inicialmente no publicado
                $stmt_insert_juego->bindParam(':publicado', $publicado);

                if ($stmt_insert_juego->execute()) {
                    // Obtener el id del juego de mesa recién insertado
                    $id_juego = $conn->lastInsertId();

                    // Insertar el producto en la base de datos
                    $stmt_insert_producto = $conn->prepare("INSERT INTO productos (id_juego, nombre, descripcion, precio, imagen) VALUES (:id_juego, :nombre, :descripcion, :precio, :imagen)");
                    $stmt_insert_producto->bindParam(':id_juego', $id_juego);
                    $stmt_insert_producto->bindParam(':nombre', $nombre);
                    $stmt_insert_producto->bindParam(':descripcion', $descripcion);
                    $stmt_insert_producto->bindParam(':precio', $precio);
                    $stmt_insert_producto->bindParam(':imagen', $imagen);

                    if ($stmt_insert_producto->execute()) {
                        $alert = '<p class="msg_save">Producto guardado correctamente.</p>';
                    } else {
                        $alert = '<p class="msg_error">Error al guardar el producto.</p>';
                    }
                } else {
                    $alert = '<p class="msg_error">Error al guardar el juego de mesa.</p>';
                }
            } catch (PDOException $e) {
                $alert = '<p class="msg_error">Error en la base de datos: ' . $e->getMessage() . '</p>';
            }
>>>>>>> main
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
<<<<<<< HEAD
=======

>>>>>>> main
<section id="container">
    <div class="form_register">
        <h1><i class="fas fa-dice"></i> Registro Producto</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

<<<<<<< HEAD
        <form action="" method="post">
            <label for="nombre">Nombre del Juego</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Juego de Mesa" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
            
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción del juego"><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?></textarea>
            
            <label for="categoria">Categoría</label>
            <input type="text" name="categoria" id="categoria" placeholder="Ej. Estrategia, Familiar" value="<?php echo isset($_POST['categoria']) ? $_POST['categoria'] : ''; ?>">
            
            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" placeholder="Precio en Bolivianos" step="0.01" value="<?php echo isset($_POST['precio']) ? $_POST['precio'] : ''; ?>">
=======
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre del Juego</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Juego de Mesa" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" required>
            
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción del juego" required><?php echo isset($_POST['descripcion']) ? $_POST['descripcion'] : ''; ?></textarea>
            
            <label for="categoria">Categoría</label>
            <input type="text" name="categoria" id="categoria" placeholder="Ej. Estrategia, Familiar" value="<?php echo isset($_POST['categoria']) ? $_POST['categoria'] : ''; ?>" required>
            
            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" placeholder="Precio en Bolivianos" step="0.01" value="<?php echo isset($_POST['precio']) ? $_POST['precio'] : ''; ?>" required>
            
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen" accept="image/*" required>
>>>>>>> main
            
            <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Producto</button>
        </form>
    </div>
</section>
<<<<<<< HEAD
=======

>>>>>>> main
<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> main
