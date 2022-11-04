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
      $obtenerNombreProducto = "SELECT PA_buscarRegistroProducto('$inputCodigoProducto')";
    
      $ejecutarConsulta = pg_query($conexion,$obtenerNombreProducto);
      
      // para recuperar un solo dato se utiliza esto
      //$row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
      
      //echo json_encode($row);    
      
      while ($row= pg_fetch_row($ejecutarConsulta)) {
        $subarray=array();
        $subarray[]=$row[0];
      }
      echo json_encode($subarray);
    }

?>