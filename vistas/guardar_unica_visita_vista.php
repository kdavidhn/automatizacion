<?php 
ob_start();
session_start();

require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');





?>


<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="../js/supervisiones/unica_visita.js"></script>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />

  <title></title>
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
      
<form action="" id="formulario" name="formulario" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">PRÁCTICA PROFESIONAL SUPERVISADA  PPS-IA-03                                                  </h3>

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
                  <option value="" >Seleccione</option>
                </select>
                </div>
                 </div>
                 

                  
                   
                    <input type="text" id="idInput" name="idInput" class="input" hidden />
            

                
             
                  

                  <div class="col-sm-6">
                  <div class="form-group">
                  <label>N de cuenta</label>
                    <input class="form-control" type="text" id="cuenta_uv" name="cuenta_uv"  readonly  maxlength="60" >
                </div>
                 </div>

                 <input hidden="true" name="id_unica_visita" id="id_unica_visita">


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre de la empresa o institución</label>
                    <input class="form-control" type="text" id="empresa_uv" name="empresa_uv"  maxlength="60" readonly>
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del jefe inmediato</label>
                    <input class="form-control" type="text" id="jefe_uv" name="jefe_uv" maxlength="60"   readonly>
                </div>
                 </div>
                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Titulo del jefe inmediato o representante de la institución</label>
                    <input class="form-control" type="text" id="titulo_uv" name="titulo_uv"   maxlength="60"readonly >
                </div>
                 </div>




                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Correo electrónico </label>
                    <input class="form-control" type="text" id="correo_uv" name="correo_uv"  maxlength="60"readonly  >
                </div>
                 </div>

                 
                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>No. de teléfono de la organización</label>
                    <input class="form-control" type="text" id="telefono_uv" name="telefono_uv"    data-inputmask='"mask": " 9999-9999"' data-mask readonly>
                </div>
                 </div>

        
          

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del estudiante</label>
                    <input class="form-control" type="text" id="estudiante_uv" name="estudiante_uv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Fecha de inicio</label>
                    <input class="form-control" type="text" id="inicio_uv" name="inicio_uv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Fecha de finalizacion</label>
                    <input class="form-control" type="text" id="finalizacion_uv" name="finalizacion_uv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Horas</label>
                    <input class="form-control" type="text" id="horas_uv" name="horas_uv"  maxlength="60" readonly >
                </div>
                 </div>

              

                 <div class="col-sm-12">
                 <br>
                  <label>FUNCIONES QUE REALIZA</label>
                  <hr>
                  </div>

                  

                  <div class="col-sm-6">
                  <input type="checkbox" value="Análisis de Sistemas" name="funciones_analisis_uv" /> <label> 1. Análisis de Sistemas</label><br/>
                  <input type="checkbox" value="Diseño de Sistemas" name="funciones_diseno_uv" /> <label> 2. Diseño de Sistemas</label><br/>
                  <input type="checkbox" value="Redes y Comunicación de Datos" name="funciones_redes_uv" /> <label> 3. Redes y Comunicación de Datos</label><br/>
                  </div>

                  
                  <div class="col-sm-6">
                  <input type="checkbox" value="Capacitación en el área Tecnológica" name="funciones_capacitacion_uv" /> <label> 7. Capacitación en el área Tecnológica</label><br/>
                  <input type="checkbox" value="Seguridad Informática" name="funciones_seguridad_uv" /> <label> 8. Seguridad Informática</label><br/>
                  <input type="checkbox" value="Auditoria de Sistema" name="funciones_auditoria_uv" /> <label> 9. Auditoria de Sistema</label><br/>
                  </div>

                  <div class="col-sm-6">
                  <input type="checkbox" value="Base de Datos" name="funciones_base_uv" /> <label> 4. Base de Datos</label><br/>
                  <input type="checkbox" value="Soporte de Aplicaciones" name="funciones_soporte_uv" /> <label> 5. Soporte de Aplicaciones</label><br/>
                  <input type="checkbox" value="Programación de Aplicaciones" name="funciones_programacion_uv" /> <label> 6. Programación de Aplicaciones</label><br/>
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
                 <br>
<br>
                 <br>
                  <label>EVALUACION PERSONAL</label>
                  <hr>
                  </div>

                  <div class="col-sm-12">
                  <label>Valores y cualidades</label>
                  </div>
                  <br>
                  <br>
                  


                  <div class="col-sm-12">
                  <table class="table">

  <tr>

    <th scope="row"></th>

    <th>Excelente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

    <th>Muy Bueno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

    <th>Bueno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

    <th>Regular&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

  </tr>
  

  <tr>

    <th>Comunicación</th>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_uv" value="Excelente" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_uv" value="Muy bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_uv" value="Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_uv" value="Regular" require></td>

  </tr>

  <tr>

    <th>Puntualidad</th>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_uv" value="Excelente" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_uv" value="Muy bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_uv" value="Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_uv" value="Regular" require></td>

  </tr>

  <tr>

    <th>Responsabilidad</th>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_uv" value="Excelente" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_uv" value="Muy Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_uv" value="Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_uv" value="Regular" require></td>

  </tr>

  <tr>

  <th>Creatividad</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_uv" value="Muy Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_uv" value="Regular" require></td>

</tr>

<tr>

<th>Presentación</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_uv" value="Excelente" require> </td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_uv" value="Muy Bueno" require> </td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_uv" value="Bueno" require> </td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_uv" value="Regular" require> </td>

</tr>

<tr>

<th>Atención al Cliente</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_uv" value="Muy Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_uv" value="Regular" require></td>

</tr>


</table>
</div>


                
                 <br>
                 <br>
<br>

                 <div class="col-sm-12">
                 <br>
                 <br>
<br>
                  <label>Competencias/Capacidades observadas</label><br>
                  <br>
                  </div>
                  
                  <div class="col-sm-12">
                  <table class="table">

<tr>

  <th scope="row"></th>

  <th>Básico &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

  <th>Intermedio&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

  <th>Avanzado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

  <th>No Aplica&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

</tr>


<tr>

  <th>Colaborativo</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_uv" value="No Aplica" require></td>

</tr>

<tr>

  <th>Trabajo en equipo</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_uv" value="No Aplica" require></td>

</tr>

<tr>

  <th>Proactivo con Iniciativa</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_uv" value="No Aplica" require></td>

</tr>

<tr>

<th>Relaciones Interpersonales</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_uv" value="No Aplica" require></td>

</tr>

<tr>

<th>Analisis de Sistemas</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_uv" value="No Aplica" require></td>

</tr>

<tr>

<th>Diseño de Aplicaciones</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_uv" value="No Aplica" require></td>

</tr>

<tr>

<th>Programador de Aplicaciones</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_uv" value="No Aplica" require></td>

</tr>

<tr>

<th>Mantenimiento de Aplicaciones</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_uv" value="No Aplica"></td>

</tr>

<th>Aspectos de auditoria de Sistemas</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_uv" value="No Aplica" require></td>

</tr>

<th>Aspectos de auditoria Informática </th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_uv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_uv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_uv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_uv" value="No Aplica" require></td>


</tr>


</table>
</div>
      
                 

                 




                 

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

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_uv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="asistencia_uv" value="Debe Mejorar" require></td>

</tr>

<tr>

  <th>Los horarios establecidos por la empresa para el practicante fueron cumplidos en forma :</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_uv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="horarios_uv" value="Debe Mejorar" require></td>



</tr>

<tr>

  <th>La adaptación del practicante al equipo de trabajo asignado y al medio ambiente laboral fue :</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_uv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_uv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>El grado de cumplimiento de las tareas encomendadas al practicante fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_uv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_uv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>La calidad del trabajo desarrollado por el practicante fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_uv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_uv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>Su percepción respecto a la preparación del alumno en términos de conocimientos para realizar su trabajo de práctica fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_uv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_conocimientos_uv" value="Debe Mejorar" require></td>

</tr>

<tr>

<th>Su percepción respecto a la preparación del alumno en términos de habilidades para realizar su trabajo de práctica fue :</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_uv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_uv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_uv" value="Regular" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="percepcion_habilidades_uv" value="Debe Mejorar" require></td>

</tr>


</table>
</div>

                  
        

                 
                 <div class="col-sm-12">
              
              <label></label>
              <hr>
              </div>
              <br>
              <br>

              <div class="col-sm-12">
             <div class="form-group">
            <label for="exampleFormControlTextarea1">Comentarios sobre la evaluación del desempeño</label>
            <textarea class="form-control" name="comentarios_uv" id="comentarios_uv" rows="3" require> </textarea>
             </div>
             </div>

             <div class="col-sm-12">
                 <div class="form-group">
                <label for="exampleFormControlTextarea1">Por favor anotar ¿Cuales de las áreas cree usted que deben reforzar o adquirir nuevos conocimientos?</label>
                <textarea class="form-control" name="areas_refuerzo_uv" id="areas_refuerzo_uv" rows="3" require></textarea>
                 </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>¿Cual seria su calificación global de 0 a 10 para el o la practicante?</label>
                    <select require class="form-control" name="calificacion_uv" id="calificacion_uv"> <option value="">Seleccione</option>
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
                    <select class="form-control" name="solicitar_practicante_uv" id="solicitar_practicante_uv"> <option value="" require>Seleccione</option>
                    <option value="Si">SI</option>
                    <option value="No">NO</option>
                </select>
                </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>¿El estudiante tendrá alguna oportunidad de empleo en la organización?</label>
                    <select class="form-control" name="oportunidad_empleo_uv" id="oportunidad_empleo_uv"> <option value="" require>Seleccione</option>
                    <option value="Si">SI</option>
                    <option value="No">NO</option>
                    <option value="No">PROBABLEMENTE</option>
                </select>
                </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>Nombre completo del representante de la carrera de informática que le ha contactado</label>
                    <input class="form-control" type="text" id="representante_uv" name="representante_uv" maxlength="60"  require>
                </div>
                 </div>


                 <div class="col-sm-12">
                  <div class="form-group">
                  <label>Lugar</label>
                    <input class="form-control" type="text" id="lugar_uv" name="lugar_uv" maxlength="60"require >
                </div>
                 </div>

                 
                

                 
            </div>
                <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" onclick="guardar();"><i class="zmdi zmdi-floppy"></i>Guardar</button>
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
      url: "../Controlador/guardar_unica_visita_controlador.php?op=selectCurso",
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

   


 $.post("../Controlador/guardar_unica_visita_controlador.php?op=rellenarDatos",{id_persona: id_persona1}, function(data, status)
	{
    
		data = JSON.parse(data);
		console.log(data);
		//mostrarform(true);
//TBL_PRACTICA_ESTUDIANTES
		$("#inicio_uv").val(data.fecha_inicio);
		$("#finalizacion_uv").val(data.fecha_finaliza);
		$("#horas_uv").val(data.horas);
//TBL_PERSONAS_EXTENDIDAS
		$("#cuenta_uv").val(data.valor);
//TBL_EMPRESAS_PRACTICA
    $("#empresa_uv").val(data.nombre_empresa);
 		$("#jefe_uv").val(data.jefe_inmediato);
		$("#titulo_uv").val(data.titulo_jefe_inmediato);
		$("#correo_uv").val(data.correo_jefe_inmediato);
		$("#telefono_uv").val(data.telefono_jefe_inmediato);
//TBL_PERSONAS
		$("#estudiante_uv").val(data.nombres);



	 })

}



 </script>

 </body>
 
 </html>

 


