<?php

  include '../conexion.php';

  if(!(isset($_POST['totalVentaEfectuado']))) {
    header('Location: ../index.php');
  }else{
  
    $arraysTabla = json_decode(filter_input(INPUT_POST,'tableJSON'));

    // se obtiene el codigo del nit de cliente
    $codCliente = $_POST['inputNitProveedor'];
  
    // obtenemos el total de la venta del t
    $total = $_POST['totalVentaEfectuado'];
    

  pg_query("BEGIN") or die("Could not start transaction\n");

  
  // se hace una consulta del numero actual de documentos de comprobantes
  date_default_timezone_set('America/Guatemala');    
  $fechaRealizadoFactura = date('Y-m-d');

  $inputDocumentoProveedor = $_POST['inputDocumentoProveedor'];

  $consultaFactura  = "INSERT INTO FacturaCompra(documentoProveedor,fechaRegistro,fechaFacturaProveedor,nitProveedor,estado) VALUES('$inputDocumentoProveedor','$fechaRealizadoFactura','$fechaRealizadoFactura','$codCliente','P');";


  $resultado="";
  foreach ($arraysTabla as $columna) {
   
    $codigop=$columna[0];
    $cantidadC=$columna[1];
    $precio=$columna[2];

    $resultado.="INSERT INTO DetalleFacturaCompra(precioCompra,cantidadComprado,codigoProducto,documentoProveedor) 
    VALUES($precio,$cantidadC,$codigop,'$inputDocumentoProveedor');";
  
}  

  $ejecutarConsulta1 = pg_query($conexion,$consultaFactura);

  $ejecutarConsulta2 = pg_query($conexion,$resultado);

  if ($ejecutarConsulta1 and $ejecutarConsulta2) {
  
    pg_query("COMMIT") or die("Transaction commit failed\n");
    echo json_encode("compraregistrado");
  }else{
   
    pg_query("ROLLBACK") or die("Transaction rollback failed\n");
    echo json_encode("compranoregistrado");
  } 

  }

?>