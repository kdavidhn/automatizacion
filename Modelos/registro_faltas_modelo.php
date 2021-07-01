
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
	public function insertar($id_tipo_falta,$fch_falta,$id_usuario_alumno,$descripcion, $usuario)
	{
		$sql="INSERT INTO tbl_voae_faltas_conductas(id_tipo_falta,fch_falta,id_usuario_alumno,descripcion, id_usuario_registro, fch_registro)
		VALUES ('$id_tipo_falta','$fch_falta',63,'$descripcion','$usuario',sysdate())";
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
	public function mostrar($id_falta)
	{
		$sql="SELECT id_falta, id_tipo_falta, fch_falta, id_usuario_alumno, descripcion FROM tbl_voae_faltas_conductas WHERE id_falta='$id_falta'";
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