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
$Id_objeto=114; 

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
 		
		} //FIN
	break;
 	
	case 'insertar_horas':
		
		$rspta=$horas->insertar_horas($id_persona_alumno,$id_actividad,$horas_alumno);
 		echo $rspta ? "Horas Agregadas" : "Error: Actividad ya está agregada";
 		
	break;

	case 'eliminar':
	
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


