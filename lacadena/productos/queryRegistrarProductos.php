
<?php

include "../sesion/sesion.php";

include '../conexion.php';

// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$codigoProducto=htmlspecialchars($_POST['inputCodigoProducto'],ENT_QUOTES,'UTF-8');
$descripcionProducto=htmlspecialchars($_POST['inputNombreProducto'],ENT_QUOTES,'UTF-8');


if(!(isset($_POST['inputCodigoProducto'],$_POST['inputNombreProducto']))) {
  header('Location: ../index.php');
}else{
  $cod = pg_escape_string($codigoProducto);
  $des = pg_escape_string($descripcionProducto);
  $imagen = "default.png";
  
  $consulta = "SELECT PA_insertarProducto('$cod','$des','$imagen')";

  $ejecutarConsulta = pg_query($conexion, $consulta);
  $data = array();
  while ($row= pg_fetch_row($ejecutarConsulta)) {
    $subarray=array();
    $subarray[]=$row[0];
  }
  echo json_encode($subarray);

}

?>