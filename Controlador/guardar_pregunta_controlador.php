<?php
 session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');




	$Pregunta=strtoupper ($_POST['txt_Pregunta']);
	

 $var=0;

 $estado= '';
///Logica para el que se repite
 $sqlexiste=("select count(pregunta) as pregunta  from tbl_preguntas where pregunta='$Pregunta'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_Pregunta']  <>' ')
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['pregunta']==1)
    {
 	/*header('location: ../contenidos/crearPregunta-view.php?msj=2');*/
 	 	echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos la pregunta <?php $Pregunta ?> ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';  
    }
    else
    {
        /* Condicion para el checkbox si esta activo o no*/
		if (isset($_POST['txt_checkboxactivo']) && $_POST['txt_checkboxactivo'] == 'true') 
	    {
	    $var=1;
	    }
	    else
	    {
	    $var=0;
	    }


    $Id_objeto=1 ; 
	   


    			/* Query para que haga el insert*/
				$sql = "call  proc_insertar_pregunta ('$Pregunta', '$var' ,'$_SESSION[usuario]')";
				$resultado = $mysqli->query($sql);


	        if($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA PREGUNTA '.$Pregunta.'');

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
                                   text:"Lo sentimos, los datos no se almacenaron correctamente",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>'; 
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