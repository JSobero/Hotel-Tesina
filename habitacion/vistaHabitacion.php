<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Habitaciones</title>
    <link rel="stylesheet" type="text/css" href="css/stylesClientes.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Lista de Habitaciones</h1>

    <?php
    require_once("ControlHotel.php");
    $controlHotel = new ClaseHotel("bd_hotel");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar si se recibió el identificador de la habitación
        if (isset($_POST['habitacion_id'])) {
            $habitacion_id = $_POST['habitacion_id'];

            // Realizar la lógica para cambiar la disponibilidad
            // (Este es solo un ejemplo, debes adaptarlo según tu estructura y necesidades)
            // Supongamos que la columna de disponibilidad en la base de datos es un ENUM('disponible', 'ocupado')

            $consulta = "SELECT disponibilidad FROM habitaciones WHERE habitaciones_id = $habitacion_id";
            $resultado = mysqli_query($controlHotel->cn, $consulta);

            if ($fila = mysqli_fetch_assoc($resultado)) {
                $nueva_disponibilidad = ($fila['disponibilidad'] == 'disponible') ? 'ocupado' : 'disponible';

                $update_query = "UPDATE habitaciones SET disponibilidad = '$nueva_disponibilidad' WHERE habitaciones_id = $habitacion_id";
                mysqli_query($controlHotel->cn, $update_query);
            }
        }
    }

    // Obtener las habitaciones después de la actualización
    $habitaciones = $controlHotel->habitacion->iniciarHabitaciones();
    ?>

    <?php foreach ($habitaciones as $habitacion) : ?>
        <div class="habitacion-card" style="
            <?php
                // Establecer el color de fondo según la disponibilidad
                echo ($habitacion['disponibilidad'] == 'disponible') ? 'background-color: #8CE88C;' : 'background-color: #FF6F6F;';
            ?>
        ">
            <h2>Habitación <?php echo $habitacion['numero_habitacion']; ?></h2>
            <p>Tipo: <?php echo $habitacion['nombre_tipo']; ?></p>
            <p>Precio: S/.<?php echo $habitacion['precio_tipo']; ?></p>
            <p>Disponibilidad: <?php echo $habitacion['disponibilidad']; ?></p>
            
            <!-- Botón Cambiar Disponibilidad -->
            <form action="indexHotel.php?page=habitacion" method="post" class="form-cambiar-disponibilidad">
                <input type="hidden" name="habitacion_id" value="<?php echo $habitacion['habitaciones_id']; ?>">
                <button type="button" onclick="confirmarCambioDisponibilidad(this)">Cambiar Disponibilidad</button>
            </form>
        </div>
    <?php endforeach; ?>

    <script>
        function confirmarCambioDisponibilidad(button) {
            Swal.fire({
                title: '¿Cambiar Disponibilidad?',
                text: "¿Estás seguro de que deseas cambiar la disponibilidad de esta habitación?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    const form = button.closest('form');
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
