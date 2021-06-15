<?php
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');


if (permiso_ver('13')=='1')
 {
  
  $_SESSION['incripcion_estudiante_charla_menu']="...";
}
else
{
$_SESSION['incripcion_estudiante_charla_menu']="No 
  tiene permisos para visualizar";

}


if (permiso_ver('17')=='1')
 {
  
  $_SESSION['registrar_empresas_practica_menu']="...";
}
else
{
$_SESSION['registrar_empresas_practica_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('18')=='1')
 {
  
  $_SESSION['historial_constancias_practica_menu']="...";
}
else
{
$_SESSION['historial_constancias_practica_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('19')=='1')
 {
  
  $_SESSION['subir_doc_practica_menu']="...";
}
else
{
$_SESSION['subir_doc_practica_menu']="No 
  tiene permisos para visualizar";

}



if (permiso_ver('39')=='1')
 {
  
  $_SESSION['solicitud_practica_menu']="...";
}
else
{
$_SESSION['solicitud_practica_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('40')=='1')
 {
  
  $_SESSION['gestion_solicitud_practica_menu']="...";
}
else
{
$_SESSION['gestion_solicitud_practica_menu']="No 
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
            <h1 class="m-0 text-dark">Práctica Profesional Supervisada</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Vinculación</li>
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
    <h5>Inscripción para charla de PPS</h5>
   <p><?php  echo $_SESSION['incripcion_estudiante_charla_menu'];?></p>
  </div>
  <div class="icon">
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/registrar_charla_pps_vista.php" class="small-box-footer">
   Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
  </div>
   <!-- /.info-box -->
  </div>
          <!-- /.col -->


 <div class="col-6 col-sm-6 col-md-4">
  <div class="small-box bg-light">
  <div class="inner">
    <h5>Registro de Empresas para PPS</h5>
   <p><?php  echo $_SESSION['registrar_empresas_practica_menu'];?></p>
  </div>
  <div class="icon">

    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/registrar_empresa_practica_vista.php" class="small-box-footer">
   Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
  </div>
   <!-- /.info-box -->
  </div>


    <div class="col-6 col-sm-6 col-md-4">
  <div class="small-box bg-light">
  <div class="inner">
    <h5>Solicitud de PPS</h5>
   <p><?php  echo $_SESSION['solicitud_practica_menu'];?></p>
  </div>
  <div class="icon">
  <!--  <a href="../pdf/reporte_constancia_charla.php">Inicio</a> -->
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/registrar_solicitud_practica_vista.php" class="small-box-footer">
   Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
  </div>
   <!-- /.info-box -->
  </div>
          <!-- /.col -->

            <div class="col-6 col-sm-6 col-md-4">
  <div class="small-box bg-light">
  <div class="inner">
    <h5>Gestión Solicitud de PPS</h5>
   <p><?php  echo $_SESSION['gestion_solicitud_practica_menu'];?></p>
  </div>
  <div class="icon">
  <!--  <a href="../pdf/reporte_constancia_charla.php">Inicio</a> -->
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/gestion_solicitud_practica_vista.php" class="small-box-footer">
   Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
  </div>
   <!-- /.info-box -->
  </div>
          <!-- /.col -->


      <div class="col-6 col-sm-6 col-md-4">
   <div class="small-box bg-light">
   <div class="inner">
    <h5>Adjuntar documentación de PPS</h5>
   <p><?php echo $_SESSION['subir_doc_practica_menu']; ?></p> 
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/subida_informacion_estudiante_vista.php" class="small-box-footer">
    Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
</div>
</div>


 <div class="col-6 col-sm-6 col-md-4">
   <div class="small-box bg-light">
   <div class="inner">
    <h5>Historial de constancias y/o cartas</h5>
   <p><?php echo $_SESSION['historial_constancias_practica_menu']; ?></p> 
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/Historial_constancias_cartas_vista.php" class="small-box-footer">
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