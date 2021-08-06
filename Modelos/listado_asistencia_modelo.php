<?php 
//Incluímos inicialmente la conexión a la base de datos


require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require "../clases/Conexionvoae.php";
require "../clases/funcion_permisos.php";



Class listado_asistencia
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_actividad_voae,$cuenta,$nombre_alumno,$cant_horas, $carrera )
	{
		$sql = "INSERT INTO `tbl_voae_asistencias` ( `id_actividad_voae`, `cuenta`, `nombre_alumno`, `cant_horas`, `carrera`) 
				VALUES ('$id_actividad_voae','$cuenta','$nombre_alumno','$cant_horas', '$carrera');
		";
		return ejecutarConsulta($sql);

		
	}

	//Implementamos un método para editar registros
	public function editar(	$id_asistencia,$cuenta,$nombre_alumno,$cant_horas, $carrera)
	{
		$sql="UPDATE tbl_voae_asistencias SET cuenta = '$cuenta', nombre_alumno = '$nombre_alumno', cant_horas = '$cant_horas', carrera = '$carrera'
		 WHERE  id_asistencia='$id_asistencia';";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_asistencia)
	{
		$sql="SELECT * FROM tbl_voae_asistencias WHERE id_asistencia='$id_asistencia'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($id_actividad_voae)
	{
		$sql="SELECT * FROM tbl_voae_asistencias where id_actividad_voae = '$id_actividad_voae' ";
		return ejecutarConsulta($sql);		
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($id_asistencia)
	{
		$sql="DELETE FROM tbl_voae_asistencias WHERE id_asistencia='$id_asistencia' ";
		return ejecutarConsulta($sql);
	}
}

?>