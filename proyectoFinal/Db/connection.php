<?php

// necesito un par para host y usuario para la bd

    $host = "localhost"; //servidor local
    $user ="root" ; //usario para entrar admin root 
    $password = "";   
    $dbname = "veterinaria"; //nombre de la base de datos
    

    $conn= mysqli_connect($host, $user, $password, $dbname);
?>

