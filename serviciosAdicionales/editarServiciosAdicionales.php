<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de servicios adicionales
$controlHotel = new ClaseHotel("bd_hotel");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_actualizar"])) {
    // Obtener los datos del formulario y actualizar el servicio adicional
    $controlHotel->serviciosAdicionales->actualizarServicioAdicional(
        $_POST["servicioAdicionalId"],
        $_POST["tipoServicio"],
        $_POST["cantidad"],
        $_POST["personal"]
    );

    // Redirigir a la página de servicios adicionales después de la actualización
    header("Location: ../indexHotel.php?page=serviciosAdicionales");
    exit();
}

// Obtener los datos del servicio adicional para prellenar el formulario
if (isset($_POST['servicioAdicionalIdEditar'])) {
    $servicioAdicionalIdEditar = $_POST['servicioAdicionalIdEditar'];
    $controlHotel->serviciosAdicionales->buscarServicioAdicionalPorId($servicioAdicionalIdEditar);
} else {
    // Redirigir si no se proporciona un ID de servicio adicional válido
    header("Location: ../indexHotel.php?page=serviciosAdicionales");
    exit();
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
    <title>Editar Servicio Adicional</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesClientes.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form id="servicios-adicionales-form" method="post" action="">
        <h2>Actualizar Servicio Adicional</h2>
        
        <label for="servicioAdicionalId">ID del Servicio Adicional:</label>
        <input type="text" name="servicioAdicionalId" value="<?= $controlHotel->serviciosAdicionales->getServicioAdicionalId(); ?>" readonly>

        <label for="tipoServicio">Tipo de Servicio:</label>
        <select name="tipoServicio" required>
            <?php
            while ($tipoServicio = $tiposServicio->fetch_assoc()) {
                $selected = ($tipoServicio['tipo_servicio_id'] == $controlHotel->serviciosAdicionales->getTipoServicioId()) ? 'selected' : '';
                echo "<option value='{$tipoServicio['tipo_servicio_id']}' $selected>{$tipoServicio['nombre']}</option>";
            }
            ?>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" value="<?= $controlHotel->serviciosAdicionales->getCantidad(); ?>" required>

        <label for="personal">Personal:</label>
        <select name="personal" required>
            <?php
            while ($persona = $personal->fetch_assoc()) {
                $selected = ($persona['personal_id'] == $controlHotel->serviciosAdicionales->getPersonalId()) ? 'selected' : '';
                echo "<option value='{$persona['personal_id']}' $selected>{$persona['nombres']} {$persona['apellidos']}</option>";
            }
            ?>
        </select>

        <button type="submit" id="actualizar-btn">Actualizar Servicio Adicional</button>
        <button type="button" name="cancelar" class='boton-cancelar' id="cancelar-btn">Cancelar</button>
        <input type="hidden" name="confirmar_actualizar">
    </form>

    <script>
        document.getElementById('actualizar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        const form = document.getElementById('servicios-adicionales-form');
        if (form.checkValidity()) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas actualizar este servicio?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, actualizar',
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
