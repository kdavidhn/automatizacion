<?php
 session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

$nombre_egresado=strtoupper ($_POST['txt_nombre_egresado']);
$Cuenta=strtoupper ($_POST['txt_cuenta']);
$fecha_graduacion=strtoupper ($_POST['txt_fecha_graduacion']);
$tel_fijo_personal=strtoupper ($_POST['txt_telefono_fijo']);
$celular_personal=strtoupper ($_POST['txt_telefono_celular']);
$correo_personal=strtoupper ($_POST['txt_correo_personal']);
$posee_maestria=strtoupper ($_POST['cb_maestria']);
$posee_certificado=strtoupper ($_POST['cb_certificado']);
$labora=strtoupper ($_POST['cb_labora']);
$nombre_empresa=strtoupper ($_POST['txt_nombre_empresa']);
$departamento=strtoupper ($_POST['txt_departamento']);
$direccion_empresa=strtoupper ($_POST['txt_direccion_empresa']);
$telefono_empresa=strtoupper ($_POST['txt_telefono_empresa']);
$correo_profesional=strtoupper ($_POST['txt_correo_profesional']);
	

$certificadov=strtoupper($_POST['txtcertificado']);

  $maestriav=strtoupper($_POST['txtmaestria']);


 
 $sqlexiste_egresado=("select count(nombre) as nombre  from tbl_egresados where nombre='$nombre_egresado' or cuenta='$Cuenta' ");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste_egresado));


    $Id_objeto=22; 
    if ($tel_fijo_personal=="") {

$tel_fijo_personal="N/A";
    }
     if ($celular_personal=="") {
      
$celular_personal="N/A";
    }
     if ($labora<>"SI")
      {
      $nombre_empresa="N/A";
      $direccion_empresa="N/A";
      $telefono_empresa="N/A";
      $departamento="N/A";
      $correo_profesional="";
     }
        if ($posee_maestria<>"SI")
      {
      $maestriav="N/A";
     }
        if ($posee_certificado<>"SI")
      {
     $certificadov="N/A";
     }

/* Logica para que no acepte campos vacios */
if (isset($nombre_egresado) && isset($Cuenta)  )

{

   /* Condicion para que no se repita el egresado*/
    if ($existe['nombre']==1)
    {
 	/*header('location: ../contenidos/crearPregunta-view.php?msj=2');*/
 	 	echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el egresado <?php $nombre_egresado ?> ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';  
    }
    else
    {
    
    $Id_objeto=22; 
	   if ($labora=="NO")
      {
      $nombre_empresa="N/A";
      $direccion_empresa="N/A";
      $telefono_empresa="N/A";
      $departamento="N/A";
      $correo_profesional="";
     }
        if ($posee_maestria=="NO")
      {
      $maestria="N/A";
     }
        if ($posee_certificado=="NO")
      {
     $certificado="N/A";
     }
if (($posee_maestria=="SI" and empty($maestriav)) or ($posee_certificado=="SI" and empty($certificadov)) or ($labora=="SI" and (empty($nombre_empresa) or  empty($departamento)))) {
     echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos tiene datos por rellenar.",
                                   type: "info",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>'; 
      
                                    }
          else
          {


    			/* Query para que haga el insert*/
				$sql = "call  proc_insertar_egresado('$nombre_egresado', '$Cuenta' ,'$correo_personal','$celular_personal','$tel_fijo_personal','$fecha_graduacion','$posee_maestria','$maestriav','$posee_certificado','$certificadov','$labora','$nombre_empresa','$direccion_empresa','$telefono_empresa','$departamento','$correo_profesional')";
				$resultado = $mysqli->query($sql);


	        if($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'AL EGRESADO '.$nombre_egresado.'');

    		/*header('location: ../contenidos/crearPregunta-view.php?msj=1');*/
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
                                   text:"Lo sentimos los datos no fueron guardados correctamente",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>'; 
			}
    }

    }


} 

else
{
/*echo '<script> alert("Lo sentimos tiene campos por rellenar ")</script>';*/
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


?>