<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$genero = strtoupper($_POST['txt_genero']);
$id_genero = $_GET['id_genero'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(genero) as genero  from tbl_genero where genero='$genero' and id_genero<>'$id_genero' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['genero'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_genero_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_genero('$genero', '$_SESSION[usuario]','$id_genero' )";








    $valor = "select genero from tbl_genero WHERE id_genero= '$id_genero'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['genero'] <> $genero ) {

        $Id_objeto = 84;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL GÉNERO ' . $valor_viejo['genero'] . 'Y POR ' . $genero . ', LA DESCRIPCION DEL GÉNERO ' . $genero . ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_genero_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_genero_vista.php?msj=3");
        }
    } elseif ($valor_viejo['genero'] <> $genero) {

        $Id_objeto = 71;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL GÉNERO ' . $valor_viejo['genero'] . ' POR ' . $genero . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_genero_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_genero_vista.php?msj=3");
        }
    } else {
          /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
             header("location:../vistas/mantenimiento_genero_vista.php?msj=3"); 

          } 
}
