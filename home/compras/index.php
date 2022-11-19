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
                <input type="text" name="inputDocumentoProveedor" class="form-control" id="inputDocumentoProveedor" placeholder="No factura" required autocomplete="off" >
                
            </div>

        </div>

        <div class="col-auto">
            <div class="col">
                <label for="Name" class="form-label">Fecha factura proveedor</label>
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
                    <th>Número documento</th>
                    <th>Fecha registro</th>
                    <th>Fecha factura proveedor</th>
                    <th>Nit proveedor</th>
                    <th>Estado</th>
                    <th>Agregar</th>
            </thead>
            <tbody>
            </tbody>
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

  
        event.preventDefault();
        var inputDocumentoProveedor=$('#inputDocumentoProveedor').val();
      
       var inputNitProveedor = document.getElementById("inputNitProveedor").value;
       
       var inputFechaFacturaProveedor = document.getElementById("inputFechaFacturaProveedor").value;

       
       //alert("fan: "+inputNitProveedor);
       //var inputNitProveedor1 = $('#inputNitProveedor').val();;
      
        if((inputDocumentoProveedor!='')){
            $.ajax({
                url:"queryRegistrarFacturaCompras.php",
                data:{inputDocumentoProveedor:inputDocumentoProveedor,inputNitProveedor:inputNitProveedor,inputFechaFacturaProveedor:inputFechaFacturaProveedor},
                type:'post',
                    success:function(data1){
                        //alert("estoy aqui: "+data1);
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
                                'No se guardaron los datos.',
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


<!--script>

        
/*** Nota importante: en data tienen que ir los valores en minuscula de la tabla que queremos mostrar sus datos
 */
    $(document).ready(function(){
        $("#datatableFacturaCompras").DataTable({
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
                //"url":"https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
                "url":"../assets/json/idiomaDataTable.json"

            },
            "responsive": true,
        });
    });
</script-->

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
                
                //eliminarDatos(".activarAnularFactura","#datatableVentasHoy","queryAnularFacturaVenta.php",'La venta de factura se anulo correctamente.',"La factura de venta no se pudo eliminar se produjo un error","¿Confirmar anulacion de factura?","Sí, eliminar factura de venta");


            });
    }
</script>


</body>
</html>