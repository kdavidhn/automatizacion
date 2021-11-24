
<?php 
//Incluímos inicialmente la conexión a la base de datos

require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();



Class Faltas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion, $usuario_x)
	{
		global $instancia_conexion;
		$sql="INSERT INTO tbl_voae_faltas_conductas(id_tipo_falta,fch_falta,id_persona_alumno,descripcion, id_usuario_registro, fch_registro)
		VALUES ('$id_tipo_falta','$fch_falta','$id_persona_alumno',upper('$descripcion'),'$usuario_x',sysdate())";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_faltas_conductas SET id_tipo_falta='$id_tipo_falta',fch_falta='$fch_falta', id_persona_alumno='$id_persona_alumno', descripcion = '$descripcion' WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($id_falta)
	{
		global $instancia_conexion;
		$sql="DELETE FROM tbl_voae_faltas_conductas WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_falta)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_faltas_conductas WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		global $instancia_conexion;
		$sql="SELECT * FROM view_faltas_conducta";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros
	public function listar_his($cuenta1)
	{
		global $instancia_conexion;
		$sql="select `tbl_voae_faltas_conductas`.`id_falta` AS `id_falta`,`tbl_voae_faltas_conductas`.`id_tipo_falta` AS `id_tipo_falta`,`tbl_voae_faltas_conductas`.`id_persona_alumno` AS `id_persona_alumno`,`tbl_voae_faltas_conductas`.`fch_falta` AS `fch_falta`,`tbl_voae_tipos_faltas`.`nombre_falta` AS `nombre_falta`,`tbl_voae_faltas_conductas`.`descripcion` AS `descripcion`,concat(`tbl_personas`.`nombres`,' ',`tbl_personas`.`apellidos`) AS `nombres`,`tbl_personas_extendidas`.`valor` AS `valor` from (((`tbl_voae_faltas_conductas` join `tbl_personas` on(`tbl_voae_faltas_conductas`.`id_persona_alumno` = `tbl_personas`.`id_persona`)) join `tbl_voae_tipos_faltas` on(`tbl_voae_faltas_conductas`.`id_tipo_falta` = `tbl_voae_tipos_faltas`.`id_falta`)) join `tbl_personas_extendidas` on(`tbl_voae_faltas_conductas`.`id_persona_alumno` = `tbl_personas_extendidas`.`id_persona`)) where `valor` = '$cuenta1'";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}
}

?>