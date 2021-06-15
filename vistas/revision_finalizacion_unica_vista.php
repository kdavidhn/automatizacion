<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=34; 
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
  if (isset($_GET['alumno'])){
    $sqltabla = json_decode( file_get_contents("http://informaticaunah.com/automatizacion/api/finalizacion_practica.php?alumno=".$_GET['alumno']), true );
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO '.$sqltabla["ROWS"][0]['nombres'].'');
  }
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
            <h1>Solicitud de Finalización</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/revision_finalizacion_vista.php">Solicitudes de Finalizacion de Practica</a></li>
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
      
<form action="../Controlador/finalizacion_practica_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del Estudiante</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre del alumno</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['nombres'].''.$sqltabla["ROWS"][0]['apellidos'] ?>" type="text" id="txt_nombre" name="txt_nombre1" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;" >
                        </div>
                </div>
                
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Número de Cuenta</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['valor'] ?>" type="text" id="txt_cuenta" name="txt_cuenta" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['correo'] ?>" type="email" id="txt_correo" name="txt_correo" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Empresa donde realizó la práctica</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['nombre_empresa'] ?>" type="text" id="txt_empresa" name="txt_empresa" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Jefe/Encargado</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['jefe_inmediato'] ?>" type="text" id="txt_jefe" name="txt_jefe" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                        <p class="text-center form-group" style="margin-top: 20px;">
                        <a href="<?php echo $sqltabla["ROWS"][0]['archivo'] ?>" target="_blank" class="btn btn-outline-primary ">Ver Documento</a>
                        </p>
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                          <p class="text-center form-group" style="margin-top: 20px;">
                            <button type="button" data-toggle='modal' data-target='#modal1' class="btn btn-outline-primary">Expediente</button>
                          </p>
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                        <label>Observación</label>
                        <textarea class="form-control" id="txt_observacion" name="txt_observacion" rows="3"></textarea>
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Seleccione su aprobación</label>
                            <select class="form-control" name="aprobado" >
                              <option disabled selected>Aprobar</option>
                              <option value="aprobado">SI</option>
                              <option value="desaprobar">NO</option>
                            </select>
                        </div>
                </div>
                
            </div>
            <p class="text-center form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_cambio" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
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

<!-- modal --->
<div class="modal fade" id="modal1">
          <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Documentos</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


               <!--Cuerpo del modal-->
            <div class="modal-body">
   



   <div class="card-body">
            <div class="row">
               

                   <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Nombre Completo</label>
                        <input class="form-control" type="text"  maxlength="60" id="txt_nombre_alumno" name="txt_nombre_alumno"  value="<?php echo $sqltabla["ROWS"][0]['nombres'].' '.$sqltabla["ROWS"][0]['apellidos']; ?>" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly>
                        <?php 
                        $cuenta = $sqltabla["ROWS"][0]['valor'];
                         
                         $listar=null;
                         $directorio=opendir("../archivos/carta_egresado/$cuenta");
                         while ($elemento =readdir($directorio)) 
                         {
                           if ($elemento !='.' and $elemento !='..') {
               
               
                             if (is_dir("archivos/$cuenta/".$elemento)) 
                             {
                               $listar .="<li> <a href='../archivos/$cuenta/$elemento' target='_blank'>$elemento/</a></li>";
                             }
                             else {
                               $listar .="<li> <a href='../archivos/$cuenta/$elemento' target='_blank'>$elemento</a></li>";
                             } 
                           }
                         }

                        ?>
                          <ul>
                             <?php echo $listar ?>
                          </ul>
                    </div>
                   </div>


                
              </div>
            </div>
          </div>

          




            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- /.  finaldel modal -->


<!-- fin modal--->

</body>
</html>
