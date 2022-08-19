<?php

    $username = "postgres";
    $nombreBD = "perseverance";
    $nombreHost = "localhost";
    $passwordUsuario = "";
    $numeroPuerto = "5432";

    $mensajeError = "No se conecto a la base de datos. Revise la configuracion: No. puerto: $numeroPuerto 
    Host: $nombreHost";

    $conexion = pg_connect("host=$nombreHost port=$numeroPuerto dbname=$nombreBD user=$username");
    if(!$conexion){
        echo $mensajeError;
    }
?>

