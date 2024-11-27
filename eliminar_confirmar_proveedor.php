<?php
session_start();
if ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2) {
    header("location: login.php");
    exit;
}

include "conexion.php";
include "functions.php";

if (!empty($_POST)) {
    if (empty($_POST['idproveedor'])) {
        header("location: lista_proveedor.php");
        exit;
    }

    $idproveedor = $_POST['idproveedor'];
    
    try {
        $query_delete = $conn->prepare("UPDATE proveedor SET estatus = 0 WHERE codproveedor = :idproveedor");
        $query_delete->bindParam(':idproveedor', $idproveedor, PDO::PARAM_INT);
        $query_delete->execute();
        
        if ($query_delete->rowCount() > 0) {
            header("location: lista_proveedor.php");
        } else {
            echo "Error al eliminar";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (empty($_REQUEST['id'])) {
    header("location: lista_proveedor.php");
    exit;
} else {
    $idproveedor = $_REQUEST['id'];

    try {
        $query = $conn->prepare("SELECT * FROM proveedor WHERE codproveedor = :idproveedor");
        $query->bindParam(':idproveedor', $idproveedor, PDO::PARAM_INT);
        $query->execute();
        
        if ($query->rowCount() > 0) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $proveedor = $data['proveedor'];
        } else {
            header("location: lista_proveedor.php");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Eliminar proveedor</title>
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
        <div class="data_delete">
            <i class="far fa-building fa-7x" style="color:#e66262"></i>
            <br><br>
            <h2>¿Está seguro de eliminar el siguiente registro?</h2>
            <p>Nombre del Proveedor: <span><?php echo htmlspecialchars($proveedor); ?></span></p>

            <form method="post" action="">
                <input type="hidden" name="idproveedor" value="<?php echo htmlspecialchars($idproveedor); ?>">
                <a href="lista_proveedor.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
            </form>
        </div>
    </section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
