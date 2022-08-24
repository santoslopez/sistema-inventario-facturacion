<?php  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php
  include '../conexion.php';
  
  $precioCompra= $_POST['precioCompra'];
  $cantidadComprado= $_POST['cantidadComprado'];
  $codigoProducto = $_POST['codigoProducto'];
  $facturaCompra= $_POST['facturaCompra'];
  $inputIdDetalle= $_POST['inputIdDetalle'];

  if(!(isset($_POST['precioCompra'],$_POST['cantidadComprado'],$_POST['codigoProducto'],$_POST['facturaCompra'],$_POST['inputIdDetalle'] ) )) {
    header('Location: ../index.php');
  }else{
    $consultaModificarModulos = "UPDATE DetalleFacturaCompra SET precioCompra=$1,cantidadComprado=$2,codigoProducto=$3 WHERE documentoProveedor=$4 AND idDetalle=$5";
    $namePrepare = "prepareModificarProductosCompra";
      
    pg_prepare($conexion,$namePrepare,$consultaModificarModulos) or die("Cannot prepare statement.");
    
    $res = pg_execute($conexion,$namePrepare,array($precioCompra,$cantidadComprado,$codigoProducto,$facturaCompra,$inputIdDetalle));
            
    if ($res ) {
      $data = array();
      $data['status'] = 'success';
      echo json_encode($data);
  
    } else {
      $data['status'] = 'failedupdate';
      echo json_encode($data);
    }

  }
?>