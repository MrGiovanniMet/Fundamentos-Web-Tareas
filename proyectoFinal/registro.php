
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>


    <link rel="stylesheet" href="./styles3.css">
    <style>
        body {
            background-image: url("./imagenes/puppy-tips-experts.jpg");
        }
    </style>


</head>

<body>
    <div class="form-container">
    <h2>Crear Cuenta</h2>

    <form method="POST" action="./Db/registrardb.php">

        <div class="form-group">
            <label for="nombre">Nombre completo</label>
            <input type="text" name="nombre" id="nombre" placeholder="Tu nombre">
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" placeholder="ejemplo@correo.com">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="confirmar">Confirmar contraseña</label>
            <input type="password" name="confirmar" id="confirmar" placeholder="••••••••">
        </div>

        <button type="submit" id="btn-registro">Registrarse</button>

    </form>

    <p >Por favor completa todos los campos</p>
    <p class="link">¿Ya tienes cuenta? <a href="./login.php">Inicia sesión aquí</a></p>
</div>
    

</body>

</html>


