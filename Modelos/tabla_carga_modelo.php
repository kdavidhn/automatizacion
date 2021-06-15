<?php
require_once ('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion();



class modeloCarga
{

    function listar_carga()
    {
        global $instancia_conexion;
        $sql = "call sel_gestion_ca()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }

    // function listar_combo_edificio()
    // {
    //     global $instancia_conexion;
    //     $sql = "SELECT * FROM tbl_edificios";
    //     $arreglo = array();
    //     if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
    //         while ($consulta_VU = mysqli_fetch_array($consulta)) {
    //             $arreglo[] = $consulta_VU;
    //         }
    //         return $arreglo;
    //     }
    // }

    // function listar_combo_aula($id_edificio)
    // {
    //     global $instancia_conexion;
    //     $sql = "SELECT * FROM tbl_aula WHERE id_edificio = $id_edificio";
    //     $arreglo = array();
    //     if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
    //         while ($consulta_VU = mysqli_fetch_array($consulta)) {
    //             $arreglo[] = $consulta_VU;
    //         }
    //         return $arreglo;
    //     }
    // }

    function modificar_carga_academica($control, $seccion, $hra_inicio, $hra_final, $num_alumnos, $id_aula, $id_asignatura, $dias, $id_modalidad, $id_carga_academica)
    {

        global $instancia_conexion;

        $sql = "call proc_actualizar_carga_academica('$control','$seccion','$hra_inicio','$hra_final','$num_alumnos','$id_aula','$id_asignatura','$dias','$id_modalidad','$id_carga_academica')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
    }
    function modificar_carga_academica_virtual($control, $seccion, $hra_inicio, $hra_final, $num_alumnos, $id_asignatura, $dias, $id_modalidad, $id_carga_academica)
    {

        global $instancia_conexion;

        $sql = "call proc_actualizar_carga_academica_virtual('$control','$seccion','$hra_inicio','$hra_final','$num_alumnos','$id_asignatura','$dias','$id_modalidad','$id_carga_academica')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function crear_carga_academica($control, $seccion, $num_alumnos, $id_persona, $id_aula, $id_asignatura, $dias, $id_modalidad, $hora_inicial, $hora_final)
    {

        global $instancia_conexion;

        $sql = "call proc_insert_carga_academica('$control', '$seccion', '$num_alumnos', '$id_persona', '$id_aula', '$id_asignatura', '$dias', '$id_modalidad', '$hora_inicial', '$hora_final')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            $Id_objeto=46;
            return 1;
            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'UNA CARGA ACADEMICA');
        } else {
            return 0;
        }
    }

    function listar_historial_carga()
    {
        global $instancia_conexion;
        $sql = "call sel_periodo_ca()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }


    function listar_carga_historial($ano, $period)
    {
        global $instancia_conexion;
        $sql = "call sel_carga_historial_ca($ano,$period)";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }

    function insertar_copia_carga($id_periodo_nuevo,$periodoantiguo)
    {
        // print_r($id_periodo_antiguo);
        // exit;
        global $instancia_conexion;
        $sql = "call proc_insertar_copia_carga('$id_periodo_nuevo','$periodoantiguo')";
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function eliminar_carga($id_carga)
    {
        global $instancia_conexion;
        $sql = "call proc_eliminar_carga_academica('$id_carga')";
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function respuesta1($id_persona)
    {
        global $instancia_conexion;
        $sql = "call sel_area_pref_doce('$id_persona')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_all($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }
    function listar_periodo_carga()
    {
        global $instancia_conexion;
        $sql = "call proc_sel_tabla_historial()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }

    function crear_carga_virtual($control, $seccion, $num_alumnos, $id_persona, $id_asignatura, $dias, $id_modalidad, $hora_inicial, $hora_final)
    {

        global $instancia_conexion;

        $sql = "call proc_insert_carga_virtual('$control', '$seccion', '$num_alumnos', '$id_persona', '$id_asignatura', '$dias', '$id_modalidad', '$hora_inicial', '$hora_final')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            $Id_objeto=46;
            return 1;
            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'UNA CARGA ACADEMICA');
        } else {
            return 0;
        }
    }

   

}
