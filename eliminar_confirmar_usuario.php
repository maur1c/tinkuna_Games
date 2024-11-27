<?php 
    session_start();
    include "conexion.php"; // Asegúrate de que la ruta a conexion.php sea correcta
    include "functions.php";

    // Verificar si el usuario tiene permiso de administrador
    //if ($_SESSION['rol'] != 1) {
      //  header("location: ./");
    //}

    if (!empty($_POST)) {
        // Impedir la eliminación del usuario con ID 1
        if ($_POST['idusuario'] == 1) {
            header("location: lista_usuarios.php");
            $conn = null;
            exit;
        }

        $idusuario = $_POST['idusuario'];

        // Consulta para eliminar lógicamente el usuario
        $query_delete = $conn->prepare("UPDATE usuarios SET estatus = 0 WHERE id = :idusuario");
        $query_delete->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
        $query_delete->execute();
        
        // Cerrar la conexión
        $conn = null;

        // Verificar si se realizó la eliminación lógica
        if ($query_delete->rowCount() > 0) {
            header("location: lista_usuarios.php");
        } else {
            echo "Error al eliminar";
        }
    }

    // Obtener el ID del usuario a eliminar y sus datos para confirmación
    if (empty($_REQUEST['id']) || $_REQUEST['id'] == 1) {
        header("location: lista_usuarios.php");
        $conn = null;
    } else {
        $idusuario = $_REQUEST['id'];

        // Consulta para obtener los datos del usuario
        $query = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id = :idusuario AND estatus = 1");
        $query->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->rowCount();

        // Validar que el usuario exista antes de mostrar la confirmación de eliminación
        if ($result > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $nombre = $data['nombre'];
            $email = $data['email'];
        } else {
            header("location: lista_usuarios.php");
        }
        
        $conn = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Eliminar Usuario</title>
</head>
<body>
<header>
    <div class="logo">Sistema TinkunaGames</div>
    <div class="user-info">
        <span>Bolivia, <?php echo fechaC(); ?> | ADMIN - <?php echo $_SESSION['nombre']; ?> - <?php echo $_SESSION['correo']; ?></span>
        <img src="assets/img/user.png" alt="User Icon" class="user-icon">
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Logout"></a>
    </div>
</header>

<!-- Incluir el archivo nav.php -->
<?php include 'nav.php'; ?>
<section id="container">
    <div class="data_delete">
        <i class="fas fa-user-times fa-7x" style="color:#e66262"></i>
        <br><br>
        <h2>¿Está seguro de eliminar el siguiente registro?</h2>
        <p>Nombre: <span><?php echo $nombre; ?></span></p>
        <p>Email: <span><?php echo $email; ?></span></p>

        <form method="post" action="">
            <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
            <a href="lista_usuarios.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
            <button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
        </form>
    </div>
</section>
<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
