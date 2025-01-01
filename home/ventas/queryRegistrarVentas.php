<?php

  include '../conexion.php';
  
  if(!(isset($_POST['inputCodigoCliente'],$_POST['totalVentaEfectuado']))) {
    header('Location: ../index.php');
  }else{
    $arraysTabla = json_decode(filter_input(INPUT_POST,'tableJSON'));

    // se obtiene el codigo del nit de cliente
    $codCliente = $_POST['inputCodigoCliente'];
  
    // obtenemos el total de la venta del t
    $total = $_POST['totalVentaEfectuado'];
    
    session_start();

    $codigoUsuario = $_SESSION["codigoUsuario"];

  pg_query("BEGIN") or die("Could not start transaction\n");

  // se hace una consulta del numero actual de documentos de comprobantes
  date_default_timezone_set('America/Guatemala');    
  $fechaRealizadoFactura = date('Y-m-d');

  $horaVenta = date('h:i:s A');

 $detalleCliente=htmlspecialchars($_POST["inputDetalle1"],ENT_QUOTES,'UTF-8');
 $detalle1 = pg_escape_string($conexion,($detalleCliente));

 $detalleDireccion=htmlspecialchars($_POST["inputDetalle2"],ENT_QUOTES,'UTF-8');
 $detalle2 = pg_escape_string($conexion,($detalleDireccion));


  $consultaFactura =  "INSERT INTO FacturaVenta(codigoCliente,totalVenta,fechaFacturaVenta,horaVenta,estado,codigoUsuario,detalle1,detalle2) VALUES ('$codCliente',$total,'$fechaRealizadoFactura','$horaVenta','P','$codigoUsuario','$detalle1','$detalle2')";
  
  $ejecutarConsulta1 = pg_query($conexion,$consultaFactura);
  
  $consultaValorMaximoFactura="SELECT max(numerodocumentofacturaventa) FROM FacturaVenta";


  $ejecutarConsultaObtenerInfo = pg_query($conexion,$consultaValorMaximoFactura);
    
  // para recuperar un solo dato se utiliza esto
  $numero1=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
  
  // para recuperar todos los datos se utiliza esto porque estamos obtiendo el maximo de la consulta
  // se incrementa en 1 el documento
  $numeroDocumento = intval($numero1['max']);

  $resultado="";
  foreach ($arraysTabla as $columna) {
    $resultado.="INSERT INTO DetalleFacturaVenta(codigoProducto,cantidadComprado,precioCompra,numeroDocumentoFacturaVenta) VALUES('$columna[0]',$columna[2],$columna[3],'$numeroDocumento');";


  }  


  $ejecutarConsulta2 = pg_query($conexion,$resultado);


  if ($ejecutarConsulta1 and $ejecutarConsulta2 and $ejecutarConsultaObtenerInfo) {
  
    pg_query("COMMIT") or die("Transaction commit failed\n");
    echo json_encode("ventaregistrado");
  }else{
   
    pg_query("ROLLBACK") or die("Transaction rollback failed\n");
    echo json_encode("ventanoregistrado");
  } 

  }

?>