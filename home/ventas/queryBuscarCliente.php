<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    
    if(!(isset($_POST['inputNitCliente']) )) {
      header('Location: ../index.php');
    }else{
      $nitCliente = $_POST['inputNitCliente'];

      $listadoTiposEventoUsuario = "SELECT * FROM Clientes WHERE  nitCliente=$1";
    
      //$ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
      pg_prepare($conexion,"queryListadoClientes",$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta listadoClientes");

      $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryListadoClientes",array($nitCliente));
    

      // para recuperar un solo dato se utiliza esto
      $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
      
      echo json_encode($row);       
      
    }

?>