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
                    <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formularioAgregarProductosCompras">
                Agregar producto
            </button>
        </div>
<?php 


            //include '../conexion.php';

            //$consultaTotalFacturaCompra = "select SUM(cantidadComprado * precioCompra) from detalleFacturaCompra";
            //$ejecutarConsultaTotalFacturaCompra  = pg_query($conexion,$consultaTotalFacturaCompra);
            



    echo '
        <table class="table table-striped table-bordered nowrap" id="datatableCompras" name="datatableCompras" style="width:100%;">
            <thead>
                    <th>Detalle</th>
                    <th>Costo</th>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Subtotal</th>
                    <th></th>
                   
            </thead>
            <tfoot>
            <tr class="tbl_foot">
              <th colspan="6">Total</th>
            </tr>
          </tfoot>
            <tbody>
            </tbody>
        </table>';

        echo '<button id="btnVerTotalFactura" onclick="updateTotal();" name="btnVerTotalFactura" class="btn btn-primary" type="submit">Actualizar total factura</button>';

        echo '<div class="alert alert-primary" role="alert" style="margin-top:20px;background:#FDFDFD">';
        //while ($row = pg_fetch_row($ejecutarConsultaTotalFacturaCompra)) {
            echo "<h5 style='color:red'>Total compra factura:</h5><input type='text' name='txtTotalFacturaCompra' id='txtTotalFacturaCompra' readonly>";

        //}
        echo '</div><a href="queryFacturaCompras.php">Regresar</a>';


    ?> 

</script>

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
</script>




<div class="modal fade" id="formularioAgregarProductosCompras" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

       <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate>
      <div class="modal-body">
        <!-- inicio formulario-->
        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Costo producto</label>
                <input type="number" name="inputCostoProducto" class="form-control" id="inputCostoProducto" placeholder="Costo de producto" required>
            </div>
            <!--div class="invalid-feedback">
                Looks good!
            </div-->
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Cantidad</label>
                <input type="number" id="inputCantidadCompra" class="form-control soloNumeros" name="inputCantidadCompra" required min="1" oninput="validity.valid||(value='');">
            </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Buscar producto: </label>
                <input type="text" id="inputCodigoProducto" class="form-control" name="inputCodigoProducto" required >
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Buscar productos</button>
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
window.onload = function() {
   // console.log("onload");
  updateTotal();
};
        </script>

<script>
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
</script>


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
                type:'post',
                    success:function(data1){
                        var json = JSON.parse(data1);
                       
                        if(json=='agregadoStock'){
                            Swal.fire(
                                'Producto agregado correctamente.',
                                'Datos guardados.',
                                'success'
                            )
                            var tabla = $('#datatableCompras').DataTable();
                            tabla.ajax.reload();
                            
                        }else if(json=='actualizadoStock'){
                            $('#inputCostoProducto').val('');
                            $('#inputCantidadCompra').val('');
                            $('#inputCodigoProducto').val('');
                            
                            $('#formularioAgregarFacturaCompras').modal('hide');

                            //cargarDatosTabla();
                            var tabla = $('#datatableCompras').DataTable();
                            tabla.ajax.reload();
                            
                            Swal.fire(
                                'Inventario actualizado',
                                'El stock se actualizo.',
                                'success'
                            )
                            var btnTotalFac = document.getElementById("btnVerTotalFactura");
                            btnTotalFac.addEventListener('click', updateTotal());
                        
                        }else  if(json=='errorsucedido'){
                            Swal.fire(
                                'Error.',
                                'El error se controlo, no se guardaron los datos.',
                                'error'
                            )
                        }else if(json=='productonoexiste'){
                            Swal.fire(
                                'Producto no encontrado.',
                                'El producto no existe o el codigo es incorrecto',
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
</script>

<script src="../assets/js/validation.js"></script>


</body>
</html>