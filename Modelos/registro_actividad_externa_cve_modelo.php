<?php 
//Incluímos inicialmente la conexión a la base de datos


require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require "../clases/Conexionvoae.php";
require "../clases/funcion_permisos.php";



Class Externa
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_act,$ubicacion,$fecha_inicio,$fecha_final,$descripcion,$ente,$usuario,$ambito,$periodo)
	{
		$sql="CALL inserta_actividad_externa('$nombre_act','$ubicacion','$fecha_inicio','$fecha_final','$descripcion','$ente','$usuario','$ambito','$periodo')";
		return ejecutarConsulta($sql);
	}

	public function insertar_horas($id_persona_alumno,$id_actividad,$horas_alumno)
	{
		$sql="CALL inserta_horas_alumno('$id_persona_alumno','$id_actividad','$horas_alumno')";
		return ejecutarConsulta($sql);
	}
	
	
	public function eliminar($id_asistencia)
	{
		$sql="DELETE FROM tbl_voae_asistencias WHERE id_asistencia='$id_asistencia'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbl_voae_actividades where tipo_actividad='ACTIVIDAD EXTERNA'";
		return ejecutarConsulta($sql);	
			
	}

	
}

?>