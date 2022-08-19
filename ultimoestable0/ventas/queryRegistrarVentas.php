<?php

  include '../conexion.php';

  $arraysTabla = json_decode(filter_input(INPUT_POST,'tableJSON'));
  
  // se obtiene el codigo del nit de cliente
  $codCliente = $_POST['inputCodigoCliente'];

  $total = 1000;
  
  // se hace una consulta del numero actual de documentos de comprobantes
  $consultaValorMaximoFactura="SELECT max(numerodocumentofacturaventa) FROM FacturaVenta";

  $documentoActual=pg_fetch_assoc($consultaValorMaximoFactura);


  $consultaFactura =  "INSERT INTO FacturaVenta(codigoCliente,totalVenta) VALUES ('$codCliente',$total)";

  //se incrementa a uno el documento
  $numeroDocumento=$documentoActual+1;

  $corcheteSimple="'";

  foreach ($arraysTabla as $columna) {
    $resultado='('.$corcheteSimple.$columna[0].$corcheteSimple.','.$columna[2].','.$columna[3].','.$numeroDocumento.'),';
    $queryInsertMultipleConComa.=$resultado;
  }

  $queryInsertMultiple=rtrim($queryInsertMultipleConComa,",");
  $queryFinal=$queryInsertMultiple.';';

  pg_query("BEGIN") or die("Could not start transaction\n");

  $consultaInsertDetalleFacturaVenta =  "INSERT INTO DetalleFacturaVenta(codigoProducto,cantidadComprado,precioCompra,numeroDocumentoFacturaVenta) VALUES $queryFinal";
  
  $ejecutarConsulta1 = pg_query($conexion,$consultaFactura);

  $ejecutarConsulta2 = pg_query($conexion,$consultaInsertDetalleFacturaVenta);


  if ($ejecutarConsulta1 and $ejecutarConsulta2) {
    pg_query("COMMIT") or die("Transaction commit failed\n");
    echo json_encode("ventaregistrado");
  }else{
    pg_query("ROLLBACK") or die("Transaction rollback failed\n");;
    echo json_encode("ventanoregistrado");
  } 
  
?>