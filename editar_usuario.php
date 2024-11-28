<?php   
session_start();
include "conexion.php";
include "functions.php";

if(!empty($_POST)) {
    $alert = '';
    if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['rol'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {
        $idUsuario = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email  = $_POST['correo'];
        $clave   = $_POST['clave'];    // Nuevo campo
        $rol     = $_POST['rol'];

        // Verificar si el correo ya existe
        $query = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND id != :idUsuario");
        $query->bindValue(':email', $email);
        $query->bindValue(':idUsuario', $idUsuario);
        $query->execute();
        
        if($query->rowCount() > 0) {
            $alert = '<p class="msg_error">El correo ya existe.</p>';
        } else {
            // Preparar la consulta de actualización
            $sql_update = $conn->prepare("UPDATE usuarios SET nombre = :nombre, email = :email, rol_id = :rol" . ($clave ? ", contraseña = :clave" : "") . " WHERE id = :idUsuario");
            $sql_update->bindValue(':nombre', $nombre);
            $sql_update->bindValue(':email', $email);
            $sql_update->bindValue(':rol', $rol);
            if ($clave) {
                $hashed_password = password_hash($clave, PASSWORD_DEFAULT); // Asegúrate de usar hashing para la contraseña
                $sql_update->bindValue(':clave', $hashed_password);
            }
            $sql_update->bindValue(':idUsuario', $idUsuario);
            if($sql_update->execute()) {
                $alert = '<p class="msg_save">Usuario actualizado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar el usuario.</p>';
            }
        }
    }
}

// Mostrar Datos
if(empty($_REQUEST['id'])) {
    header('Location: lista_usuarios.php');
    exit();
}
$iduser = $_REQUEST['id'];

// Consulta para obtener los datos del usuario
$sql = $conn->prepare("SELECT u.id, u.nombre, u.email, u.rol_id, r.nombre_rol AS rol FROM usuarios u INNER JOIN roles r ON u.rol_id = r.id WHERE u.id = :iduser AND u.estatus = 1");
$sql->bindValue(':iduser', $iduser);
$sql->execute();

$result_sql = $sql->fetch(PDO::FETCH_ASSOC);

if(!$result_sql) {
    header('Location: lista_usuarios.php');
    exit();
} else {
    $nombre  = $result_sql['nombre'];
    $correo  = $result_sql['email'];
    $idrol   = $result_sql['rol_id'];
    $rol     = $result_sql['rol'];

    // Crear opciones para el select
    $option = '<option value="'.$idrol.'" selected>'.$rol.'</option>';
}

// Consulta para obtener todos los roles
$query_rol = $conn->query("SELECT * FROM roles");
$result_rol = $query_rol->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Actualizar Usuario</title>
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
    <div class="form_register">
        <h1><i class="far fa-edit"></i> Actualizar usuario</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $iduser; ?>">
            
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">

            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $correo; ?>">

            <label for="clave">Clave de Usuario</label>
            <input type="password" name="clave" id="clave" placeholder="Clave de usuario (dejar vacío si no desea cambiar)">

            <label for="rol">Tipo Usuario</label>
            <select name="rol" id="rol" class="notItemOne">
                <?php
                    // Opción seleccionada
                    echo $option; 

                    // Opciones de otros roles
                    foreach($result_rol as $rol) {
                        if ($rol["id"] != $idrol) { // Verifica si el rol actual no es el rol seleccionado
                            echo '<option value="'.$rol["id"].'">'.$rol["nombre_rol"].'</option>'; // Cambié 'rol' por 'nombre_rol' aquí
                        }
                    }
                ?>
            </select>
            <button type="submit" class="btn_save"><i class="far fa-edit"></i> Actualizar usuario</button>
        </form>
    </div>
</section>
<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
