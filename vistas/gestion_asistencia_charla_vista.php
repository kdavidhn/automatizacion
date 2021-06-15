<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


      $Id_objeto=14 ; 

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
                           window.location = "../vistas/menu_practica_vista.php";

                            </script>';
 
}
else
{

        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A ASISTENCIA CHARLA.');

if (permisos::permiso_modificar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_asistencia']="";
}
else
{
    $_SESSION['btn_guardar_asistencia']="disabled";
}
  


if (isset($_POST['cb_jornada']))
 {


  $jornada=$_POST['cb_jornada'];
  if ($jornada=="0")
   {
  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos tiene campos por rellenar",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3500
                    });
                </script>';
       
      }
  
  else
  {
    if ($jornada=="MATUTINA") {

      $sqlimpartida="select valor from tbl_parametros where parametro='DOCENTE_VINCULACION_MATUTINA_1'";
         //Obtener la fila del query
        $Impartida = mysqli_fetch_assoc($mysqli->query($sqlimpartida)); 
                $sqlimpartida2="select valor from tbl_parametros where Parametro='DOCENTE_VINCULACION_MATUTINA_2'";
                $Impartida2 = mysqli_fetch_assoc($mysqli->query($sqlimpartida2));  
 //Obtener la fila del query
    }
    else
    {
        $sqlimpartida="select valor from tbl_parametros where parametro='DOCENTE_VINCULACION_VESPERTINA_1'";
         //Obtener la fila del query
        $Impartida = mysqli_fetch_assoc($mysqli->query($sqlimpartida)); 
                $sqlimpartida2="select valor from tbl_parametros where Parametro='DOCENTE_VINCULACION_VESPERTINA_2'";
                $Impartida2 = mysqli_fetch_assoc($mysqli->query($sqlimpartida2));  
 
}

  


$_SESSION['impartida']=$Impartida["valor"] . " /".$Impartida2["valor"];



    $counter = 0;

   $sql_tabla_control = json_decode( file_get_contents("http://informaticaunah.com/automatizacion/api/asistencia_charla_api.php?control=".$jornada), true );
  }


}
else
{
  $_SESSION['impartida']="";
    $counter = 0;

   $sql_tabla_control = json_decode( file_get_contents("http://informaticaunah.com/automatizacion/api/asistencia_charla_api.php"), true );
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
            <h1>Asistencia Charla de PPS</h1>
          </div>


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


<section class="content">
            <div class="container-fluid">
  <!-- pantalla 1 -->
      

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>

<form action="../vistas/gestion_asistencia_charla_vista.php" method="post" autocomplete="off" >
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">



                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Jornada </label>
                  <select class="form-control" name="cb_jornada" id="cb_jornada"> 
                  <option value="0">Seleccione una opción :</option>
                   <option value="MATUTINA"  <?php if(isset($jornada) and $jornada=="MATUTINA"){

                    echo "selected";
                   } ?>>MATUTINA</option>
                    <option value="VESPERTINA"  <?php if(isset($jornada) and $jornada=="VESPERTINA"){

                    echo "selected";
                   } ?>>VESPERTINA</option>
                </select>
                </div>
                 </div>

               

                 <div class="col-sm-3">
                  <div class="form-group">
                     <p class="text-center" style="margin-top: 30px;">
                 <button type="button" class="btn btn-primary" id="btn_imprimir_asistencia" name="btn_imprimir_asistencia"  onclick="dirigir(this.id)"  ><i class="zmdi zmdi-floppy"></i> Imprimir Asistencia</button>
                </div>
                 </div>

                 <div class="col-sm-3">
                  <div class="form-group">
                    <p class="text-center" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" id="btn_control_asistencia" name="btn_control_asistencia" ><i class="zmdi zmdi-floppy"></i> Control Asistencia</button>
                </div>
                 </div>
                   </form>
                  
          </div>


          </div>

          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>
         
         
    
    control


  </div>
</section>


    <!-- Main content -->
    <section class="content">
            <div class="container-fluid">
  <!-- pantalla 1 -->
      
<form action=" ../api/asistencia_charla_api.php?asistencia=<?php echo $jornada?>" method="post"  data-form="save" autocomplete="off" >

                                  
   <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">..</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                            <div class="row">

               <div class="col-sm-6">
          <div class="form-group">
                  <label>Impartida por:</label>
                    <input class="form-control" type="text" id="txt_impartida" name="txt_impartida"  value="<?php echo $_SESSION['impartida']?>" required  onkeyup="Espacio(this, event)"  maxlength="50" readonly="readonly">
                </div>
                 </div>


                <div class="col-sm-3">
                <div class="form-group">
                  <label>Fecha Impartida</label>
                    <input class="form-control" type="date" id="txt_fecha_impartida" name="txt_fecha_impartida" >
                </div>
              </div>
            
         </div>


              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>

                  <th>ESTUDIANTE</th>
                  <th>Nº CUENTA</th>
                  <th>ASISTENCIA</th>
                  
                  </tr>
                </thead>
                <tbody>
           <?php while($counter<count($sql_tabla_control["ROWS"])) { ?>
                <tr >
                  <form>
                   

 <td><?php echo $sql_tabla_control["ROWS"][$counter]["nombre"]; ?></td>
  <td><?php echo $sql_tabla_control["ROWS"][$counter]["valor"]; ?></td>

                  <td style="text-align: center;">
                 <input type="checkbox" name="asistencia[]"  data-bootstrap-switch value="<?php echo $sql_tabla_control["ROWS"][$counter]["Id_charla"]; ?>">
                 
                 </td>

               </tr>
                    <?php   $counter = $counter + 1; } ?>
             </tbody>
            </table>
               
        

              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_asistencia" name="btn_guardar_asistencia">  <?php echo $_SESSION['btn_guardar_asistencia']; ?><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>

               </div>
            <!-- /.card-body -->
          </div>


 <div class="RespuestaAjax"></div>
</form>

  </div>
</section>





</div>

<!-- Bootstrap Switch -->
<script src="../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

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
$("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checkeds'));
    });



</script>

<script type="text/javascript">

  function dirigir(boton){
        var control_asistencia = document.getElementById("cb_jornada").value;

        if (boton=="btn_imprimir_asistencia"){
          window.open("../pdf/reporte_asistencia_charla.php?control="+control_asistencia);
        } 
      }


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
                       text:"Lo sentimos tiene campos por rellenar",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3500
                    });
                </script>';
       
        }
              if ($msj==3)
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
                    if ($msj==2)
                   {
                   echo '<script type="text/javascript">
                                                  swal({
                                                       title:"",
                                                       text:"Datos almacenados correctamente.",
                                                       type: "success",
                                                       showConfirmButton: false,
                                                       timer: 3000
                                                    });

                                                </script>';
                                              }
                                              if ($msj==4) {
                                                   echo '<script type="text/javascript">
                                                  swal({
                                                       title:"",
                                                       text:"Favor revisar los campo de asistencia.",
                                                       type: "info",
                                                       showConfirmButton: false,
                                                       timer: 3000
                                                    });

                                                </script>';
                                                                                           
                                                                                            }
      }
?>