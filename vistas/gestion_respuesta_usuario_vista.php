<?php

     session_start();
     
require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');



 $Id_objeto=11 ; 
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Gestion de respuestas a preguntas de seguridad');


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
               }



$sqltabla="select p.Pregunta from tbl_preguntas_seguridad pu, tbl_preguntas p where pu.Id_pregunta=p.Id_pregunta and Id_usuario=$_SESSION[id_usuario] " ;
$resultadotabla = $mysqli->query($sqltabla);

if (isset($_GET['Pregunta']))
 {

$sqltabla="select p.Pregunta from tbl_preguntas_seguridad pu, tbl_preguntas p where pu.Id_pregunta=p.Id_pregunta and Id_usuario=$_SESSION[id_usuario]" ;
$resultadotabla = $mysqli->query($sqltabla);

 

$_SESSION["Pregunta_gestion_respuesta"]=$_GET['Pregunta'];


 if (isset($_SESSION['Pregunta_gestion_respuesta'])){


?>
  <script>
    $(function(){
    $('#modal_modificar_respuesta').modal('toggle')

    })

  </script>;
<?php 
 ?> 

  <?php




  }

$sql="select pu.Id_pregunta_seguridad, p.Id_pregunta, p.Pregunta FROM  tbl_preguntas_seguridad pu , tbl_preguntas p where pu.Id_pregunta=p.Id_pregunta and Pregunta='$_SESSION[Pregunta_gestion_respuesta]' and pu.Id_usuario=$_SESSION[id_usuario]";
  $resultado = $mysqli->query($sql);
  /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);
 
$Id_pregunta=$row['Id_pregunta'];


/*
 if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
  
   
        if ($msj==1)
                   {
               echo '<script> alert("Respuesta modificada correctamente")</script>';

                   }
    }

*/


 }


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


            <h1>Gestión de Respuestas</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a >Cambio de Respuesta</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->





 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Preguntas Registradas</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                 <th>PREGUNTA DE SEGURIDAD</th>
                  <th>MODIFICAR</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                    <tr>
                       <td><?php echo $row['Pregunta']; ?></td> 
   
                     <td style="text-align: center;">
              
                       <a href="../vistas/gestion_respuesta_usuario_vista.php?Pregunta=<?php echo $row['Pregunta']; ?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" ></i>
                    </a>
                  </td>

               </tr>
                 <?php } ?>
             </tbody>
            </table>
         </div>
            <!-- /.card-body -->
          </div>

        
          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>

</div>






<!-- *********************Creacion del modal 

-->

<form action="../Controlador/actualizar_respuesta_usuario_controlador.php?Id_pregunta_usuario=<?php echo $Id_pregunta ?>" method="post" data-form="update" autocomplete="off" >
                 


                  <div class="modal fade" id="modal_modificar_respuesta">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Respuesta</h4>
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

                  <label>Pregunta Registrada</label>

                                      
                        <input  class="form-control" type="text" id="txtpregunta" name="txtpregunta"  value="<?php echo $_SESSION['Pregunta_gestion_respuesta'];?>" required style="text-transform: uppercase" onkeyup="Espacio(this, event)"  onkeypress="return Letras(event)" maxlength="30" readonly="true">

               </div>

  <label class="control-label">Respuesta</label>

    <div class="input-group mb-3">
          <input  class="form-control" type="password" id="respuestap" name="respuestap"  required style="text-transform: uppercase"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)"  maxlength="80" onkeypress="return comprobar(this.value, event, this.id)">

          <div class="input-group-append">
            <div class="input-group-text">
              <span  id="show-hide-passwd6" action="hide" class="fas fa-eye"></span>
            </div>
          </div>
        </div

   </div>
            </div>
          </div>

            </div>




            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn_modificar_roles" name="btn_modificar_roles">Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- /.  finaldel modal -->
            <div class="RespuestaAjax"></div>



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
    <script>


 

     $(document).ready( function (){
 
   $('#show-hide-passwd6').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#respuestap').removeAttr('type');
      $('#show-hide-passwd6').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#respuestap').attr('type','password');
      $('#show-hide-passwd6').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });
 
       });

    </script>


</body>
</html>