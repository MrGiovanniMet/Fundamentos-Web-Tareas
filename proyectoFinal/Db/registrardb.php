<?php

// Conectar a la base de datos
require "./connection.php";

// Recibir los datos del formulario
$nombre    = $_POST['nombre'];
$email     = $_POST['email'];
$password  = $_POST['password'];
$confirmar = $_POST['confirmar'];

// Verificar que no haya campos vacíos
if (!isset($nombre) || !isset($email) || !isset($password) || !isset($confirmar)) {
    header("Location: ../registro.php?error=campos_incompletos");
    exit();
}

// Verificar que las contraseñas coincidan
if ($password !== $confirmar) {
    header("Location: ../registro.php?error=passwords_no_coinciden");
    exit();
}

// Insertar el usuario en la base de datos
$sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
$resultado = mysqli_query($conn, $sql);

// Verificar si se guardó correctamente
if ($resultado) {
    header("Location: ../login.php?mensaje=registro_exitoso");
} else {
    header("Location: ../registro.php?error=error_registro");
}

exit();
?>