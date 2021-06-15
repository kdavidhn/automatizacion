<?php
session_start();
require_once('../clases/conexion_mantenimientos.php');

//require_once "../clases/Conexion.php";

$instancia_conexion = new conexion();



class modelo_perfil_docentes
{
    public function mostrar($id_persona)
	{
        global $instancia_conexion;
		$sql="SELECT PER.nombres  nombre, PER.apellidos, PER.identidad, PER.nacionalidad, CON.valor,TCON.descripcion, CAT.categoria,
        PER.fecha_nacimiento, PER.sexo,  PER.estado_civil,PEX.valor AS foto,JOR.jornada, PER.id_persona

FROM tbl_personas AS PER 
   JOIN tbl_contactos AS CON ON CON.id_persona=PER.id_persona
   JOIN tbl_tipo_contactos AS TCON ON TCON.id_tipo_contacto=CON.id_tipo_contacto
   JOIN tbl_categoria_personas AS CATP ON CATP.id_persona=PER.id_persona
   JOIN tbl_categorias AS CAT ON CAT.id_categoria=CATP.id_categoria
   JOIN tbl_personas_extendidas AS PEX ON PEX.id_persona=PER.id_persona
   JOIN tbl_horario_docentes AS HD ON HD.id_persona=PER.id_persona
   JOIN tbl_jornadas AS JOR ON JOR.id_jornada= HD.id_jornada
WHERE PER.id_persona= $id_persona AND PEX.id_atributo = 11;
";
        $result= $instancia_conexion->ejecutarConsulta($sql);

        $userData = array();

		while($row=$result->fetch_assoc()){
		  
			  $userData['all'][] = $row;
		 
		}

		//echo '<pre>';print_r($userData);echo'</pre>';
		return $userData;

        
    }
    
    public function mostrarSelect($id_empleado)
	{
        global $instancia_conexion;
		$sql="select especialidad from tbl_especialidad_grado where id_grado_academico='$id_empleado'";
        //return $instancia_conexion->ejecutarConsultaEspecialidad($sql);
        $sql2 = $instancia_conexion->ejecutarConsulta($sql);
        $userData = array();

		while($row=$sql2->fetch_assoc()){
		  
			  $userData['all'][] = $row;
		 
		}

		//echo '<pre>';print_r($userData);echo'</pre>';
		return $userData;
    }
    
    function listar_select1(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_grados_academicos');
		echo '<pre>';print_r($consulta);echo'</pre>';
        return $consulta;

    }

    function TipoContacto(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('SELECT * FROM tbl_tipo_contactos');
		echo '<pre>';print_r($consulta);echo'</pre>';
        return $consulta;
    }

    function Actualizar($nombre, $apellido, $identidad, $id_persona, $nacionalidad, $estado_civil, $genero){
        global $instancia_conexion;
        $consult=$instancia_conexion->ejecutarConsulta("UPDATE tbl_personas AS ps, tbl_contactos AS cs SET ps.nombres='$nombre' ,ps.apellidos='$apellido', ps.identidad= '$identidad', ps.nacionalidad= '$nacionalidad', ps.estado_civil = '$estado_civil', ps.sexo = '$genero' WHERE ps.id_persona= $id_persona;");
        echo '<pre>';print_r($consult);echo'</pre>';
        return $consult;
    }

    public function Registrar_curriculum($curriculum, $id_persona){
        global $instancia_conexion;
        $sql="UPDATE tbl_personas_extendidas SET valor = '$curriculum' WHERE id_persona = $id_persona AND id_atributo = 8;";
        
        return $instancia_conexion->ejecutarConsulta($sql);

    }

    function AgregarEspecialidad($grado,$especialidad, $id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta("CALL proc_agregar_especialidad('$grado', '$especialidad', '$id_persona')");
      
        return $consulta;
    }

    function AgregarTelefono($telefono, $id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta("INSERT INTO tbl_contactos
         (id_persona,id_tipo_contacto,valor)VALUES($id_persona,'1','$telefono')");
      
        return $consulta;
    }

    function AgregarCorreo($id_persona, $correo){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta("INSERT INTO tbl_contactos
         (id_persona,id_tipo_contacto,valor)VALUES($id_persona,'4','$correo')");
      
        return $consulta;
    }

    function Curriculum($id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT PEX.valor AS curriculum

        FROM tbl_personas AS PER 
         
           JOIN tbl_personas_extendidas AS PEX ON PEX.id_persona=PER.id_persona
        WHERE PER.id_persona = $id_persona AND PEX.id_atributo=8 LIMIT 1");
      
        return $consulta;
    }
    
    function Num_Empleado($id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT PEX.valor

        FROM tbl_personas AS PER 
         
           JOIN tbl_personas_extendidas AS PEX ON PEX.id_persona=PER.id_persona
        WHERE PER.id_persona = $id_persona AND PEX.id_atributo=1 LIMIT 1;");
      
        return $consulta;
    }

    function ver_estado_c($id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT estado_civil

        FROM tbl_personas
        WHERE id_persona = $id_persona LIMIT 1;");
      
        return $consulta;
    }

    function ExisteIdentidad($identidad){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT EXISTS( 
        SELECT identidad FROM tbl_personas WHERE identidad='$identidad' AND 
        id_persona<>53) as existe");
      
        return $consulta;
    }
    function EliminarTelefono($eliminar_tel){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta("DELETE from tbl_contactos WHERE valor ='$eliminar_tel';");
      
        return $consulta;
    }

    function EliminarCorreo($eliminar_correo)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("DELETE from tbl_contactos WHERE valor ='$eliminar_correo';");

        return $consulta;
    }
    
    function CambiarFoto($valor, $id_persona){
        

        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta("UPDATE tbl_personas_extendidas SET valor = '$valor' WHERE id_persona = $id_persona AND id_atributo = 11;");
      
        return $consulta;
    }

    function MostrarEspecialidad($id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta("SELECT EG.ESPECIALIDAD FROM tbl_especialidad_grado EG
            JOIN tbl_grados_academicos_personas GAP ON GAP.id_especialidad = EG.id_especialidad
            WHERE GAP.ID_PERSONA = $id_persona
        ");
        $especialidades = array();

		while($row=$consulta->fetch_assoc()){
		  
			  $especialidades['all'][] = $row;
		 
		}

		//echo '<pre>';print_r($especialidades);echo'</pre>';
		return $especialidades;
    }
    function Actividades($id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta("SELECT COM.comision, ACT.actividad  FROM tbl_actividades ACT
                JOIN tbl_actividades_persona ACTP ON ACT.id_actividad= ACTP.id_actividad
                JOIN tbl_comisiones COM ON COM.id_comisiones = ACT.id_comisiones
                WHERE ACTP.id_persona = $id_persona
        ");
        $actividades = array();

		while($row=$consulta->fetch_assoc()){
		  
			  $actividades['actividades'][] = $row;
		 
		}

		//echo '<pre>';print_r($actividades);echo'</pre>';
		return $actividades;
    }

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


    function listar_estado_civil()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_estado_civil, estado_civil FROM tbl_estadocivil');

        return $consulta;
    }

    public function mostrar_estado_civil($id_estado_civil)
    {
        global $instancia_conexion;
        $sql2 = "call sel_id_estado_civil_ca($id_estado_civil)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql2);
    }


    function listar_genero()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT * FROM tbl_genero');

        return $consulta;
    }

    public function mostrar_genero($id_estado_civil)
    {
        global $instancia_conexion;
        $sql2 = "call sel_id_genero_ca($id_estado_civil)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql2);
    }

    function ver_genero($id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT sexo

        FROM tbl_personas
        WHERE id_persona = $id_persona LIMIT 1;");
      
        return $consulta;
    }

    function ver_sued($id_persona){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT valor FROM tbl_personas_extendidas where id_persona = $id_persona and id_atributo = 14 LIMIT 1;");
      
        return $consulta;
    }

    function Existepregunta1($id_persona)
    {
        global $instancia_conexion;

        $sql = "call proc_count_preg1('$id_persona')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

    function EliminarPregunta1($id_persona)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("DELETE FROM tbl_pref_area_docen WHERE id_persona = '$id_persona';");

        return $consulta;
    }
    function Existepregunta2($id_persona)
    {
        global $instancia_conexion;

        $sql = "call proc_count_preg2('$id_persona')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

    function EliminarPregunta2($id_persona)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("DELETE FROM tbl_expe_academica_docente WHERE id_persona = '$id_persona';");

        return $consulta;
    }
    function Existepregunta3($id_persona)
    {
        global $instancia_conexion;

        $sql = "call proc_count_preg3('$id_persona')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

    function EliminarPregunta3($id_persona)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("DELETE FROM tbl_pref_asig_docen WHERE id_persona = '$id_persona';");

        return $consulta;
    }
    function Existepregunta4($id_persona)
    {
        global $instancia_conexion;

        $sql = "call proc_count_preg4('$id_persona')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

    function EliminarPregunta4($id_persona)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("DELETE FROM tbl_desea_asig_doce WHERE id_persona = '$id_persona';");

        return $consulta;
    }

    function especialidad($id_persona)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("SELECT GRP.id_grado_aca_personas, GRA.grado_academico, ESG.especialidad  
        FROM tbl_especialidad_grado ESG JOIN tbl_grados_academicos_personas GRP ON GRP.id_especialidad=ESG.id_especialidad JOIN tbl_grados_academicos GRA ON GRA.id_grado_academico=ESG.id_grado_academico WHERE GRP.id_persona = $id_persona
        ");

        $especialidad = array();


        while ($row = $consulta->fetch_assoc()) {

            $especialidad['especialidad'][] = $row;
        }

        //echo '<pre>';print_r($actividades);echo'</pre>';
        return $especialidad;
    }
    function eliminar_formacion($eliminar_formacion,$id_persona)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta("DELETE from tbl_grados_academicos_personas WHERE id_grado_aca_personas ='$eliminar_formacion' AND id_persona='$id_persona';");

        return $consulta;
    }
}
