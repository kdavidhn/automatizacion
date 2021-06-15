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


$Id_objeto=16 ; 




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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A GESTION ASIGNATURA APROBADAS');


  if (permisos::permiso_insertar($Id_objeto)=='1')
  {
    $_SESSION['btn_gestion_asignaturas_aprobadas']="";
  }
  else
  {
    $_SESSION['btn_gestion_asignaturas_aprobadas']="disabled";
  }


   $counter = 0;
   $sql_tabla_clases_aprobadas = json_decode( file_get_contents('http://localhost/automatizacion2/api/asignaturas_aprobadas_api.php'), true );

  
$sql_tabla__modal_clases_aprobadas="select * from tbl_asignaturas";

if (isset($_GET['iduser']))
{

$_SESSION["nombreaprobadas"]=$_GET['nombres'];
$_SESSION["CuentaValor"]=$_GET['iduser'];

 //Obtener la fila del query
  
$sql_tabla__modal_clases_aprobadas="select * from tbl_asignaturas";
$resultadotabla_modal = $mysqli->query($sql_tabla__modal_clases_aprobadas);



?>
  <script>
    $(function(){
    $('#modal_modificar_asignaturas').modal('toggle')

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
</head>
<body >



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Asignaturas Aprobadas</h1>
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
            <h3 class="card-title">Gestión Aprobadas</h3>
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
                <th>CANTIDAD DE CLASES</th>
                <th>MODIFICAR</th>
                <th>CONSTANCIA</th>



            </tr>
          </thead>
           <tbody>
             <?php  while ($counter< count($sql_tabla_clases_aprobadas["ROWS"])) { ?>
                <tr>
 <td><?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["nombre"]; ?></td>
     <td><?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["valor"]; ?></td>
     <td><?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["clases"]; ?></td>
<td style="text-align: center;">
              
                       <a href="../vistas/gestion_asignaturas_aprobadas_vista.php?iduser=<?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["valor"]; ?>&nombres=<?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["nombre"]; ?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit"  ></i>
                    </a>
                  </td>

                  <td style="text-align: center;">
              
                       <a href="../pdf/reporte_constancia_clases.php?id_persona_=<?php echo $sql_tabla_clases_aprobadas["ROWS"][$counter]["id_persona"]; ?>" target="_blank" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit"  ></i>
                    </a>
                  </td>

      
               </tr>
                 <?php   $counter = $counter + 1; } ?>
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

<form action="../api/asignaturas_aprobadas_api.php?estudianteaprobadas=<?php echo  $_SESSION["CuentaValor"] ?> "method="post"  data-form="update" autocomplete="off"  >
                 


         <div class="modal fade" id="modal_modificar_asignaturas">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Asignaturas </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>



               <!--Cuerpo del modal-->
            <div class="modal-body">
              <label><?php echo strtoupper($_SESSION["nombreaprobadas"]);?></label>
   
   <div class="card-body">
            <div class="row">
                <div class="card-body">
        <table id="tablamodal" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ASIGNATURA</th>
                   <th>AGREGAR</th>

                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $resultadotabla_modal->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
      
        <td><?php echo $row['asignatura']; ?></td>

                 <td style="text-align: center;">


                  <input type="checkbox" name="asignatura[]"  value="<?php
                             
                   echo  $row['Id_asignatura'];  ?>" <?php 

   $sqlchk="select Id_asignatura from tbl_asignaturas_aprobadas where id_persona=(select p.id_persona from tbl_personas p , tbl_personas_extendidas px where p.id_persona=px.id_persona and px.valor='$_SESSION[CuentaValor]') and Id_asignatura=$row[Id_asignatura]";

$resultadochk = $mysqli->query($sqlchk);
  $row = $resultadochk->fetch_array(MYSQLI_ASSOC);
if (isset($row['Id_asignatura'])) {
                  echo "checked";
                  $disabled=1;
                 }
                 else
                 {
                  $disabled=0;
                 }

              
                                    ?> <?php if ($disabled==1) 
                                    {
echo "disabled";
                                    } ?> >

                </td>    
               

               </tr>
                 <?php  } ?>
             </tbody>
            </table>
      </div>



                  


            <!--Footer del modal-->
            <div class="modal-footer">
           
              <button type="submit" class="btn btn-primary" id="btn_modificar_egresado" name="btn_gestion_asignaturas_aprobadas"  <?php echo $_SESSION['btn_gestion_asignaturas_aprobadas']; ?> >Guardar Cambios</button>

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

    $('#tablamodal').DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });

 
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
