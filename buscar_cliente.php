<?php
session_start();
include "conexion.php";  // Incluye tu conexión PDO
include "functions.php";

// Verifica si el parámetro 'busqueda' fue enviado
$busqueda = strtolower($_REQUEST['busqueda'] ?? '');
if (empty($busqueda)) {
    header("location: lista_clientes.php");
    exit;
}

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
        <h1>Lista de clientes</h1>
        <a href="registro_cliente.php" class="btn_new">Crear cliente</a>
        
        <form action="buscar_cliente.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
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

            <?php
            // Contador para el total de registros
            $query_registro = $conn->prepare("SELECT COUNT(*) as total_registro FROM clientes 
                                              WHERE (idcliente LIKE :busqueda OR nit LIKE :busqueda OR nombre LIKE :busqueda OR telefono LIKE :busqueda OR direccion LIKE :busqueda)
                                              AND estatus = 1");
            $query_registro->execute([':busqueda' => "%$busqueda%"]);
            $result_register = $query_registro->fetch(PDO::FETCH_ASSOC);
            $total_registro = $result_register['total_registro'] ?? 0;

            $por_pagina = 5;
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $desde = ($pagina - 1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);

            // Consulta principal
            $query = $conn->prepare("SELECT * FROM clientes 
                                     WHERE (idcliente LIKE :busqueda OR nit LIKE :busqueda OR nombre LIKE :busqueda OR telefono LIKE :busqueda OR direccion LIKE :busqueda)
                                     AND estatus = 1 ORDER BY idcliente ASC LIMIT :desde, :por_pagina");
            $query->bindParam(':busqueda', $busqueda_param);
            $busqueda_param = "%$busqueda%";
            $query->bindParam(':desde', $desde, PDO::PARAM_INT);
            $query->bindParam(':por_pagina', $por_pagina, PDO::PARAM_INT);
            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0):
                foreach ($result as $data):
            ?>
            <tr>
                <td><?php echo $data["idcliente"]; ?></td>
                <td><?php echo $data["nit"]; ?></td>
                <td><?php echo htmlspecialchars($data["nombre"]); ?></td>
                <td><?php echo $data["telefono"]; ?></td>
                <td><?php echo htmlspecialchars($data["direccion"]); ?></td>
                <td>
                    <a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>">Editar</a>
                    <?php if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 4): ?>
                        |
                        <a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>">Eliminar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php
                endforeach;
            endif;
            ?>
        </table>

        <?php if ($total_registro > 0): ?>
        <div class="paginador">
            <ul>
                <?php if ($pagina != 1): ?>
                    <li><a href="?pagina=1&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-step-backward"></i></a></li>
                    <li><a href="?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-backward"></i></a></li>
                <?php endif; ?>

                <?php
                for ($i = 1; $i <= $total_paginas; $i++) {
                    if ($i == $pagina) {
                        echo '<li class="pageSelected">'.$i.'</li>';
                    } else {
                        echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                    }
                }
                ?>

                <?php if ($pagina != $total_paginas): ?>
                    <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-forward"></i></a></li>
                    <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>"><i class="fas fa-step-forward"></i></a></li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </section>
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
