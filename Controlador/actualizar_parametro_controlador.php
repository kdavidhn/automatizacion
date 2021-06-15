<?php
  
      session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');


  $Parametro=strtoupper ($_POST['txt_parametro_modificar']);
  $Descripcion=strtoupper ($_POST['txt_parametro_descripcion']);
  $Valor=$_POST['txt_parametro_valor'];
  $Id_parametro= $_GET['Id_parametro']; 





/* Logica para que no acepte campos vacios */
if ($_POST['txt_parametro_descripcion']  <>' ' and  $_POST['txt_parametro_valor']<> '')
{

  
	

        $Id_objeto=7 ; 

    /* Hace el query para que actualize*/
	$sql = "call proc_actulizar_parametro('$Descripcion','$Valor' , ' ".$_SESSION[usuario]."','$Id_parametro')";
	$resultado = $mysqli->query($sql);
  /*
header("location: ../contenidos/gestionParametros-view.php");*/

        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LA DESCRIPCION '.$Descripcion.', CON EL VALOR'.$Valor.'');



         header("location:../vistas/gestion_parametros_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_parametros_vista.php?msj=3"); 

}



  ?>

