<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=62 ;


$estado_civil=strtoupper ($_POST['txt_estado_civil']);
	$descripcion=strtoupper ($_POST['txt_descripcion']);

 
///Logica para el que se repite
 $sqlexiste=("select count(estado_civil) as estado_civil  from tbl_estadocivil where estado_civil='$estado_civil'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_estado_civil']  <>' ' and  $_POST['txt_descripcion']<> '')
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['estado_civil']== 1)
    {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el estado civil ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    
    }
    else
    {
       
    			/* Query para que haga el insert*/
				$sql = "call proc_insertar_estado_civil('$estado_civil','$descripcion','$_SESSION[usuario]')";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL ESTADO CIVIL '. $estado_civil.'');

         /*   require"../contenidos/crearRol-view.php"; 
    		header('location: ../contenidos/crearRol-view.php?msj=2');*/
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
    		echo "Error: " . $sql ;
			}

    }


} 

else
{
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
