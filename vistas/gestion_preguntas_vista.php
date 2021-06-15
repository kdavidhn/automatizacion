<?php

ob_start();


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
    {
  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos la pregunta ya existe",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>'; 
       
        }
   
        if ($msj==2)
                   {


  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos  se almacenaron correctamente",
                       type: "success",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>'; 
                $sqltabla_pregunta="SELECT pregunta,  
Case estado when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as estado           
FROM tbl_preguntas";
$resultadotabla_pregunta = $mysqli->query($sqltabla_pregunta);


                   }
                     if ($msj==3)
                   {


  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Error al actualizar lo sentimos,intente de nuevo.",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>'; 
                  }

    }




      $Id_objeto=2 ; 

        $visualizacion= permiso_ver($Id_objeto);


if ($visualizacion==0)
 {
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_pregunta_vista.php";

                            </script>';
 
}

else

{

        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Gestion de Preguntas');

if (permisos::permiso_modificar($Id_objeto)=='1')
 {
  $_SESSION['btn_modificar_pregunta']="";
}
else
{
    $_SESSION['btn_modificar_pregunta']="disabled";
}




/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  
$sqltabla_pregunta="SELECT pregunta,  
Case estado when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as estado           
FROM tbl_preguntas";
$resultadotabla_pregunta = $mysqli->query($sqltabla_pregunta);


/* Se declara una variable para el input check*/
$checkeado="";


/* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
if (isset($_GET['Pregunta']))
 {
$sqltabla_pregunta="SELECT pregunta,  
Case estado when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as estado           
FROM tbl_preguntas";
$resultadotabla_pregunta = $mysqli->query($sqltabla_pregunta);

 /* Esta variable recibe el rol de modificar */
$Pregunta = $_GET['Pregunta'];  

/* Iniciar la variable de sesion y la crea */

 /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
  $sql = "SELECT * FROM tbl_preguntas WHERE pregunta= '$Pregunta'";
  $resultado = $mysqli->query($sql);
  /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

  /* Aqui obtengo el id_rol de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
  $Id_pregunta= $row['Id_pregunta']; 
  $Estatus=$row['estado'];
  $_SESSION['TxtPregunta']=$row['pregunta'];


if (isset($_SESSION['TxtPregunta'])){


?>
  <script>
    $(function(){
    $('#modal_modificar_pregunta').modal('toggle')

    })

  </script>;
<?php 
 ?> 
<?php


  }

/* Si el rol a modificar esta activo que aparesca visualmente chequeado */

if ($Estatus==1) {
$checkeado="checked";
}
else
{
$checkeado="";
}

/* La variable $msj me sirve para enviar un mensaje desde actualizar.php desde esta pagina */
 /*  $_REQUEST recibe el valor de la variable ?msj y se valida con el isset*/
  
 }
 
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


            <h1>Preguntas de Seguridad</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/crear_pregunta_vista.php">Nueva Pregunta</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->


 
 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Preguntas existentes</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>PREGUNTA</th>
                  <th>ESTADO</th>
                  <th>MODIFICAR</th>
                  <th>ELIMINAR</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $resultadotabla_pregunta->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
        <td><?php echo $row['pregunta']; ?></td>
        <td><?php echo $row['estado']; ?></td>

                  <td style="text-align: center;">
              
                    <a href="../vistas/gestion_preguntas_vista.php?Pregunta=<?php echo $row['pregunta']; ?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_pregunta'] ?> "  ></i>
                    </a>
                  </td>

                  <td style="text-align: center;">
                    <form action="../controlador/eliminar_pregunta_controlador.php?Pregunta=<?php echo $row['pregunta']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off"  >
                      <button type="submit" class="btn btn-danger btn-raised btn-xs">
                        <i class="far fa-trash-alt"></i>
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

<form action="../Controlador/actualizar_pregunta_controlador.php?Id_pregunta=<?php echo $Id_pregunta; ?>" method="post"  data-form="update" autocomplete="off" >
                 


                  <div class="modal fade" id="modal_modificar_pregunta">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Preguntas</h4>
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
                  <label>Modificar pregunta</label>
             
 <input class="form-control" type="text" id="txt_pregunta_modificar" name="txt_pregunta_modificar" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="<?php echo $_SESSION['TxtPregunta'];?>">

                </div>

 <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="checkbox" id="checkboxactivomodificar" name="checkboxactivomodificar" <?php echo $checkeado; ?> value="true">
                        <label for="checkboxactivomodificar">Activo
                        </label>
                      </div>
                </div>

          
<!--
              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-info btn-raised btn-sm" id="" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>
-->
              </div>
            </div>
          </div>

            </div>




            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn_modificar_pregunta" name="btn_modificar_pregunta" <?php echo $_SESSION['btn_modificar_pregunta']; ?>  >Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- /.  finaldel modal -->



    </form>



<script type="text/javascript">
  

 $(function () {
   
    $('#tabla').DataTable({
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
