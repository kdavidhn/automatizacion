<?php 
ob_start();
session_start();

require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');



      
ob_end_flush();




?>


<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="../js/supervisiones/segunda_visita.js"></script>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


</head>
<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>

         

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
  <!-- pantalla  -->
      
<form action="../Controlador/guardar_segunda_visita_controlador.php" method="post" id="formulario" data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">PRÁCTICA PROFESIONAL SUPERVISADA  PPS-IA-02                                                  </h3>

            <div class="card-tools">   
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">

            <div class="col-sm-12">
            <label>DATOS GENERALES</label>
                  <hr>
                  </div>
                  <div class="col-sm-12">
                  <div class="form-group">
                  <p><label>Seleccione un Alumno</label>
                  <select class="form-control" name="curso" id="curso" onchange='llenarCampos(this);'> 
                  <option value="" selected hidden>Seleccione</option>
                </select>
                </div>
                 </div>
                 

                  
                   
                    <input type="text" id="idInput" name="idInput" class="input" hidden />
            

                

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>N de Cuenta</label>
                    <input  class="form-control"  type="text" id="cuenta_sv" name="cuenta_sv"   maxlength="60" readonly>
                </div>
                 </div>



               <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre de la empresa o institución</label>
                    <input class="form-control" type="text" id="empresa_sv" name="empresa_sv"   maxlength="60"readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del jefe inmediato</label>
                    <input class="form-control" type="text" id="jefe_sv" name="jefe_sv"   maxlength="60"readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Titulo del jefe inmediato o representante de la institución</label>
                    <input class="form-control" type="text" id="titulo_sv"  name="titulo_sv"    maxlength="60"readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Correo electrónico</label>
                    <input class="form-control" type="text" id="correo_sv" name="correo_sv"   maxlength="60"readonly >
                </div>
                 </div>


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>No. de teléfono de la organización</label>
                    <input class="form-control" type="text" id="telefono_sv" name="telefono_sv"    maxlength="60"readonly >
                </div>
                 </div>

                 
                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del estudiante</label>
                    <input class="form-control" type="text" id="estudiante_sv" name="estudiante_sv"   maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Fecha de inicio</label>
                    <input class="form-control" type="text" id="inicio_sv" name="inicio_sv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Fecha de finalizacion</label>
                    <input class="form-control" type="text" id="finalizacion_sv" name="finalizacion_sv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Horas</label>
                    <input class="form-control" type="text" id="horas_sv" name="horas_sv"  maxlength="60" readonly >
                </div>
                 </div>


            

                  <div class="col-sm-6">
                  <div class="form-group">
                  
                </div>
                 </div>

                 <!--<div class="col-sm-12">
                  <div class="form-group">
                  <label> </label>
                    <input class="form-control" type="text" id="otros_uv" name="otros_uv" maxlength="60" placeholder="Otros"  >
                </div>
                 </div>-->

                 
                 

                 <div class="col-sm-12">
                  <label></label>
                  <hr>
                  </div>

                  <div class="col-sm-12">
                 <br>
                  <label>EVALUACIÓN DEL DESEMPEÑO</label>
                  <hr>
                  </div>

               

                  <div class="col-sm-12">
                  <label>Aspectos relevantes</label>
                  </div>
                  <br>
                  <br>


                  
                  <table class="table">

<tr>

  <th scope="row"></th>

  <th>Excelente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

  <th>Bueno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

  <th>Regular&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

  <th>Debe Mejorar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

</tr>


<tr>

  <th>La asistencia del practicante durante el período de práctica a su lugar de trabajo fue :</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_sv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_sv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_sv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_sv" value="Debe Mejorar" require></td>

</tr>

<tr>

  <th>Los horarios establecidos por la empresa para el practicante fueron cumplidos en forma :</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_sv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_sv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_sv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_sv" value="Debe Mejorar" require></td>



</tr>

<tr>

  <th>La adaptación del practicante al equipo de trabajo asignado y al medio ambiente laboral fue :</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>El grado de cumplimiento de las tareas encomendadas al practicante fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>La calidad del trabajo desarrollado por el practicante fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>Su percepción respecto a la preparación del alumno en términos de conocimientos para realizar su trabajo de práctica fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_sv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_sv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_sv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_sv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>Su percepción respecto a la preparación del alumno en términos de habilidades para realizar su trabajo de práctica fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_sv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_sv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_sv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_sv" value="Debe Mejorar" require></td>

</tr>


</table>
</div>


                  
            

                 <div class="col-sm-12">
              
              <label></label>
              <hr>
              </div>

              <div class="col-sm-12">
             <div class="form-group">
            <label for="exampleFormControlTextarea1">Comentarios sobre la evaluación del desempeño</label>
            <textarea class="form-control" id="comentarios_sv" rows="3" style="text-transform:uppercase" require></textarea>
             </div>
             </div>

             <div class="col-sm-12">
                 <div class="form-group">
                <label for="exampleFormControlTextarea1">Por favor anotar ¿Cuales de las áreas cree usted que deben reforzar o adquirir nuevos conocimientos?</label>
                <textarea class="form-control" id="areas_refuerzo_sv" rows="3" style="text-transform:uppercase" require></textarea>
                 </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>¿Cual seria su calificación global de 0 a 10 para el o la practicante?</label>
                    <select class="form-control" name="calificacion_sv" id="calificacion_sv" require> <option value="">Seleccione</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>¿Solicitaría nuevamente uno de nuestros estudiantes para practica profesional supervisada en su empresa?</label>
                    <select class="form-control" name="solicitar_practicante_sv" id="solicitar_practicante_sv" require> <option value="">Seleccione</option>
                    <option value="Si">SI</option>
                    <option value="No">NO</option>
                </select>
                </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>¿El estudiante tendrá alguna oportunidad de empleo en la organización?</label>
                    <select class="form-control" name="oportunidad_empleo_sv" id="oportunidad_empleo_sv" require> <option value="">Seleccione</option>
                    <option value="Si">SI</option>
                    <option value="No">NO</option>
                    <option value="No">PROBABLEMENTE</option>
                </select>
                </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>Nombre completo del representante de la carrera de informática que le ha contactado</label>
                    <input class="form-control" type="text" id="representante_sv" name="representante_sv" style="text-transform:uppercase" maxlength="60"  require>
                </div>
                 </div>


                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>Lugar</label>
                    <input class="form-control" type="text" id="lugar_sv" name="lugar_sv" style="text-transform:uppercase" maxlength="60" require>
                </div>
                 </div>

                
                

                 
            </div>
                <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" onclick="guardar()"><i class="zmdi zmdi-floppy"></i>Guardar</button>
              </p>
          </div>



          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>
         
         
    
    <div class="RespuestaAjax"></div>
 </form>

 

  </div>
 </section>


 </div>


	

  <script type="text/javascript">
function llenar_select2(){
  
  var cadena="&activar=activar"
  $.ajax({
      url: "../Controlador/guardar_segunda_visita_controlador.php?op=selectCurso",
        type: "POST",
        data: cadena,
        success: function(r){
        
      
          $("#curso").html(r).fadeIn();
        }
      

  });
 
}
llenar_select2();



	function llenarCampos(inputSelect){
    document.getElementById("idInput").value = inputSelect.options[inputSelect.selectedIndex].value;
    var id_persona1=inputSelect.options[inputSelect.selectedIndex].value;
    console.log(id_persona1);
    console.log("hola");

   


 $.post("../Controlador/guardar_segunda_visita_controlador.php?op=rellenarDatos",{id_persona: id_persona1}, function(data, status)
	{
    
		data = JSON.parse(data);
		console.log(data);
		//mostrarform(true);

		//TBL_PRACTICA_ESTUDIANTES
		$("#inicio_sv").val(data.fecha_inicio);
		$("#finalizacion_sv").val(data.fecha_finaliza);
		$("#horas_sv").val(data.horas);
//TBL_PERSONAS_EXTENDIDAS
		$("#cuenta_sv").val(data.valor);
//TBL_EMPRESAS_PRACTICA
    $("#empresa_sv").val(data.nombre_empresa);
 		$("#jefe_sv").val(data.jefe_inmediato);
		$("#titulo_sv").val(data.titulo_jefe_inmediato);
		$("#correo_sv").val(data.correo_jefe_inmediato);
		$("#telefono_sv").val(data.telefono_jefe_inmediato);
//TBL_PERSONAS
		$("#estudiante_sv").val(data.nombres);




	 })

}



 </script>





 


 </body>
 </html>


