<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/conexion_mantenimientos.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=237; 


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
      window.location = "../vistas/horas_voae_cve_vista.php";

       </script>'; 
}else{
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A Actividades Externas Gestión');
}
if (permisos::permiso_insertar($Id_objeto)==0)
    {
    $_SESSION["btnagregar"]="hidden";
    }
  else
    {
      $_SESSION["btnagregar"]="";
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

         <h1>Actividades Externas Gestión</h1>
          </div>

                <div class="col-sm-6">
                  
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="../vistas/horas_voae_cve_vista.php"> Horas VOAE</a></li>
              <li class="breadcrumb-item active"><a > Actividades Externas</a></li>
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
                          
                          <h1 align="right"><button style="margin-right: 10px" class="btn btn-success" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> name="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Actividad Externa</button></h2>

                        <div class="box-tools pull-right">
                          
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Identificador</th>
                            <th>Nombre Actividad</th>
                            <th>Ente Organizador</th>
                            <th>Fecha Final</th>
                            <th>Periodo</th>
                            
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>
                  
            <div  id="formularioregistros">
             
                <form name="formulario" id="formulario" method="POST">

                 <!-- Card 1 -->
              <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Nombre Actividad</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>

                <div class="card-body">
                <div class="row">
                <input type="hidden" name="id_actividad_voae" id="id_actividad_voae">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                   <label>Nombre:</label>
                  <input type="text" class="form-control" name="nombre_actividad" id="nombre_actividad" style="text-transform: uppercase;" onkeypress="return soloLetras(event)" required maxlength="50" placeholder="Nombre Actividad" required>
                </div>
                </div>
                </div>
                </div>



                <!-- Card 7 -->
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Ente Organizador y Ámbito</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength">
                  <label>Ente Organizador:</label>
                  <input type="text" class="form-control" name="staff_alumnos" id="staff_alumnos"  maxlength="50" placeholder="Ente Organizador" style="text-transform: uppercase;" onkeypress="return soloLetras(event)" required>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength"><label>Ámbito:</label>
                              <select class="form-control select2" name="id_ambito" id="id_ambito" style="width: 100%;" required="">
                                <option value="0" disabled="disabled" >Seleccione un ámbito:</option>
                                  <?php
                                    $query = $mysqli -> query ("SELECT * FROM tbl_voae_ambitos where condicion = 1");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_ambito'].'"> '.$resultado['nombre_ambito'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                </div>
                </div>
                </div>
                
                
                <!-- Card 9 -->
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Periodo Académico</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 maxlength"><label>Periodo Académico:</label>
                  <select class="form-control select2" name="periodo" id="periodo" class="form-control"  maxlength="50" required>
                    <option value="PRIMER PERIODO">Primer Periodo</option>
                    <option value="SEGUNDO PERIODO">Segundo Periodo</option>
                    <option value="TERCER PERIODO">Tercer Periodo</option>
                  </select> 
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
                        <input type="date" class="form-control" placeholder="FECHA" name="fch_inicial_actividad" id="fch_inicial_actividad" required="" required max=<?php $hoy=date("Y-m-d"); echo $hoy;?>
                        />
                    </div>
                    </div>
                    <!-- Fecha Final-->
                    <div class="col-sm-6">
                      <div class="form-group">
                       <label>Fecha Final:</label>
                       <input type="date" class="form-control" name="fch_final_actividad" id="fch_final_actividad" required="" required max=<?php $hoy=date("Y-m-d"); echo $hoy;?>
                       >
                     </div>
                   </div>

                 </div>
               </div>
             </div>


                
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-primary pull-right" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
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
 
<script type="text/javascript" src="../js/actividad_externa_cve.js"></script>

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
document.getElementById("formulario").addEventListener("keydown", teclear);

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
