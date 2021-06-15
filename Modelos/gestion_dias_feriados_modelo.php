<?php
require "../clases/conexion_mantenimientos.php";



$instancia_conexion = new conexion();

class feriados
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($fecha,$descripcion)
	{
        global $instancia_conexion;
		$sql="INSERT INTO tbl_dias_feriados (fecha,descripcion,estado)
		VALUES ('$fecha','$descripcion','1')";
		return $instancia_conexion->ejecutarConsulta($sql);

	}

	//Implementamos un método para editar registros
	public function editar($id_dia_feriado,$fecha,$descripcion)
	{	
		/**
		global $instancia_conexion;
		
		$sql="CALL asignar_docente('$id_supervisor','$docente')";
		return $instancia_conexion->ejecutarConsulta($sql);
		**/
		global $instancia_conexion;
		$sql="UPDATE tbl_dias_feriados SET fecha='$fecha', descripcion='$descripcion' 
		WHERE id_dia_feriado='$id_dia_feriado'"; 
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($id_dia_feriado)
	{
        global $instancia_conexion;
		$sql="UPDATE tbl_dias_feriados SET estado='0' WHERE id_dia_feriado='$id_dia_feriado'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_dia_feriado)
	{   
        global $instancia_conexion;
		$sql="UPDATE tbl_dias_feriados SET estado='1' WHERE id_dia_feriado='$id_dia_feriado'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	public function mostrar($id_dia_feriado)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_dias_feriados WHERE id_dia_feriado='$id_dia_feriado'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	
	//Implementar un método para listar los registros
	public function listar()
	{
        global $instancia_conexion;
        $sql = "SELECT * FROM tbl_dias_feriados";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
}

?>


