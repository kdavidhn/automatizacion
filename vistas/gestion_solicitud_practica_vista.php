<?php

ob_start();

session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');



//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
    {
  echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el rol ya existe",
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



 $sqltabla="select Rol, Descripcion, 
Case estado when 0 then 'Inactivo' 
             when 1 then 'Activo'
END   as Estado            
FROM tbl_roles";
$resultadotabla = $mysqli->query($sqltabla);



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
 






        $Id_objeto=40 ; 
        $visualizacion= permiso_ver($Id_objeto);



if ($visualizacion==0)
 {
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
}

else

{
  
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Ingreso' , 'A Gestion de Solicitud de PPS');









        $usuario=$_SESSION['id_usuario'];
        $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
       $result= mysqli_fetch_assoc($mysqli->query($id));
       $id_persona=$result['id_persona'];
/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
$sqltabla="select ep.nombre_empresa, concat(p.nombres,'',p.apellidos)AS nombre, px.valor from tbl_empresas_practica ep, tbl_personas p, tbl_personas_extendidas px where ep.id_persona=p.id_persona and p.id_persona='$id_persona' AND px.id_atributo=12 and px.id_persona='$id_persona'";
$resultadotabla = $mysqli->query($sqltabla);






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


            <h1>Formularios PPS-01 Y PPS-02</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/_vista.php">Nueva Solicitud</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->





 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Datos del Estudiante</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
               <th>NOMBRE COMPLETO</th>
                  <th>Nº CUENTA </th>
                  <th>EMPRESA</th>
                  <th>PPS-01</th>
                  <th>PPS-02</th>
                 </tr>
                </thead>
                <tbody>
   <?php while($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
    <td><?php echo $row['nombre']; ?></td>
         <td><?php echo $row['valor']; ?></td>
             <td><?php echo $row['nombre_empresa']; ?></td>

             <td style="text-align: center;">
              <form class="well" action="../pdf/formulario_pps01.php" method="POST" target="_blank">
                      <button type="submit"  class="btn btn-secondary btn-raised btn-sm" name= "btn_imprimir">Imprimir
                      <i class="zmdi zmdi-local-printshop"></i>
                  </td>
      </form>
                  <td style="text-align: center;">
                         
                   <form class="well" action="../pdf/formulario_pps02.php" method="POST" target="_blank">
                      <button type="submit"  class="btn btn-secondary btn-raised btn-sm" name= "btn_imprimir">Imprimir
                      <i class="zmdi zmdi-local-printshop"></i>
                  </td>
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