<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!--link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    /-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">


    </head>

  <body>

  <div class="container" style="margin-top:40px;margin-bottom:20px">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <form class="card card-sm" novalidate id="frmBuscar" name="frmBuscar">
                <div class="card-body row no-gutters align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-search h4 text-body"></i>
                    </div>
                    <!--end of col-->
                    <div class="col">
                        <input id="txtCodigoProductoBuscar" name="txtCodigoProductoBuscar"  class="form-control form-control-lg form-control-borderless" type="search" placeholder="Buscar">
                    </div>
                    <!--end of col-->
                    <div class="col-auto">
                        <button class="btn btn-lg btn-success" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div id="resultados" name="resultados" style="margin-top:2%">
    </div>
    <a class="btn btn-primary" href="../index.php" role="button" style="margin-left:50%;margin-top:2%">Regresar</a>

</div>

    
    <script>
        $(document).on('submit','#frmBuscar',function(event){
            event.preventDefault();
            var buscarCodigoProducto = document.getElementById("txtCodigoProductoBuscar").value;
            //alert("hola "+buscarCodigoProducto);
            $.ajax({
                url:"queryBuscarInventario.php",
                data:{buscarCodigoProducto:buscarCodigoProducto},
                type:'POST',
                    beforeSend: function() {
                        //$("btnVerTotalFactura").prop('disabled', true);
                    },
                    success:function(data1){

                        console.log("aquiiiii"+data1.codigoProducto);
                        var json = JSON.parse(data1);

                        console.log("data: "+data1['codigoproducto']+ "follar: "+data1 + "dddddd3333333 "+data1[0]+"----"+data1.codigoproducto);
                        
                        console.log("data: "+data1);
                        console.log("json: "+json);
                        console.log("json1: "+json[0]);
                        console.log("json2: "+json.codigoproducto);
                        //console.log("json3: "+json["codigoproducto"]);


                        /*if (data1=='-1') {
                            var targetDiv = document.getElementById('resultados');
                            targetDiv.innerHTML = "<div class='alert alert-danger' role='alert'>El codigo del producto es incorrecto o no existe.</div>";
                        }else {
                            var codigo = data1[0];

                                
                            var targetDiv = document.getElementById('resultados');
                            //targetDiv.innerHTML = "<h4>Codigo:</h4> "+codigo + " <h4>Disponible en bodega:</h4> "+cantidadActual + " <h4>Costo actual:</h4> "+costoActual;
                            targetDiv.innerHTML = "<h4>Codigo:</h4> "+codigo;

                        }*/



                       
                    }
                }
            );
        });
</script>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


  </body>
</html>
