<?php
require "../clases/conexion_mantenimientos.php";
session_start();


$instancia_conexion = new conexion();

class unica_visita
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

    }
    
	//Implementamos un método para insertar registros de una visita unica de supervision
	public function insertar($numero_cuenta,$funciones,$funciones_diseno,$funciones_redes,$funciones_capacitacion,$funciones_seguridad
    ,$funciones_auditoria,$funciones_base,$funciones_soporte,$funciones_programacion,$comunicacion,$oportunidad
    ,$puntualidad,$responsabilidad,$creatividad,$presentacion,$atencion,$colaborativo,$trabajo_equipo
    ,$proactivo,$relaciones,$analisis,$diseno,$programador,$mantenimiento,$asistencia,$horario,$adaptacion
    ,$cumplimiento,$calidad,$percepcion_conocimiento,$percepcion_habilidad,$comentario,$area_refuerzo
    ,$calificacion,$solicitar,$representante,$lugar,$aspecto_a,$aspecto_s)
   

    
	{
        $visita="Única Supervisión";
        global $instancia_conexion;
        $sql = "CALL ins_unica_visita('$numero_cuenta',
                            '$comentario',
                            '$area_refuerzo',
                            '$calificacion',
                            '$solicitar',
                            '$oportunidad',
                            '$representante',
                            '$lugar',
                            '$visita',
                            '$funciones',
                            '$funciones_diseno',
                            '$funciones_redes',
                            '$funciones_capacitacion',
                            '$funciones_seguridad',
                            '$funciones_auditoria',
                            '$funciones_base',
                            '$funciones_soporte',
                            '$funciones_programacion',
                            '$comunicacion',
                            '$puntualidad',
                            '$responsabilidad',
                            '$creatividad',
                            '$presentacion',
                            '$atencion',
                            '$colaborativo',
                            '$trabajo_equipo',
                            '$proactivo',
                            '$relaciones',
                            '$analisis'
                            '$diseno',
                            '$programador',
                            '$mantenimiento',
                            '$aspecto_a',
                            '$aspecto_s',
                            '$asistencia',
                            '$horario',
                            '$adaptacion',
                            '$cumplimiento',
                            '$calidad',
                            '$percepcion_conocimiento',
                            '$percepcion_habilidad',
                            'a')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}



    public function selectCurso(){
        global $instancia_conexion ;
        $id_persona1=$_SESSION['id_persona'];
        $sql="SELECT concat(p.nombres,' ',p.apellidos) as nombres, pe.id_persona 
        FROM tbl_practica_estudiantes pe, tbl_personas p
        
        WHERE p.id_persona=pe.id_persona AND pe.estado=1 AND pe.docente_supervisor='$id_persona1'
                                         AND pe.horas=400;";
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
          join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona and pe.id_persona='$id_persona';";
            return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    
        }

}


























?>


