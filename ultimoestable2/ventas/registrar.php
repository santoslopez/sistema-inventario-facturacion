<?php


include 'conexion.php';


  $aaa = $_POST['tableJSON']; // 
  //$nit=json_decode($_POST['tableJSON']); NO FUNCIONO CON ESTO
  // $table = json_decode(filter_input($aaa,'tableJSON')); NO FUNCIONA

  $arrays12 = json_decode(filter_input(INPUT_POST,'tableJSON'));


  $corcheteSimple="'";
  foreach ($arrays12 as $arrays12) {
    $resultado='('.$corcheteSimple.$arrays12[0].$corcheteSimple.','.$corcheteSimple.$arrays12[1].$corcheteSimple.','.$corcheteSimple.$arrays12[2].$corcheteSimple.','.$corcheteSimple.$arrays12[3].$corcheteSimple.'),';
    $queryInsertMultipleConComa.=$resultado;
  }

  $queryInsertMultiple=rtrim($queryInsertMultipleConComa,",");
  $queryFinal=$queryInsertMultiple.';';

  
  $consulta =  "INSERT INTO Productos2(codigoProducto,descripcion,foto,costo) VALUES $queryFinal";
  //$consulta = "SELECT PA_registrarCompra123$queryFinal";

  $ejecutarConsulta = pg_query($conexion,$consulta);
 if ($ejecutarConsulta) {
    echo json_encode($consulta);

  }else{
    echo json_encode($consulta);
  }
?>