<?php
	

	session_start();


	require_once ('../clases/Conexion.php');

$Respuesta=strtoupper ($_POST['txt_respuestapu']);
$Pregunta=$_POST['combopregunta'];


  	$sql_preguntas=" select valor from tbl_parametros where parametro='cantidad_preguntas' " ;
$resultado_pregunta = $mysqli->query($sql_preguntas);
 $row_parametro_pregunta = mysqli_fetch_array($resultado_pregunta); 





	    if ($Pregunta>0) 
	    {
		
     		
			 $sql_existe_pregunta=("select count(Id_pregunta) as pregunta  from tbl_preguntas_seguridad where Id_pregunta='$Pregunta' and  Id_usuario= ".$_SESSION['id_usuario']." ");
			 //Obtener la fila del query
			$existe_pregunta = mysqli_fetch_assoc($mysqli->query($sql_existe_pregunta));






			if ($existe_pregunta['pregunta']==1)
			{
			header("location: ../vistas/crear_preguntas_usuario_vista.php?msj=4&estatus=".$_SESSION["estatus"]."");
			}

    		else	{

         
            		if (isset($_REQUEST['estatus_pregunta']) and $_REQUEST['estatus_pregunta']==2)
            		 {

            		 	$sql_contador_pregunta_usuario=" select count(Id_pregunta) as Contador from tbl_preguntas_seguridad where Id_usuario= ".$_SESSION['id_usuario']." " ;
								$resultado_pregunta = $mysqli->query($sql_contador_pregunta_usuario);
								 $row_preguntas = mysqli_fetch_array($resultado_pregunta); 

										$Contador=$row_preguntas['Contador'];



            		 		if ($Contador<$row_parametro_pregunta['valor'])

							 {
				/* Query para que haga el insert*/
										$sql = "call proc_insertar_pregunta_usuario('$Pregunta', ".$_SESSION['id_usuario'].", '$Respuesta')";									
										$resultado = $mysqli->query($sql);

												$Contador=$Contador + 1;
										   		header('location: ../vistas/crear_preguntas_usuario_vista.php?estatus='.$_SESSION["estatus"].' ');

										


            		 		 }	

					 if ($Contador==$row_parametro_pregunta['valor']) 

													{
									/*	$sql_actualizar_estatus = "UPDATE usuarios SET   Estatus=1 WHERE id_usuario= ".$_SESSION[id_usuario]." ";
												$resultado_actualizar_estatus= $mysqli->query($sql_actualizar_estatus);*/

						    					 header('location: ../vistas/cambiar_clave_x_usuario_vista.php?estatus='.$_SESSION["estatus"].' ');
													}

											

					}

            }


        }
		else
		{
		 header('location: ../vistas/crear_preguntas_usuario_vista.php?msj=2&estatus='.$_SESSION["estatus"].'');
        }



	?>