<?php
// Configuración de la base de datos
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "bd_hotel";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para consultar el número de habitaciones disponibles
function getHabitacionesDisponibles($conn) {
    $sql = "SELECT COUNT(*) AS disponibles FROM habitaciones WHERE disponibilidad = 'disponible'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['disponibles'];
}

// Función para consultar el número de habitaciones no disponibles
function getHabitacionesNoDisponibles($conn) {
    $sql = "SELECT COUNT(*) AS no_disponibles FROM habitaciones WHERE disponibilidad = 'ocupado'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['no_disponibles'];
}

// Función para consultar la cantidad de clientes
function getCantidadClientes($conn) {
    $sql = "SELECT COUNT(*) AS clientes FROM clientes";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['clientes'];
}

// Función para consultar las reservas actuales
function getReservasActuales($conn) {
    $sql = "SELECT COUNT(*) AS reservas FROM reservas WHERE fecha >= CURDATE()";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['reservas'];
}

// Obtener los datos utilizando las funciones
$habitaciones_disponibles = getHabitacionesDisponibles($conn);
$habitaciones_no_disponibles = getHabitacionesNoDisponibles($conn);
$cantidad_clientes = getCantidadClientes($conn);
$reservas_actuales = getReservasActuales($conn);

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control del Hotel</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #282c35;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #fff;
        }

        .summary {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background: #333;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            min-width: 250px;
            max-width: 350px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            align-items: center;
            gap: 15px; /* Espacio entre el icono y el texto */
        }

        .card h2 {
            margin: 0;
            font-size: 1.5em;
            color: #fff;
        }

        .card .number {
            font-size: 2.5em;
            font-weight: bold;
            color: #fff;
            margin: 10px 0;
        }

        .card p {
            margin: 0;
            color: #ddd;
        }

        .card-icon {
            font-size: 2em;
            color: #fff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .habitaciones-disponibles {
            background-color: #28a745; /* Verde */
        }

        .habitaciones-no-disponibles {
            background-color: #dc3545; /* Rojo */
        }

        .cantidad-clientes {
            background-color: #007bff; /* Azul */
        }

        .reservas-actuales {
            background-color: #17a2b8; /* Cian */
        }
    </style>
    <!-- Incluye la biblioteca de iconos FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <header>
            <h1>Panel de Control del Hotel</h1>
        </header>
        <section class="summary">
            <div class="card habitaciones-disponibles">
                <i class="card-icon fas fa-bed"></i>
                <div>
                    <h2>Habitaciones Disponibles</h2>
                    <p class="number"><?php echo $habitaciones_disponibles; ?></p>
                    <p>Actualmente hay <?php echo $habitaciones_disponibles; ?> habitaciones disponibles para reservar.</p>
                </div>
            </div>
            <div class="card habitaciones-no-disponibles">
                <i class="card-icon fas fa-bed"></i>
                <div>
                    <h2>Habitaciones No Disponibles</h2>
                    <p class="number"><?php echo $habitaciones_no_disponibles; ?></p>
                    <p>Actualmente hay <?php echo $habitaciones_no_disponibles; ?> habitaciones no disponibles.</p>
                </div>
            </div>
            <div class="card cantidad-clientes">
                <i class="card-icon fas fa-users"></i>
                <div>
                    <h2>Cantidad de Clientes</h2>
                    <p class="number"><?php echo $cantidad_clientes; ?></p>
                    <p>Total de clientes registrados en el sistema.</p>
                </div>
            </div>
            <div class="card reservas-actuales">
                <i class="card-icon fas fa-calendar-check"></i>
                <div>
                    <h2>Reservas Actuales</h2>
                    <p class="number"><?php echo $reservas_actuales; ?></p>
                    <p>Número de reservas confirmadas para hoy.</p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
