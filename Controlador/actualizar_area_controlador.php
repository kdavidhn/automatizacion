<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto = 93 ;


    $area = strtoupper ($_POST['area']);
    $id_area = $_GET['id_area'];

 
///Logica para el que se repite
$sqlexiste = ("select area from tbl_areas where area = '$area'");


 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


/* Logica para que no acepte campos vacios */
if ($_POST['area'] <> '')
{
   
  /* Condicion para que no se repita el rol*/
            if ($existe <> '') {
                header("location:../vistas/mantenimiento_area_vista.php?msj=1");

             }else{
                $sql = "call proc_actualizar_area('$area','$id_area')";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'EL AREA  '. $area.'');

                header("location:../vistas/mantenimiento_area_vista.php?msj=2");
           
			} 
			else 
			{
                header("location:../vistas/mantenimiento_area_vista.php?msj=3");
			}



             }
        

    


} 

else
{
  echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"Lo sentimos tiene campos por rellenar",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                </script>';
}


