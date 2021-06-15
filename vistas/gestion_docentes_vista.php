<?php

ob_start();

session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');






$Id_objeto = 51;
$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    // header('location:  ../vistas/menu_roles_vista.php');
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


    // $respuesta1=$instancia_modelo->listar_select1();
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A gestion docentes');




    // if (permisos::permiso_modificar($Id_objeto) == '1') {
    //     $_SESSION['btn_modificar_CA'] = "";
    // } else {
    //     $_SESSION['btn_modificar_CA'] = "disabled";
    // }
}
$sql2 = $mysqli->prepare("SELECT tbl_periodo.id_periodo AS id_periodo, tbl_periodo.num_periodo AS num_periodo, tbl_periodo.num_anno AS num_anno, tbl_periodo.fecha_adic_canc AS fecha_adic_canc, tbl_periodo.fecha_desbloqueo AS fecha_desbloqueo,
(SELECT tp.descripcion FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS tipo_periodo,
			(SELECT tp.horas_validas FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS horas_validas
FROM tbl_periodo
ORDER BY id_periodo DESC LIMIT 1;");
$sql2->execute();
$resultado2 = $sql2->get_result();
$row2 = $resultado2->fetch_array(MYSQLI_ASSOC);
ob_end_flush();



//$nomdocentes = "SELECT id_persona, nombres FROM tbl_personas WHERE id_tipo_persona=1";
//$resultado1 = $mysqli->query($nomdocentes);

?>


<!DOCTYPE html>

<head>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../plugins/datatables/datatables.min.css" />
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <!--  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"> -->
    <!--  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script> -->





    <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

</head>


<body>

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Gestión Docente</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_docentes_vista.php">Menu Docentes</a></li>

                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->





        <div class="card card-default">
            <div class="card-header">
                <!--COMBOBOX-->

                <div class="px-1">

                    <a href="../vistas/registro_docentes_vista.php" class="btn btn-warning"><i class="fas fa-arrow"></i>Registrar Nuevo Docente</a>

                </div>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-footer">
                <input hidden class="form-control" type="text" id="txt_periodo" name="txt_periodo" value="<?php echo $row2['num_periodo'] ?>" readonly>
                <input hidden class="form-control" type="text" id="txt_anno" name="txt_anno" value="<?php echo $row2['num_anno'] ?>" readonly>




                <div class="card-body">
                    <div class="table-responsive" style="width: 100%;">

                        <table id="tabladocentes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID PERSONA</th>
                                    <th>N EMPLEADO</th>
                                    <th>NOMBRE</th>
                                    <th>IDENTIDAD</th>
                                    <th>JORNADA</th>
                                    <th>H_INICIAL</th>
                                    <th>H_FINAL</th>
                                    <th>CATEGORIA</th>
                                    <th>SUED</th>
                                    <th>COMISIÓNES</th>
                                    <th>CORREOS</th>
                                    <th>TELÉFONOS</th>
                                    <!--  <th>FOTO</th>
                                    <th>CURRICULUM</th> -->
                                    <th>ESTADO</th>
                                    <th>MODIFICAR ESTADO</th>
                                    <th>MODIFICAR INFORMACIÓN</th>



                                </tr>
                            </thead>


                        </table>
                        <br>




                    </div>


                </div>

                <!-- modal modificar carga -->
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_editar" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Datos</h5>
                                <button onclick="limpiar();actualizar_tabla();" class="close" data-dismiss="modal">
                                    &times;
                                </button>

                            </div>


                            <div class="modal-body">

                                <div class="row">
                                    <input type="hidden">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input hidden type="text" id="txt_id_persona" readonly>

                                            <label> Docente: </label>
                                            <input class="form-control" type="text" id="txt_nombre_docente" name="txt_nombre_docente" readonly>


                                        </div>
                                    </div>

                                    <!--  <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Nacionalidad</label>
                                            <select class="form-control" name="nacionalidad_edita" id="nacionalidad_edita"></select>

                                        </div>
                                    </div> -->

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Identificación</label>
                                            <input class="form-control" name="identidad_edita" data-inputmask="'mask': '9999-9999-99999'" data-mask id="identidad_edita" onkeyup="ValidarIdentidad($('#identidad_edita').val());">

                                        </div>
                                    </div>

                                    <!-- <div class="col-md-1">
                                            <div class="form-group">
                                                <input class="form-control" hidden type="text" id="txt_hidden" name="txt_hidden" value="" readonly>

                                            </div>
                                        </div> -->


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>N° Empleado</label>
                                            <input class="form-control" name="nempleado_edita" id="nempleado_edita" onkeypress="return solonumeros(event)" onkeyUp="pierdeFoco(this)" maxlength="6" required>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jornada</label>
                                            <select class="form-control" name="jornada_edita" id="jornada_edita"></select>
                                            <input hidden type="text" name="jornada_id" id="jornada_id" readonly>
                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hora Entrada</label>
                                            <select class="form-control" name="hr_inicio_edita" id="hr_inicio_edita"></select>

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hora Salida</label>
                                            <select class="form-control" name="hr_final_edita" id="hr_final_edita" onblur="valida_horario_edita(); valida_jornada_hora();"></select>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Categoria</label>
                                            <select class="form-control" name="categoria_edita" id="categoria_edita"></select>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <label>SUED</label>
                                            <select class="form-control" name="sued" id="sued">
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>



                                        </div>
                                    </div>





                                    <div class="col-sm-3">

                                        <button type="submit" class="btn btn-primary btn" data-toggle="modal" data-target="#ModalTask2" id="agregarotra" name="agregarotra" onclick="persona()">AGREGAR COMISIONES</button>

                                    </div>



                                    <div class="card " style="width:600px;border-color:gray;">
                                        <!--comisiones-->
                                        <div class="card-body">
                                            <h4 class="card-title">Comisiones y Actividades</h4>
                                            <div class="card-text">
                                                <table class="table table-bordered table-striped m-0">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Comisión</th>
                                                            <th>Actividad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbl_comisiones"></tbody>
                                                </table>
                                            </div>
                                        </div>


                                    </div>




                                    <!--  <div class="col-md-6">


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="hidden">
                                                <label> Comisión: </label>
                                                <td> <select class="form-control-lg select2" style="width: 100%;" id="cbm_comision_edita " name="cbm_comision_edita"> </td>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden">
                                                <label> Actividad: </label>
                                                <td> <select class="form-control-lg select2" style="width: 100%;" id="cbm_actividad_edita" name="cbm_actividad_edita"> </td>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden">

                                            </div>
                                        </div>


                                    </div> -->



                                </div>
                                <div class="modal-footer">
                                    <!--  <button class="btn btn-primary" id="guardar" name="guardar" onclick="modificar_carga_academica();">Guardar</button> -->

                                    <button type="button" class="btn btn-info" onclick=" modificar_gestion();" id="editar_info" name="editar_info">Guardar Cambios</button>


                                    <button class="btn btn-secondary" data-dismiss="modal" onclick="limpiar(); actualizar_tabla();" id="salir">Cancelar</button>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>

                <div class="modal fade" tabindex="-1" role="dialog" id="ModalTask2">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Datos</h5>
                                <button class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="container">
                                    <div class="form-group">
                                        <input hidden type="text" id="txt_id_persona1" readonly>


                                        <label>Comisiones</label>
                                        <select class="form-control" name="comisiones" id="comisiones">

                                        </select>

                                        <label>Actividades</label>
                                        <select class="form-control" name="actividades" id="actividades">

                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" onclick="saveAll3();addTask3(); ">Agregar</button>
                                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>



        <!-- <a class="btn btn-success " onclick=" ventana1()">Generar PDF</a> -->
    </div>
    </div>










</body>
<html>
<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
<script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>

<script language="javascript">
    function ventana1() {
        window.open("../Controlador/gestion_docente_controlador2.php", "GESTION");
    }
</script>

<script>
    $(document).ready(function() {
        TablaDocente();


    });
</script>

<script type="text/javascript" src="../js/funciones_gestion_docente.js"></script>
<script>
    var idioma_espanol = {
        select: {
            rows: "%d fila seleccionada"
        },
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "No se encuentra el periodo o año",
        "sInfo": "Registros del (_START_ al _END_) total de _TOTAL_ registros",
        "sInfoEmpty": "Registros del (0 al 0) total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "<b>No se encontraron datos</b>",
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
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>