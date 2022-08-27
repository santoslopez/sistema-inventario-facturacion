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
    <title>La Cadena</title>
    <!-- ======= Styles ====== -->

    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">
    <link rel="stylesheet" href="../assets/css/zoomImagen.css">

    
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>
    <script src="../assets/js/mensajesPersonalizados.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.dataTables.js"></script>

<script src="../assets/js/eventosAjax.js"></script>
  </head>

  <body>
    <div class="wrapper" >
      <nav class="navBarra">
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
            >
            <!--img src="../assets/img/menu/home-button.png" alt="Acerca" class="zoomImagen"-->
            <img src="../assets/img/menu/shopping-cart.png" alt="Ventas" class="zoomImagen">

              <!--svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  fill="#6563ff"
                  d="M20,8h0L14,2.74a3,3,0,0,0-4,0L4,8a3,3,0,0,0-1,2.26V19a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V10.25A3,3,0,0,0,20,8ZM14,20H10V15a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H16V15a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v5H6a1,1,0,0,1-1-1V10.25a1,1,0,0,1,.34-.75l6-5.25a1,1,0,0,1,1.32,0l6,5.25a1,1,0,0,1,.34.75Z"
                />
              </svg-->
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

            >
              <!--svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  fill="#6563ff"
                  d="M20,8h0L14,2.74a3,3,0,0,0-4,0L4,8a3,3,0,0,0-1,2.26V19a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V10.25A3,3,0,0,0,20,8ZM14,20H10V15a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H16V15a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v5H6a1,1,0,0,1-1-1V10.25a1,1,0,0,1,.34-.75l6-5.25a1,1,0,0,1,1.32,0l6,5.25a1,1,0,0,1,.34.75Z"
                />
              </svg-->
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
            >
              <img src="../assets/img/menu/inventory.png" alt="Inventario" class="zoomImagen">

              <!--svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z"
                />
              </svg-->
            </a>
          </li>
          <!--li class="nav__item">            
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Informational messages"
              id="submodulos-tab" data-bs-toggle="tab" 
              data-bs-target="#submodulos" 
              role="tab" 
              aria-controls="profile" 
              aria-selected="false"
              >
              <img src="../assets/img/menu/delivery.png" alt="Inventario" class="zoomImagen">
              <svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M12,11a1,1,0,0,0-1,1v3a1,1,0,0,0,2,0V12A1,1,0,0,0,12,11Zm0-3a1,1,0,1,0,1,1A1,1,0,0,0,12,8Zm0-6A10,10,0,0,0,2,12a9.89,9.89,0,0,0,2.26,6.33l-2,2a1,1,0,0,0-.21,1.09A1,1,0,0,0,3,22h9A10,10,0,0,0,12,2Zm0,18H5.41l.93-.93a1,1,0,0,0,.3-.71,1,1,0,0,0-.3-.7A8,8,0,1,1,12,20Z"
                />
              </svg>
            </a>
          </li-->

          <!--li class="nav__item">
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Collections"


              id="lecciones-tab" data-bs-toggle="tab" 
              data-bs-target="#lecciones" 
               
              role="tab" 
              aria-controls="profile" 
              aria-selected="false"
            >
            <img src="../assets/img/menu/shopping-cart.png" alt="Ventas" class="zoomImagen">

              <svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M2.5,10.56l9,5.2a1,1,0,0,0,1,0l9-5.2a1,1,0,0,0,0-1.73l-9-5.2a1,1,0,0,0-1,0l-9,5.2a1,1,0,0,0,0,1.73ZM12,5.65l7,4-7,4.05L5,9.69Zm8.5,7.79L12,18.35,3.5,13.44a1,1,0,0,0-1.37.36,1,1,0,0,0,.37,1.37l9,5.2a1,1,0,0,0,1,0l9-5.2a1,1,0,0,0,.37-1.37A1,1,0,0,0,20.5,13.44Z"
                />
              </svg>
            </a>
          </li-->
          <!--li class="nav__item">
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Analytics"

              id="juego-tab" data-bs-toggle="tab" 
              data-bs-target="#juego" 
               
              role="tab" 
              aria-controls="profile" 
              aria-selected="false"
            >
            <img src="../assets/img/menu/drill.png" alt="Productos" class="zoomImagen">

              <svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M6,13H2a1,1,0,0,0-1,1v8a1,1,0,0,0,1,1H6a1,1,0,0,0,1-1V14A1,1,0,0,0,6,13ZM5,21H3V15H5ZM22,9H18a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V10A1,1,0,0,0,22,9ZM21,21H19V11h2ZM14,1H10A1,1,0,0,0,9,2V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V2A1,1,0,0,0,14,1ZM13,21H11V3h2Z"
                />
              </svg>
            </a>
          </li-->


          <li class="nav__item">
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
            >
            <img src="../assets/img/menu/office-building.png" alt="Empresa" class="zoomImagen">

              <!--svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M6,13H2a1,1,0,0,0-1,1v8a1,1,0,0,0,1,1H6a1,1,0,0,0,1-1V14A1,1,0,0,0,6,13ZM5,21H3V15H5ZM22,9H18a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V10A1,1,0,0,0,22,9ZM21,21H19V11h2ZM14,1H10A1,1,0,0,0,9,2V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V2A1,1,0,0,0,14,1ZM13,21H11V3h2Z"
                />
              </svg-->
            </a>
          </li>


          <!--li class="nav__item">
            <a
              href="#"
              class="nav__link focus--box-shadow"
              role="menuitem"
              aria-label="Usuarios"

              id="usuariosRegistrados-tab" data-bs-toggle="tab" 
              data-bs-target="#usuariosRegistrados" 
               
              role="tab" 
              aria-controls="profile" 
              aria-selected="false"
            >
            <img src="../img/dashboardAdmin/profile-user.png" alt="Usuarios registrados" class="zoomImagen">

              <svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M6,13H2a1,1,0,0,0-1,1v8a1,1,0,0,0,1,1H6a1,1,0,0,0,1-1V14A1,1,0,0,0,6,13ZM5,21H3V15H5ZM22,9H18a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V10A1,1,0,0,0,22,9ZM21,21H19V11h2ZM14,1H10A1,1,0,0,0,9,2V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V2A1,1,0,0,0,14,1ZM13,21H11V3h2Z"
                />
              </svg>
            </a>
          </li-->

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
            >
              <svg
                class="nav__icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M6,13H2a1,1,0,0,0-1,1v8a1,1,0,0,0,1,1H6a1,1,0,0,0,1-1V14A1,1,0,0,0,6,13ZM5,21H3V15H5ZM22,9H18a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V10A1,1,0,0,0,22,9ZM21,21H19V11h2ZM14,1H10A1,1,0,0,0,9,2V22a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V2A1,1,0,0,0,14,1ZM13,21H11V3h2Z"
                />
              </svg>
            </a>
          </li-->

        </ul>
      </nav>
      <main class="main">
      <!--header class="header" style="background:crimson;">
          <div class="header__wrapper">
            <form action="" class="search">
              <button class="search__button focus--box-shadow" type="submit">
                <svg
                  class="search__icon"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"
                  />
                </svg>
              </button>
              <input
                class="search__input focus--box-shadow"
                type="text"
                placeholder="Project search"
              />
            </form>
            <div class="profile">
              <button class="profile__button">
                <span class="profile__name">Jessica</span>
                <img
                  class="profile__img"
                  src="./img/seth-doyle-uJ8LNVCBjFQ-unsplash.jpg"
                  alt="Profile picture"
                  loading="lazy"
                />
              </button>
            </div>
          </div>
        </header-->
        <div class="tab-content" id="myTabContent" style="margin-top:20px;">

          <div class="tab-pane fade show active" id="acerca" role="tabpanel" aria-labelledby="acerca-tab">
            
            <div class="alert alert-primary" role="alert">
              <h3>Crear venta de hoy</h3>
            </div>
            <?php
              $user = $_SESSION["nombreUsuario"];
                echo "<h5 style='margin-left:10px;'>Bienvenido: $user</h5>";
            ?>
            
            <!-- INICIO DIV DE COMPRAS-->
            <div class="row">
              
              <div class="col-sm-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">
                      <?php
                        date_default_timezone_set('America/Guatemala');    
                        $fechaActual = date('d-m-Y',time());
                        echo "Ventas de $fechaActual";
                      ?>
                    </h5>
                    <p class="card-text">Mis ventas</p>
                    <a style="cursor: pointer;" class="btn btn-primary" href="../ventas/queryFacturaVentas.php">
                      <img src="../assets/img/shopping-cart.png" class="zoomImagen home">
                    </a>
                  </div>
                </div>
              </div>


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
                    <a style="cursor: pointer;" class="btn btn-primary" href="../resumenventas/queryTablaVentasHoy.php">
                      <img src="../assets/img/bar-graph.png" class="zoomImagen home">
                    </a>
                  </div>
                </div>
              </div>
              
              <div class="col-sm-6" style="margin-top:5%">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text">Listado de clientes.</p>
                    <a style="cursor: pointer;" class="btn btn-primary" href="../clientes/queryListadoClientes.php">
                      <img src="../assets/img/clientes.webp" class="zoomImagen home">                       
                    </a>
                  </div>
                </div>
              </div>
</div>
          </div>
<!--FIN DIV DE COMPRAS-->

          <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
          
            <div class="alert alert-primary" role="alert">
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
        <a style="cursor: pointer;" class="btn btn-primary" href="../compras/listadoProductosCompra.php">
        <img src="../assets/img/delivery-truck-2.png" class="zoomImagen home">

      </a>

      </div>
    </div>
  </div>';
}?>
<hr>
<div class="col-sm-6" >
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Listado de compras</h5>
        <p class="card-text">Factura de compras y reportes.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../compras/queryFacturaCompras.php">
          <img src="../assets/img/health-check.png" class="zoomImagen home">                       
        </a>
      </div>

    </div>
  </div>



  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Proveedores</h5>
        <p class="card-text">Listado de proveedores.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../proveedor/queryListadosProveedor.php">
          <img src="../assets/img/shopping-mall.webp" class="zoomImagen home">                       
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
            
            <div class="alert alert-primary" role="alert">
              <h3>Productos</h3>
            </div>

                        <!-- INICIO DIV DE COMPRAS-->
                        <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Mis productos</h5>
        <p class="card-text">Registrar productos</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../productos/queryListadoProductos.php">
        <img src="../assets/img/index/air-compressor.png" class="zoomImagen home">

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
        <img src="../assets/img/index/inventory-2.png" class="zoomImagen home">                       

      </a>
      </div>
    </div>
  </div>
</div>
<!-- FIN DIV DE COMPRAS-->
            

          </div>
          <!--div class="tab-pane fade" id="submodulos" role="tabpanel" aria-labelledby="submodulos-tab">
            
            <div class="alert alert-primary" role="alert">
              <h2>Envios por transporte</h2>
            </div>
            No disponible.

         

          </div-->


          <!--div class="tab-pane fade" id="lecciones" role="tabpanel" aria-labelledby="lecciones-tab">
            
            <div class="alert alert-primary" role="alert">
              <h2>Pendiente opcion</h2>
            </div>
            
          
            ddf
          </div-->

          <!--div class="tab-pane fade" id="juego" role="tabpanel" aria-labelledby="juego-tab">
            
            <div class="alert alert-primary" role="alert">
              <h2>Listado de juego</h2>
            </div>
           
            Listado contenido juego 
          </div-->

          <div class="tab-pane fade" id="contenidosAprobados" role="tabpanel" aria-labelledby="contenidosAprobados-tab">
            
            <div class="alert alert-primary" role="alert">
              <h2>Mi empresa</h2>
            </div>

            <!-- INICIO DIV DE COMPRAS-->
            <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Mis empresa</h5>
        <p class="card-text">Mi empresa</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../empresa/queryListadoEmpresa.php">
        <img src="../assets/img/shopping-mall.webp" class="zoomImagen home">

      </a>

      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Empleados</h5>
        <p class="card-text">Listado de empleados.</p>
        <a style="cursor: pointer;" class="btn btn-primary" href="../usuarios/queryUsuariosRegistrados.php">
        <img src="../assets/img/index/add-user.png" class="zoomImagen home">                       

      </a>
      </div>
    </div>
  </div>
</div>


            <!--?php
              require_once("../contenidoJuego/listadoContenidoAprobados.php");
            ?-->
            
          </div>


          <!--div class="tab-pane fade" id="usuariosRegistrados" role="tabpanel" aria-labelledby="usuariosRegistrados-tab">
            
            <div class="alert alert-primary" role="alert">
              <h2>Usuarios registrados</h2>
            </div>
          
          </div-->
    
        </div>

      
        <!--section class="section">
          <header class="section__header">
            <h2 class="section__title">Teams</h2>
            <a href="#" class="section__link">View all</a>
          </header>
          <ul class="team">
            <li class="team__item">
              <a class="team__link focus--box-shadow" href="#">
                <div class="team__header">
                  <ul class="photo">
                    <li class="photo__item">
                      <span class="photo__substrate">+2</span>
                    </li>
                    <li class="photo__item">
                      <img
                        src="./img/julian-wan-WNoLnJo7tS8-unsplash.jpg"
                        alt="Jack's photo"
                      />
                    </li>
                    <li class="photo__item">
                      <img
                        src="./img/seth-doyle-uJ8LNVCBjFQ-unsplash.jpg"
                        alt="Jessica's photo"
                      />
                    </li>
                  </ul>
                  <button
                    class="setting setting--absolute focus--box-shadow"
                    type="button"
                  >
                    <svg
                      enable-background="new 0 0 515.555 515.555"
                      height="512"
                      viewBox="0 0 515.555 515.555"
                      width="512"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="m303.347 18.875c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                      <path
                        d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                      <path
                        d="m303.347 405.541c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                    </svg>
                  </button>
                </div>
                <div class="team__inform">
                  <p class="team__name">Product presentation</p>
                  <time class="date" datetime="2020-05-05T10:00:00"
                    >05 May, 2020</time
                  >
                </div>
              </a>
            </li>
            <li class="team__item">
              <a class="team__link focus--box-shadow" href="#">
                <div class="team__header">
                  <ul class="photo">
                    <li class="photo__item">
                      <span class="photo__substrate">+6</span>
                    </li>
                    <li class="photo__item">
                      <img
                        src="./img/raychan-9UkAHVs5y7Y-unsplash.jpg"
                        alt="Yulia's photo"
                      />
                    </li>
                    <li class="photo__item">
                      <img
                        src="./img/seth-doyle-uJ8LNVCBjFQ-unsplash.jpg"
                        alt="Jessica's photo"
                      />
                    </li>
                  </ul>
                  <button
                    class="setting setting--absolute focus--box-shadow"
                    type="button"
                  >
                    <svg
                      enable-background="new 0 0 515.555 515.555"
                      height="512"
                      viewBox="0 0 515.555 515.555"
                      width="512"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="m303.347 18.875c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                      <path
                        d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                      <path
                        d="m303.347 405.541c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                    </svg>
                  </button>
                </div>
                <div class="team__inform">
                  <p class="team__name">New project</p>
                  <time class="date" datetime="2020-05-01T10:00:00"
                    >01 May, 2020</time
                  >
                </div>
              </a>
            </li>
            <li class="team__item">
              <a class="team__link focus--box-shadow" href="#">
                <div class="team__header">
                  <ul class="photo">
                    <li class="photo__item">
                      <img
                        src="./img/seth-doyle-uJ8LNVCBjFQ-unsplash.jpg"
                        alt="Jessica's photo"
                      />
                    </li>
                  </ul>
                  <button
                    class="setting setting--absolute focus--box-shadow"
                    type="button"
                  >
                    <svg
                      enable-background="new 0 0 515.555 515.555"
                      height="512"
                      viewBox="0 0 515.555 515.555"
                      width="512"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="m303.347 18.875c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                      <path
                        d="m303.347 212.209c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                      <path
                        d="m303.347 405.541c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138c25.166-25.167 65.97-25.167 91.138 0"
                      />
                    </svg>
                  </button>
                </div>
                <div class="team__inform">
                  <p class="team__name">Design development</p>
                  <time class="date" datetime="2020-01-10T10:00:00"
                    >10 January, 2020</time
                  >
                </div>
              </a>
            </li>
          </ul>
        </section-->
       
      </main>
      <aside class="aside" style="background:#F6F4F7">
        <section class="section">
          <div class="aside__control">
            <button
              class="aside__button focus--box-shadow"
              type="button"
              aria-label="Guatemala"
            >
            <img src="../img/dashboardAdmin/guatemala.png" class="zoomImagen" alt="Guatemala" style="width: 40px;heigth: 40px;">

              <!--svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                


F4F5F7

                DEE5EF
                role="presentation"
              >
                <path
                  d="M17,11H9.41l3.3-3.29a1,1,0,1,0-1.42-1.42l-5,5a1,1,0,0,0-.21.33,1,1,0,0,0,0,.76,1,1,0,0,0,.21.33l5,5a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L9.41,13H17a1,1,0,0,0,0-2Z"
                />
              </svg-->
            </button>
            <button
              class="aside__button aside__button--notification focus--box-shadow"
              type="button"
              aria-label="Quetzal"
            >
            <img src="../img/dashboardAdmin/resplendent-quetzal.png" class="zoomImagen" alt="Quetzal" style="width: 40px;heigth: 40px;">

              <!--svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                role="presentation"
              >
                <path
                  d="M18,13.18V10a6,6,0,0,0-5-5.91V3a1,1,0,0,0-2,0V4.09A6,6,0,0,0,6,10v3.18A3,3,0,0,0,4,16v2a1,1,0,0,0,1,1H8.14a4,4,0,0,0,7.72,0H19a1,1,0,0,0,1-1V16A3,3,0,0,0,18,13.18ZM8,10a4,4,0,0,1,8,0v3H8Zm4,10a2,2,0,0,1-1.72-1h3.44A2,2,0,0,1,12,20Zm6-3H6V16a1,1,0,0,1,1-1H17a1,1,0,0,1,1,1Z"
                />
              </svg-->
            </button>
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
            <h1 class="profile-main__name">FerreIndustrias Lopez</h1>
            <h2 style="background:white">
              <a class="btn btn-primary" href="logout.php" role="button">Cerrar sesion</a>              
            </h2>
          </div>
          <!--ul class="statistics">
            <li class="statistics__entry">
              <a class="statistics__entry-description" href="#">Teams</a
              ><span class="statistics__entry-quantity">5</span>
            </li>
            <li class="statistics__entry">
              <a class="statistics__entry-description" href="#">Projects</a
              ><span class="statistics__entry-quantity">3</span>
            </li>
            <li class="statistics__entry">
              <a class="statistics__entry-description" href="#">Feedback</a
              ><span class="statistics__entry-quantity">48</span>
            </li>
          </ul-->
          <!--div class="banner">
            <h3 class="banner__title">Premium access</h3>
            <p class="banner__description">Create teams without limits</p>
            <button class="banner__button" type="button">
              Get Premium Access
            </button>
          </div-->
        </section>
      </aside>
    </div>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

  <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.dataTables.js"></script>
 

  </body>
</html>


