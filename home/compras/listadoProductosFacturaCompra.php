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
    <script src="../assets/js/validarInputs.js"></script>
</head>
<body>
    <div class="container">
       
        <div class="alert alert-primary" role="alert" style="margin-top:20px;">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="inputPassword6" class="col-form-label"><h5>Factura de compra No: </h5></label>
                </div>
                <div class="col-auto">
                    <input id="facturaCompra" class="form-control" name="facturaCompra" type="text" value="<?php echo $_GET['documentoFacturaCompra'];?>" readonly>
                    <!--input type="text" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline"-->
                </div>
            </div>     
          
        </div>
        <table class="table table-striped table-bordered nowrap" id="datatableCompras" name="datatableCompras" style="width:100%;">
            <thead>
                    
                    <th>Costo</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Codigo producto</th>
                    <th style="width:30px">Descripcion</th>
                    
                    <th>Eliminar</th>
            </thead>
            
           <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="../index.php" class="btn btn-primary">Menu principal</a>
<?php 

        include "../conexion.php";
        $queryValidarCierreCompra = "SELECT detalle.iddetalle,detalle.preciocompra,detalle.cantidadcomprado, detalle.codigoproducto, detalle.documentoproveedor FROM DetalleFacturaCompra AS detalle 
        INNER JOIN FacturaCompra AS facturacompra ON detalle.documentoproveedor=facturacompra.documentoproveedor
        WHERE (facturacompra.estado='P' OR facturacompra.estado='A')  AND facturacompra.documentoProveedor=$1";        

        pg_prepare($conexion,"queryValidarCierreFacturaCompra",$queryValidarCierreCompra ) or die ("No se pudo preparar la consulta queryValidarCierreFacturaCompra");
        $numeroDocumentoCompra=$_GET["documentoFacturaCompra"];
        $ejecutarValidarCompraCierre = pg_execute($conexion,"queryValidarCierreFacturaCompra",array($numeroDocumentoCompra));

        // Validate query rows
        if (pg_num_rows($ejecutarValidarCompraCierre) > 0) {
           
        }else{   
            echo '<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#formularioAgregarProductosCompras">
                Agregar producto
                <img src="../assets/img/add.png" alt="Agregar productos" srcset="" width="32">
            </button>
            <a onclick="cerrarFacturaCompra();" class="btn btn-success">
            Cerrar factura de compra
            <img src="../assets/img/diskette-2.png" alt="Cerrar factura de compra" width="64" height="64">
            </a>';
        }
    ?> 
    </div>
</script>

<div class="modal fade" id="formularioAgregarProductosCompras" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate autocomplete="off">
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Costo producto</label>
                <input type="text" name="inputCostoProducto" class="form-control" id="inputCostoProducto" placeholder="Costo de producto" required min="0" step="0.01" title="Solo se permite: números y punto. Ejemplo: 100, 100.55. Numeros solo con 2 decimales" autocomplete="off">
                
            </div>
            <div class="invalid-feedback">
                Solo numeros se permiten.
            </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Cantidad</label>
                <input type="number" id="inputCantidadCompra" class="form-control soloNumeros" name="inputCantidadCompra" required min="1" title="Solo se permite: números y la cantidad debe ser 1 o mayor. Ejemplo: 1, 10, etc." autocomplete="off">
            </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Codigo producto</label>
                <input type="text" id="inputCodigoProducto" class="form-control" name="inputCodigoProducto" required autocomplete="off">
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


<script>
    $(document).on('submit','#guardarDatosFormulario',function(event){
        event.preventDefault();
        
        var inputCostoProducto=$('#inputCostoProducto').val();
        var inputCantidadCompra=$('#inputCantidadCompra').val();
        var inputCodigoProducto=$('#inputCodigoProducto').val();

        var facturaCompra = $('#facturaCompra').val();
        
        if((inputCostoProducto!='') && (inputCantidadCompra!='') && (inputCodigoProducto!='')){
            $.ajax({
                url:"queryRegistrarCompraProducto.php",
                data:{inputCostoProducto:inputCostoProducto,inputCantidadCompra:inputCantidadCompra,inputCodigoProducto:inputCodigoProducto,facturaCompra:facturaCompra},
                type:'POST',
                    success:function(data1){
                        
                        var json = JSON.parse(data1);
                        //console.log("follR"+json);
                        if(json=="registrado"){
                           
                            var tabla = $('#datatableCompras').DataTable();
                            tabla.ajax.reload();
                            $('#inputCostoProducto').val('');
                            $('#inputCantidadCompra').val('');
                            $('#inputCodigoProducto').val('');
                        }else if(json=="productonoencontrado"){
                            
                            
                            Swal.fire(
                                'Producto no encontrado',
                                'El codigo del producto es invalido',
                                'error'
                            )
                            //var btnTotalFac = document.getElementById("btnVerTotalFactura");
                            //btnTotalFac.addEventListener('click', updateTotal());
                        }else if(json=="facturacompranoencontrado"){
                            Swal.fire(
                                'Factura invalida',
                                'El documento de factura de compra no se encontro.',
                                'error'
                            ) 
                        }else if(json=="errorsucedido"){
                            Swal.fire(
                                'Error controlado',
                                'Se produjo el siguiente error: ',
                                'error'
                            ) 
                            

                        }else{
                            Swal.fire(
                                'Producto no guardado.',
                                'Los datos no se guardaron. Se produjo un error al querer guardar',
                                'error'
                            )
                        }
                    }
                }
            );
        }else{
            Swal.fire(
                                'Campos vacios.',
                                'Por favor llena todos los campos.',
                                'error'
                            )
        }
    });
</script>



<script>

        var totalVentaComprobante;

/*** Nota importante: en data tienen que ir los valores en minuscula de la tabla que queremos mostrar sus datos
 */
    $(document).ready(function(){
        //obtenemos el valor del numero de factura para enviarlo en la consulta en ajax
        var documentoFacturaCompra = document.getElementById("facturaCompra").value;

        $('#datatableCompras').DataTable({
            "ajax":{
                "url":"queryDetalleFacturaCompra.php",
                "dataSrc":"",
                "data":{
                    documentoFacturaCompra:documentoFacturaCompra
                }
            },
            "processing": true,
            /*drawCallback: function () {
      var api = this.api();
     
      $(api.columns(4).footer()).html(
        'Total en página seleccionada: Q.'+api.column(2, {page:'current'} ).data().sum()
      );
      
      totalVentaComprobante=api.column(2, {page:'current'} ).data().sum();
    },*/
                        footerCallback: function (row, data, start, end, display) {
                        var api = this.api();
                        
 // Remove the formatting to get integer data for summation
 var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

  // Total over all pages
                total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


                        $(api.column(2).footer()).html('Total página: Q.' + pageTotal.toFixed(3) + ' ( Q.' + total + ' total factura de compras)');
                        
                    },


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

        eliminarDatos(".activarEliminar","#datatableCompras","queryEliminarCompraProductos.php",'El producto se ha eliminado de la compra.',"El producto no se pudo eliminar se produjo un error","¿Confirmar eliminación de la fila en la factura de compras?","Sí, eliminar datos.");

    });
</script>



<script src="../assets/js/validation.js"></script>


<script>
    function cerrarFacturaCompra(){
        Swal.fire({
  title: '¿Confirmar cierre de factura de compras?',
  text: "Esto cerrara la factura de compras y no se podra modificar",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, cerrar compra.'
}).then((result) => {
  if (result.isConfirmed) {
    
    var facturaCompra = $('#facturaCompra').val();

    $.ajax({
                url:"queryCerrarFacturaCompra.php",
                data:{facturaCompra:facturaCompra},
                type:"POST",
                    success:function(data1){
                        
                            
                            var json = JSON.parse(data1);
                            
                            if(json=="actualizado"){ 
                                var table = $('#datatableCompras').DataTable();
                                table.ajax.reload();
                                
                               
                                let timerInterval
Swal.fire({
  title: 'Factura de compra cerrada!',
  html: 'Espera un momento. Redirigiendo al menu principal. Faltan: <b></b> milliseconds.',
  icon:'success',
  timer: 3000,
  
  timerProgressBar: true,
   //Bloquear hasta que haya una accion de click de continuar o cancelar
   allowOutsideClick:false,
   allowEscapeKey:false,
   allowEnterKey:false,
   stopKeydownPropagation:false,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
    
    //redirect 
    window.location.href = "../index.php";
    }
})
                            
                            }else if(json=="noafectado"){
                                Swal.fire(
                                'Factura de compra NO cerrada',
                                'Es posible que ya este finalizado la compra o se encuentre anulado previamente.',
                                'error')
                                
                            }else if(json=="errorsucedido"){
                                Swal.fire(
                                'Error controlado',
                                'Se produjo un error',
                                'error')
                            }else if(json=="facturanoexiste"){
                                Swal.fire(
                                'Factura no existe',
                                'No se puede procesar debido que la factura de compra no existe',
                                'error')

                            }else{
                                Swal.fire(
                                'Error controlado',
                                'Se produjo un error:'+json,
                                'error')
                            }
                        
                }
            });
    
  }
})
    }
</script>

<script>
    validateNumberInput("inputCostoProducto");
</script>

<script src="../assets/js/sum.js"> </script>

</body>
</html>