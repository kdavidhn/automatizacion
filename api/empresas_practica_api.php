<?php


header("Content-Type:application/json");

require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/Conexion.php');

//Verificacion del modal
        $result = [];
if (isset($_GET["id_persona"])) {

if ($R = $mysqli->query("select * from tbl_empresas_practica where id_persona='$_GET[id_persona]'")) {
            $items = [];

            while ($row = $R->fetch_assoc()) {

                array_push($items, $row);
            }
            $R->close();
            $result["ROWS"] = $items;
        }
        echo json_encode($result);
}

//*********************************Actualizar Gestion
else
{
if (isset($_GET["id_empresaa"]))
     {
session_start();

$id_empresa_modificacion=$_GET["id_empresaa"];
$_SESSION['Institucion']=strtoupper ($_POST['txt_nombre_empresa_practica']);
 $_SESSION['Direccion']=strtoupper ($_POST['txt_direccion_empresa_practica']);
$_SESSION['Departamento']=strtoupper ($_POST['txt_departamento_practica']);
 $_SESSION['jefe_inmediato']=strtoupper ($_POST['txt_nombre_jefe_inmediato']);
$_SESSION['Titulo_jefe']=strtoupper ($_POST['txt_titulo_jefe_inmediato']);
$_SESSION['Cargo']=strtoupper ($_POST['txt_cargo_jefe_inmediato']);
$_SESSION['telefono']=strtoupper ($_POST['txt_telefono_jefe_inmediato']);
$_SESSION['correo']=strtoupper ($_POST['txt_correo_jefe_inmediato']);



if (isset($_SESSION['Institucion']) and isset($_SESSION['Direccion']) and isset($_SESSION['Departamento']) and isset($_SESSION['jefe_inmediato']) and isset($_SESSION['Titulo_jefe'])  and isset($_SESSION['Cargo'])  and isset($_SESSION['telefono'])  and isset($_SESSION['correo']) )

{

      $Id_objeto=18 ; 


    $sql = "call proc_actualizar_empresa_practica('$_SESSION[Institucion]', '$_SESSION[Direccion]' , '$_SESSION[Departamento]' , '$_SESSION[jefe_inmediato]', '$_SESSION[Titulo_jefe]', '$_SESSION[Cargo]', '$_SESSION[correo]', '$_SESSION[telefono]' ,$_SESSION[id_persona],$_SESSION[id_empresa]) ";

  $resultado = $mysqli->query($sql);


                if ($resultado==true)
                 {
                              bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LOS DATOS DE LA EMPRESA '.$nombre_empresa.'');

                         header("location:../vistas/registrar_empresa_practica_vista.php?msj=1"); 


                }
                else
                {
                           header("location:../vistas/registrar_empresa_practica_vista.php?msj=2"); 

                }
}


          else
          {
         header("location:../vistas/registrar_empresa_practica_vista.php?msj=3");

           }


    }

}
?>