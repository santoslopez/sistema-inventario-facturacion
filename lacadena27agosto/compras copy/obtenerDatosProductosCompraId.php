<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $id = $_POST['id'];
    $codigoDetalle = $_POST['codigoDetalle'];

    if(!(isset($_POST['id'],$_POST['codigoDetalle']))) {
        header('Location: ../index.php');
    }else{
        $listadoTiposEventoUsuario = "SELECT * FROM DetalleFacturaCompra WHERE documentoProveedor='$id' AND idDetalle='$codigoDetalle'";        
        $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);        
        if (!($ejecutarConsultaObtenerInfo)) {
            $data['status'] = 'sindatos';
            echo json_encode($data);    
        }else{
            $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
            echo json_encode($row);       
        }
    }
?>