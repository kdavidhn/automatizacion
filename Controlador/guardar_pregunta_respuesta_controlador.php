<?php


    require_once ('../clases/Conexion.php');



        if (isset($_REQUEST['msj']))
        {
        $msj=$_REQUEST['msj'];

              if ($msj==1)
              {
              echo '<script> alert(" Respuesta correcta")</script>';
              }

                    if ($msj==2)
                    {
                    echo '<script> alert(" Respuesta incorrecta")</script>';
                    }
        }






if (isset($_Request['id_usuario'])) 
{
	$Respuesta=$_POST['txt_respuestap'];
$Combopregunta=$_POST['combopregunta'];
$idusuario=$_GET['id_usuario'];

}  
$idusuario=$_GET['id_usuario'];

if ($_POST['txt_respuestap']  <>' ')
{                            

      /* Query para que haga el select*/
				$sqlexiste = "select count(Respuesta) as Respuesta from tbl_preguntas_seguridad where Respuesta='$_POST[txt_respuestap]' and Id_usuario='$_REQUEST[id_usuario]' and id_pregunta='$_POST[combopregunta]'";
			

$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


if ($existe['Respuesta']==1) 
{
	
header("location: ../vistas/cambiar_clave_x_pregunta_vista.php?id_usuario2=$idusuario");
}
else
{
	//echo '<script> alert("Lo sentimos la respuesta no es la correcta")</script>';
	header("location: ../vistas/recuperar_x_pregunta_vista.php?msj=2&idusuario=$idusuario");
}



}
else
{
echo '<script> alert("Lo sentimos tiene campos por rellenar ")</script>';
}

?>