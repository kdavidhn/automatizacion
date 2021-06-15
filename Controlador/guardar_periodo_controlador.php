<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 63;


$num_periodo = strtoupper($_POST['num_periodo']);
$num_anno = strtoupper($_POST['num_anno']);
$fecha_inicio = strtoupper($_POST['fecha_inicio']);
$fecha_final = strtoupper($_POST['fecha_final']);
$adic_cancel = strtoupper($_POST['fecha_adic_canc']);
$tipo_periodo = strtoupper($_POST['tipo_p']);
$fecha_actual = date("Y-m-d");
//sumo 1 mes
$desbloqueo = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));


///Logica para el que se repite
$sqlexiste = ("select count(num_periodo) as num_periodo  from tbl_periodo where num_anno='$num_anno'");
$existe_periodo = ("select num_periodo, num_anno from tbl_periodo where num_anno = '$num_anno' and num_periodo = '$num_periodo'");

$verifica_fecha = ("select count(id_periodo) FROM tbl_periodo WHERE fecha_inicio >= '$fecha_inicio' AND fecha_final <= '$fecha_final';");
//Obtener la fila del query
$cuantos = mysqli_fetch_assoc($mysqli->query($sqlexiste));
$exist_periodo = mysqli_fetch_assoc($mysqli->query($existe_periodo));

// $valida_fechas =mysqli_fetch_all($mysqli->query($verifica_fecha));
// print_r($valida_fechas);
// print_r($valida_fechas);

/* Logica para que no acepte campos vacios */
if ($_POST['num_periodo']  <> '' and  $_POST['num_anno'] <> '' and  $_POST['fecha_inicio'] <> '' and  $_POST['fecha_final'] <> '' and  $_POST['fecha_adic_canc'] <> '' and  $_POST['tipo_p'] <> '') {

    // /* Condicion para que no se repita el rol*/
    if ($exist_periodo <> '') {
        echo '<script type="text/javascript">
        swal({
           title:"Informacion",
           text:"Ya existe un periodo para este año academico",
           type: "error",
           showConfirmButton: false,
           timer: 3000
        });
    </script>';
    } else {
        $sql = "call proc_insert_periodo_carga('$num_periodo','$num_anno','$fecha_inicio','$fecha_final','$_SESSION[usuario]', '$tipo_periodo','$adic_cancel', '$desbloqueo')";
        $resultado = $mysqli->query($sql);

            if ($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL PERIODO  ' . $num_periodo . ' EN EL AÑO ' . $num_anno . '');

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
                         window.location = "../vistas/mantenimiento_crear_periodo_vista.php";
                     </script>';
            } else {
                echo "Error: " . $sql;
            }

              
        
    }
} else {
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
