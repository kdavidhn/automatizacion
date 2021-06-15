<?php
session_start();
ob_start();
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
        text: "Lo sentimos el período ya existe",
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
        text: "Los datos se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
</script>';



        $sqltabla = "select * FROM tbl_periodo";
        $resultadotabla = $mysqli->query($sqltabla);
    }
    if ($msj == 3) {


        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al actualizar lo sentimos, intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }

    if ($msj == 4) {


        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Periodo no modificable",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }
}


$Id_objeto = 55;
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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A mantenimiento período');


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_periodo'] = "";
    } else {
        $_SESSION['btn_modificar_periodo'] = "disabled";
    }


    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "SELECT *,
    (SELECT tp.descripcion FROM tbl_tipo_periodo AS tp WHERE tp.id_tipo_periodo = tbl_periodo.id_tipo_periodo LIMIT 1) descripcion
    
    FROM tbl_periodo";
    $resultadotabla = $mysqli->query($sqltabla);



    /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
    if (isset($_GET['fecha_inicio'])) {
        $sqltabla = "SELECT *,
       (SELECT tp.descripcion FROM tbl_tipo_periodo AS tp WHERE tp.id_tipo_periodo = tbl_periodo.id_tipo_periodo LIMIT 1) descripcion
        
        FROM tbl_periodo";
        $resultadotabla = $mysqli->query($sqltabla);

        /* Esta variable recibe el estado de modificar */
        $fecha_inicio = $_GET['fecha_inicio'];

        /* Iniciar la variable de sesion y la crea */
        /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
        $sql = "SELECT *,
        (SELECT tp.descripcion FROM tbl_tipo_periodo AS tp WHERE tp.id_tipo_periodo = tbl_periodo.id_tipo_periodo LIMIT 1) descripcion
        
        FROM tbl_periodo WHERE fecha_inicio = '$fecha_inicio'";
        $resultado = $mysqli->query($sql);
        /* Manda a llamar la fila */
        $row = $resultado->fetch_array(MYSQLI_ASSOC);

        /* Aqui obtengo el id_actividad de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
        $_SESSION['id_periodo'] = $row['id_periodo'];
        $_SESSION['num_periodo'] = $row['num_periodo'];
        $_SESSION['num_anno'] = $row['num_anno'];
        $_SESSION['fecha_inicio'] = $row['fecha_inicio'];
        $_SESSION['fecha_final'] = $row['fecha_final'];
        $_SESSION['descripcion'] = $row['descripcion'];
        $_SESSION['fecha_adic_canc'] = $row['fecha_adic_canc'];
        $_SESSION['id_tipo_periodo'] = $row['id_tipo_periodo'];
        /*Aqui levanto el modal*/

        if (isset($_SESSION['fecha_inicio'])) {


?>
            <script>
                $(function() {
                    $('#modal_modificar_periodo').modal('toggle')

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


                        <h1>PERÍODO
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento_carga.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_periodo_vista.php">Nuevo Período</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->

        <div class="card card-default">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
                <br>
                <div class=" px-12">
                    <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
                </div>
            </div>
            <div class="card-body">

                <table id="tabla14" class="table table-bordered table-striped">



                    <thead>
                        <tr>
                            <th hidden>ID </th>
                            <th>N. PERÍODO</th>
                            <th>AÑO</th>
                            <th>FECHA INICIO </th>
                            <th>FECHA FINAL</th>
                            <th>TIPO PERÍODO </th>
                            <th>ADICIONES/CANCELACIONES</th>
                            <th>MODIFICAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <td hidden><?php echo $row['id_periodo']; ?></td>
                                <td><?php echo $row['num_periodo']; ?></td>
                                <td><?php echo $row['num_anno']; ?></td>
                                <td><?php echo $row['fecha_inicio']; ?></td>
                                <td><?php echo $row['fecha_final']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                                <td><?php echo $row['fecha_adic_canc']; ?></td>


                                <td style="text-align: center;">

                                <a href="../vistas/mantenimiento_periodo_vista.php?fecha_inicio=<?php echo $row['fecha_inicio'];?>" class="btn btn-primary btn-raised btn-xs">
                                        <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_periodo'] ?> "></i>
                                    </a>
                                </td>

                                <td style="text-align: center;">

                                    <form action="../Controlador/eliminar_periodo_controlador.php?id_periodo=<?php echo $row['id_periodo']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                        <button type="submit" class="btn btn-danger btn-raised btn-xs">

                                            <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_periodo'] ?> "></i>
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

    <form action="../Controlador/actualizar_periodo_controlador.php?id_periodo=<?php echo $_SESSION['id_periodo']; ?>" method="post" data-form="update" autocomplete="off">



        <div class="modal fade" id="modal_modificar_periodo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Actualizar Período</h4>
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

                                        <label>Número Período</label>
                                        <input class="form-control" readonly type="text" id="num_periodo" name="num_periodo" style="text-transform: uppercase" onkeypress="return Numeros(event)" value="<?php echo $_SESSION['num_periodo']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Año Académico</label>
                                        <input class="form-control" readonly type="text" id="num_anno" name="num_anno" style="text-transform: uppercase" onkeypress="return Numeros(event)" value="<?php echo $_SESSION['num_anno']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Inicio del Período</label>
                                        <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $_SESSION['fecha_inicio']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Finalización del Período</label>
                                        <input class="form-control" type="date" id="fecha_final" name="fecha_final" value="<?php echo $_SESSION['fecha_final']; ?>">
                                    </div>

                                    <div class="form-group" hidden>
                                        <label>Finalización del Período</label>
                                        <input class="form-control" hidden type="date" id="final_modificar" name="final_modificar" value="<?php echo $_SESSION['fecha_final']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Adiciones/Cancelaciones</label>
                                        <input class="form-control" type="date" id="fecha_adic_canc" name="fecha_adic_canc" value="<?php echo $_SESSION['fecha_adic_canc']; ?>">
                                    </div>

                                    <div class="form-group ">
                          <label class="control-label">Tipo de Período</label>
                          <select class="form-control" name="tipo_p" required="">
        <option value="0"  >Seleccione una opción:</option>
                  <?php

          if(isset($_SESSION['id_tipo_periodo']))
          {
                $query = $mysqli -> query ("select * FROM tbl_tipo_periodo  where id_tipo_periodo<>$_SESSION[id_tipo_periodo] ");
                while ($resultado = mysqli_fetch_array($query)) 
                {
                echo '<option value="'.$resultado['id_tipo_periodo'].'"  > '.$resultado['descripcion'].'</option>' ;
                }

                        echo '<option value="'.$_SESSION['id_tipo_periodo'].'" selected="" >  '.$_SESSION['descripcion'].'</option>' ;
          } 
          else
          {
              $query = $mysqli -> query ("select * FROM tbl_tipo_periodo ");
              while ($resultado = mysqli_fetch_array($query))
               {
               echo '<option value="'.$resultado['id_tipo_periodo'].'"  > '.$resultado['descripcion'].'</option>' ;
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
                        <button type="submit" class="btn btn-primary" id="btn_modificar_periodo" name="btn_modificar_periodo" <?php echo $_SESSION['btn_modificar_periodo']; ?>>Guardar Cambios</button>
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

            $('#tabla16').DataTable({
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
<script type="text/javascript" language="javascript">
    function ventana() {
        window.open("../Controlador/reporte_mantenimiento_periodo_controlador.php", "REPORTE");
    }
</script>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: 'Seleccione una opcion',
            theme: 'bootstrap4',
            tags: true,
        });

    });
</script>

<script type="text/javascript" src="../js/ca2.js"></script>

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

