
<?php

include "../sesion/sesion.php";

include '../conexion.php';


if(!(isset($_POST['nombreApellidos'],$_POST['nitCliente'],$_POST['direccion'],$_POST['telefono']) )) {
  header('Location: ../index.php');
}else{
  
// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$nombreEmpresa=htmlspecialchars($_POST['nombreApellidos'],ENT_QUOTES,'UTF-8');

$nit=htmlspecialchars($_POST['nitCliente'],ENT_QUOTES,'UTF-8');

$direccion=htmlspecialchars($_POST['direccion'],ENT_QUOTES,'UTF-8');
$telefono=htmlspecialchars($_POST['telefono'],ENT_QUOTES,'UTF-8');



  $nitEmpresa = pg_escape_string($conexion,($nit));
  $empresaNombre =  pg_escape_string($conexion,($nombreEmpresa));
  $fotoEmp = "";
  $direccionEmpresa=pg_escape_string($conexion,($direccion));
  $telefonoEmpresa = pg_escape_string($conexion,($telefono));
  
  $consulta = "SELECT PA_registrarProveedor('$nitEmpresa','$empresaNombre','$fotoEmp','$direccionEmpresa','$telefonoEmpresa')";

  $ejecutarConsulta = pg_query($conexion, $consulta);

  while ($row= pg_fetch_row($ejecutarConsulta)) {
    $subarray=array();
    $subarray[]=$row[0];
  }
  echo json_encode($subarray);
}

