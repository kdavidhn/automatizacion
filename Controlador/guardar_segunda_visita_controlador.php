<?php
require_once "../Modelos/segunda_visita_modelo.php";

$modelo=new segunda_visita();


$numero_cuenta=isset($_POST["cuenta_sv"])? ($_POST["cuenta_sv"]):"";
$asistencia=isset($_POST["asistencia_sv"])? ($_POST["asistencia_sv"]):"";
$horario=isset($_POST["horarios_sv"])? ($_POST["horarios_sv"]):"";
$adaptacion=isset($_POST["adaptacion_sv"])? ($_POST["adaptacion_sv"]):"";
$cumplimiento=isset($_POST["cumplimiento_sv"])? ($_POST["cumplimiento_sv"]):"";
$calidad=isset($_POST["calidad_sv"])? ($_POST["calidad_sv"]):"";
$percepcion_conocimiento=isset($_POST["percepcion_conocimientos_sv"])? ($_POST["percepcion_conocimientos_sv"]):"";
$percepcion_habilidad=isset($_POST["percepcion_habilidades_sv"])? ($_POST["percepcion_habilidades_sv"]):"";
$comentario=isset($_POST["comentarios_sv"])? ($_POST["comentarios_sv"]):"";
$area_refuerzo=isset($_POST["areas_refuerzo_sv"])? ($_POST["areas_refuerzo_sv"]):"";
$calificacion=isset($_POST["calificacion_sv"])? ($_POST["calificacion_sv"]):"";
$solicitar=isset($_POST["solicitar_practicante_sv"])? ($_POST["solicitar_practicante_sv"]):"";
$representante=isset($_POST["representante_sv"])? ($_POST["representante_sv"]):"";
$lugar=isset($_POST["lugar_sv"])? ($_POST["lugar_sv"]):"";
$oportunidad=isset($_POST["oportunidad_empleo_sv"])? ($_POST["oportunidad_empleo_sv"]):"";
$id_persona=isset($_POST["id_persona"])? ($_POST["id_persona"]):"";




$prueba="selectCurso";




switch ($_GET["op"]){
	case 'guardar':
		
            $rspta=$modelo->insertar($numero_cuenta,$asistencia,$horario,$adaptacion
                                    ,$cumplimiento,$calidad,$percepcion_conocimiento,$percepcion_habilidad,$comentario,$area_refuerzo
                                    ,$calificacion,$solicitar,$representante,$lugar,$oportunidad);
			echo $rspta ? "Encuesta registrada con exito" : "La encuesta no se pudo registrar";
		
	break;

    case 'selectCurso':
		$rspta=$modelo->selectCurso();
        while ($r = mysqli_fetch_array($rspta)) {
            echo '<option value="'.$r['id_persona'].' "  >'.$r['nombres']. ' ' .$r['apellidos']. '</option>';

        }


        break;

    
        
    case 'rellenarDatos':
$rspta=$modelo->rellenarDatos($id_persona);
echo json_encode($rspta);
break;




	
}
?>
