<?php
ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/conexion_mantenimientos.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=237; 

$visualizacion= permiso_ver($Id_objeto);
$id_actividad1=$_POST['id_actividad_cve'];
$_SESSION['id_actividad_cve']=$id_actividad1;

$query = $mysqli -> query ( " SELECT a.id_actividad_voae, a.no_solicitud, a.fch_solicitud, a.nombre_actividad, a.ubicacion, a.fch_inicial_actividad, a.fch_final_actividad, a.id_usuario_registro, a.staff_alumnos, a.id_ambito, b.nombre_ambito
  FROM tbl_voae_actividades AS a inner join tbl_voae_ambitos as b on a.id_ambito = b.id_ambito 
  WHERE id_actividad_voae='$id_actividad1'");  
$resultado = mysqli_fetch_array($query);



if($visualizacion==0){
  echo '<script type="text/javascript">
  swal({
    title:"",
    text:"Lo sentimos no tiene permiso de visualizar la pantalla",
    type: "error",
    showConfirmButton: false,
    timer: 3000
    });
    window.location = "../vistas/actividades_externas_cve_vista.php";

    </script>'; 
  }else{
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A LA LISTA DE ASISTENCIA DE LA ACTIVIDAD EXTERNA CON EL ID: '.$id_actividad1);
  }
  if (permisos::permiso_insertar($Id_objeto)==0)
  {
    $_SESSION["btnagregar"]="hidden";
  }
  else
  {
    $_SESSION["btnagregar"]="";
  }
ob_end_flush();
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><I>LISTA DE ASISTENCIA - ACTIVIDAD EXTERNA</I></h1>
          </div>
          <div class="col-sm-6">
                  
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="../vistas/horas_voae_cve_vista.php"> Horas VOAE</a></li>
                    <li class="breadcrumb-item"><a href="../vistas/actividades_externas_cve_vista.php"> Actividades Externas</a></li>
              <li class="breadcrumb-item active"><a > Asistencia Actividad</a></li>
            </ol>
            
          </div>
          <div class="RespuestaAjax"></div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->        
    <!-- Main content -->
    <section class="content">


      <div class="col-md-12">

        <div class="box">
          <div class="box-header with-border">
            <div class="row"> 

              <div class="col-sm-9">
                <h5><i><b> &nbsp;&nbsp;&nbsp;ACTIVIDAD: </b><?php  echo $resultado['nombre_actividad'];?>
                <br><b>&nbsp;&nbsp; FECHA: </b><?php  echo $resultado['fch_inicial_actividad'];?>
                <br><b>&nbsp;&nbsp; CATEGORIA: </b><?php  echo $resultado['nombre_ambito'];?>
                <br><b>&nbsp;&nbsp; ENTE ORGANIZADOR: </b><?php  echo $resultado['staff_alumnos'];?></i></h5>
              </div>

             


          

        </div> <!-- div row after box header -->





      </div><!-- div header -->



    </div><!-- div box -->
    <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------- /.box-header -->
    <!-- centro -->
    <div class="table-responsive" id="listadoregistros">
      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
        <thead>
          
          <th>Cuenta</th>
          <th>Estudiante</th>
          <th>Cantidad Horas</th>
        </thead>
        <tbody>                            
        </tbody>
      </table>
    </div>
    
  </div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<script type="text/javascript" src="../js/act_externa_detalle.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>


<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: 'Seleccione una opcion',
            theme: 'bootstrap4',
            tags: true,
        });

    });
</script>

<script src="../plugins/select2/js/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
</script>


<!-- Scrip de Validacion para el texto de los inputs -->
<script>
  function Card(event, el){//Validar nombre	
      //Obteniendo posicion del cursor 
      var val = el.value;//Valor de la caja de texto
      var pos = val.slice(0, el.selectionStart).length;
    
      var out = '';//Salida
      var filtro = '1234567890\n/';
      var v = 0;//Contador de caracteres validos
    
      //Filtar solo los numeros
      for (var i=0; i<val.length; i++){
        if (filtro.indexOf(val.charAt(i)) != -1){
        v++;
        out += val.charAt(i);		   
        
      }
      }
      //Reemplazando el valor
      el.value = out;
    
      //En caso de modificar un numero reposicionar el cursor
      if(event.keyCode==8){//Tecla borrar precionada
          el.selectionStart = pos;
          el.selectionEnd = pos;
      }
  }
</script>

</body>
</html>