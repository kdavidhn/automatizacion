<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$grado_academico= strtoupper($_POST['txtgrado_academico']);
$descripcion = strtoupper($_POST['txtdescripcion']);
$id_grado_academico = $_GET['id_grado_academico'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(grado_academico) as grado_academico  from tbl_grados_academicos where grado_academico='$grado_academico' and id_grado_academico<>'$id_grado_academico' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['grado_academico'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_grados_academicos_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_grados_academicos('$grado_academico','$descripcion','$_SESSION[usuario]','$id_grado_academico' )";








    $valor = "select grado_academico, descripcion from tbl_grados_academicos WHERE id_grado_academico= '$id_grado_academico'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['grado_academico'] <> $grado_academico and $valor_viejo['descripcion'] <> $descripcion) {

        $Id_objeto = 61;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL GRADO ACADEMICO' . $valor_viejo['grado_academico'] . 'Y POR ' . $grado_academico . ', LA DESCRIPCION DEL GRADO ACADEMICO ' . $grado_academico . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_grados_academicos_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_grados_academicos_vista.php?msj=3");
        }
    } elseif ($valor_viejo['grado_academico'] <> $grado_academico) {

        $Id_objeto = 61;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL GRADO  ACADEMICO ' . $valor_viejo['grado_academico'] . ' POR ' . $grado_academico . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_grados_academicos_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_grados_academicos_vista.php?msj=3");
        }
    } elseif ($valor_viejo['descripcion'] <> $descripcion) {

        $Id_objeto = 61;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL GRADO ACADEMICO ' . $grado_academico . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_gradoS_academicoS_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_gradoS_academicoS_vista.php?msj=3");
        }
    }else {
          /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
             header("location:../vistas/mantenimiento_gradoS_academicoS_vista.php?msj=3"); 

          } 
}
