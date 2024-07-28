<?php
require_once("ControlHotel.php");

// Inicializar el controlador de servicios adicionales
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["eliminar"])) {
        // Eliminar servicio adicional
        $servicioAdicionalIdEliminar = $_POST["servicioAdicionalIdEliminar"];
        $controlHotel->serviciosAdicionales->eliminarServicioAdicional($servicioAdicionalIdEliminar);
    }
}

// Obtener todos los servicios adicionales
$serviciosAdicionales = $controlHotel->serviciosAdicionales->getAllServicioAdicional();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Servicios Adicionales</title>
    <link rel="stylesheet" type="text/css" href="css/stylesClientes.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Servicios Adicionales</h1>

    <!-- Boton para agregar servicio adicional -->
    <form method="post" action="serviciosAdicionales/agregarServiciosAdicionales.php">
        <button type='button' onclick="window.location.href='serviciosAdicionales/agregarServiciosAdicionales.php';">
            <i class='material-icons'>add</i> Agregar Servicio Adicional
        </button>
    </form>

    <!-- Lista de Servicios Adicionales -->
    <h2>Listado de Servicios Adicionales</h2>
    <table>
        <thead>
            <tr>
                <th>Tipo de Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Personal</th>
                <td>
                <th>Acciones</th>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($serviciosAdicionales !== false) {
                foreach ($serviciosAdicionales as $servicioAdicional) {
                    echo "<tr>";
                    // Obtener información de tipo de servicio
                    $tipoServicioInfo = $controlHotel->serviciosAdicionales->getTipoServicioInfo($servicioAdicional['tipo_servicio_id']);
                    echo "<td>{$tipoServicioInfo['nombre']}</td>";

                    echo "<td>{$servicioAdicional['cantidad']}</td>";

                    // Obtener información de precio del servicio
                    $precioServicio = $tipoServicioInfo['precio'];
                    echo "<td>{$precioServicio}</td>";

                    // Calcular y mostrar el subtotal
                    $subtotal = $precioServicio * $servicioAdicional['cantidad'];
                    echo "<td>{$subtotal}</td>";

                    // Obtener información de personal
                    $personalInfo = $controlHotel->serviciosAdicionales->getPersonalInfo($servicioAdicional['personal_id']);
                    echo "<td>{$personalInfo['nombres']} {$personalInfo['apellidos']}</td>";

                    // Botones de Editar y Eliminar
                    echo "<td>";

                    echo "<form method='post' action='serviciosAdicionales/editarserviciosAdicionales.php'>";
                    echo "<input type='hidden' name='servicioAdicionalIdEditar' value='{$servicioAdicional['servicios_adicionales_id']}'>";
                    echo "<button type='submit' name='editar' class='boton-editar'><i class='material-icons'>edit</i> Editar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td>";
                    echo "<form method='post' action='' class='form-eliminar'>";
                    echo "<input type='hidden' name='servicioAdicionalIdEliminar' value='{$servicioAdicional['servicios_adicionales_id']}'>";
                    echo "<button type='button' class='boton-eliminar' onclick='confirmarEliminacion(this)'><i class='material-icons'>delete</i> Eliminar</button>";
                    echo "</form>";

                    

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay servicios adicionales.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    function confirmarEliminacion(button) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas eliminar este servicio?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviar el formulario
                const form = button.closest('form');
                form.insertAdjacentHTML('beforeend', '<input type="hidden" name="eliminar" value="1">');
                form.submit();
            }
        });
    }
    </script>
</body>
</html>
