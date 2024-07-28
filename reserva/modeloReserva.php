<?php

class ClaseReserva
{
    private $reservas_id;
    private $clientes_id;
    private $fecha;
    private $habitaciones_id;
    private $personal_id;
    public $cn;

    function __construct($xcn) {
        $this->cn = $xcn;
    }

    public function iniciarReserva() {
        $query = "SELECT r.reservas_id, r.fecha, c.nombres as nombre_cliente, c.apellidos as apellidos_cliente, h.numero_habitacion, p.nombres as nombre_personal, p.apellidos as apellidos_personal
                FROM reservas r
                LEFT JOIN clientes c ON r.clientes_id = c.clientes_id
                LEFT JOIN habitaciones h ON r.habitaciones_id = h.habitaciones_id
                LEFT JOIN personal p ON r.personal_id = p.personal_id";
    
        $resultado = mysqli_query($this->cn, $query);
    
        $reservas = array();
    
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $reservas[] = $fila;
        }
    
        return $reservas;
    }


    function getReservaId()
    {
        return $this->reservas_id;
    }

    function getClienteId()
    {
        return $this->clientes_id;
    }

    function getFecha()
    {
        return $this->fecha;
    }

    function getHabitacionId()
    {
        return $this->habitaciones_id;
    }

    function getPersonalId()
    {
        return $this->personal_id;
    }

    function agregarReserva($cliente_id, $habitacion_id, $personal_id, $fecha) {
        $query = "INSERT INTO reservas (clientes_id, habitaciones_id, personal_id, fecha) 
                  VALUES ('$cliente_id', '$habitacion_id', '$personal_id', '$fecha')";
        $result = mysqli_query($this->cn, $query);

        return $result;
    }

    function actualizarReserva($reservas_id, $clientes_id, $fecha, $habitaciones_id, $personal_id)
    {
        $sqlActualizarReserva = "UPDATE reservas SET clientes_id='$clientes_id', fecha='$fecha', habitaciones_id='$habitaciones_id', personal_id='$personal_id' WHERE reservas_id='$reservas_id'";
        if (mysqli_query($this->cn, $sqlActualizarReserva)) {
            echo "Reserva Actualizada";
        } else {
            echo "Error actualizando reserva";
        }
    }

    function eliminarReserva($reservas_id)
    {
        $sqlEliminarReserva = "DELETE FROM reservas WHERE reservas_id='$reservas_id'";
        if (mysqli_query($this->cn, $sqlEliminarReserva)) {
            //echo "Reserva eliminada con éxito";
        } else {
            echo "Error eliminando reserva";
        }
    }

    function getAllReservas()
    {
        $consulta = "SELECT * FROM reservas";
        $rs = mysqli_query($this->cn, $consulta);

        if ($rs && mysqli_num_rows($rs) > 0) {
            return $rs;
        } else {
            return false;
        }
    }

    function obtenerClientes() {
        $query = "SELECT clientes_id, nombres, apellidos FROM clientes";
        $result = mysqli_query($this->cn, $query);

        $clientes = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $clientes[] = $row;
        }

        return $clientes;
    }

    function obtenerHabitaciones() {
        $query = "SELECT habitaciones_id, numero_habitacion FROM habitaciones";
        $result = mysqli_query($this->cn, $query);

        $habitaciones = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $habitaciones[] = $row;
        }

        return $habitaciones;
    }

    function obtenerPersonal() {
        $query = "SELECT personal_id, nombres, apellidos FROM personal";
        $result = mysqli_query($this->cn, $query);

        $personal = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $personal[] = $row;
        }

        return $personal;
    }
    
    function getClienteInfo($clienteId) {
        $query = "SELECT * FROM clientes WHERE clientes_id = $clienteId";
        $result = mysqli_query($this->cn, $query);
    
        return mysqli_fetch_assoc($result);
    }

    function getHabitacionInfo($habitacionId) {
        $query = "SELECT * FROM habitaciones WHERE habitaciones_id = $habitacionId";
        $result = mysqli_query($this->cn, $query);
    
        return mysqli_fetch_assoc($result);
    }
    
    function getPersonalInfo($personalId) {
        $query = "SELECT * FROM personal WHERE personal_id = $personalId";
        $result = mysqli_query($this->cn, $query);
    
        return mysqli_fetch_assoc($result);
    }

    function getAllReservasIds()
    {
        $consulta = "SELECT reservas_id FROM reservas";
        $rs = mysqli_query($this->cn, $consulta);

        $ids = array();

        if ($rs && mysqli_num_rows($rs) > 0) {
            while ($fila = mysqli_fetch_assoc($rs)) {
                $ids[] = $fila;
            }
        }

        return $ids;
    }

    public function getReservaInfo($reservaId)
    {
        $query = "SELECT r.*, c.nombres as nombre_cliente, c.apellidos as apellidos_cliente, h.numero_habitacion
                FROM reservas r
                LEFT JOIN clientes c ON r.clientes_id = c.clientes_id
                LEFT JOIN habitaciones h ON r.habitaciones_id = h.habitaciones_id
                WHERE r.reservas_id = ?";
        $stmt = mysqli_prepare($this->cn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $reservaId);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $reservaInfo = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            return $reservaInfo;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
    }

    function getAllReservasInfo()
    {
        $query = "SELECT r.reservas_id, r.fecha, c.nombres as nombre_cliente, c.apellidos as apellidos_cliente, h.numero_habitacion, p.nombres as nombre_personal, p.apellidos as apellidos_personal
                  FROM reservas r
                  LEFT JOIN clientes c ON r.clientes_id = c.clientes_id
                  LEFT JOIN habitaciones h ON r.habitaciones_id = h.habitaciones_id
                  LEFT JOIN personal p ON r.personal_id = p.personal_id";

        $result = mysqli_query($this->cn, $query);

        $reservasInfo = array();

        while ($fila = mysqli_fetch_assoc($result)) {
            $reservasInfo[] = $fila;
        }

        return $reservasInfo;
    }

    public function getTipoHabitacion($reservas_id)
    {
        $query = "SELECT h.tipo_habitacion_id FROM reservas r JOIN habitaciones h ON r.habitaciones_id = h.habitaciones_id WHERE r.reservas_id = ?";
        $stmt = mysqli_prepare($this->cn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $reservas_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $tipoHabitacion);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            return $tipoHabitacion;
        } else {
            return false;
        }
    }
}
?>
