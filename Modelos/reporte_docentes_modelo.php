<?php

require_once ('../clases/conexion_mantenimientos.php');


$instancia_conexion = new conexion();
class modelo_reporte
{
    
    function listar($id_persona){
    
        global $instancia_conexion;
        $sql = "call sel_reporte_docente('$id_persona')";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }
    function listar2()
    {
        
        global $instancia_conexion;
        $sql = "call sel_comisiones_reporte()";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
     function mostrar()
    {
        global $instancia_conexion;
        $sql = 'SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona 
    WHERE us.Id_usuario= 8;';
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }
     function listar_actividades($id)
    {
        global $instancia_conexion;
        $sql = "call sel_comisiones_reporte('$id');";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }
    function modificar_horas($horas_semanales,$id_actividad)
    {
        global $instancia_conexion;
        $sql = "call proc_modificar_horas('$horas_semanales','$id_actividad')";
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
    }
    //listar select comisiones
    function listar_comisiones()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_comisiones, comision FROM tbl_comisiones ORDER BY comision ASC');

        return $consulta;
    }
    //listar select comisiones
    function listar_actividad()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_actividad, actividad FROM tbl_actividades ORDER BY actividad ASC');

        return $consulta;
    }





    //MANTENIMIENTOS
    public function registrar($jornada, $descripcion)
    {
        global $instancia_conexion;
        $sql = "CALL proc_insertar_jornada('$jornada', '$descripcion')";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    public function registrarcomision($comision, $carrera)
    {
        global $instancia_conexion;
        $sql = "CALL proc_insertar_tabla_comisiones('$comision', '$carrera')";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    public function registrarcategorias($categoria, $descripcion)
    {
        global $instancia_conexion;
        $sql = "CALL proc_insertar_tabla_categoria('$categoria', '$descripcion')";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    public function registrargrado($grado_academico, $descripcion)
    {
        global $instancia_conexion;
        $sql = "CALL proc_insertar_tabla_grados('$grado_academico', '$descripcion')";
        return $instancia_conexion->ejecutarConsulta($sql);
    }

}



?>