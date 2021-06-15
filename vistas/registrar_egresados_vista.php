<?php 
ob_start();
session_start();
require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


$ano_graduacion = date('Y');


//Objeto de egresado
        $Id_objeto=22 ; 


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
                           window.location = "../vistas/menu_egresados_vista.php";

                            </script>';
}

else

{
  
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REGISTRAR EGRESADOS.');


if (permisos::permiso_insertar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_egresados']="";
}
else
{
    $_SESSION['btn_guardar_egresados']="disabled";
 }


}

ob_end_flush();



?>


<!DOCTYPE html>
<html>
<head>
   <script src="../js/Validacion_registrar_egresados.js"></script>
  <title></title>
</head>
<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registro de Egresados</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Vinculación</li>
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
      
<form action="../Controlador/guardar_egresado_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax" >

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Nuevo</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">

                 <div class="col-sm-4">
                <div class="form-group">
                  <label>Nombre Completo</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_egresado" name="txt_nombre_egresado"  value="" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)">
                </div>
                 </div>


                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Nº de Cuenta</label>
                    <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta" maxlength="11" pattern="[0-9]{11}" required onkeyup="Espacio(this,event)" onkeypress="return Numeros(event)" title="El número de cuenta no es valido">
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Año de Graduación</label>
                  <select class="form-control" id="txt_fecha_graduacion" name="txt_fecha_graduacion" >
<?php while ($ano_graduacion >= 1980) { ?>
  <option value="<?php echo($ano_graduacion); ?>"><?php echo($ano_graduacion); ?></option>
<?php $ano_graduacion = ($ano_graduacion-1); } ?>
</select>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Teléfono Fijo</label>
                    <input class="form-control" type="text" id="txt_telefono_fijo" name="txt_telefono_fijo" pattern="[2][2][0-9]{6}" value="" maxlength="8" onkeypress="return Numeros(event)" title="El número que ingresó no es correcto" required>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Celular</label>
                    <input class="form-control" type="text" id="txt_telefono_celular" name="txt_telefono_celular" pattern="[3|8|9][0-9]{7}" value="" required onkeypress="return Numeros(event)" maxlength="8" title="El número que ingresó no es correcto">
                </div>
                 </div>


                 <div class="col-sm-4">
                 <div class="form-group">
                  <label>Correo Personal</label>
                    <input class="form-control" type="email" id="txt_correo_personal" name="txt_correo_personal" value="" required onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" >
                </div>
               </div>



                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Posee Maestría</label>
                    <select class="form-control" name="cb_maestria" id="cb_maestria" onchange="Mostrarmaestria();"> 
          <option value="0">Seleccione una opción:</option>
                   <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                </div>
                 </div>


                 <div class="col-sm-4">
                  <div class="form-group">
                  <label name="lblmaestria" id="lblmaestria">Maestría</label>
                    <input class="form-control" type="text" id="txtmaestria" name="txtmaestria"  value=""   onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="50">
                </div>
                 </div>



                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Posee Certificados</label>
                    <select class="form-control" name="cb_certificado" id="cb_certificado" onchange="Mostrarcertificado();">
          <option value="0">Seleccione una opción:</option>
                <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                </div>
                 </div>


                 <div class="col-sm-4" name="item_table" id="item_table">
                  <div class="form-group">
                  <label  name="lblcertificado" id="lblcertificado">Certificados</label>
                    
  <input class="form-control" type="text"  maxlength="60" id="txtcertificado" name="txtcertificado"  value=""  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >

                </div>
                
                 </div>


                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Labora</label>
                    <select class="form-control" name="cb_labora" id="cb_labora" onchange="Mostrarlabor();">
          <option value="0">Seleccione una opción:</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                </div>
                 </div>

                   <div class="col-sm-4" >
                    <div class="form-group">
                  <label name="lbllaboranombre" id="lbllaboranombre">Nombre de la Empresa</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_empresa" name="txt_nombre_empresa"  value=""  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                    <div class="col-sm-4">
                    <div class="form-group">
                 <label name="lbllaboradepartamento" id="lbllaboradepartamento">Departamento de la Empresa</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_departamento" name="txt_departamento"  value=""  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>



                 <div class="col-sm-4" >
                  <div class="form-group">
                  <label name="lbllaboradireccion" id="lbllaboradireccion">Dirección de la Empresa</label>
                    <input class="form-control" type="text"  maxlength="150" id="txt_direccion_empresa" name="txt_direccion_empresa"  value=""  style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>



                 <div class="col-sm-4">
                  <div class="form-group">
                   <label name="lbllaboratelefono" id="lbllaboratelefono">Teléfono</label>
                    <input class="form-control" type="text" id="txt_telefono_empresa" name="txt_telefono_empresa"  value="" data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group">
                  <label name="lbllaboracorreo" id="lbllaboracorreo">Correo Profesional</label>
                    <input class="form-control" type="email" id="txt_correo_profesional" name="txt_correo_profesional" value="" onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" >
                </div>
                </div>

             
                  
            </div>
                <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_egresados" name="btn_guardar_egresados"> <?php echo $_SESSION['btn_guardar_egresados']; ?><i class="zmdi zmdi-floppy"></i>Guardar</button>
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
	


 $('#txt_nombre_empresa').hide();
 $('#txt_departamento').hide();
 $('#txt_direccion_empresa').hide();
 $('#txt_telefono_empresa').hide();
  $('#lbllaboranombre').hide();
$('#lbllaboradireccion').hide();
$('#lbllaboradepartamento').hide();
$('#lbllaboratelefono').hide();
$('#lbllaboracorreo').hide();
$('#txt_correo_profesional').hide();



function Mostrarlabor()
{
/* Para obtener el valor */
var cblabor = document.getElementById("cb_labora").value;


  if (cblabor == "SI") {
        $('#txt_nombre_empresa').show();
        $('#txt_departamento').show();
        $('#txt_direccion_empresa').show();
        $('#txt_telefono_empresa').show();
            $('#lbllaboranombre').show();
$('#lbllaboradireccion').show();
$('#lbllaboradepartamento').show();
$('#lbllaboratelefono').show();
$('#lbllaboracorreo').show();
$('#txt_correo_profesional').show();


    }
    else {
     $('#txt_correo_profesional').hide();

         $('#txt_nombre_empresa').hide();
         $('#txt_departamento').hide();
         $('#txt_direccion_empresa').hide();
         $('#txt_telefono_empresa').hide();
           $('#lbllaboranombre').hide();
$('#lbllaboradireccion').hide();
$('#lbllaboradepartamento').hide();
$('#lbllaboratelefono').hide();
$('#lbllaboracorreo').hide();


    }

}


//Certificado

     $('#txtcertificado').prop("readonly", true);
    


function Mostrarcertificado()
{
/* Para obtener el valor */
var certicados = document.getElementById("cb_certificado").value;


  if (certicados == "SI") {
     $('#txtcertificado').prop("readonly", false);


    }
    else {
    	        $('#txtcertificado').prop("readonly", true);
    	     document.getElementById("txtcertificado").value = "";



    }

}
      


//maestria

        $('#txtmaestria').prop("readonly", true);


function Mostrarmaestria()
{
/* Para obtener el valor */
var maestrias = document.getElementById("cb_maestria").value;


  if (maestrias == "SI") {
        $('#txtmaestria').prop("readonly", false);



    }
    else {
           $('#txtmaestria').prop("readonly", true);
               document.getElementById("txtmaestria").value = "";

   }

}




</script>


</body>
</html>


