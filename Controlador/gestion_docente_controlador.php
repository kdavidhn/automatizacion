<?php
require_once "../Modelos/gestion_docente_modelo.php";

$id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";
$eliminar_actividad = isset($_POST["eliminar_actividad"]) ? limpiarCadena1($_POST["eliminar_actividad"]) : "";
$id_persona_ = isset($_POST["id_persona_"]) ? limpiarCadena1($_POST["id_persona_"]) : "";
$Estado = isset($_POST["Estado"]) ? limpiarCadena1($_POST["Estado"]) : "";
$id_persona1 = isset($_POST["id_persona1"]) ? limpiarCadena1($_POST["id_persona1"]) : "";
$id_actividad = isset($_POST["id_actividad"]) ? limpiarCadena1($_POST["id_actividad"]) : "";
$id_jornada = isset($_POST["id_jornada"]) ? limpiarCadena1($_POST["id_jornada"]) : "";
$sued = isset($_POST["sued"]) ? limpiarCadena1($_POST["sued"]) : "";
$identidad = isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
$num_empleado = isset($_POST["num_empleado"]) ? limpiarCadena1($_POST["num_empleado"]) : "";
$jornada_=isset($_POST["jornada_"]) ? limpiarCadena1($_POST["jornada_"]) : "";
$categoria_ = isset($_POST["categoria_"]) ? limpiarCadena1($_POST["categoria_"]) : "";
$hra_inicio = isset($_POST["hra_inicio"]) ? limpiarCadena1($_POST["hra_inicio"]) : "";
$hra_final = isset($_POST["hra_final"]) ? limpiarCadena1($_POST["hra_final"]) : "";
$id_persona__= isset($_POST["id_persona__"]) ? limpiarCadena1($_POST["id_persona__"]) : "";

$instancia_modelo=new modelo_gestion_docente();

switch ($_GET["op"])
{
   
  
  case 'Actividades':

    $rspta = $instancia_modelo->Actividades($id_persona);
    echo json_encode($rspta);

    break;
  case 'eliminar_actividad':


    $rspta = $instancia_modelo->EliminarTelefono($eliminar_actividad);

  break;
  case 'estado':


    $rspta = $instancia_modelo->actualizarestado( $Estado, $id_persona_);

  break;
  case 'existe_actividad':
    $rspta = $instancia_modelo->existe_actividad($id_persona1, $id_actividad);
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;
  case 'insertar_actividades':

    $rspta = $instancia_modelo->insertar_actividades($id_actividad, $id_persona1);
    echo json_encode($rspta);

    break;

    case 'selectJOR':
      if (isset($_POST['activar'])) {
          $data=array();
          $respuesta=$instancia_modelo->listar_selectJOR();
         
            while ($r=$respuesta->fetch_object()) {
         
               
                 # code...
                 echo "<option value='". $r->id_jornada."'> ".$r->jornada." </option>";
                 
             }
         
          
           }
           else{
             echo 'No hay informacion';
           }
         
  break;

  case 'selectCAT':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectCAT();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->id_categoria."'> ".$r->categoria." </option>";
               
           }
       
        
         }
         else{
           echo 'No hay informacion';
         }
       
  break;

  case 'selectHEN':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectHOR();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->hora."'> ".$r->hora." </option>";
               
           }
       
        
         }
         else{
           echo 'No hay informacion';
         }
       
  break;
  
  case 'selectHSAL':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectHOR();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->hora."'> ".$r->hora." </option>";
               
           }
       
        
         }
         else{
           echo 'No hay informacion';
         }
       
  break;
  
  case 'selectNACI':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectNACI();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->nacionalidad."'> ".$r->nacionalidad." </option>";
               
           }
       
        
         }
         else{
           echo 'No hay informacion';
         }
       
break;

  case 'descripcion':
    $rspta = $instancia_modelo->descripcion_jornada($id_jornada);
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;
  case 'modificar_gestion':
    $rspta = $instancia_modelo->modificar_gestion($sued, $num_empleado, $identidad, $jornada_, $categoria_, $hra_inicio, $hra_final, $id_persona__);
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;
  case 'select_periodo':
    $rspta = $instancia_modelo->select_periodo();
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;



 }




?>
