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
     timer: 4000
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



     $Id_objeto=21 ; 




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
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A  APROBACION/RECHAZO DE PRACTICA ');


        if (permisos::permiso_insertar($Id_objeto)=='1')
        {
          $_SESSION['btn_aprobacion_rechazo_practica']="";
        }
        else
        {
          $_SESSION['btn_aprobacion_rechazo_practica']="disabled";
        }


          



        $sql_tabla_estudiantes_practica="SELECT px.valor as valor, concat(p.nombres,' ',p.apellidos) as nombre,
        CASE 
        WHEN (sd.estado_coordinacion IS NULL and sd.estado_vinculacion='1') then
        'PENDIENTE' 
        END AS proceso,
        case
        when sd.estado_vinculacion IS NULL then 'PROCESO'
        else
        sd.estado_vinculacion end as estado_vinculacion, 
        case 
        when sd.estado_coordinacion IS NULL then 'PROCESO'
        else
        sd.estado_coordinacion end as estado_coordinacion
        from  tbl_personas p, tbl_subida_documentacion sd, tbl_personas_extendidas px where sd.id_persona=p.id_persona AND px.id_atributo=12 and px.id_persona=p.id_persona and estado_coordinacion IS NULL ";




  $resultadotabla_estudiantes_practica = mysqli_fetch_assoc($mysqli->query($sql_tabla_estudiantes_practica));

        $_SESSION['txt_estudiante']=$resultadotabla_estudiantes_practica['nombre'];
        $_SESSION['cuenta']=$resultadotabla_estudiantes_practica['valor'];
        $_SESSION['Estado_proceso']=$resultadotabla_estudiantes_practica['proceso'];
        $_SESSION['estado_vin']=$resultadotabla_estudiantes_practica['estado_vinculacion'];
        $_SESSION['estado_coor']=$resultadotabla_estudiantes_practica['estado_coordinacion'];
                $resultadotabla_estudiantes_practica = $mysqli->query($sql_tabla_estudiantes_practica);




 if (isset($_REQUEST['cuenta']))
        {
  
$sql_datos_modal="SELECT px.valor as valor, concat(p.nombres,' ',p.apellidos) as nombre from  tbl_personas p, tbl_subida_documentacion sd , tbl_personas_extendidas px where sd.id_persona=p.id_persona AND px.id_atributo=12 and px.id_persona=p.id_persona and px.valor=$_REQUEST[cuenta]";
          $resultado_datos = mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION['txt_estudiante']=$resultado_datos['nombre'];
          $_SESSION['cuenta']=$resultado_datos['valor'];

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

     if (isset($_REQUEST['cuenta_coordinacion']))
        {

          $sql_datos_modal="SELECT px.valor as valor, concat(p.nombres,' ',p.apellidos) as nombre , sd.estado_vinculacion,ep.nombre_empresa   from  tbl_personas p, tbl_subida_documentacion sd,tbl_empresas_practica ep ,tbl_personas_extendidas px where p.id_persona=sd.id_persona AND px.id_atributo=12 and px.id_persona=p.id_persona and px.valor=$_REQUEST[cuenta_coordinacion]";
          $resultado_datos = mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION['txt_estudiante']=$resultado_datos['nombre'];
          $_SESSION['cuenta']=$resultado_datos['valor'];
          $_SESSION['empresa']=$resultado_datos['nombre_empresa'];

       
     
          ?>
          <script>
            $(function(){
              $('#modal_aprobacion_practica').modal('toggle')

            })



          </script>;

          <?php 
        

        }



      }
      ob_end_flush();

      ?>


      <!DOCTYPE html>
      <html>
      <head>
        <title></title>
        <script type="text/javascript" src="../js/calculo_fecha_pps.js"></script>
      </head>
      <body >



        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Estudiantes a Realizar Práctica  Profesional Supervisada  </h1>
                </div>
                <div class="RespuestaAjax"></div>



                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Vinculación </li>

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
                       <th>APROBAR PRACTICA</th>                

                     </tr>
                   </thead>
                   <tbody>
                    <?php if ($_SESSION['Estado_proceso']=='PENDIENTE' and $_SESSION['estado_vin']==1) 
                    {
                     while($row = $resultadotabla_estudiantes_practica->fetch_array(MYSQLI_ASSOC)) { ?>
                      <tr>
                        <td><?php echo strtoupper($row['nombre']); ?></td>
                        <td><?php echo $row['valor']; ?></td>
                        <td><?php echo $row['proceso']; ?></td>


                        <td style="text-align: center;">

                         <a href="../vistas/aprobar_practica_coordinacion_vista.php?cuenta=<?php echo $row['valor']; ?>" class="btn btn-primary btn-raised btn-xs">
                          <i class="fas fa-eye"  title=""  ></i>
                        </a>
                      </td>

                      <td style="text-align: center;">

                       <a href="../vistas/aprobar_practica_coordinacion_vista.php?cuenta_coordinacion=<?php echo $row['valor']; ?>" class="btn btn-primary btn-raised btn-xs">
                        <i class="fas fa-edit"  title=""  ></i>
                      </a>
                    </td>


                  </tr>
                <?php  } 
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

<!--Creacion del modal-->

<!--<form action="../Controlador/aprobar_practica_coordinacion_controlador.php" method="post"  data-form="update" autocomplete="off"  >-->

<form method="post" id="formulario">

 <div class="modal fade" id="modal_aprobacion_practica">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Práctica  Profesional Supervisada</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>



      <!--Cuerpo del modal-->
      <div class="modal-body">
        <div class="card-body">
          <div class="row">

            <div class="col-sm-6">
             <div class="form-group">
               <label>Estudiante</label>
               <input class="form-control" type="text" id="txt_estudiante_documento" name="txt_estudiante_documento" value="<?php echo strtoupper($_SESSION['txt_estudiante']) ?>" readonly="readonly">
             </div></div>


             <input class="form-control" type="text" id="txt_estudiante_cuenta" name="txt_estudiante_cuenta" hidden="true"value="<?php echo strtoupper( $_SESSION['cuenta']) ?>" readonly="readonly">
             <input class="form-control" type="text" id="txt_empresa" name="txt_empresa" hidden="true"value="<?php echo strtoupper( $_SESSION['empresa']) ?>" readonly="readonly">


              <div class="col-sm-6">
               <div class="form-group">
                <label>Horas Practica</label>
                <select class="form-control" name="cb_horas_practica" id="cb_horas_practica">
                  <option value="0">Seleccione una opción :</option>
                  <option value="400">400</option>
                  <option value="800">800</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
                  <div class="form-group">
                  
                        <center> <h5>Horario de PPS</h5></center>
                        
                        <center> <label for="cars">Fecha de inicio</label>  </center>
                        <input type="date" placeholder="Escribe tu nombre" name="fecha_inicio" class="form-control" id="fecha_inicio" required autofocus title="Ingresa tu nombre porfavor">
                        <center> <h5>Días de Trabajo</h5></center>
                          <select class="form-control"name="dias" id="dias">
                          <option value="">Seleccione una opción :</option>
                          <option value="4">Lu-Ju</option>
                          <option value="5">Lu-Vi</option>
                          <option value="5.5">Lu-Sa</option>
                          </select>
                          <br>
                  </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                          <center> <h5>Horario de Trabajo</h5></center>
                          <center> <label>Entrada</label> </center>
                          <input type="time" name="horario_incio" id="horario_incio" class="form-control" required autofocus title="Ingresa tu apeliido porfavor">
                          <center><label>Salida</label>  </center>
                    <input type="time" name="horario_fin" id="horario_fin" class="form-control" required autofocus title="Ingresa tu apeliido porfavor">
                </div>
            </div>
            <div class="col-sm-4">
               <div class="form-group">
                         <center> <h5>Fecha de finalización de PPS</h5></center>
                         <center><label>Fecha</label>  </center>
                         <input type="date" placeholder="Escribe tu nombre" name="fecha_finalizacion" class="form-control" id="fecha_finalizacion"  autofocus title="Ingresa tu nombre porfavor">
                         
              </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group">
               
                         <center><button type="button" id="btnEnviar" class="btn btn-primary" name="btnEnviar">Calcular Fecha</button></center>
                         
                    
              </div>
            </div>
            </form>
            <div class="col-sm-12">
               <div class="form-group">
                <label>Aprobar PPS</label>
                <select class="form-control" name="cb_practica" id="cb_practica"  onchange="Mostrar_motivo();">
                  <option value="0">Seleccione una opción :</option>
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>
                 <option value="INCOMPLETA">REQUISITOS INCOMPLETOS</option>


                </select>
             
              </div>

            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Motivo</label>
              </div></div>
              <div class="col-sm-12">
                <div class="form-group">
                 <textarea class="form-control" id="txt_motivo_rechazo" name="txt_motivo_rechazo" style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)"  rows="4" cols="50" required  minlength="20" >

                 </textarea>

               </div>
             </div>

             <div class="row">
       
          </div>

        </div>
      </div>
    </div>


   <input class="form-control" type="text" id="txt_estudiante_cuenta" name="txt_estudiante_cuenta" hidden="true"value="<?php echo strtoupper( $_SESSION['cuenta']) ?>" readonly="readonly">

    <!--Footer del modal-->
    <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" class="btn btn-primary" id="btn_aprobacion_rechazo_practica" name="btn_aprobacion_rechazo_practica"  <?php echo $_SESSION['btn_aprobacion_rechazo_practica']; ?> >Guardar Cambios</button>
    </div>


  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<div class="RespuestaAjax"></div>

<!-- /.  finaldel modal -->


</form>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h4 class="modal-title"></h4></center>
        </div>
        <div class="modal-body">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>


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




//motivo rechazo PPS

$('#txt_motivo_rechazo').prop("readonly", true);


function Mostrar_motivo()
{
  /* Para obtener el valor */
  var aprobar = document.getElementById("cb_practica").value;


 if(aprobar == "INCOMPLETA" || aprobar =="NO") {
   
    $('#txt_motivo_rechazo').prop("readonly", false);
   document.getElementById("txt_motivo_rechazo").value = "";

 }
 else

  {
    $('#txt_motivo_rechazo').prop("readonly", true);
  }

}




</script>



</body>

</html>
