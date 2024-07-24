<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    // Obtener los datos del formulario y actualizar el cliente
    $controlHotel->personal->actualizarPersonal(
        $_POST["dniActualizar"],
        $_POST["nuevosNombres"],
        $_POST["nuevosApellidos"],
        $_POST["nuevoCorreo"],
        $_POST["nuevoRol"],
        $_POST["nuevoHorario"],
        $_POST["nuevaContraseña"],
    );
    
    // Redirigir a vistaClientes.php después de la actualización
    header("Location: ../indexHotel.php?page=personal");
    
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

// Obtener los datos del cliente para prellenar el formulario
if (isset($_POST['dniEditar'])) {
    $dniEditar = $_POST['dniEditar'];
    $controlHotel->personal->buscarPersonalPorDni($dniEditar);
} else {
    // Redirigir si no se proporciona un DNI válido
    header("Location: ../indexHotel.php?page=personal");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Personal</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesClientes.css">
</head>
<body>
    <form method="post" action="">
        <h2>Actualizar Personal</h2>
        
        <label for="dniActualizar">DNI del Personal a Actualizar:</label>
        <input type="text" name="dniActualizar" value="<?= $controlHotel->personal->getDni(); ?>" readonly>

        <label for="nuevosNombres">Nuevos Nombres:</label>
        <input type="text" name="nuevosNombres" value="<?= $controlHotel->personal->getNombres(); ?>" required>

        <label for="nuevosApellidos">Nuevos Apellidos:</label>
        <input type="text" name="nuevosApellidos" value="<?= $controlHotel->personal->getApellidos(); ?>" required>

        <label for="nuevoCorreo">Nuevo Correo:</label>
        <input type="text" name="nuevoCorreo" value="<?= $controlHotel->personal->getCorreo(); ?>" required>

        <label for="nuevoRol">Nuevo Rol:</label>
        <input type="text" name="nuevoRol" value="<?= $controlHotel->personal->getRol(); ?>" required>

        <label for="nuevoHorario">Nuevo Horario:</label>
        <input type="text" name="nuevoHorario" value="<?= $controlHotel->personal->getHorario(); ?>" required>

        <label for="nuevaContraseña">Nueva Contraseña:</label>
        <input type="text" name="nuevaContraseña" value="<?= $controlHotel->personal->getContraseña(); ?>" required>
        
        <button type="submit" name="actualizar">Actualizar Personal</button>
    </form>
</body>
</html>
