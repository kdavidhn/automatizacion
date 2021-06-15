<?php
ob_start();

session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$sql_tabla_proyectos="select Id_proyecto, nombre  , tipo_proyecto ,codigo_proyecto from tbl_proyectos";
$resultadotabla_proyectos = $mysqli->query($sql_tabla_proyectos);


      $Id_objeto=23 ; 

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
                           window.location = "../vistas/menu_proyectos_vista.php";

                            </script>';
 
}

else

{

        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A GESTION DE PROYECTOS');

if (permisos::permiso_modificar($Id_objeto)=='1')
 {
  $_SESSION['btn_modificar_proyecto']="";
}
else
{
    $_SESSION['btn_modificar_proyecto']="disabled";
}


   }


   ?>
  <script>
    $(function(){
    $('#modal_modificar_proyecto').modal('toggle')

    })



  </script>;
<?php 
 


  


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


            <h1>Gestion de Proyectos</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/registrar_proyecto_vinculacion_vista.php">Nuevo Proyecto</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
<!--Pantalla 2-->





 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Proyectos Existentes</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>CODIGO DE PROYECTO</th>
                  <th>NOMBRE</th>
                  <th>TIPO PROYECTO</th>
                   <th>MODIFICAR</th>
                  </tr>
                </thead>
                <tbody>
    <?php while($row = $resultadotabla_proyectos->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
        <td><?php echo $row['codigo_proyecto']; ?></td>
        <td><?php echo $row['nombre']; ?></td>
        <td><?php echo $row['tipo_proyecto']; ?></td>

   <!--  //    <?php   
/*
<?php  while ($counter< count($sql_tabla_proyectos["ROWS"])) { ?>
                <tr>
 <td><?php echo $sql_tabla_proyectos["ROWS"][$counter]["codigo_proyecto"]; ?></td>
     <td><?php echo $sql_tabla_proyectos["ROWS"][$counter]["nombre"]; ?></td>
     <td><?php echo $sql_tabla_proyectos["ROWS"][$counter]["estado"]; ?></td>
   */  ?> //  -->

         <td style="text-align: center;">
              
                       <a href="../vistas/gestion_proyectos_vista.php" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_proyecto'] ?> " ></i>
                    </a>
                  </td>
      
               </tr>
                  <?php } ?>
                 <!--    <?php  //  $counter = $counter + 1; } ?>    -->
             </tbody>
            </table>
         </div>
            <!-- /.card-body -->
          </div>

        
          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>



<!-- *********************Creacion del modal 

-->

<form action="" method="post"  data-form="update" autocomplete="off" >
                 


         <div class="modal fade" id="modal_modificar_proyecto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Proyecto</h4>
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
                        <label class="control-label">Nombre del Proyecto</label>
                            <input class="form-control" type="text"  maxlength="60" id="txt_nombre_proyecto" name="txt_nombre_proyecto"   required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly>
                     
                    </div>
                   </div>


                <div class="col-sm-12">
                  <hr>
                  <label>Tiempo de Ejecucion </label>
                  </div>

                <div class="col-sm-6">
                <div class="form-group">
                  <label>Fecha de Inicio</label>
                    <input class="form-control" type="date" id="txt_fecha_inicio" name="txt_fecha_inicio"  >
                </div>
              </div>

                <div class="col-sm-6">
                 <div class="form-group">
                  <label>Fecha de Finalizacion</label>
                    <input class="form-control" type="date" id="txt_fecha_final" name="txt_fecha_final"  >
                </div>
              </div>

              <div class="col-sm-12">
                <hr>
                  <label>Fecha de Evaluacion </label>
                  </div>

                <div class="col-sm-6">
                <div class="form-group">
                  <label>Intermedia</label>
                    <input class="form-control" type="date" id="txt_fecha_intermedia" name="txt_fecha_intermedia"  >
                </div>
              </div>

                <div class="col-sm-6">
                 <div class="form-group">
                  <label>Final</label>
                    <input class="form-control" type="date" id="txt_fecha_final_evaluacion" name="txt_fecha_final_evaluacion"  >
                </div>
              </div>

              <div class="col-sm-12">
                   <hr>
                  <label>Vinculacion con la Entidad </label>
</div>
                              
                 
                  <div class="col-sm-6">
                  <div class="form-group">
                  <label> Contacto Institucional  </label>
                    <input class="form-control" type="text" id="txt_contacto_institucional" name="txt_contacto_institucional"  value="" required  onkeyup="Espacio(this, event)" style="text-transform: uppercase" maxlength="60"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)">
                </div>
                 </div>

                   <div class="col-sm-6">
                  <div class="form-group">
                  <label> Cargo </label>
                    <input class="form-control" type="text" id="txt_cargo" name="txt_cargo"  value="" required  onkeyup="Espacio(this, event)"  style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)"maxlength="30">
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label> Telefono </label>
                    <input class="form-control" type="text" id="txt_telefono_empresa" name="txt_telefono_empresa"  value="" required  data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label> Correo Electronico </label>
                    <input class="form-control" type="text" id="txt_correo_contacto" name="txt_correo_contacto"  value="" required  onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50">
                </div>
                 </div>

          
<!--
              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-info btn-raised btn-sm" id="" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>
-->
              </div>
            </div>
          </div>

          




            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn_modificar_proyecto" name="btn_modificar_proyecto"  <?php echo $_SESSION['btn_modificar_proyecto']; ?> >Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

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

<?php
if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
    {
   echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos  se almacenaron correctamente",
                       type: "success",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>';
       
        }
              if ($msj==2)
                   {


  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Error al actualizar lo sentimos,intente de nuevo.",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>'; 
                  }
                    if ($msj==3)
                   {
                   echo '<script type="text/javascript">
                                                  swal({
                                                       title:"",
                                                       text:"Lo sentimos tiene campos por rellenar.",
                                                       type: "info",
                                                       showConfirmButton: false,
                                                       timer: 3000
                                                    });

                                                </script>';
                                              }
      }
?>