<?php 
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');


$preguntaname="";
if (isset($_GET['Pregunta'])) {
$preguntaname = $_GET['Pregunta'];
}

$Id_objeto=2;

if (permisos::permiso_eliminar($Id_objeto)=='0') {

  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso para eliminar",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                                               window.location = "../vistas/gestion_preguntas_vista.php";

                            </script>';
}
else
{



$sql = "call proc_eliminar_pregunta ('$preguntaname') ";
	$resultado = $mysqli->query($sql);
	if($resultado === TRUE){
                  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO' , 'LA PREGUNTA '.ctype_upper($preguntaname).'');

                        	echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos  se eliminaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                                               window.location = "../vistas/gestion_preguntas_vista.php";

                            </script>';
                        }else{
                        	echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"No se realizo el proceso, el registro a eliminar tiene datos en otras tablas",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                     $(".FormularioAjax")[0].reset();
                                </script>';
                        }


}
?>