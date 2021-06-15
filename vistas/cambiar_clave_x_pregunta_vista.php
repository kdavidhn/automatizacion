<?php

require_once ('../clases/Conexion.php');
  
               if (isset($_REQUEST['id_usuario2'])) 
        {

        $id_usuarios=$_GET['id_usuario2'];
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
<body class="hold-transition login-page">
<div class="login-box">
 
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

 <div class="login-logo">
     <img src="../dist/img/logo_informatica.jpg" width="40%" height="40%" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
        </div>

      <p class="login-box-msg">Cambiar contraseña por Pregunta de Seguridad</p>

      <form action="../Controlador/actualizar_clave_x_pregunta_controlador.php?id_usuario=<?php echo $id_usuarios?>" method="post">

        <label>Nueva Contraseña:</label>
        <div class="input-group mb-3">

          <input class="form-control" type="password" id="txt_nuevaclave"  name="txt_nuevaclave" onkeyup="Espacio(this, event)" required  oncopy="return false" onpaste="return false" maxlength="10">
          <div class="input-group-append">
            <div class="input-group-text">
              <span  id="show-hide-passwd1" action="hide" class="fas fa-eye"></span>
            </div>
          </div>
        </div>
         <label>Confirmar Contraseña:</label>
        <div class="input-group mb-3">
          <input class="form-control" type="password" id="txt_confirmarclave"  name="txt_confirmarclave" onkeyup="Espacio(this, event)" required  oncopy="return false" onpaste="return false" maxlength="10">
          <div class="input-group-append">
            <div class="input-group-text">
              <span  id="show-hide-passwd2" action="hidev" class="fas fa-eye"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="../login.php">Inicia Sesion</a>
      </p>
  
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


<script>



    $(document).ready( function (){
 
   $('#show-hide-passwd1').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#txt_nuevaclave').removeAttr('type');
      $('#show-hide-passwd1').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#txt_nuevaclave').attr('type','password');
      $('#show-hide-passwd1').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });
 
       });

     $(document).ready( function (){
 
   $('#show-hide-passwd2').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#txt_confirmarclave').removeAttr('type');
      $('#show-hide-passwd2').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#txt_confirmarclave').attr('type','password');
      $('#show-hide-passwd2').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });
 
       });

    </script>
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
  icon: "info",
  title: "PASSWORD NO VÁLIDO: '.$_REQUEST['error'].'",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                        }
                        if ($msj==3)
                         {
                          echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos  se actulizaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                      
                            </script>';
                        }
                        if ($msj==4) 
                        {
echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"No se realizo el proceso, favor llame al administrador o intente de nuevo",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                </script>';                        }
                    
               }  

?>
