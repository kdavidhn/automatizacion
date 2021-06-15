<?php

require_once ('../clases/Conexion.php');
require_once ('../clases/encriptar_desencriptar.php'); 
require_once "../Modelos/login_modelo.php";
$login = new Login();

$Usuario=$_POST['usuario'];
$contra=$_POST['clave'];
$Clave=cifrado::encryption ($_POST['clave']);

$cuenta = strlen($Usuario);
/* Obtiene el valor del parametro de intentos de contraseña*/
$sql_intentos=" select valor from tbl_parametros where parametro='intentos' " ;
$resultado_intento = $mysqli->query($sql_intentos);
$row_parametro_intento = mysqli_fetch_array($resultado_intento); 
            
if(is_numeric($Usuario) && $cuenta==11)
{
	/* obtiene el id persona*/
	$sql="SELECT id_persona from tbl_personas_extendidas where valor='$Usuario'";
	$resultado1 = $mysqli->query($sql);
	$fila = mysqli_fetch_array($resultado1); 
	session_start();
	$_SESSION["id"]=$fila['id_persona'];
	/* Verifica que el usuario y contraseña sean correctas, si es uno es correcto , si noes falso*/
	$sql_usuario="  SELECT count(px.valor) as usuario from tbl_usuarios u, tbl_personas_extendidas px where px.valor='$Usuario' and u.Contrasena='$Clave' and u.id_persona='$_SESSION[id]' " ;
	$result_usuario = $mysqli->query($sql_usuario);
	$row = mysqli_fetch_array($result_usuario); 

	/* Obtiene el valor del parametro de intentos de contraseña*/
	$sql_intentos=" select valor from tbl_parametros where parametro='intentos' " ;
	$resultado_intento = $mysqli->query($sql_intentos);
	$row_parametro_intento = mysqli_fetch_array($resultado_intento); 

	/*Valida  el count , si el usuario y contraseña son correctos*/

if ($row['usuario'] ==1 ) 
{
	
	/*si es correcto obtengo los datos*/
	$sql_datos="SELECT u.id_usuario,u.id_persona,u.usuario, u.estado from tbl_usuarios u, tbl_personas_extendidas px where px.valor='$Usuario' and u.Contrasena='$Clave' and u.id_persona='$_SESSION[id]'" ;
	$result = $mysqli->query($sql_datos);
	$row = mysqli_fetch_array($result); 
	session_start();
	$_SESSION["id_usuario"]=$row['id_usuario'];
	$_SESSION["id_persona"]=$row['id_persona'];
	$_SESSION["usuario"]=$row['usuario'];
	$_SESSION["estatus"]=$row['estado'];

	/*Si el usuario ingresa correctamente le actualiza los intentos en cero*/

	$sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario= '$_SESSION[id_usuario]' ";
	$resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);


	if ($_SESSION["estatus"]==1)
	{
		/* require"../contenidos/home-view.php"; */
		$sql_fecha_contrasena=" SELECT DATEDIFF( sysdate(), fec_vence_contrasena) as Vence_contra from tbl_usuarios where id_usuario= '$_SESSION[id_usuario]' ";
		$resultado_fecha_contra=mysqli_fetch_assoc($mysqli->query($sql_fecha_contrasena));

		$parametro_fecha_vence="SELECT valor from tbl_parametros where parametro='CAMBIO_CLAVE' ";
		$resultado_PARAMETRO_fecha_contra=mysqli_fetch_assoc($mysqli->query($parametro_fecha_vence));

		if ($resultado_fecha_contra['Vence_contra']<$resultado_PARAMETRO_fecha_contra['valor']) 
		{
			header('location: ../vistas/pagina_principal_vista.php');	
		}
		else
		{
			header('location: ../vistas/cambiar_clave_vencimiento_vista.php');	
		}
	}		
	elseif($_SESSION["estatus"]==0) 
	{
		header('location: ../login.php?msj=5');	

	}
	else
	{
		/*header('location: ../contenidos/cambiarClaveUsuario-view.php?estatus='.$_SESSION["estatus"].'');	*/
		header('location: ../vistas/crear_preguntas_usuario_vista.php?estatus='.$_SESSION["estatus"].'');	
	}
}
/*si el usuario y contraseña es incorrecto*/
else
{
		/*Este query valida si el usuario fue correcto y la contraseña fue incorrecta*/
		$sql_verificar_usuario=" SELECT count(usuario) as usuario from tbl_usuarios where usuario='$Usuario' " ;
		$resultado_verificar_usuario = $mysqli->query($sql_verificar_usuario);
		$row = mysqli_fetch_array($resultado_verificar_usuario); 

		/*Aqui valida si el count es 1, el usuario es correcto*/
		if ($row['usuario']==1)
		{
			/*Si es correcto aqui se obtiene los intentos fallidos que hace el usuario*/
			$sql_intento_usuario=" SELECT intentos from tbl_usuarios where usuario='$Usuario' " ;
			$result = $mysqli->query($sql_intento_usuario);
			$row_intentos = mysqli_fetch_array($result); 
			$intentos=$row_intentos['intentos'];

			/*obtiene los datos del usuario si  se ha equivocado en la contraseña*/
			$sql_datos_clave_incorrecta=" SELECT id_usuario,usuario from tbl_usuarios where usuario='$Usuario' " ;
			$resultado_datos_clave_incorrecta = $mysqli->query($sql_datos_clave_incorrecta);
			$row_datos_clave_incorrecta = mysqli_fetch_array($resultado_datos_clave_incorrecta); 

			session_start();
			$_SESSION["id_usuario"]=$row_datos_clave_incorrecta['id_usuario'];
			$_SESSION["usuario"]=$row_datos_clave_incorrecta['usuario'];

			$sql_admin="SELECT count(id_usuario) as idusuario from tbl_usuarios where Usuario='admin' and id_usuario=".$_SESSION['id_usuario']." ";
			$resultado_admin=  $mysqli->query($sql_admin);
			$row_parametro_intento_admin = mysqli_fetch_array($resultado_admin); 

				/*Aqui valida que los intentos de logearse del usuariario sean menos a los del parametro intentos, de lo contrario se bloquearia*/
			if ($intentos<$row_parametro_intento['valor'])
			{
				$intentos=($intentos + 1 );
				/* Aqui actualiza los intentos fallidos*/
				$sql = "UPDATE tbl_usuarios SET   Intentos=$intentos WHERE id_usuario=".$_SESSION[id_usuario]."  ";
				$resultado = $mysqli->query($sql);
				/*Aqui envia los intentos fallidos de acuerdo al usuario*/													
				header("location: ../login.php?msj=3&intentos=$intentos" );	
							
			}
			elseif ($row_parametro_intento_admin['idusuario']==1)
			{
				$sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
				$resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);
				header('location: ../login.php');
			}
			else
			{
				/*Esta condicion permite que al llegar al limite de intentos el usuario se bloquea*/
				$sql_bloqueo_usuario = "UPDATE tbl_usuarios SET   Intentos=0 , estado=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
				$resultado_bloqueo_usuario = $mysqli->query($sql_bloqueo_usuario);
				header('location: ../login.php?msj=4');	

			}

	}
	else
	{
	
		header('location: ../login.php?msj=2');	

	}			
}  
   
}
elseif(is_numeric($Usuario) &&  $cuenta==6)
{
	/* obtiene el id persona*/
	$sql="SELECT id_persona from tbl_personas_extendidas where valor='$Usuario'";
	$resultado1 = $mysqli->query($sql);
	$fila = mysqli_fetch_array($resultado1); 
	session_start();
	$_SESSION["id"]=$fila['id_persona'];
	/* Verifica que el usuario y contraseña sean correctas, si es uno es correcto , si noes falso*/
	$sql_usuario="  SELECT count(px.valor) as usuario from tbl_usuarios u, tbl_personas_extendidas px where px.valor='$Usuario' and u.Contrasena='$Clave' and u.id_persona='$_SESSION[id]' " ;
	$result_usuario = $mysqli->query($sql_usuario);
	$row = mysqli_fetch_array($result_usuario); 

	/* Obtiene el valor del parametro de intentos de contraseña*/
	$sql_intentos=" select valor from tbl_parametros where parametro='intentos' " ;
	$resultado_intento = $mysqli->query($sql_intentos);
	$row_parametro_intento = mysqli_fetch_array($resultado_intento); 

	/*Valida  el count , si el usuario y contraseña son correctos*/

if ($row['usuario'] ==1 ) 
{
	
	/*si es correcto obtengo los datos*/
	$sql_datos="SELECT u.id_usuario,u.id_persona,u.usuario, u.estado from tbl_usuarios u, tbl_personas_extendidas px where px.valor='$Usuario' and u.Contrasena='$Clave' and u.id_persona='$_SESSION[id]'" ;
	$result = $mysqli->query($sql_datos);
	$row = mysqli_fetch_array($result); 
	session_start();
	$_SESSION["id_usuario"]=$row['id_usuario'];
	$_SESSION["id_persona"]=$row['id_persona'];
	$_SESSION["usuario"]=$row['usuario'];
	$_SESSION["estatus"]=$row['estado'];

	/*Si el usuario ingresa correctamente le actualiza los intentos en cero*/

	$sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario= '$_SESSION[id_usuario]' ";
	$resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);


	if ($_SESSION["estatus"]==1)
	{
		/* require"../contenidos/home-view.php"; */
		$sql_fecha_contrasena=" SELECT DATEDIFF( sysdate(), fec_vence_contrasena) as Vence_contra from tbl_usuarios where id_usuario= '$_SESSION[id_usuario]' ";
		$resultado_fecha_contra=mysqli_fetch_assoc($mysqli->query($sql_fecha_contrasena));

		$parametro_fecha_vence="SELECT valor from tbl_parametros where parametro='CAMBIO_CLAVE' ";
		$resultado_PARAMETRO_fecha_contra=mysqli_fetch_assoc($mysqli->query($parametro_fecha_vence));

		if ($resultado_fecha_contra['Vence_contra']<$resultado_PARAMETRO_fecha_contra['valor']) 
		{
			header('location: ../vistas/pagina_principal_vista.php');	
		}
		else
		{
			header('location: ../vistas/cambiar_clave_vencimiento_vista.php');	
		}
	}		
	elseif($_SESSION["estatus"]==0) 
	{
		header('location: ../login.php?msj=5');	

	}
	else
	{
		/*header('location: ../contenidos/cambiarClaveUsuario-view.php?estatus='.$_SESSION["estatus"].'');	*/
		header('location: ../vistas/crear_preguntas_usuario_vista.php?estatus='.$_SESSION["estatus"].'');	
	}
}
/*si el usuario y contraseña es incorrecto*/
else
{
		/*Este query valida si el usuario fue correcto y la contraseña fue incorrecta*/
		$sql_verificar_usuario=" SELECT count(usuario) as usuario from tbl_usuarios where usuario='$Usuario' " ;
		$resultado_verificar_usuario = $mysqli->query($sql_verificar_usuario);
		$row = mysqli_fetch_array($resultado_verificar_usuario); 

		/*Aqui valida si el count es 1, el usuario es correcto*/
		if ($row['usuario']==1)
		{
			/*Si es correcto aqui se obtiene los intentos fallidos que hace el usuario*/
			$sql_intento_usuario=" SELECT intentos from tbl_usuarios where usuario='$Usuario' " ;
			$result = $mysqli->query($sql_intento_usuario);
			$row_intentos = mysqli_fetch_array($result); 
			$intentos=$row_intentos['intentos'];

			/*obtiene los datos del usuario si  se ha equivocado en la contraseña*/
			$sql_datos_clave_incorrecta=" SELECT id_usuario,usuario from tbl_usuarios where usuario='$Usuario' " ;
			$resultado_datos_clave_incorrecta = $mysqli->query($sql_datos_clave_incorrecta);
			$row_datos_clave_incorrecta = mysqli_fetch_array($resultado_datos_clave_incorrecta); 

			session_start();
			$_SESSION["id_usuario"]=$row_datos_clave_incorrecta['id_usuario'];
			$_SESSION["usuario"]=$row_datos_clave_incorrecta['usuario'];

			$sql_admin="SELECT count(id_usuario) as idusuario from tbl_usuarios where Usuario='admin' and id_usuario=".$_SESSION['id_usuario']." ";
			$resultado_admin=  $mysqli->query($sql_admin);
			$row_parametro_intento_admin = mysqli_fetch_array($resultado_admin); 

				/*Aqui valida que los intentos de logearse del usuariario sean menos a los del parametro intentos, de lo contrario se bloquearia*/
			if ($intentos<$row_parametro_intento['valor'])
			{
				$intentos=($intentos + 1 );
				/* Aqui actualiza los intentos fallidos*/
				$sql = "UPDATE tbl_usuarios SET   Intentos=$intentos WHERE id_usuario=".$_SESSION[id_usuario]."  ";
				$resultado = $mysqli->query($sql);
				/*Aqui envia los intentos fallidos de acuerdo al usuario*/													
				header("location: ../login.php?msj=3&intentos=$intentos" );	
							
			}
			elseif ($row_parametro_intento_admin['idusuario']==1)
			{
				$sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
				$resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);
				header('location: ../login.php');
			}
			else
			{
				/*Esta condicion permite que al llegar al limite de intentos el usuario se bloquea*/
				$sql_bloqueo_usuario = "UPDATE tbl_usuarios SET   Intentos=0 , estado=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
				$resultado_bloqueo_usuario = $mysqli->query($sql_bloqueo_usuario);
				header('location: ../login.php?msj=4');	

			}

	}
	else
	{
	
		header('location: ../login.php?msj=2');	

	}			
}  
	
}
elseif(ctype_alpha($Usuario)==true)
{
			/* Verifica que el usuario y contraseña sean correctas, si es uno es correcto , si noes falso*/
			$sql_usuario=" select count(usuario) as usuario from tbl_usuarios where usuario='$Usuario' and Contrasena='$Clave' " ;
			$result_usuario = $mysqli->query($sql_usuario);
			$row = mysqli_fetch_array($result_usuario); 

			/* Obtiene el valor del parametro de intentos de contraseña*/
			$sql_intentos=" select valor from tbl_parametros where parametro='intentos' " ;
			$resultado_intento = $mysqli->query($sql_intentos);
			$row_parametro_intento = mysqli_fetch_array($resultado_intento); 

			/*Valida  el count , si el usuario y contraseña son correctos*/

		if ($row['usuario'] ==1 ) 
		{

			/*si es correcto obtengo los datos*/
			$sql_datos=" SELECT id_usuario,id_persona,usuario, estado from tbl_usuarios where usuario='$Usuario' and Contrasena='$Clave' " ;
			$result = $mysqli->query($sql_datos);
			$row = mysqli_fetch_array($result); 
			session_start();
			$_SESSION["id_usuario"]=$row['id_usuario'];
			$_SESSION["id_persona"]=$row['id_persona'];
			$_SESSION["usuario"]=$row['usuario'];
			$_SESSION["estatus"]=$row['estado'];

			/*Si el usuario ingresa correctamente le actualiza los intentos en cero*/

			$sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario= '$_SESSION[id_usuario]' ";
			$resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);


			if ($_SESSION["estatus"]==1)
			{
				/* require"../contenidos/home-view.php"; */
				$sql_fecha_contrasena=" SELECT DATEDIFF( sysdate(), fec_vence_contrasena) as Vence_contra from tbl_usuarios where id_usuario= '$_SESSION[id_usuario]' ";
				$resultado_fecha_contra=mysqli_fetch_assoc($mysqli->query($sql_fecha_contrasena));

				$parametro_fecha_vence="SELECT valor from tbl_parametros where parametro='CAMBIO_CLAVE' ";
				$resultado_PARAMETRO_fecha_contra=mysqli_fetch_assoc($mysqli->query($parametro_fecha_vence));

				if ($resultado_fecha_contra['Vence_contra']<$resultado_PARAMETRO_fecha_contra['valor']) 
				{
					header('location: ../vistas/pagina_principal_vista.php');	
				}
				else
				{
					header('location: ../vistas/cambiar_clave_vencimiento_vista.php');	
				}
			}		
			elseif($_SESSION["estatus"]==0) 
			{
				header('location: ../login.php?msj=5');	

			}
			else
			{
				/*header('location: ../contenidos/cambiarClaveUsuario-view.php?estatus='.$_SESSION["estatus"].'');	*/
				header('location: ../vistas/crear_preguntas_usuario_vista.php?estatus='.$_SESSION["estatus"].'');	
			}
		}
		/*si el usuario y contraseña es incorrecto*/
		else
		{
				/*Este query valida si el usuario fue correcto y la contraseña fue incorrecta*/
				$sql_verificar_usuario=" SELECT count(usuario) as usuario from tbl_usuarios where usuario='$Usuario' " ;
				$resultado_verificar_usuario = $mysqli->query($sql_verificar_usuario);
				$row = mysqli_fetch_array($resultado_verificar_usuario); 

				/*Aqui valida si el count es 1, el usuario es correcto*/
				if ($row['usuario']==1)
				{
					/*Si es correcto aqui se obtiene los intentos fallidos que hace el usuario*/
					$sql_intento_usuario=" SELECT intentos from tbl_usuarios where usuario='$Usuario' " ;
					$result = $mysqli->query($sql_intento_usuario);
					$row_intentos = mysqli_fetch_array($result); 
					$intentos=$row_intentos['intentos'];

					/*obtiene los datos del usuario si  se ha equivocado en la contraseña*/
					$sql_datos_clave_incorrecta=" SELECT id_usuario,usuario from tbl_usuarios where usuario='$Usuario' " ;
					$resultado_datos_clave_incorrecta = $mysqli->query($sql_datos_clave_incorrecta);
					$row_datos_clave_incorrecta = mysqli_fetch_array($resultado_datos_clave_incorrecta); 

					session_start();
					$_SESSION["id_usuario"]=$row_datos_clave_incorrecta['id_usuario'];
					$_SESSION["usuario"]=$row_datos_clave_incorrecta['usuario'];

					$sql_admin="SELECT count(id_usuario) as idusuario from tbl_usuarios where Usuario='admin' and id_usuario=".$_SESSION['id_usuario']." ";
					$resultado_admin=  $mysqli->query($sql_admin);
					$row_parametro_intento_admin = mysqli_fetch_array($resultado_admin); 

						/*Aqui valida que los intentos de logearse del usuariario sean menos a los del parametro intentos, de lo contrario se bloquearia*/
					if ($intentos<$row_parametro_intento['valor'])
					{
						$intentos=($intentos + 1 );
						/* Aqui actualiza los intentos fallidos*/
						$sql = "UPDATE tbl_usuarios SET   Intentos=$intentos WHERE id_usuario=".$_SESSION[id_usuario]."  ";
						$resultado = $mysqli->query($sql);
						/*Aqui envia los intentos fallidos de acuerdo al usuario*/													
						header("location: ../login.php?msj=3&intentos=$intentos" );	
									
					}
					elseif ($row_parametro_intento_admin['idusuario']==1)
					{
						$sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
						$resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);
						header('location: ../login.php');
					}
					else
					{
						/*Esta condicion permite que al llegar al limite de intentos el usuario se bloquea*/
						$sql_bloqueo_usuario = "UPDATE tbl_usuarios SET   Intentos=0 , estado=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
						$resultado_bloqueo_usuario = $mysqli->query($sql_bloqueo_usuario);
						header('location: ../login.php?msj=4');	

					}

			}
			else
			{
			
				header('location: ../login.php?msj=2');	

			}			
		}  
}

/* Verifica que el usuario y contraseña sean correctas, si es uno es correcto , si noes falso
$sql_usuario=" select count(usuario) as usuario from tbl_usuarios where usuario='$Usuario' and Contrasena='$Clave' " ;
$result_usuario = $mysqli->query($sql_usuario);
 $row = mysqli_fetch_array($result_usuario); 

/* Obtiene el valor del parametro de intentos de contraseña
   	$sql_intentos=" select valor from tbl_parametros where parametro='intentos' " ;
$resultado_intento = $mysqli->query($sql_intentos);
 $row_parametro_intento = mysqli_fetch_array($resultado_intento); 




/*Valida  el count , si el usuario y contraseña son correctos

if ($row['usuario'] ==1 ) 
   {

/*si es correcto obtengo los datos
   	$sql_datos=" select id_usuario,id_persona,usuario, estado from tbl_usuarios where usuario='$Usuario' and Contrasena='$Clave' " ;
$result = $mysqli->query($sql_datos);
 $row = mysqli_fetch_array($result); 

     
   


session_start();
$_SESSION["id_usuario"]=$row['id_usuario'];
$_SESSION["id_persona"]=$row['id_persona'];
$_SESSION["usuario"]=$row['usuario'];
$_SESSION["estatus"]=$row['estado'];

/*Si el usuario ingresa correctamente le actualiza los intentos en cero

	$sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario= '$_SESSION[id_usuario]' ";
	$resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);


	if ($_SESSION["estatus"]==1)
	{
	/* require"../contenidos/home-view.php"; 
$sql_fecha_contrasena=" SELECT DATEDIFF( sysdate(), fec_vence_contrasena) as Vence_contra from tbl_usuarios where id_usuario= '$_SESSION[id_usuario]' ";
$resultado_fecha_contra=mysqli_fetch_assoc($mysqli->query($sql_fecha_contrasena));


$parametro_fecha_vence="select valor from tbl_parametros where parametro='CAMBIO_CLAVE' ";
$resultado_PARAMETRO_fecha_contra=mysqli_fetch_assoc($mysqli->query($parametro_fecha_vence));


if ($resultado_fecha_contra['Vence_contra']<$resultado_PARAMETRO_fecha_contra['valor']) 
{
header('location: ../vistas/pagina_principal_vista.php');	
}
else
{
	header('location: ../vistas/cambiar_clave_vencimiento_vista.php');	
}




	}

	elseif($_SESSION["estatus"]==0) 
	{
		 header('location: ../login.php?msj=5');	

	}
	else
	{
/*header('location: ../contenidos/cambiarClaveUsuario-view.php?estatus='.$_SESSION["estatus"].'');	
 header('location: ../vistas/crear_preguntas_usuario_vista.php?estatus='.$_SESSION["estatus"].'');	
	}
 
   }

/*si el usuario y contraseña es incorrecto
 else
   {

/*Este query valida si el usuario fue correcto y la contraseña fue incorrecta

		$sql_verificar_usuario=" select count(usuario) as usuario from tbl_usuarios where usuario='$Usuario' " ;

		$resultado_verificar_usuario = $mysqli->query($sql_verificar_usuario);
		 $row = mysqli_fetch_array($resultado_verificar_usuario); 

/*Aqui valida si el count es 1, el usuario es correcto

			if ($row['usuario']==1)
			 {

			 	/*Si es correcto aqui se obtiene los intentos fallidos que hace el usuario
				$sql_intento_usuario=" select intentos from tbl_usuarios where usuario='$Usuario' " ;
			$result = $mysqli->query($sql_intento_usuario);
			 $row_intentos = mysqli_fetch_array($result); 


			$intentos=$row_intentos['intentos'];

/*obtiene los datos del usuario si  se ha equivocado en la contraseña
	   	$sql_datos_clave_incorrecta=" select id_usuario,usuario from tbl_usuarios where usuario='$Usuario' " ;
	$resultado_datos_clave_incorrecta = $mysqli->query($sql_datos_clave_incorrecta);
	 $row_datos_clave_incorrecta = mysqli_fetch_array($resultado_datos_clave_incorrecta); 



	session_start();
	$_SESSION["id_usuario"]=$row_datos_clave_incorrecta['id_usuario'];
	$_SESSION["usuario"]=$row_datos_clave_incorrecta['usuario'];


		  $sql_admin="select count(id_usuario) as idusuario from tbl_usuarios where Usuario='admin' and id_usuario=".$_SESSION['id_usuario']." ";
		  $resultado_admin=  $mysqli->query($sql_admin);
		  $row_parametro_intento_admin = mysqli_fetch_array($resultado_admin); 


                             /*Aqui valida que los intentos de logearse del usuariario sean menos a los del parametro intentos, de lo contrario se bloquearia

							if ($intentos<$row_parametro_intento['valor'])

							 {
							 	$intentos=($intentos + 1 );
							 	/* Aqui actualiza los intentos fallidos
							 	$sql = "UPDATE tbl_usuarios SET   Intentos=$intentos WHERE id_usuario=".$_SESSION[id_usuario]."  ";
									$resultado = $mysqli->query($sql);
													/*Aqui envia los intentos fallidos de acuerdo al usuario

													
								 				 header("location: ../login.php?msj=3&intentos=$intentos" );	

								 	  

							}

							


							elseif ($row_parametro_intento_admin['idusuario']==1)
									{
									  $sql_actualizar_intentos = "UPDATE tbl_usuarios SET   Intentos=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
									  $resultado_actualizar_intentos= $mysqli->query($sql_actualizar_intentos);
									   header('location: ../login.php');
									}

							else
							{
								/*Esta condicion permite que al llegar al limite de intentos el usuario se bloquea
								$sql_bloqueo_usuario = "UPDATE tbl_usuarios SET   Intentos=0 , estado=0 WHERE id_usuario=".$_SESSION[id_usuario]." ";
								$resultado_bloqueo_usuario = $mysqli->query($sql_bloqueo_usuario);
								 header('location: ../login.php?msj=4');	
							}


								



      	}




		else
		{
				 header('location: ../login.php?msj=2');	

		}

    	
   }  

*/

?>