<?php
  //session_start();
  include "../sesion/sesion.php";

  include "../config/config.php";

?>
<?php 
    
    include '../conexion.php';
    include '../datos/funcionesDatos.php';
   
    if(!(isset($_POST["id"]) )) {
      header('Location: ../index.php');
    }else{

      $queryEliminar = "DELETE FROM Clientes WHERE codigoCliente=$1";
      $consultaEliminarLenguas = $queryEliminar;
      $namePrepareStatement="prepareStatementEliminarCliente";
      $obtenerCodigoEvento = $_POST["id"];
  
      pg_prepare($conexion,"prepareStatementEliminarCliente",$consultaEliminarLenguas) or die("Cannot prepare statement.");
      $res= pg_execute($conexion,$namePrepareStatement,array($obtenerCodigoEvento));

      if ($res) {
        $data = array();
        $data['status'] = 'success';
        echo json_encode($data);
      }else{
        $data = array();
        $data['status'] = 'failed';
        echo json_encode($data);
      }

    }


  ?>