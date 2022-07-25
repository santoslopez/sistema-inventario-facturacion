
<?php


include 'conexion.php';


  $aaa = $_POST['tableJSON']; // 
  //$nit=json_decode($_POST['tableJSON']); NO FUNCIONO CON ESTO
  // $table = json_decode(filter_input($aaa,'tableJSON')); NO FUNCIONA

  $array_num = json_decode(filter_input(INPUT_POST,'tableJSON'));

  $longitud = count($array_num);


  $data1 = array();
  $valoresInsert = array();

  $contador=0;
      //echo($arrays1[0] . ', '); // 3, 7, 11, 
      $corcheteSimple="'";
  foreach ($array_num as $array_num) {
    $get = "(".$corcheteSimple.$array_num[0].$corcheteSimple.','.$corcheteSimple.$array_num[1].$corcheteSimple.','.$corcheteSimple.$array_num[2].$corcheteSimple.','.$corcheteSimple.$array_num[3].$corcheteSimple.")";

    $valoresInsert[] = $get;

    $consulta = "INSERT INTO Productos2(codigoProducto,descripcion,foto,costo) VALUES ".$valoresInsert[0].','.$valoresInsert[1];
    $ejecutarConsulta = pg_query($conexion, $consulta);

    if ($ejecutarConsulta) {
      # code...
      echo json_encode("good");

    }else{
      echo json_encode("fail"+$consulta);

    }

    //$data1[]=$consulta;
    $contador++;
  }


  //echo json_encode($valoresInsert);
  //echo json_encode($valoresInsert);





 ?>