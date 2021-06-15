<?php

header("Content-Type:application/json");

require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/Conexion.php');

        $result = [];
//Verificacion de control de asistencia


if (isset($_GET["control"])) {



if ($R = $mysqli->query("select concat(p.nombres,'',p.apellidos)AS nombre, px.valor as valor, p.id_persona, cp.Id_charla from tbl_personas p, tbl_charla_practica cp , tbl_personas_extendidas px where px.id_atributo=12 and px.id_persona=p.id_persona and cp.id_persona=p.id_persona and jornada='$_GET[control]'")) {
            $items = [];

            while ($row = $R->fetch_assoc()) {

                array_push($items, $row);
            }
            $R->close();
            $result["ROWS"] = $items;
        }
        echo json_encode($result);
        
}
///Actualizacion
elseif (isset($_GET["asistencia"])) 
{
	$asistencia=$_POST["asistencia"];
	$fecharecibida=$_POST["txt_fecha_impartida"];
	$jornada=$_GET["asistencia"];
	$estado="";
	if (isset($fecharecibida) and isset($jornada) )
	 {

		if (empty($fecharecibida))
		 {

     //header("location:../vistas/gestion_asistencia_charla_vista.php?msj=1"); 
	 echo "<script> window.location.replace('https://www.informaticaunah.com/automatizacion/vistas/gestion_asistencia_charla_vista.php?msj=1'); </script>";
	
	/*echo '<script> alert("  '.$identificador.'  ")</script>';*/

	}	
			

		
	else
	{
		if (empty($asistencia))
		{
		  //header("location:../vistas/gestion_asistencia_charla_vista.php?msj=4"); 
		  echo "<script> window.location.replace('https://www.informaticaunah.com/automatizacion/vistas/gestion_asistencia_charla_vista.php?msj=4'); </script>";

		}
			foreach ($asistencia as $key => $idcharla) 
					{

 	if ($asistencia>=1) {
			$estado=1;
			 	}
			else
			{
				$estado=0;

			} 

										
			$sql = "call proc_actualizar_asistencia_charla($idcharla,'$jornada' ,'$estado','$fecharecibida')" ;

			$resultado = $mysqli->query($sql);

			if($resultado === TRUE)
			 {
		 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ACTUALIZO' , 'LA ASISTENCIA CHARLA.');
     		 
		 header("location: https://www.informaticaunah.com/automatizacion/vistas/gestion_asistencia_charla_vista.php?msj=2"); 
		 //echo "<script> window.location = 'https://www.informaticaunah.com/automatizacion/vistas/gestion_asistencia_charla_vista.php?msj=2';</script>";
		 //echo '<script> window.location.replace("https://www.informaticaunah.com/automatizacion/vistas/gestion_documentos_practica_vista.php?msj=2"); </script>';
		   //header("Location: https://www.informaticaunah.com/automatizacion/vistas/gestion_asistencia_charla_vista.php?msj=2");
	
			}	
			else
			{
				     //header("location:../vistas/gestion_asistencia_charla_vista.php?msj=3"); 
					 header("Location: https://www.informaticaunah.com/automatizacion/vistas/gestion_asistencia_charla_vista.php?msj=3", TRUE, 301);
					 //window.location.replace('https://www.informaticaunah.com/automatizacion/vistas/gestion_asistencia_charla_vista.php?msj=3'); 

			}

						}	
	}


		}
}
else
{
	if ($R = $mysqli->query("select concat(p.nombres,'',p.apellidos)AS nombre, px.valor as valor, p.id_persona, cp.Id_charla  from tbl_personas p, tbl_charla_practica cp , tbl_personas_extendidas px where px.id_atributo=12 and px.id_persona=p.id_persona and cp.id_persona=p.id_persona and jornada='0' ")) {
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