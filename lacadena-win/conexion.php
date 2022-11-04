<?php

    $username = "postgres";
    $nombreBD = "minegocio1";
    $nombreHost = "localhost";
    $passwordUsuario = "root";
    $numeroPuerto = "5432";

    $mensajeError = "No se conecto a la base de datos. Revise la configuracion: No. puerto: $numeroPuerto 
    Host: $nombreHost";

    $conexion = pg_connect("host=$nombreHost port=$numeroPuerto dbname=$nombreBD user=$username password=$passwordUsuario");
    if(!$conexion){
        echo $mensajeError;
    }
?>

