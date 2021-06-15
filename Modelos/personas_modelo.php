<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class personas
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

    }
    
	//Implementamos un método para insertar registros de primera unica de supervision
	
	public function insertar($nombre,$apellido,$identidad,$nacionalidad,$fecha,$estado
	,$genero,$telefono,$direccion,$correo,$tipo)
	{
        global $instancia_conexion;
		$sql = "call proc_ins_personas('$nombre', '$apellido',  '$genero',  '$identidad',  '$nacionalidad',  '$estado',  '$fecha',  $tipo,  '$telefono',  '$correo',  '$direccion' );";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

    

  //Implementar un método para listar los registros
	public function listar()
	{
        global $instancia_conexion;
		$sql="SELECT  nombres, apellidos, sexo, identidad, nacionalidad, estado_civil, fecha_nacimiento FROM tbl_personas";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	
    
	


}




   


?>

























?>


