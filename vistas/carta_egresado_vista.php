<?php
ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=31; 
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A SOLICITUD CARTA DE EGRESADO');

}

            $sql=$mysqli->prepare("SELECT  p.nombres,p.apellidos, e.jefe_inmediato,e.nombre_empresa
            FROM tbl_usuarios u, tbl_personas p, tbl_empresas_practica e 
            WHERE u.id_persona = p.id_persona
            AND p.id_persona = e.id_persona 
            AND u.Usuario = ?"); 
            $sql->bind_param("s",$_SESSION['usuario']);
            $sql->execute();
            $resultado = $sql->get_result();
            $row = $resultado->fetch_array(MYSQLI_ASSOC);

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
            <h1>Solicitud de Carta de Egresado</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
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
      
<form action="../Controlador/carta_egresado_controlador.php" method="POST"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Carta de Egresado</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre del alumno</label>
                            <input class="form-control" type="text" id="txt_nombre" name="txt_nombre" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" value="<?php echo $row['nombres'].' '.$row['apellidos'] ?>" readonly onmousedown="return false;">
                        </div>
                </div>

                <div class="col-md-6">
                        <div class="form-group">
                            <label>Verifiqué su Nombre</label>
                            <input class="form-control" type="text" id="txt_apellido" name="txt_verificado1"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" placeholder="Colocar acentos en los nombres si los lleva">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Verifiqué su Apellido</label>
                            <input class="form-control" type="text" id="txt_apellido" name="txt_verificado2"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" placeholder="Colocar acentos en los apellidos si los lleva">
                        </div>
                </div>

                <div class="col-md-6">
                        <div class="form-group">
                            <label>Número de Cuenta</label>
                            <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta" style="text-transform: uppercase" onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" maxlength="30">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Correo Electrónico Institucional</label>
                            <input class="form-control" type="email" id="txt_correo" name="txt_correo" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)" maxlength="30" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Carta de Finalización de Práctica</label>                   
                            <input class="form-control" type="file" id="txt_finalizacion" name="txt_finalizacion">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Certificado de Notas</label>                   
                            <input class="form-control" type="file" id="txt_certificado" name="txt_certificado">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Copia de Certificado de Trabajo Comunitario</label>                   
                            <input class="form-control" type="file" id="txt_comunitario" name="txt_comunitario">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Copia de Tarjeta de Identidad</label>                   
                            <input class="form-control" type="file" id="txt_identidad" name="txt_identidad">
                        </div>
                </div>
            </div>
            <p class="text-center form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_carta_egresado" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
            </p>
          </div>



          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>
         
         
    
    <div class="RespuestaAjax"></div>
</form>

  </div>
</section>


</div>
<script>
$('input[type="file"]').on('change', function(){
  var ext = $( this ).val().split('.').pop();
  if ($( this ).val() != '') {
    if(ext == "pdf" || ext == "PDF"){
      if($(this)[0].files[0].size > 1048576){
        swal({
                     title:"",
                     text:"excede el tamaño permitido...",
                     type: "error",
                     showConfirmButton: false,
                     timer: 2000
                  });
             
        $(this).val('');
      }
    }
    else
    {
      $( this ).val('');
      swal({
                     title:"",
                     text:"Extensión no permitida: " + ext,
                     type: "error",
                     showConfirmButton: false,
                     timer: 2000
                  });
    }
  }
});
</script>

</body>
</html>
