<?php
  
  //session_start();
  //include "../sesion/sesion.php";
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
				<form class="rounded bg-white shadow py-5 px-4 needs-validation" novalidate autocomplete="off" id="frmRegistrarProductos" name="frmRegistrarProductos">
					<h3 class="text-dark fw-bolder fs-4 mb-2">Registrar productos</h3>
          
					<!--div class="fw-normal text-muted mb-4"> 
						<a href="#" class="text-primary fw-bold text-decoration-none">Crear cuenta</a>
					</div-->
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="inputCodigoProducto" name="inputCodigoProducto" placeholder="Codigo de producto" required>
						<label for="floatingInput">Codigo</label>
                        <div class="invalid-feedback">
                            Ingresa un codigo de producto.
                        </div>
					</div>

					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="inputDescripcionProducto" name="inputDescripcionProducto" placeholder="Nombre de producto" required>
						<label for="floatingInput">Descripcion</label>
                        <div class="invalid-feedback">
                            Ingresa el nombre del producto
                        </div>
					</div>                    

					<button type="submit" class="btn btn-primary submit_btn w-100 my-4">Registrar producto</button>
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
  


	<script>
    $(document).on('submit','#frmRegistrarProductos',function(event){
        event.preventDefault();
        var inputCodigoProducto=$('#inputCodigoProducto').val();
        var inputDescripcionProducto=$('#inputDescripcionProducto').val();
        if((inputCodigoProducto!='') && (inputDescripcionProducto!='')){
            $.ajax({
                url:"queryRegistrarProductos.php",
                data:{inputCodigoProducto:inputCodigoProducto,inputDescripcionProducto:inputDescripcionProducto},
                type:'post',
                    success:function(data1){
                        var json = JSON.parse(data1);
                     
                        var status = json.status;
                        
						//si en el select se comprobo que el producto ya existe no se guarda en la bd

						if(status=='yaexistenoguardado'){
                            Swal.fire(
                                'Producto no guardado',
                                'El codigo del producto ya existe. No se puede guarda el producto.',
                                'info'
                            )
						}else if(status=='success'){
                            $('#frmRegistrarProductos').modal('hide');
                            Swal.fire(
                                'Producto guardado',
                                'El producto se guardo correctamente.',
                                'success'
                            )
							window.location.href="queryListadoProductos.php";
                            $('#inputCodigoProducto').val('');
                            $('#inputDescripcionProducto').val('');
							//header('Location: ../admin/index.php');
                        }else{
							Swal.fire(
                                'Producto no guardado',
                                'Se produjo un error al querer guardar los datos.',
                                'error'
                            )
                        }
                    }
                }
            );
        }else{
			Swal.fire(
				'Mensaje de campos vacios',
                'Por favor llene todos los campos.',
                'error'
            )        
		}
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="../assets/js/sweetalert2-10.js"></script>
<script src="../assets/js/validation.js"></script>

</body>
</html>
