<?php
ob_start();

session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$sql_tabla_empresas="select Id_empresa, nombre_empresa  , direccion_empresa ,departamento_empresa from tbl_empresas_practica";
$resultadotabla_empresas = $mysqli->query($sql_tabla_empresas);


      $Id_objeto=18 ; 

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
                           window.location = "../vistas/menu_practica_vista.php";

                            </script>';
 
}

else

{

        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A GESTION DE EMPRESAS PPS');

if (permisos::permiso_modificar($Id_objeto)=='1')
 {
  $_SESSION['btn_modificar_empresa_practica']="";
}
else
{
    $_SESSION['btn_modificar_empresa_practica']="disabled";
}


   }


   ?>
  <script>
    $(function(){
    $('#modal_modificar_empresa_practica').modal('toggle')

    })



  </script>;
<?php 
 


  


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


            <h1>Gestion de Empresa</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="">PPS</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
<!--Pantalla 2-->





 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Empresa Existente</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>INSTITUCION</th>
                  <th>DIRECCION</th>
                  <th>DEPARTAMENTO</th>
                   <th>MODIFICAR</th>
                  </tr>
                </thead>
                <tbody>
    <?php while($row = $resultadotabla_empresas->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
        <td><?php echo $row['nombre_empresa']; ?></td>
        <td><?php echo $row['direccion_empresa']; ?></td>
        <td><?php echo $row['departamento_empresa']; ?></td>

   <!--  //    <?php   
/*
<?php  while ($counter< count($sql_tabla_proyectos["ROWS"])) { ?>
                <tr>
 <td><?php echo $sql_tabla_proyectos["ROWS"][$counter]["nombre_empresa"]; ?></td>
     <td><?php echo $sql_tabla_proyectos["ROWS"][$counter]["direccion_empresa"]; ?></td>
     <td><?php echo $sql_tabla_proyectos["ROWS"][$counter]["departamento_empresa"]; ?></td>
   */  ?> //  -->

         <td style="text-align: center;">
              
                       <a href="../vistas/gestion_empresa_practica_vista.php" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_empresa_practica'] ?> " ></i>
                    </a>
                  </td>
      
               </tr>
                  <?php } ?>
                 <!--    <?php  //  $counter = $counter + 1; } ?>    -->
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

<form action="" method="post"  data-form="update" autocomplete="off" >
                 


         <div class="modal fade" id="modal_modificar_empresa_practica">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Empresas PPS</h4>
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
                        <label class="control-label">Institucion</label>
                            <input class="form-control" type="text"  maxlength="60" id="txt_nombre_empresa_practica_gestion" name="txt_nombre_empresa_practica_gestion"   required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" >
                     
                    </div>
                   </div>

      <div class="col-sm-12" >
                  <div class="form-group">
                  <label>Direccion</label>
                    <input class="form-control" type="text"  maxlength="150" id="txt_direccion_empresa_practica_gestion" name="txt_direccion_empresa_practica_gestion"  value=""  style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>

                    <div class="col-sm-6">
                    <div class="form-group">
                 <label>Departamento</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_departamento_practica_gestion" name="txt_departamento_practica_gestion"  value=""  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>

                 <div class="col-sm-6" >
                    <div class="form-group">
                  <label>Jefe Inmediato</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_jefe_inmediato_gestion" name="txt_nombre_jefe_inmediato_gestion"  value=""  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                    <div class="col-sm-6" >
                    <div class="form-group">
                  <label>Titulo Academico</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_titulo_jefe_inmediato_gestion" name="txt_titulo_jefe_inmediato_gestion"  value=""  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                   <div class="col-sm-6" >
                    <div class="form-group">
                  <label>Cargo</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_cargo_jefe_inmediato_gestion" name="txt_cargo_jefe_inmediato_gestion"  value=""  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                   <div class="col-sm-6">
                  <div class="form-group">
                  <label>Telefono</label>
                    <input class="form-control" type="text" id="txt_telefono_jefe_inmediato_gestion" name="txt_telefono_jefe_inmediato_gestion"  value="" data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>



                 <div class="col-sm-6">
                 <div class="form-group">
                  <label>Correo Electronico</label>
                    <input class="form-control" type="email" id="txt_nombre_jefe_inmediato_gestion" name="txt_nombre_jefe_inmediato_gestion" value="" required onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" >
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

          




            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn_modificar_empresa_practica" name="btn_modificar_empresa_practica"  <?php echo $_SESSION['btn_modificar_empresa_practica']; ?> >Guardar Cambios</button>
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

<?php
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
                    if ($msj==3)
                   {
                   echo '<script type="text/javascript">
                                                  swal({
                                                       title:"",
                                                       text:"Lo sentimos tiene campos por rellenar.",
                                                       type: "info",
                                                       showConfirmButton: false,
                                                       timer: 3000
                                                    });

                                                </script>';
                                              }
      }
?>