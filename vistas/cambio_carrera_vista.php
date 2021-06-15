<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$sql="select * from tbl_centros_regionales";
$resultado = $mysqli->query($sql);

$sql1= "select * from tbl_facultades";
$resultado1= $mysqli->query($sql1);

$Id_objeto=30; 


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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A SOLICITUD CAMBIO DE CARRERA');
}

$sql=$mysqli->prepare("SELECT p.nombres,p.apellidos
FROM tbl_usuarios u, tbl_personas p, tbl_personas_extendidas pe
WHERE u.id_persona = p.id_persona AND p.id_persona = pe.id_persona AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultado2 = $sql->get_result();
$row2 = $resultado2->fetch_array(MYSQLI_ASSOC);

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
            <h1>Admisión a la Carrera</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/menu_cambio_carrera.php">Admisión a la Carrera</a></li>
              <li class="breadcrumb-item"><a href="../pdf/cambio_carrera.php" target="_blank">Requisitos</a></li>
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
      
<form action="../Controlador/cambio_carrera_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax" enctype="multipart/form-data">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Cambio Carrera</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" type="text" id="txt_nombre" name="txt_nombre" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" value="<?php echo $row2['nombres'].' '.$row2['apellidos'] ?>" <?php echo ('readonly onmousedown="return false;"') ?> >
                            <input class="form-control" type="hidden" id="txt_interno" name="txt_interno" value="interno">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Verifiqué su Nombre</label>
                            <input class="form-control" type="text" id="txt_verificado" name="txt_verificado1"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" placeholder="Colocar acentos en los nombres si los lleva">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Verifiqué su Apellido</label>
                            <input class="form-control" type="text" id="txt_verificado" name="txt_verificado2"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" placeholder="Colocar acentos en los apellidos si los lleva">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Número de Cuenta</label>
                            <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta" style="text-transform: uppercase" onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" maxlength="30" >
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
                            <select class="form-control"  id="txt_centrore" name="txt_centrore">
                            <option disabled selected>Centro Regional de Procedencia</option>
                            <?php while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
                            <option value="<?php  echo $row['Id_centro_regional']; ?>"><?php echo $row['centro_regional']; ?></option>
                            <?php }?>
                            </select> 
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" type="text" id="txt_facultad" name="txt_facultad">
                            <option disabled selected>Facultad de la que viene</option>
                            <?php while($row1 = $resultado1->fetch_array(MYSQLI_ASSOC)) { ?>
                            <option value="<?php echo $row1['Id_facultad']; ?>"><?php echo $row1['nombre']; ?></option>
                            <?php }?>
                            </select> 
                        </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                            <label>Razón del Cambio</label>
                            <textarea class="form-control" type="text" id="txt_razon" name="txt_razon" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" ></textarea>
                        </div>
                </div>

                <!-- legend -->
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Historial académico vigente.</label>             
                            <input class="form-control" type="file" id="txt_historial" name="txt_historial">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Constancia extendida por la VOAE</label>             
                            <input class="form-control" type="file" id="txt_voae" name="txt_voae">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Copia de la tarjeta de identidad.</label>             
                            <input class="form-control" type="file" id="txt_identidad" name="txt_identidad">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Fotografía tamaño carné.</label>             
                            <input class="form-control" type="file" id="txt_foto" name="txt_foto">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Copia del Carné Estudiantil</label>             
                            <input class="form-control" type="file" id="txt_carne" name="txt_carne">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Constancia de conducta de la Carrera que cursa Actualmente.</label>             
                            <input class="form-control" type="file" id="txt_conducta" name="txt_conducta">
                        </div>
                </div>
                <!--fin legend-->
                
            </div>
            <p class="text-center form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_cambio_carrera" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
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
