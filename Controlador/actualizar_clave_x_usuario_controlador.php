<?php

	session_start();
	
require_once ('../clases/Conexion.php');
 require_once ('../clases/encriptar_desencriptar.php'); 
require_once ('../clases/funcion_contra.php'); 

								

$Clave_actual=cifrado::encryption ($_POST['txt_claveactual']);
$Clave_nueva=cifrado::encryption ($_POST['txt_clavenueva']);
$Confirmar_clave=cifrado::encryption ($_POST['txt_confirmarclave']);
$msj=0;




session_start();

 $sqlexiste=("select count(contrasena) as contrasena  from tbl_usuarios where Contrasena='$Clave_actual' and Id_usuario=".$_SESSION['id_usuario']." ");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


if ($_POST)
 {
   $error_encontrado="";
   if (validar_contra::validar_clave($_POST["txt_clavenueva"], $error_encontrado))
   {

    if ($existe['contrasena']==1)
		{
		  if ($Clave_nueva==$Confirmar_clave)
 				{

 					if ($Clave_nueva<> $Clave_actual)
 						{
					

                            
                              	if ( $_REQUEST['estatus']==2) 
                               	{
                                     	$msj=5;
                   

                               	}
                               	else
                               	{

                               	

							        $Id_objeto=12 ; 

                               	
                               		   	
									header("Location: https://www.informaticaunah.com/automatizacion/login.php");
	                            $sql = "UPDATE tbl_usuarios SET    Contrasena='$Clave_nueva' WHERE Id_usuario= ".$_SESSION['id_usuario']." ";
						$resultado = $mysqli->query($sql);
							
                               	}

 						}

 						else
 						{

 								$msj=4;
                          header("location: ../vistas/cambiar_clave_x_usuario_vista.php?msj=$msj&estatus=".$_SESSION["estatus"]."");	
 						}
				
 				}
 				else
			{
							$msj=1;

			header("location: ../vistas/cambiar_clave_x_usuario_vista.php?msj=$msj&estatus=".$_SESSION["estatus"]."");	
       	 }

		}
		else
		{
			$msj=3;


			header("location: ../vistas/cambiar_clave_x_usuario_vista.php?msj=$msj&estatus=".$_SESSION["estatus"]."");	
        }


   }
   else
   {
   		$msj=6;
 header('location: ../vistas/cambiar_clave_x_usuario_vista.php?msj==$msj&error= '. $error_encontrado.' ');
   }
}




	?>


	

	<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>	
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="row" style="text-align:center">
					<?php if($resultado && isset($resultado) ) { 
 						header("location: https://www.informaticaunah.com/automatizacion/login.php");
						?>
						<?php } else {

if ($msj==5) {

         		$sql_actualizar_1 = "UPDATE tbl_usuarios SET    Contrasena='$Clave_nueva', estado=1 WHERE Id_usuario= ".$_SESSION['id_usuario']."  ";
						$resultado_actualizar_1= $mysqli->query($sql_actualizar_1);
                                                          		  
                              	//header("location: https://www.informaticaunah.com/automatizacion/login.php");
								  echo "<script> window.location.replace('https://www.informaticaunah.com/automatizacion/login.php'); </script>";	

}
else
{
				if ($msj==6) {
					 header("location: ../vistas/cambiar_clave_x_usuario_vista.php?msj=$msj&error= ". $error_encontrado." &estatus=".$_SESSION["estatus"]."  ");
					
				}
			else
			{
			header("location: ../vistas/cambiar_clave_x_usuario_vista.php?msj=$msj&estatus=".$_SESSION["estatus"]."");
			}
						
}
	
						 ?>
					<?php } ?>
					
					
					
				</div>
			</div>
		</div>
	</body>
</html>