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

    $obtenerFechaActual = date('Y-m-d');


    $listadoTiposEventoUsuario = "SELECT * from facturacompra WHERE facturacompra.fecharegistro BETWEEN $1 AND $2";
    /*$listadoTiposEventoUsuario = "SELECT factura.numerodocumento,factura.documentoproveedor,factura.fecharegistro,
    factura.fechafacturaproveedor, factura.nitproveedor, factura.estado,SUM(detalle.preciocompra*detalle.cantidadcomprado) AS totalcompra from facturacompra AS factura
    INNER JOIN detallefacturacompra AS detalle ON
    factura.documentoproveedor=detalle.documentoproveedor
    WHERE factura.fecharegistro BETWEEN $1 AND $2
    GROUP BY (factura.numerodocumento,factura.documentoproveedor,factura.fecharegistro,
    factura.fechafacturaproveedor, factura.nitproveedor, factura.estado)";*/
    //$diferencia = strtotime($obtenerFechaActual) - strtotime($fechaInicio);
    //$diferencia = $fechaInicio->diff($obtenerFechaActual);
    //$fecha1 = "2022-01-01";
    //$fecha2 = "2022-12-31";
    



    //$dias_transcurridos = floor($diferencia / (60 * 60 * 24));
    //$ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    pg_prepare($conexion,"queryResumenComprasFacturasPorDias",$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta queryResumenVentasHoy");

    $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryResumenComprasFacturasPorDias",array($fechaInicio,$fechaFin));
    
    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[2];
        $subarray[]=$row[3];
        $subarray[]=$row[4];
      
        if ($row[5]=="A") {
            # code...
            //$subarray[]="Anulado";
            $subarray[]="<p style='color:red'>Anulado<a href=../resumencompras/queryDetalleFacturaCompras.php?obtenerCodigoDocumentoProveedor=".urlencode($row[1])."&nombreSubmoduloReporte=".urlencode($row[1])."&nitProveedor=".urlencode($row[4])."  data-id='$row[0]' class='activarReporteLecciones' id='id' name='id' target='_blank'><img src='../assets/img/detallecompras.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion' ></a></p>";
        }else if($row[5]=="N") {   
           
            //$subarray[]="<a href=../resumencompras/queryDetalleFacturaCompras.php?obtenerCodigoDocumentoProveedor=".urlencode($row[1])."&nombreSubmoduloReporte=".urlencode($row[1])."&nitProveedor=".urlencode($row[4])."  data-id='$row[0]' class='activarReporteLecciones' id='id' name='id' target='_blank'><img src='../assets/img/add.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion' ></a>";
            $subarray[]="<p style='color:red'>Factura no cerrado</p><a href=../compras/listadoProductosFacturaCompra.php?documentoFacturaCompra=".urlencode($row[1])." class='opcionEliminarProveedor btn'><img src='../assets/img/add.png' class='zoomImagen' style='width:20px;heigth: 20px;' alt='Agregar prododucto'></a><a href=../resumencompras/queryDetalleFacturaCompras.php?obtenerCodigoDocumentoProveedor=".urlencode($row[1])."&nombreSubmoduloReporte=".urlencode($row[1])."&nitProveedor=".urlencode($row[4])."  data-id='$row[0]' class='activarReporteLecciones' id='id' name='id' target='_blank'><img src='../assets/img/detallecompras.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion'></a>";

        }else{
            $fecha1 = strtotime($row[2]);
            $fecha2 = strtotime($obtenerFechaActual);
            
            $diferencia = $fecha2 - $fecha1;
            $dias_transcurridos = floor($diferencia / (60 * 60 * 24));

            if (intval($dias_transcurridos)>=180) {
                $subarray[]="Procesado<a href=../resumencompras/queryDetalleFacturaCompras.php?obtenerCodigoDocumentoProveedor=".urlencode($row[1])."&nombreSubmoduloReporte=".urlencode($row[1])."&nitProveedor=".urlencode($row[4])."  data-id='$row[0]' class='activarReporteLecciones' id='id' name='id' target='_blank'><img src='../assets/img/detallecompras.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion' ></a>
                Anular factura bloqueado";
            }  else{
               $subarray[]="Procesado<a href=../resumencompras/queryDetalleFacturaCompras.php?obtenerCodigoDocumentoProveedor=".urlencode($row[1])."&nombreSubmoduloReporte=".urlencode($row[1])."&nitProveedor=".urlencode($row[4])."  data-id='$row[0]' class='activarReporteLecciones' id='id' name='id' target='_blank'><img src='../assets/img/detallecompras.png' class='zoomImagen' style='width:20px;height:20px;' alt='Reporte leccion' ></a>
                Anular factura<a href='javascript:void();' data-id='$row[1]' class='activarEliminarFacturaCompra'><img src='../assets/img/delete.png' class='zoomImagen' style='width: 25px;px;heigth: 25px;' alt='Actualizar contenido'></a>";
            }        
            
        }

        $data[]=$subarray;                                         
    }              
    echo json_encode($data);       
?>

