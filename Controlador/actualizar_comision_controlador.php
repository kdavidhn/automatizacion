<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$comision = strtoupper($_POST['txtcomision']);
$carrera = strtoupper($_POST['carrera1']);
$id_comisiones = $_GET['id_comisiones'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(comision) as comision  from tbl_comisiones where comision='$comision' and id_comisiones<>'$id_comisiones' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['comision'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_comisiones('$comision','$carrera','$_SESSION[usuario]','$id_comisiones' )";








    $valor = "select comision, id_carrera from tbl_comisiones WHERE id_comisiones= '$id_comisiones'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['comision'] <> $comision and $valor_viejo['id_carrera'] <> $carrera) {

        $Id_objeto = 57;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA COMISION ' . $valor_viejo['comision'] . 'Y POR ' . $comision . ', LA CARRERA DE LA COMISION ' . $comision . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=3");
        }
    } elseif ($valor_viejo['comision'] <> $comision) {

        $Id_objeto = 57;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA COMISION ' . $valor_viejo['comision'] . ' POR ' . $comision . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=3");
        }
    } elseif ($valor_viejo['id_carrera'] <> $carrera) {

        $Id_objeto = 57;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA CARRERA DE LA COMISION ' . $comision . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=3");
        }
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        header("location:../vistas/mantenimiento_comisiones_docente_vista.php?msj=3");
    } 
    
}
