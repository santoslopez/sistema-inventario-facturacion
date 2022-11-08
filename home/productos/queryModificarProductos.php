<?php  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php
  include '../conexion.php';
  

  if(!(isset($_POST['nombreApellidos'],$_POST['nitCliente']) )) {
    header('Location: ../index.php');
  }else{
    $nit= $_POST['nitCliente'];
    $empresa= $_POST['nombreApellidos'];
  
    $consulta = "SELECT PA_modificarProductos('$nit','$empresa')";

    $ejecutarConsulta = pg_query($conexion,$consulta);
    //$data = array();
    $subarray=array();
    while ($row= pg_fetch_row($ejecutarConsulta)) {
      $subarray[]=$row[0];
    }
    echo json_encode($subarray);

  }

?>
