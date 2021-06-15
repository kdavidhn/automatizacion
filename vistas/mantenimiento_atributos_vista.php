<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos el atributo ya existe",
        type: "info",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }

  if ($msj == 2) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Los datos  se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
</script>';



    $sqltabla = "SELECT *, 
    (SELECT tp.tipo_persona from tbl_tipos_persona as tp where tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS  tipo_persona
     from tbl_atributos";
//     "SELECT tbl_atributos.id_atributos AS id_atributos,tbl_atributos.atributo AS atributo , tbl_atributos.requerido As requerido, tbl_atributos.id_tipo_persona AS id_tipo_persona,
// (SELECT tp.tipo_persona FROM tbl_tipos_persona tp WHERE tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS TipoPersona
// FROM tbl_atributos";
    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al actualizar lo sentimos,intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }
}


$Id_objeto = 80;
$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
  // header('location:  ../vistas/menu_roles_vista.php');
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_roles_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento Atributos');


  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_atributo'] = "";
  } else {
    $_SESSION['btn_modificar_atributo'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "SELECT *, 
  (SELECT tp.tipo_persona from tbl_tipos_persona as tp where tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS  tipo_persona
   from tbl_atributos";
  // "SELECT tbl_atributos.id_atributos AS id_atributos,tbl_atributos.atributo AS atributo , tbl_atributos.requerido As requerido, tbl_atributos.id_tipo_persona AS id_tipo_persona,
  // (SELECT tp.tipo_persona FROM tbl_tipos_persona tp WHERE tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS TipoPersona
  // FROM tbl_atributos";
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
  if (isset($_GET['atributo'])) {
    $sqltabla = "SELECT *, 
    (SELECT tp.tipo_persona from tbl_tipos_persona as tp where tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS  tipo_persona
     from tbl_atributos";
    // "SELECT tbl_atributos.id_atributos AS id_atributos,tbl_atributos.atributo AS atributo , tbl_atributos.requerido As requerido, tbl_atributos.id_tipo_persona AS id_tipo_persona,
    // (SELECT tp.tipo_persona FROM tbl_tipos_persona tp WHERE tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS TipoPersona
    // FROM tbl_atributos";
    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el estado de modificar */
    $atributo = $_GET['atributo'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
    $sql = "SELECT *, 
    (SELECT tp.tipo_persona from tbl_tipos_persona as tp where tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS  tipo_persona
     from tbl_atributos where atributo = '$atributo'";
    // "SELECT tbl_atributos.id_atributos AS id_atributos,tbl_atributos.atributo AS atributo , tbl_atributos.requerido As requerido, tbl_atributos.id_tipo_persona AS id_tipo_persona,
    // (SELECT tp.tipo_persona FROM tbl_tipos_persona tp WHERE tp.id_tipo_persona=tbl_atributos.id_tipo_persona LIMIT 1) AS TipoPersona
    // FROM tbl_atributos where atributo = '$atributo'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
    $_SESSION['id_atributos'] = $row['id_atributos'];
    $_SESSION['atributo'] = $row['atributo'];
    $_SESSION['requerido'] = $row['requerido'];
    $_SESSION['id_tipo_persona'] = $row['id_tipo_persona'];
    $_SESSION['tipo_persona'] = $row['tipo_persona'];



    /*Aqui levanto el modal*/

    if (isset($_SESSION['atributo'])) {


?>
      <script>
        $(function() {
          $('#modal_modificar_atributo').modal('toggle')

        })
      </script>;

      <?php
      ?>

<?php


    }
  }
}

ob_end_flush();


?>
<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
<link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> 
  <title></title>
</head>


<body>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">


            <h1>ATRIBUTOS
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento.php">Menu Mantenimiento</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_atributo_vista.php">Nuevo atributo</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Atributos Existentes</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">
          <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
        </div>
      </div>
      <div class="card-body">

        <table id="tabla1" class="table table-bordered table-striped">



          <thead>
            <tr>
              <th>ATRIBUTOS</th>
              <th>REQUERIDO </th>
              <th>TIPO PERSONA </th>
              <th>MODIFICAR</th>
              <th>ELIMINAR</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $row['atributo']; ?></td>
                <td><?php echo $row['requerido']; ?></td>
                <td><?php echo $row['tipo_persona']; ?></td>

                <td style="text-align: center;">

                  <a href="../vistas/mantenimiento_atributos_vista.php?atributo=<?php echo $row['atributo']; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_atributo'] ?> "></i>
                  </a>
                </td>

                <td style="text-align: center;">

                  <form action="../Controlador/eliminar_atributo_controlador.php?atributo=<?php echo $row['atributo']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                    <button type="submit" class="btn btn-danger btn-raised btn-xs">

                      <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_atributo'] ?> "></i>
                    </button>
                    <div class="RespuestaAjax"></div>
                  </form>
                </td>

              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>


    <!-- /.card-body -->
    <div class="card-footer">

    </div>
  </div>





  <!-- *********************Creacion del modal 

-->

  <form action="../Controlador/actualizar_atributo_controlador.php?id_atributos=<?php echo $_SESSION['id_atributos']; ?>" method="post" data-form="update" autocomplete="off">



    <div class="modal fade" id="modal_modificar_atributo">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Actualizar Atributo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>


          <!--Cuerpo del modal-->
          <div class="modal-body">





            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">

                    <label>Modificar Atributo</label>


                    <input class="form-control" type="text" id="txt_atributo" name="txt_atributo" value="<?php echo $_SESSION['atributo']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_atributo');" onkeypress="return sololetras(event)" maxlength="30">

                  </div>


                  <div class="form-group">
                    <label class="control-label">Requerido</label>

                    <input class="form-control" type="text" id="txt_requerido" name="txt_requerido" value="<?php echo $_SESSION['requerido']; ?>" required style="text-transform: uppercase" onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" maxlength="30" onkeypress="return comprobar(this.value, event, this.id)">

                  </div>

                  <div class="form-group">
                    <label class="control-label">Tipo Persona</label>
                    <select class="form-control" name="persona1" required="">
                    <option value="0">Seleccione una opción</option>

                      <?php

         if(isset($_SESSION['id_tipo_persona']))
          {
                $query = $mysqli -> query ("select * FROM tbl_tipos_persona  where id_tipo_persona<>$_SESSION[id_tipo_persona] ");
                while ($resultado = mysqli_fetch_array($query)) 
                {
                echo '<option value="'.$resultado['id_tipo_persona'].'"  > '.$resultado['tipo_persona'].'</option>' ;
                }

                        echo '<option value="'.$_SESSION['id_tipo_persona'].'" selected="" >  '.$_SESSION['tipo_persona'].'</option>' ;
          } 
          else
          {
              $query = $mysqli -> query ("select * FROM tbl_tipos_persona");
              while ($resultado = mysqli_fetch_array($query))
               {
               echo '<option value="'.$resultado['id_tipo_persona'].'"  > '.$resultado['tipo_persona'].'</option>' ;
               }

          }
          

        ?>
                    </select>
                  </div>
                

                </div>
              </div>
            </div>

          </div>




          <!--Footer del modal-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btn_modificar_atributo" name="btn_modificar_atributo" <?php echo $_SESSION['btn_modificar_atributo']; ?>>Guardar Cambios</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- /.  finaldel modal -->

    <!--mosdal crear -->



  </form>




  <script type="text/javascript">
    $(function() {

      $('#tabla1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script>


</body>

</html>

<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
<script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>
<script type="text/javascript" language="javascript">
  function ventana() {
    window.open("../Controlador/reporte_mantenimiento_atributos_controlador.php", "REPORTE");
  }
</script>

<script type="text/javascript" src="../js/funciones_mantenimientos.js"></script>
<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
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
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
  <!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>