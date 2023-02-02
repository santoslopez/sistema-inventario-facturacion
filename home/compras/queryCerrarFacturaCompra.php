<?php

include "../sesion/sesion.php";

include '../conexion.php';

$facturaCompra=pg_escape_string(htmlspecialchars($_POST['facturaCompra'],ENT_QUOTES,'UTF-8'));

//$consulta = "SELECT PA_cerrarFacturaCompra('$facturaCompra')";
$consulta = "SELECT PA_finalizarFacturaCompra('$facturaCompra')";

$ejecutarConsulta = pg_query($conexion,$consulta);

while ($row= pg_fetch_row($ejecutarConsulta)) {
  $subarray=array();
  $subarray[]=$row[0];
  echo json_encode($subarray);
}

?>