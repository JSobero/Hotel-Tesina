<?php
class ClaseHabitacion {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function iniciarHabitaciones() {
        $query = "SELECT h.*, th.nombre as nombre_tipo, th.precio as precio_tipo 
        FROM habitaciones h LEFT JOIN tipohabitacion th 
        ON h.tipo_habitacion_id = th.tipo_habitacion_id;";
    
        $resultado = mysqli_query($this->conexion, $query);
    
        $habitaciones = array();
    
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $habitaciones[] = $fila;
        }
    
        return $habitaciones;
    }    

}
?>
