<?php
  //session_start();
  include "../sesion/sesion.php";
?>
<?php 
    
    include '../conexion.php';
    include '../datos/funcionesDatos.php';
   
    $queryEliminar = "DELETE FROM DetalleFacturaCompra WHERE idDetalle=$1";
    $consultaEliminarLenguas = $queryEliminar;
    $namePrepareStatement="prepareStatementEliminarProductoCompra";
    $obtenerCodigoEvento = $_POST["id"];

    pg_prepare($conexion,$namePrepareStatement,$consultaEliminarLenguas) or die("Cannot prepare statement.");
    $res= pg_execute($conexion,$namePrepareStatement,array($obtenerCodigoEvento));
    $data = array();
    if ($res) {
      $data['status'] = 'success';
      echo json_encode($data);
    }else{
      $data['status'] = 'failed';
      echo json_encode($data);
    }
  ?>