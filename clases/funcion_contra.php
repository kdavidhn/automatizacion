<?php



class validar_contra {


function validar_clave($Contrasena,&$error_clave){


    
require('../clases/Conexion.php');

 $sql_parametro_tamano_min=("select valor as valor from tbl_parametros where parametro='Tamano_min_clave'");
 //Obtener la fila del query
$tamano_min = mysqli_fetch_assoc($mysqli->query($sql_parametro_tamano_min));


 $sql_parametro_tamano_max=("select valor as valor from tbl_parametros where parametro='Tamano_max_clave'");
 //Obtener la fila del query
$tamano_max = mysqli_fetch_assoc($mysqli->query($sql_parametro_tamano_max));


   if(strlen($Contrasena) < $tamano_min['valor']  )
   {
      $error_clave = "La clave debe tener al menos ". $tamano_min['valor'] ." caracteres";
      return false; 
   }
   if(strlen($Contrasena) > $tamano_max['valor'] )
   {
      $error_clave = "La clave no puede tener más de ". $tamano_max['valor'] ."  caracteres";
      return false;
   }
   if (!preg_match('`[a-z]`',$Contrasena))
   {
      $error_clave = "La clave debe tener al menos una letra minúscula";
      return false;
   }
   if (!preg_match('`[A-Z]`',$Contrasena))
   {
      $error_clave = "La clave debe tener al menos una letra mayúscula";
      return false;
   }
   if (!preg_match('`[0-9]`',$Contrasena))
   {
      $error_clave = "La clave debe tener al menos un caracter numérico";
      return false;
   }


   if (!preg_match("([*|+|-|/|@|.|_|:|,|;|¿|?|=|&|%|$|#|!|°|^])" ,$Contrasena))
   {
      $error_clave = "La clave debe tener al menos un caracter especial";
      return false;
   }
   $error_clave = "";
   return true;



}

}




?>