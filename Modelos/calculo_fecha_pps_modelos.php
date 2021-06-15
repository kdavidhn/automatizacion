<?php
require "../clases/conexion_mantenimientos.php";
$instancia_conexion = new conexion();

Class pruebas
{
    public function insertar($nombre,$edad)
	{
		$sql="INSERT INTO tb_pruebas (nombre,edad)
		VALUES ('$nombre','$edad')";
		return ejecutarConsulta($sql);
    }
    
    public function update($nombre,$edad)
	{
		$sql="UPDATE  tb_pruebas set nombre='$nombre',edad='$edad'";
		return ejecutarConsulta($sql);
	}
	public function valida_campos($nombre,$edad)
	{
		$sql="SELECT * from tb_pruebas where nombre='$nombre' and edad='$edad'";
			if (validar_select($sql))
			    {
					return true;
					# code...
				}
			else
			{
				return false;
			}
	}
	public function busqueda_fechas($fecha_inicio,$fecha_p)
	{
        global $instancia_conexion;
		$sql="SELECT COUNT(fecha) as fecha from tbl_dias_feriados WHERE fecha BETWEEN '$fecha_inicio' and '$fecha_p'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
        
    }
	public function update_pps($cb_practica,$cb_horas_practica,$fechaF,$fechaN,$txt_estudiante_cuenta,$empresa)
	{
        global $instancia_conexion;
		$sql="call proc_aprobacion_practica('$txt_estudiante_cuenta',' ',1,'$empresa', '$cb_horas_practica', '$fechaN', '$fechaF') ";
		return $instancia_conexion->ejecutarConsulta($sql);
        
    }
	
}






















?>