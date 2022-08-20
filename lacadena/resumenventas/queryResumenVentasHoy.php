<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';
    
    $listadoTiposEventoUsuario = "SELECT * FROM FacturaVenta";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[2];
        $subarray[]="<a href='javascript:void();' data-id='$row[0]' class='activarAnularFactura' id='id' name='id'><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;height:20px;' alt='Actualizar contenido'></a>";
        $subarray[]="<a href=../resumenventas/queryDetalleVentasDia.php?obtenerCodigoVentaComprobante=".urlencode($row[0])."&nombreSubmoduloReporte=".urlencode($row[0])."  data-id='$row[0]' class='activarReporteLecciones' id='id' name='id'><img src='../assets/img/bill.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion'></a>";
        $data[]=$subarray;     
    }              
    echo json_encode($data);       
   
?>