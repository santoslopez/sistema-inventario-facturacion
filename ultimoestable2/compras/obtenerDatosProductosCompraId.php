<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    
    $id = $_POST['id'];

    $codigoDetalle = $_POST['codigoDetalle'];

    $listadoTiposEventoUsuario = "SELECT * FROM DetalleFacturaCompra WHERE documentoProveedor='$id' AND idDetalle='$codigoDetalle'";
        
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    if (!($ejecutarConsultaObtenerInfo)) {
        $data['status'] = 'sindatos';
        echo json_encode($data);    
    }else{
        //$data['status'] = 'success';   
        $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
        echo json_encode($row);       
    }
?>