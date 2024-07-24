<?php
class ClaseDetalleTransaccion
{
    private $detalle_id;
    private $reservas_id;
    private $servicios_adicionales_id;
    private $total;
    private $fecha;
    private $metodo_de_pago;
    public $cn;

    function __construct($xcn)
    {
        $this->cn = $xcn;
    }

    public function iniciarDetalleTransaccion()
    {
        $query = "SELECT dt.detalle_id, dt.reservas_id, dt.servicios_adicionales_id, dt.total, dt.fecha, dt.metodo_de_pago,
                r.fecha as fecha_reserva, c.nombres as nombre_cliente, c.apellidos as apellidos_cliente
                FROM detallestransaccion dt
                LEFT JOIN reservas r ON dt.reservas_id = r.reservas_id
                LEFT JOIN clientes c ON r.clientes_id = c.clientes_id";

        $resultado = mysqli_query($this->cn, $query);

        $detallesTransaccion = array();

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $detallesTransaccion[] = $fila;
        }

        return $detallesTransaccion;
    }

    public function agregarDetalleTransaccion($reservas_id, $servicios_adicionales_id, $total, $fecha, $metodo_de_pago)
    {
        $query = "INSERT INTO detallestransaccion (reservas_id, servicios_adicionales_id, total, fecha, metodo_de_pago) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->cn, $query);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "iisss", $reservas_id, $servicios_adicionales_id, $total, $fecha, $metodo_de_pago);

            // Ejecuta la consulta
            $result = mysqli_stmt_execute($stmt);

            // Cierra el statement
            mysqli_stmt_close($stmt);

            return $result;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
    }
    

    public function actualizarDetalleTransaccion($detalle_id, $reservas_id, $servicios_adicionales_id, $total, $fecha, $metodo_de_pago)
    {
        $sqlActualizarDetalleTransaccion = "UPDATE detallestransaccion SET reservas_id=?, servicios_adicionales_id=?, total=?, fecha=?, metodo_de_pago=? WHERE detalle_id=?";
        $stmt = mysqli_prepare($this->cn, $sqlActualizarDetalleTransaccion);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "iisssi", $reservas_id, $servicios_adicionales_id, $total, $fecha, $metodo_de_pago, $detalle_id);

            // Ejecuta la consulta
            $result = mysqli_stmt_execute($stmt);

            // Cierra el statement
            mysqli_stmt_close($stmt);

            return $result;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
    }

    public function eliminarDetalleTransaccion($detalle_id)
    {
        $sqlEliminarDetalleTransaccion = "DELETE FROM detallestransaccion WHERE detalle_id=?";
        $stmt = mysqli_prepare($this->cn, $sqlEliminarDetalleTransaccion);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "i", $detalle_id);

            // Ejecuta la consulta
            $result = mysqli_stmt_execute($stmt);

            // Cierra el statement
            mysqli_stmt_close($stmt);

            return $result;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
 
 
    }

public function getDetalleTransaccionInfo($detalle_id)
{
    $query = "SELECT dt.detalle_id, dt.reservas_id, dt.servicios_adicionales_id, dt.total, dt.fecha, dt.metodo_de_pago,
    r.fecha as fecha_reserva, c.nombres as nombre_cliente, c.apellidos as apellidos_cliente,
    h.numero_habitacion, th.nombre as tipo_habitacion, th.precio as precio_habitacion,
    p.nombres as nombre_empleado, p.apellidos as apellidos_empleado,
    ts.nombre as nombre_servicio, ts.precio as precio_servicio
FROM detallestransaccion dt
LEFT JOIN reservas r ON dt.reservas_id = r.reservas_id
LEFT JOIN clientes c ON r.clientes_id = c.clientes_id
LEFT JOIN habitaciones h ON r.habitaciones_id = h.habitaciones_id
LEFT JOIN tipohabitacion th ON h.tipo_habitacion_id = th.tipo_habitacion_id
LEFT JOIN personal p ON r.personal_id = p.personal_id
LEFT JOIN serviciosadicionales sa ON dt.servicios_adicionales_id = sa.servicios_adicionales_id
LEFT JOIN tiposervicio ts ON sa.tipo_servicio_id = ts.tipo_servicio_id
WHERE dt.detalle_id = ?";

    $stmt = mysqli_prepare($this->cn, $query);

    // Verifica si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Vincula los parámetros
        mysqli_stmt_bind_param($stmt, "i", $detalle_id);

        // Ejecuta la consulta
        mysqli_stmt_execute($stmt);

        // Obtiene el resultado
        $resultado = mysqli_stmt_get_result($stmt);

        // Obtiene la fila de resultados
        $detalleTransaccionInfo = mysqli_fetch_assoc($resultado);

        // Cierra el statement
        mysqli_stmt_close($stmt);

        return $detalleTransaccionInfo;
    } else {
        // Manejar el error de preparación de la consulta
        return false;
    }
}


}
?>