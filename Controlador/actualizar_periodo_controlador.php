<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 63;


$num_periodo = strtoupper($_POST['num_periodo']);
$num_anno = strtoupper($_POST['num_anno']);
$fecha_inicio = strtoupper($_POST['fecha_inicio']);
$fecha_final = strtoupper($_POST['fecha_final']);
$final_modificar = strtoupper($_POST['final_modificar']);
$adic_cancel = strtoupper($_POST['fecha_adic_canc']);
$id_tipo_periodo = strtoupper($_POST['tipo_p']);
$id_periodo = $_GET['id_periodo'];
// $tipo_periodo= strtoupper ($_POST['tipo_p']);
$fecha_actual = date("Y-m-d");
//sumo 1 mes
$desbloqueo = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));


///Logica para el que se repite
$sqlexiste = ("select count(fecha_inicio) as fecha_inicio  from tbl_periodo where fecha_inicio='$fecha_inicio' ");


//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


/* Logica para que no acepte campos vacios */
if ($_POST['num_periodo']  <> ' ' and  $_POST['num_anno'] <> '' and  $_POST['fecha_inicio'] <> '' and  $_POST['fecha_final'] <> '') {
    if ($fecha_actual > $final_modificar) {
        header("location:../vistas/mantenimiento_periodo_vista.php?msj=4");

    } else {

        /* Query para que haga el insert*/
        $sql = "call proc_actualizar_periodo_carga('$fecha_inicio','$fecha_final','$_SESSION[usuario]', '$id_tipo_periodo','$adic_cancel', '$desbloqueo', '$num_periodo', '$num_anno', '$id_periodo')";
        $resultado = $mysqli->query($sql);

        $valor = "select num_periodo, num_anno,fecha_inicio, fecha_final from tbl_periodo WHERE id_periodo= '$id_periodo'";
        $result_valor = $mysqli->query($valor);
        $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);


        if ($resultado === TRUE) {
            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL PERIODO  ' . $num_periodo . ' EN EL AÑO ' . $num_anno . '');

            header("location:../vistas/mantenimiento_periodo_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_periodo_vista.php?msj=3");
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
