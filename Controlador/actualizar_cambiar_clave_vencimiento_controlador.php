<?php


	
require_once ('../clases/Conexion.php');
require_once ('../clases/encriptar_desencriptar.php'); 
require_once ('../clases/funcion_contra.php'); 


$Clave_actualV=cifrado::encryption ($_POST['txt_claveactualV']);
$Clave_nuevaV=cifrado::encryption ($_POST['txt_clavenuevaV']);
$Confirmar_claveV=cifrado::encryption ($_POST['txt_confirmarclaveV']);
$msj=0;




session_start();

 $sqlexiste=("select count(contrasena) as contrasena  from tbl_usuarios where Contrasena='$Clave_actualV'  and Id_usuario=".$_SESSION[id_usuario]." ");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


if ($_POST)
 {
   $error_encontrado="";
   if (validar_contra::validar_clave($_POST["txt_clavenuevaV"], $error_encontrado))
   {

    if ($existe['contrasena']==1)
		{
		  if ($Clave_nuevaV==$Confirmar_claveV)
 				{

 					if ($Clave_nuevaV<> $Clave_actualV)
 						{
					
                               	 	$msj=2;
								header("location: ../../login.php?msj=$msj");	
	                            $sql = "UPDATE tbl_usuarios SET    Contrasena='$Clave_nuevaV' , fec_vence_contrasena=sysdate()  WHERE Id_usuario= ".$_SESSION[id_usuario]." ";
						$resultado = $mysqli->query($sql);
                               	

 						}

 						else
 						{

 								$msj=4;
                          header("location: ../vistas/cambiar_clave_vencimiento_vista.php?msj=$msj");	
 						}
				
 				}
 				else
			{
							$msj=1;

			header("location: ../vistas/cambiar_clave_vencimiento_vista.php?msj=$msj");	
       	 }

		}
		else
		{
			$msj=3;


			header("location: ../vistas/cambiar_clave_vencimiento_vista.php?msj=$msj");	
        }


   }
   else
   {
   		$msj=6;
 header('location: ../vistas/cambiar_clave_vencimiento_vista.php?msj==$msj&error= '. $error_encontrado.' ');
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
 						header("location: ../login.php");
						?>
						<?php } else {


				if ($msj==6) {
					 header("location: ../vistas/cambiar_clave_vencimiento_vista.php?msj=$msj&error= ". $error_encontrado."  ");
					
				}
			else
			{
			header("location: ../vistas/cambiar_clave_vencimiento_vista.php?msj=$msj");
			}
						
}
	
						 ?>
		
					
					
					
				</div>
			</div>
		</div>
	</body>
</html>