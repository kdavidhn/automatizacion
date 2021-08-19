<?php 
ob_start();
session_start();

require_once "../Modelos/horas_voae_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');


$horas=new Horas();
$Id_objeto=228; 

$id_actividad_voae=isset($_POST["id_actividad_voae"])? limpiarCadena($_POST["id_actividad_voae"]):"";
$id_asistencia=isset($_POST["id_asistencia"])? limpiarCadena($_POST["id_asistencia"]):"";
$nombre_act=isset($_POST["nombre_act"])? limpiarCadena($_POST["nombre_act"]):"";
$ubicacion=isset($_POST["ubicacion"])? limpiarCadena($_POST["ubicacion"]):"";
$fecha_inicio=isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
$fecha_final=isset($_POST["fecha_final"])? limpiarCadena($_POST["fecha_final"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$observaciones="Actividad Externa";
$horas_voae=isset($_POST["horas_voae"])? limpiarCadena($_POST["horas_voae"]):"";
$ambito=isset($_POST["ambito"])? limpiarCadena($_POST["ambito"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";
 
//FORMULARIO 2
$id_persona_alumno=isset($_POST["id_persona_alumno"])? limpiarCadena($_POST["id_persona_alumno"]):"";
$id_actividad=isset($_POST["id_actividad"])? limpiarCadena($_POST["id_actividad"]):"";
$horas_alumno=isset($_POST["horas_alumno"])? limpiarCadena($_POST["horas_alumno"]):"";

$usuario=$_SESSION['id_usuario'];

switch ($_GET["op"]){
case 'guardaryeditar':
		if (empty($id_actividad_voae)){

			
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$horas->insertar($nombre_act,$ubicacion,$fecha_inicio,$fecha_final,$descripcion,$observaciones,$usuario,$ambito,$periodo);
 		echo $rspta ? "Actividad Registrada" : "Error Fechas";
 		 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'LA ACTIVIDAD: ' . $nombre_act . '');
		} //FIN
	break;
 	
	case 'insertar_horas':
		$valor = "select concat(nombres,' ',apellidos) as nombre from tbl_personas WHERE id_persona= '$id_persona_alumno'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

		$sql = "select nombre_actividad from tbl_voae_actividades WHERE id_actividad_voae= '$id_actividad'";
				$resultado = $mysqli->query($sql);
				$actividad = $resultado->fetch_array(MYSQLI_ASSOC);
		$rspta=$horas->insertar_horas($id_persona_alumno,$id_actividad,$horas_alumno);
 		echo $rspta ? "Horas Agregadas" : "Error: Actividad ya está agregada";
 		 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'HORAS VOAE AL ALUMNO: ' . $valor_viejo['nombre'] . ', LA CANTIDAD DE: '. $horas_alumno . ' HORAS, DE LA ACTIVIDAD: '. $actividad['nombre_actividad'] . '');
	break;

	case 'eliminar':
		$valor = "select tbl_voae_asistencias.id_asistencia,tbl_voae_asistencias.nombre_alumno,tbl_voae_asistencias.cuenta, tbl_voae_actividades.nombre_actividad from tbl_voae_asistencias JOIN tbl_voae_actividades on tbl_voae_asistencias.id_actividad_voae = tbl_voae_actividades.id_actividad_voae where tbl_voae_asistencias.id_asistencia = '$id_asistencia'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_ambito = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL AMBITO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'LA ACTIVIDAD: ' . $bt_nombre_ambito['nombre_actividad'] . ', DEL ALUMNO: '. $bt_nombre_ambito['nombre_alumno'] . ', CON CUENTA: '. $bt_nombre_ambito['cuenta'] . '');
		$rspta=$horas->eliminar($id_asistencia);
 		echo $rspta ? "Registro Eliminado" : "Error";
 		

	break;



	case 'listar':


	   
 		$rspta=$horas->listar();
 		//Vamos a declarar un array
 		$data= Array();


 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<form action="../vistas/horas_voae_alumno_cve_vista.php" method="POST">

                        <input type="hidden" name="cuenta" value="'.$reg->cuenta.'">
                        <input type="hidden" name="nombre" value="'.$reg->nombre_alumno.'">
                        <button title="Ver Actividades" class="btn btn-primary" type="submit" ><i class="fas fa-chalkboard-teacher"></i></button>
                       </form>',
 				"1"=>$reg->nombre_alumno,
 				"2"=>$reg->cuenta,
 				"3"=>$reg->total_actividades,
 				"4"=>$reg->total_horas
 			);
 		}

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
 		
break;

	case 'listar2':
		
 		$rspta=$horas->listar2($cuenta);
 		//Vamos a declarar un array
 		$data= Array();


 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Eliminar Actividad" class="btn btn-danger" onclick="eliminar('.$reg->id_asistencia.')"><i class="fas fa-trash-alt"></i></button>',
 				"1"=>$reg->nombre_actividad,
 				"2"=>$reg->fch_inicial_actividad,
 				"3"=>$reg->ambito,
 				"4"=>$reg->cant_horas
 			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
 		
break;
}
ob_end_flush();
?>


