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
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];
    $horario_trabajo = $_POST["horario_trabajo"];
    $contraseña = $_POST["contraseña"];

    $controlHotel->personal->agregarPersonal($nombres, $apellidos, $dni, $correo, $rol, $horario_trabajo, $contraseña);
    header("Location: ../indexHotel.php?page=personal");
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

// Obtener todos los clientes
$personal = $controlHotel->personal->getAllPersonal();
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
        <h2>Agregar Personal</h2>
        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" required>

        <label for="correo">Correo:</label>
        <input type="text" name="correo" required>

        <label for="rol">Rol:</label>
        <input type="text" name="rol" required>

        <label for="horario_trabajo">Horario:</label>
        <input type="text" name="horario_trabajo" required>

        <label for="contraseña">Contraseña:</label>
        <input type="text" name="contraseña" required>

        <button type="submit" name="agregar">Agregar Personal</button>
    </form>
</body>
</html>
