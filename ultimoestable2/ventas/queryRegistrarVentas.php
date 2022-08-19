<?php

  include '../conexion.php';

  $arraysTabla = json_decode(filter_input(INPUT_POST,'tableJSON'));

  $codCliente = 1;
  $total = 1000;
  
  $consultaFactura =  "INSERT INTO FacturaVenta(codigoCliente,totalVenta) VALUES ('$codCliente','$total')";
  $ejecutarConsulta1 = pg_query($conexion,$consultaFactura);


  $numeroDocumento=7;

  $corcheteSimple="'";

  foreach ($arraysTabla as $columna) {
    $resultado='('.$corcheteSimple.$columna[0].$corcheteSimple.','.$columna[2].','.$columna[3].','.$numeroDocumento.'),';
    $queryInsertMultipleConComa.=$resultado;
  }

  $queryInsertMultiple=rtrim($queryInsertMultipleConComa,",");
  $queryFinal=$queryInsertMultiple.';';

  $consulta11 =  "INSERT INTO DetalleFacturaVenta(codigoProducto,cantidadComprado,precioCompra,numeroDocumentoFacturaVenta) VALUES $queryFinal";
  $ejecutarConsultaa = pg_query($conexion,$consulta11);


  if ($ejecutarConsulta1 && $ejecutarConsultaa) {
    echo json_encode("ventaregistrado");
  }else{
    echo json_encode("ventanoregistrado");
  }  

?>