<?php
require_once "../Modelos/unica_visita_modelo.php";

$modelo=new unica_visita();

$numero_cuenta=isset($_POST["cuenta_uv"])? $_POST["cuenta_uv"]:"";
$funciones=isset($_POST["funciones_analisis_uv"])?$_POST["funciones_analisis_uv"]:"";
$funciones_diseno=isset($_POST["funciones_diseno_uv"])?$_POST["funciones_diseno_uv"]:"";
$funciones_redes=isset($_POST["funciones_redes_uv"])?$_POST["funciones_redes_uv"]:"";
$funciones_capacitacion=isset($_POST["funciones_capacitacion_uv"])?$_POST["funciones_capacitacion_uv"]:"";
$funciones_seguridad=isset($_POST["funciones_seguridad_uv"])?$_POST["funciones_seguridad_uv"]:"";
$funciones_auditoria=isset($_POST["funciones_auditoria_uv"])?$_POST["funciones_auditoria_uv"]:"";
$funciones_base=isset($_POST["funciones_base_uv"])?$_POST["funciones_base_uv"]:"";
$funciones_soporte=isset($_POST["funciones_soporte_uv"])?$_POST["funciones_soporte_uv"]:"";
$funciones_programacion=isset($_POST["funciones_programacion_uv"])?$_POST["funciones_programacion_uv"]:"";
$comunicacion=isset($_POST["comunicacion_uv"])?$_POST["comunicacion_uv"]:"";
$puntualidad=isset($_POST["puntualidad_uv"])?$_POST["puntualidad_uv"]:"";
$responsabilidad=isset($_POST["responsabilidad_uv"])? $_POST["responsabilidad_uv"]:"";
$creatividad=isset($_POST["creatividad_uv"])?$_POST["creatividad_uv"]:"";
$presentacion=isset($_POST["presentacion_uv"])? $_POST["presentacion_uv"]:"";
$atencion=isset($_POST["atencion_uv"])? $_POST["atencion_uv"]:"";
$colaborativo=isset($_POST["colaborativo_uv"])? $_POST["colaborativo_uv"]:"";
$trabajo_equipo=isset($_POST["trabajo_equipo_uv"])? $_POST["trabajo_equipo_uv"]:"";
$proactivo=isset($_POST["proactivo_iniciativa_uv"])? $_POST["proactivo_iniciativa_uv"]:"";
$relaciones=isset($_POST["relaciones_uv"])? $_POST["relaciones_uv"]:"";
$analisis=isset($_POST["analisis_uv"])? $_POST["analisis_uv"]:"";
$diseno=isset($_POST["diseno_uv"])? $_POST["diseno_uv"]:"";
$programador=isset($_POST["programador_uv"])? $_POST["programador_uv"]:"";
$mantenimiento=isset($_POST["mantenimiento_uv"])? $_POST["mantenimiento_uv"]:"";
$aspecto_a=isset($_POST["aspectos_auditoria_uv"])? $_POST["aspectos_auditoria_uv"]:"";
$aspecto_s=isset($_POST["aspectos_seguridad_uv"])? $_POST["aspectos_seguridad_uv"]:"";
$asistencia=isset($_POST["asistencia_uv"])? $_POST["asistencia_uv"]:"";
$horario=isset($_POST["horarios_uv"])? $_POST["horarios_uv"]:"";
$adaptacion=isset($_POST["adaptacion_uv"])? $_POST["adaptacion_uv"]:"";
$cumplimiento=isset($_POST["cumplimiento_uv"])? $_POST["cumplimiento_uv"]:"";
$calidad=isset($_POST["calidad_uv"])? $_POST["calidad_uv"]:"";
$percepcion_conocimiento=isset($_POST["percepcion_conocimientos_uv"])? $_POST["percepcion_conocimientos_uv"]:"";
$percepcion_habilidad=isset($_POST["percepcion_habilidades_uv"])? $_POST["percepcion_habilidades_uv"]:"";
$comentario=isset($_POST["comentarios_uv"])? $_POST["comentarios_uv"]:"";
$area_refuerzo=isset($_POST["areas_refuerzo_uv"])?$_POST["areas_refuerzo_uv"]:"";
$calificacion=isset($_POST["calificacion_uv"])? $_POST["calificacion_uv"]:"";
$solicitar=isset($_POST["solicitar_practicante_uv"])? $_POST["solicitar_practicante_uv"]:"";
$representante=isset($_POST["representante_uv"])? $_POST["representante_uv"]:"";
$lugar=isset($_POST["lugar_uv"])? $_POST["lugar_uv"]:"";
$oportunidad=isset($_POST["oportunidad_empleo_uv"])? $_POST["oportunidad_empleo_uv"]:"";
$id_persona=isset($_POST["id_persona"])? ($_POST["id_persona"]):"";









switch ($_GET["op"]){
	case 'guardar':
		
            $rspta=$modelo->insertar($numero_cuenta,$funciones,$funciones_diseno,$funciones_redes,$funciones_capacitacion,$funciones_seguridad
                                    ,$funciones_auditoria,$funciones_base,$funciones_soporte,$funciones_programacion,$comunicacion,$oportunidad
                                    ,$puntualidad,$responsabilidad,$creatividad,$presentacion,$atencion,$colaborativo,$trabajo_equipo
                                    ,$proactivo,$relaciones,$analisis,$diseno,$programador,$mantenimiento,$asistencia,$horario,$adaptacion
                                    ,$cumplimiento,$calidad,$percepcion_conocimiento,$percepcion_habilidad,$comentario,$area_refuerzo
                                    ,$calificacion,$solicitar,$representante,$lugar,$aspecto_a,$aspecto_s);
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
