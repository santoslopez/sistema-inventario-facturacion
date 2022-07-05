<?php
  
  //session_start();
  include "../sesion/sesion.php";
?>

<?php

	// importamos las variables globales para realizar la conexion y ejecutar las consultas para insertar datos.
	include '../conexion.php';

	/*
		En el POST colocamos el nombre del NAME de cada input del formulario donde ingresamos los datos
		El formulario corresponde al archivo registrarCuentas.html
	*/
    $correo=htmlspecialchars($_POST['inputCorreo'],ENT_QUOTES,'UTF-8');
  
    $datos=htmlspecialchars($_POST['inputDatos'],ENT_QUOTES,'UTF-8');

	$passw=htmlspecialchars($_POST['inputPassword'],ENT_QUOTES,'UTF-8');

    $estado = "A";
    date_default_timezone_set('America/Guatemala');    
    $fechaActual = date('d-m-Y H:i:s',time());


	if(!isset($correo,$datos,$passw)) {
		header('Location: ../index.php');
	}
	

	//Encriptamos la contraseña- NO IMPLEMENTADO EN POSTGRESQL
	$passwordEncriptado = password_hash($passw,PASSWORD_BCRYPT);


	/**
	 * Verificamos que el correo a registrar no este en uso, si lo esta no se guardan los datos.
	 */
	$verificarUsuario = "SELECT * FROM Usuarios WHERE correo=$1";
	
	pg_prepare($conexion,"prepareVerificarUsuario",$verificarUsuario) or die("Cannot prepare statement.");
	
	$ejecutarConsultaVerificarUsuario = pg_execute($conexion,"prepareVerificarUsuario",array($correo));

	if (pg_num_rows($ejecutarConsultaVerificarUsuario)) {
		echo $ejecutarConsultaVerificarUsuario;
		
		/*echo "<script>
				mensajeRegistrarDatos('ERROR. El usuario esta en uso.','ERROR','error','../usuarios/registrarUsuario.html');
	 		</script>
		";*/
		//exit;		
	}else{

	

	// Previniendo Inyecion SQL
	//$consultaInsert = "INSERT INTO Usuarios(datosUsuario,correo,passwordUsuario) VALUES ($1,$2,$3)";


	/**
	 * pg_query: corresponde para ejecutar la consulta para PostgreSQL
	 * 
	 * $conexion: está variable corresponde a la variable global del archivo conexion.php
	 */

	//pg_prepare($conexion,"prepare1",$consultaInsert) or die("Cannot prepare statement .");

	$consulta  = sprintf("INSERT INTO Usuarios(correo,estado,fechaRegistro,nombreApellidos,contrasena) VALUES('%s','%s','%s','%s','%s');",
    pg_escape_string($correo),
    pg_escape_string($estado),
    pg_escape_string($fechaActual),
    pg_escape_string($datos),
    password_hash($passw, PASSWORD_DEFAULT,['cost'=>12])
    //pg_escape_string(strtolower($idTipoCuenta)) 
    );

	$ejecutarConsulta = pg_query($conexion, $consulta);

	/**
	 * Sino hay ningun error
	 */
	if ($ejecutarConsulta) {
		//echo "cuentaRegistrado";
		/*echo "<script>
				mensajeRegistrarDatos('La cuenta de usuario se registro correctamente','Datos registrados','success','../index.php');
			 </script>
		";*/
		echo 2;
	}else{
		echo 3;
		//echo $consulta;
		/*echo "<script>
				mensajeRegistrarDatos('La cuenta no se registro','ERROR','error','../index.php');
	 		</script>
		";*/

	}
	//pg_close($conexion);
}
?>