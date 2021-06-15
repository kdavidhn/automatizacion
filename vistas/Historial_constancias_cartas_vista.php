<?php

ob_start();


session_start();


require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


$Id_objeto=18 ; 




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
		window.location = "../vistas/menu_practica_vista.php";

		</script>';
	}

	else

	{
		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A  HISTORIAL DE PRACTICA APROBADAS ');
		      
 $usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];
  $sql=("select concat(p.nombres,' ', p.apellidos) as nombre ,px.valor from tbl_personas_extendidas px, tbl_personas p, tbl_usuarios u where u.id_persona='$id_persona' and p.id_persona='$id_persona' and px.id_atributo=12 and px.id_persona='$id_persona' ");
 //Obtener la fila del query
$resultado = $mysqli->query($sql);


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
                  <h1>Historial de Constancias y/o Cartas </h1>
                </div>
                <div class="RespuestaAjax"></div>



                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Vinculacion</li>

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

              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Datos</h3>
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
                       <th>CUENTA</th>   
                       <th>CONSTANCIA CHARLA</th>                
                       <th>CARTA PRESENTACION</th>                

                

                     </tr>
                   </thead>
                   <tbody>

                  
                    <?php while($row = $resultado->fetch_array(MYSQLI_ASSOC)) {  ?>   
                      <tr>
                         <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['valor']; ?></td>


    <td style="text-align: center;">
              
              <form class="well" action="../pdf/reporte_constancia_charla.php" method="POST" target="_blank">
                      <button type="submit"  class="btn btn-secondary btn-raised btn-sm" name= "btn_imprimir">Imprimir
                      <i class="zmdi zmdi-local-printshop"></i>
                  </td>
      </form>
                  <td style="text-align: center;">
                         
                   <form class="well" action="../pdf/reporte_presentacion_empresa.php" method="POST" target="_blank">
                      <button type="submit"  class="btn btn-secondary btn-raised btn-sm" name= "btn_imprimir">Imprimir
                      <i class="zmdi zmdi-local-printshop"></i>
                  </td>
      </form>
                  </td>









<!--
                        <td style="text-align: center;">

                         <a href="../pdf/reporte_constancia_charla.php" class="btn btn-primary btn-raised btn-xs">
                          <i class="fas fa-eye"  title="Imprimir"  ></i>
                        </a>
                      </td>


                         <td style="text-align: center;">

                       <a href="../pdf/reporte_presentacion_empresa.php" class="btn btn-primary btn-raised btn-xs">
                        <i class="fas fa-edit"  title="Imprimir"  ></i>
                      </a>
                    </td>

                  
-->

                  </tr>

             <?php } ?> 

            </tbody>
          </table>
        </div>

        <!-- /.card-body -->
      </div>


      <div class="RespuestaAjax"></div>

    </div>
  </section>





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
