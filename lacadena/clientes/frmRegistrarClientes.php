<?php
  
  //session_start();
  include "../sesion/sesion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar clientes</title>
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
					  <img src="../assets/img/user.png" class="img-fluid imagenCircular" alt="Logo">
				  </div>
				<form class="rounded bg-white shadow py-5 px-4 needs-validation" novalidate action="queryRegistrarClientes.php" autocomplete="off" method="POST">
					<h3 class="text-dark fw-bolder fs-4 mb-2">Registrar clientes</h3>
          
					<!--div class="fw-normal text-muted mb-4"> 
						<a href="#" class="text-primary fw-bold text-decoration-none">Crear cuenta</a>
					</div-->
                    
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="inputDatos" name="inputDatos" placeholder="Nombre y apellidos" required>
						<label for="floatingInput">Nombre y apellidos</label>
                        <div class="invalid-feedback">
                            Ingresa el nombre y apellidos
                        </div>
					</div>

                    <div class="form-floating mb-3">
						<input type="text" class="form-control" id="inputDireccion" name="inputDireccion" placeholder="Direccion" required value="ciudad">
						<label for="floatingInput">Direccion</label>
                        <div class="invalid-feedback">
                            Ingresa una direccion
                        </div>
					</div>

					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="inputNit" name="inputNit" placeholder="Nit" value="c/f" required>
						<label for="floatingInput">Nit</label>
                        <div class="invalid-feedback">
                            Ingresa el nit del cliente
                        </div>
					</div>                    

					<div class="form-floating">
						<input type="number" class="form-control"  id="inputTelefono" name="inputTelefono" placeholder="Telefono" required>
						<label for="floatingPassword">Telefono</label>
                        <div class="invalid-feedback">
                            Ingresa un telefono
                        </div>
					</div>


					<button type="submit" class="btn btn-primary submit_btn w-100 my-4">Registrar cliente</button>
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
  
<!--script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script-->
<script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>

<script src="../assets/js/validation.js"></script>

</body>
</html>