<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="./styles3.css">
</head>
<body>
    <div class="form-container">
        <h2>Iniciar Sesión</h2>
        <form action="./Db/login.php" method="POST">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••">
            </div>
            <button type="submit" id="btn-login">Iniciar Sesión</button>
        </form>
        <p class="link">¿No tienes cuenta? <a href="./registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>