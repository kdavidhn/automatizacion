<?php
	 session_start();

require_once ('../clases/Conexion.php');
 require_once ('../clases/encriptar_desencriptar.php');
	 require_once ('../clases/funcion_contra.php');
 require_once ('../clases/funcion_bitacora.php');

              
            


   $id_persona=strtoupper ($_POST['txt_id']);
	$Usuario=strtoupper ($_POST['txt_usuario']);
	$Nombre=strtoupper ($_POST['txt_nombreusuario']);
	$Correo_electronico=$_POST['txt_correoe'];
	$Contrasena=cifrado::encryption($_POST['txt_contrasenau']);
	$Confirmar_contrasena=cifrado::encryption($_POST['txt_confirmar_contrasenau']);

	$Id_rol=$_POST['comborol'];
	
 $var=0;

 $estado= '';
///Logica para el que se repite
 $sqlexiste=("select count(usuario) as usuario  from tbl_usuarios where usuario='$Usuario'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



 if ($_POST)
 {
   $error_encontrado="";
   if (validar_contra::validar_clave($_POST["txt_contrasenau"], $error_encontrado))
   {

   	if ($Contrasena==$Confirmar_contrasena)
 				{

 
 if ($existe['usuario']==1)
    {

    	/* require"../contenidos/registrarUser-view.php"; */
 	//header('location: ../contenidos/registrarUser-view.php?msj=1');
    	echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"El Usuario <?php $Usuario ?> ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';  
    }
    else
    {
        /* Condicion para el checkbox si esta activo o no*/
		





	    			if ($Id_rol>0) 
	    			{

               $Id_objeto=3 ; 


	    				    
    			/* Query para que haga el insert*/
            $sql = "call proc_insertar_usuario ('$id_persona',
                                                  '$Usuario', 
                                                 '$Id_rol',
                                                  '$Contrasena',
                                                 ' $_SESSION[usuario] ')" ;
        $resultado = $mysqli->query($sql);


	        if($resultado === TRUE) {

                              bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL USUARIO '.$Usuario.'');

	        /*	 require"../contenidos/registrarUser-view.php"; */
    		//header('location: ../contenidos/registrarUser-view.php?msj=2');
    		 echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos  se almacenaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>'; 
			} 
			else 
			{
    		echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"No se guardaron los datos",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                </script>';
			}

					}
					else
					{
						/*require"../contenidos/registrarUser-view.php"; */
					//header('location: ../contenidos/registrarUser-view.php?msj=3');
						echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"Lo sentimos tiene campos por rellenar",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                </script>';
					}




    }

        }
 				else
			{
						

			echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Las contraseñas no son iguales",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
       	 }


   }
   else
   {
   /*	require"../contenidos/registrarUser-view.php?error= '. $error_encontrado.'"; */
 //header('location: ../contenidos/registrarUser-view.php?msj=4&error= '. $error_encontrado.' ');
   //echo $error_encontrado;
   echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"'.$error_encontrado.'",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
   }
}




?>