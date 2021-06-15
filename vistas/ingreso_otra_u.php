<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$sql="select * from tbl_centros_regionales";
$resultado = $mysqli->query($sql);

$sql1= "select * from tbl_facultades";
$resultado1= $mysqli->query($sql1);

$Id_objeto=30; 


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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A SOLICITUD CAMBIO DE CARRERA');
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
            <h1>Cambio de Carrera de Estudiante de otras Universidades</h1>
          </div>
         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/menu_cambio_carrera.php">Admisión a la Carrera</a></li>
              <li class="breadcrumb-item"><a href="../pdf/otra_universidad.php" target="_blank">Requisitos</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="container-fluid">
  <!-- pantalla 1 -->
      
<form action="../Controlador/cambio_carrera_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax" enctype="multipart/form-data">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Ingreso a la Carrera</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" id="txt_nombre" name="txt_nombre" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="30" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellido</label>
                            <input class="form-control" type="text" id="txt_apellido" name="txt_apellido" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="30" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Correo Electronico</label>
                            <input class="form-control" type="text" id="txt_correo" name="txt_correo" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="30" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Universidad de la que proviene</label>
                            <input class="form-control" type="text" id="txt_u" name="txt_u" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="30" >
                        </div>
                </div>

                <!-- legend -->
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Solicitud.</label>             
                            <input class="form-control" type="file" id="txt_solicitud" name="txt_solicitud">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Copia de la solicitud en línea</label>             
                            <input class="form-control" type="file" id="txt_copia" name="txt_copia">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Certificación de estudios</label>             
                            <input class="form-control" type="file" id="txt_certificado" name="txt_certificado">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Copia de Tarjeta de Identidad</label>             
                            <input class="form-control" type="file" id="txt_identidad" name="txt_identidad">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Constancia de conducta</label>             
                            <input class="form-control" type="file" id="txt_conducta" name="txt_conducta">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Fotografía</label>             
                            <input class="form-control" type="file" id="txt_fotografia" name="txt_fotografia" multiple="">
                        </div>
                </div>
                <!--fin legend-->
                
            </div>
            <p class="text-center form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_cambio_carrera" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
            </p>
          </div>



          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>
         
         
    
    <div class="RespuestaAjax"></div>
</form>

  </div>
</section>


</div>
<script>
$('input[type="file"]').on('change', function(){
  var ext = $( this ).val().split('.').pop();
  if ($( this ).val() != '') {
    if(ext == "pdf" || ext == "PDF"){
      if($(this)[0].files[0].size > 1048576){
        swal({
                     title:"",
                     text:"excede el tamaño permitido...",
                     type: "error",
                     showConfirmButton: false,
                     timer: 2000
                  });
             
        $(this).val('');
      }
    }
    else
    {
      $( this ).val('');
      swal({
                     title:"",
                     text:"Extensión no permitida: " + ext,
                     type: "error",
                     showConfirmButton: false,
                     timer: 2000
                  });
    }
  }
});
</script>

</body>
</html>