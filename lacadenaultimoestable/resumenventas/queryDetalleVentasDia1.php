<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';
    
    $obtenerCodigoVentaComprobante=$_GET['obtenerCodigoVentaComprobante'];
    

    $listadoTiposEventoUsuario = "SELECT * FROM detallefacturaventa WHERE numerodocumentofacturaventa=$obtenerCodigoVentaComprobante";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    if ($ejecutarConsultaObtenerInfo) {
        $data = array();
        while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
            $subarray=array();
            $subarray[]=$row[0];
            $subarray[]=$row[1];
            $subarray[]=$row[2];
            $subarray[]=$row[3];
            $subarray[]=$row[4];
            $data[]=$subarray;     
        }              
        echo json_encode($data);   
    }else{
        echo json_encode("sindatos");   
    }

    
   
?>