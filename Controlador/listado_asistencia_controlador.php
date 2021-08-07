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
				echo $rspta ? "Asistencia  Registrada" : "El informe no se pudo registrar - ";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'LA ASISTENCIA DEL ESTUDIANTE CON CUENTA "' . $cuenta. '" EN LA ACTIVIDAD CON ID "'. $id_actividad_voae . '"');
			}
			else {
				$valor = "select * from tbl_voae_asistencias WHERE id_asistencia = '$id_asistencia'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				$rspta=$listado_asistencia->editar($id_asistencia,$cuenta,$nombre_alumno,$cant_horas, $carrera );
				
				$modificaciones='';
				if ($valor_viejo['nombre_alumno']!= $nombre_alumno){
					$modificaciones=($modificaciones.'NOMBRE ' );
				}
				if ($valor_viejo['cant_horas']!= $cant_horas){
					if (empty($modificaciones)){
						$modificaciones=($modificaciones.'CANT_HORAS ' );
					} else {
						$modificaciones=($modificaciones.'- CANT_HORAS ' );
					}					
				}
				if ($valor_viejo['carrera']!= $carrera){
					
					if (empty($modificaciones)){
						$modificaciones=($modificaciones.'CARRERA');
					} else {
						$modificaciones=($modificaciones.'- CARRERA ' );
					}
				}			
				
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA(s) COLUMNA (S): '.$modificaciones.'(DE LA ASISTENCIA DEL ESTUDIANTE CON CUENTA "' . $cuenta. '" EN LA ACTIVIDAD CON ID "'. $id_actividad_voae . '") ');
				echo $rspta ? "Asistencia actualizada": "Artículo no se pudo actualizar";
				
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
			 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'LA ASISTENCIA CON ID "' . $id_asistencia.$cuenta. '" EN LA ACTIVIDAD CON ID "'. $id_actividad_voae . '" ');
	
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

		case 'importar':

			if (isset ($_FILES['dataCliente'])) {

				$tipo       = $_FILES['dataCliente']['type'];
				$tamanio    = $_FILES['dataCliente']['size'];
				$archivotmp = $_FILES['dataCliente']['tmp_name'];
				$lineas     = file($archivotmp);
				$id_actividad_voae=$_SESSION['id_actividad_cve'];
				$actualizaciones=0;
				$registros =0;
				$i = 0;

				foreach ($lineas as $linea) {
				  $cantidad_registros = count($lineas);
				  $cantidad_regist_agregados =  ($cantidad_registros - 1);

				  if ($i != 0) {

					$datos = explode(";", $linea);
					

					$cuenta                = !empty(trim($datos[0]))  ? (trim($datos[0])) : '';
					$nombre_alumno         = !empty(strtoupper(trim(quitar_tildes($datos[1]))))  ? (strtoupper(trim(quitar_tildes($datos[1])))): '';
					$cant_horas            = !empty(trim($datos[2]))  ? (trim($datos[2])) : '';
					$carrera               = !empty(strtoupper(trim(quitar_tildes($datos[3]))))  ? (strtoupper(trim(quitar_tildes($datos[3])))): '';

					if( !empty($cuenta) ){
						$query = $mysqli -> query ("SELECT cuenta FROM tbl_voae_asistencias WHERE id_actividad_voae ='".($id_actividad_voae)."' AND cuenta='".($cuenta)."' ");
								$cant_duplicidad = mysqli_num_rows($query);
					}                
								 
				  //No existe Registros Duplicados
				  if ( $cant_duplicidad == 0 ) { 
				  
				  $insertarData = "INSERT INTO tbl_voae_asistencias( 
					  id_actividad_voae,
					  cuenta,
					  nombre_alumno,
					  cant_horas,
					  carrera
				  ) VALUES(
					  '$id_actividad_voae',
					  '$cuenta',
					  '$nombre_alumno',
					  '$cant_horas',
					  '$carrera'
				  )";
				  ejecutarConsulta($insertarData);
				  $registros++;
						  
				  } 
				  /**Caso Contrario actualizo el o los Registros ya existentes*/
				  else{
					  $updateData =  ("UPDATE tbl_voae_asistencias SET 
						  nombre_alumno='" .$nombre_alumno. "',
					  cant_horas='" .$cant_horas. "',
						  carrera='" .$carrera. "' 
						  WHERE id_actividad_voae ='".($id_actividad_voae)."' AND cuenta='".($cuenta)."'
					  ");
					  $result_update = ejecutarConsulta($updateData);
					  $actualizaciones++;

				  }
				}
			
			 $i++;
			}
				echo  'Se importaron un total de: '. $cantidad_regist_agregados .'filas. De las cuales '.$actualizaciones.' fueron actualizaciones y '.$registros.' nuevos registros' ;
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'IMPORTO', 'LISTADO DE ASISTENCIA DE LA ACTIVIDAD CON ID "' . $id_actividad_voae . '", CON: '. $registros . ' REGISTROS NUEVOS Y '.$actualizaciones. ' ACTUALIZACIONES');
		}

		break;

 	}

	 function quitar_tildes($cadena) {
		$cade = utf8_encode($cadena);
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$texto = str_replace($no_permitidas, $permitidas ,$cade);
		return $texto;
		}
 	?>

