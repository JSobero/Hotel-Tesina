<?php
require_once("ControlHotel.php");

// Inicializar el controlador de detallestransaccion
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["eliminar"])) {
        // Eliminar detalle de transacción
        $detalleIdEliminar = $_POST["detalleIdEliminar"];
        $controlHotel->detalleTransaccion->eliminarDetalleTransaccion($detalleIdEliminar);
    }
}

// Obtener todos los detalles de transacción
$detallesTransaccion = $controlHotel->detalleTransaccion->iniciarDetalleTransaccion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Detalles de Transacción</title>
    <link rel="stylesheet" type="text/css" href="css/stylesClientes.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Detalles de Transacción</h1>

    <form method="post" action="detalle/agregarDetalle.php">
        <button type='button' onclick="window.location.href='detalle/agregarDetalle.php';"><i class='material-icons'>add</i> Agregar Detalles</button>
    </form>


    <!-- Lista de Detalles de Transacción -->
    <h2>Listado de Detalles de Transacción</h2>
    <table>
        <thead>
            <tr>
                <th>Reserva</th>
                <th>Servicio Adicional</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Método de Pago</th>
                <th>Acciones</th>
                <th>Imprimir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($detallesTransaccion !== false) {
                foreach ($detallesTransaccion as $detalleTransaccion) {
                    echo "<tr>";
                    
                    // Obtener información de la reserva
                    $reservaInfo = $controlHotel->reserva->getReservaInfo($detalleTransaccion['reservas_id']);

                    echo "<td>{$reservaInfo['reservas_id']} - {$reservaInfo['nombre_cliente']}, {$reservaInfo['apellidos_cliente']} - {$reservaInfo['numero_habitacion']}</td>";
                    // Obtener información del servicio adicional
                    $servicioAdicionalInfo = $controlHotel->serviciosAdicionales->getServicioAdicionalInfo($detalleTransaccion['servicios_adicionales_id']);
                    echo "<td>{$servicioAdicionalInfo['servicios_adicionales_id']} - {$servicioAdicionalInfo['nombre_servicio']}</td>";

                    echo "<td>{$detalleTransaccion['total']}</td>";
                    echo "<td>{$detalleTransaccion['fecha']}</td>";
                    echo "<td>{$detalleTransaccion['metodo_de_pago']}</td>";

                    // Botones de Editar y Eliminar
                    echo "<td>";

                    // Formulario para eliminar
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='detalleIdEliminar' value='{$detalleTransaccion['detalle_id']}'>";
                    echo "<button type='button' class='boton-eliminar' onclick='confirmarEliminacion(this)'><i class='material-icons'>delete</i> Eliminar</button>";
                    echo "</form>";
                    echo "</td>";

                    // Formulario para imprimir
                    echo "<td>";
                    echo "<form method='post' action='detalle/boleta.php' target='_blank' class='form-imprimir'>";
                    echo "<input type='hidden' name='detalle_id' value='{$detalleTransaccion['detalle_id']}'>";
                    echo "<button type='button' name='imprimir' class='boton boton-imprimir' onclick='confirmarImpresion(this)'><i class='material-icons'>print</i> Imprimir</button>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";
                }
            } 
            ?>
        </tbody>
    </table>
    <script>
        function confirmarEliminacion(button) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar este detalle de transacción?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    const form = button.closest('form');
                    form.insertAdjacentHTML('beforeend', '<input type="hidden" name="eliminar" value="1">');
                    form.submit();
                }
            });
        }

        function confirmarImpresion(button) {
            Swal.fire({
                title: '¿Imprimir Boleta?',
                text: "¿Deseas imprimir la boleta para este detalle de transacción?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Sí, imprimir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    const form = button.closest('form');
                    form.submit();
                }
            });
        }
    </script>
    
</body>
</html>
