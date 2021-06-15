<?php

ob_start();

session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


        $Id_objeto=7 ;
     $visualizacion= permiso_ver($Id_objeto);



if ($visualizacion==0)
 {
  header('location:  ../vistas/pagina_principal_vista.php');
}

else

{
 
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Gestion de Parametros');


if (permisos::permiso_modificar($Id_objeto)=='1')
 {
  $_SESSION['btn_modificar_parametro']="";
}
else
{
    $_SESSION['btn_modificar_parametro']="disabled";
}


/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
$sqltabla_parametro="SELECT Parametro, Descripcion , Valor         
FROM tbl_parametros";
$resultadotabla_parametro = $mysqli->query($sqltabla_parametro);



/* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
if (isset($_GET['Parametro']))
 {
$sqltabla_parametro="SELECT Parametro, Descripcion , Valor         
FROM tbl_parametros";
$resultadotabla_parametro = $mysqli->query($sqltabla_parametro);

$Parametro = $_GET['Parametro'];    

/* Iniciar la variable de sesion y la crea */


 /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso e el input */
    $sql = "SELECT * FROM tbl_parametros WHERE Parametro = '$Parametro'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    $Id_parametro= $row['Id_parametro']; 
 $_SESSION['TxtParametro']=$row['Parametro'];
  $_SESSION['TxtParametro_descripcion']=$row['Descripcion'];
   $_SESSION['TxtParametro_valor']=$row['Valor'];

if (isset($_SESSION['TxtParametro'])){


?>
  <script>
    $(function(){
    $('#modal_modificar_parametro').modal('toggle')

    })

  </script>;
<?php 
 ?> 

  <?php


  }


} 

}






if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
    {
  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el Parametro ya existe",
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
        $sqltabla_parametro="SELECT Parametro, Descripcion , Valor         
FROM tbl_parametros";
$resultadotabla_parametro = $mysqli->query($sqltabla_parametro);



                   }
                     if ($msj==3)
                   {


  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos tiene campos por rellenar.",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>'; 
                


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


            <h1>Parametros del Sistema</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/crear_pregunta_vista.php"></a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->


 
 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Parametros existentes</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>PARAMETRO</th>
                  <th>DESCRIPCION</th>
                  <th>VALOR</th>
                  <th>MODIFICAR</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row = $resultadotabla_parametro->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
         <td><?php echo $row['Parametro']; ?></td>
         <td><?php echo $row['Descripcion']; ?></td>
        <td><?php echo $row['Valor']; ?></td>

                  <td style="text-align: center;">
              
                    <a href="../vistas/gestion_parametros_vista.php?Parametro=<?php echo $row['Parametro']; ?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_parametro'] ?> "  ></i>
                    </a>
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

</div>





</section>

</div>



<!-- *********************Creacion del modal 

-->

<form action="../Controlador/actualizar_parametro_controlador.php?Id_parametro=<?php echo $Id_parametro ?>" method="post"  data-form="update" autocomplete="off" >
                 


                  <div class="modal fade" id="modal_modificar_parametro">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Modificar Parametro</h4>
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
                  <label>Parametro</label>
             
 <input class="form-control" type="text" id="txt_parametro_modificar" name="txt_parametro_modificar" style="text-transform: uppercase" onkeypress="return Letras(event)" readonly="true" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="<?php echo $_SESSION['TxtParametro'];?>">

                </div>

      <div class="form-group">
                      <label>Descripcion</label>
                 
     <input class="form-control" type="text" id="txt_parametro_descripcion" name="txt_parametro_descripcion" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="<?php echo $_SESSION['TxtParametro_descripcion'];?>">

                    </div>

                     <div class="form-group">
                      <label>Valor</label>
                 
     <input class="form-control" type="text" id="txt_parametro_valor" name="txt_parametro_valor" style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="<?php echo $_SESSION['TxtParametro_valor'];?>">

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
              <button type="submit" class="btn btn-primary" id="btn_modificar_parametro" name="btn_modificar_parametro"  <?php echo $_SESSION['btn_modificar_parametro']; ?>>Guardar Cambios</button>
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
