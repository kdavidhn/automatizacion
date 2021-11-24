<?php
ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/conexion_mantenimientos.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=232; 

$usuario = $_SESSION['id_usuario'];
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
    window.location = "../vistas/menu_actividades_cve_vista.php";

    </script>'; 
  }else{
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A GESTION DE DOCUMENTACION');
  }
  if (permisos::permiso_insertar($Id_objeto)==0)
  {
  $_SESSION["btnagregar"]="disabled";
  }
else
  {
    $_SESSION["btnagregar"]="";
  }
ob_end_flush();
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Informes de Actividades VOAE - CVE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_actividades_cve_vista.php">Menu Actividades CVE</a></li>
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
      <div class="card-header">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
            <h1 align="right"><button class="btn btn-success" name="btnagregar" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> 
                        onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Nuevo Informe</button></h1>
              <div class="box-tools pull-right">
              </div>
            </div>
            <!-- /.box-header -->
            <!-- centro -->
            <div class="panel-body table-responsive" id="listadoregistros">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>OPCIONES</th>
                  <th>NO ACTIVIDAD</th>
                  <th>NOMBRE DE ACTIVIDAD</th>
                  <th>ASISTENCIA</th>
                  <th>FECHA INFORME</th> 
                  <th>USUARIO</th> 
                  <th>EVIDENCIA ACTIVIDAD</th>                                  
                </thead>
                <tbody>                            
                </tbody>
              </table>
            </div>
            <div class="panel-body"  id="formularioregistros">
            <!-- Inicio del Formulario --> 
            <form name="formulario" id="formulario" method="POST">           
            


              <!-- Card 1 -->
              <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Selección de Actividad Realizada a Documentar</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                  <div class="form-group col-xs-12">
                    <input type="hidden" name="id_informe" id="id_informe">
                    <label>Actividad:</label>
                    <select class="form-control-lg select2" id= "id_actividad" style="width: 100%;" name="id_actividad" required="">
                        <option  disabled="disabled">Seleccione una actividad realizada:</option>
                          <?php
                            $query = $mysqli -> query ("call vista_act_usuario('$usuario')");
                            while ($resultado = mysqli_fetch_array($query)) {
                              echo '<option value="'.$resultado['id_actividad_voae'].'"> '.$resultado['nombre_actividad'].'---'.$resultado['no_solicitud'].'</option>' ;
                            }
                          ?>
                    </select>
                  </div>  
                </div>
              </div> 
              
              
               <!-- Card  2 Introduccion y o-->
               <div class ="card card-default ">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Introducción y Objetivos</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">                    
                      <!-- INTRODUCCION -->   
                      <div class="col-sm-6">
                        <div class="form-group">                     
                          <label>Introducción </label>
                          <p><textarea  class="form-control" name="introduccion" id="introduccion" rows="8" required="" maxlength="1000" value=""                                       
                                      onkeyup="Card(event, this)"> </textarea></p>
                        </div>
                      </div>
                      <!-- OBJETIVOS -->  
                      <div class="col-sm-6">
                        <div class="form-group">                      
                          <label>Objetivos </label>
                          <p><textarea  class="form-control" name="objetivos" id="objetivos" rows="8" required="" maxlength="1000" value=""                                       
                                        onkeyup="Card(event, this)"> </textarea></p>
                        </div>
                      </div>          
                  </div>
                </div>
              </div>


              <!-- Card  3 Desarrollo-->
              <div class ="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Desarrollo del Informe</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">                    
                      <!-- DESARROLLO-->   
                    <div class="col-sm-12">
                      <div class="form-group">                 
                        <label>Desarrollo </label>
                        <p><textarea  class="form-control" name="desarrollo" id="desarrollo" rows="10" required="" maxlength="25000" value="" onkeyup="Card(event, this)"> </textarea></p>
                      </div>
                    </div>         
                  </div>
                </div>
              </div>


              <!-- Card  4 Conclusiones y archivo-->
              <div class ="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Conclusiones y Fotografías</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">                    
                     <!-- CONCLUSIONES-->   
                     <div class="col-sm-6">
                      <div class="form-group">                     
                        <label>Conclusiones</label>
                        <p><textarea  class="form-control" name="conclusiones" id="conclusiones" rows="8" required="" maxlength="1000" value="" onkeyup="Card(event, this)"></textarea></p>
                      </div>
                    </div>



                    <!-- ADJUNTO -->  
                    <div class="col-sm-6">
                      <div class="form-group">                     
                        <label>Fotografías </label>
                        <p> Solo se admite un documento en formato PDF. Se recomienda insertar las imágenes en de Word o PowerPoint y guardarlo como PDF para importar el archivo. <p>
                        
                        <!-- <div class="custom-file">
                          <input type="file" class="custom-file-input" accept="application/pdf" id="fotos_pdf" name="fotos_pdf" required="">
                          <label class="custom-file-label" for="customFile">Elige un archivo</label>
                          <input type="hidden" name="fileactual" id="fileactual">
                        </div> -->

                    
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="archivo" id="archivo" required=""   accept="application/pdf">
                            <input type="hidden" name="archivoactual" id="archivoactual">
                            <input type="hidden" name="id_repositorio" id="id_repositorio">
                            <input type="hidden" name="nombre_archivo" id="nombre_archivo">
                            <input type="hidden" name="dir_repositorio" id="dir_repositorio">
                    
                       </div>
                    </div>         
                  </div>
                </div>
              </div>

              
              <div class="row"> 
                <div class="col-sm-6">
                  <div class="form-group"> 
                    <label>Fecha de Informe:</label>
                    <input type="text" name="fch_informe" id="fec_informe" value="<?php echo date('d-m-Y');?>" disabled>
                  </div>
                </div>
                <input type="hidden" name="id_estado" id="id_estado" value="1">
                <input type="hidden" name="nombre_estado" id="nombre_estado">
                <div class="col-sm-6">
                  <div class="form-group"> 
                    <label>Elaborado por:</label>
                    <input type="hidden" name="id_usuario_registro" id="id_usuario_registro" >
                    <input type="text" name="usuario" id="usuario" placeholder="<?php echo $_SESSION['usuario'];?>" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
                <button class="btn btn-primary" type="submit" name= "btnGuardar" id="btnGuardar" ><i class="fa fa-save"></i> Guardar</button>
                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
              </div>
            </form>
            
            </div>  <!--Fin formulario -->
              
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->

  </div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<script type="text/javascript" src="../js/informe_actividad_cve.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>


<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: 'Seleccione una opcion',
            theme: 'bootstrap4',
            tags: false,
        });

    });
</script>
<script>
$('input[type="file"]').on('change', function(){
  var ext = $( this ).val().split('.').pop();
  if ($( this ).val() != '') {
    if(ext == "pdf" || ext == "PDF"){
    }
    else
    {
      $( this ).val('');
      swal({
                     title:"ALERTA",
                     text:"EXTENSIÓN NO PERMITIDA: " + ext,
                     type: "error",
                     icon: "warning",
                     showConfirmButton: false,
                     timer: 3000
                  });
    }
  }
});
</script>
<script src="../plugins/select2/js/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
</script>


<!-- Scrip de Validacion para el texto de los inputs -->
<script>
  function Card(event, el){//Validar nombre	
      //Obteniendo posicion del cursor 
      var val = el.value;//Valor de la caja de texto
      var pos = val.slice(0, el.selectionStart).length;
    
      var out = '';//Salida
      var filtro = '1234567890ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzáéíóúüÁÉÍÓÚÜ´-!?¿¡,:;"*+%.○•() /\n/';
      var v = 0;//Contador de caracteres validos
    
      //Filtar solo los numeros
      for (var i=0; i<val.length; i++){
        if (filtro.indexOf(val.charAt(i)) != -1){
        v++;
        out += val.charAt(i);		   
        
      }
      }
      //Reemplazando el valor
      el.value = out;
    
      //En caso de modificar un numero reposicionar el cursor
      if(event.keyCode==8){//Tecla borrar precionada
          el.selectionStart = pos;
          el.selectionEnd = pos;
      }
  }
</script>

</body>
</html>
