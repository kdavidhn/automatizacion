<?php 

session_start();

require_once "../Modelos/Estado_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$estado=new Estado();
$Id_objeto=106; 

$id_estado=isset($_POST["id_estado"])? limpiarCadena($_POST["id_estado"]):"";
$nombre_estado=isset($_POST["nombre_estado"])? limpiarCadena($_POST["nombre_estado"]):"";
$descripcion_estado=isset($_POST["descripcion_estado"])? limpiarCadena($_POST["descripcion_estado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_estado)){

			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste=("select count(nombre_estado) as nombre_estado  from tbl_voae_estados where nombre_estado='$nombre_estado'");

			//OBTENER LA ULTIMA FILA DEL QUERY
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			//CONDICION PARA QUE NO SE REPITA EL NOMBRE
			if ($existe['nombre_estado']== 1) {
				echo 'EL NOMBRE DE ESTADO YA EXISTE, INGRESE UN DIFERENTE NOMBRE';

			} else {
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$estado->insertar($nombre_estado,$descripcion_estado);
				echo $rspta ? "Estado Registrado" : "Estado no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL ESTADO "' . $nombre_estado . '"');
			}

		} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(nombre_estado) as nombre_estado from tbl_voae_estados where nombre_estado='$nombre_estado' and id_estado<>'$id_estado' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['nombre_estado'] == 1) {
				echo 'EL Estado YA EXISTE, INGRESE DIFERENTE NOMBRE';

			} else {
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select nombre_estado, descripcion_estado from tbl_voae_estados WHERE id_estado= '$id_estado'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DEL NOMBRE Y LA DESCRIPCION
				if ($valor_viejo['nombre_estado'] <> $nombre_estado and $valor_viejo['descripcion_estado'] <> $descripcion_estado) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NOMBRE DE ESTADO "' . $valor_viejo['nombre_estado'] . '" POR "' . $nombre_estado . '" Y LA DESCRIPCION DEL ESTADO A"' . $descripcion_estado . '" ');
					$rspta=$estado->editar($id_estado,$nombre_estado,$descripcion_estado);
					echo $rspta ? "Estado Actualizado" : "El Estado no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DEL NOMBRE DEL ESTADO
				} elseif ($valor_viejo['nombre_estado'] <> $nombre_estado) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NOMBRE DEL ESTADO "' . $valor_viejo['nombre_estado'] . '" POR "' . $nombre_estado . '" ');
					$rspta=$estado->editar($id_estado,$nombre_estado,$descripcion_estado);
					echo $rspta ? "Estado Actualizado" : "El Estado no se pudo actualizar";

					//CONDICION PARA LA MODIFICACION DE LA DESCRIPCION DEL estado

				} elseif ($valor_viejo['descripcion_estado'] <> $descripcion_estado) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL ESTADO "' . $descripcion_estado . '" ');
				$rspta=$estado->editar($id_estado,$nombre_estado,$descripcion_estado);
				echo $rspta ? "Estado Actualizado" : "El Estado no se pudo actualizar";
				}
			}
		} //FIN
	break;


	case 'desactivar':
		$rspta=$estado->desactivar($id_estado);
 		echo $rspta ? "Estado Desactivado" : "El estado no se puede desactivar";

		 //SE EXTRAE EL NOMBRE DEL ESTADO A DESACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_estado, descripcion_estado from tbl_voae_estados where id_estado = '$id_estado'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_estado = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE DESACTIVAR EL ESTADO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DESACTIVO', 'EL ESTADO "' . $bt_nombre_estado['nombre_estado'] . '"');
	break;



	case 'activar':
		$rspta=$estado->activar($id_estado);
 		echo $rspta ? "Estado Activado" : "Estado no se puede activar";

 		//SE EXTRAE EL NOMBRE DEL ESTADO A ACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_estado, descripcion_estado from tbl_voae_estados where id_estado = '$id_estado'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_estado = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL ESTADO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ACTIVO', 'EL ESTADO "' . $bt_nombre_estado['nombre_estado'] . '"');
	break;



	case 'mostrar':

		$rspta=$estado->mostrar($id_estado);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listar':
	//SE CREA UNA CONDICION PARA VERIFICAR SI TIENE PERMISO DE MODIFICAR
	if (permisos::permiso_modificar($Id_objeto)==0){
		$rspta=$estado->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" disabled="disabled" onclick=""><i class="fa fa-check"></i></button>',
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

 	}else{

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
	}
break;
}
?>

