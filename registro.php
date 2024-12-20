<?php
session_start(); // Asegúrate de iniciar la sesión

include 'conexion.php';
include 'functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Cifrar contraseña
    $rol_id = $_POST['rol']; // Obtener el rol seleccionado

    // Verificar si el correo electrónico ya está registrado
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario_existente = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor(); // Cerrar el cursor

    if ($usuario_existente) {
        $alert = "El correo electrónico ya está registrado. Por favor, utiliza otro.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contraseña, rol_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $contraseña, $rol_id]);
        $stmt->closeCursor(); // Cerrar el cursor

        $alert = "¡Usuario registrado con éxito!";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/admin.css"> <!-- Aquí enlazas tu archivo CSS -->
    <title>Registro Usuario</title>
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

    <div class="form_register">
        <h1><i class="fas fa-user-plus"></i> Registro usuario</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="registro.php" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" required>

            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" placeholder="Correo electrónico" required>

            <label for="contraseña">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required>

            <label for="rol">Tipo Usuario</label>
            <select name="rol" id="rol" required>
                <option value="">Selecciona un rol</option>
                <?php
                // Obtener los roles de la base de datos
                $stmt = $conn->prepare("SELECT id, nombre_rol FROM roles");
                $stmt->execute();
                $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre_rol']; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn_save"> <i class="far fa-save"></i> Crear usuario</button>
        </form>
    </div>
    <!-- esta partes son los js -->
    <script src="assets/js/functions.js" defer></script>
    <script src="assets/js/icons.js" defer></script>
    <script src="assets/js/jquery.min.js" defer></script>
</body>
</html>
