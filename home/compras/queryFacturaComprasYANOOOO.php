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
    <title>Facturas de compras</title>

    <style>
        label {
            display: block;
            font: 1rem 'Fira Sans', sans-serif;
        }
        input,
        label {
            margin: .4rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        
    <?php 
      include "../conexion.php";

    $verificarSiHayProductos = "SELECT * FROM Productos";
    $ejecutarConsultaProductos = pg_query($conexion,$verificarSiHayProductos );
    $data = array();
    if (pg_num_rows($ejecutarConsultaProductos)==0) {
        echo '<div class="alert alert-danger" role="alert" style="margin-left:10%;margin-right:10%;margin-top:10%">
        Sin productos, por favor registra productos primero.
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a class="btn btn-primary" href="../index.php">Menu principal</a>
        </div>
        
        ';   
    }else{

    //include '../conexion.php';
    echo '
    <div class="alert alert-primary" role="alert" style="margin-top:20px;">
    <h2>Listado de factura de compras</h2>
    
    </div>

        <table class="table table-striped table-bordered nowrap" id="datatableUsuarios" name="datatableUsuarios" style="width:100%">
            <thead>
                    <th>No. documento</th>
                    <th>Documento proveedor</th>
                    <th>Fecha registro</th>
                    <th>Fecha factura proveedor</th>
                    <th>Nit proveedor</th>
                    <th>Estado</th>
                    <th></th>
            </thead>
            <tbody>
            </tbody>
        </table>
        <a class="btn btn-primary" href="../index.php" role="button">Menu principal</a></div>';

    }
    ?> 

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
                        "url":"../assets/json/idiomaDataTable.json"
                    },
                    "responsive": true,
                });
            });
            //eliminarDatos(".activarEliminar","#datatableUsuarios","queryEliminarFacturaCompra.php",'Factura de compra se ha eliminado correctamente.',"La factura no se pudo eliminar se produjo un error","¿Confirmar anulación de factura de compra?","Sí, anular la factura de compra");
 
            $('#datatableUsuarios').on("click", ".activarEliminar", function(event) {
                event.preventDefault();
                var idEliminar = $(this).data('id');
                $.ajax({
                    url: "queryAnularCompra.php",
                    data: {
                        id: idEliminar
                    },
                    type: 'POST',
                    success: function(data) {
                        alert("json: "+data);
                        var json = JSON.parse(data);
                        alert("json: "+json);
                        if(json=="facturacompraanulado"){
                            $('#datatableUsuarios').DataTable().ajax.reload();
                            
                              Swal.fire(
                                'Factura de compra anulado.',
                                'La factura de compra ha sido anulado.',
                                'success'
                            )
                        }else if(json=="errorproducido"){
                            $('#datatableUsuarios').DataTable().ajax.reload();
                            
                              Swal.fire(
                                'Error producido',
                                'La factura de compra ha sido anulado.',
                                'error'
                            )
                            
                        }else {
                            Swal.fire(
                                'Factura de compra no anulado',
                                'Se produjo algun error al querer actualizar el estado de la factura.',
                                'error'
                            )
                        }
                    }
                });
            });

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
                            
                            $('#formularioAgregarFacturaCompras').modal('hide');

                            //cargarDatosTabla();
                            var tabla = $('#datatableUsuarios').DataTable();
                            tabla.ajax.reload();
                            
                            Swal.fire(
                                'Factura registrado',
                                'Los datos se guardaron correctamente.',
                                'success'
                            )
                        }else if(status=='failed'){
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
<div class="modal fade" id="formularioAgregarFacturaCompras" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="date" id="inputFechaFacturaProveedor" class="form-control" name="inputFechaFacturaProveedor" required>
      
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
        <button type="submit" class="btn btn-primary" id="btnGuardarDatos" name="btnGuardarDatos">Guardar datos</button>
      </div>
      </form>

    </div>
    
  </div>
</div>

<!-- fin agregar cliente -->

<script src="../assets/js/validation.js"></script>

</body>
</html>