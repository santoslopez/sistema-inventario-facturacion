<?php  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php
  
  include "../conexion.php";

  if(!isset($_POST["nitDatos"],$_POST["direccion"],$_POST["telefono"],$_POST["empresaDatos"])) {
    header("Location: ../index.php");
  }else{
    $cliente= $_POST["nitDatos"];
    $direccion= $_POST["direccion"];
    $telefono= $_POST["telefono"];
    $nit = $_POST["empresaDatos"];

  $consulta = "SELECT PA_actualizarCliente('$nit','$cliente','$direccion','$telefono')";

  $ejecutarConsulta = pg_query($conexion,$consulta);
  $data = array();
  while ($row= pg_fetch_row($ejecutarConsulta)) {
    $subarray=array();
    $subarray[]=$row[0];
  }
  echo json_encode($subarray);
}

?>