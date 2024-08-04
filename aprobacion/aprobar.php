<?php
// aprobar.php
include 'db_connection.php';

header('Content-Type: application/json');

$reserva_id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;

$response = ['status' => 'error', 'message' => 'Acción fallida'];

if ($reserva_id && $action) {
    if ($action == 'approve') {
        $sql_move = "INSERT INTO reservas (clientes_id, fecha, habitaciones_id, personal_id)
                     SELECT clientes_id, fecha, habitaciones_id, 1 FROM reservas_pendientes WHERE reserva_id = ?";
        $stmt = $conn->prepare($sql_move);
        $stmt->bind_param('i', $reserva_id);
        $stmt->execute();

        $sql_delete = "DELETE FROM reservas_pendientes WHERE reserva_id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param('i', $reserva_id);
        $stmt->execute();

        $response['status'] = 'success';
        $response['message'] = 'Reserva aprobada con éxito.';
    } elseif ($action == 'reject') {
        $sql_get_cliente = "SELECT clientes_id FROM reservas_pendientes WHERE reserva_id = ?";
        $stmt = $conn->prepare($sql_get_cliente);
        $stmt->bind_param('i', $reserva_id);
        $stmt->execute();
        $stmt->bind_result($clientes_id);
        $stmt->fetch();
        $stmt->close();

        $sql_delete = "DELETE FROM reservas_pendientes WHERE reserva_id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param('i', $reserva_id);
        $stmt->execute();

        $sql_check_cliente = "SELECT COUNT(*) FROM reservas_pendientes WHERE clientes_id = ?";
        $stmt = $conn->prepare($sql_check_cliente);
        $stmt->bind_param('i', $clientes_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) {
            $sql_delete_cliente = "DELETE FROM clientes WHERE clientes_id = ?";
            $stmt = $conn->prepare($sql_delete_cliente);
            $stmt->bind_param('i', $clientes_id);
            $stmt->execute();
        }

        $response['status'] = 'success';
        $response['message'] = 'Reserva rechazada y cliente eliminado (si no tenía otras reservas pendientes).';
    } else {
        $response['message'] = 'Acción no válida.';
    }
} else {
    $response['message'] = 'Faltan parámetros en la solicitud.';
}

$stmt->close();
$conn->close();

echo json_encode($response);
