<?php 
session_start();
require_once ('../clases/Conexion.php');
require_once ('../vistas/pagina_inicio_vista.php');


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
            <h1>Registro de Estudiantes a realizar PPS</h1>
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
      
<form action="../Controlador/" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

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
                  <label>Nombre Completo</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_estudiante" name="txt_nombre_estudiante"  value="" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                </div>
                 </div>


                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nº de Cuenta</label>
                    <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta"  value="" required  onkeyup="Espacio(this, event)"  maxlength="11">
                </div>
                 </div>


                   <div class="col-sm-4">
                    <div class="form-group">
                  <label>Nombre de la Empresa</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_nombre_empresa" name="txt_nombre_empresa"  value="" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                </div>
                 </div>



                 <div class="col-sm-4">
                  <div class="form-group">
                  <label>Direccion de la Empresa</label>
                    <input class="form-control" type="text"  maxlength="60" id="txt_direccion_empresa" name="txt_direccion_empresa"  value="" required style="text-transform: uppercase"   onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                </div>
                 </div>


                     <div class="col-sm-4">
          <div class="form-group">
                  <label>Labora en la Empresa</label>
                    <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta"  value="" required  onkeyup="Espacio(this, event)"  maxlength="11">
                </div>
                 </div>


                              <div class="col-sm-4">
                <div class="form-group">
                  <label>Fecha de Inicio</label>
                    <input class="form-control" type="date" id="txt_fecha_inicio" name="txt_fecha_inicio"  >
                </div>
              </div>

                <div class="col-sm-4">
                 <div class="form-group">
                  <label>Fecha de Finalizacion</label>
                    <input class="form-control" type="date" id="txt_fecha_final" name="txt_fecha_final"  >
                </div>
              </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                  <label>Docente Supervisor</label>
                  <select class="form-control select2" style="width: 100%;" name="combo_docente" required="">
          <option value="0"  >Seleccione un Docente:</option>
        <?php
          $query = $mysqli -> query ("SELECT * FROM tbl_docentes ");
          while ($resultado = mysqli_fetch_array($query)) {
            echo '<option value="'.$resultado['Id_docente'].'"> '.$resultado['nombre_docente'].'</option>' ;
          }
        ?>
                </select>
                </div>
                 </div>


             


                 <div class="col-sm-6">
                <div class="form-group">
                  <label>Horas de Practica</label>
                    <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta"  value="" required  onkeyup="Espacio(this, event)"  maxlength="11">
                </div>
                 </div>



                               <div class="col-sm-6">
                <div class="form-group">
                  <label>Fecha de 1ª visita</label>
                    <input class="form-control" type="date" id="txt_fecha_primer_visita" name="txt_fecha_primer_visita"  >
                </div>
              </div>

                <div class="col-sm-6">
                 <div class="form-group">
                  <label>Fecha de 2ª visita</label>
                    <input class="form-control" type="date" id="txt_fecha_segunda_visita" name="txt_fecha_segunda_visita"  >
                </div>
              </div>

              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_estudiante_practica" name="btn_guardar_estudiante_practica">  <?php echo $_SESSION['btn_guardar_estudiante_practica']; ?><i class="zmdi zmdi-floppy"></i>Guardar</button>
              </p>

              
            </div>
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


