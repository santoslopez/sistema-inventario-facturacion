<?php
  //session_start();
  include "../sesion/sesion.php";
?>
<?php 
    
    include '../conexion.php';
    include '../datos/funcionesDatos.php';


    if(!(isset($_POST["id"]))) {
      header('Location: ../index.php');
    }else{
       
      $queryEliminar = "DELETE FROM FacturaCompra WHERE  documentoProveedor=$1";
      $consultaEliminarLenguas = $queryEliminar;
      $namePrepareStatement="prepareStatementEliminarFacturaCompra";
      $obtenerCodigoEvento = $_POST["id"];

      //eliminarDatosFila("codigoClienteEliminar","DELETE FROM Clientes WHERE codigoCliente=$1;","prepareEliminarContenidoLeccion","El cliente se elimino.","../admin/index.php",$conexion);
      pg_prepare($conexion,$namePrepareStatement,$consultaEliminarLenguas) or die("Cannot prepare statement.");
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