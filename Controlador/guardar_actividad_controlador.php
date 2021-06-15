<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=75 ;


$actividad=strtoupper ($_POST['txt_actividad1']);
$descripcion=strtoupper ($_POST['txt_descripcion1']);
$proyecto=strtoupper ($_POST['txt_proyecto1']);
$horas=strtoupper ($_POST['txt_horas1']);
$comision=strtoupper ($_POST['comision1']);


 
///Logica para el que se repite
 $sqlexiste=("select count(actividad) as actividad  from tbl_actividades where actividad='$actividad'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_actividad1']  <>' ' and  $_POST['txt_descripcion1']<> '' and  $_POST['txt_proyecto1']<> '' and  $_POST['txt_horas1']<> '' and  $_POST['comision1']<> '')
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['actividad']== 1)
    {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos la actividad ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    
    }
    else
    {
       
    			/* Query para que haga el insert*/
				$sql = "call proc_insertar_actividades('$actividad','$descripcion','$proyecto', '$horas', '$comision','$_SESSION[usuario]')";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA ACTIVIDAD '. $actividad.'');

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
