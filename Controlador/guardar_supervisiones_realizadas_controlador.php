<?php
require_once "../Modelos/asignar_docente_supervisor_modelo.php";

$modelo=new asignaturas();


$id_supervisor=isset($_POST["id_supervisor"])? limpiarCadena($_POST["id_supervisor"]):"";
$nombre_alumno=isset($_POST["nombre_alumno"])? limpiarCadena($_POST["nombre_asignatura"]):"";
$cuenta=isset($_POST["cuenta"])? limpiarCadena($_POST["id_codigo"]):"";
$docente=isset($_POST["docente"])? limpiarCadena($_POST["docente"]):"";



switch ($_GET["op"]){
	

	case 'mostrar':
		$rspta=$modelo->mostrar($id_supervisor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;

	case 'listar':
		$rspta=$modelo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			
			 $estado="";
			 $primera_supervision_boton='<center><div class="input-group mr-2" ><form  action="../pdf/primera_visita_docente_pdf.php" method="post"><button class="btn btn-primary btn-raised btn-sm" name="id_asignatura" value="'.$reg->id_persona.'"> <i class="far fa-file-pdf"> </i> </button></form></div></center>';
			 $segunda_supervision_boton='<center><div class="input-group mr-2" ><form  action="../pdf/segunda_visita_docente_pdf.php" method="post"><button class="btn btn-primary btn-raised btn-sm" name="id_asignatura" value="'.$reg->id_persona.'"> <i class="far fa-file-pdf"></i> </button></form></div></center>';
			 $tercera_supervision_boton='<center><div class="input-group mr-2" ><form  action="../pdf/unica_visita_docente_pdf.php" method="post"><button class="btn btn-primary btn-raised btn-sm" name="id_asignatura" value="'.$reg->id_persona.'"> <i class="far fa-file-pdf"></i> </button></form></div></center>';


			
			 
				 
 			$data[]=array(
				 
                "0"=>$reg->nombre,
 				"1"=>$reg->documento,
				"2"=>$reg->nombre_empresa,
				"3"=>$reg->direccion_empresa,
				"4"=>$reg->fecha_inicio,
				"5"=>$reg->fecha_finaliza,
				"6"=>$primera_supervision_boton,
				"7"=>$segunda_supervision_boton,
				"8"=>$tercera_supervision_boton,



			

				

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
