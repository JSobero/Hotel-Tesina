<?php

class ClaseClientes {
    private $clientes_id;
    private $nombres;
    private $apellidos;
    private $dni;
    private $telefono;
    public $cn;

    function __construct($xcn) {
        $this->cn = $xcn;
    }

    function iniciarClientes() {
        $consulta = "SELECT * FROM clientes";
        $rs = mysqli_query($this->cn, $consulta);
        while ($registro = mysqli_fetch_array($rs)) {
            // Procesa cada registro aquí
            $this->clientes_id = $registro[0];
            $this->nombres = $registro[1];
            $this->apellidos = $registro[2];
            $this->dni = $registro[3];
            $this->telefono = $registro[4];
        }
    }

    function getClientesId() {
        return $this->clientes_id;
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

    function getTelefono() {
        return $this->telefono;
    }

    function buscarClientePorDni($xdni) {
        $consulta = "SELECT * FROM clientes WHERE dni='$xdni'";
        $rs = mysqli_query($this->cn, $consulta);
        $registro = mysqli_fetch_array($rs);
        if ($registro) {
            $this->clientes_id = $registro[0];
            $this->nombres = $registro[1];
            $this->apellidos = $registro[2];
            $this->dni = $registro[3];
            $this->telefono = $registro[4];
        } else {
            echo "Cliente no encontrado";
            $this->clientes_id = "";
            $this->nombres = "";
            $this->apellidos = "";
            $this->dni = "";
            $this->telefono = "";
        }
    }

    function agregarCliente($xnombres, $xapellidos, $xdni, $xtelefono) {
        $sqlAgregar = "INSERT INTO clientes (nombres, apellidos, dni, telefono) VALUES ('$xnombres', '$xapellidos', '$xdni', '$xtelefono')";
        if (mysqli_query($this->cn, $sqlAgregar)) {
            echo "Cliente Agregado";
        } else {
            echo "Error agregando cliente";
        }
    }

    function actualizarCliente($xdni, $xnombres, $xapellidos, $xtelefono) {
        $sqlActualizar = "UPDATE clientes SET nombres='$xnombres', apellidos='$xapellidos', telefono='$xtelefono' WHERE dni='$xdni'";
        if (mysqli_query($this->cn, $sqlActualizar)) {
            echo "Cliente Actualizado";
        } else {
            echo "Error actualizando cliente";
        }
    }

    function eliminarCliente($xdni) {
        $sqlEliminar = "DELETE FROM clientes WHERE dni='$xdni'";
        if (mysqli_query($this->cn, $sqlEliminar)) {
            //echo "<script>alert('Cliente eliminado con exito');</script>";
        } else {
            echo "Error eliminando cliente";
        }
    }

    function getAllClientes() {
        $consulta = "SELECT * FROM clientes";
        $rs = mysqli_query($this->cn, $consulta);

        if ($rs && mysqli_num_rows($rs) > 0) {
            return $rs;
        } else {
            return false;
        }
    }

    

    public function getClienteInfo($clienteId)
    {
        $query = "SELECT * FROM clientes WHERE clientes_id = ?";
        $stmt = mysqli_prepare($this->cn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $clienteId);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $clienteInfo = mysqli_fetch_assoc($result);

            mysqli_stmt_close($stmt);

            return $clienteInfo;
        } else {
            // Manejar el error de preparación de la consulta
            return false;
        }
    }

}

?>
