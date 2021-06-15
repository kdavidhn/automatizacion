<?php

ob_start();

session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');



 $Id_objeto=4 ; 

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Gestion de Usuarios');
//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos

if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
  
        if ($msj==2)
                   {

echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos se almacenaron correctamente",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>'; 
       



$sqltabla_usuario="select r.Rol , CASE u.estado 
WHEN 0 THEN 'Inactivo'
WHEN 1 THEN 'Activo'
WHEN 2 THEN 'Nuevo'
END as Estado ,  u.Usuario 
from tbl_usuarios u ,tbl_roles r WHERE u.Id_rol=r.Id_rol ";
$resultadotabla_usuario = $mysqli->query($sqltabla_usuario);


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
                           window.location = "../vistas/menu_usuarios_vista.php";

                            </script>';
                            /*
  header('location:  ../vistas/menu_usuarios_vista.php');*/
}

else

{
      

if (permisos::permiso_modificar($Id_objeto)=='1')
 {
  $_SESSION['btn_modificar_usuario']="";
}
else
{
    $_SESSION['btn_modificar_usuario']="disabled";
}



/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
$sqltabla_usuario="select r.Rol , CASE u.estado 
WHEN 0 THEN 'Inactivo'
WHEN 1 THEN 'Activo'
WHEN 2 THEN 'Nuevo'
END as Estado  , u.Usuario 
from tbl_usuarios u ,tbl_roles r WHERE u.Id_rol=r.Id_rol ";
$resultadotabla_usuario = $mysqli->query($sqltabla_usuario);

/* Se declara una variable para el input check*/
$checkeado="";


/* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
if (isset($_GET['Usuario']))
 {


$resultadotabla_usuario = $mysqli->query($sqltabla_usuario);

 /* Esta variable recibe el rol de modificar */
$Usuario = $_GET['Usuario'];  

/* Iniciar la variable de sesion y la crea */

 /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
  $sql = "select r.Id_rol,r.Rol, u.Usuario , u.estado  , u.Id_usuario FROM tbl_usuarios u , tbl_roles r WHERE u.Id_rol=r.Id_rol AND Usuario ='$Usuario'";
  $resultado = $mysqli->query($sql);
  /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

  /* Aqui obtengo el id_rol de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
  $Id_usuario= $row['Id_usuario']; 
  $Estatus=$row['estado'];
$_SESSION['usuario_gestion']=$row['Usuario'];
$_SESSION['Id_rol_gestion']=$row['Id_rol']; 
$_SESSION['Rol_gestion_usuario']=$row['Rol']; 

if (isset($_SESSION['usuario_gestion'])){


?>
  <script>
    $(function(){
    $('#modal_modificar_usuario').modal('toggle')

    })

  </script>;
<?php 
 ?> 

  <?php

}


/* Si el rol a modificar esta activo que aparesca visualmente chequeado */

if ($Estatus==1)
{
$checkeado="checked";
}
else
{
$checkeado="";
}

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


            <h1>Gestion de Usuarios</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/crear_usuario_vista.php">Nuevo Usuario</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->





 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Usuarios Existente</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>USUARIO</th>
                  <th>ROL</th>
                  <th >ESTADO</th>
                
                  <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
   <?php while($row = $resultadotabla_usuario->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
 <td><?php echo $row['Usuario']; ?></td>
     <td><?php echo $row['Rol']; ?></td>

            <td><?php echo $row['Estado']; ?></td>
     
                  <td style="text-align: center;">
              
                       <a href="../vistas/gestion_usuarios_vista.php?Usuario=<?php echo $row['Usuario']; ?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_usuario'] ?> " ></i>
                    </a>
                  </td>

                  <td style="text-align: center;">
                         
                    <form action="../Controlador/eliminar_usuario_controlador.php?UsuarioG=<?php echo $row['Usuario']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                      <button type="submit" class="btn btn-danger btn-raised btn-xs">
                     
                        <i  class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_usuario'] ?> "></i>
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

<form action="../Controlador/actualizar_usuario_controlador.php?Id_usuarioG=<?php echo $Id_usuario ?>"method="post"  data-form="update" autocomplete="off" >
                 


                  <div class="modal fade" id="modal_modificar_usuario">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Usuarios</h4>
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




                      <div class="form-group">
                        <label class="control-label">Usuario </label>
                        
                        <input  class="form-control" type="text" 
                         id="txt_usuario" name="txt_usuario" value="<?php echo $_SESSION['usuario_gestion'];?>"  style="text-transform: uppercase" onkeyup="Espacio(this, event)"  onkeypress="return Letras(event)"maxlength="30" readonly="true" >
                    </div>

                             <div class="form-group ">
                          <label class="control-label">Lista de roles</label>
                          <select class="form-control" name="cb_comborol" required="">
        <option value="0"  >Seleccione un Rol:</option>
        <?php

          if(isset($_SESSION['Id_rol_gestion']))
          {
                $query = $mysqli -> query ("select * FROM tbl_roles where  Id_rol<>$_SESSION[Id_rol_gestion] ");
                while ($resultado = mysqli_fetch_array($query)) 
                {
                echo '<option value="'.$resultado['Id_rol'].'"  > '.$resultado['Rol'].'</option>' ;
                }

                        echo '<option value="'.$_SESSION['Id_rol_gestion'].'" selected="" >  '.$_SESSION['Rol_gestion_usuario'].'</option>' ;
          } 
          else
          {
              $query = $mysqli -> query ("select * FROM tbl_roles ");
              while ($resultado = mysqli_fetch_array($query))
               {
               echo '<option value="'.$resultado['Id_rol'].'"  > '.$resultado['Rol'].'</option>' ;
               }

          }

        ?>
      </select>
                      </div>
                          <?php echo $row['Id_rol'];?>





                    
               </div>

             <div class="form-group clearfix" >
                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="checkboxactivomodificar" name="checkboxactivomodificar" <?php echo $checkeado; ?>  value="true">
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
              <button type="submit" class="btn btn-primary" id="btn_modificar_usuario" name="btn_modificar_usuario"  <?php echo $_SESSION['btn_modificar_usuario']; ?> >Guardar Cambios</button>
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