<?php 
session_start();
include "conexion.php";
include "functions.php"; 

// Verificar si el formulario fue enviado
if (!empty($_POST)) {
    $alert = '';

    // Verificar que los campos requeridos no estén vacíos
    if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $nit = $_POST['nit'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $usuario_id = $_SESSION['usuario_id'];

        try {
            // Si el NIT es diferente de 0, verificar si ya existe en la base de datos
            if ($nit != 0) {
                $stmt = $conn->prepare("SELECT * FROM clientes WHERE nit = :nit");
                $stmt->bindParam(':nit', $nit);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $alert = '<p class="msg_error">El número de NIT ya existe.</p>';
                }
            }

            // Si no hay error (o si el NIT es 0), insertar el cliente
            if (empty($alert)) {
                $stmt_insert = $conn->prepare("INSERT INTO clientes (nit, nombre, telefono, direccion, usuario_id) VALUES (:nit, :nombre, :telefono, :direccion, :usuario_id)");
                $stmt_insert->bindParam(':nit', $nit);
                $stmt_insert->bindParam(':nombre', $nombre);
                $stmt_insert->bindParam(':telefono', $telefono);
                $stmt_insert->bindParam(':direccion', $direccion);
                $stmt_insert->bindParam(':usuario_id', $usuario_id);

                if ($stmt_insert->execute()) {
                    $alert = '<p class="msg_save">Cliente guardado correctamente.</p>';
                } else {
                    $alert = '<p class="msg_error">Error al guardar el cliente.</p>';
                }
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
    <title>Registro Cliente</title>
</head>
<body>
<header> 
    <div class="logo">Sistema TinkunaGames</div>
    
    <div class="user-info">
        <span>Bolivia, <?php echo fechaC(); ?> | 
            <?php 
            // Mostrar el rol basado en el rol_id
            if ($_SESSION['rol_id'] == 1) {
                echo 'ADMIN';
            } elseif ($_SESSION['rol_id'] == 2) {
                echo 'VENDEDOR';
            } else {
                echo 'USUARIO'; // O cualquier otro rol que tengas
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
        <h1><i class="fas fa-user-plus"></i> Registro Cliente</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
            <label for="nit">CI/NIT</label>
            <input type="number" name="nit" id="nit" placeholder="NIT o Carnet" value="<?php echo isset($_POST['nit']) ? $_POST['nit'] : ''; ?>">
            
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
            
            <label for="telefono">Teléfono</label>
            <input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo isset($_POST['telefono']) ? $_POST['telefono'] : ''; ?>">
            
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion" placeholder="Dirección completa" value="<?php echo isset($_POST['direccion']) ? $_POST['direccion'] : ''; ?>">
            
            <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Cliente</button>
        </form>
    </div>
</section>
<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
