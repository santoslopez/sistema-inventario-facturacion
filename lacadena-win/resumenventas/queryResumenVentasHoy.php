<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';
    date_default_timezone_set('America/Guatemala');   
    //$fechaHoy = date('Y-m-d');
    
    $fechaInicio = $_GET["fechaInicio"];
    $fechaFin = $_GET["fechaFin"];


    $listadoTiposEventoUsuario = "SELECT DISTINCT facturaventa.numerodocumentofacturaventa,facturaventa.fechafacturaventa,facturaventa.totalventa,nitcliente AS nitcliente,facturaventa.horaVenta  FROM Clientes INNER JOIN FacturaVenta AS facturaventa
    ON Clientes.codigocliente=FacturaVenta.codigocliente INNER JOIN  detallefacturaventa
    ON FacturaVenta.numerodocumentofacturaventa=detallefacturaventa.numerodocumentofacturaventa    
    WHERE facturaventa.numerodocumentofacturaventa=detallefacturaventa.numerodocumentofacturaventa
    AND facturaventa.fechafacturaventa BETWEEN $1 AND $2";
    
    pg_prepare($conexion,"queryResumenVentasHoy",$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta queryResumenVentasHoy");

    $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryResumenVentasHoy",array($fechaInicio,$fechaFin));
    
    //$ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[2];
        $subarray[]=$row[3];
        $subarray[]=$row[4];
        //$subarray[]="<a href='javascript:void();' data-id='$row[0]' class='activarAnularFactura' id='id' name='id'><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;height:20px;' alt='Actualizar contenido'></a>";
         $subarray[]="No disponible";

        $subarray[]="<a href=../resumenventas/queryDetalleVentasDia.php?obtenerCodigoVentaComprobante=".urlencode($row[0])."&nombreSubmoduloReporte=".urlencode($row[0])."&fechaVentaComprobante=".urlencode($row[1])." target='_blank' data-id='$row[0]' class='activarReporteLecciones' id='id' name='id'><img src='../assets/img/bill.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion'></a>";
        $data[]=$subarray;     
    }              
    echo json_encode($data);       
   
?>