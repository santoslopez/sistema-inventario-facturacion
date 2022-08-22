<?php 
  include "../sesion/sesion.php";
  include '../conexion.php';
  include '../datos/funcionesDatos.php';
   
  $obtenerNitProveedor= $_POST["id"];

  if(!(isset($_POST["id"]))) {
    header('Location: ../index.php');
  }else{
     
    $consulta = "SELECT PA_eliminarProveedor('$obtenerNitProveedor')";

    $ejecutarConsulta = pg_query($conexion,$consulta);
	
    while ($row= pg_fetch_row($ejecutarConsulta)) {
      $subarray=array();
      $subarray[]=$row[0];
      
    }
    echo json_encode($subarray);
  }
?>