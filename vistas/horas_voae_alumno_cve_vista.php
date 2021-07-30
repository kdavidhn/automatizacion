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

$cuenta = $_POST['cuenta'];
$nombre = $_POST['nombre'];


$_SESSION['cuenta'] = $cuenta;



$valor = "select nombre_alumno from view_horas_voae WHERE cuenta='$cuenta'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

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
      window.location = "../vistas/menu_administracion_cve_vista.php";

       </script>'; 
}else{
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A Mantenimiento de ambitos');
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

         <h1><p>Detalle Horas Alumno </p></h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/horas_voae_cve_vista.php">Horas Voae Gestion</a></li>
              <li class="breadcrumb-item active"><a>Detalle Horas Alumno </a></li>
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
                          <section><h5><b><i><p>Nombre Alumno: <?php echo $nombre;?></p></i></b></h5>
                          <h5><b><i><p>Cuenta: <?php echo $cuenta;?></i></b></p></h5>
                          </section>
                    </div>
                    <form method="post" action="../Controlador/reporte_faltas_conducta_controlador.php"> 
                                <button  class="btn btn-success " id="pdfHtml5" name="pdfHtml5"> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;">Exportar a PDF</a> </button>
                                <input type="text" class="form-control"  readonly hidden>

                            </form>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre Actividad</th>
                            <th>Fecha Realización</th>
                            <th>Ámbito</th>
                            <th>Horas</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>
                     <!-- AQUI INICIAL EL FORMULARIO -->
                     <form action="../vistas/Controlador/historial_alumno_cve_controlador.php" method="POST">
                     <input type="hidden" name="id_asistencia_tbl" id="id_asistencia_tbl">
                     </form>


                        
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  </div> 
 

<script type="text/javascript" src="../js/horas_voae_detalle.js"></script>
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
 


</body>
</html>
