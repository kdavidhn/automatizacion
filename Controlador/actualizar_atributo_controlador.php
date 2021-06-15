<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$atributo = strtoupper($_POST['txt_atributo']);
$requerido = strtoupper($_POST['txt_requerido']);
$tipo_persona = strtoupper($_POST['persona1']);
$id_atributo = $_GET['id_atributos'];



/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(atributo) as atributo  from tbl_atributos where atributo='$atributo' and id_atributos<>'$id_atributo' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['atributo'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_atributos_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_atributo('$atributo','$requerido','$tipo_persona','$_SESSION[usuario]','$id_atributo' )";








    $valor = "select atributo, requerido, id_tipo_persona from tbl_atributos WHERE id_atributos= '$id_atributo'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['atributo'] <> $atributo and $valor_viejo['requerido'] <> $requerido and $valor_viejo['id_tipo_persona'] <> $tipo_persona) {

        $Id_objeto = 80;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL ATRIBUTO ' . $valor_viejo['atributo'] . 'Y POR ' . $atributo . ', LA DESCRIPCION DEL ATRIBUTO ' . $atributo . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=3");
        }
    } elseif ($valor_viejo['atributo'] <> $atributo) {

        $Id_objeto = 80;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL ATRIBUTO ' . $valor_viejo['atributo'] . ' POR ' . $atributo. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=3");
        }
    } elseif ($valor_viejo['requerido'] <> $requerido) 
    {

        $Id_objeto = 80;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL ATRIBUTO A ' . $requerido. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=3");
        }
    } elseif ($valor_viejo['id_tipo_persona'] <> $tipo_persona) 
    {

        $Id_objeto = 80;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL ATRIBUTO ' . $atributo. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_atributos_vista.php?msj=3");
        }
    }else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
           header("location:../vistas/mantenimiento_atributos_vista.php?msj=3"); 

        }
}
