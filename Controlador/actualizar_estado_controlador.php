<?php
require_once "../Modelos/gestion_docente_modelo.php";

$instancia_modelo = new modelo_gestion_docente();
$id_persona = htmlspecialchars($_POST['id_persona'],ENT_QUOTES,'UTF-8');
$Estado = htmlspecialchars($_POST['Estado'],ENT_QUOTES,'UTF-8');
    $consulta = $instancia_modelo-> actualizarestado($Estado, $id_persona);
    echo $consulta;
