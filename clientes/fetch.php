<?php

include "../conexion.php";


$sql = "SELECT * FROM USUARIOS";
$query = pg_query($conexion,$sql);

?>