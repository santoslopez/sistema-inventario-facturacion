<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';


    if(!(isset($_POST['buscarCodigoProducto']))) {
      header('Location: ../index.php');
    }else{
      $documentoFacturaC=$_POST['buscarCodigoProducto'];

      $consulta = "SELECT * FROM PA_consultarInventario('$documentoFacturaC')";

  
      $ejecutarConsulta = pg_query($conexion, $consulta);
      
      if ($ejecutarConsulta) {
        # code...
        echo json_encode($ejecutarConsulta);
      }else{
        echo json_encode($ejecutarConsulta);
      }
  
      $data = array();
          
  }
    

?>