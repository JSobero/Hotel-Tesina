<?php
require_once("ControlHotel.php");

// Inicializar el controlador de personal
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["eliminar"])) {
        // Eliminar personal
        $dniEliminar = $_POST["dniEliminar"];
        $controlHotel->personal->eliminarPersonal($dniEliminar);
    }
}

// Obtener todo el personal si no se ha realizado una búsqueda
$personal = $controlHotel->personal->getAllPersonal();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Personal</title>
    <link rel="stylesheet" type="text/css" href="css/stylesClientes.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <h1>Personal</h1>

    <!-- Boton para agregar personal -->
    <form method="post" action="personal/agregarPersonal.php">
        <button type='button' onclick="window.location.href='personal/agregarPersonal.php';"><i class='material-icons'>add</i> Agregar Personal</button>
    </form>

    <!-- Lista de Personal -->
    <h2>Listado de Personal</h2>
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Horario</th>
                <th>Contraseña</th>
                <td>
                <th>Acciones</th>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($personal !== false) {
                while ($row = $personal->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['nombres']}</td>";
                    echo "<td>{$row['apellidos']}</td>";
                    echo "<td>{$row['dni']}</td>";
                    echo "<td>{$row['correo']}</td>";
                    echo "<td>{$row['rol']}</td>";
                    echo "<td>{$row['horario_trabajo']}</td>";
                    echo "<td>{$row['contraseña']}</td>";

                    // Botones de Editar y Eliminar
                    echo "<td>";
                    echo "<form method='post' action='personal/editarPersonal.php'>";
                    echo "<input type='hidden' name='dniEditar' value='{$row['dni']}'>";
                    echo "<button type='submit' name='editar' class='boton-editar'><i class='material-icons'>edit</i> Editar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "<td>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='dniEliminar' value='{$row['dni']}'>";
                    echo "<button type='submit' name='eliminar' class='boton-eliminar'><i class='material-icons'>delete</i> Eliminar</button>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay personal.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
