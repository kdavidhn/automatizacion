<?php 

session_start();

require_once "../Modelos/actividad_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$actividad=new Actividad();
$Id_objeto=121;
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
$id_estado=isset($_POST["id_estado"])? limpiarCadena($_POST["id_estado"]):"";
//$id_usuario_registro=isset($_POST["id_usuario_registro"])? limpiarCadena($_POST["id_usuario_registro"]):"";
$id_ambito=isset($_POST["id_ambito"])? limpiarCadena($_POST["id_ambito"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";



if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_finalizar"]="hidden";
  } else {
    $_SESSION["btn_finalizar"]="";
  }
if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_documentos"]="hidden";
  } else {
    $_SESSION["btn_documentos"]="";
  }


switch ($_GET["op"]){
	
		case 'finalizar':

				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
		$rspta=$actividad->finalizar($id_actividad_voae,$fch_final_actividad);
		echo $rspta ? "Actividad Finalizada" : "No fue Posible Finalizar la Actividad";


		
 		$valor = "select no_solicitud from tbl_voae_actividades where id_actividad_voae = '$id_actividad_voae'";
	    $result_valor = $mysqli->query($valor);
	    $bt_no_solicitud = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE enviar la actividad
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'FINALIZO', 'EL NO DE SOLICITUD "' . $bt_no_solicitud['no_solicitud'] . '"');
	    break;

	    case 'mostrar':

	    $rspta=$actividad->mostrar($id_actividad_voae);
 		//Codificar el resultado utilizando json
	    echo json_encode($rspta);
	    break;

	    case 'listar2':
	    $rspta=$actividad->listar2();
 		//Vamos a declarar un array
	    $data= Array();

	    while ($reg=$rspta->fetch_object()){
	    	$data[]=array(
	    		"0"=>($reg->condicion)?'<button class="btn btn-info"  onclick="mostrar('.$reg->id_actividad_voae.',1)"><i class="far fa-eye"></i></button>'. 
	    		'<form action="../vistas/informe_actividad_cve_vista.php" style="display:inline;">
                  <button id="btn_documentos"title="Agregar documentos de Actividad" '.$_SESSION["btn_finalizar"].'  class="btn btn-warning" type="submit" ><i class="fa fa-solid fa-check"></i></button>
	    		</form>':
	    		'<button class="btn btn-info" onclick="mostrar('.$reg->id_actividad_voae.',1)"><i class="far fa-eye"></i></button>'.
	    		'<button title="Finalizar Actividad" id="btn_finalizar" class="btn btn-danger"  '.$_SESSION["btn_finalizar"].' onclick="finalizar('.$reg->id_actividad_voae.')"><i class="fa fa-solid fa-check"></i></button>',
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
