<?php
  //session_start();
  include "../sesion/sesion.php";
  include "../config/config.php";
  date_default_timezone_set('America/Guatemala');    
?>


<html lang="en">
<head>
    <?php
        //session_start();
        include "../includes/head.php";
    ?>
    <title>Crear factura de compras</title>
</head>
<body>
<div class="container">


<?php
                require "../conexion.php";
                $consultaProductos="SELECT * FROM Productos";
                
                $ejecutarConsultaProductos = pg_query($conexion,$consultaProductos);
                if (!(pg_num_rows($ejecutarConsultaProductos))) {
                    echo '<div class="d-grid gap-2 col-6 mx-auto" style="margin-bottom:3%">
<div class="alert alert-danger" role="alert" style="margin-top:5%">
                    Sin productos registrados. Ingresa primero productos.
                  </div>
                  <a href="../index.php" class="btn btn-primary">Menu principal</a>
                  </div>';
               
            ?>

<?php
 }else{


?>




<div class="alert alert-success" role="alert" style="margin-left:5%;margin-right:5%;margin-top:20px;">
    <h2>Crear factura de compras</h2>
        
</div>

<nav class="navbar navbar-light bg-light">
    
<div class="container-fluid">
    
    <form id="guardarDatosFormulario" name="guardarDatosFormulario" class="row g-3 needs-validation" novalidate>
     
        <!-- inicio formulario-->
        <div class="col-auto">
            <div class="col">
                <label for="Name" class="form-label">Documento proveedor</label>
                <!--input type="text" name="inputDocumentoProveedor" class="form-control" id="inputDocumentoProveedor" placeholder="No factura" required autocomplete="off" onkeyup="habilitarCajaProducto();"-->
                <input type="text" name="inputDocumentoProveedor" class="form-control" id="inputDocumentoProveedor" placeholder="No factura" required autocomplete="off" maxlength="50">
                
            </div>

        </div>

        <div class="col-auto">
            <div class="col">
                <label for="Name" class="form-label">Fecha proveedor</label>
                <?php  
                    date_default_timezone_set('America/Guatemala'); 
                ?>
                <!--input type="date" name="inputFechaFacturaProveedor" class="form-control" id="inputFechaFacturaProveedor" placeholder="Fecha facturado por proveedor" required-->
                <input type="date" id="inputFechaFacturaProveedor" class="form-control" name="inputFechaFacturaProveedor" required value="<?php echo date("Y-m-d"); ?>">
      
            </div>
        </div>

        <div class="col-auto">
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Proveedor</label>
                <?php
                include '../conexion.php';
                         
                         include "../datos/funcionesDatos.php";
                         datosCombobox("inputNitProveedor",$conexion,"SELECT nitProveedor,nombreEmpresa FROM Proveedor");
                         ?>
            </div>
        </div>
     
      </form>
      
    </div>

    <div class="container">
    <div class="mb-3 row">
    <label for="staticEmail" class="form-label"><strong>Fecha inicio</strong></label>
    <div class="col-sm-10">
    <?php  
            date_default_timezone_set('America/Guatemala'); 
        ?>
          <input type="date" id="inputFechaInicio" class="form-control" name="inputFechaInicio" required value="<?php echo date("Y-m-d"); ?>">
    </div>
  </div>

  <div class="mb-3 row">
    <label for="staticEmail" class="form-label"><strong>Fecha fin</strong></label>
    <div class="col-sm-10">
        <?php  
            date_default_timezone_set('America/Guatemala'); 
        ?>
        <input type="date" id="inputFechaFin" class="form-control" name="inputFechaFin" required value="<?php echo date("Y-m-d"); ?>">
    </div>
  </div>

 <div class="mb-3 row">
    <label for="staticEmail" class="form-label"><strong>Aplicar cambios</strong></label>
    <div class="col-sm-10">
       
          <img src="../assets/img/search-2.png" style="width:32px;height:32px" class="zoomImagen" onclick="cargarDatosCompras();">
    </div>
  </div>
  </div>

</nav>

<button id="addRow" name="addRow"  class="btn btn-success" onclick="agregarFacturaCompra()">
        Agregar factura de compra
        <img src="../assets/img/shopping-cart-5.png" style="width: 64px;heigth: 64px;" class="zoomImagen">
    </button>

<table class="table table-striped table-bordered nowrap" id="datatableFacturaCompras" name="datatableFacturaCompras" style="width:100%">
            <thead>
                   
                    <th>#</th>
                    <th>No. factura</th>
                    <th>Fecha registro</th>
                    <th>Fecha proveedor</th>
                    <th>Nit proveedor</th>
                    <th>Estado</th>                   
                    
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

<div class="d-grid gap-2 col-6 mx-auto" style="margin-bottom:3%">

<a class="btn btn-primary" href="../index.php" role="button">Menu principal</a></div>

</div>


<?php
 }
?>
</div>


<script src="../assets/js/sum.js"> </script>

<script>        
function agregarFacturaCompra(){ 

    //alert("estoy aquiiii");
        //event.preventDefault();
        var inputDocumentoProveedor=$('#inputDocumentoProveedor').val();
      
       var inputNitProveedor = document.getElementById("inputNitProveedor").value;
       
       var inputFechaFacturaProveedor = document.getElementById("inputFechaFacturaProveedor").value;

       
       //alert("fan: "+inputNitProveedor);
       //var inputNitProveedor1 = $('#inputNitProveedor').val();;
      
        if((inputDocumentoProveedor!='')){
            $.ajax({
                url:"queryRegistrarFacturaCompras.php",
                data:{inputDocumentoProveedor:inputDocumentoProveedor,inputNitProveedor:inputNitProveedor,inputFechaFacturaProveedor:inputFechaFacturaProveedor},
                type:"POST",
                    success:function(data1){
                       alert("estooy aquiii: "+data1);

                        
                        var json = JSON.parse(data1);
                        
                        if(json=='registrado'){
                            //$('#inputDatos').val('');
                            //$('#inputDireccion').val('');
                            //$('#inputNit').val('');
                            $('#inputDocumentoProveedor').val('');
                            //$('#formularioAgregarCliente').modal('hide');
                            //cargarDatosTabla();
                            var table = $("#datatableFacturaCompras").DataTable();
                            table.ajax.reload();

                            Swal.fire(
                                'Factura registrado',
                                'El número de factura se registro correctamente',
                                'success'
                            )
                        }else if(json=='enuso'){
                            Swal.fire(
                                'Factura de compra.',
                                'El numero de factura o documente se encuentra registrado.',
                                'error'
                            )
                        }else{
                            Swal.fire(
                                'Factura de compra no guardado.',
                                'No se guardaron los datos.'+data1,
                                'info'
                            )
                        }
                    }
                }
            );
        }else{
              Swal.fire(
                'Campos vacios.',
                'Por favor llena todos los campos.',
                'warning'
                )
        }
    //});
}
</script>  

<script>
        cargarDatosCompras();
        function cargarDatosCompras(){

            var fechaInicio = document.getElementById("inputFechaInicio").value;
            var fechaFin = document.getElementById("inputFechaFin").value;
       
            $(document).ready(function(){
                $('#datatableFacturaCompras').DataTable({
                    "destroy":true,
                    
                    "ajax":{
                        "url":"queryFacturas.php",
                        "data":{fechaInicio:fechaInicio,fechaFin:fechaFin},
                        "dataSrc":""
                    },
                    "processing": true,
                    "order":[[0,"desc"]],
                    dom: 'Bfrtip',
                    /* drawCallback: function () {
      var api = this.api();
     
      $(api.columns(5).footer()).html(
        'Total: Q.'+api.column(5, {page:'current'} ).data().sum()
      );
      
      totalVentaComprobante=api.column(5, {page:'current'} ).data().sum();
    },*/
                    /*footerCallback: function (row, data, start, end, display) {
                        var api = this.api();
                        
 // Remove the formatting to get integer data for summation
 var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

                       
  // Total over all pages
                total = api
                .column(1)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(1, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


                        $(api.column(1).footer()).html('Total página: Q.' + pageTotal.toFixed(2) + ' ( Q.' + total.toFixed(2) + ' total compras)');
                        
                    },*/
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





                $('#datatableFacturaCompras').on("click", ".activarEliminarFacturaCompra", function(event) {
                event.preventDefault();
                var idEliminar = $(this).data('id');
               alert("eliminooooo "+idEliminar);
                $.ajax({
                    url: "queryAnularFacturaCompra.php",
                    data: {
                        id: idEliminar
                    },
                    type: 'POST',
                    success: function(data) {
                        alert("estoy aqui:"+data);
                        Swal.fire({
  title: '¿Confirmar anulación de factura de compra?',
  text: "La anulación solo se puede realizar una sola vez.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'Cancelar',
  confirmButtonText: 'Si, deseo anular la factura de compra.'
}).then((result) => {
  if (result.isConfirmed) {
    /*Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )*/
    var json = JSON.parse(data);
                        
                        if(json=="anulado"){
                            $('#datatableFacturaCompras').DataTable().ajax.reload();
                            
                              Swal.fire(
                                'Factura de compra anulado.',
                                'El inventario se actualizo.',
                                'success'
                            )
                        }else if(json=="noanulado"){
                              Swal.fire(
                                'Factura de compra no anulado.',
                                'La factura de compra no se anulo. Es posible que actualmente este anulado.',
                                'error'
                            )
                        }else if(json=="facturanoexiste"){
                              Swal.fire(
                                'Factura no existe.',
                                'La factura no existe.',
                                'error'
                            )
                        }else{
                            Swal.fire(
                                'Error controlado.',
                                'Se produjo algun error o es posible que este dato este siendo usado en otro lado.',
                                'error'
                            )
                        }


  }
})
                        


                    }
                });
            });


                
 //               eliminarDatos(".activarEliminarFacturaCompra","#datatableFacturaCompras","queryAnularFacturaCompra.php",'La venta de factura se anulo correctamente.',"La factura de venta no se pudo eliminar se produjo un error","¿Confirmar anulacion de factura de compra?","Sí, anular factura de compra");


            });
    }
</script>


</body>
</html>