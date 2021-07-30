<?php 
//Incluímos inicialmente la conexión a la base de datos


require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require "../clases/Conexionvoae.php";
require "../clases/funcion_permisos.php";



Class Actividad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$usuario,$id_ambito,$periodo)
	{
	$sql="call insertar_actividad ('$no_solicitud','$nombre_actividad','$ubicacion','$fch_inicial_actividad','$fch_final_actividad','$descripcion','$poblacion_objetivo','$presupuesto','$staff_alumnos','$observaciones','$usuario','$id_ambito','$periodo')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo)
	{
		$sql="UPDATE tbl_voae_actividades SET no_solicitud=trim(upper('$no_solicitud')),nombre_actividad=trim(upper('$nombre_actividad')),ubicacion=trim(upper('$ubicacion')),fch_inicial_actividad='$fch_inicial_actividad',fch_final_actividad='$fch_final_actividad',descripcion=trim(upper('$descripcion')),poblacion_objetivo=trim(upper('$poblacion_objetivo')),presupuesto='$presupuesto',staff_alumnos=trim(upper('$staff_alumnos')),observaciones=trim(upper('$observaciones')),id_ambito='$id_ambito',periodo='$periodo' WHERE id_actividad_voae='$id_actividad_voae'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para denegar categorías
	public function denegar($id_actividad_voae)
	{
		$sql="UPDATE tbl_voae_actividades SET id_estado='14' WHERE id_actividad_voae='$id_actividad_voae'";
		return ejecutarConsulta($sql);
	}
	public function solicitado($id_actividad_voae)
	{
		$sql="UPDATE tbl_voae_actividades SET id_estado='16' WHERE id_actividad_voae='$id_actividad_voae'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para aprobar categorías
	public function aprobar($id_actividad_voae)
	{
		$sql="UPDATE tbl_voae_actividades SET id_estado='13' WHERE id_actividad_voae='$id_actividad_voae'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para Finalizar Actividades
	public function finalizar($id_actividad_voae)
	{
		$sql="call procedimiento_finalizar_actividad('$id_actividad_voae')";
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
		$sql="SELECT * FROM vista_actividad_cve";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros
	public function listar1()
	{
		$sql="SELECT * FROM vista_actividad_cve_1";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listar2()
	{
		$sql="SELECT * FROM vista_actividad_cve_2";
		return ejecutarConsulta($sql);		
	}
}

?>