<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');


$codigo = strtoupper($_POST['txt_codigo']);
$descripcion = strtoupper($_POST['txt_descripcion']);
$capacidad = strtoupper($_POST['txt_capacidad']);
$edificio = strtoupper($_POST['edificio']);
$tipoaula = strtoupper($_POST['aula']);
$id_aula = $_GET['id_aula'];



/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(codigo) as codigo  from tbl_aula where codigo='$codigo' and id_aula='$id_aula'and id_edificio='$edificio' and id_tipo_aula='$tipoaula';");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['codigo'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_aula_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_aula('$codigo','$descripcion','$capacidad','$edificio','$tipoaula','$_SESSION[usuario]','$id_aula' )";








    $valor = "select codigo, descripcion, capacidad, id_edificio, id_tipo_aula  from tbl_aula WHERE id_aula= '$id_aula'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['codigo'] <> $codigo and $valor_viejo['descripcion'] <> $descripcion and $valor_viejo['capacidad'] <> $capacidad and $valor_viejo['id_edificio'] <> $edificio and $valor_viejo['id_tipo_aula'] <> $tipoaula) {

        $Id_objeto = 60;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL AULA ' . $valor_viejo['codigo'] . 'Y POR ' . $codigo . ', LA DESCRIPCION DEL AULA A ' . $codigo . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=3");
        }
    } elseif ($valor_viejo['codigo'] <> $codigo) {

        $Id_objeto = 60;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL AULA' . $valor_viejo['codigo'] . ' POR ' . $codigo. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=3");
        }
    } elseif ($valor_viejo['descripcion'] <> $descripcion) 
    {

        $Id_objeto = 60;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL AULA A ' . $descripcion. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=3");
        }
    } elseif ($valor_viejo['capacidad'] <> $capacidad) 
    {

        $Id_objeto = 60;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' lA CAPACIDAD DEL AULA A  ' . $capacidad. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=3");
        }
    }elseif ($valor_viejo['id_edificio'] <> $edificio) 
    {

        $Id_objeto = 60;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL EDIFICIO DEL AULA A  ' . $edificio. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=3");
        }
    }elseif ($valor_viejo['id_tipo_aula'] <> $tipoaula) 
    {

        $Id_objeto = 60;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL TIPO DE AULA A ' . $tipoaula. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_aula_vista.php?msj=3");
        }
    }else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
           header("location:../vistas/mantenimiento_aula_vista.php?msj=3"); 

        }
}
