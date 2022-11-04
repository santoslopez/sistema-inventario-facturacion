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
        $listadoProveedor = "SELECT * FROM Productos WHERE codigoProducto=$1";
        
        pg_prepare($conexion,"queryListadoProductos",$listadoProveedor) or die ("No se pudo preparar la consulta queryListadoProductos");

        $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryListadoProductos",array($id));
        
            
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