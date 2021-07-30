
<?php 
//Incluímos inicialmente la conexión a la base de datos


require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require "../clases/Conexionvoae.php";
require "../clases/funcion_permisos.php";



Class Ambito
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_ambito,$descripcion_ambito)
	{
		$sql="INSERT INTO tbl_voae_ambitos (nombre_ambito,descripcion_ambito,condicion)
		VALUES (trim(upper('$nombre_ambito')),trim(upper('$descripcion_ambito')),'1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_ambito,$nombre_ambito,$descripcion_ambito)
	{
		$sql="UPDATE tbl_voae_ambitos SET nombre_ambito=trim(upper('$nombre_ambito')),descripcion_ambito=trim(upper('$descripcion_ambito')) WHERE id_ambito='$id_ambito'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_ambito)
	{
		$sql="UPDATE tbl_voae_ambitos SET condicion='0' WHERE id_ambito='$id_ambito'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_ambito)
	{
		$sql="UPDATE tbl_voae_ambitos SET condicion='1' WHERE id_ambito='$id_ambito'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ambito)
	{
		$sql="SELECT * FROM tbl_voae_ambitos WHERE id_ambito='$id_ambito'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbl_voae_ambitos";
		return ejecutarConsulta($sql);		
	}


	//Implementamos un método para eliminar categorías
	public function eliminar($id_ambito)
	{
		$sql="DELETE FROM tbl_voae_ambitos WHERE id_ambito='$id_ambito'";
		return ejecutarConsulta($sql);
	}
}

?>