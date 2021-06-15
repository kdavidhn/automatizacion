<?php
ob_start();

session_start();

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');



      $Id_objeto=23 ; 

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

        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A GESTION DE EGRESADOS');




   }


   $counter = 0;
   $sql_tabla_egresados = json_decode( file_get_contents('http://informaticaunah.com/automatizacion/api/egresados_api.php'), true );

if (isset($_GET['id_egresado'])) 
{

  $_SESSION["id_egresado"] = $_GET['id_egresado']; 
$sql_egresados = json_decode( file_get_contents("http://informaticaunah.com/automatizacion/api/egresados_api.php?id_egresado=".$_SESSION["id_egresado"]), true );
 $_SESSION["nombre_completo_gestion"]=$sql_egresados["ROWS"][0]["nombre"];
 $_SESSION["telefono_gestion_egresado"]=$sql_egresados["ROWS"][0]["telefono_egresado"];
 $_SESSION["celular_gestion_egresado"]=$sql_egresados["ROWS"][0]["celular_egresado"];
 $_SESSION["correo_personal_gestion_egresado"]=$sql_egresados["ROWS"][0]["correo_electronico"];
 $_SESSION["posee_maestria_gestion_egresado"]=$sql_egresados["ROWS"][0]["posee_maestria"];
 $_SESSION["maestria_gestion_egresado"]=$sql_egresados["ROWS"][0]["maestria"];
 $_SESSION["posee_certificado_gestion_egresado"]=$sql_egresados["ROWS"][0]["posee_certificado"];
 $_SESSION["certficado_gestion_egresado"]=$sql_egresados["ROWS"][0]["certificado"];
 $_SESSION["labora_gestion_egresado"]=$sql_egresados["ROWS"][0]["labora"];
 $_SESSION["nombre_empresa_gestion_egresado"]=$sql_egresados["ROWS"][0]["nombre_empresa"];
 $_SESSION["direccion_empresa_gestion_egresado"]=$sql_egresados["ROWS"][0]["direccion_empresa"];
 $_SESSION["telefono_empresa_gestion_egresado"]=$sql_egresados["ROWS"][0]["telefono_empresa"];
 $_SESSION["departamento_gestion_egresado"]=$sql_egresados["ROWS"][0]["departamento_egresado"];
 $_SESSION["correo_profesional_gestion_egresado"]=$sql_egresados["ROWS"][0]["correo_profesional"];
 

 //Modal Abrir

if (isset( $_SESSION["nombre_completo_gestion"])){


?>
  <script>
    $(function(){
    $('#modal_modificar_egresado').modal('toggle')

    })



  </script>;
<?php 
 


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


            <h1>Gestión de Egresados</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/registrar_egresados_vista.php">Nuevo Egresado</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
<!--Pantalla 2-->





 <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Egresados Existentes</h3>
              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <form class="well" action="../pdf/reporte_egresados.php" method="POST" target="_blank">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NOMBRE</th>
                  <th>TELÉFONO FIJO</th>
                  <th >CELULAR</th>
                  <th >CORREO PERSONAL</th>
                  <th>MODIFICAR</th>
                  </tr>
                </thead>
                <tbody>
   <?php  while ($counter< count($sql_tabla_egresados["ROWS"])) { ?>
                <tr>
 <td><?php echo $sql_tabla_egresados["ROWS"][$counter]["nombre"]; ?></td>
     <td><?php echo $sql_tabla_egresados["ROWS"][$counter]["telefono_egresado"]; ?></td>
     <td><?php echo $sql_tabla_egresados["ROWS"][$counter]["celular_egresado"]; ?></td>
     <td><?php echo $sql_tabla_egresados["ROWS"][$counter]["correo_electronico"]; ?></td>
     <td style="text-align: center;">
              
                       <a href="../vistas/gestion_egresados_vista.php?id_egresado=<?php echo $sql_tabla_egresados["ROWS"][$counter]["id_egresado"]; ?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" ></i>
                    </a>
                  </td>
      
               </tr>
                 <?php   $counter = $counter + 1; } ?>
             </tbody>
            </table>


          <nav class="text-center">
            <button type="submit"  class="btn btn-secondary btn-raised btn-sm" name= "btn_imprimir">Imprimir Reporte
                      <i class="zmdi zmdi-local-printshop"></i>
          </nav>

          </form>
         </div>
            <!-- /.card-body -->
          </div>


        
          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>



<!-- *********************Creacion del modal 

-->

<form action="../api/egresados_api.php?id_egresadoa=<?php echo  $_SESSION["id_egresado"] ?> "method="post"  data-form="update" autocomplete="off" >
                 


         <div class="modal fade" id="modal_modificar_egresado">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Gestión de Egresado</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>


               <!--Cuerpo del modal-->
            <div class="modal-body">
   




   <div class="card-body">
            <div class="row">
               

                   <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Nombre Completo</label>
                            <input class="form-control" type="text"  maxlength="60" id="txt_nombre_egresado" name="txt_nombre_egresado"  value="<?php echo $_SESSION['nombre_completo_gestion'];?>" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly>
                     
                    </div>
                   </div>


                  <div class="col-sm-4">
                  <div class="form-group">
                  <label>Teléfono Fijo</label>
                       <input class="form-control" type="text" id="txt_telefono_fijo" name="txt_telefono_fijo"   value="<?php echo $_SESSION['telefono_gestion_egresado'];?>"  data-inputmask='"mask": " 9999-9999"' data-mask>
                  </div>
                </div>

                  <div class="col-sm-4">
                  <div class="form-group">
                  <label>Celular</label>
                  <input class="form-control" type="text" id="txt_telefono_celular" name="txt_telefono_celular"  value="<?php echo $_SESSION['celular_gestion_egresado'];?>"  data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>

                  <div class="col-sm-4">
                 <div class="form-group">
                  <label>Correo Personal</label>
                     <input class="form-control" type="email" id="txt_correo_personal" name="txt_correo_personal"  value="<?php echo $_SESSION['correo_personal_gestion_egresado'];?>" required onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" >
                </div>
               </div>

                  <div class="col-sm-6">
                  <div class="form-group">
                  <label>Posee Maestría</label>
             <select class="form-control" name="cb_maestria" id="cb_maestria" onchange="Mostrarmaestria();"> 
            <option value="<?php echo $_SESSION['posee_maestria_gestion_egresado'];?>"><?php echo $_SESSION['posee_maestria_gestion_egresado'];?> </option>
                   <option value="<?php if ($_SESSION['posee_maestria_gestion_egresado']=="SI") {
echo "NO";
}
if ($_SESSION['posee_maestria_gestion_egresado']=="NO") {
echo "SI";
}?>"><?php if ($_SESSION['posee_maestria_gestion_egresado']=="SI") {
echo "NO";
}
if ($_SESSION['posee_maestria_gestion_egresado']=="NO") {
echo "SI";
}?></option>

                </select>
                </div>
                 </div>

                  <div class="col-sm-6">
                  <div class="form-group">
                  <label name="lblmaestria" id="lblmaestria">Maestría</label>
                   <input class="form-control" type="text" id="txtmaestria" name="txtmaestria"  value="<?php echo $_SESSION['maestria_gestion_egresado'];?>"  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="50">
                </div>
                 </div>

                  <div class="col-sm-6">
                  <div class="form-group">
                  <label>Posee Certificados</label>
                    <select class="form-control" name="cb_certificado" id="cb_certificado" onchange="Mostrarcertificado();">
               <option value="<?php echo $_SESSION['posee_certificado_gestion_egresado'];?>"><?php echo $_SESSION['posee_certificado_gestion_egresado'];?> </option>
                   <option value="<?php if ($_SESSION['posee_certificado_gestion_egresado']=="SI") {
echo "NO";
}
if ($_SESSION['posee_certificado_gestion_egresado']=="NO") {
echo "SI";
}?>"><?php if ($_SESSION['posee_certificado_gestion_egresado']=="SI") {
echo "NO";
}
if ($_SESSION['posee_certificado_gestion_egresado']=="NO") {
echo "SI";
}?></option>
                </select>
                </div>
                 </div>


                 <div class="col-sm-6" name="item_table" id="item_table">
                  <div class="form-group">
                  <label  name="lblcertificado" id="lblcertificado">Certificados</label>
                    <input class="form-control" type="text"  maxlength="60" id="txtcertificado" name="txtcertificado"  value="<?php echo $_SESSION['certficado_gestion_egresado'];?>"  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase"  >

                </div>
                
                 </div>


                  <div class="col-sm-4">
                  <div class="form-group">
                  <label>Labora</label>
                   <select class="form-control" name="cb_labora" id="cb_labora" onchange="Mostrarlabor();">
               <option value="<?php echo $_SESSION['labora_gestion_egresado'];?>"><?php echo $_SESSION['labora_gestion_egresado'];?> </option>
                   <option value="<?php if ($_SESSION['labora_gestion_egresado']=="SI") {
echo "NO";
}
if ($_SESSION['labora_gestion_egresado']=="NO") {
echo "SI";
}?>"><?php if ($_SESSION['labora_gestion_egresado']=="SI") {
echo "NO";
}
if ($_SESSION['labora_gestion_egresado']=="NO") {
echo "SI";
}?></option>
                </select>
                </div>
                 </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                  <label name="lbllaboranombre" id="lbllaboranombre">Empresa</label>
                     <input class="form-control" type="text"  maxlength="60" id="txt_nombre_empresa" name="txt_nombre_empresa"  value="<?php echo $_SESSION['nombre_empresa_gestion_egresado'];?>" style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                 <label name="lbllaboradepartamento" id="lbllaboradepartamento">Departamento</label>
                     <input class="form-control" type="text"  maxlength="60" id="txt_departamento" name="txt_departamento"  value="<?php echo $_SESSION['departamento_gestion_egresado'];?>" style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>



                  <div class="col-sm-4">
                  <div class="form-group">
                  <label name="lbllaboradireccion" id="lbllaboradireccion">Dirección</label>
                    <input class="form-control" type="text"  maxlength="150" id="txt_direccion_empresa" name="txt_direccion_empresa"  value="<?php echo $_SESSION['direccion_empresa_gestion_egresado'];?>"  style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>



                  <div class="col-sm-4">
                  <div class="form-group">
                   <label name="lbllaboratelefono" id="lbllaboratelefono">Teléfono</label>
                    <input class="form-control" type="text" id="txt_telefono_empresa" name="txt_telefono_empresa"  value="<?php echo $_SESSION['telefono_empresa_gestion_egresado'];?>" data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>

                  <div class="col-sm-4">
                <div class="form-group">
                  <label name="lbllaboracorreo" id="lbllaboracorreo">Correo Profesional</label>
                   <input class="form-control" type="email" id="txt_correo_profesional" name="txt_correo_profesional" value="<?php echo $_SESSION['correo_profesional_gestion_egresado'];?>" onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" >
                </div>
                </div>

          
<!--
              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-info btn-raised btn-sm" id="" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>
-->
              </div>
            </div>
          </div>

          




            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn_modificar_egresado" name="btn_modificar_egresado" >Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- /.  finaldel modal -->


    </form>



<script type="text/javascript">
   if (document.getElementById("cb_labora").value == "SI") {
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
    else
    {
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
    }






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
  if (document.getElementById("cb_certificado").value == "SI") {
 $('#txtcertificado').prop("readonly", false);



    }
    else
    {
 $('#txtcertificado').prop("readonly", true);

    }
    


function Mostrarcertificado()
{
/* Para obtener el valor */
var certicados = document.getElementById("cb_certificado").value;


  if (certicados == "SI") {
     $('#txtcertificado').prop("readonly", false);


    }
    else {
              $('#txtcertificado').prop("readonly", true);



    }

}
      


//maestria



  if (document.getElementById("cb_maestria").value == "SI") {
        $('#txtmaestria').prop("readonly", false);



    }
    else
    {
              $('#txtmaestria').prop("readonly", true);

    }
function Mostrarmaestria()
{
/* Para obtener el valor */
var maestrias = document.getElementById("cb_maestria").value;


  if (maestrias == "SI") {
        $('#txtmaestria').prop("readonly", false);



    }
    else {
           $('#txtmaestria').prop("readonly", true);

   }

}




</script>




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

<?php
if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
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
       
        }
              if ($msj==2)
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
                    if ($msj==3)
                   {
                   echo '<script type="text/javascript">
                                                  swal({
                                                       title:"",
                                                       text:"Lo sentimos tiene campos por rellenar.",
                                                       type: "info",
                                                       showConfirmButton: false,
                                                       timer: 3000
                                                    });

                                                </script>';
                                              }
      }
?>