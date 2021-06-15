<?php
   require_once ('../clases/Conexion.php');




if (isset($_REQUEST['idusuario'])) 
{
$id_usuario=$_GET['idusuario'];

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
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

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

      <p class="login-box-msg">Recuperar Contraseña por Correo Electronico</p>

      <form action="../Controlador/verificar_correo_usuario_controlador.php?idusuario=<?php echo $id_usuario ?>" method="post">

        <div class="input-group mb-3">
          <input type="email" class="form-control" id="correoclave" name="correoclave"  value="" onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" onkeypress="return comprobar(this.value, event, this.id)" placeholder="Correo Electronico" required="required">

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
          </div>          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="../login.php">Inicia Sesion</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Registrate</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

  <script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js" ></script>

  <script src="../dist/js/sweetalert2.min.js"></script>

  <script src="../dist/js/main.js"></script>

</body>
</html>
<?php
if (isset($_REQUEST['msj']))
                {
                $msj=$_REQUEST['msj'];
                  if ($msj==1) 
                        {
                                  echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "Lo sentimos no se pudo enviar el correo, intente de nuevo o contactese con el administrador",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                        }
                        if ($msj==2) 
                        {
                                  echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "Lo sentimos datos incorrectos, favor intente de nuevo",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                        }
                            if ($msj==3) 
                        {
                                  echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: " Lo sentimos no se pudo actualizar la contraseña, intente de nuevo o contactese con el administrador",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                       
                      
        }
      }

?>
