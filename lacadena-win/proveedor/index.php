<?php
  include "../sesion/sesion.php";
  include "../config/config.php";
?>

<html lang="en">
    <head>
        <?php
            include "../includes/head.php";
        ?>
        <title>Listado de proveedor</title>

    </head>
<body>
    <div class="container">
        
        <div class="alert alert-primary" role="alert" style="margin-top:20px">
            <h2>Proveedores</h2>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarCliente">
                Registrar proveedor
            </button>
        </div>
        <?php 
        echo '<table class="table table-striped table-bordered nowrap" id="datatableUsuarios" name="datatableUsuarios" style="width:100%">
                <thead>
                        <th>NIT</th>
                        <th>Proveedor</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th></th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a class="btn btn-primary" href="../index.php" role="button">Menu principal</a></div>';
        ?> 
    
    <script>

            $(document).ready(function(){

                $('#datatableUsuarios').DataTable({
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
                        //"url":"../assets/json/idiomaDataTable.json
                        "url":"../assets/json/idiomaDataTable.json"

                    },
                    "responsive": true,
                });
                
                $('#datatableUsuarios').on("click", ".editbtn", function(event) {
                    //sino se coloca muestra mensaje que parentesis de cierre no iba
                    event.preventDefault();
                    var table = $('#datatableUsuarios').DataTable();
                    var trid = $(this).closest('tr').attr('id');
                    var id = $(this).data('id');
                    
                    $('#formularioModificarProveedor').modal('show');
                    $.ajax({
                        url: "obtenerDatosProveedor.php",
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

                            if(json.status=="sindatos"){
                                
                            }else {
                                $("#inputNitUpdate").val(json.nitproveedor);
                                $("#inputDatosModificar").val(json.nombreempresa);
                                $("#inputDireccionModificar").val(json.direccion);
                                $("#inputTelefonoModificar").val(json.telefono);
                            }
                        }
                    });
                    });

 
            $('#datatableUsuarios').on("click", ".activarEliminar", function(event) {
                event.preventDefault();
                var idEliminar = $(this).data('id');
                $.ajax({
                    url: "queryEliminarProveedor.php",
                    data: {
                        id: idEliminar
                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                       
                        if(json=="proveedoreliminado"){
                            $('#datatableUsuarios').DataTable().ajax.reload();
                            
                              Swal.fire(
                                'Proveedor eliminado.',
                                'El proveedor se elimino correctamente.',
                                'success'
                            )
                        }else if(json=="proveedornoexiste"){
                              Swal.fire(
                                'Proveedor no encontrado.',
                                'El proveedor no existe.',
                                'info'
                            )
                        }else if(json=="errorsucedido"){
                              Swal.fire(
                                'Proveedor no eliminado.',
                                'Es posible que los datos esten siendo usados con otra información.',
                                'error'
                            )
                        }else{
                            alert("Error al eliminar proveedor");
                        }
                    }
                });
            });



    });

</script>

<script>
    eventoFormulario('#guardarDatosFormulario','#inputNit','#inputDatos','#inputDireccion','#inputTelefono',"queryRegistrarProveedor.php",'#formularioAgregarCliente');

    eventoFormulario('#guardarDatosFormularioModificar','#inputNitUpdate','#inputDatosModificar','#inputDireccionModificar','#inputTelefonoModificar',"queryModificarProveedor.php",'#formularioModificarProveedor');

    
    function eventoFormulario(nombreSubmit,input1,input2,input3,input4,urlQuery,tipoFormulario){

    $(document).on('submit',nombreSubmit,function(event){
        event.preventDefault();

        var nitCliente=$(input1).val();
        var nombreApellidos=$(input2).val();
        var direccion=$(input3).val();
        var telefono=$(input4).val();

        if((nombreApellidos!='') && (direccion!='') && (nitCliente!='') && (telefono!='')){
            $.ajax({
                url:urlQuery,
                data:{nitCliente:nitCliente,nombreApellidos:nombreApellidos,direccion:direccion,telefono:telefono},
                type:'post',
            
                    success:function(data1){
                    
                        if(tipoFormulario=='#formularioModificarProveedor'){
      
                            var json = JSON.parse(data1);
                            //var status = json.status;
                            if(json=='proveedornoexiste'){ 
                                Swal.fire(
                                'Proveedor no encontrado',
                                'Los datos no se modificaron.',
                                'error'
                                )
                            }else if(json=='proveedoractualizado'){
                                Swal.fire(
                                'Proveedor actualizado',
                                'Los datos se actualizaron correctamente.',
                                'success')
                                var table = $('#datatableUsuarios').DataTable();
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
                        }else if(tipoFormulario=='#formularioAgregarCliente'){
                            var json1 = JSON.parse(data1);
                            //var status1 = json1.status;
                            if(json1=='registrado'){
                                $(input1).val('');
                                $(input2).val('');
                                $(input3).val('');
                                $(input4).val('');
                                
                                //$('#formularioAgregarCliente').modal('hide');
                                //$(tipoFormulario).modal('hide');

                                //cargarDatosTabla();
                                var table = $('#datatableUsuarios').DataTable();
                                table.ajax.reload();

                                Swal.fire(
                                    'Proveedor registrado',
                                    'Los datos se guardaron correctamente.',
                                    'success'
                                )
                            }else if(json1=='enuso'){
                                Swal.fire(
                                    'Proveedor no guardado.',
                                    'El nit del proveedor esta en uso.',
                                    'error'
                                )
                            }else{
                                Swal.fire(
                                    'Proveedor no guardado.',
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
                                    'Campos vacios o valor no esperado.',
                                    'Todos los campos no están llenos o el número de telefono es invalido.',
                                    'warning'
                                )
        }
    });
}
</script>


<!-- inicio agregar cliente action="javascript:void()"-->
<!-- Modal -->
<div class="modal fade" id="formularioAgregarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate autocomplete="off">
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Nit</label>
                <input type="text" name="inputNit" class="form-control" id="inputNit" placeholder="Nit" required maxlength="20">
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Nombre proveedor</label>
                <input type="text" name="inputDatos" class="form-control" placeholder="Nombre proveedor" id="inputDatos" required  maxlength="60">
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Direccion</label>
                <input type="text" name="inputDireccion" class="form-control" id="inputDireccion" placeholder="Direccion" required value="Ciudad"  maxlength="100">
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Telefono</label>
                <input type="number" name="inputTelefono" class="form-control" id="inputTelefono" placeholder="Telefono" required  maxlength="15">
            </div>
            <!--div class="invalid-feedback">
                Ingresa un numero de telefono valido.
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
<div class="modal fade" id="formularioModificarProveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="guardarDatosFormularioModificar" name="guardarDatosFormularioModificar" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Nit</label>
                <input type="text" name="inputNitUpdate" class="form-control" id="inputNitUpdate" placeholder="Nit" required readonly  maxlength="20">
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Nombre proveedor</label>
                <input type="text" name="inputDatosModificar" class="form-control" placeholder="Nombre proveedor" id="inputDatosModificar" required  maxlength="60">
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Direccion</label>
                <input type="text" name="inputDireccionModificar" class="form-control" id="inputDireccionModificar" placeholder="Direccion" required  maxlength="100">
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Telefono</label>
                <input type="number" name="inputTelefonoModificar" class="form-control" id="inputTelefonoModificar" placeholder="Telefono" required  maxlength="15">
            </div>
            <div class="invalid-feedback">
                Ingresa un numero de telefono valido.
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
<!--script src="../assets/js/validation.js"></script-->

</body>
</html>






