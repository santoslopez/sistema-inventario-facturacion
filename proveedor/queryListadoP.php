<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $listadoTiposEventoUsuario = "SELECT * FROM Proveedor";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    if (!($ejecutarConsultaObtenerInfo)) {
        $data = "No hay proveedores registrados";
        echo json_encode($data);       

    }else{   
        $data = array();
        //$data =  pg_fetch_all($ejecutarConsultaObtenerInfo);
        while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
            $subarray=array();
            $subarray[]=$row[0];
            $subarray[]=$row[1];
            $subarray[]=$row[3];
            $subarray[]=$row[4];
            //$subarray[]="<a href=../clientes/frmModificarClientes?nitDatos=$row[0]&empresaDatos=".urlencode($row[1])."&direccion=".urlencode($row[3])."&telefono=".urlencode($row[4])."><img src='../assets/img/update.png' class='zoomImagen' style='width: 25px;px;heigth: 25px;' alt='Actualizar contenido'></a><a href=../clientes/queryEliminarClientes.php?codigoClienteEliminar=".urlencode($row[0])." class='opcionEliminarProveedor btn'><img src='../assets/img/delete.png' class='zoomImagen' style='width:20px;heigth: 20px;' alt='Eliminar contenido'></a>";
            $subarray[]="<a href='javascript:void();' data-id='$row[0]' class='activarEliminar' id='id' name='id'><img src='../assets/img/delete.png' class='zoomImagen' style='width: 25px;px;heigth: 25px;' alt='Actualizar contenido'></a><a href='javascript:void();' class='editbtn btn' data-id='$row[0]' id='id' name='id'><img src='../assets/img/update.png' class='zoomImagen' style='width:20px;heigth: 20px;' alt='Eliminar contenido'></a>";
            $data[]=$subarray;                                         
        }              
        echo json_encode($data);       
    }
?>