<?php
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');


if (permiso_ver('24')=='1')
 {
  
  $_SESSION['registrar_proyecto_menu']="...";
}
else
{
$_SESSION['registrar_proyecto_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('25')=='1')
 {
  
  $_SESSION['gestion_proyectos_menu']="...";
}
else
{
$_SESSION['gestion_proyectos_menu']="No 
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
            <h1 class="m-0 text-dark">Proyectos Vinculación Universidad Sociedad </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Proyectos</li>
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
    <h4>Nuevo Proyecto </h4>
    <p><?php echo $_SESSION['registrar_proyecto_menu'];?></p>
  </div>
  <div class="icon">
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/registrar_proyecto_vinculacion_vista.php" class="small-box-footer">
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
    <h4>Gestión Proyectos </h4>
    <p><?php echo $_SESSION['gestion_proyectos_menu'];?></p>
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/gestion_proyectos_vista.php" class="small-box-footer">
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
