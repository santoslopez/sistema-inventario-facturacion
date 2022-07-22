<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $documentoFacturaC=$_POST['buscarCodigoProducto'];


    $consultaTotalFacturaCompra = "SELECT codigoProducto,cantidadComprado, costoActual from Inventario WHERE codigoProducto='$documentoFacturaC';";
    $ejecutarConsultaObtenerInfo  = pg_query($conexion,$consultaTotalFacturaCompra);

    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];     
        $subarray[]=$row[1];
        $subarray[]=$row[2];          
        $data[]=$subarray;                       
    }              
    echo json_encode($data);       

?>