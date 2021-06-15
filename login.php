<?php
session_start();
require_once ('clases/Conexion.php');
/*
   $sql_auto_registro=("select valor FROM tbl_parametros where parametro='AUTO_REGISTRO' ");
   $parametro_registro = mysqli_fetch_assoc($mysqli->query($sql_auto_registro));


if ($parametro_registro['valor']=="1") 
{
  $_SESSION['auto_registro']="block";
}
else
{
  $_SESSION['auto_registro']="none";
}
*/

        if (isset($_REQUEST['msj']))
        {
        $msj=$_REQUEST['msj'];

              if ($msj==1)
              {
                 echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "success",
  title: "Favor revisar su correo la contraseña ha sido enviada",
  showConfirmButton: false,
  timer: 3000
})
                            </script>';
              }

              if ($msj==2)
              {
                 echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "error",
  title: "Usuario/Contraseña incorrecta",
  showConfirmButton: false,
  timer: 3000
})
                            </script>';

                }
               if ($msj==3 and isset($_REQUEST['intentos']))
              {


     

  $sql_intentos=" select valor from tbl_parametros where parametro='intentos' " ;
$resultado_intento = $mysqli->query($sql_intentos);
 $row_parametro_intento = mysqli_fetch_array($resultado_intento); 

$Intento1=$_REQUEST['intentos'];

              if ($Intento1==$row_parametro_intento['valor'] and $_SESSION["id_usuario"]<>1)

               {
                  

                  echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "warning",
  title: "Lo sentimos este es tu ultimo intento.",
  showConfirmButton: false,
  timer: 3000
})
                            </script>';
                          }
              }
               if ($msj==4)
              {
                 echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "Lo sentimos tu usuario ha sido bloqueado, contactese con el administrador",
  showConfirmButton: false,
  timer: 3000
})
                            </script>';
                }
                     if ($msj==5)
              {
                echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "Lo sentimos su usuario esta bloqueado, contactese con el administrador",
  showConfirmButton: false,
  timer: 3000
})
                            </script>';
                }
                if ($msj==6 )
                 {
                   echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "success",
  title: "Su contraseña ha actualizada correctamente",
  showConfirmButton: false,
  timer: 3000
})
                            </script>';
                 }
                 if ($msj==7 )
                 {
                   echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "warning",
  title: "Número de cuenta o de empleado no cumple los requisitos de longitud",
  showConfirmButton: false,
  timer: 3000
})
                            </script>';
                 }
           
            

      
        }
   

?>





<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Informatica</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <div class="login-logo">
     <img src="dist/img/lOGO_OFICIAL.jpg" width="40%" height="40%" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
        </div>

      <p class="login-box-msg"> Iniciar Sesión</p>

<form action="Controlador/existe_usuario_controlador.php" method="post">
        <div class="input-group mb-3">
          <input id="usuario" name="usuario" value=""  type="text" maxlength="30" style="text-transform: uppercase" onkeyup="Espacio(this, event)"   onkeypress="return comprobar(this.value, event, this.id)" class="form-control" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="clave"  id="clave" class="form-control" placeholder="Contraseña" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span  id="show-hide-passwd6" action="hide" class="fas fa-eye"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
           
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <p class="mb-1">
        <a href="vistas/recuperar_clave_vista.php">Olvidaste tu contraseña?</a>
      </p>
      <p class="mb-0">
        <a href="vistas/auto_registro_estudiante_vista.php" class="text-center">Registrate!!123</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

  <script>


 

     $(document).ready( function (){
 
   $('#show-hide-passwd6').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#clave').removeAttr('type');
      $('#show-hide-passwd6').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#clave').attr('type','password');
      $('#show-hide-passwd6').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });
 
       });

    </script>

  <script type="text/javascript" src="plugins/sweetalert2/sweetalert2.min.js" ></script>

  <script src="dist/js/sweetalert2.min.js"></script>

  <script src="dist/js/main.js"></script>


</body>
</html>
