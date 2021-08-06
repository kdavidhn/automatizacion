<?php 

session_start();

require_once "../Modelos/actividad_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$actividad=new Actividad();
$Id_objeto=110;
$usuario= $_SESSION['id_usuario'];
$hoy=date("y-m-d");

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

if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_editar"]="hidden";
  } else {
    $_SESSION["btn_editar"]="";
  }
  if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_solicitado"]="hidden";
  } else {
    $_SESSION["btn_solicitado"]="";
  }



switch ($_GET["op"]){
	case 'guardaryeditar':
	if (empty($id_actividad_voae)){
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
		$rspta=$actividad->insertar($no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$usuario,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD REGISTRADA" : "actividad no se pudo registrar";
		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'LA ACTIVIDAD: "' . $nombre_actividad . '"');

	} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(no_solicitud) as no_solicitud from tbl_voae_actividades where no_solicitud='$no_solicitud' and id_ambito<>'$id_ambito' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['no_solicitud'] == 1) {
				echo 'El No DE SOLICITUD  YA EXISTE, INGRESE DIFERENTE NO DE SOLICITUD';

			} else {
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select no_solicitud, nombre_actividad, ubicacion , fch_inicial_actividad, fch_final_actividad, descripcion , poblacion_objetivo, presupuesto,staff_alumnos, observaciones , id_ambito, periodo from tbl_voae_actividades WHERE id_actividad_voae= '$id_actividad_voae'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DEL NOMBRE Y LA DESCRIPCION
				if ($valor_viejo['no_solicitud'] <> $no_solicitud and $valor_viejo['nombre_actividad'] <> $nombre_actividad and $valor_viejo['ubicacion'] <> $ubicacion and $valor_viejo['fch_inicial_actividad'] <> $fch_inicial_actividad and $valor_viejo['fch_final_actividad'] <> $fch_final_actividad and $valor_viejo['descripcion'] <> $descripcion and $valor_viejo['poblacion_objetivo'] <> $poblacion_objetivo and $valor_viejo['presupuesto'] <> $presupuesto and $valor_viejo['staff_alumnos'] <> $staff_alumnos and $valor_viejo['observaciones'] <> $observaciones and $valor_viejo['id_ambito'] <> $id_ambito and $valor_viejo['periodo'] <> $periodo) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL NO DE SOLICITUD: ' . $valor_viejo['no_solicitud'] . ' POR: ' . $no_solicitud . ', Y LA DESCRIPCION DEL AMBITO');

					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

			}elseif ($valor_viejo['no_solicitud'] <> $no_solicitud) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NO DE SOLICITUD: ' . $valor_viejo['no_solicitud'] . ' POR: ' . $no_solicitud . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

					//CONDICION PARA LA MODIFICACION DE LA DESCRIPCION DEL AMBITO

				}elseif ($valor_viejo['nombre_actividad'] <> $nombre_actividad) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL NOMBRE DE LA ACTIVIDAD: ' . $valor_viejo['nombre_actividad'] . ' POR: ' . $nombre_actividad . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['ubicacion'] <> $ubicacion) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA UBICACION DE LA ACTIVIDAD: ' . $valor_viejo['ubicacion'] . ' POR: ' . $ubicacion . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['fch_inicial_actividad'] <> $fch_inicial_actividad) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA FECHA INCIAL DE LA ACTIVIDAD: ' . $valor_viejo['fch_inicial_actividad'] . ' POR: ' . $fch_inicial_actividad . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['fch_final_actividad'] <> $fch_final_actividad) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA FECHA FINAL DE LA ACTIVIDAD: ' . $valor_viejo['fch_final_actividad'] . ' POR: ' . $fch_final_actividad . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['descripcion'] <> $descripcion) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA DESCRIPCION DE LA ACTIVIDAD: ' . $valor_viejo['descripcion'] . ' POR: ' . $descripcion . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['poblacion_objetivo'] <> $poblacion_objetivo) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA POBLACION OBJETIVA DE LA ACTIVIDAD: ' . $valor_viejo['poblacion_objetivo'] . ' POR: ' . $poblacion_objetivo . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['presupuesto'] <> $presupuesto) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL PRESUPUESTO DE LA ACTIVIDAD: ' . $valor_viejo['presupuesto'] . ' POR: ' . $presupuesto . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['staff_alumnos'] <> $staff_alumnos) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL STAFF ALUMNOS DE LA ACTIVIDAD: ' . $valor_viejo['staff_alumnos'] . ' POR: ' . $staff_alumnos . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['observaciones'] <> $observaciones) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LAS OBSERVACIONES DE LA ACTIVIDAD: ' . $valor_viejo['observaciones'] . ' POR: ' . $observaciones . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['id_ambito'] <> $id_ambito) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL AMBITO DE LA ACTIVIDAD: ' . $valor_viejo['id_ambito'] . ' POR: ' . $id_ambito . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}elseif ($valor_viejo['periodo'] <> $periodo) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL PERIODO DE LA ACTIVIDAD: ' . $valor_viejo['periodo'] . ' POR: ' . $periodo . ' ');
					$rspta=$actividad->editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo);
		echo $rspta ? "ACTIVIDAD ACTUALIZADA" : "El actividad no se pudo actualizar";

				}
				}
				
			}

		//FIN
		break;

		case 'solicitado':
		$rspta=$actividad->solicitado($id_actividad_voae);
		echo $rspta ? "Actividad Enviada Para Aprobacion" : "No fue Posible Enviar la Actividad";

		  //SE EXTRAE EL NO DE SOLICITUD  A ENVIAR Y SE GUARDA EN UNA VARIABLE
 		$valor = "select no_solicitud from tbl_voae_actividades where id_actividad_voae = '$id_actividad_voae'";
	    $result_valor = $mysqli->query($valor);
	    $bt_no_solicitud = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE enviar la actividad
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ENVIO', 'EL No DE SOLICITUD "' . $bt_no_solicitud['no_solicitud'] . '"');
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
	    		"0"=>'<button id="btn_editar" class="btn btn-warning" '.$_SESSION["btn_editar"].' onclick="mostrar('.$reg->id_actividad_voae.')"><i class="far fa-edit"></i></button>'. 
	    		'<button id="btn_solicitado" title="Enviar Solicitud" class="btn btn-success" '.$_SESSION["btn_solicitado"].' onclick="solicitado('.$reg->id_actividad_voae.')"><i class="fa fa-solid fa-check"></i></button>',
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

