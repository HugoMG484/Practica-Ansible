<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ya está autenticado y redirigir si es necesario
if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php'); // Redirige a la página de inicio del usuario autenticado
    exit();
}

// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar a la base de datos
    $conn = new mysqli('localhost', 'root', 'asdm', 'db_practica');

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Consulta SQL para verificar las credenciales
    $sql = "SELECT id, nombre FROM usuarios WHERE email = '$email' AND contraseña = '$contraseña'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Las credenciales son válidas, iniciar sesión
        $row = $resultado->fetch_assoc();
        $_SESSION['usuario'] = $row['nombre'];
        header('Location: dashboard.php'); // Redirige a la página de inicio del usuario autenticado
        exit();
    } else {
        // Las credenciales son inválidas, muestra un mensaje de error
        $mensaje_error = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-form">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($mensaje_error)) { ?>
            <p class="error-message"><?php echo $mensaje_error; ?></p>
        <?php } ?>
        <form method="POST" action="">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
