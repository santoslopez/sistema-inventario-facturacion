<?php
  
  //session_start();
  include "../sesion/sesion.php";
  include "../config/config.php";
  date_default_timezone_set('America/Guatemala');    
?>

<html lang="en">
<head>
    <?php
        //representa el queryTableVentasHoy
        include "../includes/head.php";
    ?>
    <title>Resumen ventas de hoy - Comprobante</title>

</head>
<body>
    <div class="container">
        <div class="alert alert-primary" role="alert" style="margin-top:20px">
            <h2>Resumen ventas de hoy</h2>
            <!-- Button trigger modal -->
        </div>

<div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label"><strong>Fecha inicio</strong></label>
    <div class="col-sm-10">
       
          <input type="date" id="inputFechaInicio" class="form-control" name="inputFechaInicio" required value="<?php echo date("Y-m-d"); ?>">
    </div>
  </div>

  <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label"><strong>Fecha fin</strong></label>
    <div class="col-sm-10">
       
          <input type="date" id="inputFechaFin" class="form-control" name="inputFechaFin" required value="<?php echo date("Y-m-d"); ?>">
    </div>
  </div>

 <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label"><strong>Aplicar cambios</strong></label>
    <div class="col-sm-10">
       
          <img src="../assets/img/search-2.png" style="width:32px;height:32px" class="zoomImagen" onclick="cargarDatosVentas();">
    </div>
  </div>


  <table class="table table-striped table-bordered nowrap" id="datatableVentasHoy" name="datatableVentasHoy" style="width:100%">
                <thead>
                        <th>No. comprobante</th>
                        <th>Fecha venta</th>
                        <th>Total venta</th>
                        <th>Hora venta</th>
                        <th>Estado</th>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <a class="btn btn-primary" href="../index.php" role="button">Menu principal</a>
    <!-- 

    date_default_timezone_set('America/Guatemala');   
    -->
       
    </div> 
    <script>
        cargarDatosVentas();
        function cargarDatosVentas(){

            var fechaInicio = document.getElementById("inputFechaInicio").value;
            var fechaFin = document.getElementById("inputFechaFin").value;
       
            $(document).ready(function(){
                $('#datatableVentasHoy').DataTable({
                    "destroy":true,
                    
                    "ajax":{
                        "url":"queryResumenVentasHoy.php",
                        "data":{fechaInicio:fechaInicio,fechaFin:fechaFin},
                        "dataSrc":""
                    },
                    "processing": true,
                    "order":[[0,"desc"]],
                    dom: 'Bfrtip',
                    footerCallback: function (row, data, start, end, display) {
                        var api = this.api();
                        
 // Remove the formatting to get integer data for summation
 var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

                        /*$( api.table().footer() ).html(
                            'Total: Q.'+api.column(2,{page:'current'} ).data().sum()
                            
                        );*/
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


                        $(api.column(2).footer()).html('Total página: Q.' + pageTotal.toFixed(2) + ' ( Q.' + total.toFixed(2) + ' total ventas)');
                        
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
                        "url":"../assets/json/idiomaDataTable.json"
                    },
                    "responsive": true,
                });
                
                $('#datatableVentasHoy').on("click", ".activarEliminarFacturaVenta", function(event) {
                event.preventDefault();
                
                Swal.fire({
  title: '¿Confirmar la anulación de factura de venta?',
  text: "Está acción solo se puede realizar una sola vez.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, quiero anular la factura de venta.'
}).then((result) => {
  if (result.isConfirmed) {
   

    var idEliminar = $(this).data('id');
                $.ajax({
                    url: "queryAnularFacturaVenta.php",
                    data: {
                        id: idEliminar
                    },
                    type: 'POST',
                    success: function(data) {
                        var json = JSON.parse(data);
                       
                        
                        if(json=="anulado"){
                            $('#datatableVentasHoy').DataTable().ajax.reload();
                            
                              Swal.fire(
                                'Factura de venta anulado.',
                                'El inventario se actualizo.',
                                'success'
                            )
                        }else if(json=="noanulado"){
                              Swal.fire(
                                'Factura de venta no anulado.',
                                'La factura de venta no se anulo. Es posible que actualmente este anulado.',
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
                });





  }
})
                


                // fin eliminar proveedor

            });


                //eliminarDatos(".activarAnularFactura","#datatableVentasHoy","queryAnularFacturaVenta.php",'La venta de factura se anulo correctamente.',"La factura de venta no se pudo eliminar se produjo un error","¿Confirmar anulacion de factura?","Sí, eliminar factura de venta");


            });

    }

</script>

<script src="../assets/js/sum.js"> </script>


</body>
</html>
