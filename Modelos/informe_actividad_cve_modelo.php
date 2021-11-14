<?php 
//Incluímos inicialmente la conexión a la base de datos


require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require "../clases/Conexionvoae.php";
require "../clases/funcion_permisos.php";



Class informe_actividad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}



	
	//Implementamos un método para insertar registros
	public function insertar($nombre_archivo,
							$dir_repositorio,
							$id_actividad,
							$introduccion,
							$objetivos,
							$desarrollo,
							$conclusiones,
							$id_usuario_registro,
							$id_estado)
	{
		$sql = "call proc_insertar_informe_cve(	'$nombre_archivo',
												'$dir_repositorio',
												'$id_actividad',
												'$introduccion',
												'$objetivos',
												'$desarrollo',
												'$conclusiones',
												'$id_usuario_registro',
												'$id_estado')";
		return ejecutarConsulta($sql);

		
	}

	//Implementamos un método para editar registros
	public function editar(	$id_informe,
							$id_repositorio,
							$nombre_archivo,
							$dir_repositorio,
							$id_actividad,
							$introduccion,
							$objetivos,
							$desarrollo,
							$conclusiones,
							$id_usuario_registro,
							$id_estado)
	{
		$sql="call proc_actualizar_informe_voae('$id_informe',
												'$id_repositorio',
												'$nombre_archivo',
												'$dir_repositorio',
												'$id_actividad',
												'$introduccion',
												'$objetivos',
												'$desarrollo',
												'$conclusiones',
												'$id_usuario_registro',
												'$id_estado')";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_informe)
	{
		$sql="SELECT * FROM view_informes_actividades_completa WHERE id_informe='$id_informe'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($usuario)
	{
		$sql="CALL vista_informes('$usuario')";
		return ejecutarConsulta($sql);		
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($id_informe)
	{
		$sql="CALL proc_eliminar_informe_voae('$id_informe');";
		return ejecutarConsulta($sql);
	}
}

?>