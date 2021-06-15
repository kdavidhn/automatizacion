<?php
require_once "../clases/conexion_mantenimientos.php";
require_once "../clases/Conexion.php";
//require_once "../clases/Conexion.php";
$instancia_conexion = new conexion();



class modelo_mantenimientos
{

    function listar_persona(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_tipos_persona');

        return $consulta;

    }
    

    function listar_comision(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_comisiones');

        return $consulta;

    }

    function listar_edificio(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_edificios');

        return $consulta;

    }


    function listar_aula(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_tipo_aula');

        return $consulta;

    }


  function listar_carrera(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_carrera');

        return $consulta;

    }

    function listar_departamento(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_departamentos');

        return $consulta;

    }

    function listar_facultad(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_facultades');

        return $consulta;

    }



}

