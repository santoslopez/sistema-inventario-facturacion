<?php
  session_start();
  //Sino hemos iniciado sesion indicamos la ruta por defecto
  if(!(isset($_SESSION['rolUsuario']))){
	  // ruta por default
    header('Location: ../index.php');
  }
?>
