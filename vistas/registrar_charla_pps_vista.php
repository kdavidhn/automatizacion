<?php 
ob_start();
session_start();
require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

//Objeto de egresado
        $Id_objeto=13 ; 
        //txt_constancia_charla


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
  
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A INSCRIPCION CHARLA.');


if (permisos::permiso_insertar($Id_objeto)=='1')
 {
  $_SESSION['btn_guardar_inscripcion_charla']="";
}
else
{
    $_SESSION['btn_guardar_inscripcion_charla']="disabled";
 }
 
 $usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];


  $sql=("select concat(p.nombres,' ', p.apellidos) as nombre ,px.valor from tbl_personas_extendidas px, tbl_personas p where  p.id_persona='$id_persona' and px.id_atributo=12 and px.id_persona=p.id_persona ");
 //Obtener la fila del query
$resultado = mysqli_fetch_assoc($mysqli->query($sql));

$nombre=$resultado['nombre'];
$cuenta=$resultado['valor'];



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
            <h1>Inscripción  para Charla de PPS</h1>
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
        
      
<form action="../Controlador/guardar_charla_pps_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">
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
                  <label>Jornada </label>
                  <select class="form-control" name="cb_jornada" id="cb_jornada" onchange="Constancia();"> 
                  <option value="0">Seleccione una opción :</option>
                   <option value="MATUTINA">MATUTINA</option>
                    <option value="VESPERTINA">VESPERTINA</option>
                </select>
                </div>
                 </div>


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nº Constancia</label>
                    <input class="form-control" type="text" id="txt_constancia_charla" name="txt_constancia_charla"  value="" required  onkeyup="Espacio(this, event)"  maxlength="11" readonly>
                </div>
                 </div>

               <div class="col-sm-6">
                <div class="form-group">
                  <label>Nombre Completo</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_estudiante" name="txt_nombre_estudiante"  value="<?php echo $nombre;?>" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" readonly >
                </div>
                 </div>


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nº de Cuenta</label>
                    <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta"  value="<?php echo $cuenta;?>" required  onkeyup="Espacio(this, event)"  maxlength="11" readonly>
                </div>
                 </div>


   <div class="col-sm-6">
                  <div class="form-group">
                  <label>Clases Aprobadas</label>
                    <input class="form-control" type="text" id="txt_clases_aprobadas" name="txt_clases_aprobadas"  value="" required  onkeyup="Espacio(this, event)" onkeypress="return Numeros(event)"  maxlength="2">
                </div>
                 </div>

  <div class="col-sm-6">
                  <div class="form-group">
                  <label>Promedio</label>
                    <input class="form-control" type="text" id="txt_promedio" name="txt_promedio"  value="" required  onkeyup="Espacio(this, event)"  onkeypress="return Numeros(event)" maxlength="3">
                </div>
                 </div>




                 </div>

              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_inscripcion_charla"  <?php echo $_SESSION['btn_guardar_inscripcion_charla']; ?>  ><i class="zmdi zmdi-floppy"></i> Guardar</button>
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


function Constancia()
{
/* Para obtener el valor */

var certicados = document.getElementById("cb_jornada").value;



  if (certicados == "MATUTINA") {
//
           document.getElementById("txt_constancia_charla").value = "<?php require_once ('../clases/Conexion.php');
           $sql = "select CONCAT(date_format(sysdate(), '%Y'), date_format(sysdate(), '%m'),CASE
    WHEN contador < 10 THEN concat('00',contador+1)
    WHEN contador >= 10 AND contador < 100 THEN concat('0',contador+1)
    ELSE
    contador +1

END) as contador from tbl_contador_constancia where id_contador =1 ";
        $resultado =mysqli_fetch_assoc($mysqli->query($sql)); 


 echo $resultado['contador'] ?>";


    }
    if (certicados == "VESPERTINA"){


         document.getElementById("txt_constancia_charla").value = "<?php require_once ('../clases/Conexion.php');
           $sql = "select CONCAT(date_format(sysdate(), '%Y'), date_format(sysdate(), '%m'),CASE
    WHEN contador < 10 THEN concat('00',contador+1)
    WHEN contador >= 10 AND contador < 100 THEN concat('0',contador+1)
    ELSE
    contador +1

END) as contador from tbl_contador_constancia where id_contador =2 ";
        $resultado =mysqli_fetch_assoc($mysqli->query($sql)); 
 echo $resultado['contador'] ?>";


    }


}
  </script>
</body>
</html>

