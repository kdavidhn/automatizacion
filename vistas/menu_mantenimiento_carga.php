<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');


if (permiso_ver('55') == '1') {

    $_SESSION['mantenimiento_periodo_vista'] = "...";
} else {
    $_SESSION['mantenimiento_periodo_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('63') == '1') {

    $_SESSION['mantenimiento_crear_periodo_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_periodo_vista'] = "No 
  tiene permisos para visualizar";
}


if (permiso_ver('85') == '1') {

    $_SESSION['mantenimiento_horario_docente_vista'] = "...";
} else {
    $_SESSION['mantenimiento_horario_docente_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('86') == '1') {

    $_SESSION['mantenimiento_crear_horario_docente_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_horario_docente_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('58') == '1') {

    $_SESSION['mantenimiento_edificio_vista'] = "...";
} else {
    $_SESSION['mantenimiento_edificio_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('83') == '1') {

    $_SESSION['mantenimiento_crear_edificio_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_edificio_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('60') == '1') {

    $_SESSION['mantenimiento_aula_vista'] = "...";
} else {
    $_SESSION['mantenimiento_aula_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('82') == '1') {

    $_SESSION['mantenimiento_crear_aula_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_aula_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('93') == '1') {

    $_SESSION['mantenimiento_crear_areas'] = "...";
} else {
    $_SESSION['mantenimiento_crear_areas'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('93') == '1') {

    $_SESSION['mantenimiento_area_vista'] = "...";
} else {
    $_SESSION['mantenimiento_area_vista'] = "No 
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
                            <h1 class="m-0 text-dark">MANTENIMIENTOS CARGA</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->



            <div class="card card-default">
                <div class="card-header">
                   
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">




                            <!-- /.content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
       align-items: center;
       justify-content: center;">

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Aulas</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_crear_aula_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_crear_aula_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Aulas </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_aula_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_aula_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>

                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>


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
                                                    <h4>Crear Período </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_crear_periodo_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="far fa-plus-square"></i>
                                                </div>
                                                <a href="../vistas/mantenimiento_crear_periodo_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Período </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_periodo_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>
                                                <a href="../vistas/mantenimiento_periodo_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>
                            <!-- /.content -->



                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Edificio</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_crear_edificio_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_crear_edificio_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Edificio </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_edificio_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_edificio_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>

                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>


                            <!-- /.info-box -->
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Horario </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_crear_horario_docente_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_crear_horario_docente_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>
                                        <!-- /.info-box -->
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Horarios </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_horario_docente_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_horario_docente_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>



                            <!-- /.info-box -->
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Áreas</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_crear_areas']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_crear_areas.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>
                                        <!-- /.info-box -->
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Área </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_area_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_area_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>


                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>



        </div>

    </div>

</body>

</html>