<?php

class ClasePersonal {
    private $personal_id;
    private $nombres;
    private $apellidos;
    private $dni;
    private $correo;
    private $rol;
    private $horario_trabajo;
    private $contraseña;
    public $cn;

    function __construct($xcn) {
        $this->cn = $xcn;
    }

    function iniciarPersonal() {
        $consulta = "SELECT * FROM personal";
        $rs = mysqli_query($this->cn, $consulta);
        while ($registro = mysqli_fetch_array($rs)) {
            // Procesa cada registro aquí
            $this->personal_id = $registro[0];
            $this->nombres = $registro[1];
            $this->apellidos = $registro[2];
            $this->dni = $registro[3];
            $this->correo = $registro[4];
            $this->rol = $registro[5];
            $this->horario_trabajo = $registro[6];
            $this->contraseña = $registro[7];
        }
    }

    function getPersonalId() {
        return $this->personal_id;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getDni() {
        return $this->dni;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getRol() {
        return $this->rol;
    }

    function getHorario() {
        return $this->horario_trabajo;
    }

    function getContraseña() {
        return $this->contraseña;
    }

    function buscarPersonalPorDni($xdni) {
        $consulta = "SELECT * FROM personal WHERE dni='$xdni'";
        $rs = mysqli_query($this->cn, $consulta);
        $registro = mysqli_fetch_array($rs);
        if ($registro) {
            $this->personal_id = $registro[0];
            $this->nombres = $registro[1];
            $this->apellidos = $registro[2];
            $this->dni = $registro[3];
            $this->correo = $registro[4];
            $this->rol = $registro[5];
            $this->horario_trabajo = $registro[6];
            $this->contraseña = $registro[7];
        } else {
            echo "Personal no encontrado";
            $this->personal_id = "";
            $this->nombres = "";
            $this->apellidos = "";
            $this->dni = "";
            $this->correo = "";
            $this->rol = "";
            $this->horario_trabajo = "";
            $this->contraseña = "";
        }
    }

    function agregarPersonal($xnombres, $xapellidos, $xdni, $xcorreo, $xrol, $xhorario, $xcontraseña) {
        $sqlAgregar = "INSERT INTO personal (nombres, apellidos, dni, correo, rol, horario_trabajo, contraseña) VALUES ('$xnombres', '$xapellidos', '$xdni', '$xcorreo', '$xrol', '$xhorario', '$xcontraseña')";
        if (mysqli_query($this->cn, $sqlAgregar)) {
            echo "Personal Agregado";
        } else {
            echo "Error agregando personal";
        }
    }

    function actualizarPersonal($xdni, $xnombres, $xapellidos, $xcorreo, $xrol, $xhorario, $xcontraseña) {
        $sqlActualizar = "UPDATE personal SET nombres='$xnombres', apellidos='$xapellidos', dni='$xdni', correo='$xcorreo', rol='$xrol', horario_trabajo='$xhorario', contraseña='$xcontraseña' WHERE dni='$xdni'";
        if (mysqli_query($this->cn, $sqlActualizar)) {
            echo "Personal Actualizado";
        } else {
            echo "Error actualizando personal";
        }
    }

    function eliminarPersonal($xdni) {
        $sqlEliminar = "DELETE FROM personal WHERE dni='$xdni'";
        if (mysqli_query($this->cn, $sqlEliminar)) {
            //echo "<script>alert('personal eliminado con exito');</script>";
        } else {
            echo "Error eliminando personal";
        }
    }

    function getAllPersonal() {
        $consulta = "SELECT * FROM personal";
        $rs = mysqli_query($this->cn, $consulta);

        if ($rs && mysqli_num_rows($rs) > 0) {
            return $rs;
        } else {
            return false;
        }
    }
}

?>
