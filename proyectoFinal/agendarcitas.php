<?php
session_start();
require './Db/connection.php';

// Solo usuarios logueados
if (!isset($_SESSION['id'])) {
    header('Location: ./login.php');
    exit();
}

if($_SESSION['role'] == 'admin') {
    header('Location: ./index.php');
    exit();
} 

// Fecha seleccionada o la de hoy por defecto
if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];
} else {
    $fecha = date('Y-m-d');
}

$id_usuario = $_SESSION['id'];

// Horarios disponibles: fecha seleccionada, y que la hora no haya pasado si es hoy
$sql_horarios = "SELECT id, hora FROM horarios 
WHERE disponible = 1 
AND fecha = '$fecha'
AND ('$fecha' > CURDATE() OR ('$fecha' = CURDATE() AND hora > CURTIME()))";
$query_horarios = mysqli_query($conn, $sql_horarios);

// Guardar cita
if (isset($_POST['agendarcitas'])) {
    $fecha       = $_POST['fecha'];
    $hora_id     = $_POST['hora_id'];
    $raza        = $_POST['raza'];
    $nom_mascota = $_POST['nombre_mascota'];
    $motivo      = $_POST['motivo'];
    $estado      = 'Pendiente';
    $telefono    = $_POST['telefono'];

    // Obtener la hora real según el id del horario
    $query_hora = mysqli_query($conn, "SELECT hora FROM horarios WHERE id = $hora_id");
    $row_hora   = mysqli_fetch_array($query_hora);
    $hora       = $row_hora['hora'];

    // Insertar la cita
    mysqli_query($conn, "INSERT INTO citas (id_usuario, fecha, hora, raza, nom_mascota, motivo, estado, telefono) 
        VALUES ('$id_usuario', '$fecha', '$hora', '$raza', '$nom_mascota', '$motivo', '$estado', '$telefono')");

    // Marcar el horario como ocupado
    mysqli_query($conn, "UPDATE horarios SET disponible = 0 WHERE id = $hora_id");

    header('Location: ./citas.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Agendar Cita</title>
  <link rel="stylesheet" href="./styles3.css">
</head>
<body>
  <div class="form-container">
    <h2>Agendar Cita</h2>
    <div class="form-group">
      <p>Bienvenido, para agendar tu cita llena el siguiente formulario con los datos que pide, recuerda
        que tu primera cita es gratuita, en caso de necesitar medicamentos o tratamientos, estos tendran un precio
        pero puedes adquirirlos en nuestra tienda.
      </p>
    </div>

    <form method="GET">
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $fecha; ?>">
      </div>
      <button type="submit">Buscar horarios</button>
    </form>

    <form method="POST">
      <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">

      <div class="form-group">
        <label for="hora_id">Hora</label>
        <select id="hora_id" name="hora_id" required>
          <?php while ($horario = mysqli_fetch_array($query_horarios)) { ?>
            <option value="<?php echo $horario['id']; ?>"><?php echo $horario['hora']; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <label for="nombre_mascota">Nombre de la mascota</label>
        <input type="text" id="nombre_mascota" name="nombre_mascota" placeholder="Dr.Strange" required>
      </div>

      <div class="form-group">
        <label for="raza">Raza</label>
        <input type="text" id="raza" name="raza" placeholder="Cane Corso" required>
      </div>

      <div class="form-group">
        <label for="motivo">Motivo</label>
        <input type="text" id="motivo" name="motivo" placeholder="Picadura de animal,vomito,etc." required>
      </div>

      <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" placeholder="0123-456-789" required>
      </div>

      <button type="submit" name="agendarcitas">Agendar</button>
    </form>

    <p class="link"><a class="link" href="./citas.php">Ver citas</a></p>
    <p class="link"><a class="link" href="./index.php">Inicio</a></p>
  </div>
</body>
</html>