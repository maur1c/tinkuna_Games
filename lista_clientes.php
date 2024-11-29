<?php 
	session_start();
	include "conexion.php";	
    include "functions.php";
	// Paginador
	$sql_registe = $conn->query("SELECT COUNT(*) as total_registro FROM clientes WHERE estatus = 1");
	$result_register = $sql_registe->fetch(PDO::FETCH_ASSOC);
	$total_registro = $result_register['total_registro'];

	$por_pagina = 5;
	$pagina = !empty($_GET['pagina']) ? $_GET['pagina'] : 1;
	$desde = ($pagina-1) * $por_pagina;
	$total_paginas = ceil($total_registro / $por_pagina);

	// Consulta para obtener los datos de clientes con paginación
	$query = $conn->prepare("SELECT c.idcliente, c.nit, c.nombre, c.telefono, c.direccion, u.nombre AS nombre_usuario 
							 FROM clientes c 
							 JOIN usuarios u ON c.usuario_id = u.id 
							 WHERE c.estatus = 1 
							 ORDER BY c.idcliente ASC 
							 LIMIT :desde, :por_pagina");
	$query->bindValue(':desde', $desde, PDO::PARAM_INT);
	$query->bindValue(':por_pagina', $por_pagina, PDO::PARAM_INT);
	$query->execute();
	$result = $query->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/admin.css">
	<title>Lista de clientes</title>
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
		<h1><i class='fas fa-user'></i> Lista de clientes</h1>
		<a href="registro_cliente.php" class="btn_new"><i class="fas fa-user-plus"></i> Crear cliente</a>
		
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<button type="submit" class="btn_search"> <i class="fas fa-search"></i></button>
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>NIT</th>
				<th>Nombre</th>
				<th>Teléfono</th>
				<th>Dirección</th>
				<th>Acciones</th>
			</tr>

			<?php if ($result > 0): 
				while ($data = $query->fetch(PDO::FETCH_ASSOC)): 
					$nit = $data["nit"] == 0 ? 'C/F' : $data["nit"];
			?>
				<tr>
					<td><?php echo $data["idcliente"]; ?></td>
					<td><?php echo $nit; ?></td>
					<td><?php echo $data["nombre"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data["direccion"]; ?></td>
					<td>
						<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-edit"></i> Editar</a>
						<?php if (isset($_SESSION['rol_id']) && ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 4)): ?>
						|
						<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
						<?php endif; ?>
					</td>
					<!-- otra forma de arreglarlo
									<td>
					<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-edit"></i> Editar</a>
					<?php if (isset($_SESSION['rol_id']) && ($_SESSION['rol_id'] == 1)): // Solo admin puede eliminar ?>
					|
					<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
					<?php endif; ?>
				</td>
				-->
				</tr>
			<?php endwhile; 
			endif; ?>
		</table>

		<div class="paginador">
			<ul>
				<?php if($pagina != 1): ?>
					<li><a href="?pagina=<?php echo 1; ?>"><i class="fas fa-step-backward"></i></a></li>
					<li><a href="?pagina=<?php echo $pagina - 1; ?>"><i class="fas fa-caret-left fa-lg"></i></a></li>
				<?php endif; ?>

				<?php 
					for ($i=1; $i <= $total_paginas; $i++): 
						if ($i == $pagina): ?>
							<li class="pageSelected"><?php echo $i; ?></li>
						<?php else: ?>
							<li><a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
						<?php endif;
					endfor; 
				?>

				<?php if($pagina != $total_paginas): ?>
					<li><a href="?pagina=<?php echo $pagina + 1; ?>"><i class="fas fa-caret-right fa-lg"></i></a></li>
					<li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
