<?php

 session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');



  $No_constancia=strtoupper ($_POST['txt_constancia_charla']);
  $promedio_global_=strtoupper ($_POST['txt_promedio']);
  $clases_aprobadas_=($_POST['txt_clases_aprobadas']);
  $porcentaje=(($clases_aprobadas_) *100)/52;
  $porcentaje = number_format($porcentaje, 2, "d", "@");
  $jornada_=strtoupper ($_POST['cb_jornada']);
//  $clases_aprobadas_=44;





/* Logica para que no acepte campos vacios */
	
	if (!empty($No_constancia) and $jornada_<>"0")
{


 $sqlexiste=("select count(no_constancia) as no_constancia  from tbl_charla_practica where 	no_constancia='$No_constancia'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
 
  /* Condicion para que no se repita el rol*/
    if ($existe['no_constancia']==1)
    {
 	/*header('location: ../contenidos/crearPregunta-view.php?msj=2');*/
 	 	echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos su constancia acaba de ser registrada , favor intente de nuevo",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3000
                    });
                                                    $(".FormularioAjax")[0].reset();

                </script>';  
    }
    else
    {
     $Id_objeto=13 ; 

	    $usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];

    			/* Query para que haga el insert*/
				$sql = "call proc_insertar_inscripcion_charla('$id_persona', '$No_constancia' ,'$promedio_global_','$clases_aprobadas_','$porcentaje','$jornada_');";

//call proc_insertar_inscripcion_charla('6', '$No_constancia' ,'$promedio_global_','$clases_aprobadas_','$porcentaje','Prueba')
  
				$resultado = $mysqli->query($sql);


	        if($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA INSCRIPCION DE CHARLA AL USUARIO '.$_SESSION["usuario"].'');


         $sqlcontador=("select SUBSTRING('$No_constancia',7) valor ");
 //Obtener la fila del query
$contador = mysqli_fetch_assoc($mysqli->query($sqlcontador));

if ($contador['valor']<10) {
   $sqlcontador=("select SUBSTRING('$No_constancia',9) valor ");
 //Obtener la fila del query
$contador = mysqli_fetch_assoc($mysqli->query($sqlcontador));
	$contadorresult= $contador['valor'];

		$sql = "update tbl_contador_constancia set contador='$contadorresult' where descripcion='$jornada_';";
				$resultado = $mysqli->query($sql);
	
}
elseif ($contador['valor']>= 10 and $contador['valor']<100) {
   $sqlcontador=("select SUBSTRING('$No_constancia',8) valor ");
 //Obtener la fila del query
$contador = mysqli_fetch_assoc($mysqli->query($sqlcontador));
  $contadorresult= $contador['valor'];

  
    $sql = "update tbl_contador_constancia set contador='$contadorresult' where descripcion='$jornada_';";
        $resultado = $mysqli->query($sql);
  
}
else
{  
  $contadorresult= $contador['valor'];

  
    $sql = "update tbl_contador_constancia set contador='$contadorresult' where descripcion='$jornada_';";
        $resultado = $mysqli->query($sql);
}

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
                                       text:"Lo sentimos no se pudo guardar su incripcion, intente de nuevo.",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
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