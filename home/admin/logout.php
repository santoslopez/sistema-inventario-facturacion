<!-- logout -->
<?php
// Inicializar la sesión.
session_start();

// Destruir todas las variables de sesión.
//$_SESSION = array();

// Eliminar todas las sesiones:
unset($_SESSION['nombreUsuario']);
unset($_SESSION['contrasena']);
unset($_SESSION['rolUsuario']);
unset($_SESSION['tipoUsuario']);
unset($_SESSION['loggedin']);

// Finalmente, destruir la sesión.
session_destroy();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Location:../index.php");

?>