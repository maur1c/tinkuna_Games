<?php 
session_start();
if ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2) {
    header("location: login.php");
    exit;
}
include "conexion.php";    
include "functions.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Lista de Productos</title>
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

<!-- Incluir el archivo nav.php -->
<?php include 'nav.php'; ?>

<section id="container">
    <?php 
    $busqueda = strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)) {
        header("location: lista_producto.php");
        exit;
    }

    // Paginador
    $sql_register = $conn->prepare("SELECT COUNT(*) as total_registro FROM juegos_de_mesa 
        WHERE (nombre LIKE :busqueda OR descripcion LIKE :busqueda OR categoria LIKE :busqueda) 
        AND estatus = 1");
    $sql_register->execute([':busqueda' => "%$busqueda%"]);
    $result_register = $sql_register->fetch(PDO::FETCH_ASSOC);
    $total_registro = $result_register['total_registro'];

    $por_pagina = 5;
    $pagina = empty($_GET['pagina']) ? 1 : $_GET['pagina'];
    $desde = ($pagina - 1) * $por_pagina;
    $total_paginas = ceil($total_registro / $por_pagina);

    $query = $conn->prepare("SELECT * FROM juegos_de_mesa 
        WHERE (nombre LIKE :busqueda OR descripcion LIKE :busqueda OR categoria LIKE :busqueda) 
        AND estatus = 1 
        ORDER BY id_juego ASC 
        LIMIT :desde, :por_pagina");
    $query->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
    $query->bindParam(':desde', $desde, PDO::PARAM_INT);
    $query->bindParam(':por_pagina', $por_pagina, PDO::PARAM_INT);
    $query->execute();
    $result = $query->rowCount();
    ?>

    <h1><i class="fas fa-gamepad"></i> Lista de Productos</h1>
    <a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Crear Producto</a>

    <form action="buscar_producto.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    <?php 
    if ($result > 0) {
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <tr>
            <td><?php echo $data["id_juego"]; ?></td>
            <td><?php echo $data["nombre"]; ?></td>
            <td><?php echo $data["descripcion"]; ?></td>
            <td><?php echo $data["categoria"]; ?></td>
            <td><?php echo $data["precio"]; ?></td>
            <td>
                <a class="link_edit" href="editar_producto.php?id=<?php echo $data["id_juego"]; ?>">Editar</a>
                |
<<<<<<< HEAD
                <a class="link_delete" href="eliminar_producto.php?id=<?php echo $data["id_juego"]; ?>">Eliminar</a>
=======
                <a class="link_delete" href="eliminar_confirmar_producto.php?id=<?php echo $data["id_juego"]; ?>">Eliminar</a>
                <?php if ($data['publicado'] == 1): ?>
                        <a class="link_publish" href="publicar_cliente_producto.php?id=<?php echo $data['id_juego']; ?>&estado=0"><i class="fas fa-eye-slash"></i> Despublicar</a>
                    <?php else: ?>
                        <a class="link_publish" href="publicar_cliente_producto.php?id=<?php echo $data['id_juego']; ?>&estado=1"><i class="fas fa-eye"></i> Publicar</a>
                    <?php endif; ?>
>>>>>>> main
            </td>
        </tr>
    <?php 
        }
    }
    ?>
    </table>

    <?php if ($total_registro != 0) { ?>
    <div class="paginador">
        <ul>
        <?php 
            if ($pagina != 1) {
        ?>
            <li><a href="?pagina=1&busqueda=<?php echo urlencode($busqueda); ?>"><i class="fas fa-step-backward"></i></a></li>
            <li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo urlencode($busqueda); ?>"><i class="fas fa-backward"></i></a></li>    
        <?php 
            }
            for ($i = 1; $i <= $total_paginas; $i++) { 
                if ($i == $pagina) {
                    echo '<li class="pageSelected">'.$i.'</li>';
                } else {
                    echo '<li><a href="?pagina='.$i.'&busqueda='.urlencode($busqueda).'">'.$i.'</a></li>';
                }
            }

            if ($pagina != $total_paginas) {
        ?>
            <li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo urlencode($busqueda); ?>"><i class="fas fa-forward"></i></a></li> 
            <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo urlencode($busqueda); ?>"><i class="fas fa-step-forward"></i></a></li>
        <?php } ?>
        </ul>
    </div>
    <?php } ?>

</section>
<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
