<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    
    $id = $_POST['id'];

    $listadoTiposEventoUsuario = "SELECT * FROM Proveedor WHERE  nitProveedor='$id'";
    
    //echo json_encode($listadoTiposEventoUsuario);
    
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