<?php 
session_start();
if ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2) {
    header("login.php");
}
include "conexion.php";	
include "functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
	<title>Lista de proveedores</title>
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
		
		<h1><i class='fas fa-user'></i> Lista de proveedores</h1>
		<a href="registro_proveedor.php" class="btn_new"><i class="fas fa-plus"></i> Crear proveedor</a>
		
		<form action="buscar_proveedor.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Proveedor</th>
				<th>Contacto</th>
				<th>Teléfono</th>
				<th>Dirección</th>
                <th>Fecha</th>
				<th>Acciones</th>
			</tr>
		<?php 
			// Paginador
			$sql_register = $conn->query("SELECT COUNT(*) as total_registro FROM proveedor WHERE estatus = 1");
			$result_register = $sql_register->fetch(PDO::FETCH_ASSOC);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;
			$pagina = empty($_GET['pagina']) ? 1 : $_GET['pagina'];
			$desde = ($pagina - 1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			// Consulta de proveedores con paginación
			$query = $conn->prepare("SELECT * FROM proveedor WHERE estatus = 1 ORDER BY codproveedor ASC LIMIT :desde, :por_pagina");
			$query->bindParam(':desde', $desde, PDO::PARAM_INT);
			$query->bindParam(':por_pagina', $por_pagina, PDO::PARAM_INT);
			$query->execute();

			$result = $query->rowCount();
			if ($result > 0) {
				while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
					$formato = 'Y-m-d H:i:s';
					$fecha = DateTime::createFromFormat($formato, $data['date_add']);
		?>
				<tr>
					<td><?php echo $data["codproveedor"]; ?></td>
					<td><?php echo $data["proveedor"]; ?></td>
					<td><?php echo $data["contacto"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data["direccion"]; ?></td>
					<td><?php echo $fecha->format('d-m-Y'); ?></td>
					<td>
						<a class="link_edit" href="editar_proveedor.php?id=<?php echo $data["codproveedor"]; ?>"><i class="far fa-edit"></i> Editar</a> |
						<a class="link_delete" href="eliminar_confirmar_proveedor.php?id=<?php echo $data["codproveedor"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
					</td>
				</tr>
		<?php 
				}
			}
		?>
		</table>
		<div class="paginador">
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
	</section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
