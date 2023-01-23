<?php
  include "../sesion/sesion.php";
  include "../config/config.php";
?>

<html lang="en">
    <head>
        <?php
            include "../includes/head.php";
        ?>
        <title>Listado de productos</title>

    </head>
<body>
    <div class="container">
        
        <div class="alert alert-primary" role="alert" style="margin-top:20px">
            <h2>Productos</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarProductos">
                Registrar productos
            </button>
        </div>
        <table class="table table-striped table-bordered nowrap" id="datatableProductos" name="datatableProductos" style="width:100%">
                <thead>
                        <th>CODIGO</th>
                        <th>Descripcion</th>
                        <th></th>
                </thead>
                <tbody>
                </tbody>
        </table>
        <a class="btn btn-primary" href="../index.php" role="button">Menu principal</a>
    </div>
      
    
    <script>

            $(document).ready(function(){

                $('#datatableProductos').DataTable({
                    "ajax":{
                        "url":"queryListadoP.php",
                        "dataSrc":""
                    },
                    "processing": true,
                
                    "lengthMenu": [
                        [10,15, -1],
                        [10,20, 'All'],
                    
                    ],
                    "language":{
                        "url":"../assets/json/idiomaDataTable.json"
                    },
                    "responsive": true,
                });
                
                $('#datatableProductos').on("click", ".editbtn", function(event) {
                    //sino se coloca muestra mensaje que parentesis de cierre no iba
                    event.preventDefault();
                    var table = $('#datatableProductos').DataTable();
                    var trid = $(this).closest('tr').attr('id');
                    var id = $(this).data('id');
                    
                    $('#formularioModificarProductos').modal('show');
                    $.ajax({
                        url: "obtenerDatosProductos.php",
                        data: {
                            id: id
                        },
                        type: 'POST',
                        success: function(data) {
                            var json = JSON.parse(data);
                            
                            /* IMPORTANTE: para obtener los datos de las columnas de la tabla
                            todo debe estar escrito en minuscula de lo contrario json no lo reconoce.
                            
                            EJEMPLO: en la tabla tenemos la columna nombreEmpresa,
                            en json se llama como nombreempresa
                            */

                            if(json=="sindatos"){
                                
                            }else {
                                $("#inputNitUpdate").val(json.codigoproducto);
                                $("#inputDatosModificar").val(json.descripcion);
                                //$("#inputDireccionModificar").val(json.direccion);
                                //$("#inputTelefonoModificar").val(json.telefono);
                            }
                        }
                    });
                    });

 
            $('#datatableProductos').on("click", ".activarEliminar", function(event) {
                event.preventDefault();
                var idEliminar = $(this).data('id');
                $.ajax({
                    url: "queryEliminarProducto.php",
                    data: {
                        id: idEliminar
                    },
                    type: 'POST',
                    success: function(data) {
                        Swal.fire({
  title: 'Eliminar producto',
  text: "Esta acción no se puede revertir.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Si, eliminar!'
}).then((result) => {
  if (result.isConfirmed) {
    /*Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )*/
    var json = JSON.parse(data);
                        
                        if(json=="productoeliminado"){
                            $('#datatableProductos').DataTable().ajax.reload();
                            
                              Swal.fire(
                                'Productos eliminado.',
                                'El proveedor se elimino correctamente.',
                                'success'
                            )
                        }else if(json=="productonoexiste"){
                              Swal.fire(
                                'Producto no encontrado.',
                                'El producto no existe.',
                                'info'
                            )
                        }else if(json=="errorsucedido"){
                              Swal.fire(
                                'Producto no eliminado.',
                                'Es posible que los datos esten siendo usados con otra información.',
                                'error'
                            )
                        }else{
                            Swal.fire(
                                'Producto no eliminado.',
                                'Se produjo algun error o es posible que este dato este siendo usado en otro lado.',
                                'error'
                            )
                        }


  }
})
                        


                    }
                });
            });



    });







</script>




<script>
    eventoFormulario('#guardarDatosFormulario','#inputNit','#inputDatos','#inputDireccion','#inputTelefono',"queryRegistrarProductos.php",'#formularioAgregarProductos');

    eventoFormulario('#guardarDatosFormularioModificar','#inputNitUpdate','#inputDatosModificar','#inputDireccionModificar','#inputTelefonoModificar',"queryModificarProductos.php",'#formularioModificarProductos');

    
    function eventoFormulario(nombreSubmit,input1,input2,input3,input4,urlQuery,tipoFormulario){

    $(document).on('submit',nombreSubmit,function(event){
        event.preventDefault();

        var nitCliente=$(input1).val();
        var nombreApellidos=$(input2).val();
        //var direccion=$(input3).val();
        //var telefono=$(input4).val();

        if((nombreApellidos!='') && (nitCliente!='') ){
            $.ajax({
                url:urlQuery,
                data:{nitCliente:nitCliente,nombreApellidos:nombreApellidos},
                type:'post',
            
                    success:function(data1){
                    
                        if(tipoFormulario=='#formularioModificarProductos'){
      
                            var json = JSON.parse(data1);
                            //var status = json.status;
                            if(json=='productonoexiste'){ 
                                Swal.fire(
                                'Producto no encontrado',
                                'Los datos no se modificaron.',
                                'error'
                                )
                            }else if(json=='productoactualizado'){
                                Swal.fire(
                                'Producto actualizado',
                                'Los datos se actualizaron correctamente.',
                                'success')
                                var table = $('#datatableProductos').DataTable();
                                table.ajax.reload();
                            }else if(json=='errorsucedido'){
                                
                                Swal.fire(
                                'Error controlado',
                                'Se produjo el siguiente error: '+json,
                                'error'
                                )
                            }else{
                                Swal.fire(
                                'Error',
                                'Se produjo el siguiente error: '+json,
                                'error'
                                )
                            }
                        }else if(tipoFormulario=='#formularioAgregarProductos'){

                            var json1 = JSON.parse(data1);
                            //var status1 = json1.status;
                            if(json1=='registrado'){
                                $(input1).val('');
                                $(input2).val('');
                                //$(input3).val('');
                                //$(input4).val('');
                                
                                //$('#formularioAgregarProductos').modal('hide');
                                //$(tipoFormulario).modal('hide');

                                //cargarDatosTabla();
                                var table = $('#datatableProductos').DataTable();
                                table.ajax.reload();

                                Swal.fire(
                                    'Producto registrado',
                                    'Los datos se guardaron correctamente.',
                                    'success'
                                )
                            }else if(json1=='enuso'){
                                Swal.fire(
                                    'Producto no guardado.',
                                    'El codigo del producto esta registrado.',
                                    'error'
                                )
                            }else{
                                Swal.fire(
                                    'Producto no guardado.',
                                    'Se produjo un error.',
                                    'info'
                                )
                            }
                        }else{

                        }
                }
            });
        }else{
            Swal.fire(
                                    'Campos vacios.',
                                    'Por favor llena todos los campos.',
                                    'warning'
                                )
        }
    });
}
</script>


<!-- inicio agregar cliente action="javascript:void()"-->
<!-- Modal -->
<div class="modal fade" id="formularioAgregarProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="form-control needs-validation" novalidate autocomplete="off">
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Codigo</label>
                <input type="text" name="inputNit" class="form-control" id="inputNit" placeholder="Codigo del producto" required maxlength="30" pattern="[A-Za-z0-9-_/]+" title="Solo se permite: números, letras, guion bajo, guion normal y diagonal. No se permiten espacios. Tamaño máximo código: 30"/>
            </div>
            <div class="invalid-feedback">
                Solo se permite: números, letras y guión. Tamaño máximo código: 30
            </div>
        </div>
        <div class="mb-3">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Descripcion</label>
                <input type="text" name="inputDatos" class="form-control" placeholder="Nombre del producto" id="inputDatos" required maxlength="150">
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>
       
        <!-- fin formulario -->
      </div>
    

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar datos</button>
      </div>
      </form>

    </div>
  </div>
</div>

<!-- inicio agregar cliente action="javascript:void()"-->
<div class="modal fade" id="formularioModificarProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="guardarDatosFormularioModificar" name="guardarDatosFormularioModificar" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Codigo del producto</label>
                <input type="text" name="inputNitUpdate" class="form-control" id="inputNitUpdate" placeholder="Codigo de producto" required readonly maxlength="30">
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Nombre del producto</label>
                <input type="text" name="inputDatosModificar" class="form-control" placeholder="Nombre del producto" id="inputDatosModificar" required maxlength="150">
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
<script src="../assets/js/validation.js"></script>

</body>
</html>


