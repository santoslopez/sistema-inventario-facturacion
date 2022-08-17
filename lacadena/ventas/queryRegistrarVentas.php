<?php


include '../conexion.php';


  $aaa = $_POST['tableJSON']; // 
  //$nit=json_decode($_POST['tableJSON']); NO FUNCIONO CON ESTO
  // $table = json_decode(filter_input($aaa,'tableJSON')); NO FUNCIONA

  $arrays12 = json_decode(filter_input(INPUT_POST,'tableJSON'));



  $codCliente = 1;
  $total = 1000;
  
  $consultaFactura =  "INSERT INTO FacturaVenta(codigoCliente,totalVenta) VALUES ('$codCliente','$total')";
  $ejecutarConsulta1 = pg_query($conexion,$consultaFactura);
  
  if ($ejecutarConsulta1) {
  
  
  
  }else{
      echo json_encode("invalidocliente");
  
  }
  



  $numeroDocumento=1;

  $corcheteSimple="'";
  //    $resultado='('.$corcheteSimple.$arrays12[0].$corcheteSimple.','.$corcheteSimple.$arrays12[2].$corcheteSimple.','.$corcheteSimple.$arrays12[3].$corcheteSimple.','.$corcheteSimple.$numeroDocumento.$corcheteSimple.'),';

  foreach ($arrays12 as $arrays12) {
    $resultado='('.$corcheteSimple.$arrays12[0].$corcheteSimple.','.$corcheteSimple.$arrays12[2].$corcheteSimple.','.$corcheteSimple.$arrays12[3].$corcheteSimple.','.$numeroDocumento.'),';
    $queryInsertMultipleConComa.=$resultado;
  }

  $queryInsertMultiple=rtrim($queryInsertMultipleConComa,",");
  $queryFinal=$queryInsertMultiple.';';




$consulta11 =  "INSERT INTO DetalleFacturaVenta(codigoProducto,cantidadComprado,precioCompra,numeroDocumentoFacturaVenta) VALUES $queryFinal";
$ejecutarConsultaa = pg_query($conexion,$consulta11);
if ($ejecutarConsultaa) {
  echo json_encode($consulta11);

}else{
  echo json_encode("invalido");
}





?>