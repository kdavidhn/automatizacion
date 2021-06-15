<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class asignaturas
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	

	//Implementar un método para listar los registros
	public function listar()
	{
        global $instancia_conexion;
		$sql="SELECT a.documento, a.nombre, ep.nombre_empresa, ep.direccion_empresa, pe.fecha_inicio, pe.fecha_finaliza, ep.id_persona

		FROM tbl_empresas_practica ep, tbl_personas a, tbl_practica_estudiantes pe
		WHERE
		ep.id_persona = a.id_persona AND
		pe.id_persona = a.id_persona AND
		pe.docente_supervisor= '" . $_SESSION['id_persona'] . "'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
}


























?>


