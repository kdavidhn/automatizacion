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
          <div class="col-sm-12">
          
         
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos de filtro</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                     
                           
              <div class="col-sm-6">
                <div class="form-group">
                <label>Fecha Desde:</label>
                <input type="date" class="form-control" placeholder="Start"  id="fecha_inicio" name="fecha_inicio">
                </div>
              </div>
                <div class="col-sm-6">
                 <div class="form-group">
                 <label>Hasta:</label>
                <input type="date" class="form-control" placeholder="End" id="fecha_fin" name="fecha_fin">
                </div>
              </div>
                <div class="col-sm-6">
                 <div class="form-group">
                 <label>Empresa:</label>
                <input type="text" class="form-control" placeholder="Buscar por empresa" id="empresa" name="empresa">
                </div>
              </div>
                <div class="col-sm-6">
                 <div class="form-group">
                 <label>Docente Supervisor:</label>
                <input type="text" class="form-control" placeholder="Buscar por docente" id="docente" name="docente"/>
                </div>
                 </div>
              <p class="text-center" style="margin-top: 20px;">
            <button class="btn btn-primary" value="Buscar" onclick="listar()">Buscar</button> 
              <a href="estadisticas_practica_profesional_vista.php" type="button" value="Refrescar"class="btn btn-success">Recargar<span class = "glyphicon glyphicon-refresh"><span></a>
              <a target="_blank" href="" class="btn btn-danger" onclick="imprimir(this)" id="datos" >Imprimir</a>
              
              </p>
            </div>
          </div>
         

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>


              <!--Contenido-->
              <!-- Content Wrapper. Contains page content -->
           
                <!-- Main content -->
                <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Reporte Practica Profesional Supervisada</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                            <table class="table table-bordered table-striped" id="tbllistado" >
                            
                                <thead >
                                  <tr>
                                    <th>Nombre Completo</th>
                                    <th>Número de cuenta</th>
                                    <th>Empresa</th>
                                    <th>Dirección</th>
                                    <th>Supervisor Asignado</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha de finalización</th>
                                    <th>Primera Visita</th>
                                    <th>Segunda Visita</th>
                                    <th>Visita Unica</th>
                                  </tr>
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
          <script type="text/javascript" src="../js/supervisiones/estadisticas.js"></script>
