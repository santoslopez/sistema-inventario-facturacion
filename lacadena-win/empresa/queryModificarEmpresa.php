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
    <title>Modificar empresa</title>

    <script src="../assets/js/sweetalert2-10.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">



	<!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
	<script src="../assets/js/jquery-3.6.1.min.js"></script>

	<!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
	<script src="../js/mensajesPersonalizados.js" type="text/javascript"></script>
  </head>
  <body>
    <h1>Modificar empresa</h1>
    <a href="../index">Menu principal</a>
    <?php
  /**
   * Archivo necesario para obtener la variable $conexion necesario para conectarse a la base de datos.
   */
  include '../conexion.php';

  /**
   * txtCorreoSession, txtNuevoTipoEvento, txtCorreoIdTipo: estos nombres son los que posse la propiedad
   * NAME del formulario en el archivo formularioModificarTiposEventos.php
   */
  $nitEmpresa=htmlspecialchars($_POST['inputNitEmpresa'],ENT_QUOTES,'UTF-8');
  $nombreEmpresa=htmlspecialchars($_POST['inputNombreEmpresa'],ENT_QUOTES,'UTF-8');
  $inputDireccion=htmlspecialchars($_POST['inputDireccion'],ENT_QUOTES,'UTF-8');
  

  //echo "estoy aqui  $correo $nitEmpresa $nombreEmpresa $inputDireccion";

  if(!isset($nitEmpresa,$nombreEmpresa,$inputDireccion)) {
    header('Location: ../index.php');
    //exit('Por favor ingresa el nombre de usuario y password.');
  }else {
    # code...
    $correo=$_SESSION['nombreUsuario'];

    $consultaModificarModulos = "UPDATE Empresas SET nombre=$1,direccion=$2 WHERE nitEmpresa=$3";

    //echo "estoy aqui  $consultaModificarModulos";

    $namePrepare = "prepareModificarEmpresa";
    
    pg_prepare($conexion,$namePrepare,$consultaModificarModulos) or die("Cannot prepare statement: "+$namePrepare);
  
    $res = pg_execute($conexion,$namePrepare,array($nombreEmpresa,$inputDireccion,$nitEmpresa));
    

    if ($res) {
        echo "<script>Swal.fire(
            'Empresa',
            'Los datos de la empresa se actualizaron',
            'success',
          )
          </script>
          "; 
    } else {
        echo "<script>Swal.fire(
            'Empresa',
            'No se guardaron los datos de la emrpesa, se produjo un error.',
            'error'
          )</script>";

          //echo "xxxx: $res";

    }
  }
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>