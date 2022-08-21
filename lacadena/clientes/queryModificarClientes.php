<?php  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php
  
  include '../conexion.php';
  
  $cliente= $_POST['inputCliente'];
  $direccion= $_POST['inputDireccionCliente'];
  $telefono= $_POST['inputTelefonoCliente'];
  $nit = $_POST['inputNitCliente'];

  // se valida que no se acceda en la url sin pasar por el formulario
  if(!(isset($_POST['inputCliente'],$_POST['inputDireccionCliente'],$_POST['inputTelefonoCliente'],$_POST['inputNitCliente']))) {
    header('Location: ../index.php');
  }else{

    $consultaModificarCliente = "UPDATE Clientes SET nombreApellidos=$1,direccion=$2,telefono=$3 WHERE nitCliente=$4";

    $namePrepare = "prepareModificarCliente";
      
    pg_prepare($conexion,$namePrepare,$consultaModificarCliente) or die("Cannot prepare statement.");
    
    $res = pg_execute($conexion,$namePrepare,array($cliente,$direccion,$telefono,$nit));
    
    try {
      if ($res) {
        $data = array();
        $data['status'] = 'success';
        echo json_encode($data);
      } else {
        $data['status'] = 'failedupdate';
        echo json_encode($data);
      }
    } catch (Exception $e) {
      echo json_encode($e->getMessage());
    }

  }



?>