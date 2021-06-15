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
	public function editar($docente,$id_supervisor)
	{	
		global $instancia_conexion;
		
		$sql="CALL asignar_docente('$id_supervisor','$docente')";
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
	public function mostrar_datos_alumno($id_supervisor)
	{
        global $instancia_conexion;
		$sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa,pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.jefe_inmediato, ep.titulo_jefe_inmediato

		FROM tbl_empresas_practica AS ep
		JOIN tbl_personas AS a
		ON ep.id_persona = a.id_persona
		JOIN tbl_practica_estudiantes AS pe
		ON pe.id_persona = a.id_persona
		JOIN tbl_contactos c ON a.id_persona = c.id_persona
		JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
		JOIN tbl_contactos e ON a.id_persona = e.id_persona
		JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
		join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
		where a.id_persona='$id_supervisor'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	public function mostrar_datos_docente($docente)
	{
        global $instancia_conexion;
		$sql="SELECT p.nombres, c.valor FROM tbl_contactos c, tbl_personas p WHERE c.id_persona = '$docente' and c.id_tipo_contacto=4 and p.id_persona='$docente'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
        global $instancia_conexion;
		$sql="SELECT distinctrow px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.fecha_inicio, pe.fecha_finaliza, ep.id_persona

		FROM tbl_empresas_practica ep, tbl_personas a, tbl_practica_estudiantes pe, tbl_personas_extendidas px
		WHERE
		pe.id_persona = a.id_persona AND
	    px.id_atributo=12 and ep.id_persona=pe.id_persona and ep.Id_empresa=pe.Id_empresa and px.id_persona=pe.id_persona and pe.docente_supervisor='';";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
}


























?>


