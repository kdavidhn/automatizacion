<?php
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');


if (permiso_ver('14')=='1')
 {
  
  $_SESSION['gestion_inscripcion_menu']="...";
}
else
{
$_SESSION['gestion_inscripcion_menu']="No 
  tiene permisos para visualizar";

}



if (permiso_ver('15')=='1')
 {
  
  $_SESSION['registrar_clases_aprobadas_menu']="...";
}
else
{
$_SESSION['registrar_clases_aprobadas_menu']="No";
}

if (permiso_ver('14')=='1')
 {
  
  $_SESSION['mantenimiento_dias_feriados']="...";
}
else
{
$_SESSION['mantenimiento_dias_feriados']="No tiene permisos para visualizar";

}


if (permiso_ver('16')=='1')
 {
  
  $_SESSION['gestion_clases_aprobadas_menu']="...";
}
else
{
$_SESSION['gestion_clases_aprobadas_menu']="No 
  tiene permisos para visualizar";

}



if (permiso_ver('20')=='1')
 {
  
  $_SESSION['revision_doc_practica_menu']="...";
}
else
{
$_SESSION['revision_doc_practica_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('21')=='1')
 {
  
  $_SESSION['aprobacion_rechazo_practica_menu']="...";
}
else
{
$_SESSION['aprobacion_rechazo_practica_menu']="No 
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
   <div class="small-box bg-primary">
   <div class="inner">
    <h5>Mantenimiento días feriado </h5>
   <p><?php echo $_SESSION['mantenimiento_dias_feriados']; ?></p> 
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/gestion_dias_feriados_vista.php" class="small-box-footer">
    Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
</div>
</div>


    
   <div class="col-6 col-sm-6 col-md-4">
   <div class="small-box bg-light">
   <div class="inner">
    <h5>Gestión Inscripción </h5>
   <p><?php echo $_SESSION['gestion_inscripcion_menu']; ?></p> 
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/gestion_asistencia_charla_vista.php" class="small-box-footer">
    Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
</div>
</div>


<div class="col-6 col-sm-6 col-md-4">
  <div class="small-box bg-light">
  <div class="inner">
    <h5>Registro de Asignaturas Aprobadas</h5>
   <p><?php echo $_SESSION['registrar_clases_aprobadas_menu'];?></p>
  </div>
  <div class="icon">
        <i class="fas fa-user-edit"></i>

  </div>
  <a href="../vistas/registrar_asignaturas_aprobadas_vista.php" class="small-box-footer">
   Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
  </div>
 
  </div>


   <div class="col-6 col-sm-6 col-md-4">
   <div class="small-box bg-light">
   <div class="inner">
    <h5>Gestión Asignaturas Aprobadas</h5>
   <p><?php echo $_SESSION['gestion_clases_aprobadas_menu']; ?></p> 
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/gestion_asignaturas_aprobadas_vista.php" class="small-box-footer">
    Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
</div>
</div>


     <div class="col-6 col-sm-6 col-md-4">
   <div class="small-box bg-light">
   <div class="inner">
    <h5>Revisión  de Doc. de PPS</h5>
   <p><?php echo $_SESSION['revision_doc_practica_menu']; ?></p> 
  </div>
  <div class="icon">
    <i class="fas fa-user-edit"></i>
  </div>
  <a href="../vistas/gestion_documentos_practica_vista.php" class="small-box-footer">
    Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
</div>
</div>


   <div class="col-6 col-sm-6 col-md-4">
  <div class="small-box bg-light">
  <div class="inner">
    <h5>Aprobación/Rechazo de PPS</h5>
   <p><?php  echo $_SESSION['aprobacion_rechazo_practica_menu'];?></p>
  </div>
  <div class="icon">
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/aprobar_practica_coordinacion_vista.php" class="small-box-footer">
   Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
  </div>
   <!-- /.info-box -->
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