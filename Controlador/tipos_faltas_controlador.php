<?php 
session_start();

require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once "../Modelos/tipos_faltas_modelo.php";

$falta=new falta();
$Id_objeto=108; 

$id_falta=isset($_POST["id_falta"])? limpiarCadena($_POST["id_falta"]):"";
$nombre_falta=isset($_POST["nombre_falta"])? limpiarCadena($_POST["nombre_falta"]):"";
$descripcion_falta=isset($_POST["descripcion_falta"])? limpiarCadena($_POST["descripcion_falta"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_falta)){
			$rspta=$falta->insertar($nombre_falta,$descripcion_falta);
			echo $rspta ? "Falta Registrada" : "Falta no se pudo registrar";
		}
		else {
			$rspta=$falta->editar($id_falta,$nombre_falta,$descripcion_falta);
			echo $rspta ? "Falta Actualizada" : "Falta no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$falta->desactivar($id_falta);
 		echo $rspta ? "Falta Desactivada" : "Falta no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$falta->activar($id_falta);
 		echo $rspta ? "Falta Activada" : "Falta no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$falta->mostrar($id_falta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
	if (permisos::permiso_modificar($Id_objeto)==0){
		$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" disabled="disabled" onclick=""><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre_falta,
 				"2"=>$reg->descripcion_falta,
 				"3"=>($reg->condicion)?'<span class="label bg-green">ACTIVADO</span>':
 				'<span class="label bg-red">DESACTIVADO</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
 		}else{
 			$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_falta.')"><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_falta.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre_falta,
 				"2"=>$reg->descripcion_falta,
 				"3"=>($reg->condicion)?'<span class="label bg-green">ACTIVADO</span>':
 				'<span class="label bg-red">DESACTIVADO</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
 		}
	break;
}
?>


