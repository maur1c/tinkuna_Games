<?php 
session_start();
include "conexion.php";
include "functions.php";

if(!empty($_POST)) {
    $alert = '';
    if(empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $idproveedor = $_POST['id'];
        $proveedor   = $_POST['proveedor'];
        $contacto    = $_POST['contacto'];
        $telefono    = $_POST['telefono'];
        $direccion   = $_POST['direccion'];

        // Actualizar datos del proveedor
        $sql_update = $conn->prepare("UPDATE proveedor SET proveedor = :proveedor, contacto = :contacto, telefono = :telefono, direccion = :direccion WHERE codproveedor = :idproveedor");

        $sql_update->bindParam(':proveedor', $proveedor);
        $sql_update->bindParam(':contacto', $contacto);
        $sql_update->bindParam(':telefono', $telefono, PDO::PARAM_INT);
        $sql_update->bindParam(':direccion', $direccion);
        $sql_update->bindParam(':idproveedor', $idproveedor, PDO::PARAM_INT);

        if($sql_update->execute()) {
            $alert = '<p class="msg_save">Proveedor actualizado correctamente.</p>';
        } else {
            $alert = '<p class="msg_error">Error al actualizar el Proveedor.</p>';
        }
    }
}

// Mostrar datos
if(empty($_REQUEST['id'])) {
    header('Location: lista_proveedor.php');
    exit;
}

$idproveedor = $_REQUEST['id'];

// Obtener información del proveedor
$sql = $conn->prepare("SELECT * FROM proveedor WHERE codproveedor = :idproveedor AND estatus = 1");
$sql->bindParam(':idproveedor', $idproveedor, PDO::PARAM_INT);
$sql->execute();

if($sql->rowCount() == 0) {
    header('Location: lista_proveedor.php');
    exit;
} else {
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    $proveedor   = $data['proveedor'];
    $contacto    = $data['contacto'];
    $telefono    = $data['telefono'];
    $direccion   = $data['direccion'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Actualizar Proveedor</title>
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
            <h1><i class="far fa-edit"></i> Actualizar proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idproveedor; ?>">
                <label for="proveedor">Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor" value="<?php echo $proveedor ?>">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto" value="<?php echo $contacto ?>">
                <label for="telefono">Telefono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono ?>">
                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion completa" value="<?php echo $direccion ?>">
                
                <button type="submit" class="btn_save"> <i class="far fa-edit"></i> Actualizar Proveedor</button>
            </form>
        </div>

    </section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
