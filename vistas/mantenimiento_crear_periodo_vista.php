<?php
session_start();
ob_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 63;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento/Crear Periodo');



$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    //header('location:  ../vistas/menu_roles_vista.php');

    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_roles_vista.php";

                            </script>';
} else {






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_periodo'] = "";
    } else {
        $_SESSION['btn_guardar_periodo'] = "disabled";
    }
    /*

 if (isset($_REQUEST['msj']))
 {
      $msj=$_REQUEST['msj'];
        if ($msj==1)
            {
            echo '<script> alert("Lo sentimos el rol a ingresar ya existe favor intenta con uno nuevo")</script>';
            }
   
               if ($msj==2)
                  {
                  echo '<script> alert("Rol agregado correctamente")</script>';
                  }
 }

*/
}

$sql2 = $mysqli->prepare("SELECT fecha_desbloqueo from tbl_periodo ORDER BY id_periodo DESC LIMIT 1;");
$sql2->execute();
$resultado2 = $sql2->get_result();
$desbloqueo = $resultado2->fetch_array(MYSQLI_ASSOC);

$sql3 = $mysqli->prepare("SELECT valor from tbl_parametros WHERE Parametro = 'num_periodo_maximo' LIMIT 1;");
$sql3->execute();
$resultado3 = $sql3->get_result();
$max_periodo = $resultado3->fetch_array(MYSQLI_ASSOC);


ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <title></title>



</head>

<body>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Período</h1>
                    </div>
                    <input class="form-control" hidden type="text" id="max_periodo" name="max_periodo" value="<?php echo $max_periodo['valor'] ?>">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento_carga.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_periodo_vista.php"> Mantenimiento Período</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/guardar_periodo_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Nuevo Período</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <input hidden class="form-control" type="text" id="fecha_desbloqueo" name="fecha_desbloqueo" value="<?php echo $desbloqueo['fecha_desbloqueo'] ?>">

                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Período Académico</label>
                                        <input class="form-control" type="text" minlength="1" maxlength="1" min="1" max="3" size="3" id="num_periodo" name="num_periodo" style="text-transform: uppercase" onkeypress="return Numeros(event)" onblur="comprobar()">
                                    </div>

                                    <div class="form-group">
                                        <label>Año Académico</label>
                                        <input readonly class="form-control" type="text" id="num_anno" name="num_anno" style="text-transform: uppercase" onkeypress="return Numeros(event)"  value="<?php echo date("Y"); ?>">

                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Inicio del Período</label>
                                        <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio">
                                    </div>
                                    <div class="form-group">
                                        <label>Finalización del Período</label>
                                        <input class="form-control" type="date" id="fecha_final" name="fecha_final">
                                    </div>

                                    <div class="form-group">
                                        <label>Adiciones y Cancelaciones</label>
                                        <input class="form-control" type="date" id="fecha_adic_canc" name="fecha_adic_canc">
                                    </div>


                                    <input class="form-control" type="text" id="tipo_p" hidden name="tipo_p" style="text-transform: uppercase">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tipo de Período:</label>
                                            <td><select class="form-control" onchange="mostrar_tipo_periodo($('#tipo_periodo').val());" id="tipo_periodo" class="" name="">
                                                    <option value="">Seleccionar</option>
                                                </select></td>

                                        </div>
                                    </div>


                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_periodo" name="btn_guardar_periodo" <?php echo $_SESSION['btn_guardar_periodo']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                                    </p>

                                </div>
                            </div>
                        </div>



                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>



                    <div class="RespuestaAjax"></div>
                </form>

            </div>
        </section>

    </div>





</body>

</html>

<script src="../js/ca2.js"></script>
<script type="text/javascript" src="../js/fechas_anteriores.js"></script>