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
    <title>Resumen de ventas de hoy</title>

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
       
          <img src="../assets/img/search-2.png" style="width:32px;height:32px" class="zoomImagen" onclick=" cargarDatosVentas();">
    </div>
  </div>

        <?php
            include '../conexion.php';
            date_default_timezone_set('America/Guatemala');   
            $fechaHoy = date('Y-m-d');
             $verificarSiHayVentasHoy = "SELECT DISTINCT facturaventa.numerodocumentofacturaventa,facturaventa.fechafacturaventa,facturaventa.totalventa,nitcliente,horaVenta,facturaventa.codigousuario  FROM Clientes INNER JOIN FacturaVenta AS facturaventa
             ON Clientes.codigocliente=FacturaVenta.codigocliente INNER JOIN  detallefacturaventa
             ON FacturaVenta.numerodocumentofacturaventa=detallefacturaventa.numerodocumentofacturaventa
             
             WHERE facturaventa.numerodocumentofacturaventa=detallefacturaventa.numerodocumentofacturaventa
             AND facturaventa.fechafacturaventa=$1 ORDER BY horaventa DESC";

             //$ejecutarConsultaProductos = pg_query($conexion,$verificarSiHayVentasHoy);
             pg_prepare($conexion,"queryTablaVentasHoy",$verificarSiHayVentasHoy) or die ("No se pudo preparar la consulta queryTablaVentasHoy");

             $ejecutarConsultaProductos = pg_execute($conexion,"queryTablaVentasHoy",array($fechaHoy));
     


             if (pg_num_rows($ejecutarConsultaProductos)==0) {
                 echo '<div class="alert alert-danger" role="alert" style="margin-left:10%;margin-right:10%;margin-top:10%">
                    No hay ventas registrados hoy.
                 </div>
                 <div class="d-grid gap-2 col-6 mx-auto">
                     <a class="btn btn-primary" href="../index.php">Menu principal</a>
                 </div>
                 ';   
             }else{

                echo '<table class="table table-striped table-bordered nowrap" id="datatableVentasHoy" name="datatableVentasHoy" style="width:100%">
                <thead>
                        <th>No. comprobante</th>
                        <th>Fecha venta</th>
                        <th>Total venta</th>
                        <th>Nit cliente</th>
                        <th>Hora venta</th>
                        <th>Codigo vendedor</th>
                        <th>Anular factura de venta</th>
                        <th>Detalles</th>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <a class="btn btn-primary" href="../index.php" role="button">Menu principal</a>';

             }
        ?>

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


                        $(api.column(2).footer()).html('Total página: Q.' + pageTotal + ' ( Q.' + total + ' total ventas)');
                        
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
                
                eliminarDatos(".activarAnularFactura","#datatableVentasHoy","queryAnularFacturaVenta.php",'La venta de factura se anulo correctamente.',"La factura de venta no se pudo eliminar se produjo un error","¿Confirmar anulacion de factura?","Sí, eliminar factura de venta");


            });

    }

</script>

<script src="../assets/js/sum.js"> </script>


</body>
</html>
