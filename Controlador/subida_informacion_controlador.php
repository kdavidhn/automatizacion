<?php

session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');




$Id_objeto=19;


$sqlsubida=("SELECT valor FROM `tbl_parametros` where Parametro='CANTIDAD_DOCUMENTOS'");
 //Obtener la fila del query
$datos = mysqli_fetch_assoc($mysqli->query($sqlsubida));


$_SESSION['Cantidad_Archivos']=count($_FILES["txt_documentos"]['tmp_name']);
$_SESSION['Cantidad_Archivos_parametro']=$datos['valor'];
$carpeta='../Documentacion_practica';
$cuenta=$_POST['txt_cuenta_estudiante'];


  $usuario=$_SESSION['id_usuario'];
        $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
       $result= mysqli_fetch_assoc($mysqli->query($id));
       $id_persona=$result['id_persona'];

	 $sqlexiste=("select count(id_persona) as cantidad from tbl_subida_documentacion where id_persona='$id_persona'");


if ($_SESSION['Cantidad_Archivos']<$_SESSION['Cantidad_Archivos_parametro'])
{
	



//Crea la carpeta si no existe......
	if(!file_exists($carpeta)){
		mkdir($carpeta.'/'.$cuenta.'/',0777,true);

		if(file_exists($carpeta)){
			foreach($_FILES["txt_documentos"]['tmp_name'] as $key => $tmp_name)
			{
				$nombre_archivo=$_FILES['txt_documentos']['name'][$key];
				$guardado=$_FILES['txt_documentos']['tmp_name'][$key];
$peso=$_FILES['txt_documentos']['size'][$key];
	
	
				if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
					|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")and $peso<=8000000)
				{
					if(move_uploaded_file($guardado,$carpeta.'/'.$cuenta.'/'.$nombre_archivo)){
			//echo "Archivo guardado con exito";
	 	if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
			|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
		{
					 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'EL DOCUMENTO'.$nombre_archivo.', EL USUARIO CON CUENTA: '.$cuenta.'');
				
 //Obtener la fila del query
					 	 $sqlexiste=("select count(id_persona) as cantidad from tbl_subida_documentacion where id_persona='$id_persona'");
					$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
					if ($existe['cantidad']==0)
					{
					 $sql = "call proc_insertar_subida_informacion ('$id_persona') ";

 					 $resultado = $mysqli->query($sql);

	
					}

		}
						echo '<script type="text/javascript">
						swal({
							title:"",
							text:"Los archivos fueron guardado con exito.",
							type: "success",
							showConfirmButton: false,
							timer: 3000
							});
							$(".FormularioAjax")[0].reset();

							</script>';

			 //   header("location:../vistas/subida_informacion_estudiante_vista.php?msj=2"); 

						}else
						{
							echo '<script type="text/javascript">
							swal({
								title:"",
								text:"Los archivos NO fueron guardado con exito.",
								type: "error",
								showConfirmButton: false,
								timer: 3000
								});
								$(".FormularioAjax")[0].reset();

                            </script>';				//    header("location:../vistas/subida_informacion_estudiante_vista.php?msj=3"); 

                        }

                    }
                    else
                    {
                    	 	if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
			|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
		{
					 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'EL DOCUMENTO'.$nombre_archivo.', EL USUARIO CON CUENTA: '.$cuenta.'');
					 	 $sqlexiste=("select count(id_persona) as cantidad from tbl_subida_documentacion where id_persona='$id_persona'");
					 	$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
					if ($existe['cantidad']==0)
					{
					 $sql = "call proc_insertar_subida_informacion ('$id_persona') ";

 					 $resultado = $mysqli->query($sql);

	
					}
		}
                 	echo '<script type="text/javascript">
				swal({
					title:"",
					text:"Lo sentimos archivos con extensión distintos a .pdf , .doc o .docx , o tamaño superior a 8MB fueron excluidos.",
					type: "success",
					showConfirmButton: false,
					timer: 7000
					});
					$(".FormularioAjax")[0].reset();

					</script>';
                    	}

                    			
                    }
                }
            }
            else{

//condicional si el fichero existe



            	$dir=opendir($carpeta);

			//Verifica si la carpeta ya existe de  la cuenta 
            	if(!file_exists($carpeta.'/'.$cuenta.'/')){
            		mkdir($carpeta.'/'.$cuenta.'/',0777,true);
            		foreach($_FILES["txt_documentos"]['tmp_name'] as $key => $tmp_name)
            		{
            			if($_FILES['txt_documentos']['name'][$key]) {

            				$nombre_archivo=$_FILES['txt_documentos']['name'][$key];
            				$guardado=$_FILES['txt_documentos']['tmp_name'][$key];
            				$ruta=$carpeta.'/'.$cuenta.'/'.$nombre_archivo;
            					$peso=$_FILES['txt_documentos']['size'][$key];

            				
            			
            					if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
            						|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")and $peso<=8000000)
            					{

            						if(move_uploaded_file($guardado,$ruta)){
            							if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
			|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
		{
					 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'EL DOCUMENTO'.$nombre_archivo.', EL USUARIO CON CUENTA: '.$cuenta.'');
					 	 $sqlexiste=("select count(id_persona) as cantidad from tbl_subida_documentacion where id_persona='$id_persona'");
					 	$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
					if ($existe['cantidad']==0)
					{
					 $sql = "call proc_insertar_subida_informacion ('$id_persona') ";

 					 $resultado = $mysqli->query($sql);

	
					}
		}
            							echo '<script type="text/javascript">
            							swal({
            								title:"",
            								text:"Los archivos fueron guardado con exito.",
            								type: "success",
            								showConfirmButton: false,
            								timer: 3000
            								});
            								$(".FormularioAjax")[0].reset();

			</script>';	//		  header("location:../vistas/subida_informacion_estudiante_vista.php?msj=2"); 

		}
		else
		{
			echo '<script type="text/javascript">
			swal({
				title:"",
				text:"Los archivos NO fueron guardado con exito.",
				type: "error",
				showConfirmButton: false,
				timer: 3000
				});
				$(".FormularioAjax")[0].reset();

                            </script>';		 // header("location:../vistas/subida_informacion_estudiante_vista.php?msj=3"); 


                        }
                    }
                    else
                    {
                    	if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
			|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
		{
					 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'EL DOCUMENTO'.$$nombre_archivo.', EL USUARIO CON CUENTA: '.$cuenta.'');
					 	 $sqlexiste=("select count(id_persona) as cantidad from tbl_subida_documentacion where id_persona='$id_persona'");
					 	$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
					if ($existe['cantidad']==0)
					{
					 $sql = "call proc_insertar_subida_informacion ('$id_persona') ";

 					 $resultado = $mysqli->query($sql);

	
					}
		}
                   	echo '<script type="text/javascript">
				swal({
					title:"",
					text:"Lo sentimos archivos con extensión distintos a .pdf , .doc o .docx , o tamaño superior a 8MB fueron excluidos.",
					type: "success",
					showConfirmButton: false,
					timer: 7000
					});
					$(".FormularioAjax")[0].reset();

					</script>';
                    	}
                    }
               
                }


            }
            else
            {

// eliminamos la carpeta o directorio si ya existe para solo volver a reemplazar

$ruta=$carpeta.'/'.$cuenta.'/';    // Carpeta que contine archivos y queremos eliminar 

foreach(glob($ruta."/*.*") as $archivos_carpeta) 
{ 
 unlink($archivos_carpeta);     // Eliminamos todos los archivos de la carpeta hasta dejarla vacia 
} 
//Elimina la carpeta del usuario 
rmdir($ruta); 
//Vuelve a crear la carpeta del usuario
mkdir($ruta,0777,true);


foreach($_FILES["txt_documentos"]['tmp_name'] as $key => $tmp_name)
{
	$nombre_archivo=$_FILES['txt_documentos']['name'][$key];
	$guardado=$_FILES['txt_documentos']['tmp_name'][$key];
	$ruta=$carpeta.'/'.$cuenta.'/'.$nombre_archivo;
	$peso=$_FILES['txt_documentos']['size'][$key];
	

		if ((($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
			|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) and $peso<=8000000)
		{


			if(move_uploaded_file($guardado,$ruta)){
//	echo "Archivos reemplazado";
				
		if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
			|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
		{
					 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'EL DOCUMENTO'.$nombre_archivo.', EL USUARIO CON CUENTA: '.$cuenta.'');
					 	 $sqlexiste=("select count(id_persona) as cantidad from tbl_subida_documentacion where id_persona='$id_persona'");
					 	$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
					if ($existe['cantidad']==0)
					{
					 $sql = "call proc_insertar_subida_informacion ('$id_persona') ";

 					 $resultado = $mysqli->query($sql);

	
					}
		}
				echo '<script type="text/javascript">
				swal({
					title:"",
					text:"Los archivos fueron reemplazado correctamente.",
					type: "success",
					showConfirmButton: false,
					timer: 3000
					});
					$(".FormularioAjax")[0].reset();

					</script>';
			//header("location:../vistas/subida_informacion_estudiante_vista.php?msj=4"); 


				}							
			}
			else
			{

		if (($_FILES["txt_documentos"]["type"][$key] == "application/pdf")
			|| ($_FILES["txt_documentos"]["type"][$key] == "application/msword") || ($_FILES["txt_documentos"]["type"][$key] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
		{
					 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'EL DOCUMENTO'.$nombre_archivo.', EL USUARIO CON CUENTA: '.$cuenta.'');
					 	 $sqlexiste=("select count(id_persona) as cantidad from tbl_subida_documentacion where id_persona='$id_persona'");
					 	$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
					if ($existe['cantidad']==0)
					{
					 $sql = "call proc_insertar_subida_informacion ('$id_persona') ";

 					 $resultado = $mysqli->query($sql);

	
					}
		}
		

				echo '<script type="text/javascript">
				swal({
					title:"",
					text:"Lo sentimos archivos con extensión distintos a .pdf , .doc o .docx , o tamaño superior a 8MB fueron excluidos.",
					type: "success",
					showConfirmButton: false,
					timer: 7000
					});
					$(".FormularioAjax")[0].reset();

					</script>';
				}
		



			}
		}



				closedir($dir); //Cerramos la conexion con la carpeta destino
			}


//Final del for }
		//final del If que cuenta los archivos
		}
		else
		{
   // header("location:../vistas/subida_informacion_estudiante_vista.php?msj=1"); 
			echo '<script type="text/javascript">
			swal({
				title:"",
				text:"Ha excedido el limite de archivos permitidos.",
				type: "info",
				showConfirmButton: false,
				timer: 3000
				});
				$(".FormularioAjax")[0].reset();

				</script>';
			}


			?>