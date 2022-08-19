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
        <div class="alert alert-primary" role="alert" style="margin-top:20px">
            <h2>Total ventas de hoy</h2>
            <!-- Button trigger modal -->
        </div>
        <?php
            include '../conexion.php';

             $verificarSiHayVentasHoy = "SELECT * FROM FacturaVenta";
             $ejecutarConsultaProductos = pg_query($conexion,$verificarSiHayVentasHoy);
             
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
                        <th>No. factura</th>
                        <th>Codigo cliente</th>
                        <th>Total venta</th>
                        <th>Anular factura de venta</th>
                </thead>
                <tbody>
                </tbody>
        </table>
        <a class="btn btn-primary" href="../index.php" role="button">Menu principal</a>';

             }
        ?>

    </div> 
    <script>
            $(document).ready(function(){
                $('#datatableVentasHoy').DataTable({
                    "ajax":{
                        "url":"queryResumenVentasHoy.php",
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
                
                eliminarDatos(".activarAnularFactura","#datatableVentasHoy","queryAnularFacturaVenta.php",'La venta de factura se anulo correctamente.',"La factura de venta no se pudo eliminar se produjo un error","¿Confirmar anulacion de factura?","Sí, eliminar factura de venta");


            });

</script>

</body>
</html>
