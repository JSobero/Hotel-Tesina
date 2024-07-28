<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_actualizar"])) {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form id="personal-form" method="post" action="">
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
        <input type="text" name="nuevaContraseña" maxlength="6" value="<?= $controlHotel->personal->getContraseña(); ?>" required>
        
        <button type="submit" id="actualizar-btn">Actualizar Personal</button>
        <button type="button" name="cancelar" class='boton-cancelar' id="cancelar-btn">Cancelar</button>
        <input type="hidden" name="confirmar_actualizar">
    </form>
    <script>
        document.getElementById('actualizar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        const form = document.getElementById('personal-form');
        if (form.checkValidity()) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas actualizar este personal?",
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
                window.location.href = "../indexHotel.php?page=personal";
            }
        });
    });
    </script>
</body>
</html>
