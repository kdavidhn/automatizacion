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
        text: "Lo sentimos la comision ya existe",
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



        $sqltabla = "SELECT*, 
        (SELECT c.Descripcion FROM tbl_carrera as c where c.id_carrera=tbl_comisiones.id_carrera Limit 1) AS Descripcion
        FROM tbl_comisiones";
        // "SELECT tbl_comisiones.id_comisiones AS id_comisiones,tbl_comisiones.comision AS comision,tbl_comisiones.id_carrera AS id_carrera,
        // (SELECT c.Descripcion FROM tbl_carrera c WHERE c.id_carrera=tbl_comisiones.id_carrera LIMIT 1) AS carrera
        // FROM tbl_comisiones";
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


$Id_objeto = 57;
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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento Comisiones');


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_comision'] = "";
    } else {
        $_SESSION['btn_modificar_comision'] = "disabled";
    }



    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "SELECT*, 
    (SELECT c.Descripcion FROM tbl_carrera as c where c.id_carrera=tbl_comisiones.id_carrera Limit 1) AS Descripcion
    FROM tbl_comisiones";
    // "SELECT tbl_comisiones.id_comisiones AS id_comisiones,tbl_comisiones.comision AS comision,tbl_comisiones.id_carrera AS id_carrera,
    // (SELECT c.Descripcion FROM tbl_carrera c WHERE c.id_carrera=tbl_comisiones.id_carrera LIMIT 1) AS carrera
    // FROM tbl_comisiones";
    $resultadotabla = $mysqli->query($sqltabla);



    /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
    if (isset($_GET['comision'])) {
        $sqltabla = "SELECT*, 
        (SELECT c.Descripcion FROM tbl_carrera as c where c.id_carrera=tbl_comisiones.id_carrera Limit 1) AS Descripcion
        FROM tbl_comisiones";
        // "SELECT tbl_comisiones.id_comisiones AS id_comisiones,tbl_comisiones.comision AS comision,tbl_comisiones.id_carrera AS id_carrera,
        // (SELECT c.Descripcion FROM tbl_carrera c WHERE c.id_carrera=tbl_comisiones.id_carrera LIMIT 1) AS carrera
        // FROM tbl_comisiones";
        $resultadotabla = $mysqli->query($sqltabla);

        /* Esta variable recibe el estado de modificar */
        $comision = $_GET['comision'];

        /* Iniciar la variable de sesion y la crea */
        /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
        $sql = "SELECT*, 
        (SELECT c.Descripcion FROM tbl_carrera as c where c.id_carrera=tbl_comisiones.id_carrera Limit 1) AS Descripcion
        FROM tbl_comisiones where comision ='$comision'";
        // "SELECT tbl_comisiones.id_comisiones AS id_comisiones,tbl_comisiones.comision AS comision,tbl_comisiones.id_carrera AS id_carrera,
        // (SELECT c.Descripcion FROM tbl_carrera c WHERE c.id_carrera=tbl_comisiones.id_carrera LIMIT 1) AS carrera
        // FROM tbl_comisiones where comision ='$comision'";
        $resultado = $mysqli->query($sql);
        /* Manda a llamar la fila */
        $row = $resultado->fetch_array(MYSQLI_ASSOC);

        /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
        $_SESSION['id_comisiones'] = $row['id_comisiones'];
        $_SESSION['comision'] = $row['comision'];
        $_SESSION['id_carrera'] = $row['id_carrera'];
        $_SESSION['Descripcion'] = $row['Descripcion'];


        /*Aqui levanto el modal*/

        if (isset($_SESSION['comision'])) {


?>
            <script>
                $(function() {
                    $('#modal_modificar_comision').modal('toggle')

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


                        <h1>Mantenimiento Comisiones
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_comisiones_vista.php">Nueva Comisión</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Comisiones Existentes</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
                <br>
                <div class=" px-12">
                    <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
                </div>
            </div>
            <div class="card-body">

                <table id="tabla4" class="table table-bordered table-striped">



                    <thead>
                        <tr>
                            <th>COMISIÓN</th>
                            <th>CARRERA </th>
                            <th>MODIFICAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['comision']; ?></td>
                                <td><?php echo $row['Descripcion']; ?></td>

                                <td style="text-align: center;">

                                    <a href="../vistas/mantenimiento_comisiones_docente_vista.php?comision=<?php echo $row['comision']; ?>" class="btn btn-primary btn-raised btn-xs">
                                        <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_comision'] ?> "></i>
                                    </a>
                                </td>

                                <td style="text-align: center;">

                                    <form action="../Controlador/eliminar_comision_controlador.php?comision=<?php echo $row['comision']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                        <button type="submit" class="btn btn-danger btn-raised btn-xs">

                                            <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_comision'] ?> "></i>
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

    <form action="../Controlador/actualizar_comision_controlador.php?id_comisiones=<?php echo $_SESSION['id_comisiones']; ?>" method="post" data-form="update" autocomplete="off">



        <div class="modal fade" id="modal_modificar_comision">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Actualizar Comisión</h4>
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

                                        <label>Modificar Comisión</label>


                                        <input class="form-control" type="text" id="txtcomision" name="txtcomision" value="<?php echo $_SESSION['comision']; ?>" required style="text-transform: uppercase"onkeyup="DobleEspacio(this, event); MismaLetra('txtcomision');" onkeypress="return sololetras(event)" maxlength="30">

                                    </div>


                                    <div class="form-group ">
                                    <label class="control-label">Carrera</label>
                                 <select class="form-control" name="carrera1" required="">
                                <option value="0"  >Seleccione una opción:</option>
                                <?php

                                    if(isset($_SESSION['id_carrera']))
                                    {
                                            $query = $mysqli -> query ("select * FROM tbl_carrera  where id_carrera<>$_SESSION[id_carrera] ");
                                            while ($resultado = mysqli_fetch_array($query)) 
                                            {
                                            echo '<option value="'.$resultado['id_carrera'].'"  > '.$resultado['Descripcion'].'</option>' ;
                                            }

                                                    echo '<option value="'.$_SESSION['id_carrera'].'" selected="" >  '.$_SESSION['Descripcion'].'</option>' ;
                                    } 
                                    else
                                    {
                                        $query = $mysqli -> query ("select * FROM tbl_carrera ");
                                        while ($resultado = mysqli_fetch_array($query))
                                        {
                                        echo '<option value="'.$resultado['id_carrera'].'"  > '.$resultado['Descripcion'].'</option>' ;
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
                        <button type="submit" class="btn btn-primary" id="btn_modificar_comision" name="btn_modificar_comision" <?php echo $_SESSION['btn_modificar_comision']; ?>>Guardar
                            Cambios</button>
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
            window.open("../Controlador/reporte_mantenimiento_comisiones_controlador.php", "REPORTE");
        }
    </script>


    <script type="text/javascript">
        $(function() {

            $('#tabla4').DataTable({
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