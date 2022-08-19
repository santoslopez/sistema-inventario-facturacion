<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';
    
    $listadoTiposEventoUsuario = "SELECT * FROM FacturaVenta";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    /*if (!($ejecutarConsultaObtenerInfo)) {
        $data = "No hay informacion de ventas de hoy";
        echo json_encode($data);       

    }else{   } */
    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[2];
        $subarray[]="<a href='javascript:void();' data-id='$row[0]' class='activarAnularFactura' id='id' name='id'><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;height:20px;' alt='Actualizar contenido'></a>";
        $data[]=$subarray;     
    }              
    echo json_encode($data);       
   
?>