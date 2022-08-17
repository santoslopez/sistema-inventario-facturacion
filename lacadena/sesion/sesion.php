<?php
  session_set_cookie_params(60*60*24*1); // 1 día

  session_start();
  //Sino hemos iniciado sesion indicamos la ruta por defecto
  if(!(isset($_SESSION['rolUsuario']))){
	  // ruta por default
    header('Location: ../index.php');
  }
?>
