<!-- 
    Necesario para que esta pagina se pueda acceder si se inicio sesion por el usuario administrador
-->
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
    <title>Modificar producto</title>

	<!-- Sweet Alert2 personalizado para no usar mensajes javascript sin personalizar --->
    <script src="../assets/js/sweetalert2-10.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">



	<!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
	<script src="../js/mensajesPersonalizados.js" type="text/javascript"></script>
  </head>
  <body>
    <h1>Modificar producto</h1>
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

  $codigoProducto= $_POST['inputCodigoProducto'];
  $descripcionProducto = $_POST['inputDescripcionProducto'];
  //$estado= $_POST['inputEstado'];


  if(!isset($codigoProducto,$descripcionProducto)) {
    header('Location: ../admin/index.php');
    //exit('Por favor ingresa el nombre de usuario y password.');
  }else {


    $consultaModificarProductos = "UPDATE Productos SET descripcion=$1 WHERE codigoProducto=$2";

    $namePrepare = "prepareModificarProductos";

    pg_prepare($conexion,$namePrepare,$consultaModificarProductos) or die("Cannot prepare statement: "+ $namePrepare);
  
    $res = pg_execute($conexion,$namePrepare,array($descripcionProducto,$codigoProducto));
    

    if ($res) {
        echo "<script>Swal.fire(
            'Productos modificado',
            'Datos actualizados correctamente',
            'success',
          )
          </script>
          ";  
    } else {
        echo "<script>Swal.fire(
            'Producto',
            'Se produjo un error al querer actualizar los datos',
            'error'
          )</script>";
    }
  }
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>