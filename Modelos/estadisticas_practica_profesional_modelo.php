<?php
//Incluímos inicialmente la conexión a la base de datos
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class Estadisticas
{

        //Implementamos nuestro constructor
        public function _construct()
        {


        }
     
        //implementamos un metodo para listar los registros
        public function listar()
        {       
                global $instancia_conexion;
                $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

                FROM tbl_empresas_practica AS ep
                JOIN tbl_personas AS a
                ON ep.id_persona = a.id_persona
                JOIN tbl_practica_estudiantes AS pe
                ON pe.id_persona = a.id_persona
                JOIN tbl_contactos c ON a.id_persona = c.id_persona
                JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
                JOIN tbl_contactos e ON a.id_persona = e.id_persona
                JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
                join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
                WHERE NOT (pe.docente_supervisor <=> '')";
                return $instancia_conexion->ejecutarConsulta($sql);
        }
        public function listar_fechas($fecha_inicio,$fecha_fin)
        {
                global $instancia_conexion;
                $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

                FROM tbl_empresas_practica AS ep
                JOIN tbl_personas AS a
                ON ep.id_persona = a.id_persona
                JOIN tbl_practica_estudiantes AS pe
                ON pe.id_persona = a.id_persona
                JOIN tbl_contactos c ON a.id_persona = c.id_persona
                JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
                JOIN tbl_contactos e ON a.id_persona = e.id_persona
                JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
                join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
                WHERE NOT (pe.docente_supervisor <=> '')  AND ep.Fecha_creacion BETWEEN '$fecha_inicio' AND '$fecha_fin'";
                return $instancia_conexion->ejecutarConsulta($sql);
        }
        public function listar_fechas_docente($fecha_inicio,$fecha_fin,$docente)
        {
                global $instancia_conexion;
                $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

                FROM tbl_empresas_practica AS ep
                JOIN tbl_personas AS a
                ON ep.id_persona = a.id_persona
                JOIN tbl_practica_estudiantes AS pe
                ON pe.id_persona = a.id_persona
                JOIN tbl_contactos c ON a.id_persona = c.id_persona
                JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
                JOIN tbl_contactos e ON a.id_persona = e.id_persona
                JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
                join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
                WHERE NOT (pe.docente_supervisor <=> '')  AND ep.Fecha_creacion BETWEEN '$fecha_inicio' AND '$fecha_fin' and pe.docente_supervisor='$docente' ";
                return $instancia_conexion->ejecutarConsulta($sql);
        }
        public function listar_empresa($empresa)
        {
                global $instancia_conexion;
                $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

                FROM tbl_empresas_practica AS ep
                JOIN tbl_personas AS a
                ON ep.id_persona = a.id_persona
                JOIN tbl_practica_estudiantes AS pe
                ON pe.id_persona = a.id_persona
                JOIN tbl_contactos c ON a.id_persona = c.id_persona
                JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
                JOIN tbl_contactos e ON a.id_persona = e.id_persona
                JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
                join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
                WHERE NOT (pe.docente_supervisor <=> '')  AND ep.nombre_empresa='$empresa'";
                return $instancia_conexion->ejecutarConsulta($sql);
        }
        public function listar_docente($docente)
        {
                global $instancia_conexion;
                $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

                FROM tbl_empresas_practica AS ep
                JOIN tbl_personas AS a
                ON ep.id_persona = a.id_persona
                JOIN tbl_practica_estudiantes AS pe
                ON pe.id_persona = a.id_persona
                JOIN tbl_contactos c ON a.id_persona = c.id_persona
                JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
                JOIN tbl_contactos e ON a.id_persona = e.id_persona
                JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
                join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
                WHERE NOT (pe.docente_supervisor <=> '') and pe.docente_supervisor='$docente'";
                return $instancia_conexion->ejecutarConsulta($sql);
        }
        public function listar_fechas_docente_empresa($fecha_inicio,$fecha_fin,$empresa,$docente)
        {
                global $instancia_conexion;
                $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

                FROM tbl_empresas_practica AS ep
                JOIN tbl_personas AS a
                ON ep.id_persona = a.id_persona
                JOIN tbl_practica_estudiantes AS pe
                ON pe.id_persona = a.id_persona
                JOIN tbl_contactos c ON a.id_persona = c.id_persona
                JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
                JOIN tbl_contactos e ON a.id_persona = e.id_persona
                JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
                join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
                WHERE NOT (pe.docente_supervisor <=> '')  AND pe.docente_supervisor='$docente' AND ep.nombre_empresa='$empresa' AND ep.Fecha_creacion BETWEEN '$fecha_inicio' AND '$fecha_fin'";
                return $instancia_conexion->ejecutarConsulta($sql);
        }
        
        
        


}

?>
