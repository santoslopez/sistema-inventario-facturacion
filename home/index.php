<?php
  
  session_set_cookie_params(60*60*24*1); // 1 día
  // Inicializar la sesión.
  session_start();
  //Sino hemos iniciado sesion indicamos la ruta por defecto
  //if(empty($_SESSION['nombreUsuario'])){
      // ruta por default
  //    header("Location: admin/index.php");    
  //}

  if (isset($_SESSION['rolUsuario'])) {
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
  //}else{
    header('location: admin/index.php');
  }
  
  //include "sesion/sesion.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
	<!-- Bootstrap 5 CDN Link -->
    <link rel="stylesheet" href="assets/css/bootstrap5-0-2.min.css">

	<!-- Custom CSS Link -->
	<link rel="stylesheet" href="assets/css/login.css">
	<script src="assets/js/jquery-3.6.1.min.js"></script>

</head>
<body>
 <!--div class="wrapper"> 
   <div class="container">  
     <div class="col-md-4">
       <label for="validationCustom01" class="form-label">First name</label>
       <input type="text" class="form-control" id="validationCustom01" required>
       <div class="valid-feedback">
         Looks good!
       </div>
     </div>    
  </div>
</div-->

    <section class="wrapper">
		<div class="container">
			<div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center">
			  <div class="logo">
					  <img src="assets/img/logo.webp" class="img-fluid imagenCircular" alt="Logo">
				  </div>
				<form class="rounded bg-white shadow py-5 px-4 needs-validation" novalidate id="frmLogin" name="frmLogin" autocomplete="off">
					<h3 class="text-dark fw-bolder fs-4 mb-2">INICIAR SESION</h3>
          
					<!--div class="fw-normal text-muted mb-4"> 
						<a href="usuarios/frmRegistrarUsuarios.php" class="text-primary fw-bold text-decoration-none">Crear cuenta</a>
					</div-->
					<div class="form-floating mb-3">
						<input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="name@example.com" required autocomplete="off">
						<label for="inputEmail">Correo electronico</label>
						<div class="invalid-feedback">
							Ingresa un correo valido.
						</div>
					</div>
					<div class="form-floating">
						<input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required autocomplete="off">
						<label for="inputPassword">Password</label>
						<div class="invalid-feedback">
							El password esta vacio o el formato es invalido.
						</div>
					</div>
                    <div id="mensaje">
                    </div>    
					<!--div class="mt-2 text-end">
						<a href="#" class="text-primary fw-bold text-decoration-none">Forget Password?</a>
					</div-->
					<button type="submit" id="btnIniciarSesion" name="btnIniciarSesion" class="btn btn-primary submit_btn w-100 my-4">Iniciar sesion</button>
					<!--div class="text-center text-muted text-uppercase mb-3">or</div-->
					<!--a href="#" class="btn btn-light login_with w-100 mb-3">
						<img alt="Logo" src="images/google-icon.svg" class="img-fluid me-3">Continue with Google
					</a>
					<a href="#" class="btn btn-light login_with w-100 mb-3">
						<img alt="Logo" src="images/facebook-icon.svg" class="img-fluid me-3">Continue with Facebook
					</a>
					<a href="#" class="btn btn-light login_with w-100 mb-3">
						<img alt="Logo" src="images/linkedin-icon.svg" class="img-fluid me-3">Continue with Linkedin
					</a-->
				</form>
			</div>
		</div>
	</section>
  

    
	<script>
    $(document).on('submit','#frmLogin',function(event){
        event.preventDefault();
        var nombreApellidos=$('#inputEmail').val();
        var direccion=$('#inputPassword').val();
        if((nombreApellidos!='') && (direccion!='')){
            $.ajax({
                url:"login/queryIniciarSesion.php",
                data:{nombreApellidos:nombreApellidos,direccion:direccion},
                type:'post',
                    beforeSend: function() {
                        $("#btnIniciarSesion").prop('disabled', true);
                    },
                    success:function(data1){
                        var json = JSON.parse(data1);
                        
                        var status = json;
                        
                        if(status=='success'){
   
                       
                            $('#frmLogin').modal('hide');

							window.location.href="admin/index.php";
                            $('#inputEmail').val('');
                            $('#inputPassword').val('');
                            //$("#btnIniciarSesion").prop('disabled', false);

							//header('Location: ../admin/index.php');
                        }else{
                            Swal.fire(
                                'Usuario o password incorrecto.',
                                'Los datos que ingresaste no son correctos.',
                                'warning'
                            )
                        }
                        $("#btnIniciarSesion").prop('disabled', false);
                    }
                }
            );
        }else{
            alert("please fill the required fields");
        }
    });
</script>


<script src="assets/js/bootstrap5-0-2.bundle.min.js"></script>

<!--script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script-->

<!--script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script-->  
<script src="assets/js/sweetalert2-10.js"></script>

<script src="assets/js/validation.js"></script>

</body>
</html>


