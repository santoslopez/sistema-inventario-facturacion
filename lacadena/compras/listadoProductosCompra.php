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
            <h5>Factura compra No: </h5>
            <input id="facturaCompra" name="facturaCompra" type="text" value="<?php echo $_GET['documentoFacturaCompra'];?>" readonly>
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
                $('#datatableCompras').DataTable({
                    "ajax":{
                        "url":"queryDetalleFacturaCompra.php",
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
                <input type="number" id="inputCantidadCompra" class="form-control" name="inputCantidadCompra" required min="1" oninput="validity.valid||(value='');">
            </div>
        </div>

        <div class="mb-3 has-validation">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Producto</label>
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
            $.ajax({
                url:"totalFacturaDeCompra.php",
                //data:{nombreApellidos:nombreApellidos,direccion:direccion},
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
        

        //var telefono=$('#inputTelefono').val();
        if((inputCostoProducto!='') && (inputCantidadCompra!='') && (inputCodigoProducto!='')){
            $.ajax({
                url:"queryRegistrarCompraProducto.php",
                data:{inputCostoProducto:inputCostoProducto,inputCantidadCompra:inputCantidadCompra,inputCodigoProducto:inputCodigoProducto,facturaCompra:facturaCompra},
                type:'post',
                    success:function(data1){
                        var json = JSON.parse(data1);
                     
                        var status = json.status;
                      /*if(status=='yaexistenoguardado'){
                        Swal.fire(
                        'Factura ya existe',
                                'Los datos no se registraron.',
                                'error'
                            )
                      }else */
                      if(status=='success'){
                            $('#inputCostoProducto').val('');
                            $('#inputCantidadCompra').val('');
                            $('#inputCodigoProducto').val('');
                            
                            $('#formularioAgregarFacturaCompras').modal('hide');

                            //cargarDatosTabla();
                            var tabla = $('#datatableCompras').DataTable();
                            tabla.ajax.reload();
                            
                            Swal.fire(
                                'Producto agregado',
                                'Los datos se guardaron correctamente.',
                                'success'
                            )
                            var btnTotalFac = document.getElementById("btnVerTotalFactura");
                            btnTotalFac.addEventListener('click', updateTotal());
                        
                        }else{
                            Swal.fire(
                                'Producto no guardado.',
                                'Los datos no se guardaron. Se produjo un error al querer guardar',
                                'warning'
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


<script src="../assets/js/validation.js"></script>



</body>
</html>