<?php

              ob_start();

              session_start();

              require_once ('../vistas/pagina_inicio_vista.php');
              require_once ('../clases/Conexion.php');
              require_once ('../clases/funcion_bitacora.php');
              require_once ('../clases/funcion_visualizar.php');
              require_once ('../clases/funcion_permisos.php');

?>
  
   <div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión de Docentes Supervisores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item "><a href="../vistas/menu_supervision_vista.php">Supervisión</a></li></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>

              <!--Contenido-->
              <!-- Content Wrapper. Contains page content -->
           
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="box">
                           
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead>
                                    <th>ASIGNAR DOCENTE</th>                                    
                                    <th>NOMBRE</th>
                                    <th>NÚMERO DE CUENTA</th>
                                    <th>NOMBRE EMPRESA</th>
                                    <th>DIRECCIÓN</th>
                                    <th>FECHA INICIO</th>
                                    <th>FECHA FINALIZACIÓN</th>
                                  </thead>
                                </table>
                            </div>
                           
                            </div>
                            <!--Fin centro -->
                          </div><!-- /.box -->
                      </div><!-- /.col -->
                  </div><!-- /.row -->
              </section><!-- /.content -->
        
            </div><!-- /.content-wrapper -->
          <!--Fin-Contenido-->
          <script type="text/javascript">
          $(document).ready(function() {
         
          });
          </script>
          <script type="text/javascript" src="../js/supervisiones/docente_supervisor.js"></script>
          <script type="text/javascript" src="../plugins/mantenimientos/bootbox.min.js"></script>