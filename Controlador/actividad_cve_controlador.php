<?php 

session_start();

require_once "../Modelos/actividad_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$actividad=new Actividad();
$Id_objeto=110;
$usuario= $_SESSION['id_usuario'];

$id_actividad_voae=isset($_POST["id_actividad_voae"])? limpiarCadena($_POST["id_actividad_voae"]):"";
$no_solicitud=isset($_POST["no_solicitud"])? limpiarCadena($_POST["no_solicitud"]):"";
//$fch_solicitud=isset($_POST["fch_solicitud"])? limpiarCadena($_POST["fch_solicitud"]):"";
$nombre_actividad=isset($_POST["nombre_actividad"])? limpiarCadena($_POST["nombre_actividad"]):"";
$ubicacion=isset($_POST["ubicacion"])? limpiarCadena($_POST["ubicacion"]):"";
$fch_inicial_actividad=isset($_POST["fch_inicial_actividad"])? limpiarCadena($_POST["fch_inicial_actividad"]):"";
$fch_final_actividad=isset($_POST["fch_final_actividad"])? limpiarCadena($_POST["fch_final_actividad"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$poblacion_objetivo=isset($_POST["poblacion_objetivo"])? limpiarCadena($_POST["poblacion_objetivo"]):"";
$presupuesto=isset($_POST["presupuesto"])? limpiarCadena($_POST["presupuesto"]):"";
$staff_alumnos=isset($_POST["staff_alumnos"])? limpiarCadena($_POST["staff_alumnos"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
//$id_estado=isset($_POST["id_estado"])? limpiarCadena($_POST["id_estado"]):"";
//$id_usuario_registro=isset($_POST["id_usuario_registro"])? limpiarCadena($_POST["id_usuario_registro"]):"";
$id_ambito=isset($_POST["id_ambito"])? limpiarCadena($_POST["id_ambito"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_actividad_voae)){
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$actividad->insertar($no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$usuario,$id_ambito,$periodo);
				echo $rspta ? "actividad Registrado" : "actividad no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL actividad: "' . $nombre_actividad . '"');

			} else {
				
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
					echo $rspta ? "actividad Actualizado" : "El actividad no se pudo actualizar";

		} //FIN
	break;

	case 'solicitado':
		$rspta=$actividad->solicitado($id_actividad_voae);
 		echo $rspta ? "Actividad Enviada Para Aprobacion" : "No fue Posible Enviar la Actividad";

		 //SE EXTRAE EL NOMBRE DEL actividad A DESaprobar Y SE GUARDA EN UNA VARIABLE
 		//$valor = "select nombre_actividad, descripcion_actividad from tbl_voae_actividads where id_actividad_voae = '$id_actividad_voae'";
	    //$result_valor = $mysqli->query($valor);
	    //$bt_nombre_actividad = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE DESaprobar EL actividad
 		//bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DESACTIVO', 'EL actividad "' . $bt_nombre_actividad['nombre_actividad'] . '"');
	break;


	case 'denegar':
		$rspta=$actividad->denegar($id_actividad_voae);
 		echo $rspta ? "Actividad Denegada" : "El actividad no se puede Denegar";

		 //SE EXTRAE EL NOMBRE DEL actividad A DESaprobar Y SE GUARDA EN UNA VARIABLE
 		/*$valor = "select nombre_actividad, descripcion_actividad from tbl_voae_actividads where id_actividad_voae = '$id_actividad_voae'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_actividad = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE DESaprobar EL actividad
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DESACTIVO', 'EL actividad "' . $bt_nombre_actividad['nombre_actividad'] . '"');*/
	break;



	case 'aprobar':

		$rspta=$actividad->aprobar($id_actividad_voae);
 		echo $rspta ? "Actividad Aprobada" : "Actividad no se puede aprobar";

 		//SE EXTRAE EL NOMBRE DEL actividad A aprobar Y SE GUARDA EN UNA VARIABLE
 		/*$valor = "select nombre_actividad, descripcion_actividad from tbl_voae_actividads where id_actividad_voae = '$id_actividad_voae'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_actividad = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE aprobar EL actividad
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ACTIVO', 'EL actividad "' . $bt_nombre_actividad['nombre_actividad'] . '"');*/
	break;


case 'finalizar':
		$rspta=$actividad->finalizar($id_actividad_voae);
 		echo $rspta ? "Actividad Finalizada" : "Actividad no se puede finalizar la fecha es menor a la fecha de Finalizacion" ;

 		//SE EXTRAE EL NOMBRE DEL actividad A aprobar Y SE GUARDA EN UNA VARIABLE
 		/*$valor = "select nombre_actividad, descripcion_actividad from tbl_voae_actividads where id_actividad_voae = '$id_actividad_voae'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_actividad = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE aprobar EL actividad
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ACTIVO', 'EL actividad "' . $bt_nombre_actividad['nombre_actividad'] . '"');*/
	break;

	case 'mostrar':

		$rspta=$actividad->mostrar($id_actividad_voae);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'listar':
		$rspta=$actividad->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id_actividad_voae.')"><i class="far fa-edit"></i></button>'. 
 				'<button title="Enviar Solicitud" class="btn btn-success" onclick="solicitado('.$reg->id_actividad_voae.')"><i class="fa fa-solid fa-check"></i></button>',
 				"1"=>$reg->no_solicitud,
 				"2"=>$reg->fch_solicitud,
 				"3"=>$reg->nombre_actividad,
 				"4"=>$reg->usuario,
 				"5"=>$reg->periodo,
 				"6"=>$reg->id_estado
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listar1':
		$rspta=$actividad->listar1();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Ver Solicitud" class="btn btn-warning"onclick="mostrar('.$reg->id_actividad_voae.',1)"><i class="far fa-eye"></i></button>'.
 				'<button title="Aprobar Solicitud" class="btn btn-success"onclick="aprobar('.$reg->id_actividad_voae.')"><i class="fa fa-solid fa-check"></i></button>'.
 				'<button title="Denegar Solicitud " class="btn btn-danger pull-right"onclick="denegar('.$reg->id_actividad_voae.')"><i class="fa fa-arrow-circle-left"></i></button>',
 				"1"=>$reg->no_solicitud,
 				"2"=>$reg->fch_solicitud,
 				"3"=>$reg->nombre_actividad,
 				"4"=>$reg->usuario,
 				"5"=>$reg->periodo,
 				"6"=>$reg->id_estado
 				
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
		$rspta=$actividad->listar2();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-info" onclick="mostrar('.$reg->id_actividad_voae.',1)"><i class="far fa-eye"></i></button>'. 
 				'<button title="Finalizar Actividad" class="btn btn-danger" onclick="finalizar('.$reg->id_actividad_voae.')"><i class="fa fa-solid fa-check"></i></button>',
 				"1"=>$reg->no_solicitud,
 				"2"=>$reg->fch_solicitud,
 				"3"=>$reg->nombre_actividad,
 				"4"=>$reg->usuario,
 				"5"=>$reg->periodo,
 				"6"=>$reg->id_estado
 				
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

