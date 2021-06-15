<?php
ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
    $msj = $_REQUEST['msj'];

    if ($msj == 1) {
        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos el edificio ya existe",
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



        $sqltabla = "select nombre, codigo
FROM tbl_edificios";
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


$Id_objeto = 58;
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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento Edificio');


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_edificio'] = "";
    } else {
        $_SESSION['btn_modificar_edificio'] = "disabled";
    }


    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "select nombre, codigo FROM tbl_edificios";
    $resultadotabla = $mysqli->query($sqltabla);



    /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
    if (isset($_GET['nombre'])) {
        $sqltabla = "select nombre, codigo FROM tbl_edificios";
        $resultadotabla = $mysqli->query($sqltabla);

        /* Esta variable recibe el estado de modificar */
        $nombre = $_GET['nombre'];

        /* Iniciar la variable de sesion y la crea */
        /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
        $sql = "select * FROM tbl_edificios WHERE nombre = '$nombre'";
        $resultado = $mysqli->query($sql);
        /* Manda a llamar la fila */
        $row = $resultado->fetch_array(MYSQLI_ASSOC);

        /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
        $_SESSION['id_edificio'] = $row['id_edificio'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['codigo'] = $row['codigo'];


        /*Aqui levanto el modal*/

        if (isset($_SESSION['nombre'])) {


?>
            <script>
                $(function() {
                    $('#modal_modificar_edificio').modal('toggle')

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


                        <h1>Edificios
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento_carga.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_edificio_vista.php">Nuevo Edificio</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Edificios Existentes</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
                <br>
                <div class=" px-12">
                    <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
                </div>
            </div>
            <div class="card-body">

                <table id="tabla6" class="table table-bordered table-striped">



                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>CÓDIGO</th>
                            <th>MODIFICAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['codigo']; ?></td>

                                <td style="text-align: center;">

                                    <a href="../vistas/mantenimiento_edificio_vista.php?nombre=<?php echo $row['nombre']; ?>" class="btn btn-primary btn-raised btn-xs">
                                        <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_edificio'] ?> "></i>
                                    </a>
                                </td>

                                <td style="text-align: center;">

                                    <form action="../Controlador/eliminar_edificio_controlador.php?nombre=<?php echo $row['nombre']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                        <button type="submit" class="btn btn-danger btn-raised btn-xs">

                                            <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_edificio'] ?> "></i>
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

    <form action="../Controlador/actualizar_edificio_controlador.php?id_edificio=<?php echo $_SESSION['id_edificio']; ?>" method="post" data-form="update" autocomplete="off">



        <div class="modal fade" id="modal_modificar_edificio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Actualizar Edificio</h4>
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

                                        <label>Modificar Edificio</label>


                                        <input class="form-control" type="text" id="txtedificio" name="txtedificio" value="<?php echo $_SESSION['nombre']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txtedificio');" onkeypress="return LetrasyNumeroos(event)" maxlength="30">

                                    </div>


                                    <div class="form-group">
                                        <label class="control-label">Código</label>

                                        <input class="form-control" type="text" id="txtcodigo" name="txtcodigo" value="<?php echo $_SESSION['codigo']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txtcodigo');" onkeypress="return LetrasyNumeros(event)" maxlength="30" onkeypress="return comprobar(this.value, event, this.id)">

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>




                    <!--Footer del modal-->
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btn_modificar_edificio" name="btn_modificar_edificio" <?php echo $_SESSION['btn_modificar_edificio']; ?>>Guardar Cambios</button>
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
            window.open("../Controlador/reporte_mantenimiento_edificios_controlador.php", "REPORTE");
        }
    </script>


    <script type="text/javascript">
        $(function() {

            $('#tabla6').DataTable({
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