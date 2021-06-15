<?php
require '../Modelos/tabla_carga_modelo.php';

$MU = new modeloCarga();

$id_carga = $_POST['id_carga_academica'];


$consulta = $MU->eliminar_carga($id_carga);

echo $consulta;
