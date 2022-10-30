
<?php
  
  //session_start();
  include "../sesion/sesion.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">

    <title>Producto eliminado</title>

    <script src="../assets/js/sweetalert2-10.js"></script>
    <!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
    <script src="../assets/js/jquery-3.6.1.min.js"></script>
    <!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
    <script src="../assets/js/mensajesPersonalizados.js" type="text/javascript"></script>

  </head>
  <body>
    <h1>Producto eliminado</h1>

    <?php 
    
    include '../conexion.php';
    include '../datos/funcionesDatos.php';
   
    eliminarDatosFila("codigoProductoEliminar","DELETE FROM Productos WHERE codigoProducto=$1;","prepareEliminarProducto","El producto se elimino correctamente.","../admin/index.php",$conexion);
  
    ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="../assets/js/jquery-3.6.1.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>    
    
    <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>

  </body>
</html>