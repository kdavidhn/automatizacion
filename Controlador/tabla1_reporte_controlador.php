<?php

require_once "../Modelos/reporte_docentes_modelo.php";

$instancia_modelo = new modelo_reporte();
$id_persona = $_POST['id_persona_'];

$consulta = $instancia_modelo->listar($id_persona);
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
