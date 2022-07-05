
<?php

  include "../sesion/sesion.php";

  include '../conexion.php';

  // LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

  $nombreEmpresa=htmlspecialchars($_POST['nombreApellidos'],ENT_QUOTES,'UTF-8');

  $nit=htmlspecialchars($_POST['nitCliente'],ENT_QUOTES,'UTF-8');
  
  $direccion=htmlspecialchars($_POST['direccion'],ENT_QUOTES,'UTF-8');
  $telefono=htmlspecialchars($_POST['telefono'],ENT_QUOTES,'UTF-8');

  $consulta  = sprintf("INSERT INTO Proveedor(nitProveedor,nombreEmpresa,logo,direccion,telefono) VALUES('%s','%s','%s','%s','%s');",
  pg_escape_string($nit),
  pg_escape_string($nombreEmpresa),
  "",
  pg_escape_string($direccion),
  pg_escape_string($telefono)
  
  );
  
  $ejecutarConsulta = pg_query($conexion, $consulta);

if ($ejecutarConsulta) {
    $data = array();
    $data['status'] = 'success';
    echo json_encode($data);
}else{
  $data = array();
  $data['status'] = 'failed';
  echo json_encode($data);
}
?>