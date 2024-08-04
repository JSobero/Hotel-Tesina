<?php
// aprobar_reserva.php
include 'db_connection.php';

$sql = "SELECT rp.reserva_id, c.nombres, c.apellidos, c.dni, c.telefono, h.numero_habitacion, t.nombre AS tipo_habitacion, rp.fecha
        FROM reservas_pendientes rp
        INNER JOIN clientes c ON rp.clientes_id = c.clientes_id
        INNER JOIN habitaciones h ON rp.habitaciones_id = h.habitaciones_id
        INNER JOIN tipohabitacion t ON h.tipo_habitacion_id = t.tipo_habitacion_id";
$result = $conn->query($sql);


echo "<h1>Reservas Pendientes</h1>";
if ($result->num_rows > 0) {
    
    echo "<table border='1'>
            <tr>
                <th>ID Reserva</th>
                <th>Cliente</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Habitación</th>
                <th>Tipo Habitación</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["reserva_id"] . "</td>
                <td>" . $row["nombres"] . " " . $row["apellidos"] . "</td>
                <td>" . $row["dni"] . "</td>
                <td>" . $row["telefono"] . "</td>
                <td>" . $row["numero_habitacion"] . "</td>
                <td>" . $row["tipo_habitacion"] . "</td>
                <td>" . $row["fecha"] . "</td>
                <td>
                    <button onclick=\"performAction('approve', " . $row["reserva_id"] . ")\" class='boton-editar'><i class='material-icons'>check_circle</i> Aprobar</button> 
                    <button onclick=\"performAction('reject', " . $row["reserva_id"] . ")\" class='boton-eliminar'><i class='material-icons'> cancel</i> Rechazar</button>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay reservas pendientes.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas Pendientes</title>
    <link rel="stylesheet" href="css/stylesClientes.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <script>
        function performAction(action, reservaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, proceder',
                cancelButtonText: 'No, cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('aprobacion/aprobar.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'id': reservaId,
                            'action': action
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Resultado de la Acción',
                            text: data.message,
                            icon: data.status,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload(); // Recargar la página para mostrar los cambios
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema con la acción.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>
