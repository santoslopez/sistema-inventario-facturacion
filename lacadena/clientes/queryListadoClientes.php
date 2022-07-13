<?php
  
  //session_start();
  include "../sesion/sesion.php";
  include "../config/config.php";

?>

<html lang="en">
<head>
    <?php
        //session_start();
        include "../includes/head.php";
    ?>

</head>
<body>
    <div class="container">
        
        <div class="alert" role="alert" style="margin-top:20px;background:#201E1D;color:white;">
            <h2>Listado de clientes</h2>
            
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarCliente">
                Registrar cliente
            </button>
        </div>
    <?php 
    //include '../conexion.php';
    echo '
        <table class="table table-striped table-bordered nowrap" id="datatableUsuarios" name="datatableUsuarios" style="width:100%">
            <thead>
                    <th>Nombre y apellidos</th>
                    <th>Direccion</th>
                    <th>Nit</th>
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

   
    

<script src="../assets/js/eventosAjax.js">

</script>

    <script>

        
        /*** Nota importante: en data tienen que ir los valores en minuscula de la tabla que queremos mostrar sus datos
         */
            $(document).ready(function(){
                $('#datatableUsuarios').DataTable({
                    "ajax":{
                        "url":"queryClientes.php",
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
            eliminarDatos(".activarEliminar","#datatableUsuarios","queryEliminarClientes.php",'Cliente eliminado correctamente.',"El cliente no se pudo eliminar se produjo un error","¿Confirmar eliminación de cliente?","Sí, eliminar datos de cliente");
</script>


    
    <!--script>
        $('#datatadddble').DataTable({
            'serverSide':true,
            'processing':true,
            'paging':true,
            'order':[],
            'ajax':{
                'url':'fetch.php',
                'type':'post',

            },
            'fnCreateRow':function(nRow,aData,iDataIndex)
            {
                $(nRow).attr('id',aData[0]);
            },
            'columnDefs':[
                {
                    'target':[0,5],
                    'orderable':false
                }
            ]
        });
    </script-->




    <!--script>
		// opcionEliminarTiposEventos: corresponde al nombre de la propiedad "CLASS" que se le puso en el a href, dentro del while para mostrar los datos    

		var nombreClassBotonEliminar = '.opcionEliminarCliente';
		mensajeEliminarContenido(nombreClassBotonEliminar,"Eliminar cliente","Esto no se puede revertir","warning","Si, eliminar informacion.","../admin/index.php");
	</script-->

<script>
    $(document).on('submit','#guardarDatosFormulario',function(event){
        event.preventDefault();
        var nombreApellidos=$('#inputDatos').val();
        var direccion=$('#inputDireccion').val();
        var nitCliente=$('#inputNit').val();
        var telefono=$('#inputTelefono').val();
        if((nombreApellidos!='') && (direccion!='') && (nitCliente!='') && (telefono!='')){
            $.ajax({
                url:"queryRegistrarClientes.php",
                data:{nombreApellidos:nombreApellidos,direccion:direccion,nitCliente:nitCliente,telefono:telefono},
                type:'post',
                    success:function(data1){
                        var json = JSON.parse(data1);
                     
                        var status = json.status;
                        if(status=='success'){
                            $('#inputDatos').val('');
                            $('#inputDireccion').val('');
                            $('#inputNit').val('');
                            $('#inputTelefono').val('');
                            $('#formularioAgregarCliente').modal('hide');
                            //cargarDatosTabla();
                            var table = $('#datatableUsuarios').DataTable();
                            table.ajax.reload();

                            Swal.fire(
                                'Cliente registrado',
                                'Los datos se guardaron correctamente.',
                                'success'
                            )
                        }else{
                            Swal.fire(
                                'Cliente no guardado.',
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
        <h5 class="modal-title" id="exampleModalLabel">Registrar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Nombre y apellidos</label>
                <input type="text" name="inputDatos" class="form-control" id="inputDatos" placeholder="Nombre y apellidos" required>
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Direccion</label>
                <input type="text" name="inputDireccion" class="form-control" id="inputDireccion" placeholder="Direccion" require value="Ciudad">
            </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Nit cliente</label>
                <input type="text" name="inputNit" class="form-control" id="inputNit" placeholder="Nit" required value="c/f">
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

<!-- fin agregar cliente -->

<script src="../assets/js/validation.js"></script>

</body>
</html>