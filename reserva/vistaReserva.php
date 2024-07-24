<?php
require_once("ControlHotel.php");

// Inicializar el controlador de reservas
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["eliminar"])) {
        // Eliminar reserva
        $reservaIdEliminar = $_POST["reservaIdEliminar"];
        $controlHotel->reserva->eliminarReserva($reservaIdEliminar);
    }
}

// Obtener todas las reservas
$reservas = $controlHotel->reserva->getAllReservas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Reserva</title>
    <link rel="stylesheet" type="text/css" href="css/stylesClientes.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <h1>Reservas</h1>

    <!-- Boton para agregar reserva -->
    <form method="post" action="reserva/agregarReserva.php">
        <button type='button' onclick="window.location.href='reserva/agregarReserva.php';"><i class='material-icons'>add</i> Agregar Reserva</button>
    </form>

    <!-- Lista de Reservas -->
    <h2>Listado de Reservas</h2>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Personal</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($reservas !== false) {
                while ($row = $reservas->fetch_assoc()) {
                    echo "<tr>";
                    // Obtener información de cliente
                    $clienteInfo = $controlHotel->reserva->getClienteInfo($row['clientes_id']);
                    echo "<td>{$clienteInfo['nombres']} {$clienteInfo['apellidos']}</td>";

                    // Obtener información de habitación
                    $habitacionInfo = $controlHotel->reserva->getHabitacionInfo($row['habitaciones_id']);
                    echo "<td>{$habitacionInfo['numero_habitacion']}</td>";

                    // Obtener información de personal
                    $personalInfo = $controlHotel->reserva->getPersonalInfo($row['personal_id']);
                    echo "<td>{$personalInfo['nombres']} {$personalInfo['apellidos']}</td>";

                    echo "<td>{$row['fecha']}</td>";

                    // Botón de Eliminar
                    echo "<td>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='reservaIdEliminar' value='{$row['reservas_id']}'>";
                    echo "<button type='submit' name='eliminar' class='boton-eliminar'><i class='material-icons'>delete</i> Eliminar</button>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay reservas.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>