<?php
  
  //session_start();
  include "../sesion/sesion.php";
  include "../config/config.php";

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


    <link rel="stylesheet" href="../assets/css/zoomImagen.css"/>

    <!--link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"-->
  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/r-2.3.0/datatables.min.css"/>
 
 

</head>
<body>
    <div class="container">
        
        <div class="alert alert-primary" role="alert" style="margin-top:20px">
            <h2>Proveedores</h2>
            
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarCliente">
                Registrar proveedor
            </button>
        </div>
    <?php 
    //include '../conexion.php';
    echo '
        <table class="table table-striped table-bordered nowrap" id="datatableUsuarios" name="datatableUsuarios" style="width:100%">
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
        <a class="btn btn-primary" href="../index" role="button">Menu principal</a></div>';

    ?> 

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>
    
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.dataTables.js"></script>

       
    <script src="../assets/js/eventosAjax.js"></script>
    
    <script>

        
        /*** Nota importante: en data tienen que ir los valores en minuscula de la tabla que queremos mostrar sus datos
         
                echo "<td><a href=../proveedor/frmModificarProveedor?nitDatos=$row[0]&empresaDatos=".urlencode($row[1])."&direccion=".urlencode($row[3])."&telefono=".urlencode($row[4])."><img src='../assets/img/update.png' class='zoomImagen imagenTabla' alt='Actualizar contenido'></a></td>";       

        echo "<td data-label='Eliminar'><a href=../proveedor/queryEliminarProveedor.php?nitEliminarProveedor=".urlencode($row[0])." class='opcionEliminarProveedor btn'><img src='../assets/img/delete.png' class='zoomImagen imagenTabla' alt='Eliminar contenido'></a></td>";
     
        */
            $(document).ready(function(){
                $('#datatableUsuarios').DataTable({
                    "ajax":{
                        "url":"queryListadoP.php",
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
                
                /*$('#datatableUsuarios').on('click', '.editbtn', function(event) {
                    var table = $('#datatableUsuarios').DataTable();
                    var trid = $(this).closest('tr').attr('id');
                    var id = $(this).data('id');
                    
                    $('#formularioModificarProveedor').modal('show');
                    $.ajax({
                        url: "obtenerDatosProveedor.php",
                        data: {
                            id: id
                        },
                        type: 'post',
                        success: function(data) {
                            var json = JSON.parse(data);
                            console.log("xoxo xoxo: ");
                            //$('#inputNitUpdate').val(json.nombreEmpresa +"dddd " +json[0] + "dfsdfsd " +json["nombreEmpresa"]);
                        }
                    });
                    });*/


            });
            eliminarDatos(".activarEliminar","#datatableUsuarios","queryEliminarProveedor.php",'Proveedor eliminado correctamente.',"El proveedor no se pudo eliminar se produjo un error","¿Confirmar eliminación de proveedor?","Sí, eliminar datos de proveedor");

</script>


<script>
    $(document).on('submit','#guardarDatosFormulario',function(event){
        event.preventDefault();
        var nitCliente=$('#inputNit').val();
        var nombreApellidos=$('#inputDatos').val();
        var direccion=$('#inputDireccion').val();
        var telefono=$('#inputTelefono').val();
        if((nombreApellidos!='') && (direccion!='') && (nitCliente!='') && (telefono!='')){
            $.ajax({
                url:"queryRegistrarProveedor.php",
                data:{nitCliente:nitCliente,nombreApellidos:nombreApellidos,direccion:direccion,telefono:telefono},
                type:'post',
                
                    success:function(data1){
                        var json = JSON.parse(data1);
            
                        var status = json.status;
                        if(status=='yaexistenoguardado'){ 
                            Swal.fire(
                                'Proveedor no registrado',
                                'El nit esta en uso.',
                                'warning'
                            )
                        }else if(status=='success'){
                            $('#inputDatos').val('');
                            $('#inputDireccion').val('');
                            $('#inputNit').val('');
                            $('#inputTelefono').val('');
                            $('#formularioAgregarCliente').modal('hide');
                            //cargarDatosTabla();
                            var table = $('#datatableUsuarios').DataTable();
                            table.ajax.reload();

                            Swal.fire(
                                'Proveedor registrado',
                                'Los datos se guardaron correctamente.',
                                'success'
                            )
                        }else{
                            Swal.fire(
                                'Proveedor no guardado.',
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


<!-- inicio agregar cliente action="javascript:void()"
-->
<!-- Modal -->
<div class="modal fade" id="formularioAgregarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Nit</label>
                <input type="text" name="inputNit" class="form-control" id="inputNit" placeholder="Nit" required>
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Nombre proveedor</label>
                <input type="text" name="inputDatosUpdate" class="form-control" placeholder="Nombre proveedor" id="inputDatosUpdate" required>
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Direccion</label>
                <input type="text" name="inputDireccionUpdate" class="form-control" id="inputDireccionUpdate" placeholder="Direccion" required value="Ciudad">
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Telefono</label>
                <input type="number" name="inputTelefono" class="form-control" id="inputTelefono" placeholder="Telefono" required>
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

<!-- inicio agregar cliente action="javascript:void()"
-->
<!-- Modal -->
<div class="modal fade" id="formularioModificarProveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="guardarDatosFormularioModificar" name="guardarDatosFormularioModificar" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Nit</label>
                <input type="text" name="inputNitUpdate" class="form-control" id="inputNitUpdate" placeholder="Nit" required>
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Nombre proveedor</label>
                <input type="text" name="inputDatosModificar" class="form-control" placeholder="Nombre proveedor" id="inputDatosModificar" required>
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Direccion</label>
                <input type="text" name="inputDireccionModificar" class="form-control" id="inputDireccionModificar" placeholder="Direccion" required>
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Telefono</label>
                <input type="number" name="inputTelefonoModificar" class="form-control" id="inputTelefonoModificar" placeholder="Telefono" required>
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

<!-- fin agregar cliente -->
<script src="../assets/js/validation.js"></script>

</body>
</html>






