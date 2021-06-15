<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');

if (permiso_ver('49') == '1') {

  $_SESSION['menu_docentes_vista'] = "...";
} else {
  $_SESSION['menu_docentes_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('50') == '1') {

  $_SESSION['registro_docentes_vista'] = "...";
} else {
  $_SESSION['registro_docentes_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('51') == '1') {

  $_SESSION['gestion_docentes_vista'] = "...";
} else {
  $_SESSION['gestion_docentes_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('52') == '1') {

  $_SESSION['comisiones_actividades_docentes_vista'] = "...";
} else {
  $_SESSION['comisiones_actividades_docentes_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('53') == '1') {

  $_SESSION['reporte_carga_academica_docentes_vista'] = "...";
} else {
  $_SESSION['reporte_carga_academica_docentes_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('54') == '1') {

  $_SESSION['perfil_docentes_vista'] = "...";
} else {
  $_SESSION['perfil_docentes_vista'] = "No 
  tiene permisos para visualizar";
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">



</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Docentes </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Docentes</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->



      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">



            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-light">
                <div class="inner">
                  <h4>Registro de Docentes </h4>
                  <p><?php echo $_SESSION['registro_docentes_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/registro_docentes_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>



            <div class="col-12 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Gestión Docentes </h4>
                  <p><?php echo $_SESSION['gestion_docentes_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/gestion_docentes_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          </div>
          <!--/. container-fluid -->
        </div>
      </section>


      <!--<div class="col-12 col-sm-6 col-md-4">
  <div class="small-box bg-primary">
  <div class="inner">
    <h4>Comisiones y Actividades Docentes </h4>
    <p><//?php echo $_SESSION['comisiones_actividades_docentes_vista']; ?></p>
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/comisiones_actividades_docentes_vista.php" class="small-box-footer">
    Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
  </div>
  </div>
 
          </div> -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">

            <div class="col-12 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Reporte Carga Academica </h4>
                  <p><?php echo $_SESSION['reporte_carga_academica_docentes_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/reporte_carga_academica_docentes_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Perfil Docentes </h4>
                  <p><?php echo $_SESSION['perfil_docentes_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/perfil_docentes_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <!-- /.row -->
          </div>
          <!--/. container-fluid -->
        </div>
      </section>
      <!-- /.content -->
    </div>

  </div>

</body>

</html>