<?php

ob_start();


session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');


$id_objeto=92 ;

$visualizacion= permiso_ver($id_objeto);

if ($visualizacion==0)
{
  echo '<script type="text/javascript">
                          swal({
                                title:"",
                                text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                              });
                            window.location = "../vistas/gestion_dias_feriados_vista.php";

                            </script>';
}

else 

{

      bitacora::evento_bitacora($id_objeto, $_SESSION['id_usuario'], 'Ingresó' , 'a mantenimiento de dias feriados');


}




ob_end_flush();



?>





  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

         <h1>Gestión de Días Feriados</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_practica_vista.php">Vinculación</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->



         
            <!-- /.card-body -->
          
 <div class="card card-default">        
        <!-- Main content -->
        <section class="content">
            <div class="card-header">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="card-title">Días Feriados <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                      <th>FECHA</th>
                      <th>DESCRIPCIÓN</th>
                      <th>ESTADO</th>
                      <th>EDITAR</th>
                      <th>CAMBIAR ESTADO</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"><br>
                            <label>Fecha:</label>
                            <input type="hidden" name="id_dia_feriado" id="id_dia_feriado">
                            <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Fecha" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripción:</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="255" placeholder="Descripción">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
        
          <!-- /.card-body -->






                      





   




<script type="text/javascript" src="../js/dias_feriados.js"></script>
  <script src="../js/bootbox.all.js"></script>
  <script src="../js/bootbox.all.min.js"></script>
  <script src="../js/bootbox.locales.js"></script>
  <script src="../js/bootbox.js"></script>
  <script src="../js/bootbox.locales.min.js"></script>
  <script src="../js/bootbox.min.js"></script>


</body>
</html>