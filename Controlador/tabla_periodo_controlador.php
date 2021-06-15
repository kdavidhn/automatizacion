<?php
require '../Modelos/tabla_carga_modelo.php';

$MU = new modeloCarga();

$anno = $_POST["num_anno"];
$periodo = $_POST["num_periodo"];


$consulta = $MU->listar_carga_historial($anno,$periodo);
if ($consulta) {
    echo json_encode($consulta);
} else {
    echo '{
		    "sEcho": 1,
		    "iTotalRecords": "0",
		    "iTotalDisplayRecords": "0",
		    "aaData": []
		}';
}
