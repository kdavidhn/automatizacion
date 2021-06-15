<?php 
ob_start();
session_start();
require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');




//Objeto de egresado
        $Id_objeto=24 ; 


$visualizacion= permiso_ver($Id_objeto);
/*
$sql_coordinador=("select nombre_,numero_cuenta,Correo_Electronico,direccion,cargo,telefono  from tbl_usuarios where Usuario='$_SESSION[usuario]' ");
 //Obtener la fila del query
$datos_coordi = mysqli_fetch_assoc($mysqli->query($sql_coordinador));

$_SESSION['nombre_completo_coordi']=$datos_coordi['nombre_completo'];
$_SESSION['cuenta_coordi']=$datos_coordi['numero_cuenta'];
$_SESSION['Correo_Electronico_coordi']=$datos_coordi['Correo_Electronico'];
$_SESSION['direccion_coordi']=$datos_coordi['direccion'];
$_SESSION['cargo_coordi']=$datos_coordi['cargo'];
$_SESSION['telefono_coordi']=$datos_coordi['telefono'];
*/



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
                           window.location = "../vistas/menu_proyectos_vista.php";

                            </script>';
}

else

{
  
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REGISTRAR PROYECTOS.');


if (permisos::permiso_insertar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_proyecto']="";
}
else
{
    $_SESSION['btn_guardar_proyecto']="disabled";
 }


}

ob_end_flush();



?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registro de Proyectos Vinculacion Universidad Sociedad</h1>
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
  <!-- pantalla 1 -->
      
<form action="../Controlador/guardar_proyecto_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax" id="insert_form">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">I. Informacion academica del Proyecto</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">


                 <div class="col-sm-4">
                <div class="form-group">
                  <label>Codigo de Proyecto</label>
                    <input class="form-control" type="text"  maxlength="12" id="txt_cod_proyecto" name="txt_cod_proyecto"  value="" required onkeyup="DobleEspacio(this, event)"  onkeypress="return Numeros(event)">
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label>Nombre de Proyecto</label>
                    <input class="form-control" type="text" id="txt_nombre_proyecto" name="txt_nombre_proyecto"  value="" required   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="50">
                </div>
                 </div>



                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Tipo de Proyecto</label>
                    <input class="form-control" type="text" id="txt_tipo_proyecto" name="txt_tipo_proyecto"  value="" required maxlength="30"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase">
                </div>
                 </div>

              


                   <div class="col-sm-12">
                   <hr>
                  <label>Unidad Academica</label>

              
                  </div>
                  


                  <div class="col-sm-4">
                  <div class="form-group">
                  <label> Centro Regional </label>
                    <input class="form-control" type="text" id="txt_centro_regional" name="txt_centro_regional"  value="CIUDAD UNIVERSITARIA" required  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="12">
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label> Carrera </label>
                    <input class="form-control" type="text" id="txt_carrera" name="txt_carrera"  value="INFORMATICA ADMINISTRATIVA" required   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60">
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label> Departamento </label>
                    <input class="form-control" type="text" id="txt_departamento" name="txt_departamento"  value="" required  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="30">
                </div>
                 </div>



                 <div class="col-sm-12">
                  <hr>
                  <label>Tiempo de Ejecucion </label>
                  </div>

                <div class="col-sm-6">
                <div class="form-group">
                  <label>Fecha de Inicio</label>
                    <input class="form-control" type="date" id="txt_fecha_inicio" name="txt_fecha_inicio"  >
                </div>
              </div>

                <div class="col-sm-6">
                 <div class="form-group">
                  <label>Fecha de Finalizacion</label>
                    <input class="form-control" type="date" id="txt_fecha_final" name="txt_fecha_final"  >
                </div>
              </div>

              <div class="col-sm-12">
                <hr>
                  <label>Fecha de Evaluacion </label>
                  </div>

                <div class="col-sm-6">
                <div class="form-group">
                  <label>Intermedia</label>
                    <input class="form-control" type="date" id="txt_fecha_intermedia" name="txt_fecha_intermedia"  >
                </div>
              </div>

                <div class="col-sm-6">
                 <div class="form-group">
                  <label>Final</label>
                    <input class="form-control" type="date" id="txt_fecha_final_evaluacion" name="txt_fecha_final_evaluacion"  >
                </div>
              </div>

               <div class="col-sm-12">
                <hr>
                  <label>Beneficiarios </label>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                  <label> Directos </label>
                    <input class="form-control" type="text" id="txt_beneficiario_directo" name="txt_beneficiario_directo"  value="" required  onkeyup="Espacio(this, event)" onkeypress="return Numeros(event)" maxlength="4">
                </div>
                 </div>

                  <div class="col-sm-4">
                  <div class="form-group">
                  <label> Indirectos  </label>
                    <input class="form-control" type="text" id="txt_beneficiario_indirecto" name="txt_beneficiario_indirecto"  value="" required  onkeyup="Espacio(this, event)"  onkeypress="return Numeros(event)" maxlength="4">
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label> Total </label>
                    <input class="form-control" type="text" id="txt_beneficiarios
                    " name="txt_beneficiarios"  value="" required  onkeyup="Espacio(this, event)"  onkeypress="return Numeros(event)" maxlength="4">
                </div>
                 </div>


                <div class="col-sm-12">
                <hr>
                </div>
                   <div class="col-sm-4">
                  <div class="form-group">
                  <label>Modalidad </label>
                  <select class="form-control select2" style="width: 100%;" name="combo_modalidad" required="">
          <option value="0"  >Seleccione una Modalidad:</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_modalidades_proyecto ");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['Id_modalidad'].'"> '.$resultado['modalidad'].'</option>' ;
          }
        ?>
                </select>
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label>Tipo de Vinculacion </label>
                  <select class="form-control select2" style="width: 100%;" name="combo_tipo" required="">
          <option value="0"  >Seleccione un Tipo de Vinculacion:</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_tipos_vinculacion ");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['Id_tipo_v'].'"> '.$resultado['tipo'].'</option>' ;
          }
        ?>
                </select>
                </div>
                 </div>

                    <div class="col-sm-4">
                  <div class="form-group">
                  <label>Costo del Proyecto</label>
                    <input class="form-control" type="text" id="txt_costo_proyecto
                    " name="txt_costo_proyecto"  value="" required onkeypress="return Numeros(event)"  onkeyup="Espacio(this, event)" style="text-transform: uppercase" maxlength="12">
                </div>
                 </div>

                 <div class="col-sm-12">
                   <hr>
                  <label>Vinculacion con la Entidad </label>

              
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                  <label> Nombre </label>
                    <input class="form-control" type="text" id="txt_nombre_empresa" name="txt_nombre_empresa"  value="" required   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="50">
                </div>
                 </div>


                   <div class="col-sm-4">
                  <div class="form-group">
                  <label>Aporte en el Proyecto: </label>
                  <select class="form-control select2" style="width: 100%;" name="combo_aporte_empresa" required="">
          <option value="0"  >Seleccione una opcion:</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_empresa_aporte_proyecto ");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['Id_aporte'].'"> '.$resultado['aporte'].'</option>' ;
          }
        ?>
                </select>
                </div>
                 </div>


                   <div class="col-sm-4">
                  <div class="form-group">
                  <label>Doc. de formalización  </label>
                  <select class="form-control select2" style="width: 100%;" name="combo_formalizacion" required="">
          <option value="0"  >Seleccione una opcion:</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_tipo_formalizacion_proyecto ");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['Id_tipo_formalizacion'].'"> '.$resultado['tipo_formalizacion'].'</option>' ;
          }
        ?>
                </select>
                </div>
                 </div>

                 
                  <div class="col-sm-3">
                  <div class="form-group">
                  <label> Contacto  </label>
                    <input class="form-control" type="text" id="txt_contacto_institucional" name="txt_contacto_institucional"  value="" required style="text-transform: uppercase" maxlength="60"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)">
                </div>
                 </div>

                   <div class="col-sm-3">
                  <div class="form-group">
                  <label> Cargo </label>
                    <input class="form-control" type="text" id="txt_cargo" name="txt_cargo"  value="" required  style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)"maxlength="30">
                </div>
                 </div>

                 <div class="col-sm-3">
                  <div class="form-group">
                  <label> Telefono </label>
                    <input class="form-control" type="text" id="txt_telefono_contacto" name="txt_telefono_contacto"  value="" required  data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>

                 <div class="col-sm-3">
                  <div class="form-group">
                  <label> Correo Electronico </label>
                    <input class="form-control" type="email" id="txt_correo_contacto" name="txt_correo_contacto"  value="" required  onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="30">
                </div>
                 </div>

                  <div class="col-sm-12">
                   <hr>
                  <label>II. Responsables del Proyecto</label>
                  <hr>
                  <label>Coordinador del Proyecto </label>
                  </div>

         

                  <div class="col-sm-4">
                  <div class="form-group">
                  <label> Nombre  </label>
                    <input class="form-control" type="text" id="txt_nombre_coordinador" name="txt_nombre_coordinador"  value="" required  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60">
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label> Nº de Empleado </label>
                    <input class="form-control" type="text" id="txt_num_empleado" name="txt_num_empleado"  value="" required   onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="12">
                </div>
                 </div>

                     <div class="col-sm-4">
                  <div class="form-group">
                  <label> Direccion </label>
                    <input class="form-control" type="text" id="txt_direccion_cor" name="txt_direccion_cor"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60">
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label> Cargo  </label>
                    <input class="form-control" type="text" id="txt_cargo_coordinador" name="txt_cargo_coordinador"  value="" required  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="40">
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label>Telefono </label>
                    <input class="form-control" type="text" id="txt_telefono_coordinador" name="txt_telefono_coordinador"  value="" required  data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label> Correo Electronico </label>
                    <input class="form-control" type="email" id="txt_correo_coordinador" name="txt_correo_coordinador"  value="" required  onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50">
                </div>
                 </div>

                  <div class="col-sm-12">
                   <hr>
                  </div>
                   <table class="table table-bordered" id="integrantes">
      <tr>
      <th colspan="3" style="text-align: center;">Integrantes del Proyecto</th>
       <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus-circle"></span></button></th>
      </tr>
     </table>

    


                    <div class="col-sm-12">
                   <hr>
                  <label>III. Zona de influencia del Proyecto</label>
                  <hr>
                 </div>

                      <div class="col-sm-4">
                  <div class="form-group">
                  <label> Region  </label>
                    <input class="form-control" type="text" id="txt_region" name="txt_region"  value="" required  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="20">
                </div>
                 </div>

                      <div class="col-sm-4">
                  <div class="form-group">
                  <label> Departamento  </label>
                   <select class="form-control select2" style="width: 100%;" name="combo_depto" id="combo_depto" required="">
          <option value="0"  >Seleccione el Departamento</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_departamentos");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['id_departamento'].'"> '.$resultado['departamento'].'</option>' ;
          }  
        ?>
                </select>
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label> Municipio  </label>
                  <select class="form-control select2" style="width: 100%;" name="combo_muni" id="combo_muni" required="">
          <option value="0"  >Seleccione el Municipio</option>


                </select>
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label> Aldea/Caserio </label>
                    <input class="form-control" type="text" id="txt_aldea_caserio" name="txt_aldea_caserio"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="50">
                </div>
                 </div>

                      <div class="col-sm-4">
                  <div class="form-group">
                  <label> Barrio/Colonia  </label>
                    <input class="form-control" type="text" id="txt_barrio_colonia" name="txt_barrio_colonia"  value="" required onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="50">
                </div>
                 </div>

                   <div class="col-sm-4">
                  <div class="form-group">
                  <label>Entidad Beneficiaria </label>
                    <input class="form-control" type="text" id="txt_entidad_beneficiaria" name="txt_entidad_beneficiaria"  value="" required  " onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="50">
                </div>
                 </div>

                 <div class="col-sm-12">
                   <hr>
                  <label>IV. Informacion especifica del Proyecto</label>
                  <hr>
                 </div>

                      <div class="col-sm-6">
                  <div class="form-group">
                  <label> Objetivos de desarrollo </label>
                    <textarea class="form-control" rows="3" id="txt_objetivos" name="txt_objetivos"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="120"> </textarea>
                </div>
                 </div>

                      <div class="col-sm-6">
                  <div class="form-group">
                  <label> Objetivos inmediatos del proyecto </label>
                    <textarea class="form-control" rows="3" id="txt_objetivos_inmediatos" name="txt_objetivos_inmediatos"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="120"> </textarea>
                </div>
                 </div>

                  

                      <div class="col-sm-6">
                  <div class="form-group">
                  <label> Resultados esperados </label>
                    <textarea class="form-control" rows="3" id="txt_resultados_esperados" name="txt_resultados_esperados"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="120"> </textarea>
                </div>
                 </div>

                     <div class="col-sm-6">
                  <div class="form-group">
                  <label> Lista de Actividades Principales </label>
                    <textarea class="form-control" rows="3" id="txt_
                    actividades_principales" name="txt_actividades_principales"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="120"> </textarea>
                </div>
                 </div>




                               
            </div>

            
                <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_proyecto" name="btn_guardar_proyecto">  <?php echo $_SESSION['btn_guardar_proyecto']; ?><i class="zmdi zmdi-floppy"></i>Guardar</button>
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

<!--Llenar combo box municipios -->
<script>
$(function () {
 $("#combo_depto").change(function () {
    var el_departamento = $(this).val();
    console.log(el_departamento);

    $.post("../Controlador/municipios.php", {
      id_departamento: el_departamento,
    }).done(function (respuesta) {
      $("#combo_muni").html(respuesta);
      console.log(respuesta);
    });
  });
});
</script>



<script>
$(document).ready(function(){
 
 $(document).on('click', '.add', function(){
  var html = '';
  html += '<tr>';
   html += '<td>     <input class="form-control prueba" type="text" id="txt_nombre_estudiante1" name="txt_nombre_estudiante1[]"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder="NOMBRE DEL ESTUDIANTE"/></td>';
    html += '<td><input class="form-control txt_num_estudiante1" type="text" id="txt_num_estudiante1" name="txt_num_estudiante1[]"  value="" required   onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder=" Nº de Empleado"></td>';
  html += '<td>     <input class="form-control txt_direccion_estudiante1" type="text" id="txt_direccion_estudiante1" name="txt_direccion_estudiante1[]"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder="Direccion"/></td>';

   html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-circle"</span></button></td></tr>';
    html += '<tr>';
  html += '<td>    <input class="form-control txt_cargo_estudiante1" type="text" id="txt_cargo_estudiante1" name="txt_cargo_estudiante1[]"  value="" required  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder="Cargo" /></td>';
 html += '<td><input class="form-control txt_telefono_estudiante1" type="text" id="txt_telefono_estudiante1" name="txt_telefono_estudiante1[]"  value=""  onkeypress="return Numeros(event)" maxlength="8" placeholder="TELEFONO" /></td>';
 html += '<td><input class="form-control txt_correo_estudiante1" type="email" id="txt_correo_estudiante1" name="txt_correo_estudiante1[]"  value="" required  onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" placeholder="Correo Electronico"/></td>';
 
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-circle"></span></button></td></tr>';
  $('#integrantes').append(html);
 });
 
 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 });
 
 $('#insert_form').on('submit', function(event){
  event.preventDefault();
  var error = '';
  
   $('.txt_direccion_estudiante1').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
    $('.txt_num_estudiante1').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
     $('.txt_nombre_estudiante1').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });   $('.txt_correo_estudiante1').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });   $('.txt_telefono_estudiante1').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
     $('.txt_cargo_estudiante1').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
  if(error == '')
  {
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     if(data == 'ok')
     {
      $('#integrantes').find("tr:gt(0)").remove();
      $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
     }
    }
   });
  }
  else
  {
   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
  }
 });
 
});
</script>


</body>
</html>


