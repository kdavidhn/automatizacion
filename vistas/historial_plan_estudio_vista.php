<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 97;


$visualizacion = permiso_ver($Id_objeto);


if ($visualizacion == 0) {
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_plan_estudio_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTIÓN DE PLAN DE ESTUDIO.');


    // if (permisos::permiso_insertar($Id_objeto) == '1') {
    //   $_SESSION['btn_guardar_registro_docentes'] = "";
    // } else {
    //   $_SESSION['btn_guardar_registro_docentes'] = "disabled";
    // }
}

ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <title></title>


</head>
<!-- shif alt f -->

<body>
    <div class="card card-default">

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

                <div class="container-fluid">

                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Historial de Plan de Estudio</h1>
                        </div>



                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="../vistas/menu_plan_estudio_vista.php">Menu plan de estudio</a></li>
                                <li class="breadcrumb-item">Historial de Plan de Estudio</a></li>

                            </ol>
                        </div>



                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section>



                <!-- Main content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <!-- pantalla  -->

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Datos Generales de Plan de Estudios</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="card-body" style="display: block;">
                                <input type="text" class="form-control" id="nombre_busca" name="anno_busca" readonly hidden>
                                <input type="text" class="form-control" id="codigo_busca" name="num_per_busca" readonly hidden>

                                <div class="row">
                                    <div class="table-responsive" style="width: auto;">
                                        <table id="tabla_historial_plan" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>

                                                    <th>Nombre</th>
                                                    <th>Codigo</th>
                                                    <th>Numero de Clases</th>
                                                    <th>Vigente</th>
                                                    <th>Acción</th>

                                                </tr>
                                            </thead>
                                        </table>

                                    </div>



                                </div>
                            </div>

                        </div>


                    </div>


                </section>
                <!-- Main content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <!-- pantalla  -->

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Plan de Estudios Vigente</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="card-body" style="display: block;">
                                <div class="row">

                                    <div class=" px-12">
                                        <form method="post" action="../Controlador/reporte_carga_gestion_controlador.php">
                                            <button disabled class="btn btn-success " id="pdf"> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;">Exportar a PDF</a> </button>
                                            <input type="text" class="form-control" id="txt_count1" name="txt_count1" readonly hidden>

                                        </form>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="table-responsive" style="width: auto;">
                                        <table id="tabla_historial_plan" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>

                                                    <th>Nombre</th>
                                                    <th>Codigo</th>
                                                    <th>Numero de Clases</th>
                                                    <th>Vigente</th>
                                                    <th>Acción</th>

                                                </tr>
                                            </thead>
                                        </table>

                                    </div>



                                </div>
                            </div>

                        </div>


                    </div>


                </section>
                <!-- Main content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <!-- pantalla  -->

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Plan de Estudios Seleccionado</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="card-body" style="display: block;">
                                <div class="row">

                                    <div class="col-md-2">
                                        <button class="btn btn-primary " id="limpiar" onclick="limpiar()"><i class="fas fa-sync-alt"></i> <a style="font-weight: bold;">limpiar tabla</a></button>

                                    </div>

                                    <div class=" px-12">
                                        <form method="post" action="../Controlador/reporte_carga_gestion_controlador.php">
                                            <button disabled class="btn btn-success " id="pdf"> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;">Exportar a PDF</a> </button>
                                            <input type="text" class="form-control" id="txt_count1" name="txt_count1" readonly hidden>

                                        </form>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="table-responsive" style="width: auto;">
                                        <table id="tabla_historial_plan" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>

                                                    <th>Nombre</th>
                                                    <th>Codigo</th>
                                                    <th>Numero de Clases</th>
                                                    <th>Vigente</th>
                                                    <th>Acción</th>

                                                </tr>
                                            </thead>
                                        </table>

                                    </div>



                                </div>
                            </div>

                        </div>


                    </div>


                </section>
            </section>

        </div>







    </div>







</body>



</html>