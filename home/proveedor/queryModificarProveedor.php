<?php  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php
  include '../conexion.php';

  if(!(isset($_POST['nombreApellidos'],$_POST['nitCliente'],$_POST['direccion'],$_POST['telefono']) )) {
    header('Location: ../index.php');
  }else{
    //$nit= $_POST['nitCliente'];
    //$empresa= $_POST['nombreApellidos'];
    $obtenerNit=htmlspecialchars($_POST["nitCliente"],ENT_QUOTES,'UTF-8');
    $nit = pg_escape_string($obtenerNit);

    $obtenerEmpresa=htmlspecialchars($_POST["nombreApellidos"],ENT_QUOTES,'UTF-8');
    $empresa = pg_escape_string($obtenerEmpresa);

    $obtenerDireccion=htmlspecialchars($_POST["direccion"],ENT_QUOTES,'UTF-8');
    $direccion = pg_escape_string($obtenerDireccion);

    $telefono= $_POST['telefono'];
  
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
