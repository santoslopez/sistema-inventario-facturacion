<?php
    include "../sesion/sesion.php";
  include "../config/config.php";
?>

<?php 
    include '../conexion.php';

    $nitCliente = $_POST['inputNitCliente'];
    
    if(!(isset($_POST['inputNitCliente']) )) {
      header('Location: ../index.php');
    }else{
      $listadoTiposEventoUsuario = "SELECT * FROM Clientes WHERE  nitCliente='$nitCliente'";
    
      $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
      
      // para recuperar un solo dato se utiliza esto
      $row=pg_fetch_assoc($ejecutarConsultaObtenerInfo);
      
      echo json_encode($row);       
      
    }

?>