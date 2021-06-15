<?php
session_start();
require_once "../Modelos/reporte_docentes_modelo.php";
$jornada = isset($_POST["jornada"]) ? limpiarCadena($_POST["jornada"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$comision= isset($_POST["comision"]) ? limpiarCadena($_POST["comision"]) : "";
$carrera = isset($_POST["carrera"]) ? limpiarCadena($_POST["carrera"]) : "";
$categoria = isset($_POST["categoria"]) ? limpiarCadena($_POST["categoria"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$grado_academico = isset($_POST["grado_academico"]) ? limpiarCadena($_POST["grado_academico"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";

$id_persona = $_SESSION['id_usuario'];





$instancia_modelo=new modelo_reporte();

$id_actividad = isset($_POST[$id_actividad]);
$horas_semanales = isset($_POST[$horas_semanales]);


switch ($_GET["op"])
{
   
     /* case 'listar':
      $rspta=$instancia_modelo->listar();
       //Vamos a declarar un array
       $data= Array();
  
       while ($reg=$rspta->fetch_object()){
          $data[]=array(
           
            
          "0"=>$reg->codigo,
          "1"=>$reg->asignatura,
          "2"=>$reg->seccion,
          "3"=>$reg->hra_inicio,
          "4"=>$reg->hra_final,
          "5"=>$reg->dia,
          "6"=>$reg->aula,
          "7"=>$reg->edificio,
          "8"=>$reg->num_alumnos
  
           );
       }
       $results = array(
         "sEcho"=>1, //Información para el datatables
         "iTotalRecords"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
         "aaData"=>$data);
       echo json_encode($results);
  
    break;

  case 'listar2':
    $rspta = $instancia_modelo->listar2();
    //Vamos a declarar un array
    $data = array();

    while ($reg = $rspta->fetch_object()) {
      $data[] = array(


        "0" => $reg->comision,
        "1" => $reg->actividad,
        "2" => $reg->horas_semanales,
       
      );
    }
    $results = array(
      "sEcho" => 1, //Información para el datatables
      "iTotalRecords" => count($data), //enviamos el total registros al datatable
      "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
      "aaData" => $data
    );
    echo json_encode($results);

    break; shif alt a */ 
  case 'mostrar':
    $rspta = $instancia_modelo->mostrar();
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;
  case 'registrar':
    $rspta = $instancia_modelo->registrar($jornada, $descripcion);

    break;
  case 'registrarcomision':
    $rspta = $instancia_modelo->registrarcomision($comision, $carrera);

    break;
    
  case 'registrarcategorias':
    $rspta = $instancia_modelo->registrarcategorias($categoria, $descripcion);

    break;
  case 'registrargrados':
    $rspta = $instancia_modelo->registrargrado($grado_academico, $descripcion);

    break;
    //case 'listar3':
      //$consulta = $instancia_modelo->listar_actividades();
    //if($consulta){
       // echo json_encode($consulta);

    //}else{
    //echo '{
		   // "sEcho": 1,
		   // "iTotalRecords": "0",
		    //"iTotalDisplayRecords": "0",
		   // "aaData": []
	//	}';
    //}
     // break;
      
    case 'modificar':
    $consulta = $instancia_modelo->modificar_horas($id_actividad, $horas_semanales);
        break;
  case 'select2':

    $data = array();
    $respuesta2 = $instancia_modelo->listar_comisiones();

    while ($r2 = $respuesta2->fetch_object()) {


      # code...
      echo "<option value='" . $r2->id_comisiones . "'> " . $r2->comision . " </option>";
    }
    break;
  case 'select3':

    $data = array();
    $respuesta2 = $instancia_modelo->listar_actividad();

    while ($r2 = $respuesta2->fetch_object()) {


      # code...
      echo "<option value='" . $r2->$id_actividad . "'> " . $r2->actividad . " </option>";
    }
    break;
}
?>
