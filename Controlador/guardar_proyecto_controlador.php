<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

$codigo_proyecto=strtoupper ($_POST['txt_cod_proyecto']);
$nombre_proyecto=strtoupper ($_POST['txt_nombre_proyecto']);
$tipo_proyecto=strtoupper ($_POST['txt_tipo_proyecto']);
$fecha_inicio_ejecucion=strtoupper ($_POST['txt_fecha_inicio']);
$fecha_final_ejecucion=strtoupper ($_POST['txt_fecha_final']);
$fecha_intermedia_evaluacion=strtoupper ($_POST['txt_fecha_intermedia']);
$fecha_final_evaluacion=strtoupper ($_POST['txt_fecha_final_evaluacion']);
$beneficiarios_directos=strtoupper ($_POST['txt_beneficiario_directo']);
$beneficiarios_indirectos=strtoupper ($_POST['txt_beneficiario_indirecto']);
$total_beneficiarios=strtoupper ($_POST['txt_beneficiarios']);
$modalidad_proyecto=strtoupper ($_POST['combo_modalidad']);
$tipo_vinculacion_proyecto=strtoupper ($_POST['combo_tipo']);
$costo_proyecto=strtoupper ($_POST['txt_costo_proyecto']);
$nombre_empresa=strtoupper ($_POST['txt_nombre_empresa']);
$aporte_empresa=strtoupper ($_POST['combo_aporte_empresa']);
$formalizacion_empresa=strtoupper ($_POST['combo_formalizacion']);
$contacto_institucional=strtoupper ($_POST['txt_contacto_institucional']);
$cargo_contacto=strtoupper ($_POST['txt_cargo']);
$telefono_contacto=strtoupper ($_POST['txt_telefono_contacto']);
$correo_contacto=strtoupper ($_POST['txt_correo_contacto']);

/*
$nombre_estudiante=strtoupper ($_POST['txt_nombre_estudiante1']);
$numero_estudiante=strtoupper ($_POST['txt_num_estudiante1']);
$direccion_estudiante=strtoupper ($_POST['txt_direccion_estudiante1']);
$cargo_estudiante=strtoupper ($_POST['txt_cargo_estudiante1']);
$telefono_estudiante=strtoupper ($_POST['txt_telefono_estudiante1']);
$correo_estudiante=strtoupper ($_POST['txt_correo_estudiante1']);*/
$region_proyecto=strtoupper ($_POST['txt_region']);
$departamento_pais=strtoupper ($_POST['txt_departamento_pais']);
$municipio=strtoupper ($_POST['txt_municipio']);
$aldea_caserio=strtoupper ($_POST['txt_aldea_caserio']);
$barrio_colonia=strtoupper ($_POST['txt_barrio_colonia']);
$entidad_beneficiaria=strtoupper ($_POST['txt_entidad_beneficiaria']);
$objetivos_proyecto=strtoupper ($_POST['txt_objetivos']);
$objetivos_inmediatos=strtoupper ($_POST['txt_objetivos_inmediatos']);
$resultados_proyecto=strtoupper ($_POST['txt_resultados_esperados']);
$actividades_proyecto=strtoupper ($_POST['txt_actividades_principales']);
$departamento_facultad=strtoupper ($_POST['txt_departamento']);



$sqlexiste_proyecto=("select count(nombre) as nombre  from tbl_proyectos where nombre='$nombre_proyecto' ");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste_proyecto));


$Id_objeto=24; 

/* Logica para que no acepte campos vacios */
if (isset($nombre_proyecto) and isset($nombre_empresa) and isset($codigo_proyecto) and isset($tipo_proyecto))

{

if ($existe['nombre']==1)
 {
  /*header('location: ../contenidos/crearPregunta-view.php?msj=2');*/
  echo '<script type="text/javascript">
  swal({
   title:"",
   text:"Lo sentimos el proyecto <?php $nombre_proyecto ?> ya existe",
   type: "error",
   showConfirmButton: false,
   timer: 3000
   });
   </script>';  
 }

 else
 {

  
  $sql = "call   proc_insertar_proyecto( '$tipo_vinculacion_proyecto', '$modalidad_proyecto' , '$nombre_proyecto' , '$codigo_proyecto', '$tipo_proyecto', '1', '$beneficiarios_directos', '$beneficiarios_indirectos', '$nombre_empresa', '$contacto_institucional' , '$cargo_contacto' , '$telefono_contacto', '$correo_contacto' , '$total_beneficiarios', '$fecha_inicio_ejecucion', '$fecha_final_ejecucion', '$fecha_intermedia_evaluacion', '$fecha_final_evaluacion', '$costo_proyecto','$_SESSION[id_usuario]' , '4', '$formalizacion_empresa', '$aporte_empresa', '$region_proyecto', '$departamento_pais', '$municipio ', '$aldea_caserio', '$barrio_colonia', '$entidad_beneficiaria', '$objetivos_proyecto', '$objetivos_inmediatos', '$resultados_proyecto', '$actividades_proyecto', '$departamento_facultad')";
  $resultado = $mysqli->query($sql);


           if(isset($_POST["txt_nombre_estudiante1"]))
                {


$sqlidproyecto=("select Id_proyecto as id from tbl_proyectos where nombre='$nombre_proyecto' and nombre_empresa='$nombre_empresa' and id_usuario=$_SESSION[id_usuario] ");
 //Obtener la fila del query
$Idproyecto = mysqli_fetch_assoc($mysqli->query($sqlidproyecto)); 


                 for($count = 0; $count < count($_POST["txt_nombre_estudiante1"]); $count++)
                 {  
                  $query ="INSERT INTO `tbl_estudiantes_proyecto`( `Id_proyecto`,`nombre_estudiante`, `cargo_estudiante`, `telefono_estudiante`, `correo_estudiante`, `numero_empleado`, `direccion_estudiante`) VALUES (:proyecto_id,:nombre, :cargo, :telefono, :correo, :numero, :direccion)";  

                  $statement = $connect->prepare($query);
                  $statement->execute(
                   array(
                    ':proyecto_id'   => $Idproyecto['id'],
                 
                    ':nombre'  => $_POST["txt_nombre_estudiante1"][$count], 
                    ':telefono'  => $_POST["txt_telefono_estudiante1"][$count], 
                    ':cargo' => $_POST["txt_cargo_estudiante1"][$count], 
                    ':correo'  => $_POST["txt_correo_estudiante1"][$count],
                    ':numero' => $_POST["txt_num_estudiante1"][$count], 
                    ':direccion'  => $_POST["txt_direccion_estudiante1"][$count]
                  )
                 );
                }
                $result = $statement->fetchAll();

              }


                         if($resultado === TRUE /*and $resultado_estudiante===TRUE*/)
                         {
                          bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL PROYECTO '.$nombre_proyecto.'');

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
                           text:"Lo sentimos los datos no fueron guardados correctamente",
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