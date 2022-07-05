<?php
  session_start();
  //Sino hemos iniciado sesion indicamos la ruta por defecto
  if(empty($_SESSION['nombreUsuario'])){
	  // ruta por default
	  header('Location: index.php');
    exit;
  }
?>
