<?php

 session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

// 


	$cuenta=$_SESSION['Cuenta'];
	if (isset($_POST['asignatura'])) {
			$array_id= $_POST['asignatura'];
	}
	
	if (empty($cuenta) or empty($array_id)) {
                                      $array_id="[1,1]";
    

echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos tiene campos por rellenar",
                                   type: "info",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';


	} 


else
{

		



 $sqlexiste=("select count(id_persona) as persona  from tbl_asignaturas_aprobadas where id_persona=(select id_persona from tbl_personas_extendidas where valor='$cuenta')");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

 if ($existe['persona']>=1)
    {
  /*header('location: ../contenidos/crearPregunta-view.php?msj=2');*/
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos para modificar estudiante, dirijase a gestion de clases aprobadas.",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';  
    }
    else
    {
    	
     

    $Id_objeto=15 ; 
     
 $sqlid=("select p.id_persona as persona  from tbl_personas p, tbl_personas_extendidas px where px.valor='$cuenta' AND px.id_atributo=12 and px.id_persona=p.id_persona");
 //Obtener la fila del query
$iduser = mysqli_fetch_assoc($mysqli->query($sqlid));
$idproc=$iduser['persona'];

    foreach ($array_id as $idasignatura) {

    $sql = "call proc_insertar_asignaturas_aprobadas($idasignatura,$idproc)";
        $resultado = $mysqli->query($sql);
    $sqlproc = "select asignatura as tema from tbl_asignaturas where Id_asignatura =$idasignatura";
          $resultadoproc = mysqli_fetch_assoc($mysqli->query($sqlproc));
         bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA  ASIGNATURA '.$resultadoproc['tema'].'');



                  };





          if($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LAS ASIGNATURAS AL ESTUDIANTE CON CUENTA '.$cuenta.'');

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
                                   text:"Lo sentimos no se pudieron guardar los datos",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';
                                  }

    }




}


?>
