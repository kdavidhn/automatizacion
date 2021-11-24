<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

Class Estado
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_estado,$descripcion_estado)
	{
		global $instancia_conexion;
		$sql="INSERT INTO tbl_voae_estados (nombre_estado,descripcion_estado,condicion)
		VALUES (trim(upper('$nombre_estado')),trim(upper('$descripcion_estado')),'1')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_estado,$nombre_estado,$descripcion_estado)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_estados SET nombre_estado=trim(upper('$nombre_estado')),descripcion_estado=trim(upper('$descripcion_estado')) WHERE id_estado='$id_estado'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_estado)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_estados SET condicion='0' WHERE id_estado='$id_estado'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_estado)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_estados SET condicion='1' WHERE id_estado='$id_estado'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($id_estado)
	{
		global $instancia_conexion;
		$sql="DELETE FROM tbl_voae_estados WHERE id_estado='$id_estado'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_estado)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_estados WHERE id_estado='$id_estado'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_estados";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}
}

?>