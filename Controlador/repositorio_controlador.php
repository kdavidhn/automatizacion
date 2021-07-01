<?php 
session_start();

require_once "../Modelos/repositorio_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$repositorio=new Repositorio();
$Id_objeto=107; 

$id_repositorio=isset($_POST["id_repositorio"])? limpiarCadena($_POST["id_repositorio"]):"";
$nombre_repositorio=isset($_POST["nombre_repositorio"])? limpiarCadena($_POST["nombre_repositorio"]):"";
$descripcion_repositorio=isset($_POST["descripcion_repositorio"])? limpiarCadena($_POST["descripcion_repositorio"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_repositorio)){

			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste=("select count(nombre_repositorio) as nombre_repositorio  from tbl_voae_tipos_repositorios where nombre_repositorio='$nombre_repositorio'");

			//OBTENER LA ULTIMA FILA DEL QUERY
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			//CONDICION PARA QUE NO SE REPITA EL NOMBRE
			if ($existe['nombre_repositorio']== 1) {
				echo 'EL NOMBRE DEL TIPO DE REPOSITORIO YA EXISTE, INGRESE UN NOMBRE DIFERENTE';

			} else {
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$repositorio->insertar($nombre_repositorio,$descripcion_repositorio);
				echo $rspta ? "TIPO DE REPOSITORIO Registrado" : "El TIPO DE REPOSITORIO  no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL TIPO DE REPOSITORIO "' . $nombre_repositorio . '"');
			}

		} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(nombre_repositorio) as nombre_repositorio from tbl_voae_tipos_repositorios where nombre_repositorio='$nombre_repositorio' and id_repositorio<>'$id_repositorio' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['nombre_repositorio'] == 1) {
				echo 'EL TIPO DE REPOSITORIO YA EXISTE, INGRESE DIFERENTE NOMBRE';

			} else {
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select nombre_repositorio, descripcion_repositorio from tbl_voae_tipos_repositorios WHERE id_repositorio= '$id_repositorio'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DEL NOMBRE Y LA DESCRIPCION
				if ($valor_viejo['nombre_repositorio'] <> $nombre_repositorio and $valor_viejo['descripcion_repositorio'] <> $descripcion_repositorio) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NOMBRE DE REPOSITORIO "' . $valor_viejo['nombre_repositorio'] . '" POR "' . $nombre_repositorio . '" Y LA DESCRIPCION DEL TIPO DE REPOSITORIO" ');
					$rspta=$repositorio->editar($id_repositorio,$nombre_repositorio,$descripcion_repositorio);
					echo $rspta ? "El TIPO DE REPOSITORIO fue actualizado" : "EL TIPO DE REPOSITORIO no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DEL NOMBRE DEL TIPO DE REPOSITORIO
				} elseif ($valor_viejo['nombre_repositorio'] <> $nombre_repositorio) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NOMBRE DEL TIPO DE REPOSITORIO "' . $valor_viejo['nombre_repositorio'] . '" POR "' . $nombre_repositorio . '" ');
					$rspta=$repositorio->editar($id_repositorio,$nombre_repositorio,$descripcion_repositorio);
					echo $rspta ? "El TIPO DE REPOSITORIO fue actualizado" : "EL TIPO DE REPOSITORIO no se pudo actualizar";

					//CONDICION PARA LA MODIFICACION DE LA DESCRIPCION DEL TIPO DE REPOSITORIO

				} elseif ($valor_viejo['descripcion_repositorio'] <> $descripcion_repositorio) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL TIPO DE REPOSITORIO "' . $nombre_repositorio . '" ');
				$rspta=$repositorio->editar($id_repositorio,$nombre_repositorio,$descripcion_repositorio);
				echo $rspta ? "El TIPO DE REPOSITORIO fue actualizado" : "EL TIPO DE REPOSITORIO no se pudo actualizar";
				}
			}
		} //FIN
	break;


	case 'desactivar':
		$rspta=$repositorio->desactivar($id_repositorio);
 		echo $rspta ? "El TIPO DE REPOSITORIO  Desactivado" : "EL TIPO DE REPOSITORIO no se puede desactivar";

		 //SE EXTRAE EL NOMBRE DEL TIPO DE REPOSITORIO A DESACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_repositorio, descripcion_repositorio from tbl_voae_tipos_repositorios where id_repositorio = '$id_repositorio'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_repositorio = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE DESACTIVAR EL TIPO DE REPOSITORIO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DESACTIVO', 'EL TIPO DE REPOSITORIO "' . $bt_nombre_repositorio['nombre_repositorio'] . '"');
	break;

	case 'activar':
		$rspta=$repositorio->activar($id_repositorio);
 		echo $rspta ? "El TIPO de repositorio fue activado" : "El TIPO de repositorio no se puede activar";

 		//SE EXTRAE EL NOMBRE DEL TIPO DE REPOSITORIO A ACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_repositorio, descripcion_repositorio from tbl_voae_tipos_repositorios where id_repositorio = '$id_repositorio'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_repositorio = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL TIPO DE REPOSITORIO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ACTIVO', 'EL TIPO DE REPOSITORIO "' . $bt_nombre_repositorio['nombre_repositorio'] . '"');
	break;



	case 'mostrar':

		$rspta=$repositorio->mostrar($id_repositorio);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
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


