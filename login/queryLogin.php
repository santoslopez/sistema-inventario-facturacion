<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap5-0-2.min.css">

    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  

  </head>
  <body>
    <h1>Datos incorrectos</h1>

    <?php
    session_start();
    require_once("../conexion.php");

    //verificar que hay datos en el formulario
    if(!isset($_POST["inputEmail"],$_POST["inputPassword"])){

        //redirect 
        header("Location: ../index");
    }else{
        //evitar html code
        $username = htmlspecialchars($_POST["inputEmail"],ENT_QUOTES,'UTF-8');
        $pass = htmlspecialchars($_POST["inputPassword"],ENT_QUOTES,'UTF-8');

        $queryLogin = sprintf("SELECT contrasena,nombreApellidos,fechaRegistro,estado FROM Usuarios WHERE correo='%s' AND estado='A';",pg_escape_string($username));

        $fila = pg_fetch_assoc(pg_query($conexion,$queryLogin));

        if (($fila) && password_verify($pass,$fila["contrasena"])){
            //echo "sesioniniciado";
            $nombreUsuario = $_POST['inputEmail'];	
            $passwordUsuario = $_POST['inputPassword'];
            //session_start();

            // regenerar el id de sesion
            session_regenerate_id();

            $_SESSION['loggedin'] = TRUE;
            $_SESSION['nombreUsuario'] = $nombreUsuario;	
            $_SESSION['contrasena'] = $passwordUsuario;	

            header('Location: ../admin/index.php');

        } else{
            echo "<script>Swal.fire(
                'Login',
                'Nombre o password incorrecto o contacto a su administrador.',
                'error',
              )
              </script>
              ";
        }
    }

?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

