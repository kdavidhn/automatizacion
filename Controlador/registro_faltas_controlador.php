<?php 
ob_start();
session_start();

require_once "../Modelos/registro_faltas_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$falta=new Faltas();
$Id_objeto=227; 

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

$usuario_x= $_SESSION['id_usuario'];

$id_falta=isset($_POST["id_falta"])?  $instancia_conexion->limpiarCadena($_POST["id_falta"]):"";
$id_tipo_falta=isset($_POST["id_tipo_falta"])? $instancia_conexion->limpiarCadena($_POST["id_tipo_falta"]):"";
$fch_falta=isset($_POST["fch_falta"])? $instancia_conexion->limpiarCadena($_POST["fch_falta"]):"";
$id_persona_alumno=isset($_POST["id_persona_alumno"])? $instancia_conexion->limpiarCadena($_POST["id_persona_alumno"]):"";
$descripcion=isset($_POST["descripcion"])? $instancia_conexion->limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_falta)) {
				
				$sql = "SELECT concat(nombres,' ',apellidos) AS nombres FROM tbl_personas WHERE id_persona= '$id_persona_alumno'";
				$resulta_valor = $mysqli->query($sql);
				$valor_v = $resulta_valor->fetch_array(MYSQLI_ASSOC);
		
				$rspta=$falta->insertar($id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion, $usuario_x);
				echo $rspta ? "Falta Registrada" : "Falta no se pudo registrar";
				
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UNA NUEVA FALTA PARA EL ALUMNO ALUMNO: '. $valor_v['nombres'] . '');
				 
		} else {
			
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select * from view_faltas_conducta2 WHERE id_falta= '$id_falta'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				$sql2 = "SELECT concat(nombres,' ',apellidos) AS nombres FROM tbl_personas WHERE id_persona= '$id_persona_alumno'";
				$resulta_n = $mysqli->query($sql2);
				$valor_n = $resulta_n->fetch_array(MYSQLI_ASSOC);

				$sql3 = "SELECT id_falta, nombre_falta FROM tbl_voae_tipos_faltas WHERE id_falta= '$id_tipo_falta'";
				$resulta_tipo = $mysqli->query($sql3);
				$tipo_falta_n = $resulta_tipo->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DE TODOS LOS CAMPOS
				if ($valor_viejo['id_tipo_falta'] <> $id_tipo_falta and $valor_viejo['id_persona_alumno'] <> $id_persona_alumno and $valor_viejo['fch_falta'] <> $fch_falta and $valor_viejo['descripcion'] <> $descripcion){

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA FALTA CON EL ID ' . $id_falta . ': CAMBIO TIPO DE FALTA: "'.$valor_viejo['nombre_falta'] . '" POR: "'.$tipo_falta_n['nombre_falta'] . '"; CAMBIO FECHA FALTA: "'.$valor_viejo['fch_falta'] . '" POR: "'.$fch_falta . '"; CAMBIO NOMBRE ALUMNO: "'.$valor_viejo['nombres'] . '" POR: "'.$valor_n['nombres'] . '"  Y MODIFICO LA DESCRIPCION');
					$rspta=$falta->editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion);
					echo $rspta ? "Falta Actualizada" : "Error al actualizar";

				

				//CONDICION PARA LA MODIFICACION DEL TIPO DE FALTA
				} elseif ($valor_viejo['id_tipo_falta'] <> $id_tipo_falta) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA FALTA CON EL ID ' . $id_falta . ': CAMBIO TIPO DE FALTA: "'.$valor_viejo['nombre_falta'] . '" POR: "'.$tipo_falta_n['nombre_falta'] . '"');
					$rspta=$falta->editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion);
					echo $rspta ? "Falta Actualizada" : "Error al actualizar";

				//CONDICION PARA LA MODIFICACION DE LA FECHA DE LA FALTA
				}elseif ($valor_viejo['fch_falta'] <> $fch_falta) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA FALTA CON EL ID ' . $id_falta . ': CAMBIO FECHA: "'.$valor_viejo['fch_falta'] . '" POR: "'.$fch_falta . '"');
					$rspta=$falta->editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion);
					echo $rspta ? "Falta Actualizada" : "Error al actualizar";

				//CONDICION PARA LA MODIFICACION DEL ALUMNO
				}elseif ($valor_viejo['id_persona_alumno'] <> $id_persona_alumno) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA FALTA CON EL ID ' . $id_falta . ': CAMBIO NOMBRE ALUMNO: "'.$valor_viejo['nombres'] . '" POR: "'.$valor_n['nombres']. '"');
					$rspta=$falta->editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion);
					echo $rspta ? "Falta Actualizada" : "Error al actualizar";

				//CONDICION PARA LA MODIFICACION DE LA DESCRIPCION
				}elseif ($valor_viejo['descripcion'] <> $descripcion) {

					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA FALTA CON EL ID ' . $id_falta . ': EDITO DESCRIPCIÓN');
					$rspta=$falta->editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion);
					echo $rspta ? "Falta Actualizada" : "Error al actualizar";

				}
			}
		
		 //FIN
	break;
 



	case 'mostrar':
	
		$rspta=$falta->mostrar($id_falta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'eliminar':
    $sql2 = "select concat(`tbl_personas`.`nombres`,' ',`tbl_personas`.`apellidos`) AS `nombres` from (((`tbl_voae_faltas_conductas` join `tbl_personas` on(`tbl_voae_faltas_conductas`.`id_persona_alumno` = `tbl_personas`.`id_persona`)) join `tbl_voae_tipos_faltas` on(`tbl_voae_faltas_conductas`.`id_tipo_falta` = `tbl_voae_tipos_faltas`.`id_falta`)) join `tbl_personas_extendidas` on(`tbl_voae_faltas_conductas`.`id_persona_alumno` = `tbl_personas_extendidas`.`id_persona`)) WHERE `tbl_voae_faltas_conductas`.`id_falta` = '$id_falta'";
        $resulta_n = $mysqli->query($sql2);
        $valor_n = $resulta_n->fetch_array(MYSQLI_ASSOC);

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', ' LA FALTA CON EL ID ' . $id_falta . ': DEL ALUMNO: '. $valor_n['nombres']. '');
    $rspta=$falta->eliminar($id_falta);
    echo $rspta ? "Registro Eliminado" : "Error";

  break;



	case 'listar':
	
		$rspta=$falta->listar();
 		//Vamos a declarar un array
 		$data= Array();
 		
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				
 				"0"=>'<form action="../vistas/historial_faltas_cve_vista.php" method="POST">

                        <input type="hidden" name="cuenta" value="'.$reg->valor.'">
                        <input type="hidden" name="nombre" value="'.$reg->nombre_alumno.'">
                        <button title="Ver Historial" class="btn btn-primary" type="submit" ><i class="fas fa-chalkboard-teacher"></i></button>
                       </form>', 
 				
 				"1"=>$reg->nombre_alumno,
 				"2"=>$reg->valor,
 				"3"=>$reg->total_faltas
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

