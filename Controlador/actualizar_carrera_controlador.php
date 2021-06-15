<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$Descripcion = strtoupper($_POST['txtdescripcion']);
$Id_facultad = strtoupper($_POST['facultad1']);
$id_carrera = $_GET['id_carrera'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(Descripcion) as Descripcion  from tbl_carrera where Descripcion='$Descripcion' and id_carrera<>'$id_carrera' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['Descripcion'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_carrera_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_carrera('$Descripcion','$Id_facultad','$_SESSION[usuario]','$id_carrera' )";








    $valor = "select Descripcion, Id_facultad from tbl_carrera WHERE id_carrera= '$id_carrera'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['Descripcion'] <> $Descripcion and $valor_viejo['Id_facultad'] <> $Id_facultad) {

        $Id_objeto = 89;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA CARRERA ' . $valor_viejo['Descripcion'] . 'Y POR ' . $Descripcion . ', LA FACULTAD DE LA COMISION ' . $Descripcion . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_carrera_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_carrera_vista.php?msj=3");
        }
    } elseif ($valor_viejo['Descripcion'] <> $Descripcion) {

        $Id_objeto = 89;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA CARRERA ' . $valor_viejo['Descripcion'] . ' POR ' . $Descripcion . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_carrera_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_carrera_vista.php?msj=3");
        }
    } elseif ($valor_viejo['Id_facultad'] <> $Id_facultad) {

        $Id_objeto = 89;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA FACULTAD DE LA CARRERA ' . $Descripcion . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_carrera_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_carrera_vista.php?msj=3");
        }
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        header("location:../vistas/mantenimiento_carrera_vista.php?msj=3");
    } 
    
}
