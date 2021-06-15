<?php
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');


if (permiso_ver('22')=='1')
 {
  
  $_SESSION['ayuda_menu']="...";
}
else
{
$_SESSION['ayuda_menu']="No 
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
            <h1 class="m-0 text-dark">Manuales de usuario </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Ayuda</li>
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
    <h4>Manuales de usuario</h4>
    <p><?php echo $_SESSION['ayuda_menu'];?></p>
  </div>
  <div class="icon">
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/manuales_usuario_vista.php" class="small-box-footer">
  Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
</div>


            <!-- /.info-box -->
          </div>
          <!-- /.col -->

        


    
         
            <!-- /.row -->
      </div><!--/. container-fluid -->
  </div>
    </section>
   <!-- /.content -->
  </div>
 
</div>

</body>
</html>
