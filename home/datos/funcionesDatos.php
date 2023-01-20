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

    // devuelve el codigo y nombre en combobox. El codigo aparece oculto
    function datosCombobox($codigoSelect,$linkConexion,$query){
        $resultCuentas=pg_query($linkConexion,$query);
        
        if (!(pg_num_rows($resultCuentas))) {
            echo "<div class='alert alert-danger' role='alert'>
                    No hay informacion disponible.
                </div>";
        }else{
            echo "<select class='form-select' name='$codigoSelect' id='$codigoSelect'>";
            $contador=0;
            while ($row= pg_fetch_row($resultCuentas)) {
                $codigo = $row[0];
                $nombre = $row[1];
                echo "<option value='$codigo' id='$codigo'>$nombre</option>";

                //if ($contador==0) {
                    # code...
                //    echo "<option value='$codigo' id='$codigo' selected='$codigo'>$nombre</option>";
                //}else{
                //    echo "<option value='$codigo' id='$codigo'>$nombre</option>";

                //}
                $contador++;
            }
            echo "</select>";
        }
    }

    
?>