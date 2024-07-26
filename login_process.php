<?php
// Establecer conexión a la base de datos (reemplaza con tus propios datos)
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "bd_hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Recuperar datos del formulario
$dni = $_POST['dni'];
$contraseña = $_POST['contraseña'];

// Consulta preparada para obtener el registro del personal con el DNI proporcionado
$sql = "SELECT * FROM personal WHERE dni = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script>';
echo 'document.addEventListener("DOMContentLoaded", function() {';
if ($result->num_rows > 0) {
    // Existe un registro con el DNI proporcionado
    $row = $result->fetch_assoc();

    // Verificar la contraseña (usa password_verify si estás usando contraseñas hash)
    if ($contraseña == $row['contraseña']) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['personal_id'] = $row['personal_id'];
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['nombre_usuario'] = $row['nombres'];

        // Mostrar notificación de inicio de sesión exitoso
        echo "Swal.fire({
            icon: 'success',
            title: 'Inicio de sesión exitoso',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = 'indexHotel.php';
        });";
    } else {
        // Contraseña incorrecta
        echo "Swal.fire({
            icon: 'error',
            title: 'Contraseña incorrecta',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = 'indexLogin.php';
        });";
    }
} else {
    // No se encontró ningún registro con el DNI proporcionado
    echo "Swal.fire({
        icon: 'error',
        title: 'Usuario no encontrado',
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        window.location.href = 'indexLogin.php';
    });";
}
echo '});';
echo '</script>';

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>
