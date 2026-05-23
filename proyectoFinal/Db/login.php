<?php
session_start();
require "./connection.php";

if (!isset($_POST["email"]) || !isset($_POST["password"]))
{
    header("Location: ../login.php?error=Faltan datos");
    return;
}

$email= $_POST["email"];
$password= $_POST["password"];

$sql = "SELECT COUNT(*) as login, role, id FROM usuarios WHERE email='$email' AND password='$password'";

$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_array($query);

if ($result['login'] > 0)
{
   $_SESSION["email"] = $email;
   $_SESSION["role"] = $result["role"];
   $_SESSION["id"] = $result["id"];
    header("Location: ../index.php");
}
else
{
    header("Location: ../login.php?error=Usuario o contraseña incorrectos");
}
?>

