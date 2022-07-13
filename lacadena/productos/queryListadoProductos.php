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

   //$variable = $_SESSION['nombreUsuario']; 

   //$userName="santoslopez@google.com";
   
   $queryListadoProductos = "SELECT * FROM Productos;";

    $ejecutarConsulta = pg_query($conexion,$queryListadoProductos);
    
    // verificamos que existen registros, sino no dibujamos la tabla
    if (!(pg_num_rows($ejecutarConsulta))) {
        echo "<div class='alert alert-danger' role='alert'>
                No hay productos registrados actualmente.
              </div>
              <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#formularioAgregarProductos'>
              Registrar productos
          </button>              
              ";

    }else{                                    
    # Si hay datos, entonces dibujamos el encabezado una sola vez
    echo '
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarProductos">
        Registrar productos
    </button>
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>CODIGO</td>
                    <td>Descripcion</td>
                    <td>Modificar</td>
                    <td>Eliminar</td>
                </tr>
            </thead>
            <tbody>';
    # el contenido puede ir incrementandose 
    while ($row= pg_fetch_row($ejecutarConsulta)) {
        // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
        echo "<tr>";
        echo "<td data-label='Lengua'><span class='status delivered'>$row[0]</span></td>";
        echo "<td data-label='Lengua'>$row[1]</td>";
        echo "<td><a href=../productos/frmModificarProductos.php?codigoProducto=".urlencode($row[0])."&descripcionProducto=".urlencode($row[1])."><img src='../assets/img/update.png' class='zoomImagen imagenTabla' alt='Actualizar contenido'></a></td>";
        echo "<td data-label='Eliminar'><a href=../productos/queryEliminarProducto.php?codigoProductoEliminar=".urlencode($row[0])." class='opcionEliminarUsuario btn'><img src='../assets/img/delete.png' class='zoomImagen imagenTabla' alt='Eliminar contenido'></a></td>";
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
		// .opcionEliminarTiposEventos: corresponde al nombre de la propiedad "CLASS" que se le puso en el a href, dentro del while para mostrar los datos    
		var nombreClassBotonEliminar = '.opcionEliminarUsuario';
		mensajeEliminarContenido(nombreClassBotonEliminar,"Eliminar usuario","Esto no se puede revertir","warning","Si, eliminar usuario.","../admin/index.php");
	</script>

<!-- inicio agregar cliente action="javascript:void()" -->
<!-- Modal -->
<div class="modal fade" id="formularioAgregarProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Codigo producto</label>
                <input type="text" name="inputCodigoProducto" class="form-control" id="inputCodigoProducto" placeholder="Codigo producto" required>
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Nombre</label>
                <input type="text" name="inputNombreProducto" class="form-control" id="inputNombreProducto" placeholder="Nombre" require>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar datos</button>
      </div>
      </form>

    </div>
  </div>
</div>
<!-- fin agregar cliente -->


<script>
    $(document).on('submit','#guardarDatosFormulario',function(event){
        event.preventDefault();
        //var nitCliente=$('#inputNit').val();
        var inputCodigoProducto=$('#inputCodigoProducto').val();
        var inputNombreProducto=$('#inputNombreProducto').val();
        //var telefono=$('#inputTelefono').val();
        if((inputCodigoProducto!='') && (inputNombreProducto!='') ){
            $.ajax({
                url:"queryRegistrarProductos.php",
                data:{inputCodigoProducto:inputCodigoProducto,inputNombreProducto:inputNombreProducto},
                type:'post',
                
                    success:function(data1){
                        var json = JSON.parse(data1);
            
                        var status = json.status;
                        if(status=='yaexistenoguardado'){ 
                            Swal.fire(
                                'Producto no registrado',
                                'El codigo del producto esta en uso.',
                                'warning'
                            )
                        }else if(status=='success'){
                            $('#inputCodigoProducto').val('');
                            $('#inputNombreProducto').val('');

                            $('#formularioAgregarProductos').modal('hide');
                            //cargarDatosTabla();
                            //var table = $('#datatableUsuarios').DataTable();
                            //table.ajax.reload();

                            Swal.fire(
                                'Producto registrado',
                                'Los datos se guardaron correctamente.',
                                'success'
                            )

                            //window.location.href = "queryListadoProductos.php";
                            
                        }else{
                            Swal.fire(
                                'Producto no guardado.',
                                'Los datos no se guardaron.',
                                'warning'
                            )
                        }
                    }
                }
            );
        }else{
            alert("please fill the required fields");
        }
    });
</script>


</body>
</html>
