<?php

	// importamos las variables globales para realizar la conexion y ejecutar las consultas para insertar datos.
	include "../conexion.php";
   
    date_default_timezone_set('America/Guatemala');    

    $inputFechaFacturaProveedor = $_POST["inputFechaFacturaProveedor"];

	if(!(isset($_POST["inputDocumentoProveedor"]))) {
		header('Location: ../index.php');
	}else{
	    $inputDocumentoProv=htmlspecialchars($_POST["inputDocumentoProveedor"],ENT_QUOTES,'UTF-8');

        $inputDocumentoProveedor = pg_escape_string($inputDocumentoProv);

        $inputNitProveedor= pg_escape_string(htmlspecialchars($_POST["inputNitProveedor"]));

	    $consulta = "SELECT PA_insertarFacturaCompra('$inputDocumentoProveedor','$inputFechaFacturaProveedor','$inputNitProveedor')";

        $ejecutarConsulta = pg_query($conexion, $consulta);
        
        while ($row= pg_fetch_row($ejecutarConsulta)) {
        $subarray=array();
        $subarray[]=$row[0];
        }
        echo json_encode($subarray);
}
?>