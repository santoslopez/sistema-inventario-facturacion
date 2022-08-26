<?php  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php
  
  include '../conexion.php';
  
  $cliente= $_POST['nitDatos'];
  $direccion= $_POST['direccion'];
  $telefono= $_POST['telefono'];
  $nit = $_POST['empresaDatos'];

  // se valida que no se acceda en la url sin pasar por el formulario
  /*if(!(isset($_POST['inputCliente'],$_POST['inputDireccionCliente'],$_POST['inputTelefonoCliente'],$_POST['inputNitCliente']))) {
    header('Location: ../index.php');
  }else{   }*/
    
  $consulta = "SELECT PA_actualizarCliente('$nit','$cliente','$direccion','$telefono')";

  $ejecutarConsulta = pg_query($conexion,$consulta);
  $data = array();
  while ($row= pg_fetch_row($ejecutarConsulta)) {
    $subarray=array();
    $subarray[]=$row[0];
  }
  echo json_encode($subarray);

?>