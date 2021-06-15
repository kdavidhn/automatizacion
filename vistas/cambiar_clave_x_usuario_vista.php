<?php
session_start();
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');


        $Id_objeto=12 ; 
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Cambiar clave como usuario');

    
if (isset($_REQUEST['estatus']))
 {
     $estatus=$_REQUEST['estatus'];
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

      <p class="login-box-msg">Cambiar contraseña</p>

      <form action="../Controlador/actualizar_clave_x_usuario_controlador.php?estatus=<?php if(isset($estatus)){ echo($estatus);}
else { echo('nada') ;} ?>" method="post">



        <label>Contraseña Actual</label>
        <div class="input-group mb-3">

          <input class="form-control" type="password" id="txt_claveactual"  name="txt_claveactual" onkeyup="Espacio(this, event)" required  oncopy="return false" onpaste="return false" maxlength="10">
          <div class="input-group-append">
            <div class="input-group-text">
              <span  id="show-hide-passwd" action="hide" class="fas fa-eye"></span>
            </div>
          </div>
        </div>


        <label>Nueva Contraseña</label>
        <div class="input-group mb-3">

          <input class="form-control" type="password" id="txt_clavenueva"  name="txt_clavenueva" onkeyup="Espacio(this, event)" required  oncopy="return false" onpaste="return false" maxlength="10">
          <div class="input-group-append">
            <div class="input-group-text">
              <span  id="show-hide-passwd1" action="hide" class="fas fa-eye"></span>
            </div>
          </div>
        </div>

         <label>Confirmar Contraseña</label>
        <div class="input-group mb-3">
          <input class="form-control" type="password" id="txt_confirmarclave"  name="txt_confirmarclave" onkeyup="Espacio(this, event)" required  oncopy="return false" onpaste="return false" maxlength="10">
          <div class="input-group-append">
            <div class="input-group-text">
              <span  id="show-hide-passwd2" action="hide" class="fas fa-eye"></span>
            </div>
          </div>
        </div>

        <div class="row">
         <div class="col-8">
          <p class="mb-0">
        <a href="../login.php">Inicia Sesion</a>
         </p>
          </div>


          <div class="col-4">
           <button type="submit" id="btn_cambiar_clave_usuario" name="btn_cambiar_clave_usuario" class="btn btn-primary btn-block">Enviar</button>
          </div>



          <!-- /.col -->
        </div>
      </form>

       


  
    </div>
    <!-- /.login-card-body -->
  </div>

</div>
<!-- /.login-box -->

  <script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js" ></script>

  <script src="../dist/js/sweetalert2.min.js"></script>

  <script src="../dist/js/main.js"></script>

<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>


<script>

   $(document).ready( function (){
 
   $('#show-hide-passwd').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#txt_claveactual').removeAttr('type');
      $('#show-hide-passwd').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#txt_claveactual').attr('type','password');
      $('#show-hide-passwd').addClass('fa-eye').removeClass('fa-eye-slash');
      }
       });
 
       });

    $(document).ready( function (){
 
   $('#show-hide-passwd1').click(function(){
      if($(this).hasClass('fa-eye'))
      {
      $('#txt_clavenueva').removeAttr('type');
      $('#show-hide-passwd1').addClass('fa-eye-slash').removeClass('fa-eye');
      }
 
      else
      {
      //Establecemos el atributo y valor
      $('#txt_clavenueva').attr('type','password');
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
                          title: "Clave actualizada correctamente",
                          showConfirmButton: false,
                          timer: 3000
                          }) </script>';
                    }
                    if ($msj==3) 
                    {
                               echo '<script type="text/javascript">
                          
                          Swal.fire({
  position: "center",
  icon: "info",
  title: "Clave incorrecta, verificar su clave actual",
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
  title: "La clave nueva debe ser diferente a la anterior",
  showConfirmButton: false,
  timer: 3000
})   </script>';
                    }
                    if ($msj==6)
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