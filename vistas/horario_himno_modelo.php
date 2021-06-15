<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

/*class examen_himno
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

    }
    
	//Implementamos un método para insertar registros de primera unica de supervision
	public function insertar($fecha_himno,$horario_himno,$jornada_himno,$cupos)
	{ 
        
        global $instancia_conexion;
        $sql = "call ins_horario_himno('$fecha_himno',
                                        '$horario_himno',
                                        '$jornada_himno',
                                        '$cupos')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

}*/

$id=$_POST['idhorario'];
	$fecha=$_POST['fecha'];
	$horario=$_POST['horario'];
	$jornada=$_POST['joranada'];
	$cupos=$_POST['cupos'];
	

	$sql="UPDATE tbl_horario_himno set fecha='$fecha',
								hora='$horario',								
								cupos='$cupos'				
				where id_horario_himno='$id'"; 
	echo $result=mysqli_query($conexion,$sql);
	if(!$result)
	{
		

	}
	else
	{
		header ("Location: ../vistas/crear_horario_examen_himno_vista.php");
	}
	

	
























?>


