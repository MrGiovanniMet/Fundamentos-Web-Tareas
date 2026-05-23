<?php
session_start();
require './Db/connection.php';

// Solo puede entrar el admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ./index.php');
    exit();
}

// Actualizar estado de la cita
if (isset($_POST['actualizar'])) {
    $id_cita = $_POST['id_cita'];
    $estado  = $_POST['estado'];
    mysqli_query($conn, "UPDATE citas SET estado = '$estado' WHERE id = $id_cita");
    header('Location: ./admin-citas.php');
    exit();
}

// Traer la cita a editar
$id_cita = $_GET['id'];
$cita    = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM citas WHERE id = $id_cita"));
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Editar Cita</title>
  <link rel="stylesheet" href="./styles3.css">
</head>
<body>
  <div class="form-container">
    <h2>Editar Estado de Cita</h2>

    <form method="POST">
      <input type="hidden" name="id_cita" value="<?php echo $cita['id']; ?>">

      <div class="form-group">
        <label>UsuarioId</label>
        <input type="text" value="<?php echo $cita['id_usuario']; ?>" readonly>
      </div>

      <div class="form-group">
        <label>Fecha</label>
        <input type="text" value="<?php echo $cita['fecha']; ?>" readonly>
      </div>

      <div class="form-group">
        <label>Mascota</label>
        <input type="text" value="<?php echo $cita['nom_mascota']; ?>" readonly>
      </div>

      <div class="form-group">
        <label for="estado">Estado</label>
        <select id="estado" name="estado">
          <option value="Pendiente" <?php echo $cita['estado'] == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
          <option value="Aceptada"  <?php echo $cita['estado'] == 'Aceptada'  ? 'selected' : ''; ?>>Aceptada</option>
          <option value="Cancelada" <?php echo $cita['estado'] == 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
        </select>
      </div>

      <button type="submit" name="actualizar">Guardar</button>
    </form>

    <p class="link"><a href="./admin-citas.php">Volver</a></p>
  </div>
</body>
</html>