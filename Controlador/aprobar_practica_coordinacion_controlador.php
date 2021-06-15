<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');




	    $_SESSION['cb_practica']=strtoupper ($_POST['cb_practica']);
		$_SESSION['cb_horas_practica']=strtoupper ($_POST['cb_horas_practica']);
		$_SESSION['fecha_inicio']=strtoupper ($_POST['fecha_inicio']);
		$_SESSION['fecha_finalizacion']=strtoupper ($_POST['fecha_finalizacion']);
		
	print_r($_POST);

	/*$_SESSION['txt_estudiante_cuenta']=strtoupper ($_POST['txt_estudiante_cuenta']);
	$_SESSION['empresa']=strtoupper ($_POST['txt_empresa']);

//Cuando practica es sin seleccionar
	if ($_SESSION['cb_practica']=='0' and $_SESSION['cb_horas_practica']=='0')
	{
		//header("location:../vistas/aprobar_practica_coordinacion_vista.php?msj=1"); 
		echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=1'); </script>";

	}
	//Cuando aprobar y practica es SI

	elseif ($_SESSION['cb_practica']=='SI')
	 {
	
$_SESSION['txt_motivo']="APROBADA";

// tipo 1 de aprobado
		$sql = "call proc_aprobacion_practica($_SESSION[txt_estudiante_cuenta],' $_SESSION[txt_motivo]',1,'	$_SESSION[empresa]', '$_SESSION[cb_horas_practica]', '$_SESSION[fecha_inicio]', '$_SESSION[fecha_finalizacion]') ";

		$resultado = $mysqli->query($sql);
		if ($resultado==true) {
			 
			      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'COORDINACION DEL ESTUDIANTE CON CUENTA'.$_SESSION['txt_estudiante_cuenta'] .' CON DECISION '.$_SESSION['cb_aprobar']. ', CON OBSERVACION'.$_SESSION['txt_motivo'].'');  

		//header("location:../vistas/aprobar_practica_coordinacion_vista.php?msj=2"); 
		echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=2'); </script>";

		}
		else
		{
		//header("location:../vistas/aprobar_practica_coordinacion_vista.php?msj=3"); 
		echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=3'); </script>";

		}

	 }
	 // 

	 elseif ($_SESSION['cb_practica']=='NO') 
	 {
	 	$_SESSION['txt_motivo']=$_POST['txt_motivo_rechazo'];
		if (isset($_SESSION['txt_motivo']) && empty($_SESSION['txt_motivo']) || $_SESSION['txt_motivo']=="")
		 {
		 	//valida motivo vacio
		 	//header("location:../vistas/gestion_documentos_practica_vista.php?msj=1"); 
			 echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=1'); </script>";

		}
		else
		{
			//tipo 2 rechazo
			$_SESSION['txt_motivo']=strtoupper ($_POST['txt_motivo_rechazo']);
			$sql = "call proc_aprobacion_practica($_SESSION[txt_estudiante_cuenta],' $_SESSION[txt_motivo]',0,'	$_SESSION[empresa]','$_SESSION[cb_horas_practica]') ";

		$resultado = $mysqli->query($sql);
		if ($resultado==true) {
			 
			      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'COORDINACION DEL ESTUDIANTE CON CUENTA'.$_SESSION['txt_estudiante_cuenta'] .' CON DECISION '.$_SESSION['cb_aprobar']. ', CON OBSERVACION'.$_SESSION['txt_motivo'].'');  

		//header("location:../vistas/aprobar_practica_coordinacion_vista.php?msj=2"); 
		echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=2'); </script>";


		}
		else
		{
		//header("location:../vistas/aprobar_practica_coordinacion_vista.php?msj=3"); 
		echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=3'); </script>";

		}
		}



		}




	else
	{
	 	//eligio incompleta
	 	$_SESSION['txt_motivo']=$_POST['txt_motivo_rechazo'];
		if (isset($_SESSION['txt_motivo']) && empty($_SESSION['txt_motivo']) || $_SESSION['txt_motivo']=="")
		 {
		 	//valida motivo vacio
		 	//header("location:../vistas/gestion_documentos_practica_vista.php?msj=1"); 
			 echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=1'); </script>";

		}
		else
		{
			//Tipo distinto a 0 o 1
			$_SESSION['txt_motivo']=strtoupper ($_POST['txt_motivo_rechazo']);
	$sql = "call proc_aprobacion_practica($_SESSION[txt_estudiante_cuenta],' $_SESSION[txt_motivo]',2,'	$_SESSION[empresa]','$_SESSION[cb_horas_practica]') ";

		$resultado = $mysqli->query($sql);
		if ($resultado==true) {
			 
			      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'COORDINACION DEL ESTUDIANTE CON CUENTA'.$_SESSION['txt_estudiante_cuenta'] .' CON DECISION '.$_SESSION['cb_aprobar']. ', CON OBSERVACION'.$_SESSION['txt_motivo'].'');  

		//header("location:../vistas/aprobar_practica_coordinacion_vista.php?msj=2"); 
		echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=2'); </script>";


		}
		else
		{
		//header("location:../vistas/aprobar_practica_coordinacion_vista.php?msj=3"); 
		echo "<script> window.location.replace('../vistas/aprobar_practica_coordinacion_vista.php?msj=3'); </script>";

		}		}

	
	 }*/
	 
	





?>