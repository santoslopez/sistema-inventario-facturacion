
<?php

include "../sesion/sesion.php";

include '../conexion.php';

// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$inputCostoProducto=htmlspecialchars($_POST['inputCostoProducto'],ENT_QUOTES,'UTF-8');
$inputCantidadCompra=htmlspecialchars($_POST['inputCantidadCompra'],ENT_QUOTES,'UTF-8');
$inputCodigoProducto=htmlspecialchars($_POST['inputCodigoProducto'],ENT_QUOTES,'UTF-8');

$facturaCompra=htmlspecialchars($_POST['facturaCompra'],ENT_QUOTES,'UTF-8');

// Realizar una verificacion que el codigo del producto no este registrado
/*$consultaVerificarExistenciaProducto = "SELECT * FROM Productos where codigoProducto=$1";

pg_prepare($conexion,"prepareVerificarProductos",$consultaVerificarExistenciaProducto) or die("Cannot prepare statement verificar productos existentes.");

$ejecutarConsultaVerificarProducto  = pg_execute($conexion,"prepareVerificarProductos",array($codigoProducto));


if(pg_num_rows($ejecutarConsultaVerificarProducto)) {
  $data['status'] = 'yaexistenoguardado';
  echo json_encode($data);

}else{*/

  $consulta  = sprintf("INSERT INTO DetalleFacturaCompra(precioCompra,cantidadComprado,codigoProducto,documentoProveedor) VALUES('%s','%s','%s','%s');",
  pg_escape_string($inputCostoProducto),
  pg_escape_string($inputCantidadCompra),
  pg_escape_string($inputCodigoProducto),
  pg_escape_string($facturaCompra)
  );
  
  $ejecutarConsulta = pg_query($conexion, $consulta);
  
  if ($ejecutarConsulta) {
    
    /*$consultaInsertarInventario  = sprintf("INSERT INTO Inventario(codigoProducto,costoActual) VALUES('%s','%s');",
    pg_escape_string($inputCodigoProducto),
    pg_escape_string($inputCostoProducto)
    );*/

    //$ejecutarConsultaInsertarInventario = pg_query($conexion,$consultaInsertarInventario);

    //if($ejecutarConsultaInsertarInventario){
      $data = array();
      $data['status'] = 'success';
      
      echo json_encode($data);
    //}else{

    //}

  }else{
  $data = array();
  $data['status'] = 'failed';
  echo json_encode($data);
  }
//}

?>