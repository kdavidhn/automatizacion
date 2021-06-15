<?php

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=40; 
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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A LISTA ALUMNOS HIMNO');
}
$jornada=$_GET['jornada'];
$counter = 0;
$sql_tabla = json_decode( file_get_contents('http://localhost/automatizacion/api/himno_api.php?jornada='.$jornada), true );

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

            <h1>Alumnos para la realizacion del himno</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/menu_revision_himno_vista.php">Jornadas</a></li>
            </ol>
          </div>
            <div class="RespuestaAjax"></div>  
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->


 
 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Listado</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="" method="POST">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NOMBRE</th>
                  <th># DE CUENTA</th>
                  <th>CORREO ELÉCTRONICO</th>
                  <th>FECHA</th>
                  <th>HORA</th>
                  <th>APROBO</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  if($sql_tabla["ROWS"]!=""){
                  while($counter< count($sql_tabla["ROWS"])) { ?>
                <tr>
                <td><?php echo $sql_tabla["ROWS"][$counter]["nombre"] ?></td>
                <td><?php echo $sql_tabla["ROWS"][$counter]["documento"]?></td>
                <td><?php echo $sql_tabla["ROWS"][$counter]["valor"] ?></td> 
                <td><?php echo $sql_tabla["ROWS"][$counter]["fecha"] ?></td> 
                <td><?php echo $sql_tabla["ROWS"][$counter]["hora"] ?></td>         
                <td style="text-align: center;">                    
                    <a  href="../vistas/alumnos_unico_vista.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["documento"] ?>&jornada=<?php echo $jornada ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-check-circle"></i>
                    </a>
                </td>
               </tr>
                 <?php  $counter = $counter + 1; }} ?>
                 
             </tbody>
            </table>
            </form>
         </div>
            <!-- /.card-body -->
          </div>

        
          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>

</div>





</section>

</div>
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
