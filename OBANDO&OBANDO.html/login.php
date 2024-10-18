<?php
session_start();

// Conectar a la base de datos
$host = 'localhost'; // Cambia según tu configuración
$db = 'nombre_de_tu_base_de_datos'; // Cambia según tu configuración
$user = 'tu_usuario'; // Cambia según tu configuración
$pass = 'tu_contraseña'; // Cambia según tu configuración

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Almacenar información en la sesión
            $_SESSION['username'] = $username;
            header("Location: dashboard.php"); // Redirigir a la página del panel de usuario
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró el usuario.";
    }
}

$conn->close();
?>
