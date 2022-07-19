
<?php

include "../sesion/sesion.php";

include '../conexion.php';

// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$inputCostoProducto=htmlspecialchars($_POST['inputCostoProducto'],ENT_QUOTES,'UTF-8');
$inputCantidadCompra=htmlspecialchars($_POST['inputCantidadCompra'],ENT_QUOTES,'UTF-8');
$inputCodigoProducto=htmlspecialchars($_POST['inputCodigoProducto'],ENT_QUOTES,'UTF-8');

$facturaCompra=htmlspecialchars($_POST['facturaCompra'],ENT_QUOTES,'UTF-8');

$data = array();


$result = pg_query($conexion, "SELECT * FROM DetalleFacturaCompra WHERE codigoProducto='$inputCodigoProducto' AND documentoProveedor='$facturaCompra';");

// ESPECIAL PARA UTILIZARLO EN QUERYS
$rs = pg_fetch_assoc($result);

if ($rs) {
  $data['status'] = 'yaexisteproducto';
  echo json_encode($data);
}else{

  //$ejecutarConsulta = pg_query($conexion,$queryListadoProductos);

  // insertamos
  $consulta  = sprintf("INSERT INTO DetalleFacturaCompra(precioCompra,cantidadComprado,codigoProducto,documentoProveedor) VALUES('%s','%s','%s','%s');",
  pg_escape_string($inputCostoProducto),
  pg_escape_string($inputCantidadCompra),
  pg_escape_string($inputCodigoProducto),
  pg_escape_string($facturaCompra)
  );

    $ejecutarConsulta = pg_query($conexion, $consulta);

    if ($ejecutarConsulta) {
      $consultaInsertarInventario  = sprintf("INSERT INTO Inventario(codigoProducto,cantidadComprado,costoActual) VALUES('%s','%s','%s');",
      pg_escape_string($inputCodigoProducto),
      pg_escape_string($inputCantidadCompra),
      pg_escape_string($inputCostoProducto)
      );
      $ejecutarConsultaInsertarInventario = pg_query($conexion,$consultaInsertarInventario);
      if($ejecutarConsultaInsertarInventario){
        $data['status'] = 'success';
        echo json_encode($data);
      }

    }else{
    $data['status'] = 'failed';
    echo json_encode($data);
    }
}


?>