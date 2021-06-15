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


     $Id_objeto=20 ; 

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
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REVISION DE DOCUMENTACION PRACTICA ');


        if (permisos::permiso_insertar($Id_objeto)=='1')
        {
          $_SESSION['btn_gestion_estudiantes_practica']="";

        }
        else
        {
          $_SESSION['btn_gestion_documentacion']="disabled";

        }



        $sql_tabla_estudiantes_practica="select concat(p.nombres,' ', p.apellidos) as nombre ,px.valor,
        CASE sd.estado_vinculacion
        WHEN 0 then 'DOCUMENTACION INCOMPLETA'
        WHEN 1 THEN 'ENVIADO A VINCULACION'
        WHEN 2 THEN 'REINGRESO DE DOCUMENTACION'
        WHEN 3 THEN 'CAMBIO DE EMPRESA'


        ELSE
        'PENDIENTE' END AS PROCESO,sd.estado_coordinacion
        from  tbl_personas p, tbl_subida_documentacion sd , tbl_personas_extendidas px  where p.id_persona=px.id_persona AND sd.id_persona=p.id_persona and px.id_atributo=12";
         $resultadotabla_estudiantes_practica =$mysqli->query($sql_tabla_estudiantes_practica);

             //$_SESSION['estado_vin']=$resultadotabla_estudiantes_practica['estado_vinculacion'];
        //$_SESSION['estado_coor']=$resultadotabla_estudiantes_practica['estado_coordinacion'];
             
        $resultadotabla_estudiantes_practica = $mysqli->query($sql_tabla_estudiantes_practica);

        if (isset($_REQUEST['cuenta']))
        {
          $sql_datos_modal="select concat(p.nombres,' ', p.apellidos) as nombre,px.valor from  tbl_personas p, tbl_subida_documentacion sd , tbl_personas_extendidas px where p.id_persona=px.id_persona AND sd.id_persona=p.id_persona AND   px.id_atributo=12 and px.valor=$_REQUEST[cuenta]";
          $resultado_datos =mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION["txt_estudiante"]=$resultado_datos['nombre'];
          $_SESSION["cuenta"]=$resultado_datos['valor'];

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

        if (isset($_REQUEST['cuentavinculacion']))
        {

          $sql_datos_modal="select concat(p.nombres,' ', p.apellidos) as 'nombre',px.valor, sd.estado_vinculacion  from  tbl_personas p, tbl_subida_documentacion sd , tbl_personas_extendidas px 
      where p.id_persona=px.id_persona and sd.id_persona=p.id_persona AND   px.id_atributo=12 and px.valor=$_REQUEST[cuentavinculacion]";
         $resultado_datos =mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION["txt_estudiante"]=$resultado_datos['nombre'];
          $_SESSION["cuenta"]=$resultado_datos['valor'];

          $_SESSION["estado_vinculacion"]=$resultado_datos['estado_vinculacion'];

          if ($_SESSION['estado_vinculacion']=='1') {
              echo '<script type="text/javascript">
       swal({
         title:"",
         text:"La revision de documentos ya fue enviada a Jefatura.",
         type: "info",
         showConfirmButton: false,
         timer: 3000
         });

         </script>';
     
           
               }
               elseif ($_SESSION['estado_vinculacion']=='3') 
               {
                  echo '<script type="text/javascript">
       swal({
         title:"",
         text:"Esperando a que estudiante suba documentacion.",
         type: "info",
         showConfirmButton: false,
         timer: 3000
         });

         </script>';
               }
               else
               {
                ?>
          <script>
            $(function(){
              $('#modal_aprobacion_practica').modal('toggle')

            })



          </script>;

          <?php
          
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
                  <h1>Estudiantes en Práctica Profesional Supervisada  </h1>
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
                       <th>PROCESO</th>                

                       <th>EXPEDIENTE</th>                
                       <th>CHECKLIST</th>                

                     </tr>
                   </thead>
                   <tbody>
                    <?php 
                    while($row = $resultadotabla_estudiantes_practica->fetch_array(MYSQLI_ASSOC)) { 
if ($row['estado_coordinacion']<>'1' and $row['estado_coordinacion']<>'0' ) {
                      ?>
                      <tr>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['valor']; ?></td>
                        <td><?php echo $row['PROCESO']; ?></td>


                        <td style="text-align: center;">

                         <a href="../vistas/gestion_documentos_practica_vista.php?cuenta=<?php echo $row['valor']; ?>" class="btn btn-primary btn-raised btn-xs">
                          <i class="fas fa-eye"  title="Visualizar expediente"  ></i>
                        </a>
                      </td>

                      <td style="text-align: center;">

                       <a href="../vistas/gestion_documentos_practica_vista.php?cuentavinculacion=<?php echo $row['valor']; ?>" class="btn btn-primary btn-raised btn-xs">
                        <i class="fas fa-edit"  title="Verificar documentacion "  ></i>
                      </a>
                    </td>

                  </tr>
                <?php  } } ?>
              </tbody>
            </table>
          </div>

          <!-- /.card-body -->
        </div>


        <div class="RespuestaAjax"></div>

      </div>
    </section>





  </div>

  <!--Creacion del modal-->

  <form action="../Controlador/guardar_documentacion_practica_controlador.php" method="post"  data-form="update" autocomplete="off"  >



   <div class="modal fade" id="modal_aprobacion_practica">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Gestión de Documentación </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>



        <!--Cuerpo del modal-->
        <div class="modal-body">
          <div class="card-body">
            <div class="row">
                 <div class="col-sm-12">
               <div class="form-group">
 <label>Estudiante</label>
          <input class="form-control" type="text" id="txt_estudiante_documento" name="txt_estudiante_documento"  style="text-transform: uppercase"  value="<?php echo  $_SESSION['txt_estudiante'] ;?>" readonly="readonly">


</div></div>
   <input class="form-control" type="text" id="txt_estudiante_cuenta" name="txt_estudiante_cuenta" hidden="true"value="<?php echo strtoupper($_SESSION['cuenta']) ?>" readonly="readonly">

 

              <div class="col-sm-12">
               <div class="form-group">
                <label>Aprobar documentación</label>
                <select class="form-control" name="cb_aprobar" id="cb_aprobar" onchange="Vinculacion();">
                  <option value="0">Seleccione una opcion:</option>
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>

                </select>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
                <label>Observación</label>


              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <textarea class="form-control" id="txt_observacion_documentacion" name="txt_observacion_documentacion" style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)"  rows="4" cols="50"   minlength="20" >

                </textarea>

              </div>
            </div>

          </div>
        </div>
      </div>




      <!--Footer del modal-->
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btn_gestion_estudiantes_practica" name="btn_gestion_estudiantes_practica" <?php echo $_SESSION['btn_gestion_estudiantes_practica']; ?>>Guardar Cambios</button>
      </div>


    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="RespuestaAjax"></div>

<!-- /.  finaldel modal -->


</form>









<!--Creacion del modal-->

<form action="" method="post"  data-form="update" autocomplete="off"  >

                 

 <div class="modal fade" id="modal_documentacion_estudiante">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación de Documentación </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>




      <!--Cuerpo del modal-->
      <div class="modal-body">
        <div class="card-body">

          <label>Estudiante</label>
          <input class="form-control" type="text" id="txt_estudiante" name="txt_estudiante" style="text-transform: uppercase"  value="<?php echo  $_SESSION['txt_estudiante'] ;?>"  readonly="readonly">
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
<script type="text/javascript">


  $('#txt_observacion_documentacion').prop("readonly", true);


  function Vinculacion()
  {
    /* Para obtener el valor */
    var aprobar = document.getElementById("cb_aprobar").value;


    if (aprobar == "NO") {
      $('#txt_observacion_documentacion').prop("readonly", false);
document.getElementById("txt_observacion_documentacion").value ="";
    }
    else {
     $('#txt_observacion_documentacion').prop("readonly", true);

   }

 }



</script>

</body>

</html>
