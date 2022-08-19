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

    $consultaModificarModulos = "UPDATE Proveedor SET nombreEmpresa=$2,direccion=$3,telefono=$4 WHERE nitproveedor=$1";

    $namePrepare = "prepareModificarProveedor";
    
    pg_prepare($conexion,$namePrepare,$consultaModificarModulos) or die("Cannot prepare statement.");
  
    $res = pg_execute($conexion,$namePrepare,array($nit,$empresa,$direccion,$telefono));
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
?>
