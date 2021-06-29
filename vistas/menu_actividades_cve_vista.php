<?php
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/conexion_mantenimientos.php');
require_once ('../clases/funcion_visualizar.php');

if (permiso_ver('109')=='1') {
  $_SESSION['actividades_cve']="...";
} else {
  $_SESSION['actividades_cve']="No 
            tiene permisos para visualizar";
}
if (permiso_ver('110')=='1') {
  $_SESSION['solicitud_actividades_vista']="...";
} else {
  $_SESSION['solicitud_actividades_vista']="No 
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
            <h1 class="m-0 text-dark">Actividades Horas Voae del CVE</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Actividades Módulo CVE</li>
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
        <div class="row" style="display: flex; align-items: center; justify-content: center;">

          <!-- Box 1 -->
          <div class="col-6 col-sm-6 col-md-4">
            <div class="small-box bg-primary">
              <div class="inner">
                <h5>Actividades<br> Solicitud de Actividad </h5>
                <p><?php echo $_SESSION['solicitud_actividades_vista']; ?></p> 
              </div>
              <div class="icon">
                <i class="fas fa-edit"></i>
              </div>
              <a href="../vistas/Actividad_cve_vista.php" class="small-box-footer">
                Ir <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>


         <!-- /.row -->
        </div><!--/. container-fluid -->
      </div>
    </section>
  <!-- /.content -->
  </div>
 
</div>

</body>
</html>