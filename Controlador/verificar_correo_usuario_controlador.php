<?php

require_once ('../clases/Conexion.php');

require_once ('../clases/encriptar_desencriptar.php'); 





$Id_usuario_correo=$_GET['idusuario'];
$Correo1=$_POST['correoclave'];


$sql_correo=" SELECT count(Correo_Electronico) as correo from tbl_usuarios where Id_usuario='$Id_usuario_correo' and Correo_Electronico='$Correo1'";
$existe_correo = mysqli_fetch_assoc($mysqli->query($sql_correo));

$sql_tamano_clave="select valor from tbl_parametros where parametro='Tamano_clave_correo'" ;
$Valor_tamano_clave = mysqli_fetch_assoc($mysqli->query($sql_tamano_clave));

if ($existe_correo['correo']==1)
    {
$contrasena= password_random($Valor_tamano_clave['valor']);
$contrasena_correo=cifrado::encryption($contrasena);

/**/


$sql_parametro_admin="select valor as Valor from tbl_parametros where parametro='Admin_correo' ";
$resultado_parametro_admin = $mysqli->query($sql_parametro_admin);
$fila1 = mysqli_fetch_array($resultado_parametro_admin);


$sql_parametro_correo="select valor as Valor from tbl_parametros where parametro='correo_institucional' ";
$resultado_parametro_correo = $mysqli->query($sql_parametro_correo);
$fila2 = mysqli_fetch_array($resultado_parametro_correo);


$sql_parametro_clave="select valor as Valor from tbl_parametros where parametro='clave_correo' ";
$resultado_parametro_clave_correo = $mysqli->query($sql_parametro_clave);
$fila3 =mysqli_fetch_array($resultado_parametro_clave_correo);

/*$fila1['Valor'],$fila2['Valor'],$fila3['Valor']*/



	
			require_once ('../clases/envioCorreo.php'); 
			///Nombre quien envia, correo, contraseña
            $email = new email($fila1['Valor'],$fila2['Valor'],$fila3['Valor']);
			
            $email->agregar($Correo1,'');
						//Asunto y contenido
			if ($email->enviar('Recuperacion de Contraseña',"<div>
				<p>Buen Dia Estimad@ <br> <br>
				El presente correo es para informar que ha solicitado un cambio de contraseña.
<br>
				Favor usar esta nueva contraseña :<br>
				 ". $contrasena ." 
				 <br>
<br>
Nota: si usted no ha solicitado el cambio favor contactar con el administrador del sistema para reportarlo.
<br>
<br> Saludos.
				 </p> <div>" ))
			{

					

			$sql_update= "update tbl_usuarios set Contrasena='$contrasena_correo' where Id_usuario='$Id_usuario_correo'";		
				$resultado = $mysqli->query($sql_update);

					if($resultado && isset($resultado) ) 
					{
					/*Mensaje cuando todo funciona */
					         header("location: ../login.php?msj=1");

					}
					 else { 
					/*Mensaje cuando no actualiza la contraseña */
         header("location: ../vistas/recuperar_x_correo_vista.php?msj=3&idusuario=$Id_usuario_correo");


				         } 

			}
			else
			{
										/*Mensaje cuando el correo no se envia */
	   
			          header("location: ../vistas/recuperar_x_correo_vista.php?msj=1&idusuario=$Id_usuario_correo");

			   $email->ErrorInfo;
			}




    }
    else
    {
         header("location: ../vistas/recuperar_x_correo_vista.php?msj=2&idusuario=$Id_usuario_correo");
    }


    /*Esta funcion me sirve para generar la contraseña aleatoria */
function password_random($length) 
{

   $charset = "ab0@#cdenopkrstuvwxyzABCDEFKLMNOPQRSfghiTUVWXYZ123jklm456789$%&/?¡¿*+-.,;" ;
   $codigo = "";
   for ($i=0; $i<$length ; $i++)
   {
    $rand= rand() % strlen($charset);
    $codigo = substr($charset,$rand,$length);
   }

   return $codigo;

}

?>