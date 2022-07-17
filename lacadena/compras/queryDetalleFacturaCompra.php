<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $documentoFacturaC=$_GET['documentoFacturaCompra'];
    
    $listadoTiposEventoUsuario = "SELECT * FROM DetalleFacturaCompra WHERE documentoProveedor='$documentoFacturaC';";
    //$listadoTiposEventoUsuario = "SELECT * FROM DetalleFacturaCompra";

    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    if (!($ejecutarConsultaObtenerInfo)) {
        $data = "No hay productos en esta factura de compra.";
        echo json_encode($data);       

    }else{   
        $data = array();
        while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
            // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
            $subarray=array();
            $subarray[]=$row[0];
            $subarray[]=$row[1];
            $subarray[]=$row[2];
            $subarray[]=$row[3];
            $multiplicacion = $row[1] * $row[2];
            $subarray[]=number_format($multiplicacion, 2, '.', '');
            $subarray[]="<a href='javascript:void();' data-id='$row[0]' class='activarEliminar' id='id' name='id'><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;height:20px;' alt='Actualizar contenido'></a>";
            $data[]=$subarray;                                         
        }              
        echo json_encode($data);       
    }
?>