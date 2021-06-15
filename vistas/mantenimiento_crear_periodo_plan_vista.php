<?php
session_start();
ob_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 99;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento/Crear Periodo Plan');



$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    //header('location:  ../vistas/menu_roles_vista.php');

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






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_periodo_plan'] = "";
    } else {
        $_SESSION['btn_guardar_periodo_plan'] = "disabled";
    }
    /*

 if (isset($_REQUEST['msj']))
 {
      $msj=$_REQUEST['msj'];
        if ($msj==1)
            {
            echo '<script> alert("Lo sentimos el rol a ingresar ya existe favor intenta con uno nuevo")</script>';
            }
   
               if ($msj==2)
                  {
                  echo '<script> alert("Rol agregado correctamente")</script>';
                  }
 }

*/
}



ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <title></title>



</head>

<body>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Período de Plan de Estudios</h1>
                    </div>
                    <input class="form-control" hidden type="text" id="max_periodo" name="max_periodo" value="<?php echo $max_periodo['valor'] ?>">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento_plan.php">Menu Mantenimiento Plan de Estudios</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_periodo_plan_vista.php"> Mantenimiento Período Plan de Estudios</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/guardar_periodo_plan_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title"></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body ">
                        
                                    <div class="col-md-1">
                                            <div class="form-group">
                                                <input class="form-control" hidden type="text" id="txt_hidden" name="txt_hidden" value="" readonly>

                                            </div>
                                        </div> 
                            <div class="row">
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Nuevo Período de Plan de Estudios </label>
                                        <input class="form-control" type="text"  maxlength="10" id="periodo_plan" name="periodo_plan" style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)"; onkeypress="return letrasynumeros(event)" >
                                    </div>

                                

                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_periodo_plan" name="btn_guardar_periodo_plan" <?php echo $_SESSION['btn_guardar_periodo_plan']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                                    </p>

                                </div>
                            </div>
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





</body>

</html>

<script src="../js/ca2.js"></script>
<script src="../Reporte/validar.js"></script>
  <script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
