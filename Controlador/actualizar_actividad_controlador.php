<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$actividad = strtoupper($_POST['txt_actividad']);
$descripcion = strtoupper($_POST['txt_descripcion']);
$proyecto = strtoupper($_POST['txt_proyecto']);
$horas = strtoupper($_POST['txt_horas']);
$comision = strtoupper($_POST['comision1']);
$id_actividad = $_GET['id_actividad'];



/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(actividad) as actividad  from tbl_actividades where actividad='$actividad' and id_actividad<>'$id_actividad' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['actividad'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_actividades_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_actividades('$actividad','$descripcion','$proyecto','$horas','$comision','$_SESSION[usuario]','$id_actividad' )";








    $valor = "select actividad, descripcion, nombre_proyecto, horas_semanales, id_comisiones  from tbl_actividades WHERE id_actividad= '$id_actividad'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['actividad'] <> $actividad and $valor_viejo['descripcion'] <> $descripcion and $valor_viejo['nombre_proyecto'] <> $proyecto and $valor_viejo['horas_semanales'] <> $horas and $valor_viejo['id_comisiones'] <> $comision) {

        $Id_objeto = 74;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD ' . $valor_viejo['actividad'] . 'Y POR ' . $actividad . ', LA DESCRIPCION DE LA ACTIVIDAD ' . $actividad . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=3");
        }
    } elseif ($valor_viejo['actividad'] <> $actividad) {

        $Id_objeto = 74;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA ACTIVIDAD ' . $valor_viejo['actividad'] . ' POR ' . $actividad. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=3");
        }
    } elseif ($valor_viejo['descripcion'] <> $descripcion) 
    {

        $Id_objeto = 74;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DE LA ACTIVIDAD A ' . $descripcion. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=3");
        }
    } elseif ($valor_viejo['nombre_proyecto'] <> $proyecto) 
    {

        $Id_objeto = 74;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NOMBRE DEL PROYECTO DE LA ACTIVIDAD A  ' . $proyecto. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=3");
        }
    }elseif ($valor_viejo['horas_semanales'] <> $horas) 
    {

        $Id_objeto = 74;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LAS HORAS SEMANALES DE LA ACTIVIDAD A  ' . $horas. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=3");
        }
    }elseif ($valor_viejo['id_comisiones'] <> $comision) 
    {

        $Id_objeto = 74;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA COMISION DE LA ACTIVIDAD A  ' . $comision. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_actividades_vista.php?msj=3");
        }
    }else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
           header("location:../vistas/mantenimiento_actividades_vista.php?msj=3"); 

        }
}
