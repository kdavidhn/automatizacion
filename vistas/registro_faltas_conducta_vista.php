<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=227; 


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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A registro de faltas');
}
if (permisos::permiso_insertar($Id_objeto)==0)
  {
  $_SESSION["btnagregar"]="hidden";
  }
else
  {
    $_SESSION["btnagregar"]="";
  }
if (permisos::permiso_modificar($Id_objeto)==0)
  {
  $_SESSION["btnGuardar2"]="hidden";
  }
else
  {
    $_SESSION["btnGuardar2"]="";
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

         <h1>Registro de Faltas </h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
             
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
<!--Contenido -->
      <!-- Content Wrapper. Contains page content -->
      <div class="card card-default">        
        <!-- Main content -->
        <section class="content">
            <div class="card-header">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 align="right"><button class="btn btn-success"  name="btnagregar" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Nuevo Falta</button>
                            <button class="btn btn-primary"  name="btnconstancia" id="btnconstancia"  onclick="mostrarform2(true)"><i class="fa fa-plus-circle"></i> Generar Constancia Alumno</button></h1>
                          

                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Editar</th>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Tipo Falta</th>
                            <th>Nombre Alumno</th>
                            <th>Cuenta</th>
                            <th>Descripción</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>
                    <div  id="formularioregistros">
                        <!-- AQUI INICIAL EL FORMULARIO -->
                        <form name="formulario" id="formulario" method="POST">
                          
                          <!-- Card 1 -->
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Tipo de Falta y Fecha</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                <div class="row">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Tipo de Falta:</label>
                  <input class="form-control" type="hidden" id="id_falta" name="id_falta"  required/>
                  <select class="form-control select2" name="id_tipo_falta" id="id_tipo_falta" style="width: 100%;" required="">
                                <option value="0" disabled="disabled" >Seleccione una Falta:</option>
                                  <?php
                                    $query = $mysqli -> query ("SELECT * FROM tbl_voae_tipos_faltas where condicion = 1");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_falta'].'"> '.$resultado['nombre_falta'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <label>Fecha Falta:</label>
                  <input type="date" max="<?php $hoy=date("Y-m-d"); echo $hoy;?>" class="form-control" name="fch_falta" id="fch_falta" maxlength="256" >
                </div>
                </div>
                </div>
                </div>
                

                <!-- Card 2 -->
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Alumno y Descripción</h3>
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
                                <option  value="0" disabled="disabled">Seleccione un Alumno:</option>
                                  <?php
                                    $query = $mysqli -> query ("select tbl_personas.id_persona, concat(tbl_personas.nombres,' ',tbl_personas.apellidos) AS nombres, tbl_personas_extendidas.valor from tbl_personas join tbl_personas_extendidas on tbl_personas.id_persona = tbl_personas_extendidas.id_persona Where id_tipo_persona=2 and id_atributo=12;");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_persona'].'"> '.$resultado['nombres'].'-----'.$resultado['valor'].'</option>' ;
                                    }
                                  ?>
                              </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Descripción:</label>
                  <input class="form-control" minlength="5" maxlength="200" type="text" id="descripcion" name="descripcion"  style="text-transform: uppercase;" onkeypress="return soloLetras(event)" required placeholder="Descripción" />
                </div>
                </div>
                </div>
                </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" name= "btnGuardar" id="btnGuardar" ><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>

                    <div  id="formularioregistros2">
             
                <form name="formulario2" id="formulario2" method="POST" action="../Controlador/generar_conducta_cve_pdf.php">
                <!-- Card 1 -->
                
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Sección Alumno (Se enlistan únicamente los alumnos que no tienen faltas)</h3>
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
                  <select class="form-control-lg select2" id= "id_persona" style="width: 100%;" name="id_persona" required="">
                                <option  value="0" disabled="disabled">Seleccione un Alumno:</option>
                                  <?php
                                    $query = $mysqli -> query ("Select tbl_personas.id_persona, concat(tbl_personas.nombres,' ',tbl_personas.apellidos) AS nombres, tbl_personas_extendidas.valor from tbl_personas join tbl_personas_extendidas on tbl_personas.id_persona = tbl_personas_extendidas.id_persona Where id_tipo_persona=2 and id_atributo=12 AND not exists (select id_persona_alumno from tbl_voae_faltas_conductas where tbl_voae_faltas_conductas.id_persona_alumno = tbl_personas.id_persona);");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_persona'].'"> '.$resultado['nombres'].'-----'.$resultado['valor'].'</option>' ;
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
                  <h3 class="card-title">Tipo de Conducta</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Conducta:</label>
                 <input disabled class="form-control" minlength="5" maxlength="200" type="text" id="conducta" name="conducta"  style="text-transform: uppercase;" onkeypress="return soloLetras(event)" required placeholder="EXCELENTE CONDUCTA" />
                </div>
                </div>
                </div>

                
                
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-primary pull-right" type="submit" name="btnGuardar2" id="btnGuardar2"><i class="fas fa-file-pdf"></i> Generar Constancia</button>
                  
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
 

<script type="text/javascript" src="../js/registro_faltas.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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


