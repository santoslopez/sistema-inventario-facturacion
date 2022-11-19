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
<?php 


            //include '../conexion.php';

            //$consultaTotalFacturaCompra = "select SUM(cantidadComprado * precioCompra) from detalleFacturaCompra";
            //$ejecutarConsultaTotalFacturaCompra  = pg_query($conexion,$consultaTotalFacturaCompra);
            



    echo '
        <table class="table table-striped table-bordered nowrap" id="datatableCompras" name="datatableCompras" style="width:100%;">
            <thead>
                    
                    <th>Costo</th>
                    <th>Cantidad</th>
                    <th>Codigo producto</th>
                    <th>Descripcion</th>
                    <th>Subtotal</th>
                    <th>Eliminar</th>
            </thead>
            
            <tbody>
            </tbody>
        </table>';
/**
 * <tfoot><tr class="tbl_foot"><th colspan="6">Total</th></tr></tfoot>
 */

        echo '<div class="d-grid gap-2 col-6 mx-auto">';
        //echo '<a href="queryFacturaCompras.php" class="btn btn-primary">Atrás</a>';
        echo '<a href="../index.php" class="btn btn-primary">Menu principal</a>';
        
        include "../conexion.php";
        $queryValidarCierreCompra = "SELECT  * FROM detallefacturacompra WHERE estado='P' AND documentoProveedor=$1";        

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


        echo '</div>';

    ?> 

</script>

    <!--script>

        
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

                $('#datatableCompras').on("click", ".editbtn", function(event) {
                    //sino se coloca muestra mensaje que parentesis de cierre no iba
                    event.preventDefault();

                    var codigoDetalle = $(this).data('id');

                    let id = document.getElementById("facturaCompra").value; 

                    $('#formularioModificarProductosCompra').modal('show');
                    $.ajax({
                        url: "obtenerDatosProductosCompraId.php",
                        data: {
                            id: id,codigoDetalle:codigoDetalle
                        },
                        type: 'POST',
                        success: function(data) {
                            var json = JSON.parse(data);
                            
                            if(json.status=="sindatos"){
                                
                            }else {
                                $("#inputCostoUpdate").val(json.preciocompra);
                                $("#inputCantidadCompradoModificar").val(json.cantidadcomprado);
                                $("#inputProductoModificar").val(json.codigoproducto);
                                $("#inputIdDetalle").val(json.iddetalle);                                
                            }
                        }
                    });
                    
                    });


            });
            eliminarDatos(".activarEliminar","#datatableCompras","queryEliminarCompraProductos.php",'El producto se ha eliminado de la compra.',"El producto no se pudo eliminar se produjo un error","¿Confirmar eliminación del producto en la compra?","Sí, eliminar producto en la factura de compra");
</script-->




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
                <input type="number" name="inputCostoProducto" class="form-control" id="inputCostoProducto" placeholder="Costo de producto" required min="0" title="Solo se permite: números y punto. Ejemplo: 100, 100.55">
            </div>
            <div class="invalid-feedback">
                Solo numeros se permiten.
            </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Cantidad</label>
                <input type="number" id="inputCantidadCompra" class="form-control" name="inputCantidadCompra" required min="1" title="Solo se permite: números y la cantidad debe ser 1 o mayor. Ejemplo: 1, 10, etc.">
            </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Codigo producto</label>
                <input type="text" id="inputCodigoProducto" class="form-control" name="inputCodigoProducto" required >
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

<!--script>
window.onload = function() {
  
  updateTotal();
};
        </script-->

<!--script>
    function updateTotal(){
      
        //var nombreApellidos=$('#inputEmail').val();
        //if((nombreApellidos!='') && (direccion!='')){
            var documentoFacturaCompra = document.getElementById("facturaCompra").value;
            $.ajax({
                url:"totalFacturaDeCompra.php",
                data:{documentoFacturaCompra:documentoFacturaCompra},
                type:'POST',
                    beforeSend: function() {
                        //$("btnVerTotalFactura").prop('disabled', true);
                    },
                    success:function(data1){
                        var json = JSON.parse(data1);
                        var totalFactura = json[0];
                        document.getElementById("txtTotalFacturaCompra").value = totalFactura;
  
                    }
                }
            );

    };
</script-->



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
                            /*Swal.fire(
                                'Producto agregado correctamente.',
                                'Datos guardados.',
                                'success'
                            )*/
                            var tabla = $('#datatableCompras').DataTable();
                            tabla.ajax.reload();
                            $('#inputCostoProducto').val('');
                            $('#inputCantidadCompra').val('');
                            $('#inputCodigoProducto').val('');
                        }else if(json=="productonoencontrado"){
                            //$('#inputCostoProducto').val('');
                            //$('#inputCantidadCompra').val('');
                            //$('#inputCodigoProducto').val('');
                            
                            //$('#formularioAgregarFacturaCompras').modal('hide');

                            //cargarDatosTabla();
    
                            
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
                                'Se produjo un error',
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



<!-- inicio agregar cliente action="javascript:void()"-->
<div class="modal fade" id="formularioModificarProductosCompra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar compra de producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="guardarDatosFormularioModificar" name="guardarDatosFormularioModificar" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="exampleFormControlInput1" class="form-label">Costo de producto</label>
                <input type="number" name="inputCostoUpdate" class="form-control" id="inputCostoUpdate" placeholder="Costo de producto" required>
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Cantidad comprado</label>
                <input type="number" name="inputCantidadCompradoModificar" class="form-control" placeholder="Cantidad comprado" id="inputCantidadCompradoModificar" required>
            </div>
        </div>
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Descripcion</label>
                <input type="text" name="inputProductoModificar" class="form-control" id="inputProductoModificar" placeholder="Producto" required>
                <input type="number" name="inputIdDetalle" class="form-control" id="inputIdDetalle" placeholder="IDDetalle" required readonly style="display:none">
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


<script>

        
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


<!--script>

    eventoFormulario('#guardarDatosFormularioModificar','#inputCostoUpdate','#inputCantidadCompradoModificar','#inputProductoModificar',"queryModificarProductosCompra.php",'#formularioModificarProductosCompra');

    
    function eventoFormulario(nombreSubmit,input1,input2,input3,urlQuery,tipoFormulario){

    $(document).on('submit',nombreSubmit,function(event){
        event.preventDefault();

        var precioCompra=$(input1).val();
        var cantidadComprado=$(input2).val();
        var codigoProducto=$(input3).val();
        let facturaCompra = document.getElementById("facturaCompra").value; 

        let inputIdDetalle = document.getElementById("inputIdDetalle").value; 

        //var codigoDetalle = $(this).data('id');


        if((precioCompra!='') && (cantidadComprado!='') && (codigoProducto!='')){
            $.ajax({
                url:urlQuery,
                data:{precioCompra:precioCompra,cantidadComprado:cantidadComprado,codigoProducto:codigoProducto,facturaCompra:facturaCompra,inputIdDetalle:inputIdDetalle},
                type:'post',
                    success:function(data1){
                        if(tipoFormulario=='#formularioModificarProductosCompra'){
                            //alert("JSON: "+data1);
                            var json = JSON.parse(data1);
                            var status = json.status;
                            if(status=='failedupdate'){ 
                                Swal.fire(
                                'Proveedor no actualizado',
                                'Los datos no se modificaron.',
                                'error'
                            )
                            }else if(status=='success'){
                                Swal.fire(
                                'Proveedor actualizado',
                                'Los datos se actualizaron correctamente.',
                                'success')
                                var table = $('#datatableCompras').DataTable();
                                table.ajax.reload();
                            }
                        }
                }
            });
        }else{
            Swal.fire(
                                'Campos vacios',
                                'Por favor ingresa todos los campos.',
                                'error'
                            )
        }
    });
}
</script-->

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
    /*Swal.fire(
      'Cierre de factura de compra!',
      'Los datos se han guardado correctamente.',
      'success'
    )*/
    var facturaCompra = $('#facturaCompra').val();

    $.ajax({
                url:"queryCerrarFacturaCompra.php",
                data:{facturaCompra:facturaCompra},
                type:"POST",
                    success:function(data1){
                        
                            
                            var json = JSON.parse(data1);
                            //var status = json.status;
                            if(json=="actualizado"){ 
                                var table = $('#datatableCompras').DataTable();
                                table.ajax.reload();
                                
                                /*Swal.fire(
                                'La factura de compra se ha cerrado',
                                'Los datos se actualizaron correctamente.',
                                'success'
                                )*/
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
                            
                            }else if(json=="facturainvalida"){
                                Swal.fire(
                                'Factura de compra invalida',
                                'La factura no se cerro. Es posible que no hay datos en la tabla o el numero de factura de compra es invalido.',
                                'error')
                                
                            }else if(json=="errorsucedido"){
                                Swal.fire(
                                'Error controlado',
                                'Se produjo un error',
                                'error')
                                //var table = $('#datatableCompras').DataTable();
                                //table.ajax.reload();
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

</body>
</html>