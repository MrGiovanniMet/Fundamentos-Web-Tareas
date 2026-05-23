<?php
session_start();
require './Db/connection.php';

// Solo usuarios logueados
if (!isset($_SESSION['id'])) {
    header('Location: ./login.php');
    exit();
}

$id_usuario = $_SESSION['id'];

// Traer compras del usuario con nombre e imagen del producto
$historial = mysqli_query($conn, "SELECT v.id, p.nombre, p.imagen, v.cantidad, v.total, v.fecha
                                  FROM ventas v
                                  JOIN productos p ON v.id_producto = p.id
                                  WHERE v.id_usuario = $id_usuario
                                  ORDER BY v.fecha DESC");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="./tienda.css">
</head>

<body>
    <div class="contenedor">
        <h1>Historial de Compras</h1>

        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($v = mysqli_fetch_array($historial)) { ?>
                    <tr>
                        <td><img src="<?php echo $v['imagen'] ?>" class="img-producto"></td>
                        <td>
                            <?php echo $v['nombre'] ?>
                        </td>
                        <td>
                            <?php echo $v['cantidad'] ?>
                        </td>
                        <td>$
                            <?php echo $v['total'] ?>
                        </td>
                        <td>
                            <?php echo $v['fecha'] ?>
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