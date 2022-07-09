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
        
        <div class="alert" role="alert" style="margin-top:20px;background:#201E1D;color:white;">
            <h2>Listado de factura de compras</h2>
            
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarCliente">
                Registrar compras
            </button>
        </div>
    <?php 
    //include '../conexion.php';
    echo '
        <table class="table table-striped table-bordered nowrap" id="datatableUsuarios" name="datatableUsuarios" style="width:100%">
            <thead>
                    <th>No. documento</th>
                    <th>Documento proveedor</th>
                    <th>Fecha registro</th>
                    <th>Fecha factura proveedor</th>
                    <th>Nit proveedor</th>
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
                        "url":"queryFacturas.php",
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
            eliminarDatos(".activarEliminar","#datatableUsuarios","queryEliminarFacturaCompra.php",'Factura de compra se ha eliminado correctamente.',"La factura no se pudo eliminar se produjo un error","¿Confirmar eliminación de factura de compra?","Sí, eliminar factura de compra");
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
        var inputDocumentoProveedor=$('#inputDocumentoProveedor').val();
        var inputFechaFacturaProveedor=$('#inputFechaFacturaProveedor').val();
        var inputNitProveedor=$('#inputNitProveedor').val();
        //var telefono=$('#inputTelefono').val();
        if((inputDocumentoProveedor!='') && (inputFechaFacturaProveedor!='') && (inputNitProveedor!='')){
            $.ajax({
                url:"queryRegistrarFacturaCompra.php",
                data:{inputDocumentoProveedor:inputDocumentoProveedor,inputFechaFacturaProveedor:inputFechaFacturaProveedor,inputNitProveedor:inputNitProveedor},
                type:'post',
                    success:function(data1){
                        var json = JSON.parse(data1);
                     
                        var status = json.status;
                      if(status=='yaexistenoguardado'){
                        Swal.fire(
                        'Factura ya existe',
                                'Los datos no se registraron.',
                                'error'
                            )
                      }else if(status=='success'){
                            $('#inputDocumentoProveedor').val('');
                            $('#inputFechaFacturaProveedor').val('');
                            $('#inputNitProveedor').val('');
                            //$('#inputTelefono').val('');
                            $('#formularioAgregarCliente').modal('hide');
                            //cargarDatosTabla();
                            var table = $('#datatableUsuarios').DataTable();
                            table.ajax.reload();

                            Swal.fire(
                                'Factura registrado',
                                'Los datos se guardaron correctamente.',
                                'success'
                            )
                        }else{
                            Swal.fire(
                                'Factura de compra no guardado.',
                                'Los datos no se guardaron. Se produjo un error al querer guardar',
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
        <h5 class="modal-title" id="exampleModalLabel">Registrar factura compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Documento proveedor</label>
                <input type="text" name="inputDocumentoProveedor" class="form-control" id="inputDocumentoProveedor" placeholder="No factura" required>
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Fecha factura proveedor</label>
                <!--input type="date" name="inputFechaFacturaProveedor" class="form-control" id="inputFechaFacturaProveedor" placeholder="Fecha facturado por proveedor" required-->
                <input type="datetime-local" id="inputFechaFacturaProveedor" class="form-control" name="inputFechaFacturaProveedor" required>
      
              </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Proveedor</label>
                <?php
                         include '../conexion.php';
                         include "../datos/funcionesDatos.php";
                         datosCombobox("inputNitProveedor",$conexion,"SELECT nitProveedor,nombreEmpresa FROM Proveedor");
                         ?>
            </div>
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