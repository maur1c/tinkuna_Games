<?php
include 'conexion.php';
include "functions.php";
session_start();

// Verificar si el usuario está autenticado y es un administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header('Location: login.php');
    exit();
}

// Paginación y obtención de productos
$sql_register = $conn->query("SELECT COUNT(*) as total_registro FROM juegos_de_mesa WHERE estatus = 1");
$result_register = $sql_register->fetch(PDO::FETCH_ASSOC);
$total_registro = $result_register['total_registro'];

$por_pagina = 5;
$pagina = empty($_GET['pagina']) ? 1 : $_GET['pagina'];
$desde = ($pagina - 1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);

<<<<<<< HEAD
=======
// Aquí no limitamos por "publicado = 0", ya que queremos que permanezca en la lista
>>>>>>> main
$query = $conn->prepare("SELECT * FROM juegos_de_mesa WHERE estatus = 1 ORDER BY id_juego ASC LIMIT :desde, :por_pagina");
$query->bindParam(':desde', $desde, PDO::PARAM_INT);
$query->bindParam(':por_pagina', $por_pagina, PDO::PARAM_INT);
$query->execute();
$productos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<header> 
    <div class="logo">Sistema TinkunaGames</div>
    <div class="user-info">
        <span>Bolivia, <?php echo fechaC(); ?> | 
            <?php echo $_SESSION['rol_id'] == 1 ? 'ADMIN' : 'USUARIO'; ?>
            - <?php echo $_SESSION['nombre']; ?> - <?php echo $_SESSION['correo']; ?>
        </span>
        <img src="assets/img/user.png" alt="User Icon" class="user-icon">
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Logout"></a>
    </div>
</header>

<?php include 'nav.php'; ?>

<section id="container">
    <h1><i class='fas fa-cogs'></i> Lista de Productos</h1>
    <a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Agregar Producto</a>

    <form action="buscar_producto.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
        <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $data): ?>
            <tr>
                <td><?php echo $data["id_juego"]; ?></td>
                <td><?php echo $data["nombre"]; ?></td>
                <td><?php echo $data["descripcion"]; ?></td>
                <td><?php echo $data["precio"]; ?></td>
                <td>
<<<<<<< HEAD
                    <a class="link_edit" href="editar_producto.php?id=<?php echo $data["id_juego"]; ?>"><i class="far fa-edit"></i> Editar</a> |
                    <a class="link_delete" href="eliminar_producto.php?id=<?php echo $data["id_juego"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
=======
                    <a class="link_edit" href="editar_producto.php?id=<?php echo $data['id_juego']; ?>"><i class="far fa-edit"></i> Editar</a> |
                    <a class="link_delete" href="eliminar_confirmar_producto.php?id=<?php echo $data['id_juego']; ?>"><i class="far fa-trash-alt"></i> Eliminar</a> |

                    <?php if ($data['publicado'] == 1): ?>
                        <a class="link_publish" href="publicar_cliente_producto.php?id=<?php echo $data['id_juego']; ?>&estado=0"><i class="fas fa-eye-slash"></i> Despublicar</a>
                    <?php else: ?>
                        <a class="link_publish" href="publicar_cliente_producto.php?id=<?php echo $data['id_juego']; ?>&estado=1"><i class="fas fa-eye"></i> Publicar</a>
                    <?php endif; ?>
>>>>>>> main
                </td>

            </tr>
        <?php endforeach; ?>
    </table>

    <div class="paginador">
<<<<<<< HEAD
			<ul>
			<?php 
				if ($pagina != 1) {
			?>
				<li><a href="?pagina=<?php echo 1; ?>"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina - 1; ?>"><i class="fas fa-caret-left fa-lg"></i></a></li>
			<?php 
				}
				for ($i = 1; $i <= $total_paginas; $i++) { 
					if ($i == $pagina) {
						echo '<li class="pageSelected">' . $i . '</li>';
					} else {
						echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
					}
				}

				if ($pagina != $total_paginas) {
			?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>"><i class="fas fa-caret-right fa-lg"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>
			<?php } ?>
			</ul>
		</div>
=======
        <ul>
        <?php 
            if ($pagina != 1) {
        ?>
            <li><a href="?pagina=<?php echo 1; ?>"><i class="fas fa-step-backward"></i></a></li>
            <li><a href="?pagina=<?php echo $pagina - 1; ?>"><i class="fas fa-caret-left fa-lg"></i></a></li>
        <?php 
            }
            for ($i = 1; $i <= $total_paginas; $i++) { 
                if ($i == $pagina) {
                    echo '<li class="pageSelected">' . $i . '</li>';
                } else {
                    echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
                }
            }

            if ($pagina != $total_paginas) {
        ?>
            <li><a href="?pagina=<?php echo $pagina + 1; ?>"><i class="fas fa-caret-right fa-lg"></i></a></li>
            <li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>
        <?php } ?>
        </ul>
    </div>
>>>>>>> main
</section>

<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>

</body>
</html>
