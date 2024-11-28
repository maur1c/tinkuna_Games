<?php 
	session_start();
    if($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2) {
        header("location: login.php");
    }
	include "conexion.php";	
    include "functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
	<title>Lista de Proveedores</title>
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
		<?php 
			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda)) {
				header("location: lista_proveedor.php");
				exit;
			}

			// Paginador
			$sql_register = $conn->prepare("SELECT COUNT(*) as total_registro FROM proveedor 
				WHERE (codproveedor LIKE :busqueda OR 
					   proveedor LIKE :busqueda OR 
					   contacto LIKE :busqueda OR 
					   telefono LIKE :busqueda) 
				AND estatus = 1");
			$sql_register->execute([':busqueda' => "%$busqueda%"]);
			$result_register = $sql_register->fetch(PDO::FETCH_ASSOC);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;
			$pagina = empty($_GET['pagina']) ? 1 : $_GET['pagina'];
			$desde = ($pagina - 1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = $conn->prepare("SELECT * FROM proveedor 
				WHERE (codproveedor LIKE :busqueda OR 
					   proveedor LIKE :busqueda OR 
					   contacto LIKE :busqueda OR 
					   telefono LIKE :busqueda) 
				AND estatus = 1 
				ORDER BY codproveedor ASC 
				LIMIT :desde, :por_pagina");
			$query->bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
			$query->bindParam(':desde', $desde, PDO::PARAM_INT);
			$query->bindParam(':por_pagina', $por_pagina, PDO::PARAM_INT);
			$query->execute();
			$result = $query->rowCount();
		?>

		<h1><i class="far fa-building"></i> Lista de proveedores</h1>
		<a href="registro_proveedor.php" class="btn_new"><i class="fas fa-plus"></i> Crear proveedor</a>

		<form action="buscar_proveedor.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
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
			if($result > 0) {
				while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
					$fecha = new DateTime($data['date_add']);
		?>
				<tr>
					<td><?php echo $data["codproveedor"]; ?></td>
					<td><?php echo $data["proveedor"]; ?></td>
					<td><?php echo $data["contacto"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data["direccion"]; ?></td>
					<td><?php echo $fecha->format('d-m-Y'); ?></td>
					<td>
						<a class="link_edit" href="editar_proveedor.php?id=<?php echo $data["codproveedor"]; ?>">Editar</a>
						|
						<a class="link_delete" href="eliminar_confirmar_proveedor.php?id=<?php echo $data["codproveedor"]; ?>">Eliminar</a>
					</td>
				</tr>
		<?php 
				}
			}
		?>
		</table>

		<?php if($total_registro != 0) { ?>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1) {
			?>
				<li><a href="?pagina=1&busqueda=<?php echo urlencode($busqueda); ?>"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo urlencode($busqueda); ?>"><i class="fas fa-backward"></i></a></li>	
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					if($i == $pagina) {
						echo '<li class="pageSelected">'.$i.'</li>';
					} else {
						echo '<li><a href="?pagina='.$i.'&busqueda='.urlencode($busqueda).'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas) {
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
