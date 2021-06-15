<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=76 ;


$departamento=strtoupper ($_POST['txt_departamento']);
	

 
///Logica para el que se repite
 $sqlexiste=("select count(departamento) as departamento  from tbl_departamentos where departamento='$departamento'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_departamento'])
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['departamento']== 1)
    {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el departamento ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    
    }
    else
    {
       
    			/* Query para que haga el insert*/
				$sql = "call proc_insertar_departamento('$departamento','$_SESSION[usuario]')";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL DEPARTAMENTO '. $departamento.'');

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
