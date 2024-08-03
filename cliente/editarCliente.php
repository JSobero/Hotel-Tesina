<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_actualizar"])) {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
</head>
<body>
    <form id="cliente-form" method="post" action="">
        <h2>Actualizar Cliente</h2>
        
        <label for="dniActualizar">DNI del Cliente a Actualizar:</label>
        <input type="text" name="dniActualizar" value="<?= $controlHotel->clientes->getDni(); ?>" readonly>

        <label for="nuevosNombres">Nuevos Nombres:</label>
        <input type="text" name="nuevosNombres" value="<?= $controlHotel->clientes->getNombres(); ?>" required>

        <label for="nuevosApellidos">Nuevos Apellidos:</label>
        <input type="text" name="nuevosApellidos" value="<?= $controlHotel->clientes->getApellidos(); ?>" required>

        <label for="nuevoTelefono">Nuevo Teléfono:</label>
        <input type="text" name="nuevoTelefono" maxlength="9" pattern="\d{9}" title="El telefono debe contener exactamente 9 números." value="<?= $controlHotel->clientes->getTelefono(); ?>" required>
        
        <button type="submit" id="actualizar-btn">Actualizar Cliente</button>
        <button type="button" name="cancelar" class='boton-cancelar' id="cancelar-btn">Cancelar</button>
        <input type="hidden" name="confirmar_actualizar">
    </form>

    <script>
        document.getElementById('actualizar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        const form = document.getElementById('cliente-form');
        if (form.checkValidity()) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas actualizar este cliente?",
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
                window.location.href = "../indexHotel.php?page=clientes";
            }
        });
    });
    </script>
</body>
</html>
