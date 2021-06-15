<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class control
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
		$sql="SELECT a.nombre, a.documento,ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro

		FROM tbl_empresas_practica AS ep
		JOIN tbl_personas AS a
		ON ep.id_persona = a.id_persona
		JOIN tbl_practica_estudiantes AS pe
		ON pe.id_persona = a.id_persona
		JOIN tbl_contactos c ON a.id_persona = c.id_persona
		JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
		JOIN tbl_contactos e ON a.id_persona = e.id_persona
		JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	public function llenar()
	{
		global $instancia_conexion;
		$sql="SELECT a.nombre, a.documento,ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro

		FROM tbl_empresas_practica AS ep
		JOIN tbl_personas AS a
		ON ep.id_persona = a.id_persona
		JOIN tbl_practica_estudiantes AS pe
		ON pe.id_persona = a.id_persona
		JOIN tbl_contactos c ON a.id_persona = c.id_persona
		JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
		JOIN tbl_contactos e ON a.id_persona = e.id_persona
		JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
}


?>
