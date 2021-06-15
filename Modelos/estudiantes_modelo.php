<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class estudiantes
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

    }
    
	//Implementamos un método para insertar registros de estudiantes
	public function insertar($cuenta,$nombre,$apellido,$identidad,$nacionalidad,$fecha,$estado
	,$genero,$telefono,$direccion,$correo)
	{ 
        global $instancia_conexion;
		$sql = "call proc_insertar_persona_estudiante('$cuenta', '$nombre','$apellido', '$identidad', '$nacionalidad', '$fecha', '$estado',  '$genero', '$telefono', '$correo', '$direccion');";					   
		return $instancia_conexion->ejecutarConsulta($sql);
	}
	

	


}


























?>


