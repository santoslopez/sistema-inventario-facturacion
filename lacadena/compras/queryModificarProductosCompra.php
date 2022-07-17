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

    $consultaModificarModulos = "UPDATE DetalleFacturaCompra SET precioCompra=$1,cantidadComprado=$2,codigoProducto=$3 WHERE documentoProveedor=$4 AND idDetalle=$5";

    $namePrepare = "prepareModificarProductosCompra";
    
    pg_prepare($conexion,$namePrepare,$consultaModificarModulos) or die("Cannot prepare statement.");
  
    $res = pg_execute($conexion,$namePrepare,array($precioCompra,$cantidadComprado,$codigoProducto,$facturaCompra,$inputIdDetalle));
    
    if ($res) {
        
        // actualizamos el inventario actual que tenemos
        $actualizarInventarioBodega = "UPDATE Inventario SET cantidadComprado=$1,costoActual=$2 WHERE codigoProducto=$3";
        $namePrepareActualizarInventarioBodega = "prepareActualizarInventarioBodega";
        pg_prepare($conexion,$namePrepareActualizarInventarioBodega,$actualizarInventarioBodega) or die("Cannot prepare statement.");

        $ejecutarActualizacionInventario = pg_execute($conexion,$namePrepareActualizarInventarioBodega,array($cantidadComprado,$precioCompra,$codigoProducto));

        if ($ejecutarActualizacionInventario) {

        $data = array();
        $data['status'] = 'success';
        echo json_encode($data);
    
        }

    } else {
      $data['status'] = 'failedupdate';
      echo json_encode($data);
    }
?>