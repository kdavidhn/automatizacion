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
<script type="text/javascript" src="../js/supervisiones/primera_visita.js"></script>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
</h
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
      
<form action="../Controlador/guardar_primera_visita_controlador.php" id="formulario" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">PRÁCTICA PROFESIONAL SUPERVISADA  PPS-IA-01                                                  </h3>

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
                  <label>N de cuenta</label>
                    <input class="form-control" type="text" id="cuenta_pv" name="cuenta_pv"  readonly  maxlength="60" >
                </div>
                 </div>

                 <input hidden="true" name="id_primera_visita" id="id_primera_visita">
                 






                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre de la empresa o institución</label>
                    <input class="form-control" type="text" id="empresa_pv" name="empresa_pv"    maxlength="60"readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del jefe inmediato</label>
                    <input class="form-control" type="text" id="jefe_pv" name="jefe_pv"   maxlength="60"readonly >
                </div>
                 </div>
                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Titulo del jefe inmediato o representante de la institución</label>
                    <input class="form-control" type="text" id="titulo_pv" name="titulo_pv"  maxlength="60"readonly >
                </div>
                 </div>


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Correo electrónico </label>
                    <input class="form-control" type="text" id="correo_pv" name="correo_pv"  maxlength="60" readonly >
                </div>
                 </div>

                 
                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>No. de teléfono de la organización</label>
                    <input class="form-control" type="text" id="telefono_pv" name="telefono_pv"   data-inputmask='"mask": " 9999-9999"' data-mask readonly>
                </div>
                 </div>

        
          

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del estudiante</label>
                    <input class="form-control" type="text" id="estudiante_pv" name="estudiante_pv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Fecha de inicio</label>
                    <input class="form-control" type="text" id="inicio_pv" name="inicio_pv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Fecha de finalizacion</label>
                    <input class="form-control" type="text" id="finalizacion_pv" name="finalizacion_pv"  maxlength="60" readonly >
                </div>
                 </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Horas</label>
                    <input class="form-control" type="text" id="horas_pv" name="horas_pv"  maxlength="60" readonly >
                </div>
                 </div>

                 

                
                <!-- <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del puesto que desempeña el estudiante</label>
                    <input class="form-control" type="text" id="sps_puesto_pv" name="puesto_pv" maxlength="60"  readonly>
                </div>
                 </div>-->

                 <div class="col-sm-12">
                 <br>
                 <br>
<br>
                  <label>FUNCIONES QUE REALIZA</label>
                  <hr>
                  </div>

                  <div class="col-sm-6">
                  <input type="checkbox" value="Análisis de Sistemas" name="funciones_analisis_pv" /> <label> 1. Análisis de Sistemas</label><br/>
                  <input type="checkbox" value="Diseño de Sistemas" name="funciones__diseno_pv" /> <label> 2. Diseño de Sistemas</label><br/>
                  <input type="checkbox" value="Redes y Comunicación de Datos" name="funciones_redes_pv" /> <label> 3. Redes y Comunicación de Datos</label><br/>
                  </div>

                  
                  <div class="col-sm-6">
                  <input type="checkbox" value="Capacitación en el área Tecnológica" name="funciones_capacitacion_pv" /> <label> 7. Capacitación en el área Tecnológica</label><br/>
                  <input type="checkbox" value="Seguridad Informática" name="funciones_seguridad_pv" /> <label> 8. Seguridad Informática</label><br/>
                  <input type="checkbox" value="Auditoria de Sistema" name="funciones_auditoria_pv" /> <label> 9. Auditoria de Sistema</label><br/>
                  </div>

                  <div class="col-sm-6">
                  <input type="checkbox" value="Base de Datos" name="funciones_base_pv" /> <label> 4. Base de Datos</label><br/>
                  <input type="checkbox" value="Soporte de Aplicaciones" name="funciones_soporte_pv" /> <label> 5. Soporte de Aplicaciones</label><br/>
                  <input type="checkbox" value="Programación de Aplicaciones" name="funciones_programacion_pv" /> <label> 6. Programación de Aplicaciones</label><br/>
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
                 <br><br>
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

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Excelente" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Muy bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Regular" require></td>

  </tr>

  <tr>

    <th>Puntualidad</th>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Excelente" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Muy bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Regular" require></td>

  </tr>

  <tr>

    <th>Responsabilidad</th>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Excelente" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Muy Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Bueno" require></td>

    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Regular" require></td>

  </tr>

  <tr>

  <th>Creatividad</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Muy Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Regular" require></td>

</tr>

<tr>

<th>Presentación</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Excelente" require> </td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Muy Bueno" require> </td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Bueno" require> </td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Regular" require> </td>

</tr>

<tr>

<th>Atención al Cliente</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Excelente" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Muy Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Bueno" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Regular" require></td>

</tr>


</table>
</div>


                  
                 
                 <br>
                 

                 <div class="col-sm-12">
                 <br><br>
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

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="No Aplica" require></td>

</tr>

<tr>

  <th>Trabajo en equipo</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="No Aplica" require></td>

</tr>

<tr>

  <th>Proactivo con Iniciativa</th>

  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="No Aplica" require></td>

</tr>

<tr>

<th>Relaciones Interpersonales</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="No Aplica" require></td>

</tr>

<tr>

<th>Analisis de Sistemas</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="No Aplica" require></td>

</tr>

<tr>

<th>Diseño de Aplicaciones</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="No Aplica" require></td>

</tr>

<tr>

<th>Programador de Aplicaciones</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="No Aplica" require></td>

</tr>

<tr>

<th>Mantenimiento de Aplicaciones</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="mantenimiento_pv" value="No Aplica"></td>

</tr>

<th>Aspectos de auditoria de Sistemas</th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_auditoria_pv" value="No Aplica" require></td>

</tr>

<th>Aspectos de auditoria Informática </th>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_pv" value="Básico" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_pv" value="Intermedio" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_pv" value="Avanzado" require></td>

<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aspectos_seguridad_pv" value="No Aplica" require></td>


</tr>


</table>
</div>


      
      
               


              <div class="col-sm-12"><br>
<br>
             <div class="form-group">
            <label for="exampleFormControlTextarea1">Observaciones que crea pertinentes</label>
            <textarea class="form-control" id="comentarios_pv" rows="3" require></textarea>
             </div>
             </div>

            
                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>¿Solicitaría nuevamente uno de nuestros estudiantes para practica profesional supervisada en su empresa?</label>
                    <select class="form-control" name="solicitar_practicante_pv" id="solicitar_practicante_pv" require> <option value="">Seleccione</option>
                    <option value="Si">SI</option>
                    <option value="No">NO</option>
                </select>
                </div>
                 </div>


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre completo del representante de la carrera de informática que le ha contactado</label>
                    <input class="form-control" type="text" id="representante_pv" name="representante_pv" maxlength="60" require>
                </div>
                 </div>


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Lugar</label>
                    <input class="form-control" type="text" id="lugar_pv" name="lugar_pv" maxlength="60" require>
                </div>
                 </div>

                 
                

                 
            </div>
                <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" onclick="guardar();" ><i class="zmdi zmdi-floppy"></i>Guardar</button>
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
      url: "../Controlador/guardar_primera_visita_controlador.php?op=selectCurso",
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

   


 $.post("../Controlador/guardar_primera_visita_controlador.php?op=rellenarDatos",{id_persona: id_persona1}, function(data, status)
	{
    
		data = JSON.parse(data);
		console.log(data);
		//mostrarform(true);
//TBL_PRACTICA_ESTUDIANTES
		$("#inicio_pv").val(data.fecha_inicio);
		$("#finalizacion_pv").val(data.fecha_finaliza);
		$("#horas_pv").val(data.horas);
//TBL_PERSONAS_EXTENDIDAS
		$("#cuenta_pv").val(data.valor);
//TBL_EMPRESAS_PRACTICA
    $("#empresa_pv").val(data.nombre_empresa);
 		$("#jefe_pv").val(data.jefe_inmediato);
		$("#titulo_pv").val(data.titulo_jefe_inmediato);
	//	$("#correo_pv").val(data.correo_jefe_inmediato);
		$("#telefono_pv").val(data.telefono_jefe_inmediato);
//TBL_PERSONAS
		$("#estudiante_pv").val(data.nombres);



	 })

}



 </script>

 


 </body>
 </html>


