<?php
    include "../sesion/sesion.php";
    include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $listadoInventado = "SELECT Inventario.codigoProducto,descripcion,Inventario.cantidadComprado,Inventario.precioCompra  FROM Productos INNER JOIN Inventario ON Productos.codigoProducto = Inventario.codigoProducto";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoInventado);
    
    /*if (!($ejecutarConsultaObtenerInfo)) {
        $data = "No hay proveedores registrados";
        echo json_encode($data);       

    }else{}*/   
    $data = array();
    //$data =  pg_fetch_all($ejecutarConsultaObtenerInfo);
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        $subarray=array();
        $subarray[]=$row[0];
        $subarray[]=$row[1];
        $subarray[]=$row[2];
        $subarray[]=$row[3];
        $data[]=$subarray;     
    }              
    echo json_encode($data);       
    
?>