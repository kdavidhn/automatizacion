<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 98;


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


<body>
    <div class="content-wrapper">


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Gestión Carga Académica</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_carga_academica_vista.php">Menu Carga Académica</a></li>
                            <li class="breadcrumb-item">Gestión Carga Académica</li>
                            <li class="breadcrumb-item"><a href="../vistas/historial_carga_academica_vista.php">Ir a Historial Carga Académica</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>



        <!-- /.card-header -->
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="container-fluid" style="width: 100%;">
            <div class="box-body">

                <!-- <div class="row">
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar" style="width: 90%;">
                                <span class="input-group-text">Buscar</span>
                            </div>
                        </div>

                    </div> -->

                <div class="card-body">
                    <div class="table-responsive" style="width: 100%;">
                        <table id="tabla_plan_estudio" class="table table-bordered table-striped" style="width:99%">
                            <thead>
                                <tr>
                                    <th>Acción</th>
                                    <th>Nombre</th>
                                    <th># Clases</th>
                                    <th>Código de plan</th>
                                    <th>Tipo de plan</th>
                                    <th>Plan Vigente</th>
                                    <th>Editar Vigencia</th>
                                </tr>
                            </thead>


                        </table>
                        <br>


                    </div>
                </div>
                <div class="card-footer">
                    <h1></h1>
                </div>
            </div>

        </div>

    </div>



    <!-- modal crear carga -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_editar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Nueva Carga Académica</h5>
                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>


                <div class="modal-body">



                </div>



                <div class="modal-footer">
                    <button class="btn btn-primary" id="guardar" name="guardar">Guardar</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</body>


</html>




<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../js/plan_estudio_gestion.js"></script>

<script>
    var idioma_espanol = {
        select: {
            rows: "%d fila seleccionada"
        },
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
        "sInfo": "Registros del (_START_ al _END_) total de _TOTAL_ registros",
        "sInfoEmpty": "Registros del (0 al 0) total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "<b>No se encontrarón datos</b>",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }
</script>
<script>
    $(document).ready(function() {
        TablaPlanEstudio();

    });
</script>