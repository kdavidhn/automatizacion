<?php 
ob_start();
session_start();

require_once "../Modelos/Ambito_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$ambito=new Ambito();
$Id_objeto=220; 

$id_ambito=isset($_POST["id_ambito"])? limpiarCadena($_POST["id_ambito"]):"";
$nombre_ambito=isset($_POST["nombre_ambito"])? limpiarCadena($_POST["nombre_ambito"]):"";
$descripcion_ambito=isset($_POST["descripcion_ambito"])? limpiarCadena($_POST["descripcion_ambito"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_ambito)) {
				
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste=("select count(nombre_ambito) as nombre_ambito  from tbl_voae_ambitos where nombre_ambito='$nombre_ambito'");

			//OBTENER LA ULTIMA FILA DEL QUERY
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			//CONDICION PARA QUE NO SE REPITA EL NOMBRE
			if ($existe['nombre_ambito']== 1) {
				echo 'EL ÁMBITO YA EXISTE, INGRESE DIFERENTE NOMBRE';

			} else {
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$ambito->insertar($nombre_ambito,$descripcion_ambito);
				echo $rspta ? "Ámbito Registrado" : "Ámbito no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL AMBITO: ' . $nombre_ambito . '');
				
			}

		} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(nombre_ambito) as nombre_ambito from tbl_voae_ambitos where nombre_ambito='$nombre_ambito' and id_ambito<>'$id_ambito' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['nombre_ambito'] == 1) {
				echo 'EL ÁMBITO YA EXISTE, INGRESE DIFERENTE NOMBRE';

			} else {
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select nombre_ambito, descripcion_ambito from tbl_voae_ambitos WHERE id_ambito= '$id_ambito'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DEL NOMBRE Y LA DESCRIPCION
				if ($valor_viejo['nombre_ambito'] <> $nombre_ambito and $valor_viejo['descripcion_ambito'] <> $descripcion_ambito) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NOMBRE AMBITO: ' . $valor_viejo['nombre_ambito'] . ' POR: ' . $nombre_ambito . ', Y LA DESCRIPCION DEL AMBITO');
					$rspta=$ambito->editar($id_ambito,$nombre_ambito,$descripcion_ambito);
					echo $rspta ? "Ámbito Actualizado" : "Ámbito no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DEL NOMBRE DEL AMBITO
				} elseif ($valor_viejo['nombre_ambito'] <> $nombre_ambito) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NOMBRE DEL AMBITO: ' . $valor_viejo['nombre_ambito'] . ' POR: ' . $nombre_ambito . ' ');
					$rspta=$ambito->editar($id_ambito,$nombre_ambito,$descripcion_ambito);
					echo $rspta ? "Ámbito Actualizado" : "Ámbito no se pudo actualizar";

					//CONDICION PARA LA MODIFICACION DE LA DESCRIPCION DEL AMBITO

				} elseif ($valor_viejo['descripcion_ambito'] <> $descripcion_ambito) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL AMBITO: "' . $nombre_ambito . '" ');
				$rspta=$ambito->editar($id_ambito,$nombre_ambito,$descripcion_ambito);
				echo $rspta ? "Ámbito Actualizado" : "Ámbito no se pudo actualizar";
				}
			}
		} //FIN
	break;
 	

	case 'desactivar':
		$rspta=$ambito->desactivar($id_ambito);
 		echo $rspta ? "Ámbito Desactivado" : "Ámbito no se puede desactivar";

 		//SE EXTRAE EL NOMBRE DEL AMBITO A DESACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_ambito, descripcion_ambito from tbl_voae_ambitos where id_ambito = '$id_ambito'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_ambito = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL AMBITO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DESACTIVO', 'EL AMBITO: ' . $bt_nombre_ambito['nombre_ambito'] . '');
	break;



	case 'activar':
		$rspta=$ambito->activar($id_ambito);
 		echo $rspta ? "Ámbito Activado" : "Ámbito no se puede activar";

 		//SE EXTRAE EL NOMBRE DEL AMBITO A ACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_ambito, descripcion_ambito from tbl_voae_ambitos where id_ambito = '$id_ambito'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_ambito = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL AMBITO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ACTIVO', 'EL AMBITO: ' . $bt_nombre_ambito['nombre_ambito'] . '');
	break;

	case 'eliminar': 
		//SE EXTRAE EL NOMBRE DEL AMBITO A ACTIVAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select nombre_ambito, descripcion_ambito from tbl_voae_ambitos where id_ambito = '$id_ambito'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_ambito = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL AMBITO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'EL AMBITO: ' . $bt_nombre_ambito['nombre_ambito'] . '');
 		
		$rspta=$ambito->eliminar($id_ambito);
 		echo $rspta ? "Registro Eliminado" : "Error";

 		

	break;

	case 'mostrar':
	
		$rspta=$ambito->mostrar($id_ambito);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	
	case 'listar': 
	//SE CREA UNA CONDICION PARA VERIFICAR SI TIENE PERMISO DE MODIFICAR
	if (permisos::permiso_eliminar($Id_objeto)==1 and permisos::permiso_modificar($Id_objeto)==1){
		$rspta=$ambito->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				' <button class="btn btn-warning" onclick="mostrar('.$reg->id_ambito.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_ambito.')"><i class="fa fa-window-close"></i></button>':
					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_ambito.')"><i class="fas fa-trash-alt"></i></button>'.
					' <button class="btn btn-warning" onclick="mostrar('.$reg->id_ambito.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-primary" onclick="activar('.$reg->id_ambito.')"><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_ambito,
 				"2"=>$reg->descripcion_ambito,
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

 		$rspta=$ambito->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				
 				' <button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fa fa-window-close"></i></button>':
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fas fa-trash-alt"></i></button>'.
 					' <button class="btn btn-warning" name="btnmodificar" id="btnmodificar" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" disabled="disabled" onclick=""><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_ambito,
 				"2"=>$reg->descripcion_ambito,
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
 			$rspta=$ambito->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				
 				' <button class="btn btn-warning" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" disabled="disabled" onclick=""><i class="fa fa-window-close"></i></button>':
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_ambito.')"><i class="fas fa-trash-alt"></i></button>'.
 					' <button class="btn btn-warning" name="btnmodificar" id="btnmodificar" disabled="disabled" onclick=""><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-primary" disabled="disabled" onclick=""><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_ambito,
 				"2"=>$reg->descripcion_ambito,
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
 		$rspta=$ambito->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?
 				
 				' <button class="btn btn-warning" onclick="mostrar('.$reg->id_ambito.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-danger" onclick="desactivar('.$reg->id_ambito.')"><i class="fa fa-window-close"></i></button>':
					' <button class="btn btn-danger" disabled onclick=""><i class="fas fa-trash-alt"></i></button>'.
					' <button class="btn btn-warning" onclick="mostrar('.$reg->id_ambito.')"><i class="far fa-edit"></i></button>'.
					' <button class="btn btn-primary" onclick="activar('.$reg->id_ambito.')"><i class="fa fa-check"></i></button>', 
 				"1"=>$reg->nombre_ambito,
 				"2"=>$reg->descripcion_ambito,
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
  ob_end_flush();
?>

