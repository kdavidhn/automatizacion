<?php
	
 session_start();

require_once ('../clases/Conexion.php');

$Id_objeto=11 ; 




    $Respuesta=strtoupper ($_POST['respuestap']);
    $Id_pregunta_usuario= $_GET['Id_pregunta_usuario'];
   
	  
		$sql="call  proc_actualizar_respuesta_seguridad('$Respuesta','$Id_pregunta_usuario','$_SESSION[id_usuario]')"; 
           $resultado = $mysqli->query($sql);
      
     
if ($resultado==true) {

         header("location:../vistas/gestion_respuesta_usuario_vista.php?msj=1"); 


}else

{
         header("location:../vistas/gestion_respuesta_usuario_vista.php?msj=2"); 

}

  


        
	?>
