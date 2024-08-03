<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de servicios adicionales
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_agregar"])) {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
</head>
<body>
    <form id="servicios-adicionales-form" method="post" action="">
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

        <button type="button" id="agregar-btn">Agregar Servicio Adicional</button>
        <button type="button" name="cancelar" class='boton-cancelar' id="cancelar-btn">Cancelar</button>
        <input type="hidden" name="confirmar_agregar">
    </form>
    <script>
    document.getElementById('agregar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        const form = document.getElementById('servicios-adicionales-form');
        if (form.checkValidity()) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas agregar este servicio adicional?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, agregar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    form.submit();
                }
            });
        } else {
            // Si los campos requeridos no son válidos, mostrar la validación del navegador
            form.reportValidity();
        }
    });

    document.getElementById('cancelar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas cancelar la operación?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, redirigir a la página de clientes
                window.location.href = "../indexHotel.php?page=serviciosAdicionales";
            }
        });
    });
    </script>
</body>
</html>
