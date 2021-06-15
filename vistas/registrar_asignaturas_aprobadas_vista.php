<?php

ob_start();


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


$Id_objeto=15 ; 

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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REGISTRAR ASIGNATURA APROBADAS');


  if (permisos::permiso_insertar($Id_objeto)=='1')
  {
    $_SESSION['btn_guardar_asignaturas_aprobadas']="";
  }
  else
  {
    $_SESSION['btn_guardar_asignaturas_aprobadas']="disabled";
  }



  $sqltabla_asignaturas="select Id_asignatura as Id, asignatura , codigo from tbl_asignaturas";
  $resultadotabla_asignaturtas = $mysqli->query($sqltabla_asignaturas);


  if (isset($_POST['txt_cuenta']) )
  {
  
   $_SESSION['Cuenta']=  $_POST['txt_cuenta'];

     $sql="select concat(p.nombres,' ',p.apellidos) as nombre from tbl_personas p, tbl_personas_extendidas px where px.valor=$_SESSION[Cuenta] AND px.id_atributo=12 and px.id_persona=p.id_persona";
 //Obtener la fila del query
   $nombre = mysqli_fetch_assoc($mysqli->query($sql));
   if (!empty($nombre['nombre']) )
   {
     $_SESSION['Nombre_completo']=$nombre['nombre'];


   }
   else
   {
     echo '<script type="text/javascript">
     swal({
       title:"",
       text:"El estudiante no esta registrado, lo sentimos intente de nuevo.",
       type: "info",
       showConfirmButton: false,
       timer: 1500
       });
       $(".FormularioAjax")[0].reset();
       </script>'; 
     }

   }
   else
   {
     $_SESSION['Cuenta']="";
     $_SESSION['Nombre_completo']="";


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
            <h3 class="card-title">Asignaturas Aprobadas</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          </div>
        </div>


        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">




            <div class="col-xs-12 col-md-6">
              <div class="form-group">

                  <form action="../vistas/registrar_asignaturas_aprobadas_vista.php" method="post" autocomplete="off">

                  <label>Nº de Cuenta</label>
                  <input class="form-control" type="number" id="txt_cuenta" name="txt_cuenta"  value="<?php echo $_SESSION['Cuenta'] ?>" required   maxlength="11"   onchange = "this.form.submit()" onkeyup="Espacio(this, event)"  >
                </form>
                        </div>
            </div>


            <div class="col-xs-12 col-md-6">


             <label >Nombre Completo </label>
             <div class="form-group clearfix">
                <input  class="form-control" type="text"  maxlength="60" id="txt_nombre_estudiante" name="txt_nombre_estudiante"  value="<?php echo $_SESSION['Nombre_completo'] ?>" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly="readonly">
             
            </div>
          </div>


         

        </div>

      </div>



      <!-- /.card-body -->
      <div class="card-footer">

      </div>
    </div>


            
      <form action="../Controlador/guardar_asignaturas_aprobadas_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

       

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Asignaturas</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="tabla" class="table table-bordered table-striped">
          <thead>
            <tr>
               <th>ASIGNATURA</th>
              <th>CODIGO</th>

                <th>APROBADA</th>

            </tr>
          </thead>
          <tbody>
             <?php while($row = $resultadotabla_asignaturtas->fetch_array(MYSQLI_ASSOC))
             { ?>
              <tr>
              <td><?php echo $row['asignatura']; ?></td>
                            <td><?php echo $row['codigo']; ?></td>


                <td style="text-align: center;">

                  <input type="checkbox" name="asignatura[]" value="<?php echo  $row['Id'];  ?>">

                </td>      

              </tr>
                     <?php } ?>
          </tbody>
        </table>
      </div>

        <p class="text-center" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary" id="btn_guardar_asignaturas_aprobadas" name="btn_guardar_asignaturas_aprobadas">  <?php echo $_SESSION['btn_guardar_asignaturas_aprobadas']; ?><i class="zmdi zmdi-floppy"></i> Guardar</button>
          </p>
      <!-- /.card-body -->
    </div>


    <div class="RespuestaAjax"></div>
  </form>

  </div>
</section>





</div>



  <script type="text/javascript">


   $(function () {

    $('#tabla').DataTable({
      "paging": false,
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