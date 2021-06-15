<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

$nombre_empresa_practica=strtoupper ($_POST['txt_nombre_empresa_practica']);
$direccion_empresa_practica=strtoupper ($_POST['txt_direccion_empresa_practica']);
$departamento_practica=strtoupper ($_POST['txt_departamento_practica']);
$nombre_jefe_inmediato=strtoupper ($_POST['txt_nombre_jefe_inmediato']);
$titulo_jefe_inmediato=strtoupper ($_POST['txt_titulo_jefe_inmediato']);
$cargo_jefe_inmediato=strtoupper ($_POST['txt_cargo_jefe_inmediato']);
$telefono_jefe_inmediato=strtoupper ($_POST['txt_telefono_jefe_inmediato']);
$correo_jefe_inmediato=strtoupper ($_POST['txt_correo_jefe_inmediato']);


$sqlexiste_empresa=("select count(nombre_empresa) as nombre  from tbl_empresas_practica where nombre_empresa='$nombre_empresa_practica' ");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste_empresa));


$Id_objeto=17; 

/* Logica para que no acepte campos vacios */
if (isset($nombre_empresa_practica) and isset($direccion_empresa_practica) and isset($departamento_practica) and isset($nombre_jefe_inmediato) and isset($titulo_jefe_inmediato)  and isset($cargo_jefe_inmediato)  and isset($telefono_jefe_inmediato)  and isset($correo_jefe_inmediato) )

{

if ($existe['nombre']==1)
 {
  /*header('location: ../contenidos/crearPregunta-view.php?msj=2');*/
  echo '<script type="text/javascript">
  swal({
   title:"",
   text:"Lo sentimos la empresa <?php $nombre_empresa_practica ?> ya existe",
   type: "error",
   showConfirmButton: false,
   timer: 3000
   });
   </script>';  
 }

 else
 {

  
  $sql = "call proc_insertar_empresa_practica('$nombre_empresa_practica', '$direccion_empresa_practica' , '$departamento_practica' , '$nombre_jefe_inmediato', '$titulo_jefe_inmediato', '$cargo_jefe_inmediato', '$correo_jefe_inmediato', '$telefono_jefe_inmediato',$_SESSION[id_persona] );";
  $resultado = $mysqli->query($sql);



                         if($resultado === TRUE /*and $resultado_estudiante===TRUE*/)
                         {
                          bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA EMPRESA '.$nombre_empresa_practica.'');

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