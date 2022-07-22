<!doctype html>
<html lang="en">

<?php
    include "../includes/head.php";
?>
  <body>
    <div class="container">
        <label for="">Buscar: </label>


        <form action="" method="POST">
            <input type="text" class="form-control" placeholder="Codigo producto" id="txtCodigoProductoBuscar" name="txtCodigoProductoBuscar">

            <button class="btn btn-primary" type="submit" id="enviar" name="enviar">Actualizar total factura</button>

        </form>

        <!--?php
            include "../conexion.php";

            if (isset($_GET["enviar"])) {
                # code...
                $buscar = $_GET["txtCodigoProductoBuscar"];

                $consultaTotalFacturaCompra = "SELECT codigoProducto,cantidadComprado, costoActual from Inventario WHERE codigoProducto='$buscar';";
                $ejecutarConsultaObtenerInfo  = pg_query($conexion,$consultaTotalFacturaCompra);
            
                $data = array();
                while ($row= pg_fetch_row($ejecutarConsultaObtenerInfo)) {
                    $subarray=array();
                    //$subarray[]=$row[0];     
                    //$subarray[]=$row[1];
                    //$subarray[]=$row[2];          
                    //$data[]=$subarray;       
                    echo "xxx encontrado: $row[0]";                
                }          
            }
        ?-->
        <section id="resultados2" name="resultados2"></section>

    </div>
    

    <script>
        buscar();
    function buscar(){ 
            var buscarCodigoProducto = document.getElementById("txtCodigoProductoBuscar").value;
            alert("hola "+buscarCodigoProducto);
            $.ajax({
                url:"queryBuscarInventario.php",
                data:{buscarCodigoProducto:buscarCodigoProducto},
                type:'POST',
                    beforeSend: function() {
                        //$("btnVerTotalFactura").prop('disabled', true);
                    },
                    success:function(data1){
                        var json = JSON.parse(data1);
                       
                        var totalFactura = json[0];
                        alert("FOLLAxxxx "+data1 + "sssss "+totalFactura);
                        //document.getElementById("resultados2").value = totalFactura;
                        var targetDiv = document.getElementById('resultados2');
                        targetDiv.innerHTML = totalFactura;
                    }
                }
            );
        };
</script>

<script>
           var btnTotalFac = document.getElementById("enviar");
                            btnTotalFac.addEventListener('click', buscar());
</script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


  </body>
</html>
