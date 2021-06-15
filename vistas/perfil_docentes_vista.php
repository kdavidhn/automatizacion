<?php
session_start();
ob_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');



$Id_objeto = 54;
$visualizacion = permiso_ver($Id_objeto);
$usuario = $_SESSION['id_persona'];


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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Gestion de Roles');


    // if (permisos::permiso_modificar($Id_objeto) == '1') {
    //     $_SESSION['btn_modificar_roles'] = "";
    // } else {
    //     $_SESSION['btn_modificar_roles'] = "disabled";
    // }
}

ob_end_flush();

//      SELECT A LAS TABLAS PARA ENCUESTA
$sql = "SELECT * FROM tbl_asignaturas";
$consulta = $mysqli->query($sql);
$row = $consulta->fetch_all(MYSQLI_ASSOC);

$sql1 = "SELECT * FROM tbl_areas";
$consulta1 = $mysqli->query($sql1);
$row1 = $consulta1->fetch_all(MYSQLI_ASSOC);

$sql4 = "SELECT * FROM tbl_areas";
$consulta4 = $mysqli->query($sql4);
$row4 = $consulta4->fetch_all(MYSQLI_ASSOC);

$sql9 = "SELECT * FROM tbl_asignaturas";
$consulta9 = $mysqli->query($sql9);
$row9 = $consulta9->fetch_all(MYSQLI_ASSOC);

//      --------------------------------

//      TRAER LAS PREGUNTAS RESPONDIDAS X DOCENTE

//PREGUNTA 1
$sql2 = "SELECT id_pref_area_doce,
(SELECT a.area FROM tbl_areas AS a WHERE a.id_area = tbl_pref_area_docen.id_area LIMIT 8) area_docente
FROM tbl_pref_area_docen
WHERE id_persona = '$usuario'";
$consulta2 = $mysqli->query($sql2);
$row2 = $consulta2->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 2
$sql5 = "SELECT id_expe_academi_docente AS id_expe_a_doc,
(SELECT a.area FROM tbl_areas AS a WHERE a.id_area = tbl_expe_academica_docente.id_area LIMIT 8) area_docente
FROM tbl_expe_academica_docente
WHERE id_persona = '$usuario'";
$consulta5 = $mysqli->query($sql5);
$row5 = $consulta5->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 3
$sql7 = "SELECT id_pref_asig_docen,
(SELECT a.asignatura FROM tbl_asignaturas AS a WHERE a.Id_asignatura = tbl_pref_asig_docen.Id_asignatura LIMIT 8) asig_docente
FROM tbl_pref_asig_docen
WHERE id_persona = '$usuario';";
$consulta7 = $mysqli->query($sql7);
$row7 = $consulta7->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 4
$sql10 = "SELECT id_desea_asig_doce,
(SELECT a.asignatura FROM tbl_asignaturas AS a WHERE a.Id_asignatura = tbl_desea_asig_doce.Id_asignatura LIMIT 8) desea_asig
FROM tbl_desea_asig_doce
WHERE id_persona = '$usuario';";
$consulta10 = $mysqli->query($sql10);
$row10 = $consulta10->fetch_all(MYSQLI_ASSOC);

//      --------------------------------

//      TRAER LAS PREGUNTAS QUE NO HA CONTESTADO EL DOCENTE

//PREGUNTA 1
$sql3 = "SELECT area.area AS areas_vacias, area.id_area AS id_area
FROM tbl_areas AS area
WHERE NOT EXISTS (SELECT id_area, id_persona FROM tbl_pref_area_docen AS pad WHERE pad.id_area = area.id_area AND pad.id_persona = '$usuario');";
$consulta3 = $mysqli->query($sql3);
$row3 = $consulta3->fetch_all(MYSQLI_ASSOC);


//PREGUNTA 2
//      --------------------------------
$sql6 = "SELECT area.area AS expe_areas_vacias, area.id_area AS id_area
FROM tbl_areas AS area
WHERE NOT EXISTS (SELECT id_area, id_persona FROM tbl_expe_academica_docente AS eac WHERE eac.id_area = area.id_area AND eac.id_persona = '$usuario');";
$consulta6 = $mysqli->query($sql6);
$row6 = $consulta6->fetch_all(MYSQLI_ASSOC);


//PREGUNTA 3
//      --------------------------------
$sql8 = "SELECT area.asignatura AS asig_vacias, area.Id_asignatura AS id_asignatura
FROM tbl_asignaturas AS area
WHERE NOT EXISTS (SELECT Id_asignatura, id_persona FROM tbl_pref_asig_docen AS pad WHERE pad.Id_asignatura = area.Id_asignatura 
AND pad.id_persona = '$usuario');";
$consulta8 = $mysqli->query($sql8);
$row8 = $consulta8->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 4
//      --------------------------------
$sql11 = "SELECT area.asignatura AS asig_vacias, area.Id_asignatura AS id_asignatura
FROM tbl_asignaturas AS area
WHERE NOT EXISTS (SELECT Id_asignatura, id_persona FROM tbl_desea_asig_doce AS pad WHERE pad.Id_asignatura = area.Id_asignatura 
AND pad.id_persona = '$usuario');";
$consulta11 = $mysqli->query($sql11);
$row11 = $consulta11->fetch_all(MYSQLI_ASSOC);


$fechaActual = date('d-m-Y h:i:s');
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Latest compiled and minified CSS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0mm;
        }

        ;
    </style>

    <style>
        #fecha_actual {
            font-family: Tahoma, Verdana, Arial;
            font-size: 24px;
            color: #707070;
            background-color: #FFFFFF;
            border-width: 0;
        }

        ;
    </style>
    <title></title>
</head>

<body>

    <center hidden id="titulo_1">
        <h3>Universidad Nacional Autónoma De Honduras</h2>
            <h3>Facultad De Ciencias Económicas, Administrativas Y Contables</h2>
                <h3> Departamento De Informática </h2>
    </center>

    <img style="margin-left: 100px;" hidden src="../Imagenes_Perfil_Docente/imagen23053148.png" alt="" class="brand-image img-circle elevation-3" height="185" width="170" id="foto_carrera">

    <input hidden class="form-control" type="text" id="fecha_actual" name="fecha_actual" style="margin-left: 90px;" value="<?php echo $fechaActual ?>">

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Perfil Docente</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Perfil Docente</li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="" method="post" role="form" enctype="multipart/form-data" data-form="perfil" autocomplete="off" class="FormularioAjax">


                    <div class="card card-default">
                        <div class="card-header" id="datos_docente">
                            <h3 class="card-title">Datos Personales</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" id="boton_colapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">



                                <div class="col-sm-2" id="parrafo_numEmpleado">
                                    <label for="">Nº Empleado:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user icon"></i></span>
                                            <input disabled name="" type="text" class="form-control" id="empleado">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Nombre:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_nombre"><i class="fas fa-file-signature"></i></span>
                                            <input disabled name="" type="text" onkeyup="Mayuscula('Nombre'); MismaLetra('Nombre'); DobleEspacio(this, event);" onkeypress="return sololetras(event)" class="form-control" id="Nombre" required>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="">Apellido(s):</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_apellido"><i class="fas fa-file-signature"></i></span>
                                            <input disabled name="" type="text" onkeyup="Mayuscula('txt_apellido');MismaLetra('txt_apellido'); DobleEspacio(this, event);" onkeypress="return sololetras(event);" class="form-control" id="txt_apellido" required>

                                        </div>
                                    </div>

                                </div>


                                <div class=" col-sm-1">

                                    <img style="margin-left: 0px;" src="" alt="" class="brand-image img-circle elevation-3" id="foto" height="155" width="140">

                                </div>


                                <div class="col-sm-3" id="parrafo_genero">
                                    <label for="email">Género:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_genero"><i class="fas fa-toggle-on"></i></span>

                                            <input value="" type="text" disabled name="ver_genero" id="ver_genero" class="form-control">

                                            <select hidden class="form-control" onchange="mostrar_genero($('#genero').val());" id="genero" name="">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="mayoria_edad" id="mayoria_edad" hidden readonly onload="mayoria_edad()">
                                <div class="col-sm-3" id="parrafo_identidad">
                                    <label for="">Nº Identidad:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_identidad"><i class="fas fa-id-card"></i></span>
                                            <input disabled name="" type="text" data-inputmask="'mask': '9999-9999-99999'" data-mask class="form-control" id="identidad" required onkeyup="ValidarIdentidad($('#identidad').val());" onblur="ExisteIdentidad();">

                                        </div>
                                    </div>
                                    <p hidden id="TextoIdentidad" style="color:red;">La Identidad Ya existe</p>
                                    <p hidden id="Textomayor" style="color:red;">¡Es menor de edad! </p>

                                </div>

                                <div class="col-sm-2" id="parrafo_estadoC">
                                    <label for="">Estado Civil:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_estado"><i class="fas fa-user icon"></i></span>

                                            <input value="" type="text" disabled name="ver_estado" id="ver_estado" class="form-control">

                                            <select hidden class="form-control" onchange="mostrar_estado_civil($('#estado_civil').val());" id="estado_civil" name="">
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="parrafo_sued">
                                    <label for="">Sued:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_estado"><i class="fas fa-user icon"></i></span>

                                            <input class="form-control" readonly value="" type="text" name="sued" id="sued">

                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-2">
                                    <p class="text-center" style="margin-top: 20px;" id="parrafo_boton_editar">

                                    <form action="" method="POST" role="form" enctype="multipart/form-data" id="frmimagen">
                                        <div class="form-group">
                                            <!-- FOTOGRAFIA  -->
                                            <input hidden type="file" accept=".png, .jpg, .JPG, .jpeg" maxlength="8388608" name="imagen" id="imagen" style="text-transform: uppercase">
                                        </div>
                                        <button style="color:white;font-weight: bold;" type="button" id="btn_mostrar" class="btn btn-warning" onclick="MostrarBoton();"></i>Cambiar foto de Perfil</button>

                                        <button style="color:white;font-weight: bold;" hidden type="submit" id="btn_foto" class="btn btn-dark btn_foto"></i>Guardar
                                            foto de Perfil</button>
                                        <input class="form-control" hidden value="<?php echo $usuario ?>" type="text" name="id_persona" id="id_persona">

                                    </form>
                                    </p>

                                </div>


                                <div class="col-sm-2" id="parrafor_jornada">
                                    <label for="">Jornada:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_jornada"><i class="fas fa-user icon"></i></span>
                                            <input disabled name="" type="text" class="form-control" id="jornada">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="parrafo_nacionalidad">
                                    <label for="">Nacionalidad:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_nacionalidad"><i class="fas fa-flag"></i></span>
                                            <input disabled name="" type="text" onkeyup="Mayuscula('nacionalidad');" class="form-control" id="nacionalidad">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="parrafo_categoria">
                                    <label for="">Categoría:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_categoria"><i class="fas fa-user icon"></i></span>
                                            <input disabled name="" type="text" class="form-control" id="categoria">

                                        </div>
                                    </div>
                                </div>
                                <input class="form-control" readonly hidden id="age" name="age" maxlength="25" value="" required style="text-transform: uppercase">

                                <div class="col-sm-3" id="parrafo_nacimiento">
                                    <label for="">Fecha Nacimiento:</label>

                                    <div class="form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="icono_nacimiento"><i class="far fa-calendar-alt"></i></span>
                                            <input disabled="true" value="" type="date" name="Fecha" id="fecha" class="form-control" onblur="valida_mayoria()" onkeydown="return false">
                                        </div>

                                    </div>
                                    <p hidden id="Textofecha" style="color:red;">¡El docente debe ser mayor de edad! </p>

                                </div>






                                <div class="col-sm-12">
                                    <div class="btn-group">


                                        &nbsp;&nbsp;

                                        <div class="input-group-prepend" id="parrafo_curriculum">

                                            <form action="" method="POST" role="form" enctype="multipart/form-data" id="frmimagen">
                                                <button style="color:white;font-weight: bold;" type="button" id="btn_mostrar_curriculum" class="btn btn-info" onclick="MostrarBotonCurriculum();"></i>Actualizar Curriculum</button>

                                                <input hidden class="btn btn-info" type="file" accept=".doc, .docx, .pdf" maxlength="60" id="c_vitae" name="c_vitae" value="" style="text-transform: uppercase">
                                                &nbsp;&nbsp;
                                                <button hidden type="submit" id="btn_curriculum" class="btn btn-dark btn_curriculum"></i>Guardar Curriculum</button>
                                                <input class="form-control" hidden value="<?php echo $usuario ?>" type="text" name="id_persona" id="id_persona">
                                            </form>

                                        </div>
                                        <div class="" id="curriculum_parrafo">
                                            &nbsp;&nbsp;
                                            <button class="btn btn-info " id="descargar_curriculum" name=""> <a href="" target="_blank" id="curriculum" style="color:white;font-weight: bold;">Descargar Curriculum</a></button>
                                        </div>
                                        &nbsp;&nbsp;
                                        <button class="btn btn-info" style="color:white;font-weight: bold;" id="btn_editar_curri" name="btn_editar_curri"><i class="fas fa-print"></i>Imprimir Perfil</button>


                                        &nbsp;&nbsp;

                                        <!-- <p class="text-center" style="margin-top: 20px;"></p> -->

                                        <button type="button" style="color:white;font-weight: bold;" class="btn btn-info" onclick="habilitar_editar();" id="editar_info" name="editar_info"><i class="fas fa-user-edit"></i>Editar Información</button>

                                        <button hidden type="button" style="color:white;font-weight: bold;" class="btn btn-info" onclick="desabilitar();" id="btn_editar" name="btn_editar"><i class="fas fa-user-edit"></i>Editar Información</button>



                                        &nbsp;&nbsp;
                                        <!-- <p class="text-center" style="margin-top: 20px;"> -->
                                        <button hidden type="button" class="btn btn-info" id="btn_guardar_edicion" name="btn_guardar_edicion" onclick="EditarPerfil($('#Nombre').val(),$('#txt_apellido').val(),$('#identidad').val(),$('#estado_civil_text').val()); ver_estado_civil();"><i class="fas fa-user-edit"></i>Guardar Información</button>
                                        <!-- </p> -->
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Contactos</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!--CONTACTOS-->

                            <!--  <div class="card " style="width:420px;border-color:gray;">
                                <div class="card-body">
                                    <h4 class="card-title">Contactos</h4>
                                    <div class="form-group card-text">
                                        <!TABLA CONTACTOS -->
                            <!--  <button type="button" name="add" id="add" class="btn btn-primary card-title" data-toggle="modal" data-target="#ModalTelefonos">Agregar
                                            Telefono</button>

                                        <table class="table table-bordered table-striped m-0">
                                            <thead>
                                                <tr>

                                                    <th>Telefono</th>
                                                    <th>Eliminar</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tbData2"></tbody>
                                        </table>
                                    </div>
                                </div> -->
                            <!--  </div> -->
                            <!---card-->


                            <!-- Modal para telefono -->
                            <!--   <div class="modal fade" tabindex="-1" role="dialog" id="ModalTelefonos">
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
                                                    <label for="">Tipo de Contacto</label>
                                                    <select class="form-control" onchange="" id="tipo_contacto" name="">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div class="form-group">
                                                    <label for="" id="lbl_tipo">Contacto</label>
                                                    <input hidden type="text" name="tel" id="txt_contacto_tel" class="form-control name_list" data-inputmask="'mask': ' 9999-9999'" data-mask required>

                                                    <input required type="text" name="tel" id="txt_contacto" class="form-control name_list" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" onclick="">Agregar</button>
                                            <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!--CERRANDO MODAL TELEFONO-->

                            <div class="d-flex justify-content-around flex-row bd-highlight row">
                                <div class="card " style="width:420px;border-color:gray;" id="card_telefono">
                                    <div class="card-body">
                                        <h4 class="card-title">Contactos</h4>
                                        <div class="form-group card-text">
                                            <!-- TABLA CONTACTOS -->
                                            <button type="button" name="add1" id="add1" class="btn btn-info card-title" data-toggle="modal" data-target="#ModalTel">Agregar Teléfono</button>

                                            <table class="table table-bordered table-striped m-0">
                                                <thead>
                                                    <tr>

                                                        <th>Teléfono</th>
                                                        <th id="eliminar_telefono_tabla">Eliminar</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="tbData2"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card " style="width:420px;border-color:gray;">
                                    <div class="card-body">
                                        <h4 class="card-title">Correo</h4>
                                        <div class="form-group card-text">
                                            <!-- TABLA CORREO -->
                                            <button type="button" name="add_correo1" id="add_correo1" class="btn btn-info card-title" data-toggle="modal" data-target="#ModalCorreo">Agregar Correo</button>

                                            <table class="table table-bordered table-striped m-0">
                                                <thead>
                                                    <tr>

                                                        <th>Correo</th>
                                                        <th id="eliminar_correo_tabla">Eliminar</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="tbDataCorreo1"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!---card-->


                                <!--Modal para telefono-->
                                <div class="modal fade" tabindex="-1" role="dialog" id="ModalTel">
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
                                                        <label for="">Teléfono</label>
                                                        <input required type="text" name="tel1" id="tel1" class="form-control name_list" data-inputmask="'mask': ' 9999-9999'" data-mask required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" onclick="addTel()">Agregar</button>
                                                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--CERRANDO MODAL TELEFONO-->

                                <!--Modal para correo-->
                                <div class="modal fade" tabindex="-1" role="dialog" id="ModalCorreo">
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
                                                        <label for="">Correo</label>
                                                        <input required type="email" name="correo" id="correo" class="form-control name_list">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" onclick="addCorreo()">Agregar</button>
                                                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Formación Académica y Comisiones</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="d-flex justify-content-around flex-row bd-highlight row">

                                <div class="card " style="width:500px;border-color:gray;" id="parrafo_formacion">
                                    <!--comisiones-->

                                    <div class="card-body">
                                        <h4 class="card-title ">Formación Académica</h4><br>


                                        <!-- <ul class="card-text" id="ulFormacion">

                                    </ul> -->
                                        <div class="card-body">
                                            <button type="button" class="btn btn-info card-title" data-toggle="modal" data-target="#myModal">Agregar Formación Académica <i class="fa fa-user-plus"></i></button>
                                            <h4 class="card-title"></h4>
                                            <div class="card-text">
                                                <table class="table table-bordered table-striped m-0">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Grado</th>
                                                            <th>Especialidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbl_especialidad"></tbody>
                                                </table>
                                            </div>
                                        </div>



                                        <!-- The Modal -->

                                    </div>
                                </div><!-- Comisiones-->



                                <div class="card " style="width:500px;border-color:gray;" id="parrafo_comisiones">
                                    <!--comisiones-->
                                    <div class="card-body">
                                        <h4 class="card-title">Comisiones y Actividades</h4>
                                        <div class="card-body">

                                            <table class="table table-bordered table-striped m-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Comisión</th>
                                                        <th>Actividad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl_comisiones"></tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div><!-- Comisiones-->


                            </div>
                        </div>

                    </div>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Preferencia Docente en Base a Experiencias Profesionales</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="d-flex justify-content-around flex-row bd-highlight row">
                                <div class="card " style="width:420px;border-color:gray;" id="parrafo_encuesta">
                                    <div class="card-body">
                                        <h4 class="card-title">Encuesta Docente</h4>
                                        <div class="card-text">
                                            <button type="button" id="btn_modal1" class="btn btn-info " onclick="pregunta1();">Pregunta 1</button>
                                            <button type="button" id="btn_modal2" class="btn btn-info " onclick="pregunta2();">Pregunta 2</button>
                                            <button type="button" id="btn_modal3" class="btn btn-info " onclick="pregunta3();">Pregunta 3</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

        </section>




    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Nueva Formación Académica</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <br>
                    <label for="">GRADO ACADÉMICO:</label>

                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                            &nbsp; <select class="form-control" onchange="mostrar($('#id_select').val());" id="id_select" name="">

                            </select>


                        </div>
                    </div>

                    <label for="">ESPECIALIDAD:</label>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-code"></i></span>
                            &nbsp;<select hidden id="select_especialidad" class="form-control" name="">
                                <input id="especialidad" class="form-control" type="text" onkeyup="Mayuscula('especialidad');">
                            </select>


                        </div>
                    </div>

                    <br>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" id="guardarFormacion" class="btn btn-primary">Guardar Formación Académica <i class="fa fa-user-plus"></i></button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>











    <!-- /.card-body -->
    <div class="card-footer">

    </div>



    <div class="RespuestaAjax"></div>
    </section>

    </div>
    </section>


    </div>

    <script type="text/javascript" src="../js/perfil_docentes.js"></script>
    <script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>
    <script>
        /*
function mascara(){
  let inputs = document.getElementsByTagName("input");
  let cont=0;

  for (let index = 0; index < inputs.length; index++) {
      if($(inputs[index]).attr('type')=="tel"){
      cont++;
      valor = $(inputs[index]).attr('id');
      

        $("#"+valor+"").keypress(function(e) {

        if ((e.which!=127) ) {

        var longitud= inputs[index].value;
        console.log("length "+longitud.length);
        if(longitud.length==4 ){

        inputs[index].value=inputs[index].value+'-';
        } 
        }


        });//function
      }//if
  }//for
}//function

*/
    </script>

    <!-- modal encuesta -->
    <div class="modal fade" id="modalencuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalencuesta">Pregunta 1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!--  <div class="card " style="width:420px;border-color:gray;"> -->

                    <div style="text-align:left">


                        <h5 style="font-weight: bold; font-size: 15px"> 1. ¿En que áreas de la carrera imparte clases?</h5>
                        <div class="form-check">
                            <?php

                            if ($row1 != $row2) {
                                // echo '<input type="checkbox"  name="" value="' . $id["id_pref_area_doce"] . '">' . $id["area_docente"];

                                foreach ($row2 as $id) {
                                    echo '<br>';
                                    echo '<input class="pregunta1" type="checkbox" checked = "checked" name="areas[]" value="' . $id["id_pref_area_doce"] . '">' . $id["area_docente"];
                                }

                                foreach ($row3 as $id) {

                                    echo '<br>';
                                    echo '<input class="pregunta1" type="checkbox" name="areas[]" value="' . $id["id_area"] . '">' . $id["areas_vacias"];
                                }
                            } else {
                                foreach ($row1 as $id) {
                                    echo '<br>';
                                    echo '<input  class="pregunta1" type="checkbox" name="areas[]" value="' . $id["id_area"] . '">' . $id["area"];
                                }
                            };

                            ?>
                        </div>


                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" value="pregunta1" class="btn btn-primary" onclick="enviarpregunta1()">Guardar</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalencuesta2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalencuesta">Pregunta 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div style="text-align:left">
                        <h5 style="font-weight: bold; font-size: 15px">2. ¿Seleccione una o dos áreas de la informática en la que tiene mayor experiencia y se siente más cómodo en la docencia?</h5>
                        <div class="form-check">
                            <?php


                            if ($row4 != $row5) {
                                // echo '<input type="checkbox"  name="" value="' . $id["id_pref_area_doce"] . '">' . $id["area_docente"];

                                foreach ($row5 as $id) {
                                    echo '<br>';
                                    echo '<input class="pregunta2" type="checkbox" checked = "checked" name="areas2[]" value="' . $id["area_docente"] . '">' . $id["area_docente"];
                                }

                                foreach ($row6 as $id) {

                                    echo '<br>';
                                    echo '<input class="pregunta2" type="checkbox" name="areas2[]" value="' . $id["id_area"] . '">' . $id["expe_areas_vacias"];
                                }
                            } else {

                                foreach ($row4 as $area) {
                                    echo '<br>';
                                    echo '<input  class="pregunta2" type="checkbox" name="areas2[]" value="' . $area["id_area"] . '">' . $area["area"];
                                }
                            };

                            ?>

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="enviarpregunta2();">Guardar</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalencuesta3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalencuesta">Pregunta 3</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!--  <div class="card " style="width:420px;border-color:gray;"> -->

                    <div style="text-align:left">

                        <h5 style="font-weight: bold; font-size: 15px">3. Basado en la respuesta de la pregunta anterior ¿Selecciones la(s) Asignatura(s)
                            en la que tiene mayor experiencia?</h5>
                        <div class="form-check">
                            <?php


                            if ($row != $row7) {

                                foreach ($row7 as $id) {
                                    echo '<br>';
                                    echo '<input class="pregunta3" type="checkbox" checked = "checked" name="asignatura3[]" value="' . $id["id_pref_asig_docen"] . '">' . $id["asig_docente"];
                                }

                                foreach ($row8 as $id) {

                                    echo '<br>';
                                    echo '<input class="pregunta3" type="checkbox" name="asignatura3[]" value="' . $id["id_asignatura"] . '">' . $id["asig_vacias"];
                                }
                            } else {

                                foreach ($row as $id) {
                                    echo '<br>';
                                    echo '<input  required class="pregunta3" type="checkbox" name="asignatura3[]" value="' . $id["Id_asignatura"] . '">' . $id["asignatura"];
                                }
                            };

                            ?>
                        </div>
                        <br><br>

                        <h5 style="font-weight: bold; font-size: 15px"> 4. ¿Selecciones la(s) Asignatura(s) en la que desea de impartir? </h5>
                        <div class="form-check">

                            <?php

                            if ($row9 != $row10) {

                                foreach ($row10 as $id) {
                                    echo '<br>';
                                    echo '<input class="pregunta4" type="checkbox" checked = "checked" name="asignatura4[]" value="' . $id["id_desea_asig_doce"] . '">' . $id["desea_asig"];
                                }

                                foreach ($row11 as $id) {

                                    echo '<br>';
                                    echo '<input class="pregunta4" type="checkbox" name="asignatura4[]" value="' . $id["id_asignatura"] . '">' . $id["asig_vacias"];
                                }
                            } else {
                                foreach ($row9 as $id) {
                                    echo '<br>';
                                    echo '<input required class="pregunta4" type="checkbox" name="asignatura4[]" value="' . $id["Id_asignatura"] . '">' . $id["asignatura"];
                                }
                            };

                            ?>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="enviarpregunta3();enviarpregunta4();">Guardar</button>
                    </div>
                </div>
            </div>
        </div>


</body>

</html>
<!-- para seleccionar limite de checkbox -->
<!-- <script>
    var limite = 2;
    $(".pregunta2").change(function() {
        if ($("input:checked").length > limite) {
            alert("solo puedes seleccionar un maximo de dos");
            this.checked = false;
        }
    });
</script> -->