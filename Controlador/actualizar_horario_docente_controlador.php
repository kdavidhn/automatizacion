<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');


$hora = strtoupper($_POST['txthora']);
$idhora = $_GET['hora'];




/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(hora) as hora  from tbl_hora where hora='$hora' and hora<>'$idhora'  ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['hora'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_horario_docente_vista.php?msj=1");
} else {

    $sql = "call proc_actualizar_horario_docente('$hora','$_SESSION[usuario]','$idhora' )";




    $valor = "select hora from tbl_hora WHERE hora= '$idhora'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['hora'] <> $hora) {

        $Id_objeto = 69;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA HORA ' . $valor_viejo['hora']  . 'Y POR ' . $hora .  ' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_horario_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_horario_docente_vista.php?msj=3");
        }
    } elseif ($valor_viejo['hora'] <> $hora) {

        $Id_objeto = 85;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA HORA ' . $valor_viejo['hora'] . ' POR ' . $hora . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_horario_docente_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_horario_docente_vista.php?msj=3");
        }
   }else {
          /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
             header("location:../vistas/mantenimiento_horario_docente_vista.php?msj=3"); 

          } 
}