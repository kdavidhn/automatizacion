<?php


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=116; 


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
                          <h1 align="right"><button class="btn btn-success" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Memorandum</button></h1>
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

                    <div class="card" style="height: 500px;" id="formularioregistros">
                      
                        <!-- AQUI INICIA EL FORMULARIO PARA UN MEMORANDUM -->

                        <form name="formulario" id="formulario" method="POST"> 

                          <input type="hidden" name="id_memo" id="id_memo"> <!-- ID_MEMO OCULTO-->
                          
                        <div class="row">
                          <div class="form-group  col-md-4">
                            <label>N° DE MEMORANDUM:</label>
                            <input type="text" class="form-control" name="no_memo" id="no_memo" style="text-transform: uppercase;" placeholder="N° MEMORANDUM" minlength="3" maxlength="50" onkeypress="return soloLetras(event)" required="" />
                          </div>

                          <!--SELECT PARA TIPO DE MEMORANDUM -->
                          <div class="form-group col-md-4">
                            <label>TIPO DE MEMORANDUM:</label>
                            <select class="form-control select2" name="id_tipo_memo" id="id_tipo_memo" style="width: 100%;" required="">
                                <option value="0" disabled="disabled" >SELECCIONE EL TIPO DE MEMORANDUM:</option>
                                  <?php
                                    $query = $mysqli -> query ("SELECT * FROM tbl_voae_tipo_memorandum");
                                    while ($resultado = mysqli_fetch_array($query)) {
                                      echo '<option value="'.$resultado['id_tipo_memorandum'].'"> '.$resultado['nombre_tipo_memorandum'].'</option>' ;
                                    }
                                  ?>
                              </select>
                          </div>
                        </div>

                          
                        <div class="row">
                          <!-- CAMPO REMITENTE-->
                          <div class="form-group col-md-4 ">
                            <label> QUIEN REMITE:</label>
                            <input type="text" class="form-control" name="remitente" id="remitente" style="text-transform: uppercase;" placeholder="REMITENTE" minlength="3" maxlength="50" onkeypress="return soloLetras(event)" required="" />
                          </div>

                          <!-- DESTINATARIO-->
                          <div class="form-group col-md-4">
                            <label> QUIEN RECIBE:</label>
                            <input type="text" class="form-control" name="destinatario" id="destinatario" style="text-transform: uppercase;" placeholder="DESTINATARIO" minlength="3" maxlength="50" onkeypress="return soloLetras(event)" required="" />
                          </div>
                        </div>

                        <div class="row">
                          <!-- FECHA DE MEMORANDUM-->
                          <div class="form-group  col-md-4">
                            <label> FECHA:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" style="text-transform: uppercase;" placeholder="FECHA" required="" />
                          </div>
                          <!-- ASUNTO-->
                          <div class="form-group  col-md-4">
                            <label> ASUNTO:</label>
                            <input type="text" class="form-control" name="asunto" id="asunto" style="text-transform: uppercase;" placeholder="ASUNTO" required="" />
                          </div>
                        </div>

                          <!-- CONTENIDO-->
                          <div class="form-group col-md-12">
                            <label> DESCRIPCION DEL MEMORAMDUM:</label>
                            <input type="textarea" class="form-control" name="contenido" id="contenido" style="text-transform: uppercase;" placeholder="DESCRIPCION / CONTENIDO" minlength="3" onkeypress="return soloLetras(event)" required="" />
                          </div>
                          <!--BOTON GUARDAR-->
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <!--BOTON CANCELAR-->
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
