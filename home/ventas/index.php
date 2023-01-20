<?php
  include "../sesion/sesion.php";
  include "../config/config.php";
   date_default_timezone_set('America/Guatemala');    
?>
<html lang="en">
<head>
    <?php
        include "../includes/head.php";
    ?>
    <title>Crear comprobante de venta</title>
</head>
<body>
    <div class="container">
        <?php 
      include "../conexion.php";

    $verificarSiHayProductos = "SELECT * FROM Productos";
    $ejecutarConsultaProductos = pg_query($conexion,$verificarSiHayProductos );
    $data = array();
    if (pg_num_rows($ejecutarConsultaProductos)==0) {
        echo '<div class="alert alert-danger" role="alert" style="margin-left:10%;margin-right:10%;margin-top:10%">
        Sin productos, por favor registra productos primero.
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a class="btn btn-primary" href="../index.php">Menu principal</a>
        </div>';   
    }else{
        echo '
    <div class="alert alert-primary" role="alert" style="margin-left:5%;margin-right:5%;margin-top:20px;">
    <h2>Crear comprobante de ventas</h2>
        
    </div>
    
    <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
    <form class="row g-3">
    <div class="col-auto">
      <label for="inputNitCliente">Nit de cliente</label>
      <input type="text" class="form-control" id="inputCodigoCliente" name="inputCodigoCliente" style="display:none">

      <input type="text" class="form-control" id="inputNitCliente" name="inputNitCliente" placeholder="Nit de cliente" onblur="buscarCliente();" autocomplete="off" autofocus>
    </div>
    <div class="col-auto" style="display:none">
      <label for="inputNombreCliente1">Nombre cliente</label>
      <input type="text" class="form-control" id="inputNombreCliente" name="inputNombreCliente" placeholder="Nombre de cliente" readonly autocomplete="off">
    </div>
    <div class="col-auto">
        <label for="inputDetalle1">Nombre cliente</label>
        <input type="text" class="form-control" id="inputDetalle1" name="inputDetalle1" placeholder="Nombre de cliente" autocomplete="off" maxlength="100">
   </div>
   <div class="col-auto">
        <label for="inputDetalle2">Direccion</label>
        <input type="text" class="form-control" id="inputDetalle2" name="inputDetalle2" placeholder="Direccion" autocomplete="off" maxlength="100">
   </div>

    <div class="col-auto">
        <a class="alert alert-primary" href="../clientes/index.php" role="button" target="_blank">
        Registrar cliente nuevo
        <img src="../assets/img/menu/add-contact.png" style="width: 32px;heigth: 32px;" class="zoomImagen">
        </a>
    </div>
  </form>
  </div>
  </nav>
  <nav class="navbar" style="background:#F8FCFF">
  <div class="container-fluid">
  <form class="row g-3"  class="needs-validation" novalidate autocomplete="off">
  <div class="col-auto">
    <label for="inputCodigoProducto">Buscar producto</label>
    <input type="text" class="form-control" id="inputCodigoProducto" name="inputCodigoProducto" placeholder="Codigo producto" onblur="buscarProducto();"  onkeyup="buscarProducto();" autocomplete="off"> 
  </div>
  <div class="col-auto">
  <label for="inputNombreProducto">Descripcion</label>
  <input type="text" class="form-control" id="inputNombreProducto" name="inputNombreProducto" placeholder="Nombre producto" readonly required autocomplete="off">
    </div>
  <div class="col-auto has-validation">
    <label for="inputCantidadVendido">Cantidad</label>
    <input type="number" class="form-control soloNumeros" id="inputCantidadVendido" name="inputCantidadVendido" placeholder="Cantidad"  pattern="[1-9]+" required autocomplete="off">
        
    <input type="number" class="form-control" id="inputUnidadesDisponibles" name="inputUnidadesDisponibles" placeholder="Unidades disponibles"  pattern="[1-9]+" required readonly style="display:none">
    <input type="number" class="form-control" id="inputCostoProductoActual" name="inputCostoProductoActual" placeholder="Costo promedio actual"  required readonly style="display:none" autocomplete="off" >
    
    
    </div>
  <div class="col-auto has-validation">
  <label for="inputCantidadVendido">Precio vendido</label>
  <input type="number" class="form-control" id="inputPrecioVendido" name="inputPrecioVendido" placeholder="Precio" required min="0" step="0.01" title="Solo se permite: números y punto. Ejemplo: 100, 100.55. Numeros solo con 2 decimales" >
</div>
  <div class="col-auto">
      <a class="btn" href="../inventario/index.php" role="button" target="_blank">
        Listado
      <img src="../assets/img/menu/drill.png" style="width: 32px;heigth: 32px;" class="zoomImagen">
      </a>
  </div>
</form>
</div>
</nav>
<button id="addRow" class="btn btn-success">Agregar producto</button>
<button id="button" class="btn btn-danger">Eliminar fila productos</button>
<table id="example" class="display" style="width:100%">
<thead style="background:black;color:white">
    <tr>
        <th>Codigo</th>
        <th>Descripcion</th>
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
        <th></th>
    </tr>
</tfoot>
</table>
<div class="d-grid gap-2 col-6 mx-auto" style="margin-bottom:3%">
<button onclick="guardarVenta()" class="btn btn-success" type="button" id="botonGuardarVenta" name="botonGuardarVenta">
Guardar venta
<img src="../assets/img/disk.png" style="width: 40px;heigth:40px;" class="zoomImagen">
</button>
<a href="../resumenventas/index.php" class="btn btn-info" type="button" target="_blank">
Resumen ventas hoy
<img src="../assets/img/statistics.png" style="width: 40px;heigth:40px;" class="zoomImagen">
</a>
<a class="btn btn-primary" href="../index.php" role="button">Menu principal</a></div>
</div>';



    }
    ?> 

</script>

<script>
    var estadoCodigoProducto;
    function buscarProducto(){
        
        var inputCodigoProducto = $("#inputCodigoProducto").val();

        //alert("aqui" +inputCodigoProducto);


        $.ajax({
            url:'queryBuscarCodProducto.php',
            data:{inputCodigoProducto:inputCodigoProducto},
            type:'POST',
            success:function(data){
               // alert("estoy aqui: "+data);
                var json = JSON.parse(data);
                
                if (json==false) {
                    /*Swal.fire(
                        'Producto no encontrado',
                        'Es posible que el codigo sea incorrecto',
                        'error'
                        )*/
                        estadoCodigoProducto="noaceptado";
                       // alert("aqui" +json);
                }else{
                    estadoCodigoProducto="aceptado";

                    $("#inputNombreProducto").val(json.descripcion);
                    
                    $("#inputUnidadesDisponibles").val(json.cantidadcomprado);
                    $("#inputCostoProductoActual").val(json.precioCompra);
                   

                }


            }
        })


    }
</script>


<script>
    function buscarCliente(){
        
        var inputNitCliente = $("#inputNitCliente").val();
       


        $.ajax({
            url:"queryBuscarCliente.php",
            data:{inputNitCliente:inputNitCliente},
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
                if (json==false) {
                    Swal.fire(
                        'Cliente no encontrado',
                        'Es posible que el nit no es el correcto o no este registrado',
                        'error'
                        )
                        document.getElementById("inputCodigoProducto").disabled=true;
                        //document.getElementById("inputDatosCliente").disabled=true;
                        //document.getElementById("inputDetalle1").disabled=true;
                        //document.getElementById("inputDetalle2").disabled=true;


                }else{
                    $("#inputNombreCliente").val(json.nombreapellidos);
                    $("#inputCodigoCliente").val(json.codigocliente);

                    document.getElementById("inputCodigoProducto").disabled=false;
                    
                    //$("#inputNombreCliente").val(json.nombreapellidos);
                   

                    
                }


            }
        })


    }
</script>


<script>
     var table;

     var totalVentaComprobante;
$(document).ready(function () {
    

    document.getElementById("inputCodigoProducto").disabled=true;

   // document.getElementById("inputDatosCliente").disabled=true;

   // document.getElementById("inputDetalle1").disabled=true;
   // document.getElementById("inputDetalle2").disabled=true;

    table = $('#example').DataTable( {
        dom: 'Bfrtip',
        stateSave: true,

        //languague:español,
        "language":{
            "url":"../assets/json/idiomaDataTable.json"
        },

    drawCallback: function () {
      var api = this.api();
     /*$(api.table().footer('Total: ') ).html(
        api.column( 3, {page:'current'} ).data().sum()
      );*/
      $(api.columns(4).footer()).html(
        'Total: Q.'+api.column(4, {page:'current'} ).data().sum()
      );
      
      totalVentaComprobante=api.column(4, {page:'current'} ).data().sum();
    }/*,
    buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],*/
  } );


     
    
    $('#addRow').on('click', function () {


        let codigoProducto =  document.getElementById("inputCodigoProducto").value;
        let nombreProducto =  document.getElementById("inputNombreProducto").value;
        var cantidadVendido =  document.getElementById("inputCantidadVendido").value;
        var precioVendido =  document.getElementById("inputPrecioVendido").value;
        let cantidadEnBodega = document.getElementById("inputUnidadesDisponibles").value;

        var productoIngresadoTable=true;

        // verifica que campos no esten vacios y sirve para hacer la verificacion que sea el campo correo, por ejemplo que sea entero,etc.
        if((codigoProducto !='') && (nombreProducto!='') && (cantidadVendido!='') && ( (precioVendido!='') && (precioVendido>=0) )){

            table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var data = this.data();
                var valorCodigo = data[0];
                if (valorCodigo==codigoProducto) {
                    Swal.fire(
                        'Producto ya agregado',
                        'El producto ya se encuentra en la lista',
                        'error'
                        )
                                //return false;  
                                productoIngresadoTable=false;                         
                        
                    
                    }

                    } );

 


            if(estadoCodigoProducto=="noaceptado"){
                Swal.fire('Codigo producto erroneo','El codigo del producto es incorrecto','warning')
            }else{

      

                if(parseInt(cantidadEnBodega)==0){
                    Swal.fire(                  
                    'Productos sin unidades disponibles',
                    'Actualmente no tenemos unidades para vender',
                    'error'
                    )

                }else{

                    // se hace la conversion de texto a numero
                    if ((parseInt(cantidadVendido)<=parseInt(cantidadEnBodega)) && (parseInt(cantidadVendido)>0))  {
                        
                        if(productoIngresadoTable==true){
                            table.row.add([codigoProducto,nombreProducto,cantidadVendido,precioVendido,cantidadVendido*precioVendido]).draw(false);

                        }
                                          
                        
                        document.getElementById("inputCodigoProducto").value = "";
                        document.getElementById("inputNombreProducto").value = "";
                        document.getElementById("inputCantidadVendido").value = "";
                        document.getElementById("inputPrecioVendido").value = "";
                        document.getElementById("inputUnidadesDisponibles").value = "";
                        document.getElementById("inputCostoProductoActual").value = "";
                    }else{
                        Swal.fire(
                        'Stock insuficiente',
                        'El numero de unidades es invalido o no se tiene en inventario. Disponible: '+cantidadEnBodega,
                        'warning')
                    }
                }
            }
        }else{
            Swal.fire(
                'Campos incorrectos o vacios',
                'En precio y unidades tiene que ser numerico. Ejemplo de precio: 200, 100.50, 4000.89 (No permitido uso de comas)',
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



<script>
    function guardarVenta(){

        var inputDetalle1 = $("#inputDetalle1").val();
        var inputDetalle2 = $("#inputDetalle2").val();
        
        // se verifica que existan filas en la tabla
        var cantidadFilas = table.rows().count();
       
        if (cantidadFilas==0) {
           Swal.fire(
                'Sin productos',
                'Debe agregar productos para guardar la venta.',
                'warning'
                )
        }else{
           
            var tableJSON = table.data().toArray();//SI FUNCIONA
            var table123 = JSON.stringify(tableJSON);



           Swal.fire({
            title: '¿Registrar la venta?',
            showDenyButton: true,
            //showCancelButton: true,
            icon: 'info',
            confirmButtonText: 'Guardar la venta',
            denyButtonText: `No guardar la venta`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                
                var  inputCodigoCliente = document.getElementById("inputCodigoCliente").value;

                var totalVentaEfectuado = totalVentaComprobante;
                        
                //var inputNitCliente = document.getElementById("inputNitCliente").value;

                // else if (result.isDenied) {
                    $.ajax({
                        url:"queryRegistrarVentas.php",
                        //data:{tableJSON:JSON.stringify(tableJSON)}, //SI FUNCIONA DOBLE CORCH
                        data: {
                            tableJSON:table123,inputCodigoCliente:inputCodigoCliente,totalVentaEfectuado:totalVentaEfectuado,inputDetalle1:inputDetalle1,inputDetalle2:inputDetalle2
                        },
                    /*"columns":[
                        {"data":"col1"},
                        {"data":"col2"},
                        {"data":"col3"},
                        {"data":"col4"}
                    ]*/
                    type:'POST',
                    success:function(data1){
                       
                       

                        var json = JSON.parse(data1);
                        
                        if (json=="ventaregistrado") {
                          
                            Swal.fire({
                            title: 'Venta registrado correctamente',
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

                            
                        }else if (json=="ventanoregistrado") {
                            Swal.fire(
                            'Venta no efectuado',
                            'No se guardo la venta',
                            'info')
                        
                        }else{
                            Swal.fire(
                            'Error controlado',
                            'No se guardo la venta',
                            'info'+data1)
                        }
                    }
                }); 
            }
        })
    }
}
</script>

<!--script src="https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js"> </script-->
<script src="../assets/js/sum.js"> </script>

<script src="../assets/js/validation.js"></script>

</body>

</html>