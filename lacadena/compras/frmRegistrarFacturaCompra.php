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
    <title>Registrar factura compra</title>
	<!-- Bootstrap 5 CDN Link -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">

	<!-- Custom CSS Link -->
	<link rel="stylesheet" href="../assets/css/login.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        label {
            display: block;
            font: 1rem 'Fira Sans', sans-serif;
        }
        input, label {
            margin: .4rem 0;
        }
    </style>
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
					  <img src="../assets/img/facturaCompra.webp" class="img-fluid imagenCircular" alt="Logo">
				  </div>
				<form class="rounded bg-white shadow py-5 px-4 needs-validation" novalidate autocomplete="off" id="frmRegistrarFacturaCompra" name="frmRegistrarFacturaCompra" action="queryRegistrarFacturaCompra.php" method="POST">
					<h3 class="text-dark fw-bolder fs-4 mb-2">Registrar factura de compra</h3>
          
					<!--div class="fw-normal text-muted mb-4"> 
						<a href="#" class="text-primary fw-bold text-decoration-none">Crear cuenta</a>
					</div-->
					<div class="form-floating mb-3">
						<input type="text" class="form-control" id="inputNumeroFacturaProveedor" name="inputNumeroFacturaProveedor" placeholder="Numero factura de proveedor" required>
						<label for="floatingInput">Numero factura proveedor</label>
                        <div class="invalid-feedback">
                            Ingresa el numero de factura de proveedor
                        </div>
					</div>

					<div class="mb-3">
                        <label for="floatingInput">Fecha factura proveedor</label>
                        <input type="text" id="inputFechaFacturaProveedor" name="inputFechaFacturaProveedor" name="trip-start" 
                            value="<?php
                            date_default_timezone_set('America/Guatemala');    
                            $fechaActual = date('d-m-Y',time());
                            echo "$fechaActual";
                        ?>" min="2018-01-01" max="2018-12-31">
					</div>  

					<div class="mb-3">
						<!--input type="text" class="form-control" id="inputDescripcionProducto" name="inputDescripcionProducto" placeholder="Nombre de producto" required-->
						<label for="floatingInput">Proveedor</label>
                         <?php
                         include '../conexion.php';
                         include "../datos/funcionesDatos.php";
                         datosCombobox("selectNitProveedor",$conexion,"SELECT nitProveedor,nombreEmpresa FROM Proveedor");
                         ?>
					</div>                    

					<button type="submit" class="btn btn-primary submit_btn w-100 my-4">Registrar producto</button>
					<div class="mt-2 text-end">
						<a href="../index" class="btn btn-success fw-bold text-decoration-none">Menu principal</a>
					</div>
				</form>
			</div>
		</div>
	</section>
  
	<script>
    $(document).on('submit','#frmRegistrarFacturaCompra',function(event){
        event.preventDefault();
        var inputNumeroFacturaProveedor=$('#inputNumeroFacturaProveedor').val();
        var inputFechaFacturaProveedor=$('#inputFechaFacturaProveedor').val();
        var selectNitProveedor=$('#selectNitProveedor').val();

        if((inputNumeroFacturaProveedor!='') && (inputFechaFacturaProveedor!='')){
            $.ajax({
                url:"queryRegistrarFacturaCompra.php",
                data:{inputNumeroFacturaProveedor:inputNumeroFacturaProveedor,inputFechaFacturaProveedor:inputFechaFacturaProveedor,selectNitProveedor:selectNitProveedor},
                type:'post',
                    success:function(data1){
                        var json = JSON.parse(data1);
                     
                        var status = json.status;
                        
						//si en el select se comprobo que el producto ya existe no se guarda en la bd

						if(status=='yaexistenoguardado'){
                            Swal.fire(
                                'Factura de proveedor',
                                'El numero de factura ya existe. No se puede repetir, no se guardo.',
                                'info'
                            )
						}else if(status=='success'){
                            $('#frmRegistrarFacturaCompra').modal('hide');
                            Swal.fire(
                                'Factura guardado',
                                'La factura se guardo correctamente.',
                                'success'
                            )
							window.location.href="queryFacturaCompras.php";
                            $('#inputNumeroFacturaProveedor').val('');
                            $('#inputFechaFacturaProveedor').val('');
                            //$('#selectNitProveedor').val('');
							//header('Location: ../admin/index.php');
                        }else{
							Swal.fire(
                                'Factura no guardado',
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
