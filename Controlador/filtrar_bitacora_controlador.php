<?php

  require_once ('../clases/Conexion.php');

	$Usuario=strtoupper($_POST['txt_usuario_bitacora']);
	$Accion=strtoupper($_POST['accion_bitacora']);
	$Fecha_Inicial=$_POST['txt_fecha_inicio'];
	$Fecha_Final=$_POST['txt_fecha_final'];

	/*$Fecha_Inicial->format('Y-m-d');
	$Fecha_Final->format('Y-m-d');*/
	/*$Id_usuario= $_GET['Id_usuario']; */
	$query="";


$sql_hoy = "select  Date_format(sysdate(),'%Y-%m-%d ') as Hoy";


$resultado_hoy = $mysqli->query($sql_hoy);
 $hoy =$resultado_hoy->fetch_array(MYSQLI_ASSOC);
  
  if ($Usuario<>'' and $Accion <>'0' and $Fecha_Inicial<>'' and $Fecha_Final<>'')
  {
  	if ($Fecha_Inicial<=$hoy and $Fecha_Final<=$hoy)
  	 {
  		$query=1;
	header("location: ../vistas/bitacora_vista.php?query=$query&usuario=$Usuario&accion=$Accion&fechainicio=$Fecha_Inicial&fechafinal=$Fecha_Final");

  	}

  	  }
	  	  elseif ($Usuario<>''and $Accion <>'0' and $Fecha_Inicial=='' and $Fecha_Final=='')
	  	   {

				$query=2;
				header("location: ../vistas/bitacora_vista.php?query=$query&usuario=$Usuario&accion=$Accion");
	   	   }
		  		elseif ($Usuario<>'' and $Accion =='0' and $Fecha_Inicial<>'' and $Fecha_Final<>'')
		  		 {
		  		 	if ($Fecha_Inicial<=$hoy and $Fecha_Final<=$hoy)
					  	 {
					  		$query=3;
							header("location: ../vistas/bitacora_vista.php?query=$query&usuario=$Usuario&fechainicio=$Fecha_Inicial&fechafinal=$Fecha_Final");

					  	}
		  					
		  		}
		  			elseif ($Usuario=='' and $Accion <>'0' and $Fecha_Inicial<>'' and $Fecha_Final<>'')
		  			 {
		  				
						if ($Fecha_Inicial<=$hoy and $Fecha_Final<=$hoy)
							  	 {
							  	$query=4;
											 header("location: ../vistas/bitacora_vista.php?query=$query&accion=$Accion&fechainicio=$Fecha_Inicial&fechafinal=$Fecha_Final");

							  	}
				
												  	

		  					
		  			}
		  			elseif ($Usuario=='' and $Accion <>'0' and $Fecha_Inicial=='' and $Fecha_Final=='') 
		  				{
		  							$query=5;
									header("location: ../vistas/bitacora_vista.php?query=$query&accion=$Accion");

		  				}
			  				elseif ($Usuario=='' and $Accion =='0' and $Fecha_Inicial<>'' and $Fecha_Final<>'') 
			  				{

			  						if ($Fecha_Inicial<=$hoy and $Fecha_Final<=$hoy)
							  	 {
							  		$query=6;
										header("location: ../vistas/bitacora_vista.php?query=$query&fechainicio=$Fecha_Inicial&fechafinal=$Fecha_Final");

							  	}
			  						
			  				}
				  						elseif ($Usuario<>'' and $Accion =='0' and $Fecha_Inicial=='' and $Fecha_Final=='') 
				  				{
				  							$query=7;
											header("location: ../vistas/bitacora_vista.php?query=$query&usuario=$Usuario");
				  				}


				if ( $Fecha_Inicial> $hoy or $Fecha_Final> $hoy)
				 {
				header("location: ../vistas/bitacora_vista.php?msj=1");
				}
				if ($Usuario=='' and $Accion =='0' and $Fecha_Inicial=='' and $Fecha_Final=='')
				 {
				 		header("location: ../vistas/bitacora_vista.php?msj=2");
				}
				if (($Fecha_Inicial<>'' and $Fecha_Final=='') or ( $Fecha_Inicial=='' and $Fecha_Final<>'') )
				 {
				 		header("location: ../vistas/bitacora_vista.php?msj=3");
				}
				  		

  
	

?>