<?php

ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/Conexionvoae.php');
require_once('../clases/conexion_mantenimientos.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 236;
$hoy = date("y-m-d");



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
    window.location = "../vistas/pagina_principal_vista.php";

    </script>';
} else {
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A Solicitud de Actividades CVE');
}
if (permisos::permiso_insertar($Id_objeto) == 0) {
  $_SESSION["btnagregar"] = "hidden";
} else {
  $_SESSION["btnagregar"] = "";
}

ob_end_flush();
?>

<body oncopy="return false" onpaste="return false">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

            <h1>Actividades CVE Reporte</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_actividades_cve_vista.php">Menú Actividades</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->

    <div class="card card-default">
      <!-- Main content -->
      <section class="content">
        <div class="card-header">
          <div class="col-md-12">
            <div class="box">



              <div id="formularioregistros">
                <form name="formulario" id="formulario" target="_black" method="POST" action="../Controlador/generar_reporte_pdf_controlador.php">
                  <div class="box-header with-border">

                  </div>
                  <!-- Card 1 Datos Generales de la Actividad -->
                  <div class="card card-default">
                    <div class="card-header bg-gradient-dark">
                      <h3 class="card-title">Reporte</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /. card-header-->
                    <div class="card-body">
                      <div class="row">
                        <!-- N de Solicitud -->
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Fecha Incial:</label>
                            <input type="date" class="form-control" placeholder="FECHA" name="fch_inicial_actividad" id="fch_inicial_actividad" required="" required max=<?php $hoy = date("Y-m-d");
                                                                                                                                                                          echo $hoy; ?> />
                          </div>
                        </div>
                        <!-- Nombre de la Actividad -->
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Fecha Final:</label>
                            <input type="date" class="form-control" placeholder="FECHA" name="fch_final_actividad" id="fch_final}_actividad" required="" />
                            <!--required max=<php $hoy = date("Y-m-d"); echo $hoy; ?> -->
                          </div>
                        </div>

                        <!-- Periodo Academico -->
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Filtrar por Periodo Academico:</label>
                            <select name="periodo" id="periodo" class="form-control select2" name="periodo" id="nombre" maxlength="50" placeholder="Seleccione el Periodo" required>
                              <option value="PRIMER PERIODO">--PRIMER PERIODO</option>
                              <option value="SEGUNDO PERIODO">--SEGUNDO PERIODO</option>
                              <option value="TERCER PERIODO">--TERCER PERIODO</option>
                              <option value="TODOS">TODOS</option>
                            </select>
                          </div>
                        </div>

                        <!-- Ambito -->
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Filtrar por Ámbito:</label>
                            <select class="form-control select2" name="id_ambito" id="id_ambito" style="width: 100%;">
                              <option value="0" disabled="disabled"></option>
                              <?php
                              $query = $mysqli->query("SELECT * FROM tbl_voae_ambitos where condicion = 1");
                              while ($resultado = mysqli_fetch_array($query)) {
                                echo '<option value="' . $resultado['id_ambito'] . '"> --' . $resultado['nombre_ambito'] . '</option>';
                              }
                              ?>
                              <option value="TODOS">TODOS</option>
                            </select>
                          </div>
                        </div>
                        <!-- Estado-->
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Filtrar por Estado:</label>
                            <select class="form-control select2" name="id_estado" id="id_estado" style="width: 100%;">
                              <option value="0" disabled="disabled"></option>
                              <?php
                              $query = $mysqli->query("SELECT * FROM tbl_voae_estados where condicion = 1");
                              while ($resultado = mysqli_fetch_array($query)) {
                                echo '<option value="' . $resultado['id_estado'] . '"> --' . $resultado['nombre_estado'] . '</option>';
                              }
                              ?>
                              <option value="TODOS">TODOS</option>
                            </select>
                          </div>
                        </div>
                        <!-- Formato-->
                        <!--div class="col-sm-6">
                    <div class="form-group">
                    <label>Formato del Reporte:</label>
                    <div>
                        <input type="radio" id="pdf" name="drone" value="huey"
                              checked>
                        <label for="pdf">PDF</label>
                      </div>

                      <div>
                        <input type="radio" id="excel" name="drone" value="dewey">
                        <label for="excel">EXCEL</label>
                      </div>
                  </div>
                </div-->
                      </div>
                    </div>
                  </div>

                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-primary pull-right" type="submit" "><i class="fa fa-solid fa-check"></i> Generar Reporte</button>
                  <button class="btn btn-danger pull-right" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Salir</button>
                </div>
          </form>

              </div>
            </div>
          </div>


         
        </div>
        <!--Fin centro -->
    </div><!-- /.box -->
  </div><!-- /.col -->
  </div><!-- /.row -->
  </section><!-- /.content -->

  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  </div>

  <script type="text/javascript" src="../js/reporte_general.js"></script>
  <script src="../plugins/select2/js/select2.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" language="javascript">
    $(document).ready(function() {

      $('.select2').select2({
        placeholder: 'Seleccione una opcion',
        theme: 'bootstrap4',
        tags: true,
      });

    });
  </script>
  <script>
    function soloLetras(e) {
      var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toUpperCase(),
        letras = " ÀÈÌÒÙABCDEFGHIJKLMNÑOPQRSTUVWXYZ-",

        especiales = [8, 37, 39, 46],
        tecla_especial = false;

      for (var i in especiales) {
        if (key == especiales[i]) {
          tecla_especial = true;
          break;
        }
      }

      if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
      }
    }
  </script>
  <script>
    document.getElementById("formulario").addEventListener("keydown", teclear);

    var flag = false;
    var teclaAnterior = "";

    function teclear(event) {
      teclaAnterior = teclaAnterior + " " + event.keyCode;
      var arregloTA = teclaAnterior.split(" ");
      if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
        event.preventDefault();
      }
    }
  </script>
</body>

</html>