<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

$Id_objeto=145 ; 

  
$nombre_tipo_falta=strtoupper ($_POST['txt_tipo_falta']);
$descripcion_tipo_falta=strtoupper ($_POST['txt_descripcion_tipo_falta']);


 $estado= '';
///Logica para el que se repite
 $sqlexiste=("select count(nombre_falta) as nombre_falta  from tbl_voae_tipos_faltas where nombre_falta='$nombre_tipo_falta'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_tipo_falta']  <>' ' and  $_POST['txt_descripcion_tipo_falta']<> '')
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['nombre_falta']==1)
    {
   /*   require"../contenidos/crearRol-view.php";
 	header('location: ../contenidos/crearRol-view.php?msj=1'); */
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el ROL ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    }
    else
    {

    			/* Query para que haga el insert*/
				$sql = "call proc_insertar_tipo_falta ('$nombre_tipo_falta','$descripcion_tipo_falta')";
				$resultado = $mysqli->query($sql);
 

	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL TIPO DE FALTA '.$nombre_tipo_falta.'');

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


?>