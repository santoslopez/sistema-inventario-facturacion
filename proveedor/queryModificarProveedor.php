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
    <title>Modificar proveedor</title>

	<!-- Sweet Alert2 personalizado para no usar mensajes javascript sin personalizar --->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">



	<!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
	<script src="../js/mensajesPersonalizados.js" type="text/javascript"></script>
  </head>
  <body>
    <h1>Modificar proveedor</h1>
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
  $nit= $_POST['inputNit'];
  $empresa= $_POST['inputEmpresa'];
  $direccion = $_POST['inputDireccion'];
  $telefono= $_POST['inputTelefono'];


  if(!isset($empresa,$direccion,$telefono,$nit)) {
    header('Location: ../admin/index.php');
    //exit('Por favor ingresa el nombre de usuario y password.');
  }else {
    # code...
    $consultaModificarModulos = "UPDATE Proveedor SET nombreEmpresa=$1,direccion=$2,telefono=$3 WHERE nitproveedor=$4";

    $namePrepare = "prepareModificarProveedor";
    
    pg_prepare($conexion,$namePrepare,$consultaModificarModulos) or die("Cannot prepare statement.");
  
    $res = pg_execute($conexion,$namePrepare,array($empresa,$direccion,$telefono,$nit));
    
    //echo "consulta: $res  xxx: $consultaModificarModulos nombre empresa: $empresa, direccion: $direccion telefono: $telefono nit: $nit";

    if ($res) {
        echo "<script>Swal.fire(
            'Proveedor',
            'Datos actualizados!',
            'success',
          )
          </script>
          ";  
    } else {
        echo "<script>Swal.fire(
            'Proveedor',
            'Datos no modificados',
            'error'
          )</script>";
    }
  }
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>