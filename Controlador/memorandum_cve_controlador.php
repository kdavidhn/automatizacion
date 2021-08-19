<?php 
ob_start();
session_start();

require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once "../Modelos/memorandum_cve_modelo.php";
require_once ('../clases/funcion_bitacora.php');

$memorandum=new memorandum();
$Id_objeto=233; 
if (permisos::permiso_eliminar($Id_objeto)==0)
  {
    $_SESSION["btneliminar"]="hidden";
  }
else
  {
    $_SESSION["btneliminar"]="";
  }
  if (permisos::permiso_modificar($Id_objeto)==0)
  {
    $_SESSION["btnmodificar"]="hidden";
  }
else
  {
    $_SESSION["btnmodificar"]="";
  }
// id_memo	no_memo	id_tipo_memo	remitente	destinatario	fecha	 asunto  contenido

$id_memo=isset($_POST["id_memo"])? limpiarCadena($_POST["id_memo"]):"";
$no_memo=isset($_POST["no_memo"])? limpiarCadena($_POST["no_memo"]):"";
$id_tipo_memo=isset($_POST["id_tipo_memo"])? limpiarCadena($_POST["id_tipo_memo"]):"";
$remitente=isset($_POST["remitente"])? limpiarCadena($_POST["remitente"]):"";
$destinatario=isset($_POST["destinatario"])? limpiarCadena($_POST["destinatario"]):"";
//$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$asunto=isset($_POST["asunto"])? limpiarCadena($_POST["asunto"]):"";
$contenido=isset($_POST["contenido"])? limpiarCadena($_POST["contenido"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_memo)){

			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste=("select count(no_memo) as no_memo  from tbl_voae_memorandums where no_memo='$no_memo'");
			//OBTENER LA ULTIMA FILA DEL QUERY
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			//CONDICION PARA QUE NO SE REPITA EL NOMBRE
			if ($existe['no_memo']== 1) {
				echo 'EL MEMORANDUM YA EXISTE, INGRESE UNO DIFERENTE';

			} else {
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$memorandum->insertar($no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido);
				echo $rspta ? "Memorandum Registrado" : "El MEMORANDUM  no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL MEMORANDUM "' . $no_memo . '"');
			}

		} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(no_memo) as no_memo from tbl_voae_memorandums where no_memo='$no_memo' and id_memo<>'$id_memo' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['no_memo'] == 1) {
				echo 'EL MEMORANDUM YA EXISTE, INGRESE DIFERENTE';

			} else {
				
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select id_memo, no_memo, id_tipo_memo, remitente,destinatario,asunto,contenido from tbl_voae_memorandums WHERE id_memo= '$id_memo'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DEL NOMBRE Y ACTIVIDAD
				if ($valor_viejo['no_memo'] <> $no_memo and $valor_viejo['id_tipo_memo'] <> $id_tipo_memo) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL MEMORANDUM "' . $valor_viejo['no_memo'] . '" POR "' . $no_memo . '" Y LA ACTIVIDAD "'. $valor_viejo['id_tipo_memo'] . '"POR"' . $id_tipo_memo .'" ');

					$rspta=$memorandum->editar($id_memo,$no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido);
					echo $rspta ? "MEMORANDUM fue actualizado" : "MEMORANDUM no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DEL REMITENTE
				} elseif ($valor_viejo['remitente'] <> $remitente) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EN EL MEMORANDUM EL REMITENTE"' . $valor_viejo['remitente'] . '" POR "' . $remitente . '" ');

					$rspta=$memorandum->editar($id_memo,$no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido);
					echo $rspta ? "El MEMORANDUM fue actualizado" : "EL MEMORANDUM no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DEL DESTINATARIO
				} elseif ($valor_viejo['destinatario'] <> $destinatario) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EN EL MEMORANDUM EL DESTINATARIO "' . $valor_viejo['destinatario'] . '"POR "' .$destinatario .'" ');

				$rspta=$memorandum->editar($id_memo,$no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido);
				echo $rspta ? "El MEMORANDUM fue actualizado" : "EL MEMORANDUM no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DE EL ASUNTO
				}elseif ($valor_viejo['asunto'] <> $asunto) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EN EL MEMORANDUM EL ASUNTO "' . $valor_viejo['asunto'] . '"POR "' .$asunto .'" ');
				
				$rspta=$memorandum->editar($id_memo,$no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido);
				echo $rspta ? "El MEMORANDUM fue actualizado" : "EL MEMORANDUM no se pudo actualizar";

				//CONDICION PARA LA MODIFICACION DE EL CONTENIDO
				}elseif ($valor_viejo['contenido'] <> $contenido) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EN EL MEMORANDUM EL CONTENIDO "' . $valor_viejo['contenido'] . '"POR "' .$contenido .'" ');
				
				$rspta=$memorandum->editar($id_memo,$no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido);
				echo $rspta ? "El MEMORANDUM fue actualizado" : "EL MEMORANDUM no se pudo actualizar";
				} 

				/*
				$valor = "select id_memo,no_memo, id_tipo_memo, remitente,destinatario,fecha,asunto,contenido from tbl_voae_memorandums WHERE id_memo= '$id_memo'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				
				$rspta=$memorandum->editar($id_memo,$no_memo,$id_tipo_memo,$remitente,$destinatario,$fecha,$asunto,$contenido);
					echo $rspta ? "MEMORANDUM ACTUALIZADO" : "EL MEMORANDUM NO SE PUEDE ACTUALIZAR";
					*/
			}
		} //FIN
	break;


	case 'mostrar':

		$rspta=$memorandum->mostrar($id_memo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'eliminar':
		
		$valor = "select no_memo from tbl_voae_memorandums where id_memo= '$id_memo'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_ambito = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL AMBITO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'EL MEMORANDUM: ' . $bt_nombre_ambito['no_memo'] . '');
		$rspta=$memorandum->eliminar($id_memo);
 		echo $rspta ? "Registro Eliminado" : "Error";

	break;


	case 'listar':
	
	
 		$rspta=$memorandum->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(

 				"0"=>'<button  class="btn btn-warning" '.$_SESSION['btnmodificar'].' style="display:inline;"  onclick="mostrar('.$reg->id_memo.')"><i class="far fa-edit"></i></button>'.
 					 ' <form action="../Controlador/memorandum_cve_generarpdf.php" method="POST" style="display:inline;">
					   <input type="hidden" name="id_memo" value="'.$reg->id_memo.'">
					   <button title="Generar PDF"  class="btn btn-danger"  type="submit" ><i class="fas fa-file-pdf"></i></button></form>'.
 					 ' <button class="btn btn-danger" '.$_SESSION['btneliminar'].' style="display:inline;"   onclick="eliminar('.$reg->id_memo.')"><i class="fas fa-trash-alt"></i></button>',
 				"1"=>$reg->no_memo,
 				"2"=>$reg->nombre_tipo_memorandum,		
 				"3"=>$reg->remitente,
 				"4"=>$reg->destinatario,
 				"5"=>$reg->fecha

 				
 			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	

break;
ob_end_flush();
}



