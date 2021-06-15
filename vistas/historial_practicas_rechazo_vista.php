<?php

ob_start();


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

if (isset($_REQUEST['msj']))
{
  $msj=$_REQUEST['msj'];

  if ($msj==1)
  {


    echo '<script type="text/javascript">
    swal({
     title:"",
     text:"Lo sentimos tiene campos por rellenar",
     type: "info",
     showConfirmButton: false,
     timer: 3000
     });
     $(".FormularioAjax")[0].reset();
     </script>';
   }
     if ($msj==2)
  {


    echo '<script type="text/javascript">
    swal({
     title:"",
     text:"No se realizara ningun proceso.",
     type: "info",
     showConfirmButton: false,
     timer: 3000
     });
     $(".FormularioAjax")[0].reset();
     </script>';
   }
    
   if ($msj==4)
   {
     echo '<script type="text/javascript">
     swal({
       title:"",
       text:"Los datos  se almacenaron correctamente",
       type: "success",
       showConfirmButton: false,
       timer: 3000
       });
       $(".FormularioAjax")[0].reset();
       </script>';
   }
   if ($msj==3)
   {
            echo '<script type="text/javascript">
       swal({
         title:"",
         text:"Lo sentimos no se pudieron guardar los datos",
         type: "error",
         showConfirmButton: false,
         timer: 3000
         });
         $(".FormularioAjax")[0].reset();
         </script>';


     } 
  }

$Id_objeto=28 ; 




$visualizacion= permiso_ver($Id_objeto);



if ($visualizacion==0)
{
 // header('location:  ../vistas/menu_permisos_usuario_vista.php');
	echo '<script type="text/javascript">
	swal({
		title:"",
		text:"Lo sentimos no tiene permiso de visualizar la pantalla",
		type: "error",
		showConfirmButton: false,
		timer: 3000
		});
		window.location = "../vistas/menu_practica_vista.php";

		</script>';
	}

	else

	{
		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A  HISTORIAL DE PRACTICA RECHAZADAS ');
	

        $sql_tabla_estudiantes_practica="select pr.id_practica_rechazo,  p.nombre,p.documento,pr.nombre_empresa,pr.motivo
        from  tbl_personas p, tbl_practica_rechazo pr where p.id_persona=pr.id_persona";
  $resultadotabla_estudiantes_practica = mysqli_fetch_assoc($mysqli->query($sql_tabla_estudiantes_practica));

        $_SESSION['txt_estudiante']=$resultadotabla_estudiantes_practica['nombre'];
        $_SESSION['cuenta']=$resultadotabla_estudiantes_practica['documento'];
        //$_SESSION['estado_vin']=$resultadotabla_estudiantes_practica['estado_vinculacion'];
        //$_SESSION['estado_coor']=$resultadotabla_estudiantes_practica['estado_coordinacion'];
                $resultadotabla_estudiantes_practica = $mysqli->query($sql_tabla_estudiantes_practica);

 if (isset($_REQUEST['cuenta']))
        {
  
$sql_datos_modal="select p.nombre,p.documento from  tbl_personas p, tbl_subida_documentacion sd where p.id_persona=sd.id_persona and p.documento=$_REQUEST[cuenta]";
          $resultado_datos = mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION['txt_estudiante']=$resultado_datos['nombre'];
          $_SESSION['cuenta']=$resultado_datos['documento'];

        ?>
        <script>
          $(function(){
            $('#modal_documentacion_estudiante').modal('toggle')

          })



        </script>;
        <?php 
 //Documentos enlistado.
          $listar=null;
          $directorio=opendir("../Documentacion_practica/$_SESSION[cuenta]/");
          while ($elemento =readdir($directorio)) 
          {
            if ($elemento !='.' and $elemento !='..') {


              if (is_dir("Documentacion_practica/$_SESSION[cuenta]/".$elemento)) 
              {
                $listar .="<li> <a href='../Documentacion_practica/$_SESSION[cuenta]/$elemento' target='_blank'>$elemento/</a></li>";

              }

              else {
                $listar .="<li> <a href='../Documentacion_practica/$_SESSION[cuenta]/$elemento' target='_blank'>$elemento</a></li>";

              } 
            }
          }
        }



 if (isset($_REQUEST['cuentahistorial']))
        {
  
$sql_datos_modal="select p.nombre,p.documento,pr.nombre_empresa,pr.motivo
        from  tbl_personas p, tbl_practica_rechazo pr where p.id_persona=pr.id_persona and pr.id_practica_rechazo=$_REQUEST[cuentahistorial]";
          $resultado_datos = mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION['txt_estudiante']=$resultado_datos['nombre'];
          $_SESSION['txt_motivo']=$resultado_datos['motivo'];

        ?>
        <script>
          $(function(){
            $('#modal_historial_estudiante').modal('toggle')

          })



        </script>;
        <?php 
 //Documentos enlistado.
          $listar=null;
          $directorio=opendir("../Documentacion_practica/$_SESSION[cuenta]/");
          while ($elemento =readdir($directorio)) 
          {
            if ($elemento !='.' and $elemento !='..') {


              if (is_dir("Documentacion_practica/$_SESSION[cuenta]/".$elemento)) 
              {
                $listar .="<li> <a href='../Documentacion_practica/$_SESSION[cuenta]/$elemento' target='_blank'>$elemento/</a></li>";

              }

              else {
                $listar .="<li> <a href='../Documentacion_practica/$_SESSION[cuenta]/$elemento' target='_blank'>$elemento</a></li>";

              } 
            }
          }
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
                  <h1>Historial de practicas rechazadas </h1>
                </div>
                <div class="RespuestaAjax"></div>



                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Vinculacion</li>

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

              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Expedientes</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tabla" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                       <th>NOMBRE COMPLETO</th>
                       <th>CUENTA</th>   
                       <th>EMPRESA</th>                
                       <th>EXPEDIENTE</th>  
                        <th>MOTIVO</th>                
              

                     </tr>
                   </thead>
                   <tbody>
                    <?php 
                     while($row = $resultadotabla_estudiantes_practica->fetch_array(MYSQLI_ASSOC)) { ?>
                      <tr>
                        <td><?php echo strtoupper($row['nombre']); ?></td>
                        <td><?php echo $row['documento']; ?></td>
                        <td><?php echo $row['nombre_empresa']; ?></td>


                        <td style="text-align: center;">

                         <a href="../vistas/historial_practicas_rechazo_vista.php?cuenta=<?php echo $row['documento']; ?>" class="btn btn-primary btn-raised btn-xs">
                          <i class="fas fa-eye"  title=""  ></i>
                        </a>
                      </td>
                         <td style="text-align: center;">

                       <a href="../vistas/historial_practicas_rechazo_vista.php?cuentahistorial=<?php echo $row['id_practica_rechazo']; ?>" class="btn btn-primary btn-raised btn-xs">
                        <i class="fas fa-edit"  title="Verificar documentacion "  ></i>
                      </a>
                    </td>

                  


                  </tr>
                <?php  
              }?>
            </tbody>
          </table>
        </div>

        <!-- /.card-body -->
      </div>


      <div class="RespuestaAjax"></div>

    </div>
  </section>





</div>


<form action="" method="post"  data-form="update" autocomplete="off"  >



 <div class="modal fade" id="modal_documentacion_estudiante">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Visualización de Documentación </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>




      <!--Cuerpo del modal-->
      <div class="modal-body">
        <div class="card-body">

          <label>Estudiante</label>
          <input class="form-control" type="text" id="txt_estudiante" name="txt_estudiante" value="<?php echo strtoupper($_SESSION['txt_estudiante']) ?>" readonly="readonly">


          <ul>
            <?php echo $listar ?>

          </ul>
        </div>
      </div>




      <!--Footer del modal-->
      <div class="modal-footer justify-content-between">

      </div>


    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="RespuestaAjax"></div>

<!-- /.  finaldel modal -->


</form>



<form action="../controlador/historial_practica_rechazo_controlador.php" method="post"  data-form="update" autocomplete="off"  >



 <div class="modal fade" id="modal_historial_estudiante">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Motivo de Rechazo </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>




      <!--Cuerpo del modal-->
      <div class="modal-body">
        <div class="card-body">
<div class="col-sm-12">
               <div class="form-group">
          <label>Estudiante</label>
          <input class="form-control" type="text" id="txt_estudiante" name="txt_estudiante" value="<?php echo strtoupper($_SESSION['txt_estudiante']) ?>" readonly="readonly">
</div></div>
          
   <input class="form-control" type="text" id="txt_estudiante_cuenta" name="txt_estudiante_cuenta" hidden="true"value="<?php echo strtoupper( $_SESSION['cuenta']) ?>" readonly="readonly">
 <div class="col-sm-12">
              <div class="form-group">
                <label>Motivo</label>


              </div>
            </div>
         
              <div class="col-sm-12">
               <div class="form-group">
              <textarea class="form-control" id="txt_motivo" name="txt_motivo" style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)"  rows="4" cols="50" readonly="readonly" ><?php echo strtoupper($_SESSION['txt_motivo']) ?>

                </textarea>
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
<div class="RespuestaAjax"></div>

<!-- /.  finaldel modal -->


</form>


<script type="text/javascript">


 $(function () {

  $('#tabla').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
  });
});


</script>


	</body>

	</html>

