<?php 

ob_start();

session_start();


require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');




if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
    {
  

                             echo '<script type="text/javascript">
                                 location.reload()
                              swal({
                                   title:"",
                                   text:"Los datos  se almacenaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();

                            </script>';
    }
      if ($msj==2)
    {

  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no se pudieron guardar los datos",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';
    }
      if ($msj==3)
    {


echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos tiene campos por rellenar",
                                   type: "info",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';
  } 
  
    
  

  }



//Objeto de EMPRESA
        $Id_objeto=17 ; 


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
                           window.location = "../vistas/menu_practica_vista.php";

                            </script>';
}

else

{
  $_SESSION['direccionamiento']="";
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REGISTRAR EMPRESAS PARA PRACTICA.');


if (permisos::permiso_insertar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_empresa_practica']="";
}
else
{
    $_SESSION['btn_guardar_empresa_practica']="disabled";
 }
 
  $usuario=$_SESSION['id_usuario'];
        $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
       $result= mysqli_fetch_assoc($mysqli->query($id));
       $id_persona=$result['id_persona'];
 
  $sqlexiste=("select count(Id_empresa) as existe  from tbl_empresas_practica where id_persona=$id_persona");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

 if ($existe['existe']==1 ) {
$_SESSION['Modificar_empresa']="SI";
$sql_tabla_empresa = json_decode( file_get_contents('http://informaticaunah.com/automatizacion/api/empresas_practica_api.php?id_persona='.$id_persona), true );
if (isset($sql_tabla_empresa["ROWS"][0]["nombre_empresa"])) 
{
  $_SESSION['Institucion']=$sql_tabla_empresa["ROWS"][0]["nombre_empresa"];
       $_SESSION['Direccion']=$sql_tabla_empresa["ROWS"][0]["direccion_empresa"];
   $_SESSION['Departamento']=$sql_tabla_empresa["ROWS"][0]["departamento_empresa"];
         $_SESSION['jefe_inmediato']=$sql_tabla_empresa["ROWS"][0]["jefe_inmediato"];
       $_SESSION['Titulo_jefe']=$sql_tabla_empresa["ROWS"][0]["titulo_jefe_inmediato"];
    $_SESSION['Cargo']=$sql_tabla_empresa["ROWS"][0]["cargo_jefe_inmediato"];
        $_SESSION['telefono']=$sql_tabla_empresa["ROWS"][0]["telefono_jefe_inmediato"];
         $_SESSION['correo']=$sql_tabla_empresa["ROWS"][0]["correo_jefe_inmediato"];
         $_SESSION['id_empresa']=$sql_tabla_empresa["ROWS"][0]["Id_empresa"];
        
$_SESSION['direccionamiento']=' action="../api/empresas_practica_api.php?id_empresaa=$_SESSION[id_empresa]"';

  
}


 }
 else
 {
  $_SESSION['Modificar_empresa']="NO";
$_SESSION['direccionamiento']=' action="../Controlador/guardar_empresa_practica_controlador.php"';

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
            <h1>Registro de Empresas para PPS</h1>
          </div>

         

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">PPS</li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="container-fluid">



      <form <?php echo $_SESSION['direccionamiento'] ?> method="post"  data-form="save" autocomplete="off"  class="FormularioAjax">
<!--
<form <?php echo $_SESSION['direccionamientom'] ?>  method="post"  data-form="save" autocomplete="off" style=" display:<?php echo $_SESSION['direccionamientom'] ?>" >

-->

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

                 <div class="col-sm-6">
                <div class="form-group">
                  <label>Institución </label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_empresa_practica" name="txt_nombre_empresa_practica"  value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['Institucion'];
                    }
                    else
                    {

                                            echo "";

                    }
                    ?>" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)">
                </div>
                 </div>


                 <div class="col-sm-6" >
                  <div class="form-group">
                  <label>Dirección </label>
                    <input class="form-control" type="text"  maxlength="150" id="txt_direccion_empresa_practica" name="txt_direccion_empresa_practica"  value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['Direccion'];
                    }
                    else
                    {
                                            echo "";

                    }
                    ?>"  style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>

                    <div class="col-sm-6">
                    <div class="form-group">
                 <label>Departamento</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_departamento_practica" name="txt_departamento_practica"  value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['Departamento'];
                    }
                    else
                    {
                                            echo "";

                    }
                    ?>"  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" >
                </div>
                 </div>


                   <div class="col-sm-6" >
                    <div class="form-group">
                  <label>Nombre del Jefe Inmediato</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_jefe_inmediato" name="txt_nombre_jefe_inmediato"  value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['jefe_inmediato'];
                    }
                    else
                    {
                                            echo "";

                    }
                    ?>"  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                    <div class="col-sm-6" >
                    <div class="form-group">
                  <label>Titulo Académico </label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_titulo_jefe_inmediato" name="txt_titulo_jefe_inmediato"  value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['Titulo_jefe'];
                    }
                    else
                    {
                                            echo "";

                    }
                    ?>"  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                   <div class="col-sm-6" >
                    <div class="form-group">
                  <label>Cargo</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_cargo_jefe_inmediato" name="txt_cargo_jefe_inmediato"  value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['Cargo'];
                    }
                    else
                    {
                                            echo "";

                    }
                    ?>"  style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" >
                </div>
                 </div>

                   <div class="col-sm-6">
                  <div class="form-group">
                  <label>Teléfono  </label>
                    <input class="form-control" type="text" id="txt_telefono_jefe_inmediato" name="txt_telefono_jefe_inmediato"  value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['telefono'];
                    }
                    else
                    {
                                            echo "";

                    }
                    ?>" data-inputmask='"mask": " 9999-9999"' data-mask>
                </div>
                 </div>



                 <div class="col-sm-6">
                 <div class="form-group">
                  <label>Correo Electrónico</label>
                    <input class="form-control" type="email" id="txt_correo_jefe_inmediato" name="txt_correo_jefe_inmediato" value="<?php
                    if(isset($_SESSION['Modificar_empresa']) and $_SESSION['Modificar_empresa']=="SI")
                    {
                      echo $_SESSION['correo'];
                    }
                    else
                    {
                                            echo "";

                    }
                    ?>" required onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" >
                </div>
               </div>
                                          
            </div>
                <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_empresa_practica" name="btn_guardar_empresa_practica">  <?php echo $_SESSION['btn_guardar_empresa_practica']; ?><i class="zmdi zmdi-floppy"></i>Guardar</button>
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

</body>
</html>

