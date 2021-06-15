<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 93;


$area_asignatura = strtoupper($_POST['area_asignatura']);


///     EXISTE AREA
$sqlexiste = ("select area from tbl_areas where area = '$area_asignatura'");
$existe_area = mysqli_fetch_assoc($mysqli->query($sqlexiste));

/* VERIFICAR CAMPOS VACIOS*/
if ($_POST['area_asignatura'] <> '')
{
   
  /* Condicion para que no se repita el rol*/
            if ($existe_area <> '') {
                echo '<script type="text/javascript">
                swal({
                   title:"Informacion",
                   text:"Area existente",
                   type: "error",
                   showConfirmButton: false,
                   timer: 3000
                });
            </script>';
             }else{
                $sql = "call proc_insert_area('$area_asignatura', '$area_asignatura')";
        $resultado = $mysqli->query($sql);

            if ($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL PERIODO  ' . $area_asignatura . ' E');

                echo '<script type="text/javascript">
             document.getElementById("btn_guardar_periodo").enable=true;
           </script>';
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
                         document.getElementById("area_asignatura").clear();
                     </script>';
            } else {
                echo "Error: " . $sql;
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
