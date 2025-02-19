<?php
    include "../sesion/sesion.php";
?>

<html lang="en">
<head>
   
    <!-- Sweet Alert2 personalizado para no usar mensajes javascript sin personalizar --->
    <script src="../assets/js/sweetalert2-10.js"></script>

    <!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
    <script src="../assets/js/jquery-3.6.1.min.js"></script>
    <!-- Por medio de este archivo mostramos un mensaje de confirmacion para eliminar, actualizar datos.-->
    <script src="../assets/js/mensajesPersonalizados.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">


    <link rel="stylesheet" href="../assets/css/zoomImagen.css"/>
    <title>Perfil de empresa</title>


</head>
<body>
    <div class="container">
        <div class="alert alert-primary" role="alert" style="margin-top:20px">
            <h2>Perfil de empresa</h2>
        </div>
    <?php 
    include '../conexion.php';
    
    $getUser = $_SESSION["nombreUsuario"];

    $listadoTiposEventoUsuario = "SELECT * FROM Empresas WHERE codigoUsuario=$1";

    pg_prepare($conexion,"queryEmpresa",$listadoTiposEventoUsuario) or die ("No se pudo preparar la consulta queryEmpresa");

    $ejecutarConsultaObtenerInfo = pg_execute($conexion,"queryEmpresa",array(1));

    // verificamos que existen registros, sino no dibujamos la tabla
    if (!(pg_num_rows($ejecutarConsultaObtenerInfo))) {
        echo "<div class='alert alert-danger' role='alert'>
                No hay ninguna empresa registrado.
              </div>
              <a class='btn btn-success' href='../empresa/frmRegistrarEmpresa.php'>
                                Registrar empresa
              </a>";
    }else{                                    
    # Si hay datos, entonces dibujamos el encabezado una sola vez
    echo '
        <a href="../empresa/frmRegistrarEmpresa" class="btn btn-success">
            Registrar empresa
            <img src="../assets/img/add.png" class="zoomImagen imagenTabla" alt="Registrar empresa">
        </a>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <td>Nit</td>
                    <td>Nombre</td>
                    <td>Direccion</td>
                    <td>Modificar</td>
                </tr>
            </thead>
            <tbody>';
    # el contenido puede ir incrementandose 
    while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
        // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
        echo "<tr>";
        //echo "<td data-label='CodLengua'>$row[0]</td>";
        echo "<td data-label='Lengua'><span class='status delivered'>$row[0]</span></td>";
        echo "<td data-label='Lengua'>$row[1]</td>";
        echo "<td data-label='Lengua'>$row[2]</td>";
        echo "<td data-label='Lengua'>$row[4]</td>";
        echo "<td><a href=../empresa/frmModificarEmpresa?inputNitEmpresa=".urlencode($row[0])."&inputNombreEmpresa=".urlencode($row[1])."&inputDireccion=".urlencode($row[2])."&nombreUsuario=".urlencode($row[3])."><img src='../assets/img/update.png' class='zoomImagen imagenTabla' alt='Actualizar contenido'></a></td>";       
        echo "</tr>";                                               
    }
    echo "</tbody>
    </table>";        
    }
    //pg_close($conexion);

    ?> 
        <a class="btn btn-primary" href="javascript:history.back()" role="button">Menu principal</a>
        
    </div>

    <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>


    <script>
		/* 
      .opcionEliminarTiposEventos: corresponde al nombre de la propiedad "CLASS" que se le puso en el a href, dentro del while para mostrar los datos    
    */
		var nombreClassBotonEliminar = '.opcionEliminarCliente';
		mensajeEliminarContenido(nombreClassBotonEliminar,"Eliminar cliente","Esto no se puede revertir","warning","Si, eliminar informacion.","../admin/index.php");
	</script>

</body>
</html>