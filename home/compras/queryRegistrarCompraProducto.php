<?php

include "../sesion/sesion.php";

include '../conexion.php';

// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$inputCostoProducto=floatval(htmlspecialchars($_POST['inputCostoProducto'],ENT_QUOTES,'UTF-8'));
$inputCantidadCompra=intval(htmlspecialchars($_POST['inputCantidadCompra'],ENT_QUOTES,'UTF-8'));
$inputCodigoProducto=pg_escape_string(htmlspecialchars($_POST['inputCodigoProducto'],ENT_QUOTES,'UTF-8'));

$facturaCompra=pg_escape_string(htmlspecialchars($_POST['facturaCompra'],ENT_QUOTES,'UTF-8'));

$consulta = "SELECT PA_insertarDetalleFacturaCompra('$facturaCompra','$inputCostoProducto',$inputCantidadCompra,'$inputCodigoProducto')";


$ejecutarConsulta = pg_query($conexion,$consulta);

while ($row= pg_fetch_row($ejecutarConsulta)) {
  $subarray=array();
  $subarray[]=$row[0];
  echo json_encode($subarray);
}


?>