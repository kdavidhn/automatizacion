<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/conexion_mantenimientos.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=110; 


$visualizacion= permiso_ver($Id_objeto);

if($visualizacion==0){
  echo '<script type="text/javascript">
  swal({
    title:"",
    text:"Lo sentimos no tiene permiso de visualizar la pantalla",
    type: "error",
    showConfirmButton: false,
    timer: 3000
    });
    window.location = "../vistas/pagina_principal_vista.php";

    </script>'; 
  }else{
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A Solicitud de Actividades CVE');
  }

  ob_end_flush();
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

           <h1>Actividades CVE</h1>
         </div>

         <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="../vistas/menu_actividades_cve_vista.php">Administrar Módulo CVE</a></li>
          </ol>
        </div>

        <div class="RespuestaAjax"></div>

      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!--Contenido-->
  <!-- Content Wrapper. Contains page content -->
  <div class="card card-default">        
    <!-- Main content -->
    <section class="content">
      <div class="card-header">
        <div class="col-md-12">
          <div class="box">
            <section>
             <h2>
               Gestion de Solicitudes
             </h5> 
            </section>
            <div class="box-header with-border">
            </p>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-header -->
            <!-- centro -->
            <div class="panel-body table-responsive" id="listadoregistros1">
              <table id="tbllistado1" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Opciones</th>
                  <th>No de Solicitud</th>
                  <th>Fecha</th>
                  <th>Nombre Solicitud</th>
                  <th>Usuario</th>
                  <th>Periodo</th>
                  <th>Estado</th>

                </thead>
                <tbody>                            
                </tbody>
              </table>
            </div>
            <div class="panel-body table-responsive" style="height: 800px;" id="formularioregistros">
              <form name="formulario" id="formulario" method="POST" >
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>No.Solicitud:</label>
                  <input type="hidden" name="id_actividad_voae" id="id_actividad_voae">
                  <input type="text" class="form-control " name="no_solicitud" id="no_solicitud" maxlength="50" placeholder="No de Solicitud" disabled>
                </div>
                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Nombre de la Actividad:</label>
                  <input type="text" class="form-control" name="nombre_actividad" id="nombre_actividad" maxlength="50" placeholder= "Nombre de la Actividad"  disabled> 
                </div>
                <div class="form-group col-lg-12 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Ubicacion de la Actividad:</label>
                  <input type="text" class="form-control" name="ubicacion" id="ubicacion" maxlength="50" placeholder="Ubicacion" disabled>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Periodo Academico:</label>
                  <select name="periodo" id="periodo"class="form-control" name="periodo" id="nombre" maxlength="50" placeholder="Seleccione el Periodo" disabled>
                    <option value="Primer Periodo">Primer Periodo</option>
                    <option value="Segundo Periodo">Segundo Periodo</option>
                    <option value="Tercer Periodo">Tercer Periodo</option>
                  </select> 
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 maxlength">
                  <label>Fecha Incial:</label>
                  <input type="date" class="form-control" name="fch_inicial_actividad" id="fch_inicial_actividad" maxlength="50" disabled>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 maxlength">
                  <label>Fecha Final:</label>
                  <input type="date" class="form-control" name="fch_final_actividad" id="fch_final_actividad" maxlength="50"  required>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Descripcion:</label>
                  <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Descripcion" disabled>
                </div>
                
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Poblacion Objetiva:</label>
                  <input type="text" class="form-control" name="poblacion_objetivo" id="poblacion_objetivo" maxlength="50" placeholder="Poblacion Objetiva" disabled>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Presupuesto:</label>
                  <input type="text" class="form-control" name="presupuesto" id="presupuesto" maxlength="50" placeholder="Presupuesto" disabled>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Staff Alumnos:</label>
                  <input type="hidden" class="form-control" name="id_estado" id="id_estado">
                  <input type="text" class="form-control" name="staff_alumnos" id="staff_alumnos" maxlength="50" placeholder="Staff Alumnos" disabled>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Ambito:</label>
                  <select class="form-control select2"  disabled name="id_ambito" id="id_ambito" style="width: 100%;">
                   <option value="0" disabled="disabled" >Seleccione un Ambito:</option>
                   <?php
                   $query = $mysqli -> query ("SELECT * FROM tbl_voae_ambitos where condicion = 1");
                   while ($resultado = mysqli_fetch_array($query)) {
                    echo '<option value="'.$resultado['id_ambito'].'"> '.$resultado['nombre_ambito'].'</option>' ;
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                <label>Observaciones:</label>
                <input type="text" class="form-control" name="observaciones" id="observaciones" maxlength="50" placeholder="Observaciones" disabled>
              </div>

              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-danger pull-right" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Salir</button>
              </div>
            </form>
          </div>
          <!--Fin centro -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
</div> 

<script type="text/javascript" src="../js/actividad_cve.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>


<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript" language="javascript">
  $(document).ready(function() {

    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      theme: 'bootstrap4',
      tags: true,
    });

  });
</script>

</body>
</html>
