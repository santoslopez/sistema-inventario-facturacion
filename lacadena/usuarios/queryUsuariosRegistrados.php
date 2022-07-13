<?php
  
  //session_start();
  include "../sesion/sesion.php";
?>

<html lang="en">
<head>
    <!--meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado lenguas</title-->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">

    <!-- Sweet Alert2 personalizado para no usar mensajes javascript sin personalizar --->
    <script src="../assets/js/sweetalert2-10.js"></script>
    <!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
    <script src="../assets/js/mensajesPersonalizados.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/tablaResponsive.css"/>

    <link rel="stylesheet" href="../assets/css/zoomImagen.css"/>
</head>
<body>
    <?php 
    include '../conexion.php';


    /*$numeroDatos = "SELECT * FROM Lenguas";
    $ejecutarConsultaNumeroDatos = pg_query($conexion,$numeroDatos);
    
    $cantidadDatos=0;
    while ($row= pg_fetch_row($ejecutarConsultaNumeroDatos)) {
        $cantidadDatos++;
    }
    echo "total registros: $cantidadDatos";
    $registrosPorPagina = 10;
    if(empty($_GET['pagina'])){
        $pagina=1;
    }else{
        $pagina=$_GET['pagina'];
    }
   $desde = ($pagina-1)*$registrosPorPagina;
   echo "desde: $desde";
   $totalPaginas = ceil($cantidadDatos / $registrosPorPagina);
   echo "total paginas: $totalPaginas";*/

   $variable = $_SESSION['nombreUsuario']; 

   $userName="santoslopez@google.com";
   
   $listadoTiposEventoUsuario = "SELECT * FROM Usuarios where correo!='lopeztsantos@gmail.com';";
    //echo "sex  $listadoTiposEventoUsuario";

    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    
    // verificamos que existen registros, sino no dibujamos la tabla
    if (!(pg_num_rows($ejecutarConsultaObtenerInfo))) {
        echo "<div class='alert alert-danger' role='alert'>
                No hay información de usuarios registrados.
              </div>
              <a class='btn btn-success' href='../usuarios/frmRegistrarUsuarios' role='button'>Registrar usuarios</a>";

    }else{                                    
    # Si hay datos, entonces dibujamos el encabezado una sola vez
    echo '
        <a href="../usuarios/frmRegistrarUsuarios" class="btn btn-success" role="button">Registrar usuarios</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Correo</td>
                    <td>Estado</td>
                    <td>Registrado</td>
                    <td>Nombre y apellidos</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>';
    # el contenido puede ir incrementandose 
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
        echo "<tr>";
        echo "<td data-label='CodLengua'>$row[0]</td>";
        echo "<td data-label='Lengua'><span class='status delivered'>$row[1]</span></td>";
        echo "<td data-label='Lengua'>$row[2]</td>";
        echo "<td data-label='Lengua'>$row[3]</td>";
        echo "<td><a href=../usuarios/frmModificarUsuariosRegistrados?correo=".urlencode($row[0])."&estadoActual=".urlencode($row[1])."&fechaRegistro=".urlencode($row[2])."&datos=".urlencode($row[3])."><img src='../assets/img/update.png' class='zoomImagen imagenTabla' alt='Actualizar contenido'></a></td>";
        echo "<td data-label='Eliminar'><a href=../usuarios/queryEliminarUsuario.php?correoEliminar=".urlencode($row[0])." class='opcionEliminarUsuario btn'><img src='../assets/img/delete.png' class='zoomImagen imagenTabla' alt='Eliminar contenido'></a></td>";
     
        //echo "<td data-label='Registrar modulo'><a href='../modulos/formRegistrarModulos.php?codigoLenguaObtener=$row[0]' class='btn'><img src='../img/mockup.png' class='zoomImagen' alt='Registrar modulo'></a></td>";

        echo "</tr>";                                               
    }
    echo "</tbody>
    </table>";        
    }
    pg_close($conexion);
    ?> 

    <script>
		/* 
      .opcionEliminarTiposEventos: corresponde al nombre de la propiedad "CLASS" que se le puso en el a href, dentro del while para mostrar los datos    
    */
		var nombreClassBotonEliminar = '.opcionEliminarUsuario';
		mensajeEliminarContenido(nombreClassBotonEliminar,"Eliminar usuario","Esto no se puede revertir","warning","Si, eliminar usuario.","../admin/index.php");
	</script>

</body>
</html>
