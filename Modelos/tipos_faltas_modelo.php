
<?php 
//Incluímos inicialmente la conexión a la base de datos
//require "../clases/Conexion.php";
require "../clases/Conexionvoae.php";

Class falta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_falta,$descripcion_falta)
	{
		$sql="INSERT INTO tbl_voae_tipos_faltas (nombre_falta,descripcion_falta,condicion)
		VALUES ('$nombre_falta','$descripcion_falta','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_falta,$nombre_falta,$descripcion_falta)
	{
		$sql="UPDATE tbl_voae_tipos_faltas SET nombre_falta='$nombre_falta',descripcion_falta='$descripcion_falta' WHERE id_falta='$id_falta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_falta)
	{
		$sql="UPDATE tbl_voae_tipos_faltas SET condicion='0' WHERE id_falta='$id_falta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_falta)
	{
		$sql="UPDATE tbl_voae_tipos_faltas SET condicion='1' WHERE id_falta='$id_falta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_falta)
	{
		$sql="SELECT * FROM tbl_voae_tipos_faltas WHERE id_falta='$id_falta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbl_voae_tipos_faltas";
		return ejecutarConsulta($sql);		
	}
}

?>