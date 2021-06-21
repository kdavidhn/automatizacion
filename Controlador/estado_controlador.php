<?php 
require_once "../Modelos/Estado_modelo.php";

$estado=new Estado();

$id_estado=isset($_POST["id_estado"])? limpiarCadena($_POST["id_estado"]):"";
$nombre_estado=isset($_POST["nombre_estado"])? limpiarCadena($_POST["nombre_estado"]):"";
$descripcion_estado=isset($_POST["descripcion_estado"])? limpiarCadena($_POST["descripcion_estado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_estado)){
			$rspta=$estado->insertar($nombre_estado,$descripcion_estado);
			echo $rspta ? "Estado Registrado" : "Estado no se pudo registrar";
		}
		else {
			$rspta=$estado->editar($id_estado,$nombre_estado,$descripcion_estado);
			echo $rspta ? "Estado actualizado" : "Estado no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$estado->desactivar($id_estado);
 		echo $rspta ? "Estado Desactivado" : "Estado no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$estado->activar($id_estado);
 		echo $rspta ? "Estado Activado" : "Estado no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$estado->mostrar($id_estado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$estado->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_estado.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_estado.')"><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id_estado.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_estado.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre_estado,
 				"2"=>$reg->descripcion_estado,
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

	break;
}
?>

