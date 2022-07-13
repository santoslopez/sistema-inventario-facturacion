
<?php

include "../sesion/sesion.php";

include '../conexion.php';

// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$inputNumeroFacturaProveedor=htmlspecialchars($_POST['inputDocumentoProveedor'],ENT_QUOTES,'UTF-8');
$inputFechaFacturaProveedor=htmlspecialchars($_POST['inputFechaFacturaProveedor'],ENT_QUOTES,'UTF-8');
$selectNitProveedor=htmlspecialchars($_POST['inputNitProveedor'],ENT_QUOTES,'UTF-8');


$consultaVerificarExistenciaProducto = "SELECT * FROM FacturaCompra where documentoProveedor=$1";

$namePrepareStatement = "prepareVerificarFacturaCompra";

pg_prepare($conexion,$namePrepareStatement,$consultaVerificarExistenciaProducto) or die("Cannot prepare statement verificar productos existentes.");

$ejecutarConsultaVerificarProducto  = pg_execute($conexion,$namePrepareStatement,array($inputNumeroFacturaProveedor));


if(pg_num_rows($ejecutarConsultaVerificarProducto)) {
  $data['status'] = 'yaexistenoguardado';
  echo json_encode($data);
}else{

    date_default_timezone_set('America/Guatemala');    
    //$fechaActual = date('d-m-Y',time());
  $fechaActual = date("F j, Y, g:i a");  
  $consulta  = sprintf("INSERT INTO FacturaCompra(documentoProveedor,fechaRegistro,fechaFacturaProveedor,nitProveedor) VALUES('%s','%s','%s','%s');",
  pg_escape_string($inputNumeroFacturaProveedor),
  pg_escape_string($fechaActual),
  pg_escape_string($inputFechaFacturaProveedor),
  pg_escape_string($selectNitProveedor)
  );
  
  $ejecutarConsulta = pg_query($conexion, $consulta);
  
  if ($ejecutarConsulta) {
    $data = array();
    $data['status'] = 'success';
    echo json_encode($data);
  }else{
  $data = array();
  $data['status'] = 'failed';
  echo json_encode($data);
  }

}




?>