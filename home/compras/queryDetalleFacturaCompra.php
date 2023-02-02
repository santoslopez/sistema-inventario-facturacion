<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    if(!(isset($_GET['documentoFacturaCompra']))) {
        header('Location: ../index.php');
    }else {
    
    $documentoFacturaC=pg_escape_string(htmlspecialchars($_GET['documentoFacturaCompra']));
    
    $listadoTiposEventoUsuario = "SELECT detalle.iddetalle,detalle.preciocompra,detalle.cantidadcomprado, detalle.codigoproducto,prod.descripcion,facturacompra.estado FROM DetalleFacturaCompra AS detalle 
    INNER JOIN FacturaCompra AS facturacompra ON detalle.documentoproveedor=facturacompra.documentoproveedor
    INNER JOIN Productos AS prod ON detalle.codigoProducto=prod.codigoProducto WHERE detalle.documentoProveedor=$1";
   
    $variableNombre = "queryMostrarListadoTiposEventoUsuario";
    pg_prepare($conexion,$variableNombre,$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta queryMostrarListadoTiposEventoUsuario");

    $ejecutarConsultaObtenerInfo = pg_execute($conexion,$variableNombre,array($documentoFacturaC));
    
    if (!($ejecutarConsultaObtenerInfo)) {
        $data = "No hay productos en esta factura de compra.";
        echo json_encode($data);       

    }else{   
        $data = array();
        while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
            // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
            $subarray=array();
            //$subarray[]=$row[0];
            $subarray[]=$row[1];
            $subarray[]=$row[2];
            $multiplicacion = $row[1] * $row[2];
            $subarray[]=number_format($multiplicacion, 2, '.', '');
            $subarray[]=$row[3];
            $subarray[]=$row[4];
            if($row[5]=='N'){
                $subarray[]="<a href='javascript:void();' data-id='$row[0]' class='activarEliminar' id='id' name='id'><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;height:20px;' alt='Eliminar fila'></a>";          
            }else{
                $subarray[]="<a ><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;height:20px;' alt='Eliminar fila'>No disponible</a>";          
            }
            $data[]=$subarray;                                         
        }              
        echo json_encode($data);       
    }
}
?>