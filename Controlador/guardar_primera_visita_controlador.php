<?php
require_once "../Modelos/primera_visita_modelo.php";

$modelo=new primera_visita();


$numero_cuenta=isset($_POST["cuenta_pv"])? ($_POST["cuenta_pv"]):"";
$funciones=isset($_POST["funciones_analisis_pv"])?$_POST["funciones_analisis_pv"]:"";
$funciones_diseno=isset($_POST["funciones_diseno_pv"])?$_POST["funciones_diseno_pv"]:"";
$funciones_redes=isset($_POST["funciones_redes_pv"])?$_POST["funciones_redes_pv"]:"";
$funciones_capacitacion=isset($_POST["funciones_capacitacion_pv"])?$_POST["funciones_capacitacion_pv"]:"";
$funciones_seguridad=isset($_POST["funciones_seguridad_pv"])?$_POST["funciones_seguridad_pv"]:"";
$funciones_auditoria=isset($_POST["funciones_auditoria_pv"])?$_POST["funciones_auditoria_pv"]:"";
$funciones_base=isset($_POST["funciones_base_pv"])?$_POST["funciones_base_pv"]:"";
$funciones_soporte=isset($_POST["funciones_soporte_pv"])?$_POST["funciones_soporte_pv"]:"";
$funciones_programacion=isset($_POST["funciones_programacion_pv"])?$_POST["funciones_programacion_pv"]:"";
$comunicacion=isset($_POST["comunicacion_pv"])? ($_POST["comunicacion_pv"]):"";
$puntualidad=isset($_POST["puntualidad_pv"])? ($_POST["puntualidad_pv"]):"";
$responsabilidad=isset($_POST["responsabilidad_pv"])? ($_POST["responsabilidad_pv"]):"";
$creatividad=isset($_POST["creatividad_pv"])? ($_POST["creatividad_pv"]):"";
$presentacion=isset($_POST["presentacion_pv"])? ($_POST["presentacion_pv"]):"";
$atencion=isset($_POST["atencion_pv"])? ($_POST["atencion_pv"]):"";
$colaborativo=isset($_POST["colaborativo_pv"])? ($_POST["colaborativo_pv"]):"";
$trabajo_equipo=isset($_POST["trabajo_equipo_pv"])? ($_POST["trabajo_equipo_pv"]):"";
$proactivo=isset($_POST["proactivo_iniciativa_pv"])? ($_POST["proactivo_iniciativa_pv"]):"";
$relaciones=isset($_POST["relaciones_pv"])? ($_POST["relaciones_pv"]):"";
$analisis=isset($_POST["analisis_pv"])? ($_POST["analisis_pv"]):"";
$diseno=isset($_POST["diseno_pv"])? ($_POST["diseno_pv"]):"";
$programador=isset($_POST["programador_pv"])? ($_POST["programador_pv"]):"";
$mantenimiento=isset($_POST["mantenimiento_pv"])? ($_POST["mantenimiento_pv"]):"";
$aspecto_a=isset($_POST["aspectos_auditoria_pv"])? ($_POST["aspectos_auditoria_pv"]):"";
$aspecto_s=isset($_POST["aspectos_seguridad_pv"])? ($_POST["aspectos_seguridad_pv"]):"";
$comentario=isset($_POST["comentarios_pv"])? ($_POST["comentarios_pv"]):"";
$calificacion=isset($_POST["calificacion_uv"])? ($_POST["calificacion_uv"]):"";
$solicitar=isset($_POST["solicitar_practicante_pv"])? ($_POST["solicitar_practicante_pv"]):"";
$representante=isset($_POST["representante_pv"])? ($_POST["representante_pv"]):"";
$lugar=isset($_POST["lugar_pv"])? ($_POST["lugar_pv"]):"";
$fecha=isset($_POST["fecha_pv"])? ($_POST["fecha_pv"]):"";
$id_primera_visita=isset($_POST["id_primera_visita"])? ($_POST["id_primera_visita"]):"";
$id_persona=isset($_POST["id_persona"])? ($_POST["id_persona"]):"";




$prueba="selectCurso";



switch ($_GET["op"]){
	case 'guardar':
		
            $rspta=$modelo->insertar($numero_cuenta,$funciones,$funciones_diseno,$funciones_redes,$funciones_capacitacion,$funciones_seguridad
                                   ,$funciones_auditoria,$funciones_base,$funciones_soporte,$funciones_programacion,$comunicacion
                                    ,$puntualidad,$responsabilidad,$creatividad,$presentacion,$atencion,$colaborativo,$trabajo_equipo
                                    ,$proactivo,$relaciones,$analisis,$diseno,$programador,$mantenimiento,$comentario
                                    ,$calificacion,$solicitar,$representante,$lugar,$fecha,$aspecto_a,$aspecto_s);
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
