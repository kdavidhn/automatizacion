<?php

ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');



$Id_objeto = 53;
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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Reporte Carga Academica Docente');



  // if (permisos::permiso_modificar($Id_objeto) == '1') {
  //   $_SESSION['btn_modificar_horas'] = "";
  // } else {
  //   $_SESSION['btn_modificar_horas'] = "disabled";
  // }
  $nombre = $_SESSION['usuario'];
  $id = $_SESSION['id_usuario'];
  $id_persona = $_SESSION['id_persona'];

  $sql = "SELECT tp.nombres, tp.apellidos FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= $id";
  $resultado3 = $mysqli->query($sql);




?>
  <script>
    $(function() {
      $('#modal_modificar_horas').modal('toggle')

    })
  </script>;

  <?php
  ?>

<?php
  //$this->Cell(100, 10, utf8_decode($reg->asignatura), 1, 0, 'C');
  //echo utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS")
}



ob_end_flush();



//$nomdocentes = "SELECT id_persona, nombres FROM tbl_personas WHERE id_tipo_persona=1";
//$resultado1 = $mysqli->query($nomdocentes);

?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <div class="full-box text-center">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

    <!--<img src="../dist/img/logo_informatica.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="width: 10%; margin-right: 75%">-->
    <h1>Reporte Carga Académica Docente </h1>
    <!--<img src="../dist/img/logo_reporte.jpg" alt="AdminLTE Lo   go" class="" style="opacity: .8; width: 30%; height: 30%; margin-left: 60%;">-->

  </div>


</head>


<body onload="TablaCarga1();">

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">



          </div>

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/menu_docentes_vista.php">Menú Docentes </a>
              </li>

            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->



    <!--  <input type="datetime" name="fecha" value="<?php echo date("Y-m-d"); ?>"> -->

    <div class="card card-default">
      <div class="card-header">
        <h1>Actividad Docente: </h1>
        <!-- <h1><?php// echo $nombre ?></h1>-->
        <?php while ($row = $resultado3->fetch_array(MYSQLI_ASSOC)) { ?>
          <h1><?php echo $row['nombres'], ' ', $row['apellidos']; ?></h1>
        <?php }  ?>
      </div>
    </div>
    <!--<input class="form-control" type="text" maxlength="60" id="docente" name="docente" autocomplete="off" value="" required style="text-transform: uppercase">-->
    <!-- <a class="btn btn-success "  onclick=" ventana1()">Generar Reporte Carga Academica</a>
        <a class="btn btn-success " onclick=" ventana()">Generar Reporte de Actividades</a> -->
    <div class="card-header">
      <!--  <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;"  onclick="ventana1()">Reporte Carga Académica a PDF</a> </button>

      <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()"> Reporte Actividades a PDF</a> </button> -->
      <div class=" px-12">
        <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana1()">Exportar a PDF</a> </button>
      </div>
      <script type="text/javascript" language="javascript">
        function ventana3() {
          window.open("../Controlador/reporte_mantenimiento_periodo_controlador.php", "REPORTE");
        }
      </script>

      <br>






    </div>
    <!-- <button type="submit" name="export" class="btn btn-success " value="EXCEL"> <i class="fas fa-file-excel"></i> <a style="font-weight: bold;" href="../Controlador/reporteExcelCA_docente.php">Exportar Carga Académica a EXCEL</a></button> -->


    <!--  <a href="../Controlador/reporteExcelCA_docente.php" class="fas fa-file-excel" title="Exportar a Excel"></a> -->

    <!-- <button type="submit" name="export" class="btn btn-success " value="EXCEL"> <i class="fas fa-file-excel"></i> <a href="../Controlador/reporteExcelactividades_Docentes.php" style="font-weight: bold;">Exportar Actividades a EXCEL</a></button> -->

    <!-- <a href="" onclick="generar_reporte_excel();" style="font-weight: bold;"  title=" Exportar a Excel"><i class="fas fa-file-pdf"></i></a> -->

    <!--<h3 class="card-title">Docente </h3>-->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Carga Académica Docente </h3>
        <br>
       <!--  <a href="../Controlador/reporteExcelCA_Docentes.php" class="fas fa-file-excel" title=" Exportar Carga a Excel"></a> -->

      <!--   <a href="" onclick="ventana1()" class="fas fa-file-pdf" title=" Exportar Carga a PDF"></a> -->
        <!--COMBOBOX-->
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

        </div>
      </div>
      <h1 class="hidden-print"></h1>

      <!-- /.card-header -->
      <input type="text" id="id_sesion" name="id_sesion" value="<?php echo $id; ?>" hidden readonly>
      <input type="text" id="id_persona" name="id_persona" value="<?php echo $id_persona; ?>" hidden readonly>

      <div class="card-body">

        <table id="tabla" class="table table-bordered table-striped">

          <thead>
            <tr>

              <th>CÓDIGO ASIGNATURA</th>
              <th>NOMBRE DE LA ASIGNATURA </th>
              <th>SECCIÓN</th>
              <th>HI</th>
              <th>HF</th>
              <th>DÍAS</th>
              <th>AULA</th>
              <th>EDIFICIO</th>
              <th>N.ALUMNOS</th>

            </tr>
          </thead>


        </table>

        <br>



      </div>

      <!-- /.card-header -->
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Actividades de Investigación, Vinculación UNAH-Sociedad, u otra </h3>
          <br>
         <!--  <a href="../Controlador/reporteExcelactividades_Docentes.php" class="fas fa-file-excel" title=" Exportar Actividades a Excel"></a> -->
          <!-- <a href="" onclick="ventana()" class="fas fa-file-pdf" title=" Exportar Actividades a PDF"></a> -->
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body">


          <table id="tabla1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>COMISIÓN</th>
                <th>ACTIVIDAD </th>
                <th>HORAS SEMANALES</th>
                <th>AGREGAR HORAS</th>
              </tr>
            </thead>

          </table>
        </div>
        <!-- /.card-body -->
      </div>


      <!-- /.card-body -->
      <div class="card-footer">

      </div>
    </div>



    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_editar" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content ">
          <div class="modal-header  ">
            <h5 class="modal-title ">AGREGAR HORAS DE ACTIVIDADES</h5>
            <button class="close" data-dismiss="modal">
              &times;
            </button>

          </div>


          <div class="modal-body">
            <div class="row">
              <div class="col-sm-8">
                <input type="text" id=txt_idactividad hidden>
                <label>Comisión</label>
                <input class="form-control" type="text" id="txt_comision" name="txt_comision" value="" readonly>
              </div>
              <div class="col-sm-12">
                <label>Actividad </label>
                <input class="form-control" type="text" id="txt_actividad" name="txt_actividad" value="" readonly>
              </div>
              <div class="col-sm-4">
                <label>Horas</label>
                <input class="form-control" type="text" id="txt_horas" name="txt_horas" values="" onkeypress="return Numeros(event)" maxlength="2">
              </div>
            </div>
          </div>
          <div class="modal-footer">

            <button class="btn btn-warning" onclick="modificar_horas()" id="guardar" name="guardar">Modificar</button>
            <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>

        </div>
      </div>
    </div>

    <!--  var tuvarible = <?= @$id ?> -->
    <!-- <script>
      $(document).ready(function() {

        TablaCarga1();

      });
    </script> -->
    <script>
      $(document).ready(function() {



        TablaCarga();



      });
    </script>
    <!--   <script language="javascript">
      var miVariableJS = <?= @$id ?>
      TablaCarga(miVariableJS);
    </script> -->





    <!-- *********************Creacion del modal 

-->



    <!--<button type="button" onclick="javascript:imprim2();">Imprimir</button>-->

    <!--<a class="btn btn-success hidden-print" onclick="javascript:Imprimir()">IMPRIMIR</a>-->
    <!-- <button id="btnCrearPDF">guardar pdf</button>-->

    <!--   <form method="post" action="../Controlador/reporte_carga_docente_excel.php">
          <button type="submit" name="export" class="btn btn-success" value="EXCEL"></button>
        </form>-->



    <!-- datatables JS -->
    <!-- <script type="text/javascript" src="../Reporte/datatables/datatables.min.js"></script>-->
    <!-- para usar botones en datatables JS -->
    <!--<script src="../Reporte/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>-->
    <!--<script src="../Reporte/datatables/JSZip-2.5.0/jszip.min.js"></script>-->
    <!--<script src="../Reporte/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>-->
    <!--<script src="../Reporte/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>-->
    <!--<script src="../Reporte/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>-->


    <!-- código JS propìo-->
    <!--<script type="text/javascript" src="../Reporte/main.js"></script>-->
    <script type="text/javascript" src="../Reporte/funciones_reporte.js"></script>
    <script>
      function imprim2() {
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');
        mywindow.document.write('<html><head>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById('id').innerHTML);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necesario para IE >= 10
        mywindow.focus(); // necesario para IE >= 10
        mywindow.print();
        mywindow.close();
        return true;
      }
    </script>

    <script>
      function Imprimir() {
        document.title = '';
        document.footer = 'unah';
        document.header = 'no ruta'
        window.print();
      }
    </script>
    <script language="javascript">
      function ventana() {
        window.open("../Controlador/reporte_comisiones_actividades.php", "REPORTE");
      }
    </script>
    <script language="javascript">
    
      function ventana1() {
        window.open("../Controlador/reporte_carga_academica_docente.php", "REPORTE");
      }
    </script>


    <script src="../plugins/datatables/jquery.dataTables.js"></script>

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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
</body>
<html>