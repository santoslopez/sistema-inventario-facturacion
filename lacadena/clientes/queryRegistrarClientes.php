<?php

  include "../sesion/sesion.php";

  include '../conexion.php';

// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$nombreEmpresa=htmlspecialchars($_POST['nombreApellidos'],ENT_QUOTES,'UTF-8');
$direccion=htmlspecialchars($_POST['direccion'],ENT_QUOTES,'UTF-8');
$nit=htmlspecialchars($_POST['nitCliente'],ENT_QUOTES,'UTF-8');
$telefono=htmlspecialchars($_POST['telefono'],ENT_QUOTES,'UTF-8');

$datosC = pg_escape_string($nombreEmpresa);
$dirC = pg_escape_string($direccion);
$nitCliente = pg_escape_string($nit);
$telC = pg_escape_string($telefono);

if(!(isset($_POST['nombreApellidos'],$_POST['direccion'],$_POST['nitCliente'],$_POST['telefono']))) {
  header('Location: ../index.php');
}else{
  $consulta = "SELECT PA_insertarCliente('$datosC','$dirC','$nitCliente','$telC')";

  $ejecutarConsulta = pg_query($conexion, $consulta);
  
  while ($row= pg_fetch_row($ejecutarConsulta)) {
    $subarray=array();
    $subarray[]=$row[0];
  }
  echo json_encode($subarray);
}

?>