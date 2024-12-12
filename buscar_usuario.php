<?php  
session_start();

include "conexion.php";	
include "functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Buscar Usuario</title>
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
        <?php 
            $busqueda = strtolower($_REQUEST['busqueda']);
            if(empty($busqueda)) {
                header("location: lista_usuarios.php");
                exit();
            }
            
            // Define los roles que se buscarán
            $rol = '';
            if($busqueda == 'administrador') {
                $rol = " OR rol_id = 1 ";
            } else if($busqueda == 'vendedor') {
                $rol = " OR rol_id = 2 ";
            }

            // Paginación con PDO
            $stmt = $conn->prepare("SELECT COUNT(*) as total_registro FROM usuarios 
                                     WHERE (id LIKE :busqueda OR 
                                            nombre LIKE :busqueda OR 
                                            email LIKE :busqueda $rol) 
                                     AND estatus = 1");
            $stmt->execute([':busqueda' => "%$busqueda%"]);
            $result_register = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_registro = $result_register['total_registro'];
            $por_pagina = 5;

            $pagina = empty($_GET['pagina']) ? 1 : $_GET['pagina'];
            $desde = ($pagina - 1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);

            // Consulta de usuarios con PDO
            $stmt = $conn->prepare("SELECT u.id, u.nombre, u.email, r.nombre_rol AS rol 
                                    FROM usuarios u 
                                    INNER JOIN roles r ON u.rol_id = r.id 
                                    WHERE (u.id LIKE :busqueda OR 
                                           u.nombre LIKE :busqueda OR 
                                           u.email LIKE :busqueda OR 
                                           r.nombre_rol LIKE :busqueda)
                                    AND u.estatus = 1 
                                    ORDER BY u.id ASC 
                                    LIMIT :desde, :por_pagina");

            $stmt->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
            $stmt->bindValue(':desde', $desde, PDO::PARAM_INT);
            $stmt->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <h1>Lista de usuarios</h1>
        <a href="registro_usuario.php" class="btn_new">Crear usuario</a>
        
        <form action="buscar_usuario.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
            <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        <?php 
            if($result) {
                foreach ($result as $data) {
        ?>
                <tr>
                    <td><?php echo $data["id"]; ?></td>
                    <td><?php echo $data["nombre"]; ?></td>
                    <td><?php echo $data["email"]; ?></td>
                    <td><?php echo $data["rol"]; ?></td>
                    <td>
                        <a class="link_edit" href="editar_usuario.php?id=<?php echo $data["id"]; ?>">Editar</a>
                        <?php if($data["id"] != 1){ ?>
                            |
                            <a class="link_delete" href="eliminar_confirmar_usuario.php?id=<?php echo $data["id"]; ?>">Eliminar</a>
                        <?php } ?>
                    </td>
                </tr>
        <?php 
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
            }
        ?>
        </table>

        <?php 
            if($total_registro != 0) {
        ?>
            <div class="paginador">
                <ul>
                <?php 
                    if($pagina != 1) {
                ?>
                    <li><a href="?pagina=1&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-step-backward"></i></a></li>
                    <li><a href="?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-backward"></i></a></li>    
                <?php 
                    }
                    for ($i = 1; $i <= $total_paginas; $i++) { 
                        if($i == $pagina) {
                            echo '<li class="pageSelected">'.$i.'</li>';
                        } else {
                            echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                        }
                    }

                    if($pagina != $total_paginas) {
                ?>
                    <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-forward"></i></a></li> 
                    <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-step-forward"></i></a></li>
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
