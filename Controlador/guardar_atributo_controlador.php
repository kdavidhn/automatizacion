<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=81 ;


$atributo=strtoupper ($_POST['txt_atributo1']);
	$requerido=strtoupper ($_POST['txt_requerido1']);
  $persona=strtoupper ($_POST['txt_persona1']);


 
///Logica para el que se repite
 $sqlexiste=("select count(atributo) as atributo  from tbl_atributos where atributo='$atributo'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_atributo1']  <>' ' and  $_POST['txt_requerido1']<> ''and  $_POST['txt_persona1']<> '')
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['atributo']== 1)
    {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el atributo ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    
    }
    else
    {
       
    			/* Query para que haga el insert*/
				$sql = "call proc_insertar_atributo('$atributo','$requerido','$persona','$_SESSION[usuario]')";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL ATRIBUTO '. $atributo.'');

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
