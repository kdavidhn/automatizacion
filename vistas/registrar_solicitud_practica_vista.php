<?php 
ob_start();
session_start();

require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

       $Id_objeto=39 ; 




$visualizacion= permiso_ver($Id_objeto);

$usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];
$sql_estudiante=("SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, c.valor Correo
FROM

  tbl_empresas_practica AS ep
JOIN tbl_personas AS a
ON ep.id_persona = a.id_persona
JOIN tbl_contactos c ON a.id_persona = c.id_persona
JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
            join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
            WHERE a.id_persona='$id_persona'");
 //Obtener la fila del query
$datos_estudiante = mysqli_fetch_assoc($mysqli->query($sql_estudiante));


$sql_empresa=(
"SELECT  ep.nombre_empresa, ep.direccion_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.telefono_jefe_inmediato
FROM
tbl_empresas_practica AS ep
WHERE ep.id_persona='$id_persona'");
 //Obtener la fila del query
$datos_empresa = mysqli_fetch_assoc($mysqli->query($sql_empresa));

$_SESSION['nombre_completo_estudiante']=$datos_estudiante['nombre'];
/*
$_SESSION['identidad_estudiante']=$datos_estudiante['identidad'];*/
$_SESSION['cuenta_estudiante']=$datos_estudiante['valor'];
$_SESSION['Correo_Electronico_estudiante']=$datos_estudiante['Correo'];
/*$_SESSION['direccion_estudiante']=$datos_estudiante['direccion'];

$_SESSION['telefono_estudiante']=$datos_estudiante['telefono'];
$_SESSION['celular_estudiante']=$datos_estudiante['celular'];*/

$_SESSION['nombre_empresa_practica']=$datos_empresa['nombre_empresa'];
$_SESSION['direccion_empresa_practica']=$datos_empresa['direccion_empresa'];
$_SESSION['nombre_jefe_inmediato_practica']=$datos_empresa['jefe_inmediato'];
$_SESSION['cargo_jefe_inmediato_practica']=$datos_empresa['cargo_jefe_inmediato'];
$_SESSION['titulo_jefe_inmediato_practica']=$datos_empresa['titulo_jefe_inmediato'];
$_SESSION['telefono_jefe_inmediato_practica']=$datos_empresa['telefono_jefe_inmediato'];




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
  
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REGISTRAR SOLICITUD PRACTICA.');


if (permisos::permiso_insertar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_solicitud_pps']="";
}
else
{
    $_SESSION['btn_guardar_solicitud_pps']="disabled";
 }


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
            <h1>Solicitud de Practica Profesional Supervisada</h1>
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
      
<form action="../Controlador/guardar_solicitud_practica_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

 <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Formulario IA-PPS-01</h3>

            <div class="card-tools">   
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">

            <div class="col-sm-12">
                  <label>DATOS PERSONALES</label>
                  <hr>
                  </div>


                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Nº de Cuenta</label>
                    <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $_SESSION['cuenta_estudiante'];?>"  readonly
                    >
                </div>
                 </div>


                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Nombre</label>
                    <input class="form-control" type="text" id="txt_nombre_solicitud" name="txt_nombre_solicitud" maxlength="60" value="<?php echo $_SESSION['nombre_completo_estudiante'];?>" readonly>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Identidad</label>
                    <input class="form-control" type="text" id="txt_identidad" name="txt_identidad"  value="" data-inputmask='"mask": " 9999-9999-99999"' data-mask >
                </div>
                 </div>


                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Fecha de nacimiento</label>
                    <input class="form-control" type="date" id="txt_fecha_nacimiento" name="txt_fecha_nacimiento">
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Teléfono Fijo</label>
                    <input class="form-control" type="text" id="txt_telefono_solicitud" name="txt_telefono_solicitud"  value="" data-inputmask='"mask": " 9999-9999"' data-mask  > 
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Celular</label>
                    <input class="form-control" type="text" id="txt_celular_solicitud" name="txt_celular_solicitud"  value="" data-inputmask='"mask": " 9999-9999"' data-mask >
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Dirección</label>
                    <input class="form-control" type="text" id="txt_direccion_solicitud" name="txt_direccion_solicitud" maxlength="150" value="">
                </div>
                 </div>

                 <div class="col-sm-4">
                 <div class="form-group">
                  <label>Correo electrónico</label>
                    <input class="form-control" type="email" id="txt_correo_solicitud" name="txt_correo_solicitud" value="<?php echo $_SESSION['Correo_Electronico_estudiante'];?>" readonly>
                </div>
               </div>

            

               <div class="col-sm-12">
                   <hr>
                  <label>DATOS PRACTICA PROFESIONAL</label>
                  <hr>
                  </div>

                  <div class="col-sm-4">
                  <div class="form-group">
                  <label>Nombre de la institución</label>
                    <input class="form-control" type="text" id="txt_institucion_solicitud" name="txt_institucion_solicitud" maxlength="60" value="<?php echo $_SESSION['nombre_empresa_practica'];?>" readonly>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Dirección</label>
                    <input class="form-control" type="text" id="txt_institucion_direccion_solicitud" name="txt_institucion_direccion_solicitud" maxlength="150" value="<?php echo $_SESSION['direccion_empresa_practica'];?>" readonly>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Trabaja en la empresa</label>
                    <select class="form-control" name="cb_trabaja" id="cb_trabaja">
          <option value="0">Seleccione una opcion:</option>
                <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Nombre del jefe inmediato</label>
                    <input class="form-control" type="text" id="txt_jefe_solicitud" name="txt_jefe_solicitud" maxlength="60" value="<?php echo $_SESSION['nombre_jefe_inmediato_practica'];?>" readonly>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Nombre del puesto</label>
                    <input class="form-control" type="text" id="txt_puesto_solicitud" name="txt_puesto_solicitud" maxlength="60" value="<?php echo $_SESSION['cargo_jefe_inmediato_practica'];?>" readonly>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Titulo profesional</label>
                    <input class="form-control" type="text" id="txt_puesto_solicitud" name="txt_puesto_solicitud" maxlength="60" value="<?php echo $_SESSION['titulo_jefe_inmediato_practica'];?>" readonly>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Teléfono</label>
                    <input class="form-control" type="text" id="txt_telefono_jefe_solicitud" name="txt_telefono_jefe_solicitud"  value="<?php echo $_SESSION['telefono_jefe_inmediato_practica'];?>" data-inputmask='"mask": " 9999-9999"' data-mask readonly>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Tipo de empresa</label>
                    <select class="form-control" name="cb_tipo_empresa" id="cb_tipo_empresa">
          <option value="0">Seleccione una opcion:</option>
                <option value="PRIVADA">PRIVADA</option>
                    <option value="PUBLICA">PUBLICA</option>
                    <option value="ONG">ONG</option>
                </select>
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Fecha estimada de inicio</label>
                    <input class="form-control" type="date" id="txt_fecha_inicio_estimada" name="txt_fecha_inicio_estimada">
                </div>
                 </div>

                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Fecha estimada de finalización</label>
                    <input class="form-control" type="date" id="txt_fecha_final_estimada" name="txt_fecha_final_estimada">
                </div>
                 </div>

                 
            </div>
                <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_solicitud_pps" name="btn_guardar_solicitud_pps"><i class="zmdi zmdi-floppy"></i>Guardar</button>
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
	


</script>


</body>
</html>

