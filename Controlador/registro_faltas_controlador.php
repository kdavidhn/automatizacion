<?php 

session_start();

require_once "../Modelos/registro_faltas_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$falta=new Faltas();
$Id_objeto=113; 

$id_falta=isset($_POST["id_falta"])? limpiarCadena($_POST["id_falta"]):"";
$id_tipo_falta=isset($_POST["id_tipo_falta"])? limpiarCadena($_POST["id_tipo_falta"]):"";
$fch_falta=isset($_POST["fch_falta"])? limpiarCadena($_POST["fch_falta"]):"";
$id_usuario_alumno=isset($_POST["id_usuario_alumno"])? limpiarCadena($_POST["id_usuario_alumno"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_falta)) {
			
			$usuario = $_SESSION['id_usuario'];
				$rspta=$falta->insertar($id_tipo_falta,$fch_falta,$id_usuario_alumno,$descripcion, $usuario);
				echo $rspta ? "Falta Registrada" : "Falta no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UNA NUEVA FALTA CON FECHA: ' . $fch_falta . '');
				
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
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NOMBRE AMBITO: ' . $valor_viejo['nombre_ambito'] . ' POR: ' . $descripcion_ambito . ', Y LA DESCRIPCION DEL AMBITO: ' . $nombre_ambito . ' ');
					$rspta=$falta->editar($id_ambito,$nombre_ambito,$descripcion_ambito);
					echo $rspta ? "Ámbito Actualizado" : "Ámbito no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DEL NOMBRE DEL AMBITO
				} elseif ($valor_viejo['nombre_ambito'] <> $nombre_ambito) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NOMBRE DEL AMBITO: ' . $valor_viejo['nombre_ambito'] . ' POR: ' . $nombre_ambito . ' ');
					$rspta=$ambito->editar($id_ambito,$nombre_ambito,$descripcion_ambito);
					echo $rspta ? "Ámbito Actualizado" : "Ámbito no se pudo actualizar";

					//CONDICION PARA LA MODIFICACION DE LA DESCRIPCION DEL AMBITO

				} elseif ($valor_viejo['descripcion_ambito'] <> $descripcion_ambito) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION DEL AMBITO POR "' . $descripcion_ambito . '" ');
				$rspta=$ambito->editar($id_ambito,$nombre_ambito,$descripcion_ambito);
				echo $rspta ? "Ámbito Actualizado" : "Ámbito no se pudo actualizar";
				}
			}
		} //FIN
	break;
 



	case 'mostrar':
	
		$rspta=$falta->mostrar($id_falta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;



	case 'listar':
	

 		$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(

 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>',
 				"1"=>$reg->FECHA,
 				"2"=>$reg->TIPO,
 				"3"=>$reg->CUENTA,
 				"4"=>$reg->ESTUDIANTE,
 				"5"=>$reg->descripcion,

 				
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

