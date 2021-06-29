<?php 
session_start();

require_once "../Modelos/repositorio_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');


$repositorio=new Repositorio();
$Id_objeto=107; 

$id_repositorio=isset($_POST["id_repositorio"])? limpiarCadena($_POST["id_repositorio"]):"";
$nombre_repositorio=isset($_POST["nombre_repositorio"])? limpiarCadena($_POST["nombre_repositorio"]):"";
$descripcion_repositorio=isset($_POST["descripcion_repositorio"])? limpiarCadena($_POST["descripcion_repositorio"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_repositorio)){
			$rspta=$repositorio->insertar($nombre_repositorio,$descripcion_repositorio);
			echo $rspta ? "Repositorio Registrado" : "Repositorio no se pudo registrar";
		}
		else {
			$rspta=$repositorio->editar($id_repositorio,$nombre_repositorio,$descripcion_repositorio);
			echo $rspta ? "Repositorio Actualizado" : "Repositorio no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$repositorio->desactivar($id_repositorio);
 		echo $rspta ? "Repositorio Desactivado" : "Repositorio no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$repositorio->activar($id_repositorio);
 		echo $rspta ? "Repositorio Activado" : "Repositorio no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$repositorio->mostrar($id_repositorio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
	if (permisos::permiso_modificar($Id_objeto)==0){
		$rspta=$repositorio->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" disabled="disabled" onclick=""><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre_repositorio,
 				"2"=>$reg->descripcion_repositorio,
 				"3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

 		}else{

 		$rspta=$repositorio->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_repositorio.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_repositorio.')"><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id_repositorio.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_repositorio.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre_repositorio,
 				"2"=>$reg->descripcion_repositorio,
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


