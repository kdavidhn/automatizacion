<?php
require_once "../Modelos/reporte_carga_modelo.php";


$Id_asignatura = isset($_POST["Id_asignatura"]) ? limpiarCadena1($_POST["Id_asignatura"]) : "";
$id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";
$Id_dia = isset($_POST["Id_dia"]) ? limpiarCadena1($_POST["Id_dia"]) : "";
$id_edificio = isset($_POST["id_edificio"]) ? limpiarCadena1($_POST["id_edificio"]) : "";
$Id_modalidad = isset($_POST["id_modalidad"]) ? limpiarCadena1($_POST["id_modalidad"]) : "";
$id_hora = isset($_POST["hora"]) ? limpiarCadena1($_POST["hora"]) : "";
$num_periodo = isset($_POST["num_periodo"]) ? limpiarCadena1($_POST["num_periodo"]) : "";
$num_anno = isset($_POST["num_anno"]) ? limpiarCadena1($_POST["num_anno"]) : "";
$fecha_inicio = isset($_POST["fecha_inicio"]) ? limpiarCadena1($_POST["fecha_inicio"]) : "";
$fecha_final = isset($_POST["fecha_final"]) ? limpiarCadena1($_POST["fecha_final"]) : "";
$id_periodo = isset($_POST["id_periodo"]) ? limpiarCadena1($_POST["id_periodo"]) : "";
$aula = isset($_POST["id_aula"]) ? limpiarCadena1($_POST["id_aula"]) : "";
$id_tipo_periodo = isset($_POST["id_tipo_periodo"]) ? limpiarCadena1($_POST["id_tipo_periodo"]) : "";
$fecha_adic_canc = isset($_POST["fecha_adic_canc"]) ? limpiarCadena1($_POST["fecha_adic_canc"]) : "";
$seccion = isset($_POST["seccion"]) ? limpiarCadena1($_POST["seccion"]) : "";
$hora_inicial = isset($_POST["hora_inicial"]) ? limpiarCadena1($_POST["hora_inicial"]) : "";
$dias = isset($_POST["dias"]) ? limpiarCadena1($_POST["dias"]) : "";
$hora_inicial = isset($_POST["hora_inicial"]) ? limpiarCadena1($_POST["hora_inicial"]) : "";
$hora_final = isset($_POST["hora_final"]) ? limpiarCadena1($_POST["hora_final"]) : "";



$instancia_modelo = new modelo_modal();
switch ($_GET["op"]) {
    case 'mostrar':
        $rspta = $instancia_modelo->mostrar($id_persona);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'select1':

        $data = array();
        $respuesta = $instancia_modelo->listar_select1();

        while ($r = $respuesta->fetch_object()) {


            # code...
            echo "<option value='" . $r->id_persona . "'> " . $r->nombres . " " . $r->apellidos . " </option>";
        }
        break;

    case 'mostrar2':
        $rspta2 = $instancia_modelo->mostrar2($Id_asignatura);
        //Codificar el resultado utilizando json
        echo json_encode($rspta2);
        break;
    case 'select2':

        $data = array();
        $respuesta2 = $instancia_modelo->listar_select2();

        while ($r2 = $respuesta2->fetch_object()) {


            # code...
            echo "<option value='" . $r2->Id_asignatura . "'> " . $r2->asignatura . " </option>";
        }
        break;

        //MODALIDAD
    case 'mostrar6':
        $rspta6 = $instancia_modelo->mostrar_modalidad($Id_modalidad);
        //Codificar el resultado utilizando json
        echo json_encode($rspta6);
        break;
    case 'select6':

        $data = array();
        $respuesta6 = $instancia_modelo->listar_select6();

        while ($r6 = $respuesta6->fetch_object()) {


            # code...
            echo "<option value='" . $r6->id_modalidad . "'> " . $r6->modalidad . " </option>";
        }
        break;
        //---------

        //HORARIO
    case 'mostrar7':
        $rspta6 = $instancia_modelo->mostrar_hora($id_hora);
        //Codificar el resultado utilizando json
        echo json_encode($rspta6);
        break;
    case 'select7':

        $data = array();
        $respuesta6 = $instancia_modelo->listar_select7();

        while ($r6 = $respuesta6->fetch_object()) {


            # code...
            echo "<option value='" . $r6->hora . "'> " . $r6->hora . " </option>";
        }
        break;
        //---------

        //TIPO PERIODO
    case 'mostrar8':
        $rspta6 = $instancia_modelo->tipo_periodo($id_tipo_periodo);
        //Codificar el resultado utilizando json
        echo json_encode($rspta6);
        break;
    case 'select8':

        $data = array();
        $respuesta6 = $instancia_modelo->listar_select8();

        while ($r6 = $respuesta6->fetch_object()) {


            # code...
            echo "<option value='" . $r6->id_tipo_periodo . "'> " . $r6->descripcion . " </option>";
        }
        break;

    case 'mostrar3':
        $rspta3 = $instancia_modelo->mostrar3($Id_dia);
        //Codificar el resultado utilizando json
        echo json_encode($rspta3);
        break;
    case 'select3':

        $data = array();
        $respuesta3 = $instancia_modelo->listar_select3();

        while ($r3 = $respuesta3->fetch_object()) {


            # code...
            echo "<option value='" . $r3->Id_dia . "'> " . $r3->dia . " </option>";
        }
        break;
        //EDIFICIO
    case 'mostrar4':
        $rspta4 = $instancia_modelo->mostrar4($id_edificio);
        //Codificar el resultado utilizando json
        echo json_encode($rspta4);
        break;
    case 'select4':

        $data = array();
        $respuesta4 = $instancia_modelo->listar_select4();

        while ($r4 = $respuesta4->fetch_object()) {


            # code...
            echo "<option value='" . $r4->id_edificio . "'> " . $r->nombres . " " . $r->apellidos .  " </option>";
        }
        break;

    case 'capacidad':

        $respuesta = $instancia_modelo->capacidad($aula);
        echo json_encode($respuesta);
        break;



    case 'mostrar_docente':
        $rspta = $instancia_modelo->mostrar_docente($id_persona);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'select5':

        $data = array();
        $respuesta = $instancia_modelo->listar_docente();

        while ($r = $respuesta->fetch_object()) {


            # code...
            echo "<option value='" . $r->id_persona . "'> " . $r->nombres . " " . $r->apellidos .  " </option>";
        }
        break;
    case 'cargar_aula':


        $data = array();
        $respuesta = $instancia_modelo->listar_aula($id_edificio);

        while ($r = $respuesta->fetch_object()) {

            if ($r->id_aula == $aula) {
                echo '<option selected value="' . $r->id_aula . '">' . $r->codigo . '</option>' . "\n";
            } else {
                echo '<option value="' . $r->id_aula . '">' . $r->codigo . '</option>' . "\n";
            }
        }
        break;

    case 'modalidad':

        $data = array();
        $respuesta2 = $instancia_modelo->listar_modalidad();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_modalidad . "'> " . $r2->modalidad . " </option>";
        }
        break;

    case 'id_periodo_historial':
        $rspta = $instancia_modelo->id_periodo_hist($num_anno, $num_periodo);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'id_periodo_nuevo':
        $rspta = $instancia_modelo->existe_carga_periodo($id_periodo);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'validarhoradocente':
        $rspta = $instancia_modelo->validarhoradocen($id_persona);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'verificarCarga':
        $rspta = $instancia_modelo->existe_carga_persona($hora_inicial, $aula, $id_periodo, $hora_final);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'existe_carga':
        $rspta = $instancia_modelo->existe_carga($hora_inicial, $id_periodo, $hora_final, $aula);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'contar_carga':
        $rspta = $instancia_modelo->contar_carga($id_persona);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

   
}
