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
                       text:"Lo sentimos hay algunos asignaturas ya existente y no seran guardados",
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
                                   text:"Los datos  se almacenaron correctamente",
                                   type: "success",
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
                                   text:"Lo sentimos no se pudieron guardar los datos",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';
    }
        

  }


$Id_objeto=26 ; 




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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A GESTION ESTUDIANTE PRACTICA ');


  if (permisos::permiso_insertar($Id_objeto)=='1')
  {
    $_SESSION['btn_gestion_estudiantes_practica']="";
  }
  else
  {
    $_SESSION['btn_gestion_estudiantes_practica']="disabled";
  }

$sql_tabla_estudiantes_practica="select * from tbl_usuarios";
$resultadotabla_estudiantes_practica = $mysqli->query($sql_tabla_estudiantes_practica);



?>
  <script>
    $(function(){
    $('#modal_aprobacion_practica').modal('toggle')

    })



  </script>;
<?php 
 
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
            <h1>Estudiantes en Practica Profesional Supervisada  </h1>
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
               <th>EXPEDIENTE</th>                
               <th>CHECKLIST</th>                

            </tr>
          </thead>
          <tbody>
            <?php while($row = $resultadotabla_estudiantes_practica->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
        <td><?php echo $row['nombre_completo']; ?></td>
        <td><?php echo $row['numero_cuenta']; ?></td>

<td style="text-align: center;">
              
                       <a href="../vistas/gestion_estudiantes_practica_vista.php?iduser=<?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["nombre_completo"]; ?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="fas fa-eye"  title="Visualizar expediente"  ></i>
                    </a>
                  </td>

                  <td style="text-align: center;">
              
                       <a href="../vistas/gestion_practica_vista.php?iduser=<?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["nombre_completo"]; ?>"class="btn btn-primary btn-raised btn-xs">
                      <i class="fas fa-edit"  title="Verificar documentacion "  ></i>
                    </a>
                  </td>
      
      
               </tr>
                 <?php  } ?>
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

<form action="" method="post"  data-form="update" autocomplete="off"  >
                 


         <div class="modal fade" id="modal_aprobacion_practica">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Documentacion </h4>
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
                  <label>Aprobar documentacion</label>
                      <select class="form-control" name="accion_bitacora" id="accion_bitacora">
          <option value="0">Seleccione una opcion:</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                
                </select>
                </div>
                 </div>

                 <div class="col-sm-6">
      <div class="form-group">
        <label>Observacion</label>
    <input class="form-control" type="text" id="txt_observacion_documentacion" name="txt_observacion_documentacion" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="">
   </div>
    </div>


              </div>
            </div>
          </div>

         


            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn_gestion_estudiantes_practica" name="btn_gestion_estudiantes_practica"  <?php echo $_SESSION['btn_gestion_estudiantes_practica']; ?> >Guardar Cambios</button>
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

