<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 96;








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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A CREAR UN PLAN DE ESTUDIO.');


    // if (permisos::permiso_insertar($Id_objeto) == '1') {
    //   $_SESSION['btn_guardar_registro_docentes'] = "";
    // } else {
    //   $_SESSION['btn_guardar_registro_docentes'] = "disabled";
    // }
}

$nombre = $_SESSION['usuario'];
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
                        <h1>Crear Plan de Estudio</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_plan_estudio_vista.php">Menu plan de estudio</a></li>
                            <li class="breadcrumb-item">Crear plan de estudio</a></li>

                        </ol>
                    </div>



                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section>

            <input type="text" id="id_sesion" name="id_sesion" value="<?php echo $nombre; ?>" hidden readonly>


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- pantalla  -->

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Nuevo Plan de Estudio </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden">

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label>Nombre de Plan</label>

                                        <input class="form-control" type="text" id="txt_nombre" name="txt_nombre" maxlength="25" value="" required>


                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label>Número de clases del plan</label>
                                        <input class="form-control" type="text" id="txt_num_clases" name="txt_num_clases" maxlength="2" value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden">

                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label>Código de Plan</label>

                                        <input class="form-control" type="text" id="txt_codigo_plan" name="txt_codigo_plan" maxlength="25" value="" required>


                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label>Seleccione Tipo de plan:</label>
                                        <td><select class="form-control" style="width: 100%;" name="cbm_tipo_plan" id="cbm_tipo_plan">
                                            </select></td>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden">

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Plan Vigente</label>
                                    <div style="padding: 3px 5px; border: #c3c3c3  1px solid;  border-radius:5px; width:auto; height:35px;">

                                        <div class="form-group">

                                            <input type="text" name="sino" id="sino" readonly hidden>
                                            <span class="checkbox-inline">
                                                <label class="checkbox-inline"><input id="SI" type="checkbox" name="check[]" class="ch" value="SI"> SI</label>
                                                <label class="checkbox-inline"><input id="NO" type="checkbox" name="check[]" class="ch" value="NO"> NO</label>


                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label>Fecha de Creación</label>

                                        <input class="form-control" type="date" id="fechacreacion" name="fechacreacion" value="" required>


                                    </div>
                                </div>

                            </div>
                            <br>
                            <br>
                            <p class="text-center" style="margin-top: 10px;">
                                <button class="btn btn-primary" id="guardar" class="guardar" name="guardar" onclick="crear_plan_estudio();">Guardar</button>
                            </p>
                        </div>

                    </div>

                </div>


            </section>
        </section>
    </div>






    <script type="text/javascript" src="../js/plan_estudio.js"></script>
    <!-- <script type="text/javascript" src="../js/registro_docente.js"></script> -->

    <!-- para seleccionar limite de checkbox -->
    <script>
        var limite = 1;
        $(".ch").change(function() {
            if ($("input:checked").length > limite) {
                alert("Solo puede seleccionar una opción ");
                document.getElementById('sino').value = '';
                document.getElementById("SI").checked = false;
                document.getElementById("NO").checked = false;
                this.checked = false;
            }
        });
    </script>
</body>



</html>