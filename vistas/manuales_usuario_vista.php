<?php 
ob_start();
session_start();
require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');



?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manuales de usuario</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Ayuda</li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="container-fluid">



      <form method="post"  data-form="save" autocomplete="off"  class="FormularioAjax">
<!--
<form  method="post"  data-form="save" autocomplete="off" style=" display:" >

-->

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Nuevo</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">

                   <div class="col-sm-12" >
                    <div class="form-group">
                  <label>Vinculación</label>
                  <a href="../Documentacion_practica/manuales_de_usuario/manual_usuario_vinculacion.pdf" target="_blank" class="small-box-footer">
                    Ir <i class="fas fa-arrow-circle-right"></i>
                  </a>
                    </div>
                    </div>
                    
                    <div class="col-sm-12" >
                      <div class="form-group">
                        <label>Coordinación</label>
                        <a href="../manuales/Manual de Coordinación.docx" target="_blank" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>
                    </div>

                    <div class="col-sm-12" >
                      <div class="form-group">
                        <label>Alumno</label>
                        <a href="../manuales/manual alumno.docx" target="_blank" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>
                    </div>


                    

                
                            
          <!-- /.card-body -->
          
        </div>
                     
    <div class="RespuestaAjax"></div>
</form>


  </div>
</section>

</div>

</body>
</html>


