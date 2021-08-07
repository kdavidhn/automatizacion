<?php 

session_start();

require_once "../Modelos/registro_actividad_externa_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$externa=new Externa();
$Id_objeto=114; 

if (permisos::permiso_modificar($Id_objeto)==0)
  {
    $_SESSION["btnmodificar"]="hidden";
  }
else
  {
    $_SESSION["btnmodificar"]="";
  }
 if (permisos::permiso_eliminar($Id_objeto)==0)
  {
    $_SESSION["btneliminar"]="hidden";
  }
else
  {
    $_SESSION["btneliminar"]="";
  }

$usuario= $_SESSION['id_usuario'];
$id_actividad_voae=isset($_POST["id_actividad_voae"])? limpiarCadena($_POST["id_actividad_voae"]):"";
$id_asistencia=isset($_POST["id_asistencia"])? limpiarCadena($_POST["id_asistencia"]):"";
$nombre_act=isset($_POST["nombre_act"])? limpiarCadena($_POST["nombre_act"]):"";
$ubicacion=isset($_POST["ubicacion"])? limpiarCadena($_POST["ubicacion"]):"";
$fecha_inicio=isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
$fecha_final=isset($_POST["fecha_final"])? limpiarCadena($_POST["fecha_final"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$ente=isset($_POST["ente"])? limpiarCadena($_POST["ente"]):"";
$horas_voae=isset($_POST["horas_voae"])? limpiarCadena($_POST["horas_voae"]):"";
$ambito=isset($_POST["ambito"])? limpiarCadena($_POST["ambito"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";

switch ($_GET["op"]){
	
	case 'guardaryeditar':
		if (empty($id_actividad_voae)) {
				
			
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$externa->insertar($nombre_act,$ubicacion,$fecha_inicio,$fecha_final,$descripcion,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Registrada" : "No se pudo registrar";
				
				
			

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


	case 'listar':
	
		$rspta=$externa->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				
 				"0"=>'<button title="Modificar Registro" '.$_SESSION['btnmodificar'].' class="btn btn-warning" onclick= ><i class="far fa-edit"></i></button>'.
 					' <button title="Eliminar Registro" '.$_SESSION['btneliminar'].' class="btn btn-danger"  onclick=><i class="fas fa-trash-alt"></i></button>', 
 				"1"=>$reg->id_actividad_voae,
 				"2"=>$reg->nombre_actividad,
 				"3"=>$reg->staff_alumnos,
 				"4"=>$reg->ubicacion,
 				"5"=>$reg->fch_inicial_actividad,
 				"6"=>$reg->fch_final_actividad
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

