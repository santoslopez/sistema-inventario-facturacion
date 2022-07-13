
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
    <title>Modificar cliente</title>

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
    <h1>Modificar cliente</h1>
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
  $cliente= $_POST['inputCliente'];
  $direccion= $_POST['inputDireccionCliente'];
  $nit = $_POST['inputNitCliente'];
  $telefono= $_POST['inputTelefonoCliente'];


  if(!isset($cliente,$direccion,$nit,$telefono)) {
    header('Location: ../index.php');
    //exit('Por favor ingresa el nombre de usuario y password.');
  }else {
    # code...
    $consultaModificarModulos = "UPDATE Clientes SET nombreApellidos=$1,direccion=$2,telefono=$3 WHERE nitCliente=$4";

    $namePrepare = "prepareModificarCliente";
    
    pg_prepare($conexion,$namePrepare,$consultaModificarModulos) or die("Cannot prepare statement.");
  
    $res = pg_execute($conexion,$namePrepare,array(openssl_decrypt($cliente,AES,KEY),$direccion,$telefono,$nit));
    
    //echo "consulta: $res  xxx: $consultaModificarModulos nombre empresa: $empresa, direccion: $direccion telefono: $telefono nit: $nit";

    if ($res) {
        echo "<script>Swal.fire(
            'Cliente',
            'Datos actualizados!',
            'success',
          )
          </script>
          ";  
    } else {
        echo "<script>Swal.fire(
            'Cliente',
            'Datos no modificados',
            'error'
          )</script>";
    }
  }
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>