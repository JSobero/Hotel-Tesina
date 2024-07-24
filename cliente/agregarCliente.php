<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    // Agregar cliente
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $dni = $_POST["dni"];
    $telefono = $_POST["telefono"];

    $controlHotel->clientes->agregarCliente($nombres, $apellidos, $dni, $telefono);
    header("Location: ../indexHotel.php?page=clientes");
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

// Obtener todos los clientes
$clientes = $controlHotel->clientes->getAllClientes();
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
        <h2>Agregar Cliente</h2>
        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required>

        <button type="submit" name="agregar">Agregar Cliente</button>
    </form>
</body>
</html>
