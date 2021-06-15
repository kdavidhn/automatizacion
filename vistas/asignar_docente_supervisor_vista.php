<?php

ob_start();


  session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_visualizar.php');


 

ob_end_flush();


?>


<!DOCTYPE html>
<html>
<head>

<script type="text/javascript" src="../js/supervisiones/docente_supervisor.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
            if (isset($_POST) && isset($_POST['id_asignatura'])) {
            echo '<script> mostrar('.$_POST['id_asignatura'].'); 
                  console.log("Hay Post");
            </script>';
              # code...
            }
            ?>
</head>
<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Asignar Docente Supervisor</h1>
           
            
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item "><a href="../vistas/menu_supervision_vista.php">Supervisión</a></li></li>
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
      
<form  name="formulario" id="formulario" method="post" action="../Controlador/corre_supervisor.php" data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                  <div class="col-sm-12">
                  <div class="form-group">
                  <form action="../Controlador/corre_supervisor.php" method="POST"></form>
                  <input hidden="true" name="id_supervisor" id="id_supervisor">
                  </form>
                  <label>Docente supervisor</label>
                 
                  <select class="form-control" name="docente" id="docente"> 
                  <option value="" selected hidden>Seleccione</option>
                  <?php
                    $query = $mysqli -> query ("SELECT * FROM tbl_personas WHERE tipo_persona = 'empleado' ");
                   while ($supervisores = mysqli_fetch_array($query)) {
                   echo '<option value="'.$supervisores['id_persona'].' ">'.$supervisores['nombre'].'</option>';
                   
                  }
                   ?>
                </select>
                </div>
                 </div>

               

                
                
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar" onclick="editar();"> Guardar</button>

                            <a href="../vistas/gestion_docente_supervisor_vista.php" class="btn btn-danger float-right ">Cancelar</a>
                  </div>
         
         
    
</form>

  </div>
</section>


</div>



</body>
</html>


