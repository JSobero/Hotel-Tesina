<?php
session_start();

if (isset($_GET['logout'])) {
    // Cerrar la sesión
    session_unset();
    session_destroy();

    // Redirigir al login
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesIndex.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Sistema de Hotel</title>
    <link rel="icon" href="image/logo.png" type="image/x-icon">
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <img src="image/logo.png" alt="Logo del hotel">
        <h2>Serenia Oasis</h2>
    </div>
    <div class="user-info">
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['nombre_usuario']); ?></p>
    </div>
    <div class="categories">
        <ul>
            <li class='sidebar'><a href="indexHotel.php?page=home"><i class="material-icons">home</i> Principal</a></li>
            <li class='sidebar'><a href="indexHotel.php?page=clientes"><i class="material-icons">person</i> Clientes</a></li>
            <li class='sidebar'><a href="indexHotel.php?page=habitacion"><i class="material-icons">hotel</i> Habitaciones</a></li>
            <li class='sidebar'><a href="indexHotel.php?page=reserva"><i class="material-icons">event</i> Reservas</a></li>
            <li class='sidebar'><a href="indexHotel.php?page=serviciosAdicionales"><i class="material-icons">room_service</i> Servicios Adicionales</a></li>
            <li class='sidebar'><a href="indexHotel.php?page=detalleTransacciones"><i class="material-icons">receipt_long</i> Transacciones</a></li>
            <li class='sidebar'><a href="indexHotel.php?page=aprobarReserva"><i class="material-icons">receipt_long</i> Aprobar Reserva</a></li>
            <?php
            // Verificar el rol para mostrar o no el enlace al área de personal
            if ($_SESSION['rol'] == 'administrador') {
                echo "<li class='sidebar'><a href='indexHotel.php?page=personal'><i class='material-icons'>diversity_3</i> Personal</a></li>";
            }
            ?>
            <li class='sidebar'><a href="?logout=1" id="logout-link"><i class="material-icons">exit_to_app</i> Cerrar Sesión</a></li>
        </ul>
    </div>
</div>

<div class="content">
    
    <?php
    // Verificar si se proporciona un parámetro "page" en la URL
    $page = $_GET['page'] ?? '';

    // Incluir la vista correspondiente según la página solicitada
    switch ($page) {
        case 'home':
            include('home/vistaHome.php');
            break;
        case 'clientes':
            include('cliente/vistaClientes.php');
            break;
        // Agrega más casos para otras páginas si es necesario
        case 'personal':
            include('personal/vistaPersonal.php');
            break;
        case 'habitacion':
            include('habitacion/vistaHabitacion.php');
            break;
        case 'reserva':
            include('reserva/vistaReserva.php');
            break;
        case 'serviciosAdicionales':
            include('serviciosAdicionales/vistaServiciosAdicionales.php');
            break;
        case 'detalleTransacciones':
            include('detalle/vistaDetalle.php');
            break;
        case 'aprobarReserva':
            include('aprobacion/aprobar_reserva.php');
            break;
        default:
            // Página principal por defecto
            echo "<h1>Bienvenido al Sistema de Hotel</h1>";
            // Otro contenido de la página principal
            break;
    }
    ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const logoutLink = document.getElementById("logout-link");

    logoutLink.addEventListener("click", function(event) {
        event.preventDefault(); // Prevenir el enlace por defecto

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas cerrar sesión?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, redirigir al logout
                window.location.href = "?logout=1";
                
            }
        });
    });
});
</script>
</body>
</html>
