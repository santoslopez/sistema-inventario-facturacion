<?
    require "conexion.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <title>ines x</title>
  </head>
  <body>

<div class="container">
    <h1>Productos </h1>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Descripcion</label>
    <input type="text" id="txt1" aria-describedby="emailHelp" required>
    
    <label for="exampleInputPassword1" class="form-label">Unidades</label>
    <input type="number" id="txt2" required>
    <label for="exampleInputPassword1" class="form-label">Precios</label>
    <input type="number" id="txt3" required>
  </div>
  <button id="addRow" class="btn btn-success">Agregar producto</button>


<button id="button" class="btn btn-danger">Eliminar fila</button>

<form id="guardarDatosFormulario" name="guardarDatosFormulario">
    <input type="submit" class="btn btn-warning" id="btnEnviarDatos" name="btnEnviarDatos">

</form>


    <table id="example" class="display" style="width:100%">
        <thead style="background:black;color:white">
            <tr>
                <th>Descripcion</th>
                <th>Unidad</th>
                <th>Costo</th>
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
    </table></div>
    <!-- Optional JavaScript; choose one of the two! -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

 <script src="https://cdn.datatables.net/plug-ins/1.12.1/api/sum().js"> </script>
    
    
    
<!--script src="https://code.jquery.com/jquery-3.5.1.js"> </script-->
<!--script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script-->
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
     var table;
$(document).ready(function () {
    table = $('#example').DataTable( {
        dom: 'Bfrtip',
    drawCallback: function () {
      var api = this.api();
     /*$(api.table().footer('Total: ') ).html(
        api.column( 3, {page:'current'} ).data().sum()
      );*/
      $(api.columns(3).footer()).html(
        'Total: '+api.column( 3, {page:'current'} ).data().sum()
      );
    },
    buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
  } );



    var counter = 1;
    
    $('#addRow').on('click', function () {
        let caja =  document.getElementById("txt1").value;
        let unidades =  document.getElementById("txt2").value;
        let costo =  document.getElementById("txt3").value;


        table.row.add([caja, unidades, costo, unidades*costo]).draw(false);
        //console.log("Cantidad de elementos: "+table.data().length);

       document.getElementById("txt1").value = "";
       document.getElementById("txt2").value = "";
       document.getElementById("txt3").value = "";

        counter++;
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
    //var data11 = table.rows().data();
   
    // Automatically add a first row of data

    //$('#addRow').click();



});
</script>

<!--script>
$('#btnEnviarDatos').on('click', function () {
    $("txt1").val("");
    $("txt2").val("");
    $("txt3").val("");

//Si deseas recorrerlo
var table22 = table.data().toArray();


table.data().each(function(d){
    
   
   //Aqui haces lo que deseas con cada elemento
    //console.log("sexo reloj: " +d);
})
});
</script-->



<script>
    $(document).on('submit','#guardarDatosFormulario',function(event){
        event.preventDefault();
        var tableJSON = table.data().toArray();//SI FUNCIONA
        
        //var object = table.data();//
        var table123 = JSON.stringify(tableJSON);

        //var table123 = table.rows().data().toArray();
        
        alert("folalr a ines: "+table123);
        //var objectA = table.data().toArray();//

        //alert("stringify: "+hola);
        alert("to array: "+tableJSON);
        
        console.log()
            $.ajax({
                url:"registrar.php",
                //data:{tableJSON:JSON.stringify(tableJSON)}, //SI FUNCIONA DOBLE CORCH
                data: {
                    tableJSON: table123
                },
                "columns":[
                    {"data":"col1"},
                    {"data":"col2"},
                    {"data":"col3"},
                    {"data":"col4"}
                ],

                type:'post',
                    success:function(data1){


                        console.log("mexicox 1: "+data1);
                        
                        var json = JSON.parse(data1);
                        // devuelve sin string
                        console.log("longitud arreglo x: "+json);
                        console.log("xxx: "+json[0]);

       
                    
                    }
                }
            );

    


    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>


