
<?php 
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

Class Repositorio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_repositorio,$descripcion_repositorio)
	{
		global $instancia_conexion;
		$sql="INSERT INTO tbl_voae_tipos_repositorios (nombre_repositorio,descripcion_repositorio,condicion)
		VALUES (trim(upper('$nombre_repositorio')),trim(upper('$descripcion_repositorio')),'1')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_repositorio,$nombre_repositorio,$descripcion_repositorio)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_tipos_repositorios SET nombre_repositorio=trim(upper('$nombre_repositorio')),descripcion_repositorio=trim(upper('$descripcion_repositorio')) WHERE id_repositorio='$id_repositorio'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_repositorio)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_tipos_repositorios SET condicion='0' WHERE id_repositorio='$id_repositorio'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_repositorio)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_tipos_repositorios SET condicion='1' WHERE id_repositorio='$id_repositorio'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	public function eliminar($id_repositorio)
	{
		global $instancia_conexion;
		$sql="DELETE FROM tbl_voae_tipos_repositorios WHERE id_repositorio='$id_repositorio'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_repositorio)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_tipos_repositorios WHERE id_repositorio='$id_repositorio'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_tipos_repositorios";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}
}

?>
