<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$departamento = strtoupper($_POST['txtdepartamento']);

$id_departamento= $_GET['id_departamento'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(departamento) as departamento  from tbl_departamentos where departamento='$departamento' and id_departamento<>'$id_departamento' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['departamento'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_departamento_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_departamento('$departamento','$_SESSION[usuario]','$id_departamento' )";








    $valor = "select departamento from tbl_departamentos WHERE id_departamento= '$id_departamento'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['departamento'] <> $departamento ) {

        $Id_objeto = 77;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL DEPARTAMENTO ' . $valor_viejo['departamento'] . 'Y POR ' . $departamento . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_departamento_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_departamento_vista.php?msj=3");
        }
    } elseif ($valor_viejo['departamento'] <> $departamento) {

        $Id_objeto = 77;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL DEPARTAMENTO ' . $valor_viejo['departamento'] . ' POR ' . $departamento . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_departamento_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_departamento_vista.php?msj=3");
        }
    
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        header("location:../vistas/mantenimiento_departamento_vista.php?msj=3");
    } 
}
