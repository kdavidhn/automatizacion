<?php

  require_once ('../clases/Conexion.php');

	$Usuario=$_POST['usuarion'];
    $Boton="" ;

	if (isset($_POST['Correo'])) 
	  {
         $Boton="Correo";
     } 
     else 
     {
         $Boton="Pregunta";
     }



///Logica para el que se repite
 $sqlexiste=("select count(usuario) as usuario   from tbl_usuarios where usuario = '$Usuario'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

if ($existe['usuario']==1)
    {
 $sql_idusuario=("select Id_usuario  from tbl_usuarios where usuario = '$Usuario'");
 //Obtener la fila del query
$idusuario= mysqli_fetch_assoc($mysqli->query($sql_idusuario));
$idusuario2=$idusuario['Id_usuario'];
if ($Boton=='Pregunta') 
{
	 	header("location: ../vistas/recuperar_x_pregunta_vista.php?idusuario=$idusuario2");
	}	

  else
  {
  	 	header("location: ../vistas/recuperar_x_correo_vista.php?idusuario=$idusuario2");
  }
       

    }
   
    else
    {
     header('location: ../vistas/recuperar_clave_vista.php?msj=2');
    }

?>

