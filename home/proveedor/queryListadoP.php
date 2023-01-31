<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $listadoTiposEventoUsuario = "SELECT * FROM Proveedor";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[3];
        $subarray[]=$row[4];
        $subarray[]="<a href='javascript:void()' data-id='$row[0]' class='activarEliminar btn' id='id' name='id'><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;height:20px;' alt='Actualizar contenido'></a><a href='javascript:void()' data-id='$row[0]' class='editbtn btn' id='id' name='id'><img src='../assets/img/update.png' class='zoomImagen' style='width:20px;height:20px;' alt='Eliminar contenido'></a>";
        $data[]=$subarray;     
    }              
    echo json_encode($data);       
?>