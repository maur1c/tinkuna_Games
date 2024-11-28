<?php
session_start();
if ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 4) {
    header("location: ./");
    exit();
}

include "conexion.php";
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['idcliente'])) {
        header("location: lista_clientes.php");
        exit();
    }

    $idcliente = $_POST['idcliente'];

    try {
        // Actualizamos el estatus del cliente en lugar de eliminar
        $query_delete = $conn->prepare("UPDATE clientes SET estatus = 0 WHERE idcliente = :idcliente");
        $query_delete->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
        
        if ($query_delete->execute()) {
            header("location: lista_clientes.php");
        } else {
            echo "Error al eliminar";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif (empty($_GET['id'])) {
    header("location: lista_clientes.php");
    exit();
} else {
    $idcliente = $_GET['id'];

    try {
        // Consulta para obtener los datos del cliente
        $query = $conn->prepare("SELECT nit, nombre FROM clientes WHERE idcliente = :idcliente AND estatus = 1");
        $query->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
        $query->execute();
        $cliente = $query->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            header("location: lista_clientes.php");
            exit();
        }

        $nit = $cliente['nit'];
        $nombre = $cliente['nombre'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Eliminar Cliente</title>
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
            <i class="fas fa-user-times fa-7x" style="color:#e66262"></i>
            <br>
            <br>
            <h2>¿Está seguro de eliminar el siguiente registro?</h2>
            <p>Nombre del Cliente: <span><?php echo htmlspecialchars($nombre); ?></span></p>
            <p>NIT: <span><?php echo htmlspecialchars($nit); ?></span></p>

            <form method="post" action="">
                <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
                <a href="lista_clientes.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
                <button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
            </form>
        </div>
    </section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
