<?php 
ob_start();
session_start();

require_once "../Modelos/horas_voae_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');


$horas=new Horas();
$Id_objeto = 116;

$cuenta=$_SESSION['cuenta'];

if (permisos::permiso_eliminar($Id_objeto)==0)
  {
    $_SESSION["btneliminar"]="hidden";
  }
else
  {
    $_SESSION["btneliminar"]="";
  }

$usuario=$_SESSION['id_usuario'];
switch ($_GET["op"]){
	
	case 'listar2':
		
 			$rspta=$horas->listar2($cuenta);
 		//Vamos a declarar un array
 		$data= Array();


 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Eliminar Actividad" '.$_SESSION['btneliminar'].' class="btn btn-danger" onclick="eliminar('.$reg->id_asistencia.')"><i class="fas fa-trash-alt"></i></button>',
 				"1"=>$reg->nombre_actividad,
 				"2"=>$reg->fch_inicial_actividad,
 				"3"=>$reg->ambito,
 				"4"=>$reg->cant_horas,
 				"5"=>$reg->tipo_actividad
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


