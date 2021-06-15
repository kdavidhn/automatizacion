<?php
    require '../Modelos/tabla_carga_modelo.php';

    $MU = new modeloCarga();

$id_carga_academica = $_POST['id_carga_academica'];
$id_asignatura = $_POST['id_asignatura'];
$seccion = $_POST['seccion'];
$hra_inicio = $_POST['hora_inicial'];
$hra_final = $_POST['hora_final'];
$dias = $_POST['dias'];
//$id_aula = $_POST['id_aula'];
$num_alumnos = $_POST['num_alumnos'];
$control = $_POST['control'];
$id_modalidad = $_POST['id_modalidad'];

    $consulta = $MU->modificar_carga_academica_virtual($control, $seccion, $hra_inicio, $hra_final, $num_alumnos, $id_asignatura, $dias, $id_modalidad, $id_carga_academica);
    echo $consulta;
