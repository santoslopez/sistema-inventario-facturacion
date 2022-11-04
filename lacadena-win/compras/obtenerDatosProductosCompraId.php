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
        $listadoTiposEventoUsuario = "SELECT * FROM DetalleFacturaCompra WHERE documentoProveedor=$1 AND idDetalle=$2";        
        
        pg_prepare($conexion,"queryDetalleFacturaCompra",$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta queryDetalleFacturaCompra");

        $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryDetalleFacturaCompra",array($id,$codigoDetalle));
    
        //$ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);        
        
        if (!($ejecutarConsultaObtenerInfo)) {
            $data['status'] = 'sindatos';
            echo json_encode($data);    
        }else{
            $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
            echo json_encode($row);       
        }
    }
?>