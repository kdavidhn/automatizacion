<?php

global $mysqli;

require_once ('../clases/class.phpmailer.php'); 
require_once ('../clases/class.smtp.php'); 

class Email  extends PHPMailer{

    //datos de remitente
    var $fila2;
    var $fila1;
    var $fila3;

    /**
 * Constructor de clase
 */


    public function __construct($fila1,$fila2,$fila3)
    {

require ('../clases/Conexion.php');

      $sql_parametro_host="select valor as Valor from tbl_parametros where parametro='HOST_SMTP' ";
$resultado_parametro_host = $mysqli->query($sql_parametro_host);
$fila4 = mysqli_fetch_array($resultado_parametro_host);


$sql_parametro_puerto="select valor as Valor from tbl_parametros where parametro='Puerto' ";
$resultado_parametro_puerto = $mysqli->query($sql_parametro_puerto);
$fila5 = mysqli_fetch_array($resultado_parametro_puerto);



      //configuracion general
     $this->IsSMTP(); // protocolo de transferencia de correo
     $this->Host = $fila4['Valor'];  // Servidor GMAIL
     $this->Port = $fila5['Valor']; //puerto
     $this->SMTPAuth = true; // Habilitar la autenticación SMTP
     $this->Username = $this->tu_email=$fila2;
     $this->Password = $this->tu_password=$fila3;
     $this->SMTPSecure = 'ssl';  //habilita la encriptacion SSL
     //remitente
     $this->From = $this->tu_email;
     $this->FromName = $this->tu_nombre=$fila1;
	   $this->CharSet='UTF8';
    }

    /**
 * Metodo encargado del envio del e-mail
 */
    public function enviar($asunto , $contenido)
    {
      //$this->AddAddress($para,$nombre );  // Correo y nombre a quien se envia
	   //$this->addCC("harold-c-m@hotmail.com",'Harold Campo Morales');
	   //$this->addBCC("harold-c-m@hotmail.com",'Harold Campo Morales'); 
       $this->WordWrap = 50; // Ajuste de texto
       $this->IsHTML(true); //establece formato HTML para el contenido
       $this->Subject =$asunto;
       $this->Body    =  $contenido; //contenido con etiquetas HTML
       $this->AltBody =  strip_tags($contenido); //Contenido para servidores que no aceptan HTML
	   //$this->addAttachment("archivoadjunto.pdf",'Prueba 1.pdf');
	   //$this->addAttachment("archivoadjunto.pdf",'Prueba 2.pdf');
       //envio de e-mail y retorno de resultado
       return $this->Send() ;
   }
   ///Opcional nombre
   public function agregar($correo,$nombre = ''){
	   $this->addAddress($correo,$nombre);
	}

}//--> fin clase
	
	//$contenido =$_post['contenido'];
?>