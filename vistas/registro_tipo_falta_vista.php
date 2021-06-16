<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
$Id_objeto = 145;




$visualizacion = permiso_ver($Id_objeto);

if ($visualizacion == 0) {
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_docentes_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A REGISTRAR TIPO DE FALTA CVE.');


  // if (permisos::permiso_insertar($Id_objeto) == '1') {
  //   $_SESSION['btn_guardar_registro_docentes'] = "";
  // } else {
  //   $_SESSION['btn_guardar_registro_docentes'] = "disabled";
  // }
}



ob_end_flush();


?>


<!DOCTYPE html>
<html>
<head>
  <title></title>



</head>

<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Registro de Tipos de Faltas</h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="../vistas/menu_administracion_cve_vista.php">Administración del Módulo CVE</a></li>
                    <li class="breadcrumb-item"><a href="../vistas/mantenimiento_tipos_faltas_vista.php">Mantenimiento de Tipos de Faltas</a></li>
                </ol>
            </div>
            <div class="RespuestaAjax">
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
  
        <!-- pantalla 1 --> 
        <form action="../Controlador/guardar_tipo_falta_controlador.php" method="post"  data-form="save" class="FormularioAjax" autocomplete="off">

            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Nuevo Tipo de falta</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>


                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ingrese el nombre del tipo de falta</label>
                                <input class="form-control" type="text" id="txt_tipo_falta" name="txt_tipo_falta" required="" maxlength="40" style="text-transform: uppercase" onkeyup="Espacio(this, event)"  onkeypress="return Letras(event)"  onkeypress="return comprobar(this.value, event, this.id)">
                            </div>

                            <div class="form-group">
                                <label>Descripcion</label>
                                <input class="form-control" type="text" id="txt_descripcion_tipo_falta" name="txt_descripcion_tipo_falta" required="" maxlength="195"style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)"  onkeypress="return Letras(event)"  onkeypress="return comprobar(this.value, event, this.id)">
                            </div>

                            <p class="text-center" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary" id="btn_guardar_tipos_faltas" name="btn_guardar_tipos_faltas" 
                                <?php echo $_SESSION['btn_guardar_roles']; ?>  >
                                <i class="zmdi zmdi-floppy"></i> Guardar</button>
                            </p>

                        </div>
                    </div>
                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                </div>
            </div>
            
        
            <div class="RespuestaAjax">
            </div>
        </form>
           
    </div>
</section>

</div>




  
</body>
</html>