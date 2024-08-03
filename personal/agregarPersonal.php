<?php
require_once("../ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar_agregar"])) {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../image/logo.png" type="image/x-icon">
</head>
<body>
    <form id="personal-form" method="post" action="">
        <h2>Agregar Personal</h2>
        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" maxlength="8" required>

        <label for="correo">Correo:</label>
        <input type="text" name="correo" required>

        <label for="rol">Rol:</label>
        <input type="text" name="rol" required>

        <label for="horario_trabajo">Horario:</label>
        <input type="text" name="horario_trabajo"  required>

        <label for="contraseña">Contraseña:</label>
        <input type="text" name="contraseña" maxlength="6" required>

        <button type="submit" id="agregar-btn">Agregar Personal</button>
        <button type="button" name="cancelar" class='boton-cancelar' id="cancelar-btn">Cancelar</button>
        <input type="hidden" name="confirmar_agregar">
    </form>
    <script>
    document.getElementById('agregar-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevenir la acción por defecto

        const form = document.getElementById('personal-form');
        if (form.checkValidity()) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas agregar este personal?",
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
                window.location.href = "../indexHotel.php?page=personal";
            }
        });
    });
    </script>
</body>
</html>
