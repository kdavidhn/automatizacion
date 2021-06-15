<?php
require_once('../clases/conexion_mantenimientos.php');


$instancia_conexion = new conexion();

class modelo_modal
{


    function listar_select2()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT Id_asignatura, asignatura, codigo, uv FROM tbl_asignaturas ORDER BY asignatura ASC');

        return $consulta;
    }

    public function mostrar($id_persona_valor)
    {
        global $instancia_conexion;
        $sql = "call sel_modal_ca($id_persona_valor)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

    function listar_select1()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("SELECT id_persona, nombres, apellidos FROM tbl_personas WHERE id_tipo_persona =1 and Estado='ACTIVO' ORDER BY nombres ASC");
        return $consulta;
    }

    public function mostrar2($codigo)
    {
        global $instancia_conexion;
        $sql2 = "call sel_id_asignatura_ca($codigo)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql2);
    }

    function listar_select3()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT Id_dia, dia FROM tbl_dias ');

        return $consulta;
    }



    public function mostrar3($dia)
    {
        global $instancia_conexion;
        $sql3 = "call sel_id_dia_ca($dia)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql3);
    }


    function listar_select4()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_edificio, nombre FROM tbl_edificios ');

        return $consulta;
    }

    public function mostrar4($edificio)
    {
        global $instancia_conexion;
        $sql4 = "call sel_id_edificio($edificio)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }


    //MODALIDAD
    function listar_select6()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_modalidad, modalidad FROM tbl_modalidad ');

        return $consulta;
    }

    public function mostrar_modalidad($modalidad)
    {
        global $instancia_conexion;
        $sql4 = "call sel_id_modalidad_ca($modalidad)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    //-----------

    //HORARIO
    function listar_select7()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT hora FROM tbl_hora ');

        return $consulta;
    }

    public function mostrar_hora($hora)
    {
        global $instancia_conexion;
        $sql4 = "call sel_id_hora_ca($hora)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    //-----------

    //TIPO PERIODO
    function listar_select8()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_tipo_periodo, descripcion FROM tbl_tipo_periodo ');

        return $consulta;
    }

    public function tipo_periodo($tipo_periodo)
    {
        global $instancia_conexion;
        $sql4 = "call sel_id_tipo_periodo($tipo_periodo)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    //-----------
    public function capacidad($aula)
    {

        global $instancia_conexion;
        $sql6 = "SELECT capacidad,codigo from tbl_aula where id_aula = $aula";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql6);
    }


    public function mostrar_docente($id_persona_valor)
    {
        global $instancia_conexion;
        $sql = "call sel_modal_ca($id_persona_valor)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

    function listar_docente()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("SELECT id_persona,nombres, apellidos FROM tbl_personas WHERE id_tipo_persona =1  and Estado= 'ACTIVO'");

        return $consulta;
    }

    function listar_aula($id_edificio)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT * FROM tbl_aula WHERE id_edificio = ' . $id_edificio . '');

        return $consulta;
    }

    function listar_modalidad()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_modalidad,modalidad  FROM tbl_modalidad ORDER BY modalidad ASC');

        return $consulta;
    }


    function id_periodo_hist($anno, $periodo)
    {
        global $instancia_conexion;
        $sql5 = "CALL sel_id_periodo_ca('$anno','$periodo')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql5);
    }
    
    function existe_carga_periodo($periodo)
    {
        global $instancia_conexion;

        $sql4 = "call sel_carga_id_periodo_nuevo('$periodo')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    function validarhoradocen($id)
    {
        global $instancia_conexion;

        $sql4 = "call sel_modal_ca('$id')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    function existe_carga_persona($hora_inicial, $aula,$id_periodo, $hora_final)
    {
        global $instancia_conexion;

        $sql4 = "call proc_verificar_carga_modificar('$hora_inicial', '$aula','$id_periodo','$hora_final')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    function existe_carga($hora_inicial,$id_periodo, $hora_final, $aula)
    {
        global $instancia_conexion;

        $sql5 = "call proc_verifica_carga_crear('$hora_inicial','$id_periodo','$hora_final', '$aula')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql5);
    }

    function contar_carga($id_persona)
    {
        global $instancia_conexion;

        $sql = "call proc_count_carga('$id_persona')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

   
    
}
   

