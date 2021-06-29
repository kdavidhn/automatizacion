<?php 
//Incluímos inicialmente la conexión a la base de datos
//require "../clases/Conexion.php";
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require "../clases/Conexionvoae.php";

Class Estado
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_estado,$descripcion_estado)
	{
		$sql="INSERT INTO tbl_voae_estados (nombre_estado,descripcion_estado,condicion)
		VALUES (trim(upper('$nombre_estado')),trim(upper('$descripcion_estado')),'1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_estado,$nombre_estado,$descripcion_estado)
	{
		$sql="UPDATE tbl_voae_estados SET nombre_estado=trim(upper('$nombre_estado')),descripcion_estado=trim(upper('$descripcion_estado')) WHERE id_estado='$id_estado'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_estado)
	{
		$sql="UPDATE tbl_voae_estados SET condicion='0' WHERE id_estado='$id_estado'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_estado)
	{
		$sql="UPDATE tbl_voae_estados SET condicion='1' WHERE id_estado='$id_estado'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_estado)
	{
		$sql="SELECT * FROM tbl_voae_estados WHERE id_estado='$id_estado'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbl_voae_estados";
		return ejecutarConsulta($sql);		
	}
}

?>