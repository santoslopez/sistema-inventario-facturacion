<?php
  
  //session_start();
  include "../sesion/sesion.php";
?>

<html lang="en">
<head>
    <?php
    
    //session_start();
    include "../includes/head.php";
    ?>
</head>
<body>
    <?php 
    include '../conexion.php';


   //$variable = $_SESSION['nombreUsuario']; 

   //$userName="santoslopez@google.com";
   
   
      echo '<div class="container"><a href="../usuarios/frmRegistrarUsuarios" class="btn btn-success" role="button">Registrar usuarios</a>
      <table class="table table-striped table-bordered nowrap" id="datatableUsuarios" name="datatableUsuarios" style="width:100%">
          <thead>
                  <th>Correo</th>
                  <th>Estado</th>
                  <th>Registrado</th>
                  <th>Nombre y apellidos</th>
                  <th></th>
                  <th></th>
          </thead>
          <tbody>
          </tbody>
      </table></div>';
    ?> 

<script>

        
/*** Nota importante: en data tienen que ir los valores en minuscula de la tabla que queremos mostrar sus datos
 */
    $(document).ready(function(){
        $('#datatableUsuarios').DataTable({
            "ajax":{
                "url":"queryUsuarios.php",
                "dataSrc":""
            },
            "processing": true,
            //"serverSide": true,
            /*"columns":[
                {"data":"nombreapellidos"},
                {"data":"direccion"},
                {"data":"nitcliente"},
                {"data":"telefono"}
            ]*/
            "lengthMenu": [
                //[10,15, -1],
                //[10,20, 'All'],
                [10,15],
                [10,15],
            ],
            "language":{
                "url":"https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
            },
            "responsive": true,
        });
    });
    //eliminarDatos(".activarEliminar","#datatableUsuarios","queryEliminarClientes.php",'Cliente eliminado correctamente.',"El cliente no se pudo eliminar se produjo un error","¿Confirmar eliminación de cliente?","Sí, eliminar datos de cliente");
</script>


    <script>
		/* 
      .opcionEliminarTiposEventos: corresponde al nombre de la propiedad "CLASS" que se le puso en el a href, dentro del while para mostrar los datos    
    */
		var nombreClassBotonEliminar = '.opcionEliminarUsuario';
		mensajeEliminarContenido(nombreClassBotonEliminar,"Eliminar usuario","Esto no se puede revertir","warning","Si, eliminar usuario.","../admin/index.php");
	</script>

</body>
</html>
