<?php
require_once('../clases/conexion_mantenimientos.php');
$instancia_conexion = new conexion();
$id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";
$imagen = "";

if (isset($_FILES["imagen"])) {
    $file = $_FILES["imagen"];
    $nombre = $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    $carpeta = "../Imagenes_Perfil_Docente/";
    $src = $carpeta.$nombre;
    move_uploaded_file($ruta_provisional,$src);
    $imagen = "../Imagenes_Perfil_Docente/".$nombre;
    echo json_encode($imagen);

    global $instancia_conexion;
    $consulta=$instancia_conexion->ejecutarConsulta("UPDATE tbl_personas_extendidas SET valor = '$imagen' WHERE id_persona = 10 AND id_atributo = 11;");
  
    return $consulta;
}




?>
