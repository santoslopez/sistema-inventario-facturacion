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
    <title>Modificar usuario</title>
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
					  <img src="../assets/img/profile-user.png" class="img-fluid imagenCircular" alt="Logo">
				  </div>
				<form class="rounded bg-white shadow py-5 px-4 needs-validation" novalidate action="queryModificarUsuarios.php" autocomplete="off" method="POST">
					<h3 class="text-dark fw-bolder fs-4 mb-2">Modificar usuario</h3>
          
					<div class="form-floating mb-3">
						<input type="email" class="form-control" id="inputCorreo" name="inputCorreo"  value="<?=$_GET['correo']?>" placeholder="Correo" required>
						<label for="floatingInput">Correo electronico</label>
                        <div class="invalid-feedback">
                            Ingresa un correo valido.
                        </div>
					</div>

					<div class="form-floating mb-3">
						<input type="text" class="form-control" name="inputDatos" name="inputDatos"  value="<?=$_GET['datos']?>" placeholder="Nombre y apellidos" required>
						<label for="floatingInput">Nombre y apellidos</label>
                        <div class="invalid-feedback">
                            Ingresa tu nombre y apellidos
                        </div>
					</div>                    
					<label for="floatingPassword">Estado</label>
					<div class="form-floating">
						<select id="inputEstado" name="inputEstado">
							<option value="A" selected>Activo</option>
							<option value="I">Inactivo</option>
						</select>
                        <div class="invalid-feedback">
                            El estado es invalido.
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

          			<div class="form-floating">
						<input type="text" class="form-control" id="inputFechaRegistro" name="inputFechaRegistro" placeholder="Fecha registro"  value="<?=$_GET['fechaRegistro']?>" required readonly>
						<label for="floatingPassword">Fecha de registro</label>
					</div>
	
					<button type="submit" class="btn btn-primary submit_btn w-100 my-4">Modificar usuario</button>
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
