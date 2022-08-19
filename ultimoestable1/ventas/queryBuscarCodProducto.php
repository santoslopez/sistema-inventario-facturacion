<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $inputCodigoProducto = $_POST['inputCodigoProducto'];

    $obtenerNombreProducto = "SELECT Inventario.codigoProducto AS codigo,descripcion AS descripcion,Inventario.cantidadComprado AS unidadesdesdisponibles,Inventario.costoActual AS costopromedio FROM Productos INNER JOIN Inventario ON Productos.codigoProducto = '$inputCodigoProducto'";
    
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$obtenerNombreProducto);
    
    // para recuperar un solo dato se utiliza esto
    $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
    
    echo json_encode($row);                  
    
?>