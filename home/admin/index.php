<?php
  
  session_start();
  //Sino hemos iniciado sesion indicamos la ruta por defecto

  if (!isset($_SESSION['rolUsuario'])) {
    //header('location: admin/index.php');
    # code...
    /*switch ($_SESSION) {
        case 'value':
            # code...
            case 1:
                header('location:../admin/index.php');
            break;
        
        default:
            # code...
            break;
    }*/
  //}else  {
    header('location: ../index.php');
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>

  <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--title>Listado lenguas</title-->
  <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css"/>
    <title>Home</title>
    <!-- ======= Styles ====== -->

    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">
    <link rel="stylesheet" href="../assets/css/zoomImagen.css">

    
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>
    <script src="../assets/js/mensajesPersonalizados.js" type="text/javascript"></script>
    <script src="../assets/js/jquery/3.6.1.min.js"></script>

  <script src="../assets/js/datatables.min.js"></script>

<script src="../assets/js/buttons.dataTables.js"></script>

<script src="../assets/js/eventosAjax.js"></script>

<style>
  .bloqueado{
    filter: opacity(0.2) drop-shadow(0 0 0 black);
}

</style>

  </head>

  <body>
    <div class="wrapper" >
      <nav class="navBarra" >
      <ul class="nav nav__list " id="myTab" role="menubar" >
          <li class="nav__item nav__item--isActive">
            <a
              href="#"
              class="nav__link focus--box-shadow active"
              role="menuitem"
              aria-label="Acerca"
      
              id="acerca-tab" 
              data-bs-toggle="tab" 
              data-bs-target="#acerca" 
             
              role="tab" 
              aria-controls="acerca" 
              aria-selected="true"
              style="background:#AAD8FF"

              data-toggle="tooltip" data-placement="right" title="Realizar ventas"
            >
          
            <img src="../assets/img/menu/shopping-cart.png" alt="Ventas" class="zoomImagen">

             
            </a>
          </li>

          <li class="nav-item nav__item" role="presentation">
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Home"
      
              id="home-tab" 
              data-bs-toggle="tab" 
              data-bs-target="#home" 
             
              role="tab" 
              aria-controls="home" 
              aria-selected="false"
              data-toggle="tooltip" data-placement="right" title="Mis compras a empresas"
            >
            
              <img src="../assets/img/menu/delivery-truck.png" alt="Acerca" class="zoomImagen">

            </a>
          </li>
          <li class="nav-item nav__item" role="presentation">
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Favorite projects"


              id="modulos-tab" data-bs-toggle="tab" 
              data-bs-target="#modulos" 
               
              role="tab" 
              aria-controls="profile" 
              aria-selected="false"
               data-toggle="tooltip" data-placement="right" title="Mis productos"
            >
              <img src="../assets/img/menu/inventory.png" alt="Inventario" class="zoomImagen">

            
            </a>
          </li>


          <!--li class="nav__item">
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Analytics"

              id="contenidosAprobados-tab" data-bs-toggle="tab" 
              data-bs-target="#contenidosAprobados" 
               
              role="tab" 
              aria-controls="profile" 
              aria-selected="false"
              data-toggle="tooltip" data-placement="right" title="Mi empresa"
            >
            <img src="../assets/img/menu/office-building.png" alt="Empresa" class="zoomImagen">

            
            </a>
          </li-->


          <li class="nav__item">
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Analytics"

              id="cs-tab" data-bs-toggle="tab" 
              data-bs-target="#cs" 
               
              role="tab" 
              aria-controls="profile" 
              aria-selected="false"
               data-toggle="tooltip" data-placement="right" title="Mi perfil"
            >
            <img src="../assets/img/mechanic.png" alt="Centros de servicio" class="zoomImagen" title="Centros de servicio">

 
            </a>
          </li>

        </ul>
      </nav>
      <main class="main" >
        <noscript>
        <div class="alert alert-danger">
          Necesitas habilitar JavaScript en tu navegador para que el sitio funciona correctamente.
        </div>
        </noscript>
        <div class="tab-content" id="myTabContent" style="margin-top:20px;">

          <div class="tab-pane fade show active" id="acerca" role="tabpanel" aria-labelledby="acerca-tab">
            
            <div class="alert alert-success" role="alert">
              <h3>Crear venta de hoy</h3>
            </div>
            <?php
              $user = $_SESSION["nombreUsuario"];
                echo "<h5 style='margin-left:10px;'>Bienvenido: $user</h5>";
            ?>
            
            <!-- INICIO DIV DE COMPRAS-->
            <div class="row">
              
            <?php 
    include '../conexion.php';

    $listadoTiposEventoUsuario = "SELECT * FROM Proveedor";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    //$data = array();

    if (pg_num_rows($ejecutarConsultaObtenerInfo)==0) {
      echo '<div class="col-sm-6">
      <div class="card">
        <div class="card-body">
        <h6 class="card-title" style="color:red">No hay proveedores registrados.</h6>
        <p class="card-text">Ingresa primero los proveedores</p>
        <a href="#" style="cursor: pointer;" class="btn">
        <img src="../assets/img/delivery-truck.png" class="zoomImagen home bloqueado"  alt="Realizar compras a proveedor" title="Realizar compras a proveedor">
        </a>


    </div></div></div>';
    }else{    
  echo '<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Realizar ventas</h5>
        
        <p class="card-text">Crear ventas del día</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../ventas/index.php">
        <img src="../assets/img/shopping-cart.png" class="zoomImagen home"  alt="Crear ventas" title="Crear ventas">

      </a>

      </div>
    </div>
  </div>';
}?>

              <!--div class="col-sm-6">
                <div class="card">
                  <div class="card-body">
                    
                    <p class="card-text">Mis ventas</p>
                    
                    
                    <a style="cursor: pointer;" class="btn btn-primary" href="../ventas/index.php">
                      <img src="../assets/img/shopping-cart.png" class="zoomImagen home"  alt="Crear ventas" title="Crear ventas">
                    </a>


                    
                  </div>
                </div>
              </div-->


              <div class="col-sm-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">
                      <?php
                        date_default_timezone_set('America/Guatemala');    
                        $fechaActual = date('d-m-Y',time());
                        echo "Resumen de hoy $fechaActual";
                      ?>
                    </h5>
                    <p class="card-text">Resumen de hoy</p>
                    <a style="cursor: pointer;" class="btn btn-primary" href="../resumenventas/index.php">
                      <img src="../assets/img/bar-graph.png" class="zoomImagen home"  alt="Mis ventas de hoy" title="Mis ventas de hoy">
                    </a>
                  </div>
                </div>
              </div>
              
              <div class="col-sm-6" style="margin-top:5%">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text">Listado de clientes.</p>
                    <a style="cursor: pointer;" class="btn btn-primary" href="../clientes/index.php">
                      <img src="../assets/img/clientes.webp" class="zoomImagen home"  alt="Mis clientes" title="Mis clientes">                       
                    </a>
                  </div>
                </div>
              </div>
</div>
          </div>
<!--FIN DIV DE COMPRAS-->

          <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
          
            <div class="alert alert-success" role="alert">
              <h3>Mis compras</h3>
            </div>
            <!-- INICIO DIV DE COMPRAS-->
            <div class="row">
            <?php 
    include '../conexion.php';

    $listadoTiposEventoUsuario = "SELECT * FROM Proveedor";
    $ejecutarConsultaObtenerInfo = pg_query($conexion,$listadoTiposEventoUsuario);
    //$data = array();

    if (pg_num_rows($ejecutarConsultaObtenerInfo)==0) {
      echo '<div class="alert alert-danger" role="alert">
        No hay proveedores registrados. Ingrese un proveedor.
    </div>';
    }else{    
  echo '<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Realizar compras</h5>
        <p class="card-text">Generar factura de compras</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../compras/index.php">
        <img src="../assets/img/delivery-truck.png" class="zoomImagen home"  alt="Realizar compras a proveedor" title="Realizar compras a proveedor">

      </a>

      </div>
    </div>
  </div>';
}?>
  <!--div class="col-sm-6" >
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Listado de compras</h5>
        <p class="card-text">Factura de compras y reportes.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../compras/queryFacturaCompras.php">
          <img src="../assets/img/health-check.png" class="zoomImagen home" alt="Listado de compras a proveedor" title="Listado de compras a proveedor">                       
        </a>
      </div>

    </div>
  </div-->



  <div class="col-sm-6" >
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Proveedores</h5>
        <p class="card-text">Listado de proveedores.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../proveedor/index.php">
          <img src="../assets/img/shopping-mall.webp" class="zoomImagen home" alt="Mis proveedores" title="Mis proveedores">                       
        </a>
      </div>

    </div>
  </div>


</div>
          </div>
<!--FIN DIV DE COMPRAS-->


            
          <!--section class="section">
          <header class="section__header">
            <h2 class="section__title">Projects</h2>
            <div class="section__control">
              <button
                class="section__button focus--box-shadow"
                type="button"
                aria-label="Filter projects"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  role="presentation"
                >
                  <path
                    d="M20,8.18V3a1,1,0,0,0-2,0V8.18a3,3,0,0,0,0,5.64V21a1,1,0,0,0,2,0V13.82a3,3,0,0,0,0-5.64ZM19,12a1,1,0,1,1,1-1A1,1,0,0,1,19,12Zm-6,2.18V3a1,1,0,0,0-2,0V14.18a3,3,0,0,0,0,5.64V21a1,1,0,0,0,2,0V19.82a3,3,0,0,0,0-5.64ZM12,18a1,1,0,1,1,1-1A1,1,0,0,1,12,18ZM6,6.18V3A1,1,0,0,0,4,3V6.18a3,3,0,0,0,0,5.64V21a1,1,0,0,0,2,0V11.82A3,3,0,0,0,6,6.18ZM5,10A1,1,0,1,1,6,9,1,1,0,0,1,5,10Z"
                  />
                </svg>
              </button>
              <button
                class="section__button section__button--painted focus--box-shadow"
                type="button"
                aria-label="Add New project"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  role="presentation"
                >
                  <path
                    d="M19,11H13V5a1,1,0,0,0-2,0v6H5a1,1,0,0,0,0,2h6v6a1,1,0,0,0,2,0V13h6a1,1,0,0,0,0-2Z"
                  />
                </svg>
              </button>
            </div>

            
          </header>
       
        </section-->

          
          <div class="tab-pane fade" id="modulos" role="tabpanel" aria-labelledby="modulos-tab">
            
            <div class="alert alert-success" role="alert">
              <h3>Productos</h3>
            </div>

                        <!-- INICIO DIV DE COMPRAS-->
                        <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Mis productos</h5>
        <p class="card-text">Registrar productos</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../productos/index.php">
          <img src="../assets/img/index/air-compressor.png" class="zoomImagen home" alt="Mis productos" title="Mis productos">
        </a>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Stock de productos</h5>
        <p class="card-text">Buscar existencia de productos.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../inventario/index.php">
          <img src="../assets/img/index/inventory-2.png" class="zoomImagen home" alt="Existencia de productos" title="Existencia de productos">                       
        </a>
      </div>
    </div>
  </div>


  <div class="col-sm-6" style="margin-top:5%">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Reporte de inventario</h5>
        <p class="card-text">Imprimir reporte de inventario.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../inventario/reporteInventario.php">
          <img src="../assets/img/pdf.webp" class="zoomImagen home" alt="Reporte de inventario" title="Reporte de inventario">                       
        </a>
      </div>
    </div>
  </div>



</div>
<!-- FIN DIV DE COMPRAS-->
            

          </div>
          <!--div class="tab-pane fade" id="submodulos" role="tabpanel" aria-labelledby="submodulos-tab">
            
            <div class="alert alert-success" role="alert">
              <h2>Envios por transporte</h2>
            </div>
            No disponible.

         

          </div-->


          <!--div class="tab-pane fade" id="lecciones" role="tabpanel" aria-labelledby="lecciones-tab">
            
            <div class="alert alert-success" role="alert">
              <h2>Pendiente opcion</h2>
            </div>
            
          
            ddf
          </div-->

          <div class="tab-pane fade" id="cs" role="tabpanel" aria-labelledby="cs-tab">
            
            <div class="alert alert-success" role="alert">
              <h2>Centro de servicios</h2>
            </div>
            <?php
            include '../centro-servicios/index.php';
            ?>
           
          </div>

          <!--div class="tab-pane fade" id="contenidosAprobados" role="tabpanel" aria-labelledby="contenidosAprobados-tab">
            
            <div class="alert alert-success" role="alert">
              <h2>Mi empresa</h2>
            </div>

            <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Mis empresa</h5>
        <p class="card-text">Mi empresa</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../empresa/queryListadoEmpresa.php">
          <img src="../assets/img/shopping-mall.webp" class="zoomImagen home" alt="Mi empresa" title="Mi empresa">
        </a>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Empleados</h5>
        <p class="card-text">Listado de empleados.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../usuarios/index.php">
          <img src="../assets/img/index/add-user.png" class="zoomImagen home" alt="Empleados" title="Empleados">                       
        </a>
      </div>
    </div>
  </div>

</div>


            
          </div-->


         
    
        </div>

      
       
      </main>
     
      <aside class="aside" style="background:#AAD8FF" >
        <section class="section">
          <div class="aside__control">
            <!--button
              class="aside__button focus--box-shadow"
              type="button"
              aria-label="Guatemala"
            >
            <img src="../img/dashboardAdmin/guatemala.png" class="zoomImagen" alt="Guatemala" style="width: 40px;heigth: 40px;">

    
            </button-->
            <!--button
              class="aside__button aside__button--notification focus--box-shadow"
              type="button"
              aria-label="Quetzal"
            >
            <img src="../img/dashboardAdmin/resplendent-quetzal.png" class="zoomImagen" alt="Quetzal" style="width: 40px;heigth: 40px;">
            
            </button-->
          </div>
          <div class="profile-main">
            <button
              class="profile-main__setting focus--box-shadow"
              type="button"
            >
              <img
                class="profile-main__photo circular--square"
                src="../assets/img/logo.webp"
                alt="Profile photo"
                style="background:#5DAEFF";

              />
            </button>
            <h1 class="profile-main__name">HOME
            <img loading="lazy" src="../assets/img/verified-user.webp" alt="FerreIndustrias Lopez" title="FerreIndustrias Lopez" style="width:25px;">
            </h1>
            <!--h2 style="background:white">
                    
            </h2-->
            
            <a class="btn btn-primary" href="logout.php" role="button">Cerrar sesion</a>        
          </div>
        
          
        </section>
      </aside>
    </div>
    <script src="../assets/js/datatables.min.js"></script>

     <script src="../assets/js/buttons.dataTables.js"></script>


  </body>
</html>


