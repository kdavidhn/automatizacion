<?php

require_once('../clases/Conexion.php');
require_once('../clases/permisos_usuario.php');




if (session_status() === PHP_SESSION_NONE) {
  session_start();
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Informatica Administrativa</title>


  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 -->
  <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
  <link href="../plugins/datatables/Buttons-1.5.6/buttons.dataTables.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/dataTables.bootstrap4.min.css">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link rel="stylesheet" type="text/css" href="../plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="../dist/css/sweetalert2.css">
  <script src="../js/funciones.js"></script>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" href="../vistas/cambiar_clave_x_usuario_vista.php">
            <i class="fas fa-user-tag"></i>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" href="../vistas/gestion_respuesta_usuario_vista.php">
            <i class="fas fa-question-circle"></i>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="btn-exit-system" href="#!">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>

      </ul>

    </nav>

    <!-- nav -->





    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../vistas/pagina_principal_vista.php" class="brand-link">
        <img src="../dist/img/lOGO_OFICIAL.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Informática </span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../dist/img/usuario3.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php
                                        echo ($_SESSION['usuario']); ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item has-treeview " style="display:<?php echo $_SESSION['btn_seguridad'] ?>">
              <a href="#" class="nav-link ">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>
                  Seguridad
                  <i class="right fas fa-angle-left"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['pregunta_vista'] ?>">
                  <a href="../vistas/menu_pregunta_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Preguntas de Seguridad</p>
                  </a>
                </li>

                <li class="nav-item" style="display:<?php echo $_SESSION['usuarios_vista'] ?>">
                  <a href="../vistas/menu_usuarios_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Usuarios</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['roles_vista'] ?>">
                  <a href="../vistas/menu_roles_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Roles</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['permisos_usuario_vista'] ?>">
                  <a href="../vistas/menu_permisos_usuario_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Permisos a Usuarios</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['parametro_vista'] ?>">
                  <a href="../vistas/gestion_parametros_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Parametros</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['bitacora_vista'] ?>">
                  <a href="../vistas/bitacora_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Bitacora del Sistema</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_vinculacion'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Vinculación
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['practica_vista'] ?>">
                  <a href="../vistas/menu_practica_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Práctica Profesional </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['supervision_vista'] ?>">
                  <a href="../vistas/menu_supervision_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Supervisión de Práctica </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['egresados_vista'] ?>">
                  <a href="../vistas/menu_egresados_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Egresados</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['proyectos_vinculacion_vista'] ?>">
                  <a href="../vistas/menu_proyectos_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Proyectos de Vinculación </p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_coordinacion'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Coordinación
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item" style="display:<?php echo $_SESSION['final_practica'] ?>">
                  <a href="../vistas/revision_finalizacion_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Finalizacion de Practica </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['cambio_carrera'] ?>">
                  <a href="../vistas/menu_revision_cambio.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Cambio de Carrera </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['carta_egresado'] ?>">
                  <a href="../vistas/revision_carta_egresado_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Carta de Egresado</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['equivalencias'] ?>">
                  <a href="../vistas/menu_revison_equivalencias.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Equivalencias </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['cancelar_clases'] ?>">
                  <a href="../vistas/revision_cancelar_clases.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cancelacion de clases</p>
                  </a>
                </li>
                <!-- CARGA ACADEMICA -->
                <li class="nav-item" style="display:<?php echo $_SESSION['carga_academica_vista'] ?>">
                  <a href="../vistas/menu_carga_academica_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Carga Académica </p>
                  </a>
                </li>
                <!-- PLAN DE ESTUDIO -->
                <li class="nav-item" style="display:<?php echo $_SESSION['plan_estudio_vista'] ?>">
                  <a href="../vistas/menu_plan_estudio_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Plan de Estudio </p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- AGREGANDO DOCENTES -->
            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_docentes'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-signature"></i>
                <p>
                  Docentes
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['docentes_vista'] ?>">
                  <a href="../vistas/menu_docentes_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Docentes </p>
                  </a>
                </li>
              </ul>
            </li>
           
     <!-- AGREGANDO COMITE DE VIDA ESTUDIANTIL -->
            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_comite_vida_estudiantil'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-address-card"></i>
                <p>
                  Comité Vida Estudiantil
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['actividades_cve'] ?>">
                  <a href="../vistas/menu_actividades_cve_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Actividades </p>
                  </a>
                </li>
               <li class="nav-item" style="display:<?php echo $_SESSION['faltas_cve'] ?>">
                  <a href="../vistas/registro_faltas_conducta_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Registro Faltas</p>
                  </a>
                </li> 
                <li class="nav-item" style="display:<?php echo $_SESSION['memos_cve'] ?>">
                  <a href="../vistas/memorandum_cve_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Memorándums</p>
                  </a>
                </li>  
                <li class="nav-item" style="display:<?php echo $_SESSION['horas_cve'] ?>">
                  <a href="../vistas/horas_voae_cve_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Horas VOAE</p>
                  </a>
                </li>  
              </ul>
            </li>








            <!---- solicitudes ----->

            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_solicitudes'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-signature"></i>
                <p>
                  Solicitudes
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['solicitud_practica'] ?>">
                  <a href="../vistas/menu_estudiantes_practica_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Solicitud de Practica </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['solicitud_final_practica'] ?>">
                  <a href="../vistas/solicitud_finalizacion_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Finalizacion de Practica </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['solicitud_cambio_carrera'] ?>">
                  <a href="../vistas/cambio_carrera_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Cambio de Carrera </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['solicitud_carta_egresado'] ?>">
                  <a href="../vistas/carta_egresado_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Carta de Egresado</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['solicitud_equivalencias'] ?>">
                  <a href="../vistas/equivalencias_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Equivalencias </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['solicitud_cancelar_clases'] ?>">
                  <a href="../vistas/cancelar_clases_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cancelacion de clases</p>
                  </a>
                </li>
              </ul>
            </li>
            <!---- Ayuda ----->

            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_ayuda'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book-open"></i>
                <p>
                  Ayuda
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['btn_ayuda'] ?>">
                  <a href="../vistas/menu_ayuda_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Manuales de usuario </p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['btn_ayuda'] ?>">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Mesa de ayuda </p>
                  </a>
                </li>
              </ul>

              <!---- ----->
              <!----MANTENIMIENTOS ----->
            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_mantenimiento'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Mantenimiento
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item" style="display:<?php echo $_SESSION['mantemiento_carga_academica'] ?>">
                  <a href="../vistas/menu_mantenimiento.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Mantenimientos Docentes</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['mantemiento_carga_academica1'] ?>">
                  <a href="../vistas/menu_mantenimiento_carga.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Mantenimientos Carga </p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['mantenimiento_plan'] ?>">
                  <a href="../vistas/menu_mantenimiento_plan.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> Mantenimientos Plan de Estudios</p>
                  </a>
                </li>
                <li class="nav-item" style="display:<?php echo $_SESSION['administracion_cve'] ?>">
                  <a href="../vistas/menu_administracion_cve_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mantenimiento CVE</p>
                  </a>
                </li>

              </ul>

            </li>
            <!----About ----->

            <li class="nav-item has-treeview" style="display:<?php echo $_SESSION['btn_solicitudes'] ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-info"></i>
                <p>
                  About
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" style="display:<?php echo $_SESSION['btn_ayuda'] ?>">
                  <a href="../vistas/about_vista.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p> About </p>
                  </a>
                </li>
              </ul>

              <!---- ----->



          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>



  </div>

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- Bootstrap 4 -->
  <!-- Select2 -->
  <script src="../plugins/select2/js/select2.full.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="../dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <!-- bootstrap color picker -->
  <script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>

  <script src="../plugins/raphael/raphael.min.js"></script>
  <script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- DataTables -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  
  
  
  
  <!-- InputMask -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="../dist/js/pages/dashboard2.js"></script>

  <!-- Bootstrap 4 -->
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="../plugins/sweetalert/sweetalert.min.js"></script>
  <!-- Toastr -->
  <script src="../plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js"></script>

  <script src="../dist/js/sweetalert2.min.js"></script>

  <script src="../dist/js/main.js"></script>



  <script type="text/javascript" src="../plugins/bootstrap/js/bootstrap.min.js"></script>


  <script src="../js/sweetalert2.min.js"></script>

  <script src="../js/main.js"></script>
    

  <script src="../js/bootbox.min.js"></script> 

     

    <script src="../public/datatables/jszip.min.js"></script>
    

 <link rel="stylesheet" type="text/css" href="../public/DataTables-1.10.25/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="../public/Buttons-1.7.1/css/buttons.bootstrap4.min.css"/>
 
<script type="text/javascript" src="../public/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="../public/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="../public/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../public/DataTables-1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/buttons.html5.min.js"></script>


  <script type="text/javascript">
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $(function() {
          //Initialize Select2 Elements
          $('.select2').select2()

          //Initialize Select2 Elements
          $('.select2bs4').select2({
            theme: 'bootstrap4'
          })
  </script>
  <script>
    $(function() {

      //Input para telefono
      $('[data-mask]').inputmask()



    })
  </script>
  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000

      });


    });
  </script>

</body>

</html>