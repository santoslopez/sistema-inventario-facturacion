<?php

    function eliminarDatosFila($codigoEliminar,$queryEliminar,$namePrepareStatement,$mensajeOK,$urlRedirect,$conexion){
        /**
            *  codigoLenguaEliminar: corresponde al nombre que se le puso en la opcion a href en listadoAdministracionEventos.php 
        * */ 
        $obtenerCodigoEvento = $_GET[$codigoEliminar];
        if (!isset($obtenerCodigoEvento)) {
            //exit("No hay datos alli");
            header('Location: ../admin/index.php');

        }else{
            /**
        * Evitamos inyeccion SQL */  
        //$consultaEliminarLenguas = "DELETE FROM Lenguas WHERE  idLengua=$1";
        $consultaEliminarLenguas = $queryEliminar;


        pg_prepare($conexion,$namePrepareStatement,$consultaEliminarLenguas) or die("Cannot prepare statement.");
        $res= pg_execute($conexion,$namePrepareStatement,array($obtenerCodigoEvento));
            
        
        
        if ($res) {
        echo "<script>
        Swal.fire(
            'Mensaje',
            'Datos eliminado',
            'success'
          )            
            </script>
        ";
        } else {
            echo "<script>
            Swal.fire(
                'Mensaje',
                'No se elimino la informacion',
                'error'
              )            
            </script>
            ";
        }
          }

    }


    
?>