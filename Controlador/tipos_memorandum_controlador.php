<?php 
session_start();

require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once "../Modelos/tipos_memorandum_modelo.php";
require_once ('../clases/funcion_bitacora.php');

$memorandum=new memorandum();
$Id_objeto=120; 

$id_tipo_memorandum=isset($_POST["id_tipo_memorandum"])? limpiarCadena($_POST["id_tipo_memorandum"]):"";
$nombre_tipo_memorandum=isset($_POST["nombre_tipo_memorandum"])? limpiarCadena($_POST["nombre_tipo_memorandum"]):"";
$descripcion_memorandum=isset($_POST["descripcion_memorandum"])? limpiarCadena($_POST["descripcion_memorandum"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_tipo_memorandum)){

			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste=("select count(nombre_tipo_memorandum) as nombre_tipo_memorandum  from tbl_voae_tipo_memorandum where nombre_tipo_memorandum='$nombre_tipo_memorandum'");

			//OBTENER LA ULTIMA FILA DEL QUERY
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			//CONDICION PARA QUE NO SE REPITA EL NOMBRE
			if ($existe['nombre_tipo_memorandum']== 1) {
				echo 'EL NOMBRE DEL TIPO DE MEMORANDUM YA EXISTE, INGRESE UN NOMBRE DIFERENTE';

			} else {
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$memorandum->insertar($nombre_tipo_memorandum,$descripcion_memorandum);
				echo $rspta ? "TIPO DE MEMORANDUM REGUISTRADO" : "EL TIPO DE MEMORANDUM NO SE PUEDE REGISTRAR";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL TIPO DE memorandum "' . $nombre_tipo_memorandum . '"');
			}

		} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(nombre_tipo_memorandum) as nombre_tipo_memorandum from tbl_voae_tipo_memorandum where nombre_tipo_memorandum='$nombre_tipo_memorandum' and id_tipo_memorandum<>'$id_tipo_memorandum' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['nombre_tipo_memorandum'] == 1) {
				echo 'EL TIPO DE MEMORANDUM YA EXISTE, INGRESE DIFERENTE NOMBRE';

			} else {
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select id_tipo_memorandum, nombre_tipo_memorandum, descripcion_memorandum from tbl_voae_tipo_memorandum WHERE id_tipo_memorandum= '$id_tipo_memorandum'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DEL NOMBRE Y LA DESCRIPCION
				if ($valor_viejo['nombre_tipo_memorandum'] <> $nombre_tipo_memorandum and $valor_viejo['descripcion_memorandum'] <> $descripcion_memorandum) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NOMBRE DE MEMORANDUM "' . $valor_viejo['nombre_tipo_memorandum'] . '" POR "' . $nombre_tipo_memorandum . '" Y LA DESCRIPCION DEL TIPO DE memorandum "'. $valor_viejo['descripcion_memorandum'] . '"POR"' . $descripcion_memorandum);
					$rspta=$memorandum->editar($id_tipo_memorandum,$nombre_tipo_memorandum,$descripcion_memorandum);
					echo $rspta ? "El TIPO DE MEMORANDUM FUE ACTUALIZADO" : "EL TIPO DE MEMORANDUM NO SE PUEDE ACTUALIZAR";

				//CONDICION PARA LA MODIFICACION DEL NOMBRE DEL TIPO DE MEMORANDUM
				} elseif ($valor_viejo['nombre_tipo_memorandum'] <> $nombre_tipo_memorandum) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NOMBRE DEL TIPO DE MEMORANDUM "' . $valor_viejo['nombre_tipo_memorandum'] . '" POR "' . $nombre_tipo_memorandum . '" ');

					$rspta=$memorandum->editar($id_tipo_memorandum,$nombre_tipo_memorandum,$descripcion_memorandum);
					echo $rspta ? "El TIPO DE MEMORANDUM FUE ACTUALIZADO" : "EL TIPO DE MEMORANDUM NO SE PUEDE ACTUALIZAR";


			    //CONDICION PARA LA MODIFICACION DE LA DESCRIPCION DEL TIPO DE MEMORANDUM
				} elseif ($valor_viejo['descripcion_memorandum'] <> $descripcion_memorandum) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL TIPO DE MEMORANDUM  "' .$valor_viejo['descripcion_memorandum'] . '"POR"' .$nombre_tipo_memorandum . '" ');
				$rspta=$memorandum->editar($id_tipo_memorandum,$nombre_tipo_memorandum,$descripcion_memorandum);
				echo $rspta ? "El TIPO de memorandum fue actualizado" : "EL TIPO de memorandum no se pudo actualizar";
				}
			}
		} //FIN
	break;


	case 'desactivar':
		$rspta=$memorandum->desactivar($id_tipo_memorandum);
 		echo $rspta ? "El TIPO DE MEMORANDUM  DESACTIVADO" : "EL TIPO DE MEMORANDUM NO SE PUEDE DESACTIVAR";

		 //SE EXTRAE EL NOMBRE DEL TIPO DE memorandum A DESACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_tipo_memorandum, descripcion_memorandum from tbl_voae_tipo_memorandum where id_tipo_memorandum = '$id_tipo_memorandum'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_tipo_memorandum = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE DESACTIVAR EL TIPO DE memorandum
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DESACTIVO', 'EL TIPO DE MEMORANDUM "' . $bt_nombre_tipo_memorandum['nombre_tipo_memorandum'] . '"');
	break;



	case 'activar':
		$rspta=$memorandum->activar($id_tipo_memorandum);
 		echo $rspta ? "El TIPO DE MEMORANDUM ACTIVADO" : "El TIPO DE MEMORANDUM NO SE PUEDE ACTIVAR";

 		//SE EXTRAE EL NOMBRE DEL TIPO DE memorandum A ACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_tipo_memorandum, descripcion_memorandum from tbl_voae_tipo_memorandum where id_tipo_memorandum = '$id_tipo_memorandum'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_tipo_memorandum = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL TIPO DE memorandum
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ACTIVO', 'EL TIPO DE MEMORANDUM "' . $bt_nombre_tipo_memorandum['nombre_tipo_memorandum'] . '"');
	break;



	case 'mostrar':

		$rspta=$memorandum->mostrar($id_tipo_memorandum);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listar':
	if (permisos::permiso_modificar($Id_objeto)==1 and permisos::permiso_eliminar($Id_objeto)==1){
		$rspta=$memorandum->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				' <button class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_tipo_memorandum.')"><i class="fa fa-window-close"></i></button>':
					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_tipo_memorandum.')"><i class="fas fa-trash-alt"></i></button>'.
					' <button class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-primary" onclick="activar('.$reg->id_tipo_memorandum.')"><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_tipo_memorandum,
 				"2"=>$reg->descripcion_memorandum,
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

   		}elseif (permisos::permiso_modificar($Id_objeto)==0 and permisos::permiso_eliminar($Id_objeto)==0){
   			$rspta=$memorandum->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				' <button class="btn btn-warning" disabled onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button disabled class="btn btn-danger" onclick="desactivar('.$reg->id_tipo_memorandum.')"><i class="fa fa-window-close"></i></button>':
					' <button disabled class="btn btn-danger" onclick="eliminar('.$reg->id_tipo_memorandum.')"><i class="fas fa-trash-alt"></i></button>'.
					' <button disabled class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button disabled class="btn btn-primary" onclick="activar('.$reg->id_tipo_memorandum.')"><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_tipo_memorandum,
 				"2"=>$reg->descripcion_memorandum,
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
 			$rspta=$memorandum->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				' <button class="btn btn-warning" disabled onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button disabled class="btn btn-danger" onclick="desactivar('.$reg->id_tipo_memorandum.')"><i class="fa fa-window-close"></i></button>':
					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_tipo_memorandum.')"><i class="fas fa-trash-alt"></i></button>'.
					' <button disabled class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button disabled class="btn btn-primary" onclick="activar('.$reg->id_tipo_memorandum.')"><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_tipo_memorandum,
 				"2"=>$reg->descripcion_memorandum,
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
 			$rspta=$memorandum->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				' <button class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_tipo_memorandum.')"><i class="fa fa-window-close"></i></button>':
					' <button disabled class="btn btn-danger" onclick="eliminar('.$reg->id_tipo_memorandum.')"><i class="fas fa-trash-alt"></i></button>'.
					' <button class="btn btn-warning" onclick="mostrar('.$reg->id_tipo_memorandum.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-primary" onclick="activar('.$reg->id_tipo_memorandum.')"><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_tipo_memorandum,
 				"2"=>$reg->descripcion_memorandum,
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