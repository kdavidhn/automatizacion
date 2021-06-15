<?php
    require ('../Modelos/tabla_carga_modelo.php');

    $MU = new modeloCarga();

    $id_persona = $_POST['id_persona'];

    $consulta = $MU->respuesta1($id_persona);
    
    // print_r ($consulta);
