<?php
session_start();
require_once "../Modelos/reporte_docentes_modelo.php";
 $MU = new modelo_reporte();

$id_actividad = $_POST['id_actividad'];
$horas_semanales = $_POST['horas_semanales'];

 $consulta = $MU->modificar_horas( $horas_semanales, $id_actividad);
    echo $consulta;
?>