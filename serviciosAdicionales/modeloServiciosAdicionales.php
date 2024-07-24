<?php

class ClaseServicioAdicional
{
    private $servicios_adicionales_id;
    private $tipo_servicio_id;
    private $cantidad;
    private $personal_id;
    public $cn;

    function __construct($xcn)
    {
        $this->cn = $xcn;
    }

    public function iniciarServiciosAdicionales()
    {
        $query = "SELECT sa.servicios_adicionales_id, ts.nombre as tipo_servicio, sa.cantidad, p.nombres as nombre_personal, p.apellidos as apellidos_personal
                FROM serviciosadicionales sa
                LEFT JOIN tiposervicio ts ON sa.tipo_servicio_id = ts.tipo_servicio_id
                LEFT JOIN personal p ON sa.personal_id = p.personal_id";

        $resultado = mysqli_query($this->cn, $query);

        $serviciosAdicionales = array();

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $serviciosAdicionales[] = $fila;
        }

        return $serviciosAdicionales;
    }

    function getServicioAdicionalId()
    {
        return $this->servicios_adicionales_id;
    }

    function getTipoServicioId()
    {
        return $this->tipo_servicio_id;
    }

    function getCantidad()
    {
        return $this->cantidad;
    }

    function getPersonalId()
    {
        return $this->personal_id;
    }

    function agregarServicioAdicional($tipo_servicio_id, $cantidad, $personal_id)
    {
        $query = "INSERT INTO serviciosadicionales (tipo_servicio_id, cantidad, personal_id) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->cn, $query);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "iii", $tipo_servicio_id, $cantidad, $personal_id);

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

    function actualizarServicioAdicional($servicios_adicionales_id, $tipo_servicio_id, $cantidad, $personal_id)
    {
        $sqlActualizarServicioAdicional = "UPDATE serviciosadicionales SET tipo_servicio_id=?, cantidad=?, personal_id=? WHERE servicios_adicionales_id=?";
        $stmt = mysqli_prepare($this->cn, $sqlActualizarServicioAdicional);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "iiii", $tipo_servicio_id, $cantidad, $personal_id, $servicios_adicionales_id);

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

    function eliminarServicioAdicional($servicios_adicionales_id)
    {
        $sqlEliminarServicioAdicional = "DELETE FROM serviciosadicionales WHERE servicios_adicionales_id=?";
        $stmt = mysqli_prepare($this->cn, $sqlEliminarServicioAdicional);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "i", $servicios_adicionales_id);

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

    function obtenerTiposServicio()
    {
        $query = "SELECT tipo_servicio_id, nombre FROM tiposervicio";
        $result = mysqli_query($this->cn, $query);

        $tipos_servicio = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $tipos_servicio[] = $row;
        }

        return $tipos_servicio;
    }

    function obtenerPersonal()
    {
        $query = "SELECT personal_id, nombres, apellidos FROM personal";
        $result = mysqli_query($this->cn, $query);

        $personal = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $personal[] = $row;
        }

        return $personal;
    }

    function getTipoServicioInfo($tipoServicioId)
    {
        $query = "SELECT * FROM tiposervicio WHERE tipo_servicio_id = ?";
        $stmt = mysqli_prepare($this->cn, $query);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "i", $tipoServicioId);

            // Ejecuta la consulta
            mysqli_stmt_execute($stmt);

            // Obtiene el resultado
            $result = mysqli_stmt_get_result($stmt);

            // Obtiene la fila
            $row = mysqli_fetch_assoc($result);

            // Cierra el statement
            mysqli_stmt_close($stmt);

            return $row;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
    }

    function getPersonalInfo($personalId)
    {
        $query = "SELECT * FROM personal WHERE personal_id = ?";
        $stmt = mysqli_prepare($this->cn, $query);

        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "i", $personalId);

            // Ejecuta la consulta
            mysqli_stmt_execute($stmt);

            // Obtiene el resultado
            $result = mysqli_stmt_get_result($stmt);

            // Obtiene la fila
            $row = mysqli_fetch_assoc($result);

            // Cierra el statement
            mysqli_stmt_close($stmt);

            return $row;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
    }

    function getAllServicioAdicional()
    {
        $consulta = "SELECT * FROM serviciosadicionales";
        $rs = mysqli_query($this->cn, $consulta);

        if ($rs && mysqli_num_rows($rs) > 0) {
            return $rs;
        } else {
            return false;
        }
    }

    public function getAllTiposServicio()
    {
        $query = "SELECT * FROM tiposervicio";
        $result = mysqli_query($this->cn, $query);

        return $result;
    }

    public function buscarServicioAdicionalPorId($servicioAdicionalId)
    {
        $query = "SELECT * FROM serviciosadicionales WHERE servicios_adicionales_id = $servicioAdicionalId";
        $result = mysqli_query($this->cn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $servicioAdicional = mysqli_fetch_assoc($result);

            // Actualizar las propiedades de la instancia con los datos recuperados
            $this->servicios_adicionales_id = $servicioAdicional['servicios_adicionales_id'];
            $this->tipo_servicio_id = $servicioAdicional['tipo_servicio_id'];
            $this->cantidad = $servicioAdicional['cantidad'];
            $this->personal_id = $servicioAdicional['personal_id'];

            return true; // Indicar que se encontró el servicio adicional
        } else {
            return false; // Indicar que no se encontró el servicio adicional
        }
    }

    function getAllServiciosAdicionales()
    {
        $consulta = "SELECT * FROM serviciosadicionales";
        $rs = mysqli_query($this->cn, $consulta);

        if ($rs && mysqli_num_rows($rs) > 0) {
            return $rs;
        } else {
            return false;
        }
    }

    public function getServicioAdicionalInfo($servicioAdicionalId)
    {
        $query = "SELECT sa.*, ts.nombre as nombre_servicio, ts.descripcion as descripcion_servicio, ts.precio as precio_servicio, 
                        p.nombres as nombre_empleado, p.apellidos as apellidos_empleado
                FROM serviciosadicionales sa
                LEFT JOIN tiposervicio ts ON sa.tipo_servicio_id = ts.tipo_servicio_id
                LEFT JOIN personal p ON sa.personal_id = p.personal_id
                WHERE sa.servicios_adicionales_id = ?";
        $stmt = mysqli_prepare($this->cn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $servicioAdicionalId);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $servicioAdicionalInfo = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            return $servicioAdicionalInfo;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
    }

    public function getAllServiciosAdicionalesInfo()
    {
        $query = "SELECT sa.servicios_adicionales_id, ts.nombre as nombre_servicio, sa.cantidad, p.nombres as nombre_personal, p.apellidos as apellidos_personal
                FROM serviciosadicionales sa
                LEFT JOIN tiposervicio ts ON sa.tipo_servicio_id = ts.tipo_servicio_id
                LEFT JOIN personal p ON sa.personal_id = p.personal_id";

        $result = mysqli_query($this->cn, $query);

        $serviciosAdicionalesInfo = array();

        while ($fila = mysqli_fetch_assoc($result)) {
            $serviciosAdicionalesInfo[] = $fila;
        }

        return $serviciosAdicionalesInfo;
    }

}
?>
