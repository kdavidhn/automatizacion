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
	public function insertar($nombre_act,$ente,$usuario,$ambito,$periodo,$tipo)
	{
		$sql="CALL inserta_actividad_externa('$nombre_act','$ente','$usuario','$ambito','$periodo')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_actividad_voae,$nombre_act,$ubicacion,$fecha_inicio,$fecha_final,$descripcion,$ente,$usuario,$ambito,$periodo)
	{
		$sql="UPDATE tbl_voae_actividades SET nombre_actividad=trim(upper('$nombre_act')),ubicacion=trim(upper('$ubicacion')),fch_inicial_actividad='$fecha_inicio',fch_final_actividad='$fecha_final',descripcion=trim(upper('$descripcion')),staff_alumnos=trim(upper('$ente')),id_ambito='$ambito',periodo='$periodo' WHERE id_actividad_voae='$id_actividad_voae'";
		return ejecutarConsulta($sql);
	}
	
	public function eliminar($id_actividad_voae)
	{
		$sql="DELETE FROM tbl_voae_actividades WHERE id_actividad_voae='$id_actividad_voae'";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_actividad_voae)
	{
		$sql="SELECT * FROM tbl_voae_actividades WHERE id_actividad_voae='$id_actividad_voae'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbl_voae_actividades where tipo_actividad='ACTIVIDAD EXTERNA'";
		return ejecutarConsulta($sql);	
			
	}

	
}

?>