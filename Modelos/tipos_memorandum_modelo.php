<?php 
//Incluímos inicialmente la conexión a la base de datos
//require "../clases/Conexion.php";
require "../clases/Conexionvoae.php";

Class memorandum
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_tipo_memorandum,$descripcion_memorandum)
	{
		$sql="INSERT INTO tbl_voae_tipo_memorandum (nombre_tipo_memorandum,descripcion_memorandum,condicion)
		VALUES ( trim(upper('$nombre_tipo_memorandum')), trim(upper('$descripcion_memorandum')),'1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_tipo_memorandum,$nombre_tipo_memorandum,$descripcion_memorandum)
	{
		$sql="UPDATE tbl_voae_tipo_memorandum SET nombre_tipo_memorandum= trim(upper('$nombre_tipo_memorandum')),descripcion_memorandum=trim(upper('$descripcion_memorandum')) WHERE id_tipo_memorandum='$id_tipo_memorandum'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_tipo_memorandum)
	{
		$sql="UPDATE tbl_voae_tipo_memorandum SET condicion='0' WHERE id_tipo_memorandum='$id_tipo_memorandum'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_tipo_memorandum)
	{
		$sql="UPDATE tbl_voae_tipo_memorandum SET condicion='1' WHERE id_tipo_memorandum='$id_tipo_memorandum'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_tipo_memorandum)
	{
		$sql="SELECT * FROM tbl_voae_tipo_memorandum WHERE id_tipo_memorandum='$id_tipo_memorandum'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbl_voae_tipo_memorandum";
		return ejecutarConsulta($sql);		
	}
}

?>