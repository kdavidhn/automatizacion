<?php 
//Incluímos inicialmente la conexión a la base de datos


require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();



Class Externa 
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_act,$ente,$usuario,$ambito,$periodo,$tipo,$fecha_inicio,$fecha_final)
	{
		global $instancia_conexion;
		$sql="CALL inserta_actividad_externa('$nombre_act','$ente','$usuario','$ambito','$periodo','$fecha_inicio','$fecha_final')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_actividad_voae,$nombre_act,$fecha_inicio,$fecha_final,$ente,$usuario,$ambito,$periodo)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET nombre_actividad=trim(upper('$nombre_act')),fch_inicial_actividad='$fecha_inicio',fch_final_actividad='$fecha_final',staff_alumnos=trim(upper('$ente')),id_ambito='$ambito',periodo='$periodo' WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	
	public function eliminar($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="CALL eliminar_act_externa('$id_actividad_voae')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_actividades WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_actividades where tipo_actividad='ACTIVIDAD EXTERNA'";
		return $instancia_conexion->ejecutarConsulta($sql);	
			
	}
	//Implementar un método para listar los registros
	public function listar2($actividad)
	{
		global $instancia_conexion;
		$sql="SELECT nombre_alumno, cuenta, cant_horas FROM tbl_voae_asistencias where id_actividad_voae='$actividad'";
		return $instancia_conexion->ejecutarConsulta($sql);	
			
	}

	
}

?>