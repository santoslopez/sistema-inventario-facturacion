<?php
  
  //session_start();
  include "../sesion/sesion.php";
?>

<html lang="en">
<head>

    <!-- Bootstrap CSS -->
    <title>Listado de productos</title>
    <?php
        //session_start();
        include "../includes/head.php";
    ?>
    <link rel="stylesheet" href="assets/css/tableResponsive.css"/>

</head>
<body>
    <?php 
    include '../conexion.php';

    $porpagina = 10;

    if (isset($_GET['pagina'])) {
        # code...
        $pagina=$_GET['pagina'];
    } else {
        $pagina=1;
    }

    $empieza = ($pagina-1) * $porpagina;
   
   $queryListadoProductos = "SELECT * FROM Productos LIMIT $porpagina OFFSET $empieza";

    $ejecutarConsulta = pg_query($conexion,$queryListadoProductos);
    
    // verificamos que existen registros, sino no dibujamos la tabla
    if (!(pg_num_rows($ejecutarConsulta))) {
        echo "<div class='alert alert-danger' role='alert' style='margin-left:5%;margin-right:5%;margin-top:5%'>
                No hay productos registrados actualmente.
              </div>
              <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#formularioAgregarProductos'>
              Registrar productos
          </button>              
              ";

    }else{       
    # Si hay datos, entonces dibujamos el encabezado una sola vez
    echo '
    <div class="alert alert-success" role="alert" style="margin-left:5%;margin-right:5%;margin-top:5%">
        Registro y listado de productos
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarProductos">
            Registrar productos
        </button>
    </div>
    <div class="container"><table class="table">
            <thead>
                <tr>
                <th scope="col">CODIGO</th>
                <th scope="col">Descripcion</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';
    # el contenido puede ir incrementandose 
    while ($row= pg_fetch_row($ejecutarConsulta)) {
        // codigoTipo: este valor lo vamos a recuperar en el archivo eliminarTiposEventos.php
        echo "<tr>";
        echo "<td data-label='Codigo'><span class='status delivered'>$row[0]</span></td>";
        echo "<td data-label='Descripcion'>$row[1]</td>";
        echo "<td data-label='Modificcar'><a href=../productos/frmModificarProductos.php?codigoProducto=".urlencode($row[0])."&descripcionProducto=".urlencode($row[1])."><img src='../assets/img/update.png' class='zoomImagen' alt='Actualizar contenido' style='width: 20px;heigth: 20px;px;'></a><a href=../productos/queryEliminarProducto.php?codigoProductoEliminar=".urlencode($row[0])." class='opcionEliminarUsuario btn'><img src='../assets/img/delete.png' class='zoomImagen' alt='Eliminar contenido' style='width: 20px;heigth: 20px;px;'></a></td>";
        echo "</tr>";                                               
    }
    echo "</tbody></table></div>";        
    }


    //paginacion    
    $query="SELECT * FROM  Productos";
    $resultado=pg_query($conexion,$query);
       
    $total_registros=pg_num_rows($resultado);
    $total_paginas=ceil($total_registros/$porpagina);
   
    echo"<nav aria-label='Nav'><ul class='pagination justify-content-center'><li class='page-item'><a href='queryListadoProductos.php?pagina=1' class='page-link'>"  .'Anterior'. "</a></li>";
    for($i=1;$i<=$total_paginas; $i++)
    {    
    echo"<li class='page-item'><a href='queryListadoProductos.php?pagina=".$i."' class='page-link'> ".$i." </a></li>";

    }

    echo"<li class='page-item'><a href='queryListadoProductos.php?pagina=$total_paginas' class='page-link'>"  .'Siguiente'. "</a></li></ul>
    </nav>";

    echo "<div class='d-grid gap-2 col-6 mx-auto'>
    <a href='../index.php' class='btn btn-primary justify-content-center' role='button'>Regresar menu principal</a>
  </div>";

    pg_close($conexion);
    ?> 

    <script>
		// .opcionEliminarTiposEventos: corresponde al nombre de la propiedad "CLASS" que se le puso en el a href, dentro del while para mostrar los datos    
		var nombreClassBotonEliminar = '.opcionEliminarUsuario';
		mensajeEliminarContenido(nombreClassBotonEliminar,"Eliminar productos","Esto no se puede revertir","warning","Si, eliminar productos.","../admin/index.php");
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
                        //var status = json.status;

                        if(json=='registrado'){
                            $('#inputCodigoProducto').val('');
                            $('#inputNombreProducto').val('');

                            //$('#formularioAgregarProductos').modal('hide');
    
                           

                            Swal.fire({
  title: 'Producto registrado',
  text: "Los datos se guardaron correctamente.",
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Recargar la pagina, para ver los cambios'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = "queryListadoProductos.php";
  }
})

                            //window.location.href = "queryListadoProductos.php";
                        }else if(json=='enuso'){
                            Swal.fire(
                                'Producto no guardado.',
                                'Ya se encuentra en uso.',
                                'error'
                            )        
                    
                        }else if(json=='errorsucedido'){
                            Swal.fire(
                                'Error',
                                'No se pudo registrar el producto.',
                                'error'
                            )
                        }
                    }
                }
            );
        }else{
            Swal.fire('Campos vacios.',
                    'Por favor llena todos los campos.',
                    'error'
                    )
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
