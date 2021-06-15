<?php

header("Content-Type:application/json");
session_start();

require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/Conexion.php');

        $result = [];


      if (isset($_GET['estudianteaprobadas'])) 
      {

    $nombreestuadiante=$_GET['estudianteaprobadas'];
  if (isset($_POST['asignatura'])) {
      $array_id= $_POST['asignatura'];
  }
  
  if (empty($nombreestuadiante) or empty($array_id)) {
        $array_id="[1,1]";
                                
        header("location:../vistas/gestion_asignaturas_aprobadas_vista.php?msj=1"); 

  } 


else
{

    

      
     

    $Id_objeto=16 ; 
     
 $sqlid=("select p.id_persona as 'usuario'  from tbl_personas p, tbl_personas_extendidas px where p.id_persona=px.id_persona and  px.valor='$nombreestuadiante'");
 //Obtener la fila del query
$iduser = mysqli_fetch_assoc($mysqli->query($sqlid));
$idproc=$iduser['usuario'];

    foreach ($array_id as $idasignatura) 
    {

       
$sqlexiste=("select count(Id_asignatura) as asignatura  from tbl_asignaturas_aprobadas where  Id_asignatura='$idasignatura' and id_persona=(select p.id_persona from tbl_personas p, tbl_personas_extendidas px where p.id_persona=px.id_persona and  px.valor='$nombreestuadiante')");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
  if ($existe['asignatura']>=1)
    {
   /*   require"../contenidos/crearRol-view.php";
  header('location: ../contenidos/crearRol-view.php?msj=1'); */
          header("location:../vistas/gestion_asignaturas_aprobadas_vista.php?msj=2"); 

    }
    else
{
    $sql = "call proc_insertar_asignaturas_aprobadas($idasignatura,$idproc)";
        $resultado = $mysqli->query($sql);
    $sqlproc = "select asignatura as tema from tbl_asignaturas where Id_asignatura =$idasignatura";
          $resultadoproc = mysqli_fetch_assoc($mysqli->query($sqlproc));
         bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LA  ASIGNATURA '.$resultadoproc['tema'].'');
}


                  };





          if($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE '.$nombreestuadiante.'');

        /*header('location: ../contenidos/crearPregunta-view.php?msj=1');*/
                header("location:../vistas/gestion_asignaturas_aprobadas_vista.php?msj=3"); 

     
      
                          } 
      else 
      {

                header("location:../vistas/gestion_asignaturas_aprobadas_vista.php?msj=4"); 

                                  }

   




}

      }
      else
      {



  if ($R = $mysqli->query("select p.id_persona,concat(p.nombres,' ',p.apellidos) as 'nombre', px.valor as 'valor', count(ca.Id_asignatura) as 'clases' from tbl_personas p ,tbl_asignaturas_aprobadas ca ,tbl_personas_extendidas px
 where px.id_atributo=12 and px.id_persona=p.id_persona and ca.id_persona=p.id_persona 
  GROUP BY p.id_persona ,px.valor")) {



            $items = [];

            while ($row = $R->fetch_assoc()) {

                array_push($items, $row);
            }
            $R->close();
            $result["ROWS"] = $items;
        }
        echo json_encode($result);
          }


     
?>