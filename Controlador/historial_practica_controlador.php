<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

if (isset($_POST['cb_empresa']))
{

	$_SESSION['cb_empresa']=strtoupper ($_POST['cb_empresa']);

	$_SESSION['txt_estudiante_cuenta']=strtoupper ($_POST['txt_estudiante_cuenta']);
	if ($_SESSION['cb_empresa']=='0')
	{
		header("location:../vistas/historial_practicas_aprobadas_vista.php?msj=1"); 

	}
	else
	{
		if ($_SESSION['cb_empresa']=="SI") 
		{
	echo "prueba si";
	
	$Id_objeto=27 ; 
		$sql = "call proc_actualizar_cambio_empresa_estudiante_practica('$_SESSION[txt_estudiante_cuenta]')";

		$resultado = $mysqli->query($sql);
		if ($resultado==true) {
			 
			      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ACTUALIZO' , 'DERECHO PARA CAMBIO DE EMPRESA AL ESTUDIANTE CON CUENTA '.$_SESSION['txt_estudiante_cuenta'] .'');  

			header("location:../vistas/historial_practicas_aprobadas_vista.php?msj=4"); 


		}
		else
		{
			header("location:../vistas/historial_practicas_aprobadas_vista.php?msj=3"); 

		}

		}
	else
	{
				header("location:../vistas/historial_practicas_aprobadas_vista.php?msj=2"); 

	}
		}
	}
?>