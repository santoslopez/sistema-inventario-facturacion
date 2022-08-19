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
/*
    En el POST colocamos el nombre del NAME de cada input del formulario donde ingresamos los datos
    El formulario corresponde al archivo registrarCuentas.html
*/
$nitEmpresa=htmlspecialchars($_POST['inputNitEmpresa'],ENT_QUOTES,'UTF-8');
$nombreEmpresa=htmlspecialchars($_POST['inputNombreEmpresa'],ENT_QUOTES,'UTF-8');
$inputDireccion=htmlspecialchars($_POST['inputDireccion'],ENT_QUOTES,'UTF-8');
$correo=$_SESSION["nombreUsuario"];

//htmlspecialchars($_POST['inputTelefono'],ENT_QUOTES,'UTF-8');
//date_default_timezone_set('America/Guatemala');    
//$fechaActual = date('d-m-Y H:i:s',time());
if(!isset($nitEmpresa,$nombreEmpresa,$inputDireccion)) {
    header('Location: ../index.php');
}
//Encriptamos la contraseña- NO IMPLEMENTADO EN POSTGRESQL
//$passwordEncriptado = password_hash($passw,PASSWORD_BCRYPT);
/**
 * Verificamos que el correo a registrar no este en uso, si lo esta no se guardan los datos.
 */
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
// Previniendo Inyecion SQL
//$consultaInsert = "INSERT INTO Usuarios(datosUsuario,correo,passwordUsuario) VALUES ($1,$2,$3)";
/**
 * pg_query: corresponde para ejecutar la consulta para PostgreSQL
 * 
 * $conexion: está variable corresponde a la variable global del archivo conexion.php
 */

//pg_prepare($conexion,"prepare1",$consultaInsert) or die("Cannot prepare statement .");

$consulta  = sprintf("INSERT INTO Empresas(nitEmpresa,nombre,direccion,logoEmpresa,correo) VALUES('%s','%s','%s','%s','%s');",
pg_escape_string($nitEmpresa),
pg_escape_string($nombreEmpresa),
pg_escape_string($inputDireccion),
"default.png",
$correo
//password_hash($passw, PASSWORD_DEFAULT,['cost'=>12])
//pg_escape_string(strtolower($idTipoCuenta)) 
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
//pg_close($conexion);
}
?>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>