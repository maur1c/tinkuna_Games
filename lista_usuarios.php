<?php 
session_start(); // Asegúrate de iniciar la sesión
include 'conexion.php'; // Asegúrate de que la conexión esté correcta
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Lista de usuarios</title>
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
        <h1><i class="fas fa-users fa-2x"></i> Lista de usuarios</h1>
        <a href="registro.php" class="btn_new"><i class="fas fa-user-plus"></i> Crear usuario</a>
        <form action="buscar_usuario.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
            <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
        </form>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        <?php 
            // Paginador
            $sql_register = $conn->query("SELECT COUNT(*) as total_registro FROM usuarios");
            $result_register = $sql_register->fetch(PDO::FETCH_ASSOC);
            $total_registro = $result_register['total_registro'];

            $por_pagina = 5;
            $pagina = empty($_GET['pagina']) ? 1 : (int)$_GET['pagina'];
            $desde = ($pagina - 1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);

            // Consulta de usuarios
            // Consulta de usuarios con filtro de estatus
                $query = $conn->prepare("SELECT id, nombre, email, fecha_registro FROM usuarios WHERE estatus = 1 ORDER BY id ASC LIMIT :desde, :por_pagina");
                $query->bindValue(':desde', $desde, PDO::PARAM_INT);
                $query->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
                $query->execute();


            if ($query->rowCount() > 0) {
                while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <tr>
                    <td><?php echo $data["id"]; ?></td>
                    <td><?php echo $data["nombre"]; ?></td>
                    <td><?php echo $data["email"]; ?></td>
                    <td><?php echo $data["fecha_registro"]; ?></td>
                    <td>
                        <a class="link_edit" href="editar_usuario.php?id=<?php echo $data["id"]; ?>"><i class="far fa-edit"></i> Editar</a>
                        |
                        <a class="link_delete" href="eliminar_confirmar_usuario.php?id=<?php echo $data["id"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
                    </td>
                </tr>
        <?php 
                }
            } else {
                echo '<tr><td colspan="5">No hay usuarios registrados</td></tr>';
            }
        ?>
        </table>
        
        <!-- Paginador -->
        <div class="paginador">
            <ul>
            <?php 
                if ($pagina > 1) {
            ?>
                <li><a href="?pagina=1"><i class="fas fa-step-backward"></i></a></li>
                <li><a href="?pagina=<?php echo $pagina - 1; ?>"><i class="fas fa-caret-left fa-lg"></i></a></li>
            <?php 
                }
                for ($i = 1; $i <= $total_paginas; $i++) {
                    echo $i == $pagina ? '<li class="pageSelected">'.$i.'</li>' : '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                }
                if ($pagina < $total_paginas) {
            ?>
                <li><a href="?pagina=<?php echo $pagina + 1; ?>"><i class="fas fa-caret-right fa-lg"></i></a></li>
                <li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>
            <?php } ?>
            </ul>
        </div>
    </section>

    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
