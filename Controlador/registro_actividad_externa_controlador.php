<?php 
ob_start();
session_start();

require_once "../Modelos/registro_actividad_externa_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$externa=new Externa();
$Id_objeto=237; 

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
$id_actividad_voae=isset($_POST["id_actividad_voae"])? $instancia_conexion->limpiarCadena($_POST["id_actividad_voae"]):"";

$nombre_act=isset($_POST["nombre_actividad"])? $instancia_conexion->limpiarCadena($_POST["nombre_actividad"]):"";

$fecha_inicio=isset($_POST["fch_inicial_actividad"])? $instancia_conexion->limpiarCadena($_POST["fch_inicial_actividad"]):"";
$fecha_final=isset($_POST["fch_final_actividad"])? $instancia_conexion->limpiarCadena($_POST["fch_final_actividad"]):"";
$descripcion=isset($_POST["descripcion"])? $instancia_conexion->limpiarCadena($_POST["descripcion"]):"";
$ente=isset($_POST["staff_alumnos"])? $instancia_conexion->limpiarCadena($_POST["staff_alumnos"]):"";

$ambito=isset($_POST["id_ambito"])? $instancia_conexion->limpiarCadena($_POST["id_ambito"]):"";
$periodo=isset($_POST["periodo"])? $instancia_conexion->limpiarCadena($_POST["periodo"]):"";
$tipo = "ACTIVIDAD EXTERNA";
$estado = "6";

switch ($_GET["op"]){
	
	case 'guardaryeditar':
		if (empty($id_actividad_voae)) {
				
			
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				

				$sql = "select MAX(id_actividad_voae) as id from tbl_voae_actividades";
				$result_valor2 = $mysqli->query($sql);
				$id = $result_valor2->fetch_array(MYSQLI_ASSOC);

				$rspta=$externa->insertar($nombre_act,$ente,$usuario,$ambito,$periodo,$tipo,$fecha_inicio,$fecha_final);
				echo $rspta ? "Actividad Registrada" : "No se pudo registrar";
				
				 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'LA ACTIVIDAD EXTERNA: "' . $nombre_act . '" CON EL ID: "' . $id['id'] . '" ');
				
			

		} else {
			
				$valor = "select tbl_voae_actividades.nombre_actividad, tbl_voae_actividades.ubicacion , tbl_voae_actividades.fch_inicial_actividad, tbl_voae_actividades.fch_final_actividad, tbl_voae_actividades.descripcion , tbl_voae_actividades.staff_alumnos, tbl_voae_actividades.id_ambito, tbl_voae_actividades.periodo, tbl_voae_ambitos.nombre_ambito from tbl_voae_actividades JOIN tbl_voae_ambitos on tbl_voae_actividades.id_ambito = tbl_voae_ambitos.id_ambito WHERE id_actividad_voae= '$id_actividad_voae'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				$sql = "select nombre_ambito from tbl_voae_ambitos WHERE id_ambito= '$ambito'";
				$result_valor2 = $mysqli->query($sql);
				$valor_viejo2 = $result_valor2->fetch_array(MYSQLI_ASSOC);

				if ($valor_viejo['nombre_actividad'] <> $nombre_act and $valor_viejo['staff_alumnos'] <> $ente and $valor_viejo['id_ambito'] <> $ambito and $valor_viejo['periodo'] <> $periodo) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO NOMBRE: "'.$valor_viejo['nombre_actividad'] . '" POR: "'.$nombre_act . '"; CAMBIO FECHA INICIO: "'.$valor_viejo['fch_inicial_actividad'] . '" POR: "'.$fecha_inicio . '";  CAMBIO FECHA FINAL: "'.$valor_viejo['fch_final_actividad'] . '" POR: "'.$fecha_final . '"; CAMBIO ENTE: "'.$valor_viejo['staff_alumnos'] . '" POR: "'.$ente . '";  CAMBIO AMBITO: "'.$valor_viejo2['nombre_ambito'] . '" POR: "'.$ambito . '";  CAMBIO PERIODO: "'.$valor_viejo['periodo'] . '" POR: "'.$periodo . '";');
			$rspta=$externa->editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";
				

		 }elseif ($valor_viejo['nombre_actividad'] <> $nombre_act) {
		 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO NOMBRE: "'.$valor_viejo['nombre_actividad'] . '" POR: "'.$nombre_act . '');
		 		$rspta=$externa->editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";

			
			}elseif($valor_viejo['staff_alumnos'] <> $ente) {
		 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO ENTE ORGANIZADOR: "'.$valor_viejo['staff_alumnos'] . '" POR: "'.$ente . '');
		 		$rspta=$externa->editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";
			
			}elseif($valor_viejo['id_ambito'] <> $ambito) {
		 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO EL AMBITO: "'.$valor_viejo['nombre_ambito'] . '" POR: "'.$valor_viejo2['nombre_ambito'] . '"');
		 		$rspta=$externa->editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";
			
			}elseif($valor_viejo['periodo'] <> $periodo) {
		 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO EL PERIODO: "'.$valor_viejo['periodo'] . '" POR: "'.$periodo . '"');
		 		$rspta=$externa->editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";
			
			}elseif($valor_viejo['fch_inicial_actividad'] <> $fecha_inicio) {
		 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO LA FECHA INICIAL: "'.$valor_viejo['fch_inicial_actividad'] . '" POR: "'.$fecha_inicio . '"');
		 		$rspta=$externa->editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";
			
			}elseif($valor_viejo['fch_final_actividad'] <> $fecha_final) {
		 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO LA FECHA FINAL: "'.$valor_viejo['fch_final_actividad'] . '" POR: "'.$fecha_final . '"');
		 		$rspta=$externa->editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";
			
			}
		}//FIN
	break;

	case 'mostrar':

	    $rspta=$externa->mostrar($id_actividad_voae);
 		//Codificar el resultado utilizando json
	    echo json_encode($rspta);
	break;

	case 'eliminar': 
	
		$sql = "select nombre_actividad from tbl_voae_actividades where id_actividad_voae= '$id_actividad_voae'";
				$result_valor2 = $mysqli->query($sql);
				$nombre = $result_valor2->fetch_array(MYSQLI_ASSOC);

		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'LA ACTIVIDAD EXTERNA: "' . $nombre['nombre_actividad'] . '" CON EL ID: "' . $id_actividad_voae . '" ');

		$rspta=$externa->eliminar($id_actividad_voae);
 		echo $rspta ? "Registro Eliminado" : "Error";

 		

	break;

	case 'listar':
	
		$rspta=$externa->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				
 				"0"=>'<form action="../vistas/listado_asistencia_act_ext_vista.php" method="POST"   style="display:inline;">
					<input type="hidden" name="id_actividad_cve" value="'.$reg->id_actividad_voae.'" onclick="listar('.$reg->id_actividad_voae.')">
					<button class="btn btn-info" title="Lista de Asistencia" type="submit"><i class="fas fa-list-ol"></i></button>
				</form>'. 
 				' <button title="Modificar Registro" '.$_SESSION['btnmodificar'].' class="btn btn-warning" onclick="mostrar('.$reg->id_actividad_voae.')" ><i class="far fa-edit"></i></button>'.
 					' <button title="Eliminar Registro" '.$_SESSION['btneliminar'].' class="btn btn-danger"  onclick="eliminar('.$reg->id_actividad_voae.')"><i class="fas fa-trash-alt"></i></button>', 
 				"1"=>$reg->id_actividad_voae,
 				"2"=>$reg->nombre_actividad,
 				"3"=>$reg->staff_alumnos,
 				"4"=>$reg->fch_final_actividad,
 				"5"=>$reg->periodo
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
ob_end_flush();
?>


