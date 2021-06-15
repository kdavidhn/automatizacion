<?php
	
 session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

	$Rol=$_POST['txtnombrerol'];
	$Pantalla=$_POST['txtnombrepantalla'];
	$Id_permisos_usuarios= $_GET['Id_permisos_usuarios']; 
	$checkInsertar=0;
	$checkModificar=0;
	$checkEliminar=0;
	$checkVer=0;


	if (isset($_POST['checkboxinsertar']) && $_POST['checkboxinsertar'] == 'true') 
	{
	$checkInsertar=1;
		$checkInsertar1="ACTIVO";

	}
	else
	{
	$checkInsertar=0;
			$checkInsertar1="INACTIVO";

	}	


	if (isset($_POST['checkboxmodificar']) && $_POST['checkboxmodificar'] == 'true') 
	{
	$checkModificar=1;
	$checkModificar1="ACTIVO";
	}
	else
	{
	$checkModificar=0;
	$checkModificar1="INACTIVO";
    }

	if (isset($_POST['checkboxeliminar']) && $_POST['checkboxeliminar'] == 'true') 
	{
	$checkEliminar=1;
	$checkEliminar1="ACTIVO";
	}
	else
	{
	$checkEliminar=0;
	$checkEliminar1="INACTIVO";
	}	

	if (isset($_POST['checkboxvisualizar']) && $_POST['checkboxvisualizar'] == 'true') 
	{
	$checkVer=1;
	$checkVer1="ACTIVO";
	}
	else
	{
	$checkVer=0;
	$checkVer1="INACTIVO";
	}



        $Id_objeto=10 ; 

    /* Hace el query para que actualize*/
$sql = "call proc_actualizar_permiso_usuario('$checkInsertar','$checkModificar','$checkEliminar','$checkVer','$_SESSION[usuario]','$Id_permisos_usuarios')";
	$resultado = $mysqli->query($sql);
	/*
header("location: ../contenidos/gestionPermisos-view.php?msj=1 ");*/



	if($resultado === TRUE){
		        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'EL INSERTAR A'.$checkInsertar1.',EL MODIFICAR A'.$checkModificar1.' ,EL ELIMINAR A'.$checkEliminar1.' ,EL VISUALIZAR A'.$checkVer1.' ');

		header("location: ../vistas/gestion_permiso_usuario_vista.php?msj=1 ");

}
else
{
	
	header("location: ../vistas/gestion_permiso_usuario_vista.php?msj=2 ");


}




?>
 
