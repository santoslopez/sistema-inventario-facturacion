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
    if ($ejecutarConsultaa && $ejecutarConsulta1) {
      echo json_encode("ventaregistrado");
    }else{
      echo json_encode("ventanoregistrado");
    }
    
?>