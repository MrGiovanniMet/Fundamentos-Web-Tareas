<?php
session_start();
require './Db/connection.php';

// Solo puede entrar el admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ./index.php');
    exit();
}

// Agregar horario
if (isset($_POST['agregar_horario'])) {
    $fecha = $_POST['fecha'];
    $hora  = $_POST['hora'];

    // Revisar si ese horario ya existe
    $check = mysqli_query($conn, "SELECT id FROM horarios WHERE fecha = '$fecha' AND hora = '$hora'");

    if (mysqli_num_rows($check) > 0) {
        $error = "Ya existe un horario para el $fecha a las $hora.";
    } else {
        mysqli_query($conn, "INSERT INTO horarios (fecha, hora, disponible) VALUES ('$fecha', '$hora', 1)");
        header('Location: ./admin-agregar-cita.php');
        exit();
    }
}

// Eliminar horario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM horarios WHERE id = $id");
    header('Location: ./admin-agregar-cita.php');
    exit();
}

// Traer horarios desde mañana en adelante
$manana   = date('Y-m-d', strtotime('+1 day'));
$horarios = mysqli_query($conn, "SELECT * FROM horarios WHERE fecha >= '$manana' ORDER BY fecha, hora");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <title>Admin — Horarios</title>
  <link rel="stylesheet" href="./styles3.css">
</head>
<body>
<div class="form-container">

  <h2>Agregar Horario Disponible</h2>

  <?php if (isset($error)) { ?>
    <p style="color:red;"><?php echo $error; ?></p>
  <?php } ?>

  <form method="POST">
    <div class="form-group">
      <label>Fecha</label>
      <input type="date" name="fecha" min="<?php echo $manana; ?>" required>
    </div>
    <div class="form-group">
      <label>Hora</label>
      <input type="time" name="hora" required>
    </div>
    <button type="submit" name="agregar_horario">Agregar Horario</button>
  </form>

  <h3 class="tabla-titulo">Horarios registrados</h3>
  <table class="tabla-horarios">
    <tr>
      <th>Fecha</th>
      <th>Hora</th>
      <th>Disponible</th>
      <th>Acción</th>
    </tr>
    <?php while ($h = mysqli_fetch_assoc($horarios)) { ?>
    <tr>
      <td><?php echo $h['fecha']; ?></td>
      <td><?php echo substr($h['hora'], 0, 5); ?></td>
      <td><?php echo $h['disponible'] ? 'Sí' : 'No (ocupado)'; ?></td>
      <td>
        <?php if ($h['disponible'] == 1) { ?>
          <a href="?eliminar=<?php echo $h['id']; ?>">Eliminar</a>
        <?php } else { ?>
          —
        <?php } ?>
      </td>
    </tr>
    <?php } ?>
  </table>

  <p><a class="link" href="./admin-citas.php">Volver</a></p>
</div>
</body>
</html>