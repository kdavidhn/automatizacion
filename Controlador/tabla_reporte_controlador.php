<?php
/* session_start(); */
require_once "../Modelos/reporte_docentes_modelo.php";
/* $id = $_SESSION['id_usuario'];
print_r($id); */
$id = $_POST['id_usuario_'];
$instancia_modelo = new modelo_reporte();

$consulta = $instancia_modelo->listar_actividades($id);
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
