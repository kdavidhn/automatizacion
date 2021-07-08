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
$usuario_x= $_SESSION['id_usuario'];
$id_falta=isset($_POST["id_falta"])? limpiarCadena($_POST["id_falta"]):"";
$id_tipo_falta=isset($_POST["id_tipo_falta"])? limpiarCadena($_POST["id_tipo_falta"]):"";
$fch_falta=isset($_POST["fch_falta"])? limpiarCadena($_POST["fch_falta"]):"";
$id_persona_alumno=isset($_POST["id_persona_alumno"])? limpiarCadena($_POST["id_persona_alumno"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_falta)) {
		
							
				$rspta=$falta->insertar($id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion, $usuario_x);
				echo $rspta ? "Falta Registrada" : "Falta no se pudo registrar";
				
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UNA NUEVA FALTA ');
				
		} else {
			

				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select id_tipo_falta, fch_falta, id_persona_alumno, descripcion from tbl_voae_faltas_conductas WHERE id_falta= '$id_falta'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				
					$rspta=$falta->editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion);
					echo $rspta ? "Falta Actualizada" : "Falta no se pudo actualizar";

			}
		 //FIN
	break;
 



	case 'mostrar':
	
		$rspta=$falta->mostrar($id_falta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'eliminar':
	
		$rspta=$falta->eliminar($id_falta);
 		echo $rspta ? "Registro Eliminado" : "Error";

	break;


	case 'listar':
	
 
 		$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(

 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id_falta.')"><i class="far fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->id_falta.')"><i class="fas fa-trash-alt"></i></button>', 
 				"1"=>$reg->fch_falta,
 				"2"=>$reg->nombre_falta,
 				"3"=>$reg->nombres,
 				"4"=>$reg->valor,
 				"5"=>$reg->descripcion

 				
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

