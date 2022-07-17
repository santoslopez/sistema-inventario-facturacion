<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $consultaTotalFacturaCompra = "select sum(cantidadcomprado * preciocompra) as totalfacturacompra from detallefacturacompra";
    $ejecutarConsultaObtenerInfo  = pg_query($conexion,$consultaTotalFacturaCompra);

    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];     
        $data[]=$subarray;                       
    }              
    echo json_encode($data);       

?>