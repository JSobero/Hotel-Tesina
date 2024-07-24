<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de servicios adicionales
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    // Agregar servicio adicional
    $tipoServicioId = $_POST["tipoServicio"];
    $cantidad = $_POST["cantidad"];
    $personalId = $_POST["personal"];

    $controlHotel->serviciosAdicionales->agregarServicioAdicional($tipoServicioId, $cantidad, $personalId);
    header("Location: ../indexHotel.php?page=serviciosAdicionales");
    exit(); // Asegurar que no se ejecuten más instrucciones después de la redirección
}

// Obtener todos los tipos de servicio
$tiposServicio = $controlHotel->serviciosAdicionales->getAllTiposServicio();

// Obtener todo el personal
$personal = $controlHotel->personal->getAllPersonal();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Servicio Adicional</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesClientes.css">
</head>
<body>
    <form method="post" action="">
        <h2>Agregar Servicio Adicional</h2>
        
        <label for="tipoServicio">Tipo de Servicio:</label>
        <select name="tipoServicio" required>
            <?php
            while ($tipoServicio = $tiposServicio->fetch_assoc()) {
                echo "<option value='{$tipoServicio['tipo_servicio_id']}'>{$tipoServicio['nombre']}</option>";
            }
            ?>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" required>

        <label for="personal">Personal:</label>
        <select name="personal" required>
            <?php
            while ($persona = $personal->fetch_assoc()) {
                echo "<option value='{$persona['personal_id']}'>{$persona['nombres']} {$persona['apellidos']}</option>";
            }
            ?>
        </select>

        <button type="submit" name="agregar">Agregar Servicio Adicional</button>
    </form>
</body>
</html>
