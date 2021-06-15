<?php
require_once "../clases/conexion_mantenimientos.php";
//require_once "../clases/Conexion.php";

$instancia_conexion = new conexion();



class modelo_registro_docentes
{

    //Insertar registros
    public function registar($nombre,$apellidos,$sexo,$identidad,$nacionalidad,$estado,$fecha_nacimiento,$hi,$hf,$nempleado, $tipo_docente, $fecha_ingreso,$idcategoria,$idjornada){
        global $instancia_conexion;
        $sql="call proc_insertar_docentes_personas ('$nombre', '$apellidos', '$sexo', '$identidad', '$nacionalidad', '$estado', '$fecha_nacimiento', '1', 'ACTIVO', '$idjornada', '$idcategoria', '$hi', '$hf', '$nempleado', '$fecha_ingreso', '$tipo_docente')";
        

        return $instancia_conexion->ejecutarConsulta($sql);

    }
    public function registar2($nombre,$apellidos,$sexo,$pasaporte,$nacionalidad,$estado,$fecha_nacimiento,$hi,$hf,$nempleado,$tipo_docente,$fecha_ingreso,$idcategoria,$idjornada){
        global $instancia_conexion;
        $sql="call proc_insertar_docentes_personas ('$nombre', '$apellidos', '$sexo', '$pasaporte', '$nacionalidad', '$estado', '$fecha_nacimiento', '1', 'ACTIVO', '$idjornada', '$idcategoria', '$hi', '$hf', '$nempleado', '$fecha_ingreso', '$tipo_docente')";
        

        return $instancia_conexion->ejecutarConsulta($sql);

    }
    
    public function Registrar_atributos($nempleado, $fecha_ingreso, $ruta_pc, $ruta_p){
        global $instancia_conexion;
        $sql="CALL proc_insertar_extendidas('$nempleado', '$fecha_ingreso', '$ruta_pc', '$ruta_p')";
        
        return $instancia_conexion->ejecutarConsulta($sql);

    }

    public function Registrar_foto($nombrearchivo){
        global $instancia_conexion;
        $sql="CALL proc_insertar_foto('$nombrearchivo')";
        
        return $instancia_conexion->ejecutarConsulta($sql);

    }

    public function Registrar_curriculum($nombrearchivo2){
        global $instancia_conexion;
        $sql="CALL proc_insertar_curriculum('$nombrearchivo2')";
        
        return $instancia_conexion->ejecutarConsulta($sql);

    }


    function listar_selectEST(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_estadocivil');

        return $consulta;

    }
    function listar_selectHOR(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_hora');

        return $consulta;

    }
    
    function listar_selectGRA(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_grados_academicos');

        return $consulta;

    }
    function listar_selectCAT(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_categorias');

        return $consulta;

    }
    function listar_selectJOR(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_jornadas');

        return $consulta;

    }


    function listar_selectCOM(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_comisiones');

        return $consulta;

    }

    function ExisteIdentidad($identidad){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT EXISTS( 
        SELECT  identidad FROM tbl_personas WHERE identidad='$identidad') as existe");
      
        return $consulta;
    }
    function Existepasaporte($pasaporte){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT EXISTS( 
        SELECT identidad FROM tbl_personas WHERE identidad='$pasaporte') as existe");
      
        return $consulta;
    }
    
    function listar_selectGEN(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_genero');

        return $consulta;

    }
    
    function listar_selectNAC(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_nacionalidad');

        return $consulta;

    }

     //INGRESADO POR LUIS
     function mayoria_edad()
     {
         global $instancia_conexion;
         $sql = 'SELECT valor FROM tbl_parametros WHERE parametro = "mayoria_edad"';
         return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
     }



    function validardepto($codigo)
    {
        global $instancia_conexion;
        $sql4 = "call proc_existe_municipio_depto($codigo)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    function descripcion_jornada($id_jornada)
    {
        global $instancia_conexion;
        $sql = "call sel_jornada_docente('$id_jornada')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

  
    


}