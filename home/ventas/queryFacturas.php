<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';
 
    $listadoTiposEventoUsuario = "SELECT * FROM FacturaCompra";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    $data = array();
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[2];
        $subarray[]=$row[3];
        $subarray[]=$row[4];
        $subarray[]="<a href=../compras/index.php?documentoFacturaCompra=".urlencode($row[1])." class='opcionEliminarProveedor btn'><img src='../assets/img/add.png' class='zoomImagen' style='width:20px;heigth: 20px;' alt='Agregar prododucto'></a><a href='javascript:void();' data-id='$row[1]' class='activarEliminar'><img src='../assets/img/delete.png' class='zoomImagen' style='width: 25px;px;heigth: 25px;' alt='Actualizar contenido'></a><a href='javascript:void();' class='opcionEliminarProveedor btn'><img src='../assets/img/update.png' class='zoomImagen' style='width:20px;heigth: 20px;' alt='Eliminar contenido'></a>";
        $data[]=$subarray;                                         
    }              
    echo json_encode($data);       
?>