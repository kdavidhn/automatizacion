<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$sql="SELECT DATE_FORMAT(hora,'%H:%i') hora,jornada,fecha,id_horario_himno,cupos FROM `tbl_horario_himno`";
$resultado = $mysqli->query($sql);

$Id_objeto=43; 

$usuario = $_SESSION['usuario'];

$permiso ="SELECT c.aprobado FROM 
tbl_carta_egresado c, tbl_usuarios u, tbl_personas p
WHERE u.id_persona = p.id_persona
AND c.id_persona = p.id_persona
AND u.Usuario = '$usuario'";
$resultadop=$mysqli->query($permiso);

$row3 = $resultadop->fetch_array(MYSQLI_ASSOC);

if($row3['aprobado']==='desaprobado'){
  echo '<script type="text/javascript">
      swal({
            title:"",
            text:"Lo sentimos no tiene permiso de visualizar la pantalla",
            type: "error",
            showConfirmButton: false,
            timer: 4000
          });
      window.location = "../vistas/pagina_principal_vista.php";

       </script>';
}


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

$sql=$mysqli->prepare("SELECT nombre,documento FROM tbl_usuarios u, tbl_personas p
WHERE u.id_persona = p.id_persona
AND u.Usuario = ?");
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
            <h1>Horarios Para Realizar Examen del Himno</h1>
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
      
<form action="../controlador/alumno_himno_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax" enctype="multipart/form-data">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Horarios de Examen</h3>

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
                            <input class="form-control" type="text" id="txt_nombre" name="txt_nombre" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" value="<?php echo $row2['nombre'] ?>" readonly onmousedown="return false;" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                        <label >Jornada</label>
                            <select class="form-control" type="text" id="txt_jornada" name="txt_jornada" onchange='cambioOpciones();'>
                            <option disabled selected> Seleccione su Jornada</option>
                            <?php while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
                            <option value="<?php echo $row['id_horario_himno'].' '.$row['fecha'].' '.$row['hora'].' '.$row['cupos']; ?>"><?php echo $row['jornada']; ?></option>
                            <?php }?>
                            </select> 
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label >Cupos Disponibles</label>
                            <input class="form-control" type="text" id="txt_horario" name="txt_horario" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" readonly onmousedown="return false;" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label >Fecha</label>
                            <input class="form-control" type="text" id="txt_fecha" name="txt_fecha" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" readonly onmousedown="return false;" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label >Hora</label>
                            <input class="form-control" type="text" id="txt_hora" name="txt_hora" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" readonly onmousedown="return false;" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <input class="form-control" type="hidden" id="id" name="id" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" readonly onmousedown="return false;" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <input class="form-control" type="hidden" id="txt_cuenta" name="txt_cuenta" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" value="<?php echo $row2['documento'] ?>" readonly onmousedown="return false;" >
                        </div>
                </div>
                <!--fin legend-->
                
            </div>
            <p class="text-center form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_himno"  ><i class="zmdi zmdi-floppy"></i> Guardar</button>
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

<script type="text/javascript">

// funcion que se ejecuta cada vez que se selecciona una opción

function cambioOpciones()

{


    var cadena = document.getElementById('txt_jornada').value;
    separador = " ", // un espacio en blanco
    arregloDeSubCadenas = cadena.split(separador);
   
    document.getElementById('id').value=arregloDeSubCadenas[0];
    document.getElementById('txt_horario').value=arregloDeSubCadenas[3]
    document.getElementById('txt_fecha').value=arregloDeSubCadenas[1];
    document.getElementById('txt_hora').value=arregloDeSubCadenas[2];
    

}

</script>


</body>
</html>