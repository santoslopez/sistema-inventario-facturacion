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
    if(!(isset($fechaInicio,$fechaFin) )) {
        header("Location: ../index.php");
    }else{

    $listadoTiposEventoUsuario = "SELECT facturaventa.numerodocumentofacturaventa,facturaventa.fechafacturaventa,SUM(detalle.preciocompra*detalle.cantidadcomprado) AS totalventa,facturaventa.detalle1,facturaventa.horaventa,facturaventa.codigousuario,facturaventa.estado,REPLACE(facturaventa.detalle1, '&#039;', ''''),REPLACE(facturaventa.detalle2, '&#039;', '''') from facturaventa as facturaventa
INNER JOIN detallefacturaventa AS detalle ON facturaventa.numerodocumentofacturaventa=detalle.numerodocumentofacturaventa
WHERE facturaventa.numerodocumentofacturaventa=detalle.numerodocumentofacturaventa
    AND facturaventa.fechafacturaventa BETWEEN $1 AND $2
GROUP BY (facturaventa.numerodocumentofacturaventa,facturaventa.fechafacturaventa,facturaventa.detalle1,facturaventa.horaventa,facturaventa.codigousuario,facturaventa.estado)";
    
    pg_prepare($conexion,"queryResumenVentasHoy",$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta queryResumenVentasHoy");

    $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryResumenVentasHoy",array($fechaInicio,$fechaFin));
    
    
    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[2];
        $subarray[]=$row[4];
        if ($row[6]=="P") {
            $subarray[]="Procesado<a href=../resumenventas/queryDetalleVentasDia.php?obtenerCodigoVentaComprobante=".urlencode($row[0])."&nombreSubmoduloReporte=".urlencode($row[0])."&fechaVentaComprobante=".urlencode($row[1])."&detalle1=".urlencode($row[7])."&detalle2=".urlencode($row[8])." target='_blank' data-id='$row[0]' class='activarReporteLecciones' id='id' name='id'><img src='../assets/img/bill.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion'></a>
            Anular factura<a href='javascript:void();' data-id='$row[0]' class='activarEliminarFacturaVenta'><img src='../assets/img/delete.png' class='zoomImagen' style='width: 25px;px;heigth: 25px;' alt='Actualizar contenido'></a>";
           
        }else{
            $subarray[]="Anulado<a href=../resumenventas/queryDetalleVentasDia.php?obtenerCodigoVentaComprobante=".urlencode($row[0])."&nombreSubmoduloReporte=".urlencode($row[0])."&fechaVentaComprobante=".urlencode($row[1])."&detalle1=".urlencode($row[7])."&detalle2=".urlencode($row[8])." target='_blank' data-id='$row[0]' class='activarReporteLecciones' id='id' name='id'><img src='../assets/img/bill.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion'></a>";
        }
      

        $data[]=$subarray;     
    }              
    echo json_encode($data);       
    } 
?>