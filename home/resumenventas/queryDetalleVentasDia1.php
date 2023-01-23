<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';
    
    if (!isset($_GET['obtenerCodigoVentaComprobante'])) {
        //$obtenerNombreSubmodulo = "0";
        # code...
        header("Location: ../index.php");
    }else{


    $obtenerCodigoVentaComprobante=$_GET['obtenerCodigoVentaComprobante'];
    

    $listadoTiposEventoUsuario = "SELECT * FROM detallefacturaventa WHERE numerodocumentofacturaventa=$1";
    
    //$ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    pg_prepare($conexion,"queryDetalleFactura",$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta obtenerCodigoVentaComprobante");

    $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryDetalleFactura",array($obtenerCodigoVentaComprobante));
    

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

}
   
?>