<?php

  include '../conexion.php';

  $arraysTabla = json_decode(filter_input(INPUT_POST,'tableJSON'));
  //$arraysTabla = json_decode('tableJSON');


  // se obtiene el codigo del nit de cliente
  $codCliente = $_POST['inputCodigoCliente'];


  // obtenemos el total de la venta del t
  $total = $_POST['totalVentaEfectuado'];
  
  if(!(isset($_POST['inputCodigoCliente'],$_POST['totalVentaEfectuado']))) {
    header('Location: ../index.php');
  }else{

  $consultaValorMaximoFactura="SELECT max(numerodocumentofacturaventa) FROM FacturaVenta";


  $ejecutarConsultaObtenerInfo = pg_query($conexion,$consultaValorMaximoFactura);
    
  // para recuperar un solo dato se utiliza esto
  $numero1=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
  
  // para recuperar todos los datos se utiliza esto porque estamos obtiendo el maximo de la consulta
  // se incrementa en 1 el documento
  $numeroDocumento = intval($numero1['max'])+1;
  //echo json_encode($row);  

  // se hace una consulta del numero actual de documentos de comprobantes

  //$documentoActual=pg_fetch_assoc($consultaValorMaximoFactura);
  $fechaRealizadoFactura = date('Y-m-d');

  $consultaFactura =  "INSERT INTO FacturaVenta(codigoCliente,totalVenta,fechaFacturaVenta) VALUES ('$codCliente',$total,'$fechaRealizadoFactura')";

  //se incrementa a uno el documento
  //$numeroDocumento=1;

  $corcheteSimple="'";

  $queryInsertMultipleConComa = "";
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


  if ($ejecutarConsulta1 and $ejecutarConsulta2 and $ejecutarConsultaObtenerInfo) {
    pg_query("COMMIT") or die("Transaction commit failed\n");
    echo json_encode("ventaregistrado");
  }else{
    pg_query("ROLLBACK") or die("Transaction rollback failed\n");;
    echo json_encode("ventanoregistrado");
  } 
  
    

  }

?>