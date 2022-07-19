
<?php

include "../sesion/sesion.php";

include '../conexion.php';

// LOS VALORES QUE SE COLOCAN EN EL POST CORRESPONDE A LO QUE SE ESTA ENVIANDO EN  data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono}

$codigoProducto=htmlspecialchars($_POST['inputCodigoProducto'],ENT_QUOTES,'UTF-8');
$descripcionProducto=htmlspecialchars($_POST['inputNombreProducto'],ENT_QUOTES,'UTF-8');


// Realizar una verificacion que el codigo del producto no este registrado
$consultaVerificarExistenciaProducto = "SELECT * FROM Productos where codigoProducto=$1";

pg_prepare($conexion,"prepareVerificarProductos",$consultaVerificarExistenciaProducto) or die("Cannot prepare statement verificar productos existentes.");

$ejecutarConsultaVerificarProducto  = pg_execute($conexion,"prepareVerificarProductos",array($codigoProducto));


if(pg_num_rows($ejecutarConsultaVerificarProducto)) {
  $data['status'] = 'yaexistenoguardado';
  echo json_encode($data);

}else{

  /*$consulta  = sprintf("INSERT INTO Productos(codigoProducto,descripcion) VALUES('%s','%s');",
  pg_escape_string($codigoProducto),
  pg_escape_string($descripcionProducto)
  );*/
  $cod = pg_escape_string($codigoProducto);
  $des = pg_escape_string($descripcionProducto);
  $imagen = "default.png";
  
  $consulta = "SELECT PA_insertarProducto('$cod','$des','$imagen')";
  
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
}

?>