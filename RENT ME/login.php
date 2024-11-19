<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");

// Verificar si la conexión es exitosa
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario
$nombre_usuario = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];

// Consulta para obtener el usuario por nombre de usuario
$sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $nombre_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si el usuario existe
if ($resultado->num_rows > 0) {
    // Obtener la fila de la base de datos
    $usuario = $resultado->fetch_assoc();
    
    // Verificar si la contraseña es correcta
    if (password_verify($contrasena, $usuario['contrasena'])) {
        // Si es correcta, se inicia sesión
        session_start();
        $_SESSION['usuario'] = $usuario['nombre_usuario'];
        echo "Inicio de sesión exitoso. ¡Bienvenido, " . $usuario['nombre_usuario'] . "!";
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>

<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");

// Verificar si la conexión es exitosa
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Datos de registro (pueden provenir de un formulario)
$nombre_usuario = "nuevoUsuario";
$contrasena = "miContrasenaSegura";

// Encriptar la contraseña
$hash_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

// Insertar el nuevo usuario en la base de datos
$sql = "INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $nombre_usuario, $hash_contrasena);

if ($stmt->execute()) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error al registrar el usuario: " . $conexion->error;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>
