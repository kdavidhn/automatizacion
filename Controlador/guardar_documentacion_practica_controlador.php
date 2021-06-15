<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

if (isset($_POST['cb_aprobar']))
{

	$_SESSION['cb_aprobar']=strtoupper ($_POST['cb_aprobar']);

	$_SESSION['txt_estudiante_cuenta']=strtoupper ($_POST['txt_estudiante_cuenta']);
	if ($_SESSION['cb_aprobar']=='0')
	{
		//header("location:../vistas/gestion_documentos_practica_vista.php?msj=1"); 
		echo "<script> window.location.replace('https://www.informaticaunah.com/automatizacion/vistas/gestion_documentos_practica_vista.php?msj=1'); </script>";

	}
	else
	{
		if ($_SESSION['cb_aprobar']=="SI") 
		{
		$_SESSION['cb_aprobarD']=1;
		$_SESSION['txt_observacion']="SIN OBSERVACION";


		}
		else
		{
		$_SESSION['cb_aprobarD']=0;
		$_SESSION['txt_observacion']=$_POST['txt_observacion_documentacion'];
		if (isset($_SESSION['txt_observacion']) && empty($_SESSION['txt_observacion']) || $_SESSION['txt_observacion']=="")
		 {
		 	//header("location:../vistas/gestion_documentos_practica_vista.php?msj=1"); 
			 echo "<script> window.location.replace('https://www.informaticaunah.com/automatizacion/vistas/gestion_documentos_practica_vista.php?msj=1'); </script>";

		}
		else
		{
			$_SESSION['txt_observacion']=strtoupper ($_POST['txt_observacion_documentacion']);
		}



		}

		$Id_objeto=20 ; 

		$sql = "call proc_actualizar_documentos_practica_vinculacion('$_SESSION[txt_estudiante_cuenta]',$_SESSION[cb_aprobarD],'$_SESSION[txt_observacion]') ";

		$resultado = $mysqli->query($sql);


		if ($resultado==true) {
			 
			      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'VINCULACION DEL ESTUDIANTE CON CUENTA'.$_SESSION['txt_estudiante_cuenta'] .' CON LA DOCUMENTACION '.$_SESSION['cb_aprobar']. ', APROBADA CON OBSERVACION'.$_SESSION['txt_observacion'].'');  

			//header("location:../vistas/gestion_documentos_practica_vista.php?msj=2"); 
			echo "<script> window.location.replace('https://www.informaticaunah.com/automatizacion/vistas/gestion_documentos_practica_vista.php?msj=2'); </script>";


		}
		else
		{
			//header("location:../vistas/gestion_documentos_practica_vista.php?msj=3"); 
			echo "<script> window.location.replace('https://www.informaticaunah.com/automatizacion/vistas/gestion_documentos_practica_vista.php?msj=3'); </script>";

		}
	}

	
}




?>