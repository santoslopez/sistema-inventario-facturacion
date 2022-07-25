<?php

/*$array_num1 = array();
$array_num1[]=10;
$array_num1[]=20;
$array_num1[]=100;*/

echo $array_num1[0];


$array = [
    "foo" => "bar",
    "bar" => "foo",
];
//echo $array['foo'];


/** Arreglo multidimensional 
 * Para recorrer el arreglo muldimensional se realiza lo siguiente
 *  */ 
$arrays1 = [[10, 100], [20, 200], [30, 300]];

foreach ($arrays1 as $arrays1) {
    echo($arrays1[0] . ', '); // 3, 7, 11, 
}


$arrayA = [
    ['id' => 1, 'title' => 'tree'],
    ['id' => 2, 'title' => 'sun'],
    ['id' => 3, 'title' => 'cloud'],
];
 
//$ids = array_column($arrayA, 'id');
 
//print_r($ids); // [1, 2, 3]


?>