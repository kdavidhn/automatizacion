<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
  

$Pregunta=strtoupper ($_POST['txt_pregunta_modificar']);
  $Id_pregunta= $_GET['Id_pregunta']; 
  $var=0;


  /* Iniciar la variable de sesion y la crea */

///Logica para el rol que se repite
  //Obtener la fila del query
 $sqlexiste=("select count(pregunta) as pregunta  from tbl_preguntas where Pregunta='$Pregunta' and  Id_pregunta<>'$Id_pregunta';");
  //Obtener la fila del query
 $result_ =$mysqli->query($sqlexiste);
$existe =  mysqli_fetch_array($result_);
if ($existe['pregunta']==1)
{
  /*
header("location: ../contenidos/gestionPreguntas-view.php?msj=1&Pregunta=$Pregunta2 ");*/   

         header("location:../vistas/gestion_preguntas_vista.php?msj=1"); 

 
}
else
{

  if (isset($_POST['checkboxactivomodificar']) && $_POST['checkboxactivomodificar'] == 'true') 
  {
  $var=1;
    $var1="ACTIVADO";

  }
  else
  {
  $var=0;
    $var1="INACTIVADO";

  }

          

            $Id_objeto=2 ; 

    /* Hace el query para que actualize*/
 // $sql = "call proc_actualizar_pregunta('$Pregunta',$var,'$_SESSION['usuario']','$Id_pregunta') ";
    $sql = "call proc_actualizar_pregunta ('$Pregunta','$var','$_SESSION[usuario]','$Id_pregunta') ";

  $resultado = $mysqli->query($sql);


if ($resultado==true) {
              bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LA PREGUNTA'.$Pregunta.', Y SU ESTADO'.$var1.'');

         header("location:../vistas/gestion_preguntas_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_preguntas_vista.php?msj=3"); 

}
  /*
  header("location: ../contenidos/gestionPreguntas-view.php?msj=2 ");*/


                          
           
}


?>