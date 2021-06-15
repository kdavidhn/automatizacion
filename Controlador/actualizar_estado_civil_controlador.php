<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$estado_civil = strtoupper($_POST['txtestado_civil']);
$descripcion = strtoupper($_POST['txtdescripcion']);
$id_estado_civil = $_GET['id_estado_civil'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(estado_civil) as estado_civil  from tbl_estadocivil where estado_civil='$estado_civil' and id_estado_civil<>'$id_estado_civil' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['estado_civil'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_estado_civil('$estado_civil','$descripcion','$_SESSION[usuario]','$id_estado_civil' )";








    $valor = "select estado_civil, descripcion from tbl_estadocivil WHERE id_estado_civil= '$id_estado_civil'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['estado_civil'] <> $estado_civil and $valor_viejo['descripcion'] <> $descripcion) {

        $Id_objeto = 62;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL ESTADO CIVIL ' . $valor_viejo['estado_civil'] . 'Y POR ' . $estado_civil . ', LA DESCRIPCION DEL ESTADO CIVIL ' . $estado_civil . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=3");
        }
    } elseif ($valor_viejo['estado_civil'] <> $estado_civil) {

        $Id_objeto = 62;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL ESTADO CIVIL ' . $valor_viejo['estado_civil'] . ' POR ' . $estado_civil . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=3");
        }
    } elseif ($valor_viejo['descripcion'] <> $descripcion) 
    {

        $Id_objeto = 62;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL ESTADO CIVIL ' . $estado_civil . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=3");
        }
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        header("location:../vistas/mantenimiento_estado_civil_vista.php?msj=3");
    } 
}
