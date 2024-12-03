<?php
session_start();
include 'conexion.php';
include "functions.php";

// Buscador
$busqueda = '';
if (!empty($_GET['busqueda'])) {
    $busqueda = trim($_GET['busqueda']);
    $query = $conn->prepare("SELECT id, fecha_emision, nombre_cliente, subtotal, nit_ci_cliente FROM facturacion WHERE nombre_cliente LIKE :busqueda OR nit_ci_cliente LIKE :busqueda ORDER BY fecha_emision DESC");
    $query->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
} else {
    $query = $conn->query("SELECT id, fecha_emision, nombre_cliente, subtotal, nit_ci_cliente FROM facturacion ORDER BY fecha_emision DESC");
}
$query->execute();
$facturas = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/admin.css">
    <title>Lista de Facturas</title>
</head>
<body>
<header>
    <div class="logo">Sistema TinkunaGames</div>
    <div class="user-info">
        <span>Bolivia, <?php echo date('Y-m-d'); ?> | 
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
        <a href="logout.php" class="logout-icon"><img src="assets/img/salir.png" alt="Salir"></a>
    </div>
</header>

<!-- Incluir el archivo nav.php -->
<?php include 'nav.php'; ?>

<section id="container">
    <div class="title_page">
        <h1><i class="fas fa-file-invoice"></i> Lista de Facturas</h1>
    </div>

    <!-- Buscador -->
    <form action="lista_facturas.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar por Cliente o CI/NIT" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" class="btn_search"><i class="fas fa-search"></i> Buscar</button>
    </form>
    
    <div class="datos_lista">
        <table class="tbl_facturas">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha de Emisión</th>
                    <th>Cliente</th>
                    <th>NIT/CI</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($facturas) > 0): ?>
                    <?php foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($factura['id']); ?></td>
                        <td><?php echo htmlspecialchars($factura['fecha_emision']); ?></td>
                        <td><?php echo htmlspecialchars($factura['nombre_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($factura['nit_ci_cliente']); ?></td>
                        <td class="textright">S/. <?php echo number_format($factura['subtotal'], 2); ?></td>
                        <td class="textcenter">
                        <a href="#" class="btn_view" onclick="verFactura(<?php echo $factura['id']; ?>)"><i class="fas fa-eye"></i> Ver PDF</a>
                            <a href="editar_factura.php?id=<?php echo $factura['id']; ?>" class="link_edit"><i class="far fa-edit"></i> Editar</a>
                            <a href="eliminar_factura.php?id=<?php echo $factura['id']; ?>" class="link_delete"><i class="far fa-trash-alt"></i> Eliminar</a>
                            <a href="generar_factura.php?id=<?php echo $factura['id']; ?>" class="btn btn_download">Descargar PDF</a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="textright">No hay facturas generadas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>


                    <!-- Modal para la vista previa de la factura -->
<div id="modalFactura" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <div id="facturaPreview">
            <!-- Aquí se cargará la vista previa de la factura -->
        </div>
    </div>
</div>

<style>
/* Estilos para el modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalFactura');
    const closeModal = document.getElementById('closeModal');
    
    // Función para cerrar el modal
    closeModal.onclick = () => {
        modal.style.display = 'none';
        document.getElementById('facturaPreview').innerHTML = ''; // Limpia el contenido del modal
    };
    
    // Cierra el modal si se hace clic fuera de él
    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
            document.getElementById('facturaPreview').innerHTML = ''; // Limpia el contenido del modal
        }
    };
});

// Función para mostrar la vista previa de la factura
function verFactura(id) {
    const modal = document.getElementById('modalFactura');
    const facturaPreview = document.getElementById('facturaPreview');

    // Realiza una solicitud AJAX para obtener los datos de la factura
    fetch(`vista_previa_factura.php?id=${id}`)
        .then(response => response.text())
        .then(html => {
            facturaPreview.innerHTML = html; // Carga el contenido de la factura en el modal
            modal.style.display = 'block'; // Muestra el modal
        })
        .catch(error => console.error('Error al cargar la vista previa:', error));
}
</script>




<script src="assets/js/functions.js" defer></script>
<script src="assets/js/icons.js" defer></script>
<script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
