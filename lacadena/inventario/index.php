<?php
  include "../sesion/sesion.php";
  include "../config/config.php";
?>

<html lang="en">
    <head>
        <?php
            include "../includes/head.php";
        ?>

    </head>
<body>
    <div class="container">
        
        <div class="alert alert-primary" role="alert" style="margin-top:20px">
            <h2>Inventario de productos</h2>
        </div>
        <?php 
        echo '<table class="table table-striped table-bordered nowrap" id="datatableInventario" name="datatableInventario" style="width:100%">
                <thead>
                        <th>Codigo</th>
                        <th>Nombre producto</th>
                        <th>Cantidad disponible</th>
                        <th>Costo promedio actual</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a class="btn btn-primary" href="../index.php" role="button">Menu principal</a></div>';
        ?> 
    
    <script>

        
        /*** Nota importante: en data tienen que ir los valores en minuscula de la tabla que queremos mostrar sus datos
         
                echo "<td><a href=../proveedor/frmModificarProveedor?nitDatos=$row[0]&empresaDatos=".urlencode($row[1])."&direccion=".urlencode($row[3])."&telefono=".urlencode($row[4])."><img src='../assets/img/update.png' class='zoomImagen imagenTabla' alt='Actualizar contenido'></a></td>";       

        echo "<td data-label='Eliminar'><a href=../proveedor/queryEliminarProveedor.php?nitEliminarProveedor=".urlencode($row[0])." class='opcionEliminarProveedor btn'><img src='../assets/img/delete.png' class='zoomImagen imagenTabla' alt='Eliminar contenido'></a></td>";
     
        */
            $(document).ready(function(){
                $('#datatableInventario').DataTable({
                    "ajax":{
                        "url":"queryInventario.php",
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
                
            });

</script>


</body>
</html>






