
<?php

ob_start();


session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');





        $Id_objeto=1 ; 


$visualizacion= permiso_ver($Id_objeto);



if ($visualizacion==0)
 {
   echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_pregunta_vista.php";

                            </script>';
}

else

{
  
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Creacion de Preguntas');


if (permisos::permiso_insertar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_pregunta']="";
}
else
{
    $_SESSION['btn_guardar_pregunta']="disabled";
 }
/*


 if (isset($_REQUEST['msj']))
 {


  $msj=$_REQUEST['msj'];
if ($msj==1) {
   echo '<script> alert("Pregunta creada correctamente")</script>';
}
   
   if ($msj==2)
    {
   echo '<script> alert("Pregunta ya esiste, intenta de nuevo ")</script>';
    }
}*/


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
            <h1>Preguntas de Seguridad</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Seguridad</li>
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
      
<form action="../Controlador/guardar_pregunta_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Nueva pregunta</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Ingrese la pregunta</label>
                    <input class="form-control" type="text" id="txt_Pregunta" name="txt_Pregunta" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" >
                </div>

                <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="checkbox"  id="txt_checkboxactivo" name="txt_checkboxactivo" value="true">
                        <label for="txt_checkboxactivo">Activo
                        </label>
                      </div>
                </div>

              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_pregunta" <?php echo $_SESSION['btn_guardar_pregunta']; ?>  ><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>

              </div>
            </div>
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

</body>
</html>