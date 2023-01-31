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
    <title>Generar reporte de compras - Comprobante</title>
    <style>
input[type="submit"] {
  background-image: url("../assets/img/pdf.webp");
  background-repeat: no-repeat;
  background-size: cover;
  border: none;
  width:100px;
  height:100px;
}
</style>
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
    
    <form action="reporteTodasFacturasCompras.php" method="post">
    <h2 class="text-center">Generar reporte de compras</h2>
    <div class="d-grid gap-2 col-6 mx-auto">
    <label for="name">Fecha inicio:</label>
 
  <?php  
            date_default_timezone_set('America/Guatemala'); 
        ?>
          <input type="date" id="fechaInicio" class="form-control" name="fechaInicio" required value="<?php echo date("Y-m-d"); ?>">
  <br><br>
  </div>
  <div class="d-grid gap-2 col-6 mx-auto">
  <label for="email">Fecha fin:</label>
  <?php  
    date_default_timezone_set('America/Guatemala'); 
    ?>
    <input type="date" id="fechaFin" class="form-control" name="fechaFin" required value="<?php echo date("Y-m-d"); ?>">
 </div>
  <!--input type="email" id="email" name="email"-->
  <br><br>

  <div class="d-grid gap-2 col-6 mx-auto">
    <label for="">Generar reporte</label>
    <input type="submit" class="btn btn-primary" value="Generar">
    <a href="../index.php" class="btn btn-primary">Menu principal</a>
  </div>
</form>
</div>


<?php
 }
?>
</div>

</body>
</html>