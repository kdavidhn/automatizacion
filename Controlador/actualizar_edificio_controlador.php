<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');


$edificio= strtoupper($_POST['txtedificio']);
$codigo = strtoupper($_POST['txtcodigo']);
$id_edificio = $_GET['id_edificio'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(nombre) as nombre  from tbl_edificios where nombre='$edificio' and id_edificio<>'$id_edificio' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['nombre'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_edificio_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_edificio('$edificio','$codigo','$_SESSION[usuario]','$id_edificio' )";
    $valor = "select nombre, codigo from tbl_edificios WHERE id_edificio= '$id_edificio'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['nombre'] <> $edificio and $valor_viejo['codigo'] <> $codigo) {

        $Id_objeto = 58;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL EDIFICIO ' . $valor_viejo['nombre'] . 'Y POR ' . $edificio . ', EL CODIGO DEL EDIFICIO ' . $edificio . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_edificio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_edificio_vista.php?msj=3");
        }
    } elseif ($valor_viejo['nombre'] <> $edificio) {

        $Id_objeto = 58;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL EDIFICIO ' . $valor_viejo['nombre'] . ' POR ' . $edificio . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_edificio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_edificio_vista.php?msj=3");
        }
    } elseif ($valor_viejo['codigo'] <> $codigo) 
    {

        $Id_objeto = 58;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL CODIGO DEL EDIFICIO  ' . $edificio . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_edificio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_edificio_vista.php?msj=3");
        }
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        header("location:../vistas/mantenimiento_edificio_vista.php?msj=3");
    }
}
