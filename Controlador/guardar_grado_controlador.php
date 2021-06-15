<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 65;


$grado = strtoupper($_POST['txtgradoacademico']);
$descripcion = strtoupper($_POST['txtdescripcion']);


///Logica para el que se repite
$sqlexiste = ("select count(grado_academico) as grado_academico  from tbl_grados_academicos where grado_academico='$grado'");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txtgradoacademico']  <> ' ' and  $_POST['txtdescripcion'] <> '') {


    /* Condicion para que no se repita el rol*/
    if ($existe['grado_academico'] == 1) {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el grado academico ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    } else {

        /* Query para que haga el insert*/
        $sql = "call proc_insertar_grado_academico('$grado','$descripcion','$_SESSION[usuario]')";
        $resultado = $mysqli->query($sql);


        if ($resultado === TRUE) {
            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL GRADO ACADEMICO ' . $grado . '');

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
