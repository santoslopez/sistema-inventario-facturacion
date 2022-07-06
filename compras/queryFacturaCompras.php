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
   
   $queryListadoProductos = "SELECT * FROM FacturaCompra;";

    $ejecutarConsulta = pg_query($conexion,$queryListadoProductos);
    
    // verificamos que existen registros, sino no dibujamos la tabla
    if (!(pg_num_rows($ejecutarConsulta))) {
        echo "<div class='alert alert-danger' role='alert'>
                No hay ninguna factura de compra registrado.
              </div>
              <a class='btn btn-success' href='../compras/frmRegistrarFacturaCompra.php' role='button'>Registrar factura compra</a>";

    }else{                                    
    # Si hay datos, entonces dibujamos el encabezado una sola vez
    echo '
        <a href="../compras/frmRegistrarFacturaCompra.php" class="btn btn-success" role="button">Registrar factura compra</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>CODIGO</td>
                    <td>No. documento proveedor</td>
                    <td>Fecha ingresado</td>
                    <td>Fecha factura proveedor</td>
                    <td>Nit proveedor</td>
                </tr>
            </thead>
            <tbody>';
    # el contenido puede ir incrementandose 
    while ($row= pg_fetch_row($ejecutarConsulta)) {
        // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
        echo "<tr>";
        echo "<td data-label='Lengua'><span class='status delivered'>$row[0]</span></td>";
        echo "<td data-label='Lengua'>$row[1]</td>";
        echo "<td data-label='Lengua'>$row[2]</td>";
        echo "<td data-label='Lengua'>$row[3]</td>";
        echo "<td data-label='Lengua'>$row[4]</td>";
        //echo "<td><a href=../productos/frmModificarProductos.php?codigoProducto=".urlencode($row[0])."&descripcionProducto=".urlencode($row[1])."><img src='../assets/img/update.png' class='zoomImagen imagenTabla' alt='Actualizar contenido'></a></td>";
        //echo "<td data-label='Eliminar'><a href=../productos/queryEliminarProducto.php?codigoProductoEliminar=".urlencode($row[0])." class='opcionEliminarUsuario btn'><img src='../assets/img/delete.png' class='zoomImagen imagenTabla' alt='Eliminar contenido'></a></td>";
        echo "</tr>";                                               
    }
    echo "</tbody>
    </table>
    <a href='../index.php' class='btn btn-primary' role='button'>Regresar menu principal</a>
    ";        
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
