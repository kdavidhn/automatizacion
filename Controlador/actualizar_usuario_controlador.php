<?php
	
 session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

	$Usuario=strtoupper ($_POST['txt_usuario']);

	$Id_rol=$_POST['cb_comborol'];
	$Id_usuario= $_GET['Id_usuarioG']; 
	$var=0;

	/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
 $sqlexiste=("select count(usuario) as usuario  from tbl_usuarios where Usuario='$Usuario' and  Id_usuario <> '$Id_usuario' ");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


if ($existe['usuario']==1)
{
	 echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el usuario ya existe",
                       type: "success",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>'; 
       
}
else
{


	if (isset($_POST['checkboxactivomodificar']) && $_POST['checkboxactivomodificar'] == 'true') 
	{
	$var=1;
	}
	else
	{
	$var=0;
	}	

$sql_datos_estatus=" select  estado from tbl_usuarios where usuario='$Usuario' " ;
$result_estatus = $mysqli->query($sql_datos_estatus);
 $row_estatus = mysqli_fetch_array($result_estatus); 

		if ($row_estatus['estado']==2)
		 {
	

	        $Id_objeto=4 ; 
    /* Hace 
    el query para que actualize*/



    $sql="call proc_actualizar_usuario('$Usuario','$Id_rol','$_SESSION[usuario]','$Id_usuario','$var');";
	$resultado = $mysqli->query($sql);

	if ($resultado==true) {
			        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'EL '.$Nombre.',DEL USUARIO '.$Usuario.'');

header("location:../vistas/gestion_usuarios_vista.php?msj=2"); 

}
else
{
           header("location:../vistas/gestion_usuarios_vista.php?msj=3"); 

}


	
		}
		else
		{
		
	        $Id_objeto=4 ; 

			/* Hace el query para que actualize*/
   $sql = "call proc_actualizar_usuario('$Usuario','$Id_rol','$_SESSION[usuario]','$Id_usuario','$var');";
	$resultado = $mysqli->query($sql);

	                     
if ($resultado==true) {
				        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'EL '.$Nombre.',DEL USUARIO '.$Usuario.'');

   header("location:../vistas/gestion_usuarios_vista.php?msj=2"); 

}
else
{
           header("location:../vistas/gestion_usuarios_vista.php?msj=3"); 

}


		}


    
}


?>