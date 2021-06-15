<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$nacionalidad = strtoupper($_POST['txt_nacionalidad']);
$PAIS_NAC= strtoupper($_POST['txt_pais']);
$id_nacionalidad = $_GET['id_nacionalidad'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(nacionalidad) as nacionalidad  from tbl_nacionalidad where nacionalidad='$nacionalidad' and id_nacionalidad<>'$id_nacionalidad' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['nacionalidad'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_nacionalidad('$nacionalidad','$PAIS_NAC','$_SESSION[usuario]','$id_nacionalidad' )";








    $valor = "select nacionalidad, PAIS_NAC from tbl_nacionalidad WHERE id_nacionalidad= '$id_nacionalidad'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['nacionalidad'] <> $nacionalidad and $valor_viejo['PAIS_NAC'] <> $PAIS_NAC) {

        $Id_objeto = 73;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA NACIONALIDAD ' . $valor_viejo['nacionalidad'] . 'Y POR ' . $nacionalidad. ', EL PAIS DE LA NACIONALIDAD ' . $nacionalidad . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=3");
        }
    } elseif ($valor_viejo['nacionalidad'] <> $nacionalidad) {

        $Id_objeto = 90;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA NACIONALIDAD ' . $valor_viejo['nacionalidad'] . ' POR ' . $nacionalidad . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=3");
        }
    } elseif ($valor_viejo['PAIS_NAC'] <> $PAIS_NAC) 
    {

        $Id_objeto = 73;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL PAIS DE LA NACIONALIDAD ' . $nacionalidad . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=3");
        }
    } else {
          /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
             header("location:../vistas/mantenimiento_nacionalidad_vista.php?msj=3"); 

          } 

}
