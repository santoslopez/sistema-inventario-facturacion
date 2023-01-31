<?php
    session_set_cookie_params(60*60*24*1); // 1 día
    // Inicializar la sesión.
    session_start();
    require_once("../conexion.php");

        $nombreUsuario = htmlspecialchars($_POST["nombreApellidos"],ENT_QUOTES,'UTF-8');
        $pass = htmlspecialchars($_POST["direccion"],ENT_QUOTES,'UTF-8');

        $queryLogin = sprintf("SELECT contrasena,nombreApellidos,fechaRegistro,estado,codRol,codigoUsuario FROM Usuarios WHERE correo='%s' AND estado='A' AND codRol='1';",pg_escape_string($nombreUsuario));

        $fila = pg_fetch_assoc(pg_query($conexion,$queryLogin));

        if (($fila) && password_verify($pass,$fila["contrasena"])){
            $passwordUsuario = $_POST["direccion"];

            // regenerar el id de sesion
            session_regenerate_id();
            // sesion para mostrar si esta activo o no el usuario
            $_SESSION["loggedin"] = TRUE;
            $_SESSION["nombreUsuario"] = $nombreUsuario;	
            $_SESSION["contrasena"] = $pass;	
            $_SESSION["rolUsuario"]= "1"; 
            $_SESSION["tipoUsuario"]= TRUE; 
            $_SESSION["codigoUsuario"] = $fila["codigousuario"];
            //$data['status'] = 'success';
            echo json_encode("success");
            
        } else{
            //$data['status'] = 'failed';
            echo json_encode("failed");
            
        }
?>