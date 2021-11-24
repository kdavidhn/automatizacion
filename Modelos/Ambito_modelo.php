
<?php 
//Incluímos inicialmente la conexión a la base de datos


require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

Class Ambito
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_ambito,$descripcion_ambito)
	{
		global $instancia_conexion;
		$sql="INSERT INTO tbl_voae_ambitos (nombre_ambito,descripcion_ambito,condicion)
		VALUES (trim(upper('$nombre_ambito')),trim(upper('$descripcion_ambito')),'1')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_ambito,$nombre_ambito,$descripcion_ambito)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_ambitos SET nombre_ambito=trim(upper('$nombre_ambito')),descripcion_ambito=trim(upper('$descripcion_ambito')) WHERE id_ambito='$id_ambito'";
		return $instancia_conexion->ejecutarConsulta($sql);;
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_ambito)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_ambitos SET condicion='0' WHERE id_ambito='$id_ambito'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_ambito)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_ambitos SET condicion='1' WHERE id_ambito='$id_ambito'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_ambito)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_ambitos WHERE id_ambito='$id_ambito'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_ambitos";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}


	//Implementamos un método para eliminar categorías
	public function eliminar($id_ambito)
	{
		global $instancia_conexion;
		$sql="DELETE FROM tbl_voae_ambitos WHERE id_ambito='$id_ambito'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
}

?>