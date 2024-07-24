<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    // Obtener los datos del formulario y actualizar el cliente
    $controlHotel->clientes->actualizarCliente(
        $_POST["dniActualizar"],
        $_POST["nuevosNombres"],
        $_POST["nuevosApellidos"],
        $_POST["nuevoTelefono"]
    );
    
    // Redirigir a vistaClientes.php después de la actualización
    header("Location: ../indexHotel.php?page=clientes");
    
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

// Obtener los datos del cliente para prellenar el formulario
if (isset($_POST['dniEditar'])) {
    $dniEditar = $_POST['dniEditar'];
    $controlHotel->clientes->buscarClientePorDni($dniEditar);
} else {
    // Redirigir si no se proporciona un DNI válido
    header("Location: ../indexHotel.php?page=clientes");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesClientes.css">
</head>
<body>
    <form method="post" action="">
        <h2>Actualizar Cliente</h2>
        
        <label for="dniActualizar">DNI del Cliente a Actualizar:</label>
        <input type="text" name="dniActualizar" value="<?= $controlHotel->clientes->getDni(); ?>" readonly>

        <label for="nuevosNombres">Nuevos Nombres:</label>
        <input type="text" name="nuevosNombres" value="<?= $controlHotel->clientes->getNombres(); ?>" required>

        <label for="nuevosApellidos">Nuevos Apellidos:</label>
        <input type="text" name="nuevosApellidos" value="<?= $controlHotel->clientes->getApellidos(); ?>" required>

        <label for="nuevoTelefono">Nuevo Teléfono:</label>
        <input type="text" name="nuevoTelefono" value="<?= $controlHotel->clientes->getTelefono(); ?>" required>
        
        <button type="submit" name="actualizar">Actualizar Cliente</button>
    </form>
</body>
</html>
