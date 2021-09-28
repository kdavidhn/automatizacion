<?php 
//Incluímos inicialmente la conexión a la base de datos


require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');





Class Horas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_act,$ubicacion,$fecha_inicio,$fecha_final,$descripcion,$observaciones,$usuario,$ambito,$periodo)
	{
		$sql="CALL inserta_actividad_externa('$nombre_act','$ubicacion','$fecha_inicio','$fecha_final','$descripcion','$observaciones','$usuario','$ambito','$periodo')";
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
	public function listar($usuario)
	{
		$sql="CALL vista_horas('$usuario')";
		return ejecutarConsulta($sql);	
			
	}

	public function listar2($cuenta)
	{
		$sql="SELECT tbl_voae_asistencias.id_asistencia, tbl_voae_asistencias.id_actividad_voae, tbl_voae_asistencias.nombre_alumno, tbl_voae_actividades.nombre_actividad, tbl_voae_actividades.fch_inicial_actividad, tbl_voae_ambitos.nombre_ambito AS ambito, tbl_voae_asistencias.cant_horas,tbl_voae_actividades.tipo_actividad FROM tbl_voae_asistencias JOIN tbl_voae_actividades ON tbl_voae_asistencias.id_actividad_voae= tbl_voae_actividades.id_actividad_voae JOIN tbl_voae_ambitos ON tbl_voae_actividades.id_ambito = tbl_voae_ambitos.id_ambito where cuenta = '$cuenta'";
		return ejecutarConsulta($sql);	
			
	}

	
}

?>