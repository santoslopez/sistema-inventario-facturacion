<!--?php
  
  //session_start();
  include "../sesion/sesion.php";
?-->

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

    //$estado = "A";
    //date_default_timezone_set('America/Guatemala');    
    //$fechaActual = date('d-m-Y H:i:s',time());


	$correoU = pg_escape_string($correo);
	$datosU = pg_escape_string($datos);
	$passwordUsuario = pg_escape_string($passw);

	if(!(isset($_POST['inputCorreo'],$_POST['inputDatos'],$_POST['inputPassword']))) {
		header('Location: ../index.php');
	}else{
	
	//Encriptamos la contraseña- NO IMPLEMENTADO EN POSTGRESQL
	$passwordEncriptado = password_hash($passwordEncriptado,PASSWORD_BCRYPT);

	$consulta = "SELECT PA_registrarUsuario('$correoU','$datosU','$passwordEncriptado')";

	$ejecutarConsulta = pg_query($conexion, $consulta);
	$data = array();
	
	while ($row= pg_fetch_row($ejecutarConsulta)) {
	  $subarray=array();
	  $subarray[]=$row[0];
	}
	echo json_encode($subarray);
}

?>