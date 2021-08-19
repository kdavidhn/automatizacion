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

$Id_objeto=228; 


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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A Horas VOAE Gestión');
}
if (permisos::permiso_insertar($Id_objeto)==0)
  {
  $_SESSION["btnagregar"]="hidden";
  }
else
  {
    $_SESSION["btnagregar"]="";
  }
if (permisos::permiso_insertar($Id_objeto)==0)
  {
  $_SESSION["btnagregarhoras"]="hidden";
  }
else
  {
    $_SESSION["btnagregarhoras"]="";
  }
ob_end_flush();
?>
<body oncopy="return false" onpaste="return false">
  

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

         <h1>Horas VOAE Historial</h1>
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
                           <form action="../vistas/actividades_externas_cve_vista.php">

                            <button title="Ver Actividades" id="btnact" name="btnact"class="btn btn-primary" type="submit" ><i class="far fa-eye"></i>    VER ACTIVIDADES EXTERNAS</button>
                       </form>
                          <h1 align="right">

                            <button class="btn btn-success" id="btnagregarhoras" name="btnagregarhoras"<?php echo $_SESSION['btnagregarhoras']; ?> onclick="mostrarform2(true)"><i class="fa fa-plus-circle"></i> Agregar Horas Externas Alumno</button>
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
                    
            <div  id="formularioregistros2">
             
                <form name="formulario2" id="formulario2" method="POST">
                <!-- Card 1 -->
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Selección Alumno y Actividad</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Alumno:</label>
                  <select class="form-control-lg select2" id= "id_persona_alumno" style="width: 100%;" name="id_persona_alumno" required="">
                                <option  value="0" disabled="disabled">CUENTA --- NOMBRES</option>
                                  <?php
                                  $espacio=" --";
                                    $query = $mysqli -> query ("select tbl_personas.id_persona, upper(concat(tbl_personas.nombres,' ',tbl_personas.apellidos)) AS nombres, tbl_personas_extendidas.valor from tbl_personas join tbl_personas_extendidas on tbl_personas.id_persona = tbl_personas_extendidas.id_persona Where id_tipo_persona=2 and id_atributo=12;");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_persona'].'">'.$resultado['valor'].''.$espacio.' '.$resultado['nombres'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Actividad Externa:</label>
                  <select class="form-control-lg select2" id= "id_actividad" style="width: 100%;" name="id_actividad" required="">
                                <option  value="0" disabled="disabled">ID --- NOMBRE</option>
                                  <?php
                                    $query = $mysqli -> query ("select id_actividad_voae, concat(id_actividad_voae,' -- ',nombre_actividad) as actividad from tbl_voae_actividades where tipo_actividad = 'Actividad Externa';");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_actividad_voae'].'"> '.$resultado['actividad'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                </div>
                </div>
                </div>
               

                <!-- Card 2 -->
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Horas a Asignar</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                  <label>Horas:</label>
                  <input type="number" class="form-control" name="horas_alumno" id="horas_alumno" maxlength="50" placeholder="Horas Alumno" required>
                </div>
                </div>
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
<script>
  function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toUpperCase(),
      letras = " ÀÈÌÒÙABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
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
<script>
document.getElementById("formulario2").addEventListener("keydown", teclear);

var flag = false;
var teclaAnterior = "";

function teclear(event) {
  teclaAnterior = teclaAnterior + " " + event.keyCode;
  var arregloTA = teclaAnterior.split(" ");
  if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
    event.preventDefault();
  }
}
</script>
</body>
</html>
