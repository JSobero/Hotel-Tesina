<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de detallestransaccion
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador para procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregarDetalleTransaccion"])) {
        // Recuperar datos del formulario
        $reservas_id = $_POST["reservas_id"];
        $servicios_adicionales_id = $_POST["servicios_adicionales_id"];
        $fecha = $_POST["fecha"];
        $metodo_de_pago = $_POST["metodo_de_pago"];

        // Validar la existencia de la reserva y el servicio adicional
        $reservaExistente = $controlHotel->reserva->getReservaInfo($reservas_id);
        $servicioAdicionalExistente = $controlHotel->serviciosAdicionales->getServicioAdicionalInfo($servicios_adicionales_id);

        if ($reservaExistente && $servicioAdicionalExistente) {
            // Agregar detalle de transacción
            $precioHabitacion = obtenerPrecioHabitacion($controlHotel, $reservas_id);
            $precioServicio = obtenerPrecioServicio($controlHotel, $servicios_adicionales_id);
            $total = $precioHabitacion + $precioServicio;

            $controlHotel->detalleTransaccion->agregarDetalleTransaccion($reservas_id, $servicios_adicionales_id, $total, $fecha, $metodo_de_pago);
        } else {
            echo "Error: La reserva o el servicio adicional no existen.";
        }
    }
    header("Location: ../indexHotel.php?page=detalleTransacciones");
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

// Obtener precios de habitación y servicio
function obtenerPrecioHabitacion($controlHotel, $reservas_id) {
    $consultaHabitacion = "SELECT habitaciones.tipo_habitacion_id FROM habitaciones 
                          JOIN reservas ON habitaciones.habitaciones_id = reservas.habitaciones_id
                          WHERE reservas.reservas_id = $reservas_id";

    $resultadoHabitacion = mysqli_query($controlHotel->cn, $consultaHabitacion);

    if ($filaHabitacion = mysqli_fetch_assoc($resultadoHabitacion)) {
        $tipo_habitacion_id = $filaHabitacion['tipo_habitacion_id'];

        $consultaPrecioHabitacion = "SELECT precio FROM tipohabitacion WHERE tipo_habitacion_id = $tipo_habitacion_id";
        $resultadoPrecioHabitacion = mysqli_query($controlHotel->cn, $consultaPrecioHabitacion);

        if ($filaPrecioHabitacion = mysqli_fetch_assoc($resultadoPrecioHabitacion)) {
            return $filaPrecioHabitacion['precio'];
        } else {
            echo "Error: No se pudo obtener el precio de la habitación.";
            exit;
        }
    } else {
        echo "Error: No se pudo obtener la información de la habitación.";
        exit;
    }
}


function obtenerPrecioServicio($controlHotel, $servicios_adicionales_id) {
    $consultaPrecioServicio = "SELECT precio FROM tiposervicio WHERE tipo_servicio_id = (SELECT tipo_servicio_id FROM serviciosadicionales WHERE servicios_adicionales_id = $servicios_adicionales_id)";
    $resultadoPrecioServicio = mysqli_query($controlHotel->cn, $consultaPrecioServicio);

    if ($filaPrecioServicio = mysqli_fetch_assoc($resultadoPrecioServicio)) {
        return $filaPrecioServicio['precio'];
    } else {
        echo "Error: No se pudo obtener el precio del servicio adicional.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Detalle de Transacción</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesClientes.css">
</head>
<body>
    <h1>Agregar Detalle de Transacción</h1>

    <!-- Formulario para Agregar Detalle de Transacción -->
    <form method="post" action="">
        <label for="reservas_id">ID de Reserva:</label>
        <select name="reservas_id" required>
            <?php
            // Obtener información de todas las reservas
            $reservasInfo = $controlHotel->reserva->getAllReservasInfo();

            // Mostrar opciones en el combo box
            foreach ($reservasInfo as $reservaInfo) {
                echo "<option value='{$reservaInfo['reservas_id']}'>Reserva #{$reservaInfo['reservas_id']} - {$reservaInfo['nombre_cliente']} {$reservaInfo['apellidos_cliente']} - Habitación #{$reservaInfo['numero_habitacion']}</option>";
            }
            ?>
        </select>

        <label for="servicios_adicionales_id">ID de Servicio Adicional:</label>
        <select name="servicios_adicionales_id" required>
            <?php
            // Obtener información de todos los servicios adicionales
            $serviciosAdicionalesInfo = $controlHotel->serviciosAdicionales->getAllServiciosAdicionalesInfo();

            // Mostrar opciones en el combo box
            foreach ($serviciosAdicionalesInfo as $servicioAdicionalInfo) {
                echo "<option value='{$servicioAdicionalInfo['servicios_adicionales_id']}'>ID: {$servicioAdicionalInfo['servicios_adicionales_id']} - Servicio: {$servicioAdicionalInfo['nombre_servicio']} - Cantidad: {$servicioAdicionalInfo['cantidad']} - Atendido por: {$servicioAdicionalInfo['nombre_personal']} {$servicioAdicionalInfo['apellidos_personal']}</option>";
            }
            ?>
        </select>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>

        <label for="metodo_de_pago">Método de Pago:</label>
        <select name="metodo_de_pago" required>
            <option value="Efectivo">Efectivo</option>
            <option value="Tarjeta">Tarjeta</option>
        </select>

        <button type="submit" name="agregarDetalleTransaccion">Agregar Detalle de Transacción</button>
    </form>

</body>
</html>
