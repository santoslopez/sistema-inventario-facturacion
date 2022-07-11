<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $id = $_POST['id'];

    $listadoTiposEventoUsuario = "SELECT * FROM Proveedor WHERE  nitProveedor=$id LIMIT 1";

    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    if (!($ejecutarConsultaObtenerInfo)) {
        $data['status'] = 'failed';
        echo json_encode("No hay proveedores registrados.");    
    }else{   
        $data = array();
        while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
            $subarray=array();
            $subarray[]=$row[0];
            $subarray[]=$row[1];
            $subarray[]=$row[3];
            $subarray[]=$row[4];
            $data[]=$subarray;                                         
        }                 
        echo json_encode($data);       
    }
?>