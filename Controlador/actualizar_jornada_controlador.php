<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$jornada = strtoupper($_POST['txt_jornada']);
$descripcion = strtoupper($_POST['txt_descripcion']);
$id_jornada = $_GET['id_jornada'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(jornada) as jornada  from tbl_jornadas where jornada='$jornada' and id_jornada<>'$id_jornada' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['jornada'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_jornada('$jornada','$descripcion','$_SESSION[usuario]','$id_jornada' )";








    $valor = "select jornada, descripcion from tbl_jornadas WHERE id_jornada= '$id_jornada'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['jornada'] <> $jornada and $valor_viejo['descripcion'] <> $descripcion) {

        $Id_objeto = 56;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA JORNADA' . $valor_viejo['jornada'] . 'Y POR ' . $jornada . ', LA DESCRIPCION DE LA JORNADA ' . $jornada. ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=3");
        }
    } elseif ($valor_viejo['jornada'] <> $jornada) {

        $Id_objeto = 56;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA JORNADA ' . $valor_viejo['jornada'] . ' POR ' . $jornada . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=3");
        }
    } elseif ($valor_viejo['descripcion'] <> $descripcion) 
    {

        $Id_objeto = 56;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DE LA JORNADA ' . $jornada . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=3");
        }
    } else {
          /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
             header("location:../vistas/mantenimiento_jornadas_docente_vista.php?msj=3"); 

          } 
}
