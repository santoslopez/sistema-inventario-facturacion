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
    <title>Crear cuenta usuario</title>
	<!-- Bootstrap 5 CDN Link -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">

	<!-- Custom CSS Link -->
	<link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <section class="wrapper">
		<div class="container">
			<div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center">
			  <div class="logo">
					  <img src="../assets/img/user.png" class="img-fluid imagenCircular" alt="Logo">
				  </div>
				<form class="rounded bg-white shadow py-5 px-4 needs-validation" novalidate action="queryRegistrarUsuarios.php" autocomplete="off" method="POST">
					<h3 class="text-dark fw-bolder fs-4 mb-2">Registrar usuario</h3>
					<div class="form-floating mb-3">
						<input type="email" class="form-control" id="inputCorreo" name="inputCorreo" placeholder="name@example.com" required maxlength="50">
						<label for="floatingInput">Correo electronico</label>
                        <div class="invalid-feedback">
                            Ingresa un correo valido.
                        </div>
					</div>

					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="inputDatos" name="inputDatos" placeholder="Nombre y apellidos" required maxlength="100">
						<label for="floatingInput">Nombre y apellidos</label>
                        <div class="invalid-feedback">
                            Ingresa tu nombre y apellidos
                        </div>
					</div>                    

					<div class="form-floating">
						<input type="password" class="form-control" pattern="[A-Za-z0-9.]+" id="inputPassword" name="inputPassword" placeholder="Password" required maxlength="255">
						<label for="floatingPassword">Password</label>
                        <div class="invalid-feedback">
                            El password puede tener letras, numeros y el signo punto.
                        </div>
					</div>

					<div class="form-floating">
						<br>
						<label for="floatingPassword">Seleccione una rol:</label>
						<!--input type="password" class="form-control" id="inputRol" name="inputRol" placeholder="Rol" required-->
						<select class="form-select" aria-label="Default select example" id="selectRol" name="selectRol">
							<option value="1" selected>Administrador</option>
							<option value="2">Cajero</option>
						</select>

					</div>					

					<button type="submit" class="btn btn-primary submit_btn w-100 my-4">Registrar usuario</button>
					<div class="mt-2 text-end">
						<a href="../index.php" class="btn btn-success fw-bold text-decoration-none">Menu principal</a>
					</div>
				</form>
			</div>
		</div>
	</section>
  
<script src="../assets/js/bootstrap5-0-2.bundle.min.js"></script>

<script src="../assets/js/validation.js"></script>

</body>
</html>
