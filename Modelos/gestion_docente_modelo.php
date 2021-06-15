<?php
require_once ('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion();

class modelo_gestion_docente
{


  
//   public function eliminar($id_persona)
// 	{
//         global $instancia_conexion;
// 		$sql="DELETE proc_gestion_docente  WHERE id_persona='$id_persona' ";
// 		return $instancia_conexion->ejecutarConsulta($sql);
// 	}  

     function listar(){
     global $instancia_conexion;
		$sql="call proc_gestion_docente()";
    $arreglo = array();
    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
        $arreglo["data"][] = $consulta_VU;
      }
      return $arreglo;
    }


}
  function Actividades($id_persona)
  {
    global $instancia_conexion;
    $consulta = $instancia_conexion->ejecutarConsulta("SELECT ACTP.id_act_persona, COM.comision, ACT.actividad  FROM tbl_actividades ACT
                JOIN tbl_actividades_persona ACTP ON ACT.id_actividad= ACTP.id_actividad
                JOIN tbl_comisiones COM ON COM.id_comisiones = ACT.id_comisiones
                WHERE ACTP.id_persona = $id_persona
        ");
  
    $actividades = array();
    

    while ($row = $consulta->fetch_assoc()) {

      $actividades['actividades'][] = $row;
    }

    //echo '<pre>';print_r($actividades);echo'</pre>';
    return $actividades;
  }
  function EliminarTelefono($eliminar_actividad)
  {
    global $instancia_conexion;
    $consulta = $instancia_conexion->ejecutarConsulta("DELETE FROM tbl_actividades_persona WHERE id_act_persona='$eliminar_actividad';");

    return $consulta;
  }

  function actualizarestado($Estado,$id_persona_)
  {
    global $instancia_conexion;
    $sql = "CALL proc_estado_usuario('$Estado', '$id_persona_');";
    
    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      return 1;
    } else {
      return 0;
    }
    
  }
  function existe_actividad($id_persona1, $id_actividad)
  {
    global $instancia_conexion;
    $sql5 = "CALL sel_actividades_personas('$id_persona1','$id_actividad')";
    return $instancia_conexion->ejecutarConsultaSimpleFila($sql5);
  }
  function insertar_actividades($actividades, $id_persona)
  {
    global $instancia_conexion;
    $sql = "CALL proc_prueba_api($actividades, $id_persona);";

    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      return 1;
    } else {
      return 0;
    }
  }

  function listar_selectJOR(){
    global $instancia_conexion;
    $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_jornadas');

    return $consulta;

}

function listar_selectCAT(){
  global $instancia_conexion;
  $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_categorias');

  return $consulta;

}

function listar_selectHOR(){
  global $instancia_conexion;
  $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_hora');

  return $consulta;

}

function listar_selectNACI(){
  global $instancia_conexion;
  $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_nacionalidad');

  return $consulta;

}

function descripcion_jornada($id_jornada)
    {
        global $instancia_conexion;
        $sql = "call sel_jornada_docente('$id_jornada')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }


  function modificar_gestion($sued, $num_empleado, $identidad, $id_jornada_, $id_categoria_, $hr_inicial_, $hr_final_, $id_persona_)
  {

    global $instancia_conexion;

    $sql = "call proc_modificar_gestion('$sued', '$num_empleado', '$identidad', '$id_jornada_','$id_categoria_','$hr_inicial_','$hr_final_','$id_persona_')";

    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      return 1;
    } else {
      return 0;
    }
  }
  function select_periodo()
  {
    global $instancia_conexion;
    $consulta = $instancia_conexion->ejecutarConsulta('SELECT tbl_periodo.id_periodo AS id_periodo, tbl_periodo.num_periodo AS num_periodo, tbl_periodo.num_anno AS num_anno, tbl_periodo.fecha_adic_canc AS fecha_adic_canc, tbl_periodo.fecha_desbloqueo AS fecha_desbloqueo,
(SELECT tp.descripcion FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS tipo_periodo,
			(SELECT tp.horas_validas FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS horas_validas
FROM tbl_periodo
ORDER BY id_periodo DESC LIMIT 1;');

    return $consulta;
  }

}



?>
