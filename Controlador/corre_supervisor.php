<?php
class correo{
		
	function enviarEmailDocente($cuerpo,$asunto_docente,$destino,$nombre_destino){
		
    
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
require 'OAuth.php';
require_once('../clases/Conexion.php');
$mail = new PHPMailer\PHPMailer\PHPMailer();


$mail->isSMTP();

$correo= "automatizacionunah2021@gmail.com";
$Password= "Hola*1234";
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'TSL';
$mail->SMTPAuth = true;
$mail->Username = $correo;
$mail->Password = $Password;
$mail->setFrom($correo, 'Unidad de Vinculación depto Informática ');
$mail->addAddress($destino, $nombre_destino);
$mail->Subject = $asunto_docente;
$mail->Body = $cuerpo;
$mail->CharSet = 'UTF-8'; // Con esto ya funcionan los acentos
$mail->IsHTML(true);

if (!$mail->send())
{
	echo "Error al enviar el E-Mail: ".$mail->ErrorInfo;
}
else
{
	echo " JUNTO AL CORREO DE AVISO";
}
}//cierre de la funcion


function enviarEmailPracticante($cuerpo_estudiante,$asunto_estudiante,$ecorreo,$estudiante){
		
    
	
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	
	
	$mail->isSMTP();
	
	$correo= "automatizacionunah2021@gmail.com";
    $Password= "Hola*1234";
	$mail->SMTPDebug =0;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'TSL';
	$mail->SMTPAuth = true;
	$mail->Username = $correo;
	$mail->Password = $Password;
	$mail->setFrom($correo, 'Unidad de Vinculación depto Informática ');
	$mail->addAddress($ecorreo, $estudiante);
	$mail->Subject = $asunto_estudiante;
	$mail->Body = $cuerpo_estudiante;
	$mail->CharSet = 'UTF-8'; // Con esto ya funcionan los acentos
	$mail->IsHTML(true);
	
	if (!$mail->send())
	{
		echo "Error al enviar el E-Mail: ".$mail->ErrorInfo;
	}
	else
	{
		echo "";
	}
	}//cierre de la funcion
	
    }//cierre class
?>