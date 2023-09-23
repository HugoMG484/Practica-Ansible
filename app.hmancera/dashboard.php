<?php
// Inicia la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php'); // Redirige al inicio de sesión si el usuario no está autenticado
    exit();
}

// Cerrar sesión al hacer clic en el enlace de "Cerrar Sesión"
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php'); // Redirige al inicio de sesión después de cerrar sesión
    exit();
}

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', 'asdm', 'db_practica');

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Operación CREATE (Agregar un nuevo componente electrónico)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Validaciones de datos

    // Insertar el nuevo componente electrónico en la base de datos
    $sql = "INSERT INTO componentes_electronicos (nombre, descripcion, precio) VALUES ('$nombre', '$descripcion', $precio)";
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirigir después de agregar
        exit();
    } else {
        echo "Error al agregar el componente electrónico: " . $conn->error;
    }
}

// Operación READ (Listar componentes electrónicos existentes)
$sql = "SELECT * FROM componentes_electronicos";
$resultado = $conn->query($sql);

// Operación UPDATE (Editar un componente electrónico existente)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Validaciones de datos

    // Actualizar el componente electrónico en la base de datos
    $sql = "UPDATE componentes_electronicos SET nombre='$nombre', descripcion='$descripcion', precio=$precio WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirigir después de editar
        exit();
    } else {
        echo "Error al editar el componente electrónico: " . $conn->error;
    }
}

// Operación DELETE (Eliminar un componente electrónico existente)
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    // Eliminar el componente electrónico de la base de datos
    $sql = "DELETE FROM componentes_electronicos WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirigir después de eliminar
        exit();
    } else {
        echo "Error al eliminar el componente electrónico: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styledash.css"> 
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Pedidos</a></li>
                <li><a href="?logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <section class="container">
        <h2>Catálogo de Componentes Electrónicos</h2>

        <!-- Formulario para agregar un nuevo componente electrónico -->
        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="3"></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <button type="submit" name="agregar">Agregar</button>
        </form>

        <!-- Tabla de componentes electrónicos existentes -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila['id'] . "</td>";
                        echo "<td>" . $fila['nombre'] . "</td>";
                        echo "<td>" . $fila['descripcion'] . "</td>";
                        echo "<td>$" . number_format($fila['precio'], 2) . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action=''>";
                        echo "<input type='hidden' name='id' value='" . $fila['id'] . "'>";
                        echo "<input type='hidden' name='nombre' value='" . $fila['nombre'] . "'>";
                        echo "<input type='hidden' name='descripcion' value='" . $fila['descripcion'] . "'>";
                        echo "<input type='hidden' name='precio' value='" . $fila['precio'] . "'>";
                        echo "<button type='submit' name='editar'>Editar</button>";
                        echo "</form>";
                        echo "<a href='dashboard.php?eliminar=" . $fila['id'] . "'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay componentes electrónicos disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2023 Catálogo de Ventas</p>
    </footer>
</body>
</html>
