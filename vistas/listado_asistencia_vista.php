<?php
ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/conexion_mantenimientos.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=232; 

$visualizacion= permiso_ver($Id_objeto);
$id_actividad=$_POST['id_actividad_cve'];
$_SESSION['id_actividad_cve']=$id_actividad;

$query = $mysqli -> query ( " SELECT a.id_actividad_voae, a.no_solicitud, a.fch_solicitud, a.nombre_actividad, a.ubicacion, a.fch_inicial_actividad, a.fch_final_actividad, a.id_usuario_registro, a.id_ambito, b.nombre_ambito
  FROM tbl_voae_actividades AS a inner join tbl_voae_ambitos as b on a.id_ambito = b.id_ambito 
  WHERE id_actividad_voae='$id_actividad'");  
$resultado = mysqli_fetch_array($query);

if (empty($id_actividad)){
  header("Location: ../vistas/informe_actividad_cve_vista.php");
  die();

}

if($visualizacion==0){
  echo '<script type="text/javascript">
  swal({
    title:"",
    text:"Lo sentimos no tiene permiso de visualizar la pantalla",
    type: "error",
    showConfirmButton: false,
    timer: 3000
    });
    window.location = "../vistas/menu_actividades_cve_vista.php";

    </script>'; 
  }else{
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A LA LISTA DE ASISTENCIA DE LA ACTIVIDAD ID: '.$id_actividad);
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
            <h1><I>LISTA DE ASISTENCIA</I></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/menu_actividad_cve_vista.php">Menu actividades CVE</a></li>
              <li class="breadcrumb-item"><a href="../vistas/informe_actividad_cve_vista.php">Informes de actividades</a></li>
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
                <br><b>&nbsp;&nbsp; LUGAR: </b><?php  echo $resultado['ubicacion'];?>
                <br><b>&nbsp;&nbsp; FECHA: </b><?php  echo $resultado['fch_inicial_actividad'];?>
                <br><b>&nbsp;&nbsp; CATEGORIA: </b><?php  echo $resultado['nombre_ambito'];?></i></h5>
              </div>

              <div class="col-sm-3" align="right">
                <div class="box" id="formularioexcel">
                <?php if (!isset ($_FILES['dataCliente']) && permisos::permiso_insertar($Id_objeto)=='1') {?>
                  <form name="form_import" id="form_import" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"  enctype="multipart/form-data">
                    <input type="hidden" id="id_actividad_cve" name="id_actividad_cve" value="<?php echo $id_actividad ?>" >
                    <div class="input-group">
                      <div class="custom-file ">                                           
                        <input  type="file" name="dataCliente" id="file-input" class="file-input__input form-control" required="" accept=".csv">
                        <label class="file-input__label" for="file-input">
                          <i class="zmdi zmdi-upload zmdi-hc-2x"></i>
                        </label>
                      </div>

                      <input  type="submit" name="add" id="btn_enviar" class="btn btn-info" placeholder="Importar"/>
                    </div>




                  </form>
              <?php } ?>

            </div>

            <div class="row"> 
            <div class="col-sm-3 text-right">
              <h1 align="right"><button class="btn btn-success" name="btnagregar" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> 
              onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Estudiante</button></h1>
              <div class="box-tools pull-right">
              </div>
            </div>
          </div>

          </div>


          

        </div> <!-- div row after box header -->





      </div><!-- div header -->



    </div><!-- div box -->
    <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------- /.box-header -->
    <!-- centro -->
    <div class="table-responsive" id="listadoregistros">
      <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
        <thead>
          <th>OPCIÓN</th>
          <th>CUENTA</th>
          <th>ESTUDIANTE</th>
          <th>cant_horas</th>
          <th>CARRERA</th>
        </thead>
        <tbody>                            
        </tbody>
      </table>
    </div>
    <div class="panel-body"  id="formularioregistros">
      <!-- Inicio del Formulario --> 
      <form name="formulario" id="formulario" method="POST">  
        <input class="form-control" type="hidden" id="id_actividad_voae" name="id_actividad_voae" value="<?php echo $id_actividad; ?>">
        <input class="form-control" type="hidden" id="id_asistencia" name="id_asistencia" value="">   
        <input class="form-control" type="hidden" id="id_cuenta2" name="id_cuenta2" value="">            
        <!-- Card  5 Desarrollo-->
        <div class ="card card-default">
          <div class="card-header bg-gradient-dark">
            <h3 class="card-title">Agregar Asistente</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">                    
              <!-- CUENTA-->   
              <div class="col-sm-6">
                <div class="form-group">
                  <label>CUENTA: </label>
                  <select class="form-control-lg select2"  style="width: 100%;" id="cuenta" name="cuenta" required="" >
                        <option  disabled="disabled" >Cuenta:</option>
                          <?php
                            $query = $mysqli -> query ("SELECT cuenta, nombre_alumno
                            FROM `tbl_voae_asistencias` as a 
                            JOIN tbl_personas_extendidas as p
                            GROUP by a.cuenta;");
                            while ($resultado = mysqli_fetch_array($query)) {
                              echo '<option value="'.$resultado['cuenta'].'"> '.$resultado['cuenta'].'</option>' ;
                            }
                          ?>
                    </select>
                </div>
              </div>
              <!-- NOMBRE -->   
              <div class="col-sm-6">
                <div class="form-group">
                  <label>NOMBRE: </label>
                  <input class="form-control" type="text" id="nombre_alumno" name="nombre_alumno" required="" maxlength="50" style="text-transform: uppercase"   onkeypress="return Letras(event)"  onkeypress="return comprobar(this.value, event, this.id)">
                </div>
              </div> 
              <!-- CARRERA -->   
              <div class="col-sm-6">
                <div class="form-group">
                  <label>CARRERA:</label>
                  <select class="form-control-lg select2" id= "carrera" style="width: 100%;" name="carrera" required="">
                    <option  value="" disabled="disabled">Seleccione una carrera:</option>
                    <?php
                    $query = $mysqli -> query ("SELECT * FROM tbl_carrera");
                    while ($resultado = mysqli_fetch_array($query)) {
                      echo '<option value="'.$resultado['Descripcion'].'"> '.$resultado['Descripcion'].'</option>' ;
                    }
                    ?>
                  </select>
                </div>
              </div> 
              <!-- HORAS -->   
              <div class="col-sm-6">
                <div class="form-group">
                  <label>cant_horas: </label>
                  <input class="form-control" type="number" id="cant_horas" name="cant_horas" required="" min="1" style="text-transform: uppercase" >
                </div>
              </div>         
            </div>
          </div>
        </div>

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
          <button class="btn btn-primary" type="submit" name= "btnGuardar" id="btnGuardar" ><i class="fa fa-save"></i> Guardar</button>
          <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
        </div>
      </form>

    </div>  <!--Fin formulario -->

  </div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<script type="text/javascript" src="../js/listado_asistencia.js"></script>
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