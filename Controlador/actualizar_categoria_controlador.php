<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$categoria = strtoupper($_POST['txtcategoria']);
$descripcion = strtoupper($_POST['txtdescripcion']);
$id_categoria = $_GET['id_categoria'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(categoria) as categoria  from tbl_categorias where categoria='$categoria' and id_categoria<>'$id_categoria' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['categoria'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_categoria('$categoria','$descripcion','$_SESSION[usuario]','$id_categoria' )";


    $valor = "select categoria, descripcion from tbl_categorias WHERE id_categoria= '$id_categoria'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['categoria'] <> $categoria and $valor_viejo['descripcion'] <> $descripcion) {

        $Id_objeto = 59;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA CATEGORIA ' . $valor_viejo['categoria'] . 'Y POR ' . $categoria . ', LA DESCRIPCION DE LA CATEGORIA ' . $categoria . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=3");
        }
    } elseif ($valor_viejo['categoria'] <> $categoria) {

        $Id_objeto = 59;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA CATEGORIA ' . $valor_viejo['categoria'] . ' POR ' . $categoria . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=3");
        }
    } elseif ($valor_viejo['descripcion'] <> $descripcion) {

        $Id_objeto = 59;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DE LA CATEGORIA ' . $categoria . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=3");
        }
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        header("location:../vistas/mantenimiento_categorias_docente_vista.php?msj=3");
    } 

}
