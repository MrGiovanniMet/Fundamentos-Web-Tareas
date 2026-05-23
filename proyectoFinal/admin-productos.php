<?php
session_start();
require './Db/connection.php';

// Solo puede entrar el admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ./index.php');
    exit();
}

// Sumar cantidad a un producto existente
if (isset($_POST['actualizar_cantidad'])) {
    $id       = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    // cantidad = cantidad actual + lo que se ingresó
    mysqli_query($conn, "UPDATE productos SET cantidad = cantidad + $cantidad WHERE id = $id");
    header('Location: ./admin-productos.php');
    exit();
}

// Insertar nuevo producto
if (isset($_POST['agregar_producto'])) {
    $nombre      = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio      = $_POST['precio'];
    $cantidad    = $_POST['cantidad'];
    $categoria   = $_POST['categoria'];
    $imagen      = $_POST['imagen']; // url que regresa cloudinary
    mysqli_query($conn, "INSERT INTO productos (nombre, descripcion, precio, cantidad, categoria, imagen)
        VALUES ('$nombre','$descripcion','$precio','$cantidad','$categoria','$imagen')");
    header('Location: ./admin-productos.php');
    exit();
}

// Borrar producto por id
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    mysqli_query($conn, "DELETE FROM productos WHERE id = $id");
    header('Location: ./admin-productos.php');
    exit();
}

// Suma todos los totales de ventas del mes y año actual
$res_total = mysqli_query($conn, "SELECT SUM(total) AS total_mes FROM ventas WHERE MONTH(fecha) = MONTH(NOW()) AND YEAR(fecha) = YEAR(NOW())");
$row_total = mysqli_fetch_array($res_total); // convierte el resultado en arreglo
$total_mes = $row_total['total_mes'] ?? 0;   // si no hay ventas, pone 0

// Traer todos los productos ordenados por categoría
$query_productos = mysqli_query($conn, "SELECT * FROM productos ORDER BY categoria, id");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin — Productos</title>
  <link rel="stylesheet" href="./admin-productos.css">
  <script src="https://upload-widget.cloudinary.com/global/all.js"></script>
  <script src="./cloudinary.js" defer></script>
</head>

<body>
  <div class="contenedor">
    <h1>Gestión de Productos</h1>

    <p>Total vendido este mes: <strong>$<?php echo $total_mes ?></strong></p>

    <h3>Agregar Producto</h3>
    <form method="POST" class="form-agregar">
      <input type="text" name="nombre" placeholder="Nombre" required>
      <input type="text" name="descripcion" placeholder="Descripción" required>
      <input type="number" name="precio" placeholder="Precio" step="0.01" required>
      <input type="number" name="cantidad" placeholder="Cantidad" required>
      <select name="categoria" required>
        <option value="">Categoría</option>
        <option value="medicina">Medicina</option>
        <option value="comida">Comida</option>
        <option value="juguete">Juguete</option>
      </select>
      <button type="button" onclick="abrirWidget()">Subir imagen</button>
      <img id="preview" style="max-width:100px; display:none;">
      <input type="hidden" name="imagen" id="imagen_url">
      <button type="submit" name="agregar_producto">Agregar</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Categoría</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($p = mysqli_fetch_array($query_productos)) { ?>
          <tr>
            <td><img src="<?php echo $p['imagen'] ?>" class="img-producto"></td>
            <td><?php echo $p['nombre'] ?></td>
            <td><?php echo $p['descripcion'] ?></td>
            <td>$<?php echo $p['precio'] ?></td>
            <td>
              <?php echo $p['cantidad'] ?>
              <form method="POST" class="form-cantidad">
                <input type="hidden" name="id" value="<?php echo $p['id'] ?>">
                <input type="number" name="cantidad" placeholder="cantidad" min="1">
                <button type="submit" name="actualizar_cantidad">Añadir</button>
              </form>
            </td>
            <td><?php echo $p['categoria'] ?></td>
            <td><a class="link" href="./admin-productos.php?borrar=<?php echo $p['id'] ?>">Borrar</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <br>
    <a class="link" href="./index.php">Inicio</a>
  </div>
</body>

</html>