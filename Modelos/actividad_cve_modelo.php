<?php 
require "../clases/conexion_mantenimientos.php";



$instancia_conexion = new conexion();

Class Actividad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$usuario,$id_ambito,$periodo)
	{
	global $instancia_conexion;
	$sql="call insertar_actividad ('$no_solicitud','$nombre_actividad','$ubicacion','$fch_inicial_actividad','$fch_final_actividad','$descripcion','$poblacion_objetivo','$presupuesto','$staff_alumnos','$observaciones','$usuario','$id_ambito','$periodo')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	//Implementamos un método para insertar registros
	public function insertaryenviar($no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$usuario,$id_ambito,$periodo)
	{
		global $instancia_conexion;
		$sql="call insertaryenviar_actividad ('$no_solicitud','$nombre_actividad','$ubicacion','$fch_inicial_actividad','$fch_final_actividad','$descripcion','$poblacion_objetivo','$presupuesto','$staff_alumnos','$observaciones','$usuario','$id_ambito','$periodo')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	public function insertaryenviar2($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET no_solicitud=trim(upper('$no_solicitud')),nombre_actividad=trim(upper('$nombre_actividad')),ubicacion=trim(upper('$ubicacion')),fch_inicial_actividad='$fch_inicial_actividad',fch_final_actividad='$fch_final_actividad',descripcion=trim(upper('$descripcion')),poblacion_objetivo=trim(upper('$poblacion_objetivo')),presupuesto='$presupuesto',staff_alumnos=trim(upper('$staff_alumnos')),observaciones=trim(upper('$observaciones')),id_ambito='$id_ambito',periodo='$periodo', ,id_estado=2 WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	
	//Implementamos un método para editar registros
	public function editar($id_actividad_voae,$no_solicitud,$nombre_actividad,$ubicacion,$fch_inicial_actividad,$fch_final_actividad,$descripcion,$poblacion_objetivo,$presupuesto,$staff_alumnos,$observaciones,$id_ambito,$periodo)
	{	
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET no_solicitud=trim(upper('$no_solicitud')),nombre_actividad=trim(upper('$nombre_actividad')),ubicacion=trim(upper('$ubicacion')),fch_inicial_actividad='$fch_inicial_actividad',fch_final_actividad='$fch_final_actividad',descripcion=trim(upper('$descripcion')),poblacion_objetivo=trim(upper('$poblacion_objetivo')),presupuesto='$presupuesto',staff_alumnos=trim(upper('$staff_alumnos')),observaciones=trim(upper('$observaciones')),id_ambito='$id_ambito',periodo='$periodo' WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para denegar categorías
	public function denegar($id_actividad,$just_act)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET id_estado='4', observaciones = '$just_act'  WHERE id_actividad_voae='$id_actividad'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	public function cancelar($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET id_estado='7' WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	public function solicitado($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET id_estado='2' WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para aprobar categorías
	public function aprobar($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET id_estado='3',condicion= '0' WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para Finalizar Actividades
	public function finalizar($id_actividad_voae,$fch_final_actividad)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_actividades SET id_estado='6',condicion= '1' WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_actividades WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}
	public function mostrar2($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_actividades WHERE id_actividad_voae='$id_actividad_voae'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un método para listar los registros
	public function listar($usuario)
	{
		global $instancia_conexion;
		$sql="CALL vista_solicitud('$usuario') ";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros
	public function listar1()
	{
		global $instancia_conexion;
		$sql="SELECT * FROM vista_actividad_cve_1";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listar2($usuario)
	{
		global $instancia_conexion;
		$sql="CALL vista_finalizar('$usuario')";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}
}

?>