<?php

ob_start();


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


 $Id_objeto=9 ; 

        $visualizacion= permiso_ver($Id_objeto);



if ($visualizacion==0)
 {
 // header('location:  ../vistas/menu_permisos_usuario_vista.php');
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
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Permisos a roles y pantallas');


if (permisos::permiso_insertar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_permisos']="";
}
else
{
    $_SESSION['btn_guardar_permisos']="disabled";
 }

/*
if (isset($_REQUEST['msj']))
 {
   $msj=$_REQUEST['msj'];

    if ($msj==1) 
      {
      echo '<script> alert("Permisos agregados correctamente")</script>';
      }
           if ($msj==2)
            {
              echo '<script> alert("Lo sentimos tiene campos por rellenar ")</script>';
            }
   
}*/

}




$sqltabla_permisos="select Id_objeto, objeto   from tbl_objetos";
$resultadotabla_permisos = $mysqli->query($sqltabla_permisos);


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
            <h1>Permisos a Usuarios</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Seguridad</li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="container-fluid">
  <!-- pantalla 1 -->
      
<form action="../Controlador/guardar_permisos_usuarios_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Nuevo Permiso</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
             
                


    <div class="col-xs-12 col-md-6">
    <div class="form-group">
                  <label>Roles</label>
                  <select class="form-control select2" style="width: 100%;" name="comborol" required="">
          <option value="0"  >Seleccione un Rol:</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_roles ");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['Id_rol'].'"> '.$resultado['Rol'].'</option>' ;
          }
        ?>
                </select>
    </div>
    </div>

                 <div class="col-xs-12 col-md-6">

                 
                   <label for="">Privilegios
                        </label>
              <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="checkbox"  id="checkbox_insertar" name="checkbox_insertar" value="true">
                        <label for="checkbox_insertar">Insertar
                        </label>
                      </div>
                
                
                      <div class="icheck-success d-inline">
                        <input type="checkbox"  id="checkbox_modificar" name="checkbox_modificar" value="true">
                        <label for="checkbox_modificar">Modificar
                        </label>
                      </div>
                
                      <div class="icheck-success d-inline">
                        <input type="checkbox"  id="checkbox_eliminar" name="checkbox_eliminar" value="true">
                        <label for="checkbox_eliminar">Eliminar
                        </label>
                      </div>
               
                      <div class="icheck-success d-inline">
                        <input type="checkbox"  id="checkbox_visualizar" name="checkbox_visualizar" value="true">
                        <label for="checkbox_visualizar">Visualizar
                        </label>
                      </div>
                </div>
                </div>
                      

               



              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_permisos" name="btn_guardar_permisos">  <?php echo $_SESSION['btn_guardar_permisos']; ?><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>

            </div>
          </div>



          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>
         
         
    
   

<div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Pantallas</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>PANTALLA</th>
                  <th>ESTADO</th>
                  
                  </tr>
                </thead>
                <tbody>
           <?php while($row = $resultadotabla_permisos->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
        <td><?php echo $row['objeto']; ?></td>
   

                  <td style="text-align: center;">
             
                        <input type="checkbox" name="objeto[]" value="<?php echo $row['Id_objeto']; ?>">
      
                  </td>
      
               </tr>
                 <?php } ?>
             </tbody>
            </table>
         </div>
            <!-- /.card-body -->
          </div>


 <div class="RespuestaAjax"></div>
</form>

  </div>
</section>





</div>

</body>
</html>