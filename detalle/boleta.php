<?php
require_once("../ControlHotel.php");
require('../fpdf/fpdf.php'); // Asegúrate de tener la biblioteca FPDF incluida en tu proyecto

// Inicializar el controlador de detallestransaccion
$controlHotel = new ClaseHotel("bd_hotel");

class PDF extends FPDF
{
    // Método para agregar información al PDF
    public function AddDetalleTransaccionInfo($detalleTransaccionInfo)
    {
        // Agregar logo y nombre del hotel
        $this->Image('../image/logo.png', 170, 8, 25);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(35, 10, 'Serenia Oasis', 0, 1, 'R');

        $this->Ln(10);

        // Título
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(0, 51, 102); // Azul oscuro
        $this->Cell(0, 10, 'Boleta de Detalle de Transaccion', 0, 1, 'C');
        $this->SetTextColor(0, 0, 0); // Negro

        $this->Ln(5); // Salto de línea

        // Información del detalle de transacción
        $this->SetFont('Arial', '', 12);
        $this->Cell(40, 10, 'Fecha:', 0, 0, 'L');
        $this->Cell(0, 10, date('d/m/Y', strtotime($detalleTransaccionInfo['fecha'])), 0, 1, 'L');
        $this->Cell(40, 10, 'Numero de Detalle:', 0, 0, 'L');
        $this->Cell(0, 10, $detalleTransaccionInfo['detalle_id'], 0, 1, 'L');

        $this->Ln(5); // Salto de línea

        // Información de la reserva y cliente
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Informacion de la Reserva y Cliente', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(40, 10, 'ID de Reserva:', 0, 0, 'L');
        $this->Cell(0, 10, $detalleTransaccionInfo['reservas_id'], 0, 1, 'L');
        $this->Cell(40, 10, 'Cliente:', 0, 0, 'L');
        $this->Cell(0, 10, $detalleTransaccionInfo['nombre_cliente'] . ' ' . $detalleTransaccionInfo['apellidos_cliente'], 0, 1, 'L');
        $this->Cell(40, 10, 'Habitacion:', 0, 0, 'L');
        $this->Cell(0, 10, $detalleTransaccionInfo['numero_habitacion'] . ' (' . $detalleTransaccionInfo['tipo_habitacion'] . ')', 0, 1, 'L');
        $this->Cell(40, 10, 'Precio Habitacion:', 0, 0, 'L');
        $this->Cell(0, 10, 'S/.' . number_format($detalleTransaccionInfo['precio_habitacion'], 2), 0, 1, 'L');

        $this->Ln(5); // Salto de línea

        // Información del servicio adicional
        if ($detalleTransaccionInfo['servicios_adicionales_id']) {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Informacion del Servicio Adicional', 0, 1, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(40, 10, 'Servicio:', 0, 0, 'L');
            $this->Cell(0, 10, $detalleTransaccionInfo['nombre_servicio'], 0, 1, 'L');
            $this->Cell(40, 10, 'Precio Servicio:', 0, 0, 'L');
            $this->Cell(0, 10, 'S/.' . number_format($detalleTransaccionInfo['precio_servicio'], 2), 0, 1, 'L');
        }

        $this->Ln(5); // Salto de línea

        // Total y método de pago
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Total y Metodo de Pago', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(40, 10, 'Total:', 0, 0, 'L');
        $this->Cell(0, 10, 'S/.' . number_format($detalleTransaccionInfo['total'], 2), 0, 1, 'L');
        $this->Cell(40, 10, 'Metodo de Pago:', 0, 0, 'L');
        $this->Cell(0, 10, $detalleTransaccionInfo['metodo_de_pago'], 0, 1, 'L');

        $this->Ln(10); // Salto de línea
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Gracias por su visita', 0, 1, 'C');
    }
}

if (isset($_POST['detalle_id'])) {
    $detalle_id = $_POST['detalle_id'];

    // Lógica para obtener la información del detalle de transacción según el $detalle_id
    $detalleTransaccionInfo = $controlHotel->detalleTransaccion->getDetalleTransaccionInfo($detalle_id);

    if ($detalleTransaccionInfo) {
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->AddDetalleTransaccionInfo($detalleTransaccionInfo);
        $pdf->Output();
    } else {
        echo 'Error: No se pudo obtener la información del detalle de transaccion';
    }
} else {
    echo 'Error: Falta el parámetro detalle_id';
}
?>
