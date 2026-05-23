<?php
session_start();
require './Db/connection.php';

// Solo usuarios logueados
if (!isset($_SESSION['id'])) {
    header('Location: ./login.php');
    exit();
}

// Si no existe el carrito en sesión, lo crea vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if (isset($_POST['agregar'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad    = $_POST['cantidad'];

    // Ejecuta la consulta y busca el producto verificando que haya stock suficiente
    $res  = mysqli_query($conn, "SELECT * FROM productos WHERE id = $id_producto AND cantidad >= $cantidad");
    $prod = mysqli_fetch_array($res); // convierte el resultado en arreglo para usarlo

    if ($prod) {
        // Si el producto ya está en el carrito, suma la cantidad
        if (isset($_SESSION['carrito'][$id_producto])) {
            $nueva = $_SESSION['carrito'][$id_producto]['cantidad'] + $cantidad;
            if ($nueva <= $prod['cantidad']) {
                $_SESSION['carrito'][$id_producto]['cantidad'] = $nueva;
                $_SESSION['carrito'][$id_producto]['subtotal'] = $prod['precio'] * $nueva;
            } else {
                $mensaje = "No hay suficiente stock para agregar más de " . $prod['nombre'] . ".";
            }
        } else {
            // Si no está, lo agrega como nuevo al carrito
            $_SESSION['carrito'][$id_producto] = [
                'id'       => $id_producto,
                'nombre'   => $prod['nombre'],
                'precio'   => $prod['precio'],
                'imagen'   => $prod['imagen'],
                'cantidad' => $cantidad,
                'subtotal' => $prod['precio'] * $cantidad,
            ];
        }
        if (!isset($mensaje)) $mensaje = $prod['nombre'] . " agregado al carrito.";
    } else {
        $mensaje = "Cantidad insuficiente en stock.";
    }
}

// Quitar producto del carrito
if (isset($_POST['quitar'])) {
    $id = $_POST['id_producto'];
    unset($_SESSION['carrito'][$id]); // elimina ese producto del arreglo de sesión
    $mensaje = "Producto eliminado del carrito.";
}

// Confirmar compra y registrar cada venta
if (isset($_POST['confirmar']) && !empty($_SESSION['carrito'])) {
    $id_usuario = $_SESSION['id'];

    // Recorre cada producto del carrito
    foreach ($_SESSION['carrito'] as $item) {
        $id_prod = $item['id'];
        $cant    = $item['cantidad'];

        // Verifica stock antes de registrar la venta
        $res  = mysqli_query($conn, "SELECT * FROM productos WHERE id = $id_prod AND cantidad >= $cant");
        $prod = mysqli_fetch_array($res); // convierte el resultado en arreglo para usarlo

        if ($prod) {
            $total = $prod['precio'] * $cant;
            // Registra la venta en la tabla ventas
            mysqli_query($conn, "INSERT INTO ventas (id_usuario, id_producto, cantidad, total, fecha)
                                 VALUES ('$id_usuario','$id_prod','$cant','$total', NOW())");
            // Descuenta del stock la cantidad comprada
            mysqli_query($conn, "UPDATE productos SET cantidad = cantidad - $cant WHERE id = $id_prod");
        }
    }

    $_SESSION['carrito'] = []; // vacía el carrito al terminar
    $mensaje = "Compra confirmada con éxito.";
}

// Traer productos por categoría con stock disponible
$medicinas = mysqli_query($conn, "SELECT * FROM productos WHERE categoria = 'medicina' AND cantidad > 0");
$comidas   = mysqli_query($conn, "SELECT * FROM productos WHERE categoria = 'comida'   AND cantidad > 0");
$juguetes  = mysqli_query($conn, "SELECT * FROM productos WHERE categoria = 'juguete'  AND cantidad > 0");

// Suma todos los subtotales del carrito para mostrar el total
$total_carrito = array_sum(array_column($_SESSION['carrito'], 'subtotal'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tienda</title>
  <link rel="stylesheet" href="./tienda.css">
</head>
<body>
<div class="contenedor">
  <h1>Tienda</h1>

  <?php if (isset($mensaje)) { ?>
    <p class="mensaje"><?php echo $mensaje ?></p>
  <?php } ?>

  <h2>🛒 Carrito</h2>
  <?php if (empty($_SESSION['carrito'])) { ?>
    <p>Tu carrito está vacío.</p>
  <?php } else { ?>
    <table>
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th>Quitar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['carrito'] as $item) { ?>
          <tr>
            <td><?php echo $item['nombre'] ?></td>
            <td>$<?php echo $item['precio'] ?></td>
            <td><?php echo $item['cantidad'] ?></td>
            <td>$<?php echo $item['subtotal'] ?></td>
            <td>
              <form method="POST" class="form-comprar">
                <input type="hidden" name="id_producto" value="<?php echo $item['id'] ?>">
                <button type="submit" name="quitar">Quitar</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <p><strong>Total a pagar: $<?php echo $total_carrito ?></strong></p>
    <form method="POST">
      <button type="submit" name="confirmar">Confirmar compra</button>
    </form>
  <?php } ?>

  <h2>Medicinas</h2>
  <table>
    <thead>
      <tr>
        <th>Imagen</th><th>Producto</th><th>Descripción</th><th>Precio</th><th>Cantidad</th><th>Comprar</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($p = mysqli_fetch_array($medicinas)) { ?>
        <tr>
          <td><img src="<?php echo $p['imagen'] ?>" class="img-producto"></td>
          <td><?php echo $p['nombre'] ?></td>
          <td><?php echo $p['descripcion'] ?></td>
          <td>$<?php echo $p['precio'] ?></td>
          <td><?php echo $p['cantidad'] ?></td>
          <td>
            <form method="POST" class="form-comprar">
              <input type="hidden" name="id_producto" value="<?php echo $p['id'] ?>">
              <input type="number" name="cantidad" value="1" min="1" max="<?php echo $p['cantidad'] ?>" class="input-cantidad">
              <button type="submit" name="agregar">Agregar al carrito</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <h2>Comidas</h2>
  <table>
    <thead>
      <tr>
        <th>Imagen</th><th>Producto</th><th>Descripción</th><th>Precio</th><th>Cantidad</th><th>Comprar</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($p = mysqli_fetch_array($comidas)) { ?>
        <tr>
          <td><img src="<?php echo $p['imagen'] ?>" class="img-producto"></td>
          <td><?php echo $p['nombre'] ?></td>
          <td><?php echo $p['descripcion'] ?></td>
          <td>$<?php echo $p['precio'] ?></td>
          <td><?php echo $p['cantidad'] ?></td>
          <td>
            <form method="POST" class="form-comprar">
              <input type="hidden" name="id_producto" value="<?php echo $p['id'] ?>">
              <input type="number" name="cantidad" value="1" min="1" max="<?php echo $p['cantidad'] ?>" class="input-cantidad">
              <button type="submit" name="agregar">Agregar al carrito</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <h2>Juguetes</h2>
  <table>
    <thead>
      <tr>
        <th>Imagen</th><th>Producto</th><th>Descripción</th><th>Precio</th><th>Cantidad</th><th>Comprar</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($p = mysqli_fetch_array($juguetes)) { ?>
        <tr>
          <td><img src="<?php echo $p['imagen'] ?>" class="img-producto"></td>
          <td><?php echo $p['nombre'] ?></td>
          <td><?php echo $p['descripcion'] ?></td>
          <td>$<?php echo $p['precio'] ?></td>
          <td><?php echo $p['cantidad'] ?></td>
          <td>
            <form method="POST" class="form-comprar">
              <input type="hidden" name="id_producto" value="<?php echo $p['id'] ?>">
              <input type="number" name="cantidad" value="1" min="1" max="<?php echo $p['cantidad'] ?>" class="input-cantidad">
              <button type="submit" name="agregar">Agregar al carrito</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <br>
  <a class="link" href="./index.php">Inicio</a>
</div>
</body>
</html>