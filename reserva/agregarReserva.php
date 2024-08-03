<?php
require_once("../ControlHotel.php");

$controlHotel = new ClaseHotel("bd_hotel");
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_agregar"])) {

    // Recupera los datos del formulario
    $cliente_id = $_POST["cliente_id"];
    $habitacion_id = $_POST["habitacion_id"];
    $personal_id = $_POST["personal_id"];
    $fecha = $_POST["fecha"];

    // Agrega la reserva utilizando la función en el modelo
    $resultado = $controlHotel->reserva->agregarReserva($cliente_id, $habitacion_id, $personal_id, $fecha);
    header("Location: ../indexHotel.php?page=reserva");
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

$reserva = $controlHotel->reserva->getAllReservas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Reserva</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesClientes.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
</head>
<body>

    <form id="reserva-form" method="post" action="">
        <h2>Agregar Reserva</h2>
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" id="cliente_id">
            <?php
            require_once("../ControlHotel.php");
            $controlHotel = new ClaseHotel("bd_hotel");
            // Obtener y mostrar dinámicamente los nombres de los clientes
            $clientes = $controlHotel->reserva->obtenerClientes();
            foreach ($clientes as $cliente) {
                echo '<option value="' . $cliente['clientes_id'] . '">' . $cliente['nombres'] . ' ' . $cliente['apellidos'] . '</option>';
            }
            ?>
        </select>

        <br>

        <label for="habitacion_id">Habitación:</label>
        <select name="habitacion_id" id="habitacion_id">
            <?php
            // Obtener y mostrar dinámicamente las opciones de habitaciones
            $habitaciones = $controlHotel->reserva->obtenerHabitaciones();
            foreach ($habitaciones as $habitacion) {
                echo '<option value="' . $habitacion['habitaciones_id'] . '">' . $habitacion['numero_habitacion'] . '</option>';
            }
            ?>
        </select>

        <br>

        <label for="personal_id">Personal:</label>
        <select name="personal_id" id="personal_id">
            <?php
            // Obtener y mostrar dinámicamente las opciones de personal
            $personal = $controlHotel->reserva->obtenerPersonal();
            foreach ($personal as $persona) {
                echo '<option value="' . $persona['personal_id'] . '">' . $persona['nombres'] . ' ' . $persona['apellidos'] . '</option>';
            }
            ?>
        </select>

        <br>

        <label for="fecha">Fecha de Reserva:</label>
        <input type="date" name="fecha" id="fecha" required>

        <br>

        <button type="submit" id="agregar-btn">Agregar Reserva</button>
        <button type="button" name="cancelar" class='boton-cancelar' id="cancelar-btn">Cancelar</button>
        <input type="hidden" name="confirmar_agregar">
    </form>

    <script>
    document.getElementById('agregar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        const form = document.getElementById('reserva-form');
        if (form.checkValidity()) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas agregar esta reserva?",
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
                window.location.href = "../indexHotel.php?page=reserva";
            }
        });
    });
    </script>

</body>
</html>
