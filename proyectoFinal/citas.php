<?php
session_start();
require './Db/connection.php';

// Solo usuarios logueados
if (!isset($_SESSION['id'])) {
    header('Location: ./login.php');
    exit();
}

$id_usuario = $_SESSION['id'];

// Traer las citas del usuario logueado
$query = mysqli_query($conn, "SELECT fecha, hora, raza, nom_mascota, motivo, estado, telefono FROM citas WHERE id_usuario = $id_usuario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mis Citas</title>
  <link rel="stylesheet" href="./citas.css">
</head>
<body>

  <h1>Mis Citas</h1>

  <table id="tablaCitas">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Raza</th>
        <th>Mascota</th>
        <th>Motivo</th>
        <th>Estado</th>
        <th>Teléfono</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($cita = mysqli_fetch_array($query)) { ?>
        <tr>
          <td><?php echo $cita['fecha'] ?></td>
          <td><?php echo $cita['hora'] ?></td>
          <td><?php echo $cita['raza'] ?></td>
          <td><?php echo $cita['nom_mascota'] ?></td>
          <td><?php echo $cita['motivo'] ?></td>
          <td><?php echo $cita['estado'] ?></td>
          <td><?php echo $cita['telefono'] ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <br><br><br>
  <a class="link" href="./index.php">Volver al inicio</a>

</body>
</html>