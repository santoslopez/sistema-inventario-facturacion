<?php
  
  //session_start();
  include "../sesion/sesion.php";
?>


<!doctype html>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">
    <script src="../assets/js/sweetalert2-10.js"></script>

    <title>Empresa registrado</title>
  </head>
  <body>
    <h1>Empresa registrado</h1>
    <?php
// importamos las variables globales para realizar la conexion y ejecutar las consultas para insertar datos.
include '../conexion.php';


if(!isset($nitEmpresa,$nombreEmpresa,$inputDireccion)) {
    header('Location: ../index.php');
}else{

/*
    En el POST colocamos el nombre del NAME de cada input del formulario donde ingresamos los datos
    El formulario corresponde al archivo registrarCuentas.html
*/
$nitEmpresa=htmlspecialchars($_POST['inputNitEmpresa'],ENT_QUOTES,'UTF-8');
$nombreEmpresa=htmlspecialchars($_POST['inputNombreEmpresa'],ENT_QUOTES,'UTF-8');
$inputDireccion=htmlspecialchars($_POST['inputDireccion'],ENT_QUOTES,'UTF-8');
$correo=$_SESSION["nombreUsuario"];


$verificarUsuario = "SELECT * FROM Empresas WHERE nitEmpresa=$1";
$namePrepare = "prepareVerificarEmpresa";

pg_prepare($conexion,$namePrepare,$verificarUsuario) or die("Cannot prepare statement: "+$namePrepare);

$ejecutarConsultaVerificarUsuario = pg_execute($conexion,$namePrepare,array($nitEmpresa));

if (pg_num_rows($ejecutarConsultaVerificarUsuario)) {
    //echo $ejecutarConsultaVerificarUsuario;
    echo "<script>Swal.fire(
        'Empresa',
        'La empresa no se registro. El nit esta en uso',
        'error'
      )</script>";	
}else{

$consulta  = sprintf("INSERT INTO Empresas(nitEmpresa,nombre,direccion,logoEmpresa,correo) VALUES('%s','%s','%s','%s','%s');",
pg_escape_string($conexion,($nitEmpresa)),
pg_escape_string($conexion,($nombreEmpresa)),
pg_escape_string($conexion,($inputDireccion)),
"default.png",
$correo

);

$ejecutarConsulta = pg_query($conexion, $consulta);
/**
 * Sino hay ningun error
 */
if ($ejecutarConsulta) {
    echo "<script>Swal.fire(
        'Empresa',
        'La empresa se registro',
        'success',
      )
      </script>
      ";  
}else{
    echo "<script>Swal.fire(
        'Empresa',
        'No se pudo guardar la empresa.',
        'error'
      )</script>";

}
}
//pg_close($conexion);
}
?>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>


  </body>