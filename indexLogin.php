<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleslogin.css">
    <title>Iniciar Sesión - Sistema de Hotel</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="login-container">
    <div class="logo-container">
        <img src="image/logo.png" alt="Logo del hotel">
    </div>
    <h2>Iniciar Sesión</h2>
    <form action="login_process.php" method="post">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>

        <button type="submit">Iniciar Sesión</button>
    </form>
</div>

</body>
</html>
