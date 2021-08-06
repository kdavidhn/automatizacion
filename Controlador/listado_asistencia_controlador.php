<?php 

session_start();

require_once "../Modelos/listado_asistencia_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$listado_asistencia=new listado_asistencia();
$Id_objeto=118; 

$id_asistencia=isset($_POST["id_asistencia"])? limpiarCadena($_POST["id_asistencia"]):"";
$cuenta=isset($_POST["cuenta"])? limpiarCadena($_POST["cuenta"]):"";
$nombre_alumno=isset($_POST["nombre_alumno"])? limpiarCadena($_POST["nombre_alumno"]):"";
$cant_horas=isset($_POST["cant_horas"])? limpiarCadena($_POST["cant_horas"]):"";
$carrera=isset($_POST["carrera"])? limpiarCadena($_POST["carrera"]):"";
$id_actividad_voae=$_SESSION['id_actividad_cve'];

if (permisos::permiso_eliminar($Id_objeto)=='0')    {
    $_SESSION["btn_eliminar_li"]="hidden";
  } else {
    $_SESSION["btn_eliminar_li"]="";
  }
  if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_editar_li"]="hidden";
  } else {
    $_SESSION["btn_editar_li"]="";
  }

switch ($_GET["op"]){
	case 'guardaryeditar':

		$sql = "SELECT * FROM tbl_voae_asistencias WHERE cuenta = '$cuenta' && id_actividad_voae = '$id_actividad_voae'";
		$rows = ejecutarConsulta($sql);
		if (mysqli_num_rows($rows)>1){
			echo 'La cuenta ingresada ya existe en el Listado' ;
		} else {


			if (empty($id_asistencia)){ 


				
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$listado_asistencia->insertar($id_actividad_voae,$cuenta,$nombre_alumno,$cant_horas, $carrera );
				echo $rspta ? "Asistencia  Registrada".$id_actividad_voae." - ".$cuenta." - ".$nombre_alumno." - ".$cant_horas." - ".$carrera : "El informe no se pudo registrar - ".$id_actividad_voae." - ".$cuenta." - ".$nombre_alumno." - ".$cant_horas." - ".$carrera;
				
			}
			else {
				$rspta=$listado_asistencia->editar($id_asistencia,$cuenta,$nombre_alumno,$cant_horas, $carrera );
				echo $rspta ? "Asistencia actualizada" .$id_actividad_voae." - ".$cuenta." - ".$nombre_alumno." - ".$cant_horas." - ".$carrera: "Artículo no se pudo actualizar".$id_actividad_voae." - ".$cuenta." - ".$nombre_alumno." - ".$cant_horas." - ".$carrera;
				
			}
		}
	break;


	
		case 'mostrar':
			$rspta=$listado_asistencia->mostrar($id_asistencia);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
		break;


		case 'eliminar':
	
			$rspta=$listado_asistencia->eliminar($id_asistencia);
			 echo $rspta ? "Asistencia de estudiante Eliminada" : "Error";
	
		break;


		case 'listar':
			
				$rspta=$listado_asistencia->listar($id_actividad_voae);
				 //Vamos a declarar un array
				 $data= Array();
		
				 while ($reg=$rspta->fetch_object()){
					 $data[]=array(
						"0"=>'<button id="tbn_editar_li" '.$_SESSION["btn_editar_li"].' class="btn btn-warning" onclick="mostrar('.$reg->id_asistencia.')"><i class="far fa-edit"></i></button>'.
						' <button id="tbn_eliminar_li" '.$_SESSION["btn_eliminar_li"].' class="btn btn-danger" onclick="eliminar('.$reg->id_asistencia.')"><i class="fas fa-trash-alt"></i></button>', 
						"1"=>$reg->cuenta,
						"2"=>$reg->nombre_alumno,
						"3"=>$reg->cant_horas,
						"4"=>$reg->carrera
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

