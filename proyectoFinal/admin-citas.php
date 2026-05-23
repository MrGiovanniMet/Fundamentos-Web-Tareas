<?php
session_start();
require './Db/connection.php';
require './borrarcitas.php';

// Solo puede entrar el admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ./index.php');
    exit();
}

// Borrar cita
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];

    // Liberar el horario y borrar la cita
    mysqli_query($conn, "UPDATE horarios h
                         INNER JOIN citas c ON h.fecha = c.fecha AND h.hora = c.hora
                         SET h.disponible = 1
                         WHERE c.id = $id");

    mysqli_query($conn, "DELETE FROM citas WHERE id = $id");

    header('Location: ./admin-citas.php');
    exit();
}

// Traer todas las citas con el email del usuario
$sql   = "SELECT citas.id, citas.fecha, citas.hora, citas.raza, citas.nom_mascota, citas.motivo, citas.estado, citas.telefono, usuarios.email 
          FROM citas INNER JOIN usuarios ON citas.id_usuario = usuarios.id";
$query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Citas</title>
  <link rel="stylesheet" href="./citas.css">
</head>

<body>
  <div class="contenedor">
    <h1>Todas las Citas</h1>
    <a class="link" href="./admin-agregar-cita.php">+ Agregar Cita</a>
    <table>
      <thead>
        <tr>
          <th>Email</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Mascota</th>
          <th>Raza</th>
          <th>Motivo</th>
          <th>Estado</th>
          <th>Telefono</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($cita = mysqli_fetch_array($query)) { ?>
          <tr>
            <td><?php echo $cita['email']; ?></td>
            <td><?php echo $cita['fecha']; ?></td>
            <td><?php echo $cita['hora']; ?></td>
            <td><?php echo $cita['nom_mascota']; ?></td>
            <td><?php echo $cita['raza']; ?></td>
            <td><?php echo $cita['motivo']; ?></td>
            <td>
              <?php echo $cita['estado']; ?>
              <a class="link" href="./editarcita.php?id=<?php echo $cita['id']; ?>">Editar</a>
              <a class="link" href="./admin-citas.php?borrar=<?php echo $cita['id']; ?>">Borrar</a>
            </td>
            <td><?php echo $cita['telefono']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <br><br><br>
    <a class="link" href="./index.php">Volver al inicio</a>
  </div>
</body>

</html>