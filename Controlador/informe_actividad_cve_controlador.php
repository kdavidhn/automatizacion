<?php 
ob_start();
session_start();

require_once "../Modelos/informe_actividad_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$informe_actividad=new informe_actividad();
$Id_objeto=232; 

$id_informe=isset($_POST["id_informe"])? $instancia_conexion->limpiarCadena($_POST["id_informe"]):"";
$id_actividad=isset($_POST["id_actividad"])? $instancia_conexion->limpiarCadena($_POST["id_actividad"]):"";
$introduccion=isset($_POST["introduccion"])? $instancia_conexion->limpiarCadena($_POST["introduccion"]):"";
$objetivos=isset($_POST["objetivos"])? $instancia_conexion->limpiarCadena($_POST["objetivos"]):"";
$desarrollo=isset($_POST["desarrollo"])? $instancia_conexion->limpiarCadena($_POST["desarrollo"]):"";
$conclusiones=isset($_POST["conclusiones"])? $instancia_conexion->limpiarCadena($_POST["conclusiones"]):"";
$fch_informe=isset($_POST["fch_informe"])? $instancia_conexion->limpiarCadena($_POST["fch_informe"]):"";
$id_repositorio=isset($_POST["id_repositorio"])? $instancia_conexion->limpiarCadena($_POST["id_repositorio"]):"";
$nombre_archivo=isset($_POST["nombre_archivo"])? $instancia_conexion->limpiarCadena($_POST["nombre_archivo"]):"";
$dir_repositorio=isset($_POST["dir_repositorio"])? $instancia_conexion->limpiarCadena($_POST["dir_repositorio"]):"";
$id_usuario_registro=$_SESSION['id_usuario'];
$usuario=isset($_POST["usuario"])? $instancia_conexion->limpiarCadena($_POST["usuario"]):"";
$id_estado=isset($_POST["id_estado"])? $instancia_conexion->limpiarCadena($_POST["id_estado"]):"";
$nombre_estado=isset($_POST["nombre_estado"])? $instancia_conexion->limpiarCadena($_POST["nombre_estado"]):"";
$archivo=isset($_POST["archivo"])? $instancia_conexion->limpiarCadena($_POST["archivo"]):"";
$usuario=$_SESSION['id_usuario'];
if (permisos::permiso_eliminar($Id_objeto)=='0')    {
    $_SESSION["btn_eliminar"]="hidden";
  } else {
    $_SESSION["btn_eliminar"]="";
  }
  if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_editar"]="hidden";
  } else {
    $_SESSION["btn_editar"]="";
  }


switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['archivo']['tmp_name']) || !is_uploaded_file($_FILES['archivo']['tmp_name']))
		{
			$archivo=$_POST["archivoactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["archivo"]["name"]);
			if ($_FILES['archivo']['type'] == "application/pdf")
			{
				$archivo = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["archivo"]["tmp_name"], "../archivos/repositorio_voae/" . $archivo);
				$dir_repositorio = "../archivos/repositorio_voae/" . $archivo;
				$nombre_archivo = $_FILES['archivo']['name'];

			}
		}

		if (empty($id_informe)){ 

			
			//SE MANDA A LA BITACORA LA ACCION DE INSERTAR CON EL ID DE ESTADO 13 

			$id_estado=13;

			$rspta=$informe_actividad->insertar($nombre_archivo,$dir_repositorio,$id_actividad,$introduccion,$objetivos,$desarrollo,$conclusiones,$id_usuario_registro,$id_estado);
			echo $rspta ? "Informe  Registrado" : "El informe no se pudo registrar ";
			bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL INFORME CON ID: "' . $id_informe . '"');
		}
		else {
			$rspta=$informe_actividad->editar($id_informe,$id_repositorio,$nombre_archivo,$dir_repositorio,$id_actividad,$introduccion,$objetivos,$desarrollo,$conclusiones,$id_usuario_registro,$id_estado);
			echo $rspta ? "Informe  actualizado" : "El informe no se pudo actualizar ";
			bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL INFORME CON ID: "' . $id_informe . '"');				

		}

	break;


	
	case 'mostrar':
		$rspta=$informe_actividad->mostrar($id_informe);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	break;


	case 'eliminar':

		$rspta=$informe_actividad->eliminar($id_informe);
			echo $rspta ? "Informe Eliminado" : "Error";

	break;





		case 'listar': 
			
			$rspta=$informe_actividad->listar($usuario);
			//Vamos a declarar un array
			$data= Array();

			while ($reg=$rspta->fetch_object()){
				$data[]=array(
				"0"=>' <button id="btn_editar" '.$_SESSION["btn_editar"].' class="btn btn-warning" onclick="mostrar('.$reg->id_informe.')"><i class="far fa-edit"></i></button>'.
				' <button id="btn_eliminar" '.$_SESSION["btn_eliminar"].' class="btn btn-danger" onclick="eliminar('.$reg->id_informe.')"><i class="fas fa-trash-alt"></i></button>'.
				'<form action="../vistas/listado_asistencia_vista.php" method="POST"   style="display:inline;">
					<input type="hidden" name="id_actividad_cve" value="'.$reg->id_actividad_voae.'" onclick="listar('.$reg->id_actividad_voae.')">
					<button class="btn btn-info" title="Lista de Asistencia" type="submit"><i class="fas fa-list-ol"></i></button>
				</form>'. 
				'<form target="_black" action="../Controlador/informe_actividad_pdf.php" method="POST" style="display:inline;">
					   <input type="hidden" name="id_informe" value="'.$reg->id_informe.'">
					   <button title="Generar PDF"  class="btn btn-danger"  type="submit" ><i class="fas fa-file-pdf"></i></button></form>',						 
				"1"=>$reg->no_solicitud,
				"2"=>$reg->nombre,
				"3"=>$reg->asistentes,
				"4"=>$reg->fch_informe,
				"5"=>$reg->usuario,
				"6"=>'<a target="_black" href="'.$reg->dir_repositorio.'"><button class="btn btn-success" type="button">Ver Archivo</button>
				</a>'
				
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

