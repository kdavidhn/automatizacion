<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 88;


$descripcion = strtoupper($_POST['txt_descripcion']);
$facultad = strtoupper($_POST['facultad1']);


///Logica para el que se repite
$sqlexiste = ("select count(descripcion) as descripcion from tbl_carrera where descripcion='$descripcion'");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_descripcion']  <> ' ' and  $_POST['facultad1'] <> '') {


    /* Condicion para que no se repita el rol*/
    if ($existe['descripcion'] == 1) {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos la carrera ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    } else {

        /* Query para que haga el insert*/
        $sql = "call proc_insertar_carrera('$descripcion','$facultad','$_SESSION[usuario]')";
        $resultado = $mysqli->query($sql);


        if ($resultado === TRUE) {
            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'LA CARRERA ' . $descripcion . '');

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