<?php
ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=40; 
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
}
if (isset($_GET['alumno'])){

    $sqltabla = json_decode( file_get_contents("http://localhost:80/automatizacion/api/himno_api.php?alumno=".$_GET['alumno']), true );
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REVISION ALUMNO HIMNO '.$sqltabla["ROWS"][0]['nombre'].'');
}

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
            <h1>Imprimir Documento</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/lista_alumnos_himno.php?jornada=<?php echo $_GET['jornada'] ?>">Lista de alumnos Himno</a></li>
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
      
<form action="../Controlador/alumno_himno_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del Estudiante</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre del Alumno</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['nombre'] ?>" type="text" id="txt_nombre" name="txt_nombre1" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;" >
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Numero de Cuenta</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['documento']  ?>" type="text" id="txt_cuenta" name="txt_cuenta" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Correo Electronico</label>
                            <input class="form-control" value="<?php echo $sqltabla["ROWS"][0]['valor'] ?>" type="email" id="txt_correo" name="txt_correo" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <label>Seleccione su aprobación</label>
                            <select class="form-control" id="aprobado" name="aprobado" onchange="Mostrarlink();">
                              <option disabled selected>Aprobar</option>
                              <option value="aprobado">SI</option>
                              <option value="desaprobar">NO</option>
                            </select>
                        </div>
                </div>
                <div class="col-md-6">
                      <div class="form-group">
                        
                            <a style="margin-top: 32px;"  class="badge-warning btn-sm text-center form-group" href="http://localhost:8055/Automatizacion/PDF/himno.php?cuenta=<?php echo $sqltabla['ROWS'][0]['documento'] ?>" id="documento" name="documento" target="_blank">Imprimir Documento</a>
                        
                      </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group">
                            <input class="form-control" value="<?php echo $_GET['jornada'] ?>" type="hidden" id="txt_jornada" name="txt_jornada"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly onmousedown="return false;">
                        </div>
                </div>
            </div>
            <p class="text-center form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_cambio" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
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
 
 document.getElementById("documento").style.display="none";

 function Mostrarlink()
{
/* Para obtener el valor */
var aprobado = document.getElementById("aprobado").value;

  if (aprobado == "aprobado") {
       
    
    document.getElementById("documento").style.display="block";

    }
    else {
      
      
      document.getElementById("documento").style.display="none";
   }

}

</script>

</body>
</html>