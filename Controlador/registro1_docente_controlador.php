<?php

require '../Modelos/registro_docente_modelo.php';

$MU = new modelo_registro_docentes();

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$sexo = $_POST['sexo'];
//$identidad = $_POST['identidad'];
$nacionalidad = $_POST['nacionalidad'];
$estado = $_POST['estado'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$hi = $_POST['hi'];
$hf = $_POST['hf'];
$nempleado = $_POST['nempleado'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$idjornada = $_POST['idjornada'];
$idcategoria = $_POST['idcategoria'];


//$consulta = $MU->registrar_docente($nombre, $apellidos, $sexo, $nacionalidad, $estado, $fecha_nacimiento, $idcategoria, $idjornada, $hi, $hf, $nempleado, $fecha_ingreso);
echo $consulta;
