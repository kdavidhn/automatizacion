<?php
require_once "../Modelos/registro_docente_modelo.php";

$nombre=isset($_POST["nombre"]) ? limpiarCadena1($_POST["nombre"]) : "";
$apellidos=isset($_POST["apellidos"]) ? limpiarCadena1($_POST["apellidos"]) : "";
$identidad=isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
$pasaporte=isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";


$nacionalidad=isset($_POST["nacionalidad"]) ? limpiarCadena1($_POST["nacionalidad"]) : "";
$fecha_nacimiento=isset($_POST["fecha_nacimiento"]) ? limpiarCadena1($_POST["fecha_nacimiento"]) : "";
$estado=isset($_POST["estado"]) ? limpiarCadena1($_POST["estado"]) : "";
$sexo=isset($_POST["sexo"]) ? limpiarCadena1($_POST["sexo"]) : "";
$nempleado=isset($_POST["nempleado"]) ? limpiarCadena1($_POST["nempleado"]) : "";
$tipo_docente=isset($_POST["tipo_docente"]) ? limpiarCadena1($_POST["tipo_docente"]) : "";
$fecha_ingreso=isset($_POST["fecha_ingreso"]) ? limpiarCadena1($_POST["fecha_ingreso"]) : "";
$idjornada=isset($_POST["idjornada"]) ? limpiarCadena1($_POST["idjornada"]) : "";
$idcategoria=isset($_POST["idcategoria"]) ? limpiarCadena1($_POST["idcategoria"]) : "";

$hi=isset($_POST["hi"]) ? limpiarCadena1($_POST["hi"]) : "";
$hf=isset($_POST["hf"]) ? limpiarCadena1($_POST["hf"]) : "";
$codigo = isset($_POST["codigo"])?limpiarCadena1($_POST["codigo"]):"";
$id_jornada = isset($_POST["id_jornada"]) ? limpiarCadena1($_POST["id_jornada"]) : "";




$instancia_modelo = new modelo_registro_docentes();




switch ($_GET["op"]){
    
  case 'selectGRA':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectGRA();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->id_grado_academico."'> ".$r->grado_academico." </option>";
               
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

    case 'selectGEN':
        if (isset($_POST['activar'])) {
            $data=array();
            $respuesta=$instancia_modelo->listar_selectGEN();
           
              while ($r=$respuesta->fetch_object()) {
           
                 
                   # code...
                   echo "<option value='". $r->genero."'> ".$r->genero." </option>";
                   
               }
           
            
             }
             else{
               echo 'No hay informacion';
             }
           
    break;
      

    case 'selectEST':
      if (isset($_POST['activar'])) {
          $data=array();
          $respuesta=$instancia_modelo->listar_selectEST();
         
            while ($r=$respuesta->fetch_object()) {
         
               
                 # code...
                 echo "<option value='". $r->estado_civil."'> ".$r->estado_civil." </option>";
                 
             }
         
          
           }
           else{
             echo 'No hay informacion';
           }
         
  break;
  
  case 'selectNAC':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectNAC();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->nacionalidad."'> ".$r->nacionalidad." </option>";
               
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

case 'ExisteIdentidad':
  $respuesta=$instancia_modelo->ExisteIdentidad($identidad);
  echo json_encode($respuesta);
  
break;
case 'Existepasaporte':
  $respuesta=$instancia_modelo->Existepasaporte($pasaporte);
  echo json_encode($respuesta);
  
break;

    case 'registar':
      $respuesta=$instancia_modelo->registar($nombre,$apellidos, $sexo, $identidad, $nacionalidad, $estado, $fecha_nacimiento, $hi, $hf, $nempleado, $tipo_docente, $fecha_ingreso, $idjornada, $idcategoria);
      
    break;
    case 'registar2':
      $respuesta=$instancia_modelo->registar2($nombre,$apellidos, $sexo, $pasaporte, $nacionalidad, $estado, $fecha_nacimiento, $hi, $hf, $nempleado, $tipo_docente, $fecha_ingreso, $idjornada, $idcategoria);
      
    break;
    
    case 'TipoContacto':
           
           
      $data=array();
      $respuesta=$instancia_modelo->TipoContacto();
     // echo '<pre>';print_r($respuesta);echo'</pre>';
        while ($r=$respuesta->fetch_object()) {


             # code...
            echo "<option value='". $r->id_tipo_contacto."'> ".$r->descripcion." </option>";
            // echo "<option value='1'> 1 </option>";
         }
      
  break;

  case 'mayoria_edad':
    $rspta = $instancia_modelo->mayoria_edad();
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;

  case 'validar_depto':
    $respuesta = $instancia_modelo->validardepto($codigo);
    echo json_encode($respuesta);

    break;

  case 'descripcion':
    $rspta = $instancia_modelo->descripcion_jornada($id_jornada);
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;
    
}
