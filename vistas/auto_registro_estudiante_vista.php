<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Informatica Admistrativa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">


<!-- SweetAlert2 -->
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
<body class="hold-transition register-page">
<div class="register-box">

  <div class="card">
    <div class="card-body register-card-body">

  <div class="register-logo">
    <img src="../dist/img/logo_informatica.jpg" width="40%" height="40%" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
  </div>

      <p class="login-box-msg">Registro de Estudiantes</p>

      <form action="../Controlador/guardar_auto_registro_estudiantes_controlador.php" method="post">

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nombres" id="txt_nombre_estudiante" name="txt_nombre_estudiante">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Apellidos" id="txt_apellido_estudiante" name="txt_apellido_estudiante">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <select class="form-control" name="sexo" id="sexo" require > <option value="">Sexo</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
        </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

           <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Numero de Cuenta" id="txt_cuenta_estudiante" name="txt_cuenta_estudiante">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" id="txt_correo_estudiante" name="txt_correo_estudiante">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" id="txt_clave" name="txt_clave">
          <div class="input-group-append">
            <div class="input-group-text">
 <span  id="show-hide-passwd6" action="hide" class="fas fa-eye"></span>            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirmar Contraseña"  id="txt_confirmar_clave" name="txt_confirmar_clave">
          <div class="input-group-append">
            <div class="input-group-text">
 <span  id="show-hide-passwd7" action="hide" class="fas fa-eye"></span>            </div>
          </div>
        </div>

        <div class="row">
              <div class="col-8">
             <a href="../login.php" class="text-center">Iniciar Sesion</a>
          </div>
              <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

 

    
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

 <script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js" ></script>

  <script src="../dist/js/sweetalert2.min.js"></script>

  <script src="../dist/js/main.js"></script>

<script>


 

     $(document).ready( function (){
 
   $('#show-hide-passwd6').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#txt_clave').removeAttr('type');
      $('#show-hide-passwd6').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#txt_clave').attr('type','password');
      $('#show-hide-passwd6').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });
 
       });

          $(document).ready( function (){
 
   $('#show-hide-passwd7').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#txt_confirmar_clave').removeAttr('type');
      $('#show-hide-passwd7').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#txt_confirmar_clave').attr('type','password');
      $('#show-hide-passwd7').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });
 
       });

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
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "Lo sentimos NUEVA Y CONFIRMAR deben ser iguales intenta de nuevo",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                    }
                    if ($msj==2) 
                    {
                      echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "success",
  title: "Los datos  se almacenaron correctamente",
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
  title: "El Usuario ya existe",
  showConfirmButton: false,
  timer: 3000
})   </script>';

                    }
                    if ($msj==4) 
                    {
                              echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "Error al guardar lo sentimos,intente de nuevo.",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                    }
                    if ($msj==5)
                    {
                            echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "PASSWORD NO VÁLIDO: '.$_REQUEST['error'].'",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                    }
                    
             }




             ?>





