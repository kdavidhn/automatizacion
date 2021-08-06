<?php


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=119; 


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
      window.location = "../vistas/pagina_inicio_vista.php";

       </script>'; 
}else{
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A Memorandums');
}

if (permisos::permiso_insertar($Id_objeto)==0)
  {
  $_SESSION["btnagregar"]="disabled";
  }
else
  {
    $_SESSION["btnagregar"]="";
  }
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

         <h1>Memoramdums</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <!--li class="breadcrumb-item active"><a href="../vistas/menu_administracion_cve_vista.php">Administrar Módulo CVE</a></li-->
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
                          <h1 style="text-align:right;"><button class="btn btn-success" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Memorandum</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                       <!--div class="box-header with-border">
                          <h1 align="left"><form method="post"  action="../Controlador/memorandum_cve_pdf_controlador.php"><button  class="btn btn-danger " id="pdf"> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;">Exportar a PDF</a> </button></h1></form>
                       </div-->

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>N_Memorandum</th>
                            <th>Tipo de Memorandum</th>
                            <th>Envia</th>
                            <th>Recibe</th>
                            <th>Fecha</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>

              <div class="card" style="height: 500px;"  id="formularioregistros">
                    <!-- AQUI INICIA EL FORMULARIO PARA UN MEMORANDUM -->
              <form name="formulario" id="formulario" method="POST">
               <input type="hidden" name="id_memo" id="id_memo"> <!-- ID_MEMO OCULTO-->

                    <!-- Card 1 Nombre de memorandum y ultimo memo -->
                    <div class="card card-default">
                      <div class="card-header bg-gradient-dark">
                        <h3 class="card-title">Numero de Memorandum</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /. card-header-->
                      <div class="card-body">
                        <div class="row">
                          <!-- N MEMORANDUM -->
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>N. DE MEMORANDUM</label>
                              <input type="text" class="form-control" name="no_memo" id="no_memo" style="text-transform: uppercase;" 
                                placeholder="N° MEMORANDUM" minlength="3" maxlength="50" onkeypress="return soloLetras(event)" 
                                oncopy="return false" onpaste="return false" " pattern="^[a-zA-Z]{2}-[0-9]{4}$" 
                                title="Introduce las letras NM o MN seguido de un guion - y por ultimo un numero de 4 digitos "  required="" />
                            </div>
                          </div>
                          <!-- ULTIMO  MEMORANDUM -->
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>ULTIMO MEMORANDUM</label>
                              <input type="text" class="form-control" disabled="disabled" value = <?php
                               $query = $mysqli->query("SELECT * FROM tbl_voae_memorandums ORDER BY id_memo DESC LIMIT 1");
                                 while ($resultado = mysqli_fetch_array($query)) {
                                  echo ' ' .  $resultado['no_memo'] . ' ';
                                 }
                                ?>
                                />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Card 2 sELECT TIPO DE MEMO -->
                    <div class="card card-default">
                      <div class="card-header bg-gradient-dark">
                        <h3 class="card-title">Tipo de Memerandum</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /. card-header-->
                      <div class="card-body">
                        <div class="row">
                          <!-- SELECT TIPO M -->
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>SELECCIONE EL TIPO DE MEMORANDUM</label>
                              <select class="form-control select2" name="id_tipo_memo" id="id_tipo_memo" style="width: 100%;" required="">
                                 <option value="0" disabled="disabled" oncopy="return false" onpaste="return false">SELECCIONE EL TIPO DE MEMORANDUM:</option>
                                  <?php
                                  $query = $mysqli->query("SELECT * FROM tbl_voae_tipo_memorandum WHERE condicion=1");
                                  while ($resultado = mysqli_fetch_array($query)) {
                                  echo '<option value="' . $resultado['id_tipo_memorandum'] . '"> ' . $resultado['nombre_tipo_memorandum'] . '</option>';
                                   }
                                  ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                   <!-- Card 3 REMITENTE Y DESTINATARIO -->
                    <div class="card card-default">
                      <div class="card-header bg-gradient-dark">
                        <h3 class="card-title">Quien Remite y Quien Recibe</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /. card-header-->
                      <div class="card-body">
                        <div class="row">
                          <!-- REMITENTE -->
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>REMITENTE </label>
                              <input type="text" class="form-control" name="remitente" id="remitente" 
                              style="text-transform: uppercase;" placeholder="REMITENTE" minlength="3" 
                              maxlength="50" onkeypress="return soloLetras(event)" oncopy="return false" 
                              onpaste="return false" required="" />
                            </div>
                          </div>
                           <!-- DESTINATARIO -->
                           <div class="col-sm-6">
                            <div class="form-group">
                              <label>DESTINATARIO </label>
                              <input type="text" class="form-control" name="destinatario" id="destinatario" 
                              style="text-transform: uppercase;" placeholder="DESTINATARIO" minlength="3" 
                              maxlength="50" onkeypress="return soloLetras(event)" oncopy="return false" 
                              onpaste="return false" required="" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Card 4 ASUNTO Y CONTENIDO -->
                    <div class="card card-default">
                      <div class="card-header bg-gradient-dark">
                        <h3 class="card-title">Asunto y Contendio del Memorandum</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /. card-header-->
                      <div class="card-body">
                        <div class="row">
                          <!-- ASUNTO -->
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label>ASUNTO </label>
                              <input type="text" class="form-control" name="asunto" id="asunto" 
                              style="text-transform: uppercase;" placeholder="ASUNTO" oncopy="return false" 
                              onpaste="return false" required="" />
                            </div>
                          </div>
                           <!-- CONTENIDO -->
                           <div class="col-sm-8">
                            <div class="form-group">
                              <label>CONTENIDO </label>
                              <textarea class="form-control" name="contenido" id="contenido" rows="8"
                              style="text-transform: uppercase;" placeholder="DESCRIPCION / CONTENIDO" 
                              minlength="3" onkeypress="return soloLetras(event)" oncopy="return false" 
                              onpaste="return false" required="" ></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- BOTON DE GUARDAR -->
                 <h3 style="text-align: center;"><button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                  <!-- BOTON DE CANCELAR -->
                   <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button></h3>

              </form>
               </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
</div>
<script type="text/javascript" src="../js/memorandum.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toUpperCase(),
      letras = " ÀÈÌÒÙABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789",
      especiales = [8, 37, 39, 44, 45, 46, 58, 59],
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

<!--script>
document.getElementById("formularioregistros").addEventListener("submit", function(e) {
  var estado = document.getElementById("no_memo").value;
  if (estado.match("^[a-zA-Z]{2}-[0-9]{4}$")) {
    alert("Cumple el patron");
  } else {
    alert("No cumple el patron");
    e.preventDefault(); // no se envia el formulario
  }
})
</script-->

</body>
</html>
