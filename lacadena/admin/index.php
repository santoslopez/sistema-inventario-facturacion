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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>La Cadena</title>
    <!-- ======= Styles ====== -->

    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">

    
    <link rel="stylesheet" href="../assets/css/admin.css">


</head>

    <body>
        <div class="containerPrincipal">

            <div class="navigation">
                <ul class="nav">
                    <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="logo-apple"></ion-icon>
                            </span>
                            <span class="title">LACADENA</span>
                        </a>
                    </li>
                    <li>
                        <a style="cursor: pointer;" href="../index" class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                            <span class="title">Home</span>
                        </a>
                    </li>
                    <li>
                        <a style="cursor: pointer;" class="nav-link" id="v-pills-usuarios-tab" data-bs-toggle="pill" data-bs-target="#v-pills-usuarios" role="tab" aria-controls="v-pills-usuarios" aria-selected="false">
                            <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                            <span class="title">Usuarios</span>
                        </a>
                    </li>
                    <!--li>
                        <a style="cursor: pointer;" class="nav-link" id="v-pills-clientes-tab" data-bs-toggle="pill" data-bs-target="#v-pills-clientes1" role="tab" aria-controls="v-pills-clientes1" aria-selected="false">
                            <span class="icon"><ion-icon name="people-circle"></ion-icon></span>
                            <span class="title">Clientes</span>
                        </a>
                    </li-->
                    
                    <!--li>
                        <a style="cursor: pointer;"  class="nav-link" id="v-pills-roles-tab" data-bs-toggle="pill" data-bs-target="#v-pills-roles" role="tab" aria-controls="v-pills-roles" aria-selected="false">
                            <span class="icon"><ion-icon name="shield-half-outline"></ion-icon></span>
                            <span class="title">Roles</span>
                        </a>
                    </li-->

                    <li>
                        <!--a style="cursor: pointer;" class="nav-link" id="v-pills-proveedor-tab" data-bs-toggle="pill" data-bs-target="#v-pills-proveedor" role="tab" aria-controls="v-pills-" aria-selected="false" href="../proveedor/queryListadosProveedor.php"-->
                        <a style="cursor: pointer;" class="nav-link" id="v-pills-proveedor-tab" href="../proveedor/queryListadosProveedor.php">

                            <span class="icon"><ion-icon name="storefront-outline"></ion-icon></span>
                            <span class="title">Proveedor</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" style="cursor: pointer;" class="nav-link" id="v-pills-configuracion-tab" data-bs-toggle="pill" data-bs-target="#v-pills-configuracion" role="tab" aria-controls="v-pills-" aria-selected="false">
                            <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                            <span class="title">Configuración</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                            <span class="title">Cerrar sesion</span>
                        </a>
                        
                    </li>   
                    
                    
                </ul>
            </div>

            
            <div class="main">
            
                <div class="topbar">
                     <!-- representa las barras en responsive 3 lineas-->
                    <div class="toggle">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>
                    <div class="search">
                        <label for="">
                            <input type="text" placeholder="Buscar">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </div>   
                    <div class="user">
                        <img src="../assets/img/logo.webp" alt="Logo">
                    </div> 
                </div>

                <div class="w-100">
                    <div class="tab-content" id="v-pills-tabContent">
                        <?php
                            $user = $_SESSION["nombreUsuario"];

                            echo "<h5 style='margin-left:10px;'>Bienvenido: $user</h5>";
                        ?>
                        <!-- inicio primero -->
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <!-- ======================= Cards ================== -->
                            <div class="cardBox">
                                <div class="card">
                                    <div>

                                        <div class="numbers">
                                            
                                                <!--span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                                                <span class="title">Ventas hoy</span-->
                                            
                                                        <a style="cursor: pointer;" class="nav nav-link" id="v-pills-ventasHoy-tab" data-bs-toggle="pill" data-bs-target="#v-pills-ventasHoy" role="tab" aria-controls="v-pills-ventasHoy" aria-selected="false">
                                                            Hoy
                                                        </a>
                                                
                                        </div>
                                        
                                        <div class="cardName">
                                            <?php
                                            date_default_timezone_set('America/Guatemala');    
                                            $fechaActual = date('d-m-Y',time());
                                            echo "Ventas de $fechaActual";
                                            ?>
                                        </div>
                                    </div>

                                    <div class="iconBx">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </div>
                                </div>

                                
                                <a style="cursor: pointer;" href="../compras/queryFacturaCompras.php">
                                <div class="card">    
                                <div>
                                        <!--div class="numbers">
                                            $
                                        </div-->
                                        <div class="cardName"><strong><h5>COMPRAS</strong></h5></div>
                                        <div>
                                            <span class="title">Factura de compras</span>
                                        </div>
                                    </div>
                                    <div class="iconBx">
                                        
                                            <img src="../assets/img/truck.webp" class="zoomImagen home">
                                        
                                        <!--ion-icon name="cart-outline"></ion-icon-->
                                    </div>
                                    </div>
                                    </a>
                               


                                
                                <a style="cursor: pointer;" href="#">
                                <div class="card">
                                    <div>    
                                        <div class="cardName">
                                            <h5>Inventario</h5>
                                        </div>
                                        <div>
                                            <span class="title">Inventario</span>
                                        </div>
                                    </div>

                                    <div class="iconBx">
                                        <!--ion-icon name="chatbubbles-outline"></ion-icon-->
                                        <img src="../assets/img/stocks.png" class="zoomImagen home">                       
                                    </div>
                                    </div>
                                    </a>
                                
                                    <a style="cursor: pointer;" href="#">
                                <div class="card">
                                    <div>    
                                        <div class="cardName">
                                            <h5>Envios</h5>
                                        </div>
                                        <div>
                                            <span class="title">Envios o delivery</span>
                                        </div>
                                    </div>

                                    <div class="iconBx">
                                        <!--ion-icon name="chatbubbles-outline"></ion-icon-->
                                        <img src="../assets/img/delivery-bike.png" class="zoomImagen home">                       
                                    </div>
                                    </div>
                                    </a>

                                
                                <a style="cursor: pointer;" href="../proveedor/queryListadosProveedor.php">
                                <div class="card">    
                                <div>    
                                        <div class="cardName">
                                            <h5>Proveedores</h5>
                                        </div>
                                        <div>
                                            <span class="title">Listado</span>
                                        </div>
                                    </div>

                                    <div class="iconBx">
                                        <!--ion-icon name="chatbubbles-outline"></ion-icon-->
                                        <img src="../assets/img/shopping-mall.webp" class="zoomImagen home">                       
                                    </div>
                                    </div>
                                    </a>
                                

                                <!--div class="card">
                                    <a style="cursor: pointer;" href="../clientes/queryListadoClientes.php">
                                        <div class="cardName"><h5>Clientes</h5></div>

                                        <div>
                        
                                            <span class="title">Listado</span>
                                        </div>

                                        <div class="iconBx">
                                            <img src="../assets/img/clientes.webp" class="zoomImagen home">                       
                                        </div>
                                    </a>
                                </div-->
                                <a href="#">
                                <div class="card">
                                    
                                    <div>
                                       
                                        <div class="cardName numbers"><strong><h5>VENTAS</h5></strong></div>
                                        <div>
                                            <span class="title">Vender</span>
                                        </div>
                                    </div>
                                    <div class="iconBx">
                                        
                                            <img src="../assets/img/ventas.webp" class="zoomImagen home">
                                        
                                        <!--ion-icon name="cart-outline"></ion-icon-->
                                    </div>
                                    </div>
                                    </a>
                               

                                <div class="card">
                                    <a href="../productos/queryListadoProductos.php">
                                    <div>
                                       
                                        <div class="cardName numbers"><strong><h5>Productos</h5></strong></div>
                                        <div>
                                            <span class="title">Listado productos</span>
                                        </div>
                                    </div>
                                    <div class="iconBx">
                                            <img src="../assets/img/drill.webp" class="zoomImagen home">
                                        
                                        <!--ion-icon name="cart-outline"></ion-icon-->
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- fin primero-->
                        <!--div class="tab-pane fade" id="v-pills-ventasHoy" role="tabpanel" aria-labelledby="v-pills-ventasHoy-tab" style="margin-left:7%;margin-right:7%;">
                            Ventas de hoy
                            <div class="alert alert-primary" role="alert" style="width:100%">
                                <h2>Ventas de hoy</h2>
                            </div>
                        </div-->
                        
                        <div class="tab-pane fade" id="v-pills-usuarios" role="tabpanel" aria-labelledby="v-pills-usuarios-tab" style="margin-left:7%;margin-right:7%;">          
                        
                            <!-- INICIO CODIGO PARA USUARIOS-->
                            <div class="cardBox">

                                <div class="card">
                                <a style="cursor: pointer;" href="../usuarios/queryUsuariosRegistrados.php">
                                    <div>
                                        <!--div class="numbers">
                                            $
                                        </div-->
                                        <div class="cardName"><strong><h5>Empleados</strong></h5></div>
                                        <div>
                                            <span class="title">Listado</span>
                                        </div>
                                    </div>
                                    <div class="iconBx">
                                            <img src="../assets/img/userhome.webp" class="zoomImagen home">
                                        
                                        <!--ion-icon name="cart-outline"></ion-icon-->
                                    </div>
                                    </a>
                                </div>


                                <div class="card">
                                    <a style="cursor: pointer;" href="../clientes/queryListadoClientes.php">
                                        <div class="cardName"><h5>Clientes</h5></div>

                                        <div>
                        
                                            <span class="title">Listado</span>
                                        </div>

                                        <div class="iconBx">
                                            <!--ion-icon name="people-circle-outline"></ion-icon-->
                                            <img src="../assets/img/clientes.webp" class="zoomImagen home">                       
                                        </div>
                                    </a>
                                </div>


                            </div>
                            <!-- FIN CODIGO PARA USUARIOS-->

                            <!--?php
                                require_once("../usuarios/queryUsuariosRegistrados.php");
                            ?-->    
                        </div>
                        

                        <!--div class="tab-pane fade" id="v-pills-clientes" role="tabpanel" aria-labelledby="v-pills-clientes-tab" style="margin-left:7%;margin-right:7%;">
                        
                            <div class="alert alert-primary" role="alert" style="width:100%">
                                Clientes
                            </div>
                            <a class="btn btn-success" href="../index" role="button">Menu principal</a>

                        </div-->


                        <!--div class="tab-pane fade" id="v-pills-proveedor" role="tabpanel" aria-labelledby="v-pills-proveedor-tab" style="margin-left:7%;margin-right:7%;">
                            <a href="../proveedor/queryListadosProveedor.php">Listado proveedores</a>
                        </div-->

                        <div class="tab-pane fade" id="v-pills-configuracion" role="tabpanel" aria-labelledby="v-pills-configuracion-tab" style="margin-left:7%;margin-right:7%;">
                        
                            <!--div id="ccc" class="alert alert-primary" role="alert" style="width:100%">
                                Perfil de empresa
                            </div-->
                            <?php
                                require_once("../empresa/queryListadoEmpresa.php");
                            ?> 
                        </div>
                        
                    </div>
                </div>

            </div>

        </div>


      
        <script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>

        <script src="../assets/js/admin.js"></script>

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>




    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/r-2.3.0/datatables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.dataTables.js"></script>
    
    </body>
</html>