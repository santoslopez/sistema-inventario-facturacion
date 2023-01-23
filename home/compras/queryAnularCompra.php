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
      $queryActualizarEstado = "UPDATE FacturaCompra SET estado='A' WHERE numeroDocumento=$1";

      
      
      $namePrepareStatement="prepareStatementActualizarEstadoFacturaCompra";
      $obtenerNumeroDocumento = $_POST["id"];
  
      pg_prepare($conexion,"prepareStatementActualizarEstadoFacturaCompra",$queryActualizarEstado) or die("Cannot prepare statement prepareStatementActualizarEstadoFacturaCompra.");
      $res = pg_execute($conexion,$namePrepareStatement,array($obtenerNumeroDocumento));

      if ($res) { 
        echo json_encode("facturacompraanulado");
      }else{       
        echo json_encode("errorproducido");
      }

    }

  ?>