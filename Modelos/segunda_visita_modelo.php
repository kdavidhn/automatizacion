<?php
require "../clases/conexion_mantenimientos.php";
session_start();


$instancia_conexion = new conexion();

class segunda_visita
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

    }
    
	//Implementamos un método para insertar registros de una visita unica de supervision
	public function insertar($numero_cuenta,$asistencia,$horario,$adaptacion
    ,$cumplimiento,$calidad,$percepcion_conocimiento,$percepcion_habilidad,$comentario,$area_refuerzo
    ,$calificacion,$solicitar,$representante,$lugar,$oportunidad)
	{
		$visita="Segunda Supervisión";
        global $instancia_conexion;
		$sql = "call ins_segunda_visita('$numero_cuenta',
									  '$comentario',
									  '$area_refuerzo',
									  '$calificacion',
									  '$solicitar',
									  '$oportunidad',
									  '$representante',
									  '$lugar',
									  '$visita',
									  '$asistencia',
									  '$horario',
									  '$adaptacion',
									  '$cumplimiento',
									  '$calidad',
									  '$percepcion_conocimiento',
									  '$percepcion_habilidad')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	public function selectCurso(){
		global $instancia_conexion ;
		$id_persona1=$_SESSION['id_persona'];
      $sql="SELECT concat(p.nombres,' ',p.apellidos) as nombres, pe.id_persona 
      FROM tbl_practica_estudiantes pe, tbl_personas p
      
      WHERE p.id_persona=pe.id_persona AND pe.estado=1 AND pe.docente_supervisor='$id_persona1'
                                       AND pe.horas=800;";
		  return $instancia_conexion->ejecutarConsulta($sql);
  
	  }
  
  
	  public function rellenarDatos($id_persona){
		  global $instancia_conexion ;
		  $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombres, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

		  FROM
  
		  tbl_empresas_practica AS ep
		  JOIN tbl_personas AS a
		  ON ep.id_persona = a.id_persona
		  JOIN tbl_practica_estudiantes AS pe
		  ON pe.id_persona = a.id_persona
		  JOIN tbl_contactos c ON a.id_persona = c.id_persona
		  JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
		  JOIN tbl_contactos e ON a.id_persona = e.id_persona
		  JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
		  join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona and pe.id_persona='$id_persona';";			return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	
		}
  
	  

}


























?>


