<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=82 ;


$codigo=strtoupper ($_POST['txt_codigo1']);
$descripcion=strtoupper ($_POST['txt_descripcion1']);
$capacidad=strtoupper ($_POST['txt_capacidad1']);
$edificio=strtoupper ($_POST['edificio']);
$tipoaula=strtoupper ($_POST['aula']);


 
///Logica para el que se repite
 $sqlexiste=("select count(codigo) as codigo  from tbl_aula where codigo='$codigo' and id_edificio='$edificio'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_codigo1']  <>' ' and  $_POST['txt_descripcion1']<> '' and  $_POST['txt_capacidad1']<> '' and  $_POST['edificio']<> '' and  $_POST['aula']<> '')
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['codigo']== 1 )
    {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el numero de aula ya existe en este edificio",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    
    }
    else
    {
       
    			/* Query para que haga el insert*/
				$sql = "call proc_insertar_aula('$codigo','$descripcion','$capacidad', '$edificio', '$tipoaula','$_SESSION[usuario]')";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL CODIGO DE AULA '. $codigo.'');

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
