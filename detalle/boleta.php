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
        // Establecer márgenes para el logo
        $this->SetLeftMargin(10);
        $this->SetRightMargin(10);

        // Agregar logo circular y nombre del hotel en la esquina derecha
        $this->Image('../image/logo.png', 170, 8, 25); // Ajusta las coordenadas según sea necesario
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(125, 8); // Ajusta las coordenadas según sea necesario
        $this->Cell(60, 10, 'Serenia Oasis', 0, 1, 'C');

        $this->Ln(10);

        // Restaurar márgenes predeterminados
        $this->SetLeftMargin(10);
        $this->SetRightMargin(10);

        // Añade las celdas con la información del detalle de transacción
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Boleta de Detalle de Transaccion', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Fecha: ' . date('d/m/Y', strtotime($detalleTransaccionInfo['fecha'])), 0, 1, 'L');
        $this->Cell(0, 10, 'Numero de Detalle: ' . $detalleTransaccionInfo['detalle_id'], 0, 1, 'L');

        $this->Ln(10); // Salto de línea

        // Información de la reserva
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Informacion de la Reserva', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'ID de Reserva: ' . $detalleTransaccionInfo['reservas_id'], 0, 1, 'L');
        $this->Cell(0, 10, 'Fecha de Reserva: ' . $detalleTransaccionInfo['fecha_reserva'], 0, 1, 'L');
        $this->Cell(0, 10, 'Cliente: ' . $detalleTransaccionInfo['nombre_cliente'] . ' ' . $detalleTransaccionInfo['apellidos_cliente'], 0, 1, 'L');
        $this->Cell(0, 10, 'Habitacion: ' . $detalleTransaccionInfo['numero_habitacion'], 0, 1, 'L');
        $this->Cell(0, 10, 'Tipo de Habitacion: ' . $detalleTransaccionInfo['tipo_habitacion'], 0, 1, 'L');
        $this->Cell(0, 10, 'Precio de la Habitacion: S/.' . number_format($detalleTransaccionInfo['precio_habitacion'], 2), 0, 1, 'L');

        $this->Ln(10); // Salto de línea

        // Información del servicio adicional
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Informacion del Servicio Adicional', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'ID de Servicio Adicional: ' . $detalleTransaccionInfo['servicios_adicionales_id'], 0, 1, 'L');
        $this->Cell(0, 10, 'Nombre del Servicio: ' . $detalleTransaccionInfo['nombre_servicio'], 0, 1, 'L');
        $this->Cell(0, 10, 'Precio del Servicio: S/.' . number_format($detalleTransaccionInfo['precio_servicio'], 2), 0, 1, 'L');

        $this->Ln(10); // Salto de línea

        // Otros detalles
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Otros Detalles', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Total: S/.' . $detalleTransaccionInfo['total'], 0, 1, 'L');
        $this->Cell(0, 10, 'Metodo de Pago: ' . $detalleTransaccionInfo['metodo_de_pago'], 0, 1, 'L');

        // Línea de separación
        $this->Line(10, $this->GetY() + 10, 200, $this->GetY() + 10);
        
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
