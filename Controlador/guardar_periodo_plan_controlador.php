<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 63;

//obtener el valor del input mediante metodo post
$periodo_plan = strtoupper($_POST['periodo_plan']);




///Logica para el que se repite
$sqlexiste = ("select count(periodo) as periodo  from tbl_periodo_plan where periodo='$periodo_plan'");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

/* Logica para que no acepte campos vacios */
if ($_POST['periodo_plan']  <> '') {

    // /* Condicion para que no se repita el periodo*/
    if ($existe['periodo'] == 1) {
        echo '<script type="text/javascript">
        swal({
           title:"Informacion",
           text:"Ya existe el periodo para este plan",
           type: "error",
           showConfirmButton: false,
           timer: 3000
        });
    </script>';
    } else {
        $sql = "call proc_insertar_periodo_plan('$periodo_plan','$_SESSION[usuario]')";
        $resultado = $mysqli->query($sql);

            if ($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL PERIODO  ' . $periodo_plan . '');

                echo '<script type="text/javascript">
             document.getElementById("btn_guardar_periodo_plan").enable=true;
           </script>';
                /*   require"../contenidos/crearRol-view.php"; 
     header('location: ../contenidos/crearRol-view.php?msj=2');*/
                echo '<script type="text/javascript">
                       swal({
                            title:"",
                            text:"Los datos  se almacenaron correctamente",
                            type: "success",
                            showConfirmButton: false,
                            timer: 3000
                         });
                         $(".FormularioAjax")[0].reset();
                         window.location = "../vistas/mantenimiento_crear_periodo_plan_vista.php";
                     </script>';
            } else {
                echo "Error: " . $sql;
            }

              
        
    }
} else {
    echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"Lo sentimos tiene campos por rellenar",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                </script>';
}