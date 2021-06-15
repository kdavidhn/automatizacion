<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$municipio = strtoupper($_POST['txt_municipio']);
$codigo = strtoupper($_POST['txt_codigo']);
$departamento = strtoupper($_POST['departamento1']);
$id_municipio = $_GET['id_municipio'];



/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(municipio) as municipio  from tbl_municipios_hn where municipio='$municipio' and id_municipio<>'$id_municipio' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['municipio'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_municipio_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_municipio('$municipio','$codigo','$departamento','$_SESSION[usuario]','$id_municipio' )";








    $valor = "select municipio, codigo, id_departamento from tbl_municipios_hn WHERE id_municipio= '$id_municipio'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['municipio'] <> $municipio and $valor_viejo['codigo'] <> $codigo and $valor_viejo['id_departamento'] <> $departamento) {

        $Id_objeto = 79;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL MUNICIPIO ' . $valor_viejo['municipio'] . 'Y POR ' . $municipio . ', EL MUNICIPIO ' . $municipio . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=3");
        }
    } elseif ($valor_viejo['municipio'] <> $municipio) {

        $Id_objeto = 79;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL MUNICIPIO ' . $valor_viejo['municipio'] . ' POR ' . $municipio. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=3");
        }
    } elseif ($valor_viejo['codigo'] <> $codigo) 
    {

        $Id_objeto = 79;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL MUNICIPIO ' . $codigo. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=3");
        }
    } elseif ($valor_viejo['id_departamento'] <> $departamento) 
    {

        $Id_objeto = 79;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL MUNICIPIO ' . $municipio. ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_municipio_vista.php?msj=3");
        }
    }else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
           header("location:../vistas/mantenimiento_municipio_vista.php?msj=3"); 

        }
}
