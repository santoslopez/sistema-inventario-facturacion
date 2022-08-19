<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $documentoFacturaC=$_POST['buscarCodigoProducto'];


    //$consultaTotalFacturaCompra = "SELECT codigoProducto,cantidadComprado, costoActual from Inventario WHERE codigoProducto='$documentoFacturaC';";
    //$ejecutarConsultaObtenerInfo  = pg_query($conexion,$consultaTotalFacturaCompra);

    

    /*$data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];     
        $subarray[]=$row[1];
        $subarray[]=$row[2];          
        $data=$subarray;                       
    }              
    echo json_encode($data); */
    $consulta = "SELECT * FROM PA_consultarInventario('$documentoFacturaC')";

  
    $ejecutarConsulta = pg_query($conexion, $consulta);
    
    if ($ejecutarConsulta) {
      # code...
      echo json_encode($ejecutarConsulta);
    }else{
      echo json_encode($ejecutarConsulta);
    }

    $data = array();
  
    /*while ($row= pg_fetch_row($ejecutarConsulta)) {
      $subarray=array();
      $subarray[]=$row[0];
      echo json_encode($subarray);
    }*/
    /*while ($row = pg_fetch_assoc($ejecutarConsulta)) {
        $data[]=$row['codigoproducto'];
        //$data[]=$row['cantidadComprado'];
        //$data[]=$row[' costoActual'];
        echo json_encode($data);
      }*/

    

?>