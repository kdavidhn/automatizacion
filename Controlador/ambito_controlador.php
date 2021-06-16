<?php 
require_once "../Modelos/Ambito_modelo.php";

$ambito=new Ambito();

$id_ambito=isset($_POST["id_ambito"])? limpiarCadena($_POST["id_ambito"]):"";
$nombre_ambito=isset($_POST["nombre_ambito"])? limpiarCadena($_POST["nombre_ambito"]):"";
$descripcion_ambito=isset($_POST["descripcion_ambito"])? limpiarCadena($_POST["descripcion_ambito"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_ambito)){
			$rspta=$ambito->insertar($nombre_ambito,$descripcion_ambito);
			echo $rspta ? "Ambito registrado" : "Ambito no se pudo registrar";
		}
		else {
			$rspta=$ambito->editar($id_ambito,$nombre_ambito,$descripcion_ambito);
			echo $rspta ? "Ambito actualizado" : "Ambito no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$ambito->desactivar($id_ambito);
 		echo $rspta ? "ambito Desactivado" : "ambito no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$ambito->activar($id_ambito);
 		echo $rspta ? "Ambito activado" : "Ambito no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$ambito->mostrar($id_ambito);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$ambito->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_ambito.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_ambito.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id_ambito.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_ambito.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre_ambito,
 				"2"=>$reg->descripcion_ambito,
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

	break;
}
?>


