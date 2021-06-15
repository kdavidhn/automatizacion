<?php

session_start();
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
 




   

                  $sql_contador_pregunta_usuario=" select count(Id_pregunta) as Contador from tbl_preguntas_seguridad where Id_usuario= ".$_SESSION['id_usuario']." " ;
                $resultado_pregunta = $mysqli->query($sql_contador_pregunta_usuario);
                 $row_preguntas = mysqli_fetch_array($resultado_pregunta); 

                 
    $sql_preguntas=" select valor from tbl_parametros where parametro='cantidad_preguntas' " ;
$resultado_pregunta = $mysqli->query($sql_preguntas);
 $row_parametro_pregunta = mysqli_fetch_array($resultado_pregunta); 

                    $Contador=$row_preguntas['Contador'];


           if ($Contador==$row_parametro_pregunta['valor']) 

                          {
                  /*  $sql_actualizar_estatus = "UPDATE usuarios SET   Estatus=1 WHERE id_usuario= ".$_SESSION[id_usuario]." ";
                        $resultado_actualizar_estatus= $mysqli->query($sql_actualizar_estatus);*/

                           header('location: ../vistas/cambiar_clave_x_usuario_vista.php?estatus='.$_SESSION["estatus"].' ');
                          }



 $estatus_nuevo_pregunta_usuario=$_REQUEST['estatus'];

if (isset($_REQUEST['msj']))
 {
      $msj=$_REQUEST['msj'];
                
  
               if ($msj==1 )
                  {
                  echo '<script> alert("Pregunta agregada correctamente, numero de pregunta ingresada : '.$_REQUEST['contador'].' ")</script>';
                  }
               if ($msj==2)
                 {
               echo '<script> alert("Lo sentimos tiene campos por rellenar ")</script>';
                 }  
                   
                 if ($msj==4)
                 {
               echo '<script> alert("Lo sentimos esta pregunta ya existe intenta con una nueva")</script>';
                 }   

 }




 ?>

 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Informatica Admistrativa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <div class="login-logo">
     <img src="../dist/img/logo_informatica.jpg" width="40%" height="40%" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
        </div>

      <p class="login-box-msg">Se ingresarán 3 Preguntas de Seguridad </p>
      

<form action="../Controlador/guardar_pregunta_usuario_controlador.php?estatus_pregunta=<?php if (isset($estatus_nuevo_pregunta_usuario)){
  echo ($estatus_nuevo_pregunta_usuario); 
 }  else { echo('nada');}?>" method="post">

     <div class="form-group">
                  <label>Lista de Preguntas</label>
                 <select class="form-control"  name="combopregunta">
        <option value="0"  >Seleccione una pregunta:</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_preguntas ");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['Id_pregunta'].'"> '.$resultado['pregunta'].'</option>' ;
          }
        ?>
      </select>
                </div>

        <div class="input-group mb-3">
          <input  type="text" id="txt_respuestapu" name="txt_respuestapu"  value="" required=""  style="text-transform: uppercase" class="form-control" placeholder="Respuesta">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-comment-dots"></span>
            </div>
          </div>
        </div>

        <div class="row">
           <div class="col-8">
          <p class="mb-0">
        <a href="../login.php">Inicia Sesion</a>
      </p>
          </div>

          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>




    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
