<?php 
ob_start();
session_start();

require_once "../Modelos/registro_actividad_externa_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');


$externa=new Externa();
$Id_objeto = 237;

$actividad=$_SESSION['id_actividad_cve'];

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
		
 			$rspta=$externa->listar2($actividad);
 		//Vamos a declarar un array
 		$data= Array();


 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->cuenta,
 				"1"=>$reg->nombre_alumno,
 				"2"=>$reg->cant_horas
 				
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


