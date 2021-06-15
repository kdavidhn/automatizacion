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
                       text:"Los datos  se almacenaron correctamente",
                       type: "success",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>';

       $sqltabla_permisos="select r.rol , p.objeto,  Case pu.insertar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Insertar ,   
Case pu.Modificar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Modificar ,
Case pu.Eliminar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Eliminar ,
Case pu.Visualizar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Visualizar    from tbl_permisos_usuarios pu,tbl_roles r,tbl_objetos p where pu.id_rol=r.id_rol and pu.Id_objeto=p.Id_objeto;";
$resultadotabla_permisos = $mysqli->query($sqltabla_permisos);
        }
   
        if ($msj==2)
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





        $Id_objeto=10 ; 

        $visualizacion= permiso_ver($Id_objeto);



if ($visualizacion==0)
 {
  //header('location:  ../vistas/menu_permisos_usuario_vista.php');
 echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_permisos_usuario_vista.php";

                            </script>';
}

else

{
  
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Gestion de permisos usuarios');


if (permisos::permiso_modificar($Id_objeto)=='1')
 {
  $_SESSION['btn_modificar_permisos']="";
}
else
{
    $_SESSION['btn_modificar_permisos']="disabled";
}


/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
$sqltabla_permisos="select r.rol , p.objeto,  Case pu.insertar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Insertar ,   
Case pu.Modificar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Modificar ,
Case pu.Eliminar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Eliminar ,
Case pu.Visualizar when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Visualizar    from tbl_permisos_usuarios pu,tbl_roles r,tbl_objetos p where pu.id_rol=r.id_rol and pu.Id_objeto=p.Id_objeto;";
$resultadotabla_permisos = $mysqli->query($sqltabla_permisos);

/* Se declara una variable para el input check*/
$checkeado="";
$checkeado1="";
$checkeado2="";
$checkeado3="";


/* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
if (isset($_GET['rol']) and isset($_GET['pantalla']) )
 
 {

$resultadotabla_permisos = $mysqli->query($sqltabla_permisos);

 /* Esta variable recibe el rol de modificar */
$Rol = $_GET['rol']; 
$Pantalla = $_GET['pantalla'];
//$Id_pantalla = $_GET['Id_pantalla'];  





 /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
  $sql = "select pu.insertar as Insertar , pu.modificar as Modificar , pu.eliminar as Eliminar , pu.visualizar as Visualizar , pu.id_permisos_usuario as Id_permiso_usuario, r.rol as Rol , p.objeto as Pantalla  from tbl_permisos_usuarios pu,tbl_roles r,tbl_objetos p where pu.id_rol=r.id_rol and pu.Id_objeto=p.Id_objeto AND r.rol= '$Rol' and p.objeto= '$Pantalla'";
  $resultado=$mysqli->query($sql);

  /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

  /* Aqui obtengo el id_rol de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
  

 $_SESSION['Id_permiso_usuario_gestion']= $row['Id_permiso_usuario']; 
  $Insertar=$row['Insertar'];
  $Modificar=$row['Modificar'];
  $Eliminar=$row['Eliminar'];
  $Visualizar=$row['Visualizar'];
  $_SESSION['PantallanRol_gestion']=$row['Pantalla'];
    $_SESSION['Rol_gestion']=$row['Rol'];



/*Aqui levanto el modal*/

  if (isset($_SESSION['Rol_gestion'])){


?>
  <script>
    $(function(){
    $('#modal_modificar_permiso_usuario').modal('toggle')

    })

  </script>;
<?php 
 ?> 

  <?php


  }

/* Si el rol a modificar esta activo que aparesca visualmente chequeado */

if ($Insertar==1) {
$checkeado1="checked";
}
else
{
$checkeado1="";
}
      if ($Modificar==1) {
      $checkeado2="checked";
      }
      else
      {
      $checkeado2="";
      }
           

            if ($Eliminar==1) {
            $checkeado3="checked";
            }
            else
            {
            $checkeado3="";
            }


                  if ($Visualizar==1) {
                  $checkeado="checked";
                  }
                  else
                  {
                  $checkeado="";
                  }


/* La variable $msj me sirve para enviar un mensaje desde actualizar.php desde esta pagina */
 /*  $_REQUEST recibe el valor de la variable ?msj y se valida con el isset*/
 /* if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
        {
         echo '<script> alert("Permisos modificada correctamente")</script>';
        }
   
      */
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

         <h1>Gestion de Permiso</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/crear_permisos_usuarios_vista.php">Crear Permiso</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->



<div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Permisos Existente</h3>
       <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                      <th>ROL</th>
              <th>PANTALLA</th>
              <th>VISUALIZAR</th>
              <th>INSERTAR</th>
              <th>MODIFICAR</th>
              <th>ELIMINAR</th>
              <th>EDITAR</th>
            
                </tr>
                </thead>
                <tbody>
   <?php while($row = $resultadotabla_permisos->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
    <td><?php echo $row['rol']; ?></td>
         <td><?php echo $row['objeto']; ?></td>
              <td><?php echo $row['Visualizar']; ?></td>
        <td><?php echo $row['Insertar']; ?></td>
          <td><?php echo $row['Modificar']; ?></td>
            <td><?php echo $row['Eliminar']; ?></td>
         

                  <td style="text-align: center;">
              
                       <a href="../vistas/gestion_permiso_usuario_vista.php?rol=<?php echo $row['rol']; ?>&pantalla=<?php echo $row['objeto']?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_permisos'] ?> " ></i>
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


                      <div class="RespuestaAjax"></div>


<!-- *********************Creacion del modal 

-->

<form action="../Controlador/actualizar_permiso_usuario_controlador.php?Id_permisos_usuarios=<?php echo $_SESSION['Id_permiso_usuario_gestion']; ?>" method="post" data-form="update" autocomplete="off" >
                 


                  <div class="modal fade" id="modal_modificar_permiso_usuario">
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
               <label>Rol</label>
               <input  class="form-control" type="text" id="txtnombrerol" readonly="true"  name="txtnombrerol"  value="<?php echo $_SESSION['Rol_gestion'];?>" required style="text-transform: uppercase" onkeyup="Espacio(this, event)"  onkeypress="return Letras(event)" maxlength="30">
               </div>


               <div class="form-group">
            <label class="control-label">Pantalla</label>

                        <input readonly="true"   class="form-control" type="text" id="txt_nombrepantalla" name="txtnombrepantalla" value="<?php echo $_SESSION['PantallanRol_gestion'];?>" required style="text-transform: uppercase"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)"  maxlength="30" onkeypress="return comprobar(this.value, event, this.id)">
               </div>

            <label class="control-label">Privilegios</label>
                <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="checkbox" id="checkboxvisualizar" name="checkboxvisualizar" <?php echo $checkeado; ?> value="true">
                        <label for="checkboxvisualizar">Visualizar
                        </label>
                      </div>
                        <div class="icheck-success d-inline">
                        <input type="checkbox" id="checkboxinsertar" name="checkboxinsertar" <?php echo $checkeado1; ?> value="true">
                        <label for="checkboxinsertar">Insertar
                        </label>
                      </div>
                        <div class="icheck-success d-inline">
                        <input type="checkbox" id="checkboxmodificar" name="checkboxmodificar" <?php echo $checkeado2; ?> value="true">
                        <label for="checkboxmodificar">Modificar
                        </label>
                      </div>
                        <div class="icheck-success d-inline">
                        <input type="checkbox" id="checkboxeliminar" name="checkboxeliminar" <?php echo $checkeado3; ?> value="true">
                        <label for="checkboxeliminar">Eliminar
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
              <button type="submit" class="btn btn-primary" id="btn_modificar_permisos" name="btn_modificar_permisos"  <?php echo $_SESSION['btn_modificar_permisos']; ?> >Guardar Cambios</button>
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