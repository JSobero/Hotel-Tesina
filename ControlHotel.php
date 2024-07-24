<?php
require_once("cliente/modeloClientes.php");
require_once("personal/modeloPersonal.php");
require_once("habitacion/modeloHabitacion.php");
require_once("reserva/modeloReserva.php");
require_once("serviciosAdicionales/modeloServiciosAdicionales.php");
require_once("detalle/modeloDetalle.php");
class ClaseHotel{
    public $cn;
    public $clientes;
    public $personal;
    public $habitacion;
    public $reserva;
    public $serviciosAdicionales;
    public $detalleTransaccion;
    //CONSTRUCTOR

    function __construct($db){
        $this->cn=mysqli_connect("localhost:3307","root","",$db);
        $this->clientes=new ClaseClientes($this->cn);
        $this->clientes->iniciarClientes();
        $this->personal=new ClasePersonal($this->cn);
        $this->personal->iniciarPersonal();
        $this->habitacion=new ClaseHabitacion($this->cn);
        $this->habitacion->iniciarHabitaciones();
        $this->reserva=new ClaseReserva($this->cn);
        $this->reserva->iniciarReserva();
        $this->serviciosAdicionales=new ClaseServicioAdicional($this->cn);
        $this->serviciosAdicionales->iniciarServiciosAdicionales();
        $this->detalleTransaccion=new ClaseDetalleTransaccion($this->cn);
        $this->detalleTransaccion->iniciarDetalleTransaccion();
        
    }
}
?>
