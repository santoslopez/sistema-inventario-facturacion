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
    <title>Crear comprobante de venta</title>
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
                <input type="text" name="inputDocumentoProveedor" class="form-control" id="inputDocumentoProveedor" placeholder="No factura" required autocomplete="off" onkeyup="habilitarCajaProducto();">
                
            </div>

        </div>

        <div class="col-auto">
            <div class="col">
                <label for="Name" class="form-label">Fecha factura proveedor</label>
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

      
    </div>

     
      </form>

</nav>
<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="container-fluid">
  <form class="row g-3">
    <div class="col-auto">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Buscar producto: </label>
            
                <a onclick="buscarProducto();" class="btn btn-oustline-success"><img src="../assets/img/search-2.png" alt="MDN" style="width:40%" class="zoomImagen"></a>
                <input type="text" id="inputCodigoProducto" class="col-sm-10" name="inputCodigoProducto" required onblur="buscarProducto();" onkeyup="buscarProducto();" autocomplete="off" placeholder="Ingrese codigo del producto">        

            </div>
        </div> 

        <div class="col-auto">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Costo producto</label>
                <input type="number" name="inputCostoProducto" class="form-control" id="inputCostoProducto" placeholder="Costo de producto" required readonly min="0">
            </div>

        </div>

        <div class="col-auto">
            <div class="col-sm-10">
                <label for="Name" class="form-label">Cantidad</label>
                <input type="number" id="inputCantidadCompra" class="form-control soloNumeros" name="inputCantidadCompra" required min="1" readonly pattern="[1-9]+" placeholder="Cantidad">
            </div>
        </div>


</form>
</div>
</nav>

<button id="addRow" class="btn btn-primary">Agregar producto</button>
<button id="button" class="btn btn-danger">Eliminar fila productos</button>
<table id="example" class="display" style="width:100%">
<thead style="background:black;color:white">
    <tr>
        <th>Codigo</th>
        <th>Unidad</th>
        <th>Precio</th>
        <th>Subtotal</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</tfoot>
</table>

<div class="d-grid gap-2 col-6 mx-auto" style="margin-bottom:3%">


                
                
       <button onclick="guardarFacturaCompra();" class="btn btn-success" type="button" id="botonFinalizarCompra" name="botonFinalizarCompra" >
                    Finalizar factura de compra
                <img src="../assets/img/shopping-cart-5.png" style="width: 64px;heigth: 64px;" class="zoomImagen">
                </button>
              
            

<a class="btn btn-primary" href="../index.php" role="button">Menu principal</a></div>

</div>


<?php
 }
?>
</div>


<script>
    function habilitarCajaProducto(){
    
     var inputDocPro= $("#inputDocumentoProveedor").val();

    if(inputDocPro!=''){ 
        document.getElementById("inputCodigoProducto").disabled=false;
        //document.getElementById("botonFinalizarCompra").disabled=false;


    }else{
        document.getElementById("inputCodigoProducto").disabled=true;
        //document.getElementById("botonFinalizarCompra").disabled=true;

    }
 }
</script>

<script>
    // necesario para que se habilite el boton de agregar producto
    var estadoCodigoProducto;

     var table;

var totalVentaComprobante;

$(document).ready(function () {
     
    // deshabilitamos la caja para buscar productos
    document.getElementById("inputCodigoProducto").disabled=true;
   

    table = $('#example').DataTable( {
        dom: 'Bfrtip',
        "language":{
            "url":"../assets/json/idiomaDataTable.json"
        },
    drawCallback: function () {
      var api = this.api();
     
      $(api.columns(3).footer()).html(
        'Total: Q.'+api.column(3, {page:'current'} ).data().sum()
      );
      
      totalVentaComprobante=api.column(3, {page:'current'} ).data().sum();
    }/*,
    buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],*/
  } );

      
    $('#addRow').on('click', function () {
        //alert("aqui");
        var inputCodigoProducto =  document.getElementById("inputCodigoProducto").value;
        let inputCantidadCompra =  document.getElementById("inputCantidadCompra").value;

        let inputCostoProducto =  document.getElementById("inputCostoProducto").value;
        
       
        if((inputCodigoProducto !='') && (inputCantidadCompra!='') && (inputCostoProducto!='')){

            if(estadoCodigoProducto=="aceptado"){
                
                if ((parseInt(inputCantidadCompra)>=1))   {
                    document.getElementById("inputCostoProducto").value = "";
                    document.getElementById("inputCantidadCompra").value = "";
                    document.getElementById("inputCodigoProducto").value = "";

                    document.getElementById("inputCostoProducto").readOnly = true;
                    document.getElementById("inputCantidadCompra").readOnly = true;

                        
                    table.row.add([inputCodigoProducto,
                    inputCantidadCompra,
                    parseFloat(inputCostoProducto),
                    parseInt(inputCantidadCompra) * parseFloat(inputCostoProducto)]).draw(false);
                
                
                }else{
                    // sweet alert success
                    Swal.fire({
                        icon: 'error',
                        title: 'Unidades de compra no validas',
                        text: 'El numero de unidades de compra no puede ser mayor a 1',
                        footer: '<a href>Cantidad de compra invalida.</a>'
                    })
                }


            }else if(estadoCodigoProducto=="noaceptado"){
                Swal.fire('Codigo producto erroneo','El codigo del producto es incorrecto','warning')
                document.getElementById("inputCostoProducto").value = "";
                document.getElementById("inputCantidadCompra").value = "";
                //document.getElementById("inputCodigoProducto").value = "";

            }



        }else{
            Swal.fire(
                'Campos incorrectos o vacios',
                'En precio y unidades tiene que ser numerico',
                'info'
            )
        }


    });
 

    // eliminar datatable fila
    $('#example tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
 
    $('#button').click(function () {
        table.row('.selected').remove().draw(false);
    });
   
    // Automatically add a first row of data

    //$('#addRow').click();



});
</script>
<!--script src="https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js"> </script-->
<script src="../assets/js/sum.js"> </script>

<script>
function guardarFacturaCompra(){


    var inputDocPro= $("#inputDocumentoProveedor").val();

    if(inputDocPro!=''){ 
        //document.getElementById("inputCodigoProducto").disabled=false;
        //document.getElementById("botonFinalizarCompra").disabled=false;



     // se verifica que existan filas en la tabla
     var cantidadFilas = table.rows().count();
     
     if (cantidadFilas==0) {
        Swal.fire(
            'Sin productos',
            'Debe agregar productos para finalizar la compra.',
            'warning'
        )
    }else{
       // inicio
           
       var tableJSON = table.data().toArray();//SI FUNCIONA
            var valorDatatable = JSON.stringify(tableJSON);

           Swal.fire({
            title: '¿Finalizar la factura de compra?',
            showDenyButton: true,
            //showCancelButton: true,
            icon: 'info',
            confirmButtonText: 'Si, finalizar compra',
            denyButtonText: `No guardar la factura todavia`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                
                var  inputNitProveedor = document.getElementById("inputNitProveedor").value;

                var  inputDocumentoProveedor = document.getElementById("inputDocumentoProveedor").value;

                var  inputFechaFacturaProveedor = document.getElementById("inputFechaFacturaProveedor").value;
                
               
                
                var totalVentaEfectuado = totalVentaComprobante;
                        

                    $.ajax({
                        url:"queryRegistrarFacturaCompras.php",
                        //data:{tableJSON:JSON.stringify(tableJSON)}, //SI FUNCIONA DOBLE CORCH
                        data: {
                            tableJSON:valorDatatable,
                            inputNitProveedor:inputNitProveedor,
                            totalVentaEfectuado:totalVentaEfectuado,
                            inputDocumentoProveedor:inputDocumentoProveedor,
                            inputFechaFacturaProveedor:inputFechaFacturaProveedor
                        },

                    type:'POST',
                    success:function(data1){
                       
                        //alert("data 1:"+data1);
                        var json = JSON.parse(data1);
                        
                        if (json=="compraregistrado") {
                           
                            Swal.fire({
                            title: 'Factura de compra registrado correctamente',
                            text: "Presiona el boton para recargargar la pagina",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }else{
                                window.location.reload();
                            }
                            })
                        }else if (json=="compranoregistrado") {
                            Swal.fire(
                            'Compra no realizado',
                            'No se guardo la compra. Se produjo el siguiente error'+data1,
                            'info')

                        }else{
                            Swal.fire(
                            'Error controlado: '+data1,
                            'No se guardo la venta',
                            'info')
                        }
                    },
                    
                }); 
            }
        })





        // fin 
    }






    }else{
        //document.getElementById("inputCodigoProducto").disabled=true;
        //document.getElementById("botonFinalizarCompra").disabled=true;
         Swal.fire(
                            'Necesitas ingresar el codigo de la factura',
                            'Campos obligatorios',
                            'error')
    }

    

}
</script>

<script>

    function  buscarProducto(){
       
        var inputCodigoProducto = $("#inputCodigoProducto").val();
        
        $.ajax({
            url:'queryBuscarProductoRegistrado.php',
            data:{inputCodigoProducto:inputCodigoProducto},
            type:'POST',
            /*beforeSend:function(){
                alert("123 buscando datos");
            },
            error:function(){
                alert("Error");
            },
            complete:function(){
                alert("listo");
            },*/
            success:function(data){
               
                var json = JSON.parse(data);
                if (json=="productoencontrado") {
                    /*Swal.fire(
                        'Producto encontrado',
                        'El producto se encuentra registrado',
                        'info'
                        )*/
                        estadoCodigoProducto="aceptado";
                        document.getElementById("inputCostoProducto").readOnly = false;
                        document.getElementById("inputCantidadCompra").readOnly = false;

                     

                }else  if (json=="productonoencontrado") {
                    /*Swal.fire(
                        'Producto no encontrado',
                        'Es posible que el codigo sea incorrecto o el producto no este registrado',
                        'error'
                        )*/
                    estadoCodigoProducto="noaceptado";
                    document.getElementById("inputCantidadCompra").value = "";
                    document.getElementById("inputCostoProducto").value = "";



                    document.getElementById("inputCostoProducto").readOnly = true;
                        document.getElementById("inputCantidadCompra").readOnly = true;
                   
                   
                }else{
                    Swal.fire(
                        'Producto no encontrado',
                        'Es posible que el codigo sea incorrecto o el producto no este registrado',
                        'error'
                        )
                }


            }
        })


    }
</script>
<!--script src="../assets/js/validation.js"></script-->


</body>
</html>