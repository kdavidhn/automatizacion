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


<div class="modal fade" id="modalHorario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center><h4 class="modal-title" id="myModalLabel">DATOS DEL EXAMEN</h4></center>
      </div>
      <div class="modal-body">
        
          <input type="text" hidden="" id="idhorario" name="">
          <div id="alertaModal1" class='alert alert-warning'></div>
                      <label>FECHA DEL EXAMEN</label>
                      <input class="form-control" type="date" id="fecha" name="fecha" maxlength="60" require>
          <div id="alertaModal2" class='alert alert-warning'></div>
                      <label>HORARIO DEL EXAMEN</label>
                      <input class="form-control" type="time" id="horario" name="horario" maxlength="60" require>
        	<div id="alertaModal3" class='alert alert-warning'></div>
                        <label>JORNADA DEL EXAMEN</label>
                        <input class="form-control" name="jornada" id="jornada"maxlength="60" require readonly onmousedown="return false;" >
                          
          <div id="alertaModal4" class='alert alert-warning'></div>
                      <label>CUPOS</label>
                      <input class="form-control" type="number" id="cupos" name="cupos" maxlength="60" require>
         
      
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
      <button  class="btn btn-primary" id="actualizadatos" data-dismiss="modal" onclick="location.reload()">ACTUALIZAR</button>
      
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
    $('#tabla').load('../Controlador/horario_himno_controlador.php');

	});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#guardarnuevo').click(function(){
          rolm=$('#rolm').val();
          descripcion=$('#descripcion').val();
         
          
          
            agregarrol(rolm, descripcion)
            
        });



        $('#actualizadatos').click(function(){
          actualizaDatos_r();
          
        });

    });
</script>
          <script type="text/javascript" src="../js/horario_himno.js"></script>
        

              
  
          