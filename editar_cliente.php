<?php
session_start();
include "conexion.php";
include "functions.php";

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $idcliente = $_POST['id'];
        $nit = $_POST['nit'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        $result = 0;

        // Verificar si el NIT ya existe
        if (is_numeric($nit) && $nit != 0) {
            $query = $conn->prepare("SELECT * FROM clientes WHERE nit = :nit AND idcliente != :idcliente");
            $query->bindParam(':nit', $nit, PDO::PARAM_INT);
            $query->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch();
        }

        if ($result) {
            $alert = '<p class="msg_error">El NIT ya existe, ingrese otro.</p>';
        } else {
            if ($nit == '') {
                $nit = 0;
            }

            // Actualizar cliente
            $sql_update = $conn->prepare("UPDATE clientes SET nit = :nit, nombre = :nombre, telefono = :telefono, direccion = :direccion WHERE idcliente = :idcliente");
            $sql_update->bindParam(':nit', $nit, PDO::PARAM_INT);
            $sql_update->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $sql_update->bindParam(':telefono', $telefono, PDO::PARAM_INT);
            $sql_update->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $sql_update->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);

            if ($sql_update->execute()) {
                $alert = '<p class="msg_save">Cliente actualizado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar el cliente.</p>';
            }
        }
    }
}

// Mostrar datos
if (empty($_REQUEST['id'])) {
    header('Location: lista_clientes.php');
    exit;
}
$idcliente = $_REQUEST['id'];

// Obtener los datos del cliente
$query = $conn->prepare("SELECT * FROM clientes WHERE idcliente = :idcliente AND estatus = 1");
$query->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
$query->execute();
$data = $query->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: lista_clientes.php');
    exit;
}

$nit = $data['nit'];
$nombre = $data['nombre'];
$telefono = $data['telefono'];
$direccion = $data['direccion'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Actualizar Cliente</title>
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
            <h1><i class="far fa-edit"></i> Actualizar Cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
                <label for="nit">NIT</label>
                <input type="number" name="nit" id="nit" placeholder="Número de NIT" value="<?php echo $nit; ?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección completa" value="<?php echo $direccion; ?>">
                <button type="submit" class="btn_save"><i class="far fa-edit"></i> Actualizar Cliente</button>
            </form>
        </div>
    </section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
