<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class asignaturas
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($asignatura,$codigo,$uv)
	{
        global $instancia_conexion;
		$sql="INSERT INTO tbl_asignaturas (asignatura,codigo,uv)
		VALUES ('$asignatura','$codigo','$uv')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($Id_asignatura,$asignatura,$codigo,$uv)
	{
        global $instancia_conexion;
		$sql="UPDATE tbl_asignaturas SET asignatura='$asignatura',codigo='$codigo',uv='$uv' WHERE Id_asignatura='$Id_asignatura'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($Id_asignatura)
	{
        global $instancia_conexion;
		$sql="UPDATE tbl_asignaturas SET estado='0' WHERE Id_asignatura='$Id_asignatura'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($Id_asignatura)
	{   
        global $instancia_conexion;
		$sql="UPDATE tbl_asignaturas SET estado='1' WHERE Id_asignatura='$Id_asignatura'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($Id_asignatura)
	{
        global $instancia_conexion;
		$sql="SELECT * FROM tbl_asignaturas WHERE Id_asignatura='$Id_asignatura'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
        global $instancia_conexion;
		$sql="SELECT * FROM tbl_asignaturas";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
}


























?>


