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

$Id_objeto=114; 


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

         <h1>Horas VOAE Gestión</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a >Horas VOAE</a></li>
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
        
            <div class="card-header">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          
                          <h1><button style="margin-right: 10px" class="btn btn-success" id="btnagregar" name="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Actividad Externa</button>

                            <button class="btn btn-info" id="btnagregarhoras" name="btnagregarhoras" onclick="mostrarform2(true)"><i class="fa fa-plus-circle"></i> Agregar Horas Alumno</button>
                          </h1>
                       

                        <div class="box-tools pull-right">
                          
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre Alumno</th>
                            <th>Cuenta</th>
                            <th>Actividades Realizadas</th>
                            <th>Horas Totales</th>
                            
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>
                    <div  id="formularioregistros">
             
                <form name="formulario" id="formulario" method="POST">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Identificador Actividad:</label>
                  <input type="text" class="form-control" disabled maxlength="50" placeholder="<?php
                                    
                                    $query = $mysqli -> query ("SELECT MAX(id_actividad_voae) AS id FROM tbl_voae_actividades");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo $resultado['id'] + 1;
                                    }
                                  ?>" required>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Nombre de la Actividad:</label>
                  <input type="hidden" name="id_actividad_voae" id="id_actividad_voae">
                  <input type="text" class="form-control" name="nombre_act" id="nombre_act" maxlength="50" placeholder="Nombre Actividad" required>
                </div>
                
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Ubicación de la Actividad:</label>
                  <input type="text" class="form-control" name="ubicacion" id="ubicacion" maxlength="50" placeholder="Ubicación" required>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Inicial:</label>
                  <input type="datetime-local" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="256" >
                </div>
                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Final:</label>
                  <input type="datetime-local" class="form-control" name="fecha_final" id="fecha_final" maxlength="256">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Descripción:</label>
                  <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="50" placeholder="Descripción" required>
                </div>
                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Observaciones:</label>
                  <input type="text" value ="Actividad Externa"class="form-control" name="observaciones" id="observaciones" disabled maxlength="50" placeholder="Actividad Externa" required>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Horas:</label>
                  <input type="text" class="form-control" name="horas_voae" id="horas_voae" maxlength="50" placeholder="Horas Actividad" required>
                </div>
                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Ambito:</label>
                              <select class="form-control select2" name="ambito" id="ambito" style="width: 100%;" required="">
                                <option value="0" disabled="disabled" >Seleccione una Falta:</option>
                                  <?php
                                    $query = $mysqli -> query ("SELECT * FROM tbl_voae_ambitos where condicion = 1");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_ambito'].'"> '.$resultado['nombre_ambito'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Periodo Academico:</label>
                  <select class="form-control select2" name="periodo" id="periodo" class="form-control"  maxlength="50" required>
                    <option value="1">Primer Periodo</option>
                    <option value="2">Segundo Periodo</option>
                    <option value="3">Tercer Periodo</option>
                  </select> 
                </div>

                
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-primary pull-right" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Agregar</button>
                  <button class="btn btn-danger pull-right" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Salir</button>
                </div>
              </form>
            </div>
            <div  id="formularioregistros2">
             
                <form name="formulario2" id="formulario2" method="POST">
                
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Nombre Alumno:</label>
                  <select class="form-control-lg select2" id= "id_persona_alumno" style="width: 100%;" name="id_persona_alumno" required="">
                                <option  value="0" disabled="disabled">Seleccione un Alumno:</option>
                                  <?php
                                    $query = $mysqli -> query ("select tbl_personas.id_persona, concat(tbl_personas.nombres,' ',tbl_personas.apellidos) AS nombres, tbl_personas_extendidas.valor from tbl_personas join tbl_personas_extendidas on tbl_personas.id_persona = tbl_personas_extendidas.id_persona Where id_tipo_persona=2 and id_atributo=12;");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_persona'].'"> '.$resultado['nombres'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Actividad (Externa):</label>
                  <select class="form-control-lg select2" id= "id_actividad" style="width: 100%;" name="id_actividad" required="">
                                <option  value="0" disabled="disabled">Seleccione Actividad:</option>
                                  <?php
                                    $query = $mysqli -> query ("select id_actividad_voae, concat(id_actividad_voae,' -- ',nombre_actividad,' -- ', ubicacion) as actividad from tbl_voae_actividades where tipo_actividad = 2;");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_actividad_voae'].'"> '.$resultado['actividad'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Horas:</label>
                  <input type="text" class="form-control" name="horas_alumno" id="horas_alumno" maxlength="50" placeholder="Horas Alumno" required>
                </div>
                

                
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-primary pull-right" type="submit" id="btnGuardar2"><i class="fa fa-save"></i> Agregar Horas</button>
                  <button class="btn btn-danger pull-right" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Salir</button>
                </div>
              </form>
            </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
     

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  </div> 
 
<script type="text/javascript" src="../js/horas_voae.js"></script>

<script src="../plugins/select2/js/select2.min.js"></script>



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
