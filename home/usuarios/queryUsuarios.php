<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $listadoTiposEventoUsuario = "SELECT * FROM Usuarios where correo!='lopeztsantos@gmail.com';";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    $data = array();
    //if (!($ejecutarConsultaObtenerInfo)) {
    //if (!(pg_num_rows($ejecutarConsultaObtenerInfo))) {
    if (!($ejecutarConsultaObtenerInfo)) {
        $data = "No hay usuarios registrados";
        echo json_encode($data);       

    }else{   
    
        //$data =  pg_fetch_all($ejecutarConsultaObtenerInfo);
        while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
            $subarray=array();
            $subarray[]=$row[0];
            $subarray[]=$row[1];
            $subarray[]=$row[2];
            $subarray[]=$row[3];
            $subarray[]=$row[4];
            $subarray[]="<a href=../usuarios/frmModificarUsuariosRegistrados.php?correo=".urlencode($row[1])."&estadoActual=".urlencode($row[1])."&fechaRegistro=".urlencode($row[2])."&datos=".urlencode($row[3])."><img src='../assets/img/update.png' class='zoomImagen imagenTabla' alt='Actualizar contenido'></a></td>";
            //$subarray[]="<td data-label='Eliminar'><a href=../usuarios/queryEliminarUsuario.php?correoEliminar=".urlencode($row[0])." class='opcionEliminarUsuario btn'><img src='../assets/img/delete.png' class='zoomImagen imagenTabla' alt='Eliminar contenido'></a></td>";
            
            $data[]=$subarray;                                         
        }              
        echo json_encode($data);       
    }
?>