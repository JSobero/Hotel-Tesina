<?php
require_once("ControlHotel.php");

// Inicializar el controlador de clientes
$controlHotel = new ClaseHotel("bd_hotel");

// Lógica del controlador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["eliminar"])) {
        // Eliminar cliente
        $dniEliminar = $_POST["dniEliminar"];
        $controlHotel->clientes->eliminarCliente($dniEliminar);
    }
}

// Obtener todos los clientes si no se ha realizado una búsqueda
$clientes = $controlHotel->clientes->getAllClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Clientes</title>
    <link rel="stylesheet" type="text/css" href="css/stylesClientes.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <h1>Clientes</h1>

    <!-- Boton para agregar cliente -->
    <form method="post" action="cliente/agregarCliente.php">
        <button type='button' onclick="window.location.href='cliente/agregarCliente.php';"><i class='material-icons'>add</i> Agregar Cliente</button>
    </form>

    <!-- Lista de Clientes -->
    <h2>Listado de Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <td>
                <th>Acciones</th>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($clientes !== false) {
                while ($row = $clientes->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['nombres']}</td>";
                    echo "<td>{$row['apellidos']}</td>";
                    echo "<td>{$row['dni']}</td>";
                    echo "<td>{$row['telefono']}</td>";

                    // Botones de Editar y Eliminar
                    echo "<td>";
                    echo "<form method='post' action='cliente/editarCliente.php'>";
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
                echo "<tr><td colspan='6'>No hay clientes.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
