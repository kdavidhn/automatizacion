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
$hoy=date("y-m-d");
if (permisos::permiso_insertar($Id_objeto)=='0'){
    $_SESSION["btnagregar"]="hidden";
  } else {
    $_SESSION["btnagregar"]="";
  }


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
            <li class="breadcrumb-item active"><a href="../vistas/menu_actividades_cve_vista.php">Menú Actividades</a></li>
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
            
            <div class="box-header with-border">
              <h1 align="right"><button class="btn btn-success" id="btnagregar" name="btnagregar" <?php $_SESSION['btnagregar'];?> onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Solicitud</button></h1>
              <div class="box-tools pull-right">
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <div class="col-sm-12">
                  <h4>ACTIVIDADES EN ELABORACION</h4>
                 </div>
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
              </div><br>
              <div class="box-tools pull-right">
              </div>
              <!-- /.box-header -->
              <!-- centro -->

              <div id="formularioregistros">
                <form name="formulario" id="formulario" method="POST" >
                  <div class="box-header with-border">
                    <section>
                          <h5><b><i><p>Fecha de Solicitud: <?php echo $hoy;?></i></b></p></h5>
                          </section>
                    </div>
                  <!-- Card 1 Datos Generales de la Actividad -->
                  <div class="card card-default">
                    <div class="card-header bg-gradient-dark">
                      <h3 class="card-title">Datos Generales de la Actividad</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /. card-header-->
                    <div class="card-body">
                      <div class="row">
                        <!-- N de Solicitud -->
                        <div class="col-sm-6">
                          <div class="form-group">
                           <label>No.Solicitud:</label>
                           <input type="hidden" name="id_actividad_voae" id="id_actividad_voae">
                           <input type="text" class="form-control" name="no_solicitud" id="no_solicitud" maxlength="10" style="text-transform: uppercase "placeholder="No de Solicitud" onkeypress="return soloLetras(event)" oncopy="return false" onpaste="return false"  required="" />
                         </div>
                       </div>
                       <!-- Nombre de la Actividad -->
                       <div class="col-sm-6">
                        <div class="form-group">
                          <label>Nombre de la Actividad:</label>
                          <input type="text" class="form-control" name="nombre_actividad" id="nombre_actividad" maxlength="50" placeholder= "Nombre de la Actividad" required> 
                        </div>
                      </div>
                      <!-- Ubicacion de la Actividad -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Ubicacion</label>
                          <input type="text" class="form-control" name="ubicacion" id="ubicacion" maxlength="50" placeholder= "Ubicacion de la Actividad" required> 
                        </div>
                      </div>
                      <!-- Periodo Academico -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Periodo Academico:</label>
                          <select name="periodo" id="periodo"class="form-control" name="periodo" id="nombre" maxlength="50" placeholder="Seleccione el Periodo" required>
                            <option value="Primer Periodo">Primer Periodo</option>
                            <option value="Segundo Periodo">Segundo Periodo</option>
                            <option value="Tercer Periodo">Tercer Periodo</option>
                          </select> 
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              <!-- Card 1 Fechas de la Actividad -->
              <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Fechas Inicial/Final de la Actividad</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /. card-header-->
                <div class="card-body">
                  <div class="row">
                    <!-- Fecha Inical -->
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Fecha Incial:</label>
                        <input type="date" class="form-control" placeholder="FECHA" name="fch_inicial_actividad" id="fch_inicial_actividad" required="" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?>
                        />
                    </div>
                    </div>
                    <!-- Fecha Final-->
                    <div class="col-sm-6">
                      <div class="form-group">
                       <label>Fecha Final:</label>
                       <input type="date" class="form-control" name="fch_final_actividad" id="fch_final_actividad" required="" required min=<?php $hoy=date("Y-m-d"); echo $hoy;?>
                       >
                     </div>
                   </div>

                 </div>
               </div>
             </div>


           <!-- Card 1 Datos extras de la Actividad -->
           <div class="card card-default">
            <div class="card-header bg-gradient-dark">
              <h3 class="card-title">Datos Adicionales de la Actividad</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /. card-header-->
            <div class="card-body">
              <div class="row">
                <!-- Descripcion -->
                <div class="col-sm-6">
                  <div class="form-group">
                   <label>Descripcion:</label>
                   <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Descripcion" required>
                 </div>
               </div>
               <!-- Poblacion Objetivo -->
               <div class="col-sm-6">
                <div class="form-group">
                  <label>Poblacion Objetiva:</label>
                  <input type="text" class="form-control" name="poblacion_objetivo" id="poblacion_objetivo" maxlength="50" placeholder="Poblacion Objetiva" required>
                </div>
              </div>
              <!-- Presupuesto -->
              <div class="col-sm-6">
                <div class="form-group">
                 <label>Presupuesto:</label>
                 <input type="text" class="form-control" name="presupuesto" id="presupuesto" maxlength="50" placeholder="Presupuesto" required>
               </div>
             </div>
             <!-- Staff Alumnos -->
             <div class="col-sm-6">
              <div class="form-group">
                <label>Staff Alumnos:</label>
                <input type="hidden" class="form-control" name="id_estado" id="id_estado">
                <input type="text" class="form-control" name="staff_alumnos" id="staff_alumnos" maxlength="50" placeholder="Staff Alumnos" required>
              </div>
            </div>
            <!-- Ambito -->
            <div class="col-sm-6">
              <div class="form-group">
               <label>Ambito:</label>
               <select class="form-control select2" name="id_ambito" id="id_ambito" style="width: 100%;">
                 <option value="0" disabled="disabled" >Seleccione un Ambito:</option>
                 <?php
                 $query = $mysqli -> query ("SELECT * FROM tbl_voae_ambitos where condicion = 1");
                 while ($resultado = mysqli_fetch_array($query)) {
                  echo '<option value="'.$resultado['id_ambito'].'"> '.$resultado['nombre_ambito'].'</option>' ;
                }
                ?>
              </select>
            </div>
          </div>
          <!-- Observaciones -->
          <div class="col-sm-6">
            <div class="form-group">
              <label>Observaciones:</label>
              <input type="text" class="form-control" name="observaciones" id="observaciones" maxlength="50" placeholder="Observaciones" required>
            </div>
          </div>


        </div>
      </div>
    </div>


  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <button class="btn btn-primary pull-right" type="submit" id="btnGuardar"><i class="fa fa-solid fa-check"></i> Guardar</button>
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

<script type="text/javascript" src="../js/actividad_cve_solicitud.js"></script>
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
<script>
  function soloLetras(e) {
    var key = e.keyCode || e.which,
    tecla = String.fromCharCode(key).toUpperCase(),
    letras = " ÀÈÌÒÙABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789-",

    especiales = [8, 37, 39, 46],
    tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }
</script>

</body>
</html>
