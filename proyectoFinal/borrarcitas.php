<?php
// Liberar horarios y borrar citas de fechas pasadas

mysqli_query($conn, "UPDATE horarios h 
                     INNER JOIN citas c ON h.fecha = c.fecha AND h.hora = c.hora
                     SET h.disponible = 1 
                     WHERE c.fecha < CURDATE()");

mysqli_query($conn, "DELETE FROM citas WHERE fecha < CURDATE()");
?>