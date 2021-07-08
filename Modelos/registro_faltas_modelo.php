
<?php 
//Incluímos inicialmente la conexión a la base de datos


require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require "../clases/Conexionvoae.php";
require "../clases/funcion_permisos.php";



Class Faltas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion, $usuario_x)
	{
		$sql="INSERT INTO tbl_voae_faltas_conductas(id_tipo_falta,fch_falta,id_persona_alumno,descripcion, id_usuario_registro, fch_registro)
		VALUES ('$id_tipo_falta','$fch_falta','$id_persona_alumno','$descripcion','$usuario_x',sysdate())";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_falta,$id_tipo_falta,$fch_falta,$id_persona_alumno,$descripcion)
	{
		$sql="UPDATE tbl_voae_faltas_conductas SET id_tipo_falta='$id_tipo_falta',fch_falta='$fch_falta', id_persona_alumno='$id_persona_alumno', descripcion = '$descripcion' WHERE id_falta='$id_falta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($id_falta)
	{
		$sql="DELETE FROM tbl_voae_faltas_conductas WHERE id_falta='$id_falta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_falta)
	{
		$sql="SELECT * FROM tbl_voae_faltas_conductas WHERE id_falta='$id_falta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM view_faltas_conducta";
		return ejecutarConsulta($sql);		
	}
}

?>