<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    


    if(!(isset($_POST['id']))) {
        header('Location: ../index.php');
    }else{
        $id = $_POST['id'];
        $listadoProveedor = "SELECT * FROM Proveedor WHERE  nitProveedor=$1";
        
        pg_prepare($conexion,"queryListadoProveedor",$listadoProveedor) or die ("No se pudo preparar la consulta queryListadoProveedor");

        $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryListadoProveedor",array($id));
        
                    
        if (!($ejecutarConsultaObtenerInfo)) {
            $data['status'] = 'sindatos';
            echo json_encode($data);    
        }else{
            $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
            echo json_encode($row);       
        }    
    }
?>