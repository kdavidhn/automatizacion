<?php
require_once "../Modelos/plan_estudio_modelo.php";


$opcion_check = isset($_POST["plan_vigente"]) ? limpiarCadena1($_POST["plan_vigente"]) : "";
$nombre_plan = isset($_POST["nombre"]) ? limpiarCadena1($_POST["nombre"]) : "";

$instancia_modelo = new modelo_plan();
switch ($_GET["op"]) {
    
    case 'tipo_plan':

        $data = array();
        $respuesta2 = $instancia_modelo->tipo_plan_sel();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_tipo_plan . "'> " . $r2->nombre . " </option>";
        }
        break;

    case 'verificarPlan':
        $rspta = $instancia_modelo->planActivo($opcion_check);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'verificarPlanNombre':
        $rspta = $instancia_modelo->verificarPlanNombre($nombre_plan);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;


  
  
}


?>