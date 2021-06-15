<?php

              ob_start();

              session_start();

              require_once ('../vistas/pagina_inicio_vista.php');
              require_once ('../clases/Conexion.php');
              require_once ('../clases/funcion_bitacora.php');
              require_once ('../clases/funcion_visualizar.php');
              require_once ('../clases/funcion_permisos.php');

?>
<<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  


  <link rel="stylesheet" type="text/css" href="../plugins/sweetalert2/sweetalert2.min.css">
   <div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item "><a href="../vistas/menu_supervision_vista.php">Viculación</a></li></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>

              <!--Contenido-->
              <!-- Content Wrapper. Contains page content -->
           
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="box">
                           
                            <!-- /.box-header -->
                            <!-- centro -->

		<div id="tabla"></div>
                        
                           <!-- Modal para listar datos del practicante -->


<div class="modal fade" id="modalPracticante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center><h4 class="modal-title" id="myModalLabel">Datos personales del practicantes</h4></center>
      </div>
      <div class="modal-body">

        	<label>Nombre Completo</label>
        	<input type="text" name="" id="nombre" class="form-control input-sm" readonly onmousedown="return false;" >
        	<label>Número de cuenta</label>
        	<input type="text" name="" id="cuenta" class="form-control input-sm" readonly onmousedown="return false;" >
        	<label>Email</label>
        	<input type="text" name="" id="email" class="form-control input-sm" readonly onmousedown="return false;" >
        	<label>telefono</label>
        	<input type="text" name="" id="telefono" class="form-control input-sm"  readonly onmousedown="return false;" >
          <label>Labora en la Empresa</label>
          <input type="text" name="" id="labora" class="form-control input-sm"  readonly onmousedown="return false;" >

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">
        Cerrar
        </button>

      </div>
    </div>
  </div>
</div>

<!-- Modal para listar datos de empresa-->

<div class="modal fade" id="modalEmpresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Datos de la Empresa</h4>
      </div>
      <div class="modal-body">

        	<label>Nombre</label>
        	<input type="text" name="" id="nombree" class="form-control input-sm" readonly onmousedown="return false;" >
        	<label>Direccion</label>
          <input type="text" name="" id="direccion" class="form-control input-sm" readonly onmousedown="return false;" >
          <label>Tipo de Empresa</label>
          <input type="text" name="" id="tipo" class="form-control input-sm" readonly onmousedown="return false;" >
          <label>Departamento Empresa</label>
          <input type="text" name="" id="departamento" class="form-control input-sm" readonly onmousedown="return false;" >
          <label>Jefe Inmediato</label>
          <input type="text" name="" id="jefe" class="form-control input-sm" readonly onmousedown="return false;" >
          <label>Titulo del Jefe Inmediato</label>
          <input type="text" name="" id="titulo" class="form-control input-sm" readonly onmousedown="return false;" >
          <label>Cargo del Jefe Inmediato</label>
          <input type="text" name="" id="cargo" class="form-control input-sm" readonly onmousedown="return false;" >
          <label>Correo del Jefe Inmediato</label>
          <input type="text" name="" id="correo" class="form-control input-sm" readonly onmousedown="return false;" >
          <label>Telefono del Jefe Inmediato</label>
        	<input type="text" name="" id="telefonoj" class="form-control input-sm" readonly onmousedown="return false;" >

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">
        Cerrar
        </button>

      </div>
    </div>
  </div>
</div>
                            </div>
                            <!--Fin centro -->
                          </div><!-- /.box -->
                      </div><!-- /.col -->
                  </div><!-- /.row -->
              </section><!-- /.content -->
        
            </div><!-- /.content-wrapper -->
          <!--Fin-Contenido-->
  <script type="text/javascript">
	$(document).ready(function(){
    $('#tabla').load('../Controlador/control_practicantes_controlador.php');

	});
</script>
          <script type="text/javascript" src="../js/supervisiones/gestion_practicantes.js"></script>
        

              
  
          