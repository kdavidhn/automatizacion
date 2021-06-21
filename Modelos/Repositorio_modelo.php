
<?php 
//Incluímos inicialmente la conexión a la base de datos
//require "../clases/Conexion.php";
require "../clases/Conexionvoae.php";

Class Repositorio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_repositorio,$descripcion_repositorio)
	{
		$sql="INSERT INTO tbl_voae_tipos_repositorios (nombre_repositorio,descripcion_repositorio,condicion)
		VALUES ('$nombre_repositorio','$descripcion_repositorio','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_repositorio,$nombre_repositorio,$descripcion_repositorio)
	{
		$sql="UPDATE tbl_voae_tipos_repositorios SET nombre_repositorio='$nombre_repositorio',descripcion_repositorio='$descripcion_repositorio' WHERE id_repositorio='$id_repositorio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_repositorio)
	{
		$sql="UPDATE tbl_voae_tipos_repositorios SET condicion='0' WHERE id_repositorio='$id_repositorio'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_repositorio)
	{
		$sql="UPDATE tbl_voae_tipos_repositorios SET condicion='1' WHERE id_repositorio='$id_repositorio'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_repositorio)
	{
		$sql="SELECT * FROM tbl_voae_tipos_repositorios WHERE id_repositorio='$id_repositorio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbl_voae_tipos_repositorios";
		return ejecutarConsulta($sql);		
	}
}

?>
