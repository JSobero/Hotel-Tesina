<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_agregar"])) {
    // Agregar cliente
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $dni = $_POST["dni"];
    $telefono = $_POST["telefono"];

    $controlHotel->clientes->agregarCliente($nombres, $apellidos, $dni, $telefono);
    header("Location: ../indexHotel.php?page=clientes");
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

// Obtener todos los clientes
$clientes = $controlHotel->clientes->getAllClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesClientes.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form id="cliente-form" method="post" action="">
        <h2>Agregar Cliente</h2>
        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" maxlength="8" pattern="\d{8}" title="El DNI debe contener exactamente 8 números." required>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" maxlength="9" pattern="\d{9}" title="El telefono debe contener exactamente 9 números." required>

        <button type="button" id="agregar-btn">Agregar Cliente</button>
        <button type="button" name="cancelar" class='boton-cancelar' id="cancelar-btn">Cancelar</button>
        <input type="hidden" name="confirmar_agregar">
    </form>

    <script>
    document.getElementById('agregar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        const form = document.getElementById('cliente-form');
        if (form.checkValidity()) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas agregar este cliente?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, agregar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    form.submit();
                }
            });
        } else {
            // Si los campos requeridos no son válidos, mostrar la validación del navegador
            form.reportValidity();
        }
    });

    document.getElementById('cancelar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas cancelar la operación?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, redirigir a la página de clientes
                window.location.href = "../indexHotel.php?page=clientes";
            }
        });
    });
    </script>
</body>
</html>
