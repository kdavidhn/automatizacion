<?php
    require '../Modelos/tabla_carga_modelo.php';

    $MU = new modeloCarga();

    $id_periodo_antiguo = $_POST['id_periodo'];
$id_periodo_nuevo = $_POST['id_periodo_nuevo_'];


    $consulta = $MU->insertar_copia_carga($id_periodo_nuevo, $id_periodo_antiguo);

    echo $consulta;
    
