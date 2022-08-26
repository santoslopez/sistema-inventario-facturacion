<?php  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php
  include '../conexion.php';
  
  $nit= $_POST['nitCliente'];
  $empresa= $_POST['nombreApellidos'];
  $direccion = $_POST['direccion'];
  $telefono= $_POST['telefono'];


  if(!(isset($_POST['nombreApellidos'],$_POST['nitCliente'],$_POST['direccion'],$_POST['telefono']) )) {
    header('Location: ../index.php');
  }else{

    $consulta = "SELECT PA_modificarProveedor('$nit','$empresa','$direccion','$telefono')";

    $ejecutarConsulta = pg_query($conexion,$consulta);
    //$data = array();
    $subarray=array();
    while ($row= pg_fetch_row($ejecutarConsulta)) {
      $subarray[]=$row[0];
    }
    echo json_encode($subarray);

  }

?>
