<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $inputCodigoProducto = $_POST['inputCodigoProducto'];

    if(!(isset($_POST['inputCodigoProducto']))) {
      header('Location: ../index.php');
    }else{
      $obtenerNombreProducto = "SELECT Inventario.codigoProducto AS codigo,descripcion AS descripcion,Inventario.cantidadComprado AS cantidadcomprado,Inventario.costoActual AS costoactual FROM Productos INNER JOIN Inventario ON Productos.codigoProducto = Inventario.codigoProducto WHERE Inventario.codigoProducto='$inputCodigoProducto'";
    
      $ejecutarConsultaObtenerInfo = pg_query($conexion,$obtenerNombreProducto);
      
      // para recuperar un solo dato se utiliza esto
      $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
      
      echo json_encode($row);    
      
    }    
?>