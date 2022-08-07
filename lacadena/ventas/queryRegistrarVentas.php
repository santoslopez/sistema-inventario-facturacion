<?php


include '../conexion.php';


  $aaa = $_POST['tableJSON']; // 
  //$nit=json_decode($_POST['tableJSON']); NO FUNCIONO CON ESTO
  // $table = json_decode(filter_input($aaa,'tableJSON')); NO FUNCIONA

  $arrays12 = json_decode(filter_input(INPUT_POST,'tableJSON'));

  $numeroDocumento=1;

  $corcheteSimple="'";
  foreach ($arrays12 as $arrays12) {
    $resultado='('.$corcheteSimple.$arrays12[0].$corcheteSimple.','.$corcheteSimple.$arrays12[2].$corcheteSimple.','.$corcheteSimple.$arrays12[3].$corcheteSimple.','.$corcheteSimple.$numeroDocumento.$corcheteSimple.'),';
    $queryInsertMultipleConComa.=$resultado;
  }

  $queryInsertMultiple=rtrim($queryInsertMultipleConComa,",");
  $queryFinal=$queryInsertMultiple.';';


$codCliente = 1;
$total = 1000;

$consultaFactura =  "INSERT INTO FacturaVenta(codigoCliente,totalVenta) VALUES ('$codCliente','$total')";
$ejecutarConsulta1 = pg_query($conexion,$consultaFactura);

if ($ejecutarConsulta1) {


}else{
    echo json_encode("invalidocliente");

}


$consulta =  "INSERT INTO DetalleFacturaVenta(codigoProducto,cantidadComprado,precioCompra,numeroDocumentoFacturaVenta) VALUES $queryFinal";
$ejecutarConsulta = pg_query($conexion,$consulta);
if ($ejecutarConsulta) {
  echo json_encode($consulta);

}else{
  echo json_encode("invalido");
}



?>