<?php
require '../Modelos/tabla_carga_modelo.php';

$MU = new modeloCarga();

$consulta = $MU->listar_periodo_carga();
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
