
<?php 
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

Class falta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre_falta,$descripcion_falta)
	{
		global $instancia_conexion;
		$sql="INSERT INTO tbl_voae_tipos_faltas (nombre_falta,descripcion_falta,condicion)
		VALUES ( trim(upper('$nombre_falta')), trim(upper('$descripcion_falta')),'1')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_falta,$nombre_falta,$descripcion_falta)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_tipos_faltas SET nombre_falta= trim(upper('$nombre_falta')),descripcion_falta=trim(upper('$descripcion_falta')) WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_falta)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_tipos_faltas SET condicion='0' WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_falta)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_tipos_faltas SET condicion='1' WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	//Implementamos un método para eliminar categorías
	public function eliminar($id_falta)
	{
		global $instancia_conexion;
		$sql="DELETE FROM tbl_voae_tipos_faltas WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_falta)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_tipos_faltas WHERE id_falta='$id_falta'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_tipos_faltas";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}
}

?>