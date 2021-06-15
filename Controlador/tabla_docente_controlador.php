<?php
require_once "../Modelos/gestion_docente_modelo.php";
$instancia_modelo = new modelo_gestion_docente();

$consulta = $instancia_modelo->listar();
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
?>