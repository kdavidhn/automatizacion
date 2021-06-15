<?php
require "../clases/conexion_mantenimientos.php";

Class Login
{
    

	public function valida_campos($Usuario,$Clave)
	{
		$sql="CALL sel_existe_usuario('$Usuario','$Clave')";
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
}






















?>