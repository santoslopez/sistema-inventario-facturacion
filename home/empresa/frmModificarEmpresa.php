<?php
  
  //session_start();
  include "../sesion/sesion.php";

  if(!(isset($_GET['inputNitEmpresa'],$_GET['inputNombreEmpresa'],$_GET['inputDireccion']))) {
	header('Location: ../index.php');
  }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar empresa</title>
	<!-- Bootstrap 5 CDN Link -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">

	<!-- Custom CSS Link -->
	<link rel="stylesheet" href="../assets/css/login.css">
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
					  <img src="../assets/img/buildings.png" class="img-fluid imagenCircular" alt="Logo">
				  </div>
				<form class="rounded bg-white shadow py-5 px-4 needs-validation" novalidate action="queryModificarEmpresa.php" autocomplete="off" method="POST">
					<h3 class="text-dark fw-bolder fs-4 mb-2">Modificar empresa</h3>
        			<div class="form-floating mb-3">
						<input type="text" class="form-control" name="inputNitEmpresa" name="inputNitEmpresa" placeholder="Nit o dpi de empresa" required value="<?=$_GET['inputNitEmpresa']?>" >
						<label for="floatingInput">Nit</label>
                        <div class="invalid-feedback">
                            Ingresa el nit de la empresa o dpi
                        </div>
					</div>       
                    
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="inputNombreEmpresa" name="inputNombreEmpresa" placeholder="Nombre de la empresa" required value="<?=$_GET['inputNombreEmpresa']?>">
						<label for="floatingInput">Nombre de empresa:</label>
                        <div class="invalid-feedback">
                            Ingresa el nombre de la empresa
                        </div>
					</div>

                    <div class="form-floating mb-3">
						<input type="text" class="form-control" id="inputDireccion" name="inputDireccion" placeholder="Direccion" required value="<?=$_GET['inputDireccion']?>">
						<label for="floatingInput">Direccion</label>
                        <div class="invalid-feedback">
                            Ingresa una direccion
                        </div>
					</div>

					<button type="submit" class="btn btn-primary submit_btn w-100 my-4">Guardar datos</button>
					<div class="mt-2 text-end">
						<a href="../index" class="btn btn-success fw-bold text-decoration-none">Menu principal</a>
					</div>
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
  
	<script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>

<script src="../assets/js/validation.js"></script>

</body>
</html>
