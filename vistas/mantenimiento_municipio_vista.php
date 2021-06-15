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
        text: "Lo sentimos el municipio ya existe",
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
(SELECT d.departamento FROM tbl_departamentos as d WHERE d.id_departamento= tbl_municipios_hn.id_departamento LIMIT 1) AS departamento
FROM tbl_municipios_hn";
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


$Id_objeto = 79;
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento Municipio');


  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_municipio'] = "";
  } else {
    $_SESSION['btn_modificar_municipio'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  /*$sqltabla = "select  municipio, codigo, id_departamento FROM tbl_municipios_hn";*/
  $sqltabla="SELECT *,
(SELECT d.departamento FROM tbl_departamentos as d WHERE d.id_departamento= tbl_municipios_hn.id_departamento LIMIT 1) AS departamento
FROM tbl_municipios_hn";
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
  if (isset($_GET['municipio'])) {
    $sqltabla = "SELECT *,
(SELECT d.departamento FROM tbl_departamentos as d WHERE d.id_departamento= tbl_municipios_hn.id_departamento LIMIT 1) AS departamento
FROM tbl_municipios_hn";
    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el estado de modificar */
    $municipio = $_GET['municipio'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
    $sql = "SELECT *,
(SELECT d.departamento FROM tbl_departamentos as d WHERE d.id_departamento= tbl_municipios_hn.id_departamento LIMIT 1) AS departamento
FROM tbl_municipios_hn WHERE municipio = '$municipio'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
    $_SESSION['id_municipio'] = $row['id_municipio'];
    $_SESSION['municipio'] = $row['municipio'];
    $_SESSION['codigo'] = $row['codigo'];
    $_SESSION['id_departamento'] = $row['id_departamento'];
     $_SESSION['departamento'] = $row['departamento'];
    


    /*Aqui levanto el modal*/

    if (isset($_SESSION['municipio'])) {


?>
      <script>
        $(function() {
          $('#modal_modificar_municipio').modal('toggle')

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


            <h1>MUNICIPIOS
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento.php">Menu Mantenimiento</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_municipio_vista.php">Nuevo municipio</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Municipios Existentes</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">
          <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
        </div>
      </div>
      <div class="card-body">

        <table id="tabla12" class="table table-bordered table-striped">



          <thead>
            <tr>
            
              <th>MUNICIPIOS</th>
              <th>CÓDIGO </th>
              <th>DEPARTAMENTO </th>
              <th>MODIFICAR</th>
              <th>ELIMINAR</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $row['municipio']; ?></td>
                <td><?php echo $row['codigo']; ?></td>
                <td><?php echo $row['departamento']; ?></td>

                <td style="text-align: center;">

                  <a href="../vistas/mantenimiento_municipio_vista.php?municipio=<?php echo $row['municipio']; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_municipio'] ?> "></i>
                  </a>
                </td>

                <td style="text-align: center;">

                  <form action="../Controlador/eliminar_municipio_controlador.php?municipio=<?php echo $row['municipio']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                    <button type="submit" class="btn btn-danger btn-raised btn-xs">

                      <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_municipio'] ?> "></i>
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

  <form action="../Controlador/actualizar_municipio_controlador.php?id_municipio=<?php echo $_SESSION['id_municipio']; ?>" method="post" data-form="update" autocomplete="off">



    <div class="modal fade" id="modal_modificar_municipio">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Actualizar Municipio</h4>
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

                    <label>Modificar Municipio</label>
                    <input class="form-control" type="text" id="txt_municipio" name="txt_municipio" value="<?php echo $_SESSION['municipio']; ?>" required="" maxlength="30" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_municipio');" onkeypress="return sololetras(event)" onkeypress="return comprobar(this.value, event, this.id)">




                  </div>


                  <div class="form-group">
                    <label class="control-label">Código</label>

                    <input class="form-control" type="text" id="txt_codigo" name="txt_codigo" value="<?php echo $_SESSION['codigo']; ?>" required style="text-transform: uppercase" onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" maxlength="30" onkeypress="return comprobar(this.value, event, this.id)">

                  </div>

                 <div class="form-group ">
                          <label class="control-label">Departamentos</label>
                          <select class="form-control" name="departamento1" required="">
        <option value="0"  >Seleccione un Departamento:</option>
                  <?php

          if(isset($_SESSION['id_departamento']))
          {
                $query = $mysqli -> query ("select * FROM tbl_departamentos  where id_departamento<>$_SESSION[id_departamento] ");
                while ($resultado = mysqli_fetch_array($query)) 
                {
                echo '<option value="'.$resultado['id_departamento'].'"  > '.$resultado['departamento'].'</option>' ;
                }

                        echo '<option value="'.$_SESSION['id_departamento'].'" selected="" >  '.$_SESSION['departamento'].'</option>' ;
          } 
          else
          {
              $query = $mysqli -> query ("select * FROM tbl_departamentos ");
              while ($resultado = mysqli_fetch_array($query))
               {
               echo '<option value="'.$resultado['id_departamento'].'"  > '.$resultado['departamento'].'</option>' ;
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
            <button type="submit" class="btn btn-primary" id="btn_modificar_municipio" name="btn_modificar_municipio" <?php echo $_SESSION['btn_modificar_municipio']; ?>>Guardar Cambios</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- /.  finaldel modal -->

    <!--mosdal crear -->



  </form>
  <script type="text/javascript" language="javascript">
    function ventana() {
      window.open("../Controlador/reporte_mantenimiento_municipio_controlador.php", "REPORTE");
    }
  </script>



  <script type="text/javascript">
    $(function() {

      $('#tabla12').DataTable({
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

  <script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
  <script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>
</body>

</html>

<script type="text/javascript" src="../js/funciones_mantenimientos.js"></script>
<script type="text/javascript" language="javascript">
  $(document).ready(function() {

    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      theme: 'bootstrap4',
      tags: true,
    });

  });
</script>
<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
  <!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>