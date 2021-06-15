<?php
require_once('../clases/Conexion.php');
require_once ('../clases/encriptar_desencriptar.php'); 

$numero_cuenta=strtoupper($_POST['txt_cuenta_estudiante']);
$contrasena=$_POST['txt_clave'];
$confirmar_contrasena=$_POST['txt_confirmar_clave'];
$nombre_estudiante=$_POST['txt_nombre_estudiante'];
$correo=$_POST['txt_correo_estudiante'];
$apellido_estudiante=$_POST['txt_apellido_estudiante'];
$sexo=$_POST['sexo'];
//Tomar la primera letra del string
$letra=substr($nombre_estudiante, 0, 1);
//Tomar la primera palabra de todo el string usando el indice[0]
$palabra = explode (" ", $apellido_estudiante);
//Concatenación de la primera letra del nombre y primer apellido para crear el usuario
$usuario=$letra.$palabra[0];
//Convertir el nombre de usuario en mayuscula
$usuario_final = strtoupper($usuario);

if($contrasena!=$confirmar_contrasena)
{

  $msj=1;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj"); 

    }
    else
    {
      $sql_parametro_tamano_min=("SELECT valor AS valor FROM tbl_parametros WHERE parametro='Tamano_min_clave'");
 //Obtener la fila del query
$tamano_min = mysqli_fetch_assoc($mysqli->query($sql_parametro_tamano_min));

 $sql_parametro_tamano_max=("SELECT valor as valor FROM tbl_parametros WHERE parametro='Tamano_max_clave'");
$tamano_max = mysqli_fetch_assoc($mysqli->query($sql_parametro_tamano_max));



if(strlen($contrasena) < $tamano_min['valor']  )
   {
     $error_clave = "La clave debe tener al menos ". $tamano_min['valor'] ." caracteres"; 
  $msj=5;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj&error= $error_clave"); 


   }elseif(strlen($contrasena) > $tamano_max['valor']) {
      $error_clave = "La clave no puede tener más de ". $tamano_max['valor'] ."  caracteres";
   
 $msj=5;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj&error= $error_clave"); 


   }elseif (!preg_match('`[a-z]`',$contrasena)) {
      $error_clave = "La clave debe tener al menos una letra minúscula";
   
    $msj=5;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj&error= $error_clave"); 

   }elseif (!preg_match('`[A-Z]`',$contrasena)) {
     $error_clave = "La clave debe tener al menos una letra mayúscula";

 $msj=5;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj&error= $error_clave"); 

   }elseif (!preg_match('`[0-9]`',$contrasena)) {
  $error_clave = "La clave debe tener al menos un caracter numérico";

 $msj=5;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj&error= $error_clave"); 

   }elseif (!preg_match("([*|+|-|/|@|.|_|:|,|;|¿|?|=|&|%|$|#|!|°|^])" ,$contrasena)) {
  $error_clave = "La clave debe tener al menos un caracter especial";
 
  $msj=5;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj&error= $error_clave"); 

   }else{
    $existe_usuario="";
    $existe_usuario=("select count(numero_cuenta) as Usuario from tbl_usuarios where Usuario='$numero_cuenta'");
      $existe=mysqli_fetch_assoc($mysqli->query($existe_usuario));
        if($existe['Usuario']==1)
        {

    $msj=3;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj"); 


              }else{
                $clave=cifrado::encryption($contrasena);
                      $sql = "call   proc_insertar_estudiante( '$nombre_estudiante','$apellido_estudiante','$numero_cuenta','$correo','$clave','$sexo','$usuario_final')";

                        $result = $mysqli->query($sql);
                          if($result === TRUE)
                          {

                   $msj=2;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj"); 

                                }
                                else
                                {

                      $msj=4;
    header("location: ../vistas/auto_registro_estudiante_vista.php?msj=$msj"); 

                          } 
                  }
       }
 }

?>