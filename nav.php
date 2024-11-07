<nav>
    <ul>
        <li>
            <a href="<?php echo ($_SESSION['rol_id'] == 1) ? 'admin_dashboard.php' : 'vendedor_dashboard.php'; ?>">
                <i class="fas fa-home"></i> Inicio
            </a>
        </li>
        <?php 
        if ($_SESSION['rol_id'] == 1) { // Rol de Administrador
        ?>
        <li class="principal">
            <a href="#"><i class="fas fa-users"></i> Usuarios</a>
            <ul>
                <li><a href="registro.php"><i class="fas fa-user-plus"></i> Nuevo Usuario</a></li>
                <li><a href="lista_usuarios.php"><i class="fas fa-users"></i> Lista de Usuarios</a></li>
            </ul>
        </li>
        <?php } ?>
        <li class="principal">
            <a href="#"><i class="far fa-user"></i> Clientes</a>
            <ul>
                <li><a href="registro_cliente.php"><i class="fas fa-user-plus"></i> Nuevo Cliente</a></li>
                <li><a href="lista_clientes.php"><i class="far fa-list-alt"></i> Lista de Clientes</a></li>
            </ul>
        </li>
        <?php 
        if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 2) { // Rol de Admin o Vendedor
        ?>
        <li class="principal">
            <a href="#"><i class="far fa-building"></i> Proveedores</a>
            <ul>
                <li><a href="registro_proveedor.php"><i class="fas fa-plus"></i> Nuevo Proveedor</a></li>
                <li><a href="lista_proveedor.php"><i class="fas fa-list-alt"></i> Lista de Proveedores</a></li>
            </ul>
        </li>
        <li class="principal">
            <a href="#"><i class="fas fa-cubes"></i> Productos</a>
            <ul>
                <li><a href="registro_producto.php"><i class="fas fa-plus"></i> Nuevo Producto</a></li>
                <li><a href="lista_producto.php"><i class="fas fa-cube"></i> Lista de Productos</a></li>
            </ul>
        </li>
        <?php } ?>
        <li class="principal">
            <a href="#"><i class="far fa-file-alt"></i> Facturas</a>
            <ul>
                <li><a href="registro_factura.php"><i class="fas fa-file-alt"></i> Nueva Factura</a></li>
                <li><a href="lista_facturas.php"><i class="fas fa-clipboard-list"></i> Lista de Facturas</a></li>
            </ul>
        </li>
    </ul>
</nav>
