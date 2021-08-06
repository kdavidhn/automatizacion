<?php 
session_start();

require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once "../Modelos/tipos_faltas_modelo.php";
require_once ('../clases/funcion_bitacora.php');

$falta=new falta();
$Id_objeto=108; 

$id_falta=isset($_POST["id_falta"])? limpiarCadena($_POST["id_falta"]):"";
$nombre_falta=isset($_POST["nombre_falta"])? limpiarCadena($_POST["nombre_falta"]):"";
$descripcion_falta=isset($_POST["descripcion_falta"])? limpiarCadena($_POST["descripcion_falta"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_falta)){

			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste=("select count(nombre_falta) as nombre_falta  from tbl_voae_tipos_faltas where nombre_falta='$nombre_falta'");

			//OBTENER LA ULTIMA FILA DEL QUERY
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			//CONDICION PARA QUE NO SE REPITA EL NOMBRE
			if ($existe['nombre_falta']== 1) {
				echo 'EL NOMBRE DEL TIPO DE FALTA YA EXISTE, INGRESE UN NOMBRE DIFERENTE';

			} else {
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$falta->insertar($nombre_falta,$descripcion_falta);
				echo $rspta ? "Tipo de falta Registrado" : "El TIPO de FALTA  no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL TIPO DE FALTA "' . $nombre_falta . '"');
			}

		} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(nombre_falta) as nombre_falta from tbl_voae_tipos_faltas where nombre_falta='$nombre_falta' and id_falta<>'$id_falta' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['nombre_falta'] == 1) {
				echo 'EL TIPO DE FALTA YA EXISTE, INGRESE DIFERENTE NOMBRE';

			} else {
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select nombre_falta, descripcion_falta from tbl_voae_tipos_faltas WHERE id_falta= '$id_falta'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DEL NOMBRE Y LA DESCRIPCION
				if ($valor_viejo['nombre_falta'] <> $nombre_falta and $valor_viejo['descripcion_falta'] <> $descripcion_falta) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NOMBRE DE FALTA "' . $valor_viejo['nombre_falta'] . '" POR "' . $nombre_falta . '" Y LA DESCRIPCION DEL TIPO DE FALTA ');
					$rspta=$falta->editar($id_falta,$nombre_falta,$descripcion_falta);
					echo $rspta ? "El TIPO de FALTA fue actualizado" : "EL TIPO de FALTA no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DEL NOMBRE DEL TIPO DE FALTA
				} elseif ($valor_viejo['nombre_falta'] <> $nombre_falta) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NOMBRE DEL TIPO DE FALTA "' . $valor_viejo['nombre_falta'] . '" POR "' . $nombre_falta . '" ');
					$rspta=$falta->editar($id_falta,$nombre_falta,$descripcion_falta);
					echo $rspta ? "El TIPO de FALTA fue actualizado" : "EL TIPO de FALTA no se pudo actualizar";

					//CONDICION PARA LA MODIFICACION DE LA DESCRIPCION DEL TIPO DE FALTA

				} elseif ($valor_viejo['descripcion_falta'] <> $descripcion_falta) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL TIPO DE FALTA  "' . $nombre_falta . '" ');
				$rspta=$falta->editar($id_falta,$nombre_falta,$descripcion_falta);
				echo $rspta ? "El TIPO de FALTA fue actualizado" : "EL TIPO de FALTA no se pudo actualizar";
				}
			}
		} //FIN
	break;


	case 'desactivar':
		$rspta=$falta->desactivar($id_falta);
 		echo $rspta ? "FALTA DESCATIVADA" : "EL TIPO DE FALTA no se puede desactivar";

		 //SE EXTRAE EL NOMBRE DEL TIPO DE FALTA A DESACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_falta, descripcion_falta from tbl_voae_tipos_faltas where id_falta = '$id_falta'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_falta = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE DESACTIVAR EL TIPO DE FALTA
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DESACTIVO', 'EL TIPO DE FALTA "' . $bt_nombre_falta['nombre_falta'] . '"');
	break;



	case 'activar':
		$rspta=$falta->activar($id_falta);
 		echo $rspta ? "FALTA ACTIVADA" : "El TIPO de FALTA  no se puede activar";

 		//SE EXTRAE EL NOMBRE DEL TIPO DE FALTA A ACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_falta, descripcion_falta from tbl_voae_tipos_faltas where id_falta = '$id_falta'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_falta = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL TIPO DE FALTA
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ACTIVO', 'EL TIPO DE FALTA "' . $bt_nombre_falta['nombre_falta'] . '"');
	break;

	case 'eliminar':
		//SE EXTRAE EL NOMBRE DEL TIPO DE FALTA A ACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_falta, descripcion_falta from tbl_voae_tipos_faltas where id_falta = '$id_falta'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_falta = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL TIPO DE FALTA
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'EL TIPO DE FALTA "' . $bt_nombre_falta['nombre_falta'] . '"');
		$rspta=$falta->eliminar($id_falta);
 		echo $rspta ? "FALTA ELIMINADA" : "El TIPO de FALTA  no se puede activar";

 		
	break;


	case 'mostrar':

		$rspta=$falta->mostrar($id_falta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listar':
	if (permisos::permiso_eliminar($Id_objeto)==1 and permisos::permiso_modificar($Id_objeto)==1){
		$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_falta.')"><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_falta.')"><i class="fa fa-check"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_falta.')"><i class="fas fa-trash-alt"></i></button>',
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

 		}elseif (permisos::permiso_eliminar($Id_objeto)==0 and permisos::permiso_modificar($Id_objeto)==0){
 			$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" disabled="disabled" onclick=""><i class="fa fa-check"></i></button>'.
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fas fa-trash-alt"></i></button>',
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
 		}elseif (permisos::permiso_modificar($Id_objeto)==0){
 			$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" disabled onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" disabled onclick="desactivar('.$reg->id_falta.')"><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" disabled onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" disabled onclick="activar('.$reg->id_falta.')"><i class="fa fa-check"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_falta.')"><i class="fas fa-trash-alt"></i></button>',
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

 			}elseif (permisos::permiso_eliminar($Id_objeto)==0){
 				$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_falta.')"><i class="fa fa-window-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->id_falta.')"><i class="fa fa-check"></i></button>'.
 					' <button class="btn btn-danger" disabled onclick="eliminar('.$reg->id_falta.')"><i class="fas fa-trash-alt"></i></button>',
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


