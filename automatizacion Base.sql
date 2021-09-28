-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2021 a las 02:10:01
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `automatizacion`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `asignar_docente` (IN `_id_supervisor` INT, IN `_id_docente` INT)  BEGIN
START TRANSACTION;
set @nombre_docente =(select nombres from tbl_personas where id_persona=_id_docente);
UPDATE tbl_practica_estudiantes SET docente_supervisor = @nombre_docente WHERE id_persona=_id_supervisor;

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertaryenviar_actividad` (IN `no_solicitud` VARCHAR(255), IN `nombre_actividad` VARCHAR(255), IN `ubicacion` VARCHAR(255), IN `fch_inicial_actividad` DATE, IN `fch_final_actividad` DATE, IN `descripcion` INT(255), IN `poblacion_objetivo` VARCHAR(255), IN `presupuesto` VARCHAR(255), IN `staff_alumnos` VARCHAR(355), IN `observaciones` VARCHAR(355), IN `usuario` INT, IN `id_ambito` INT, IN `periodo` INT)  INSERT INTO tbl_voae_actividades (no_solicitud,fch_solicitud,nombre_actividad,ubicacion,fch_inicial_actividad,fch_final_actividad,descripcion,poblacion_objetivo,presupuesto,staff_alumnos,observaciones,id_estado,id_usuario_registro,id_ambito,periodo)
    VALUES (upper(no_solicitud),now(),upper(nombre_actividad),upper(ubicacion),fch_inicial_actividad,fch_final_actividad,upper(descripcion),upper(poblacion_objetivo),presupuesto,upper(staff_alumnos),upper(observaciones),'2',upper(usuario),id_ambito,upper(periodo))$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_actividad` (IN `no_solicitud` INT(10), IN `nombre_actividad` VARCHAR(255), IN `ubicacion` VARCHAR(255), IN `fch_inicial_actividad` DATE, IN `fch_final_actividad` DATE, IN `descripcion` VARCHAR(255), IN `poblacion_objetivo` VARCHAR(255), IN `presupuesto` INT(50), IN `staff_alumnos` VARCHAR(255), IN `observaciones` VARCHAR(255), IN `id_usuario_registro` INT(10), IN `id_ambito` INT(10), IN `periodo` VARCHAR(50))  INSERT INTO tbl_voae_actividades (no_solicitud,fch_solicitud,nombre_actividad,ubicacion,fch_inicial_actividad,fch_final_actividad,descripcion,poblacion_objetivo,presupuesto,staff_alumnos,observaciones,id_estado,id_usuario_registro,id_ambito,periodo)
		VALUES (upper(no_solicitud),now(),upper(nombre_actividad),upper(ubicacion),fch_inicial_actividad,fch_final_actividad,upper(descripcion),upper(poblacion_objetivo),presupuesto,upper(staff_alumnos),upper(observaciones),'1',upper(id_usuario_registro),id_ambito,upper(periodo))$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inserta_actividad_externa` (IN `nombre_act` VARCHAR(255), IN `ente` VARCHAR(255), IN `usuario` VARCHAR(255), IN `ambito` VARCHAR(255), IN `periodo` VARCHAR(255))  BEGIN

INSERT INTO tbl_voae_actividades (nombre_actividad,staff_alumnos,id_estado,id_usuario_registro,id_ambito,periodo,tipo_actividad)
   VALUES (upper(nombre_act),upper(ente),'6',usuario,ambito,periodo,'ACTIVIDAD EXTERNA');

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inserta_horas_alumno` (IN `id_persona_alumno` INT, IN `id_actividad` INT, IN `horas_alumno` VARCHAR(255))  BEGIN
set @nombre = (select concat(nombres,' ',apellidos) from tbl_personas where id_persona = id_persona_alumno);
set @cuenta = (select valor from tbl_personas_extendidas where id_persona = id_persona_alumno and id_atributo = 12);
set @id = (select id_actividad_voae from tbl_voae_asistencias where id_actividad_voae = id_actividad and cuenta = @cuenta);

IF @id = id_actividad THEN
INSERT INTO tbl_voae_asistencs (nombre_alumno, cuenta, id_actividad_voae, cant_horas, carrera)
VALUES(@nombre,@cuenta,id_actividad,horas_alumno, "Informatica Administrativa");
ELSE
INSERT INTO tbl_voae_asistencias (nombre_alumno, cuenta, id_actividad_voae, cant_horas, carrera)
VALUES(@nombre,@cuenta,id_actividad,horas_alumno, "Informatica Administrativa");
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_aldeas` (IN `nombre_` VARCHAR(80), IN `codigo_` INT, IN `creado_por_` VARCHAR(80), IN `id_municipio_` BIGINT)  BEGIN
INSERT INTO tbl_aldeas_caserios_hn(nombre_aldea_caserio, codigo, fecha_creacion, creado_por, id_municipio) 
VALUES (nombre_, codigo_, SYSDATE(), creado_por_, id_municipio_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_prueba` (IN `dias` VARCHAR(50))  INSERT INTO tbl_carga_dias(dias) VALUES 
('dias')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_estudiantes` (IN `cod_usuario` BIGINT(16), IN `nombres` VARCHAR(255), IN `apellidos` VARCHAR(255), IN `numero_cuenta` BIGINT(16), IN `correo_electronico` VARCHAR(255), IN `identidad` INT(13), IN `telefono` INT(8))  BEGIN
START TRANSACTION;
INSERT INTO `tbl_telefonos`
(
`telefono`
)
VALUES
(
telefono
);
SELECT @cod_telefono := MAX(id_telefono) FROM `tbl_telefonos`;
insert into `tbl_estudiantes`(
`id_telefono`,
`nombres`,
`apellidos`,
`numero_cuenta`,
`correo_electronico`,
`id_usuario`,
`fecha_creacion`,
`identidad`
)
values
(
@cod_telefono,
nombres,
apellidos,
numero_cuenta,
correo_electronico,
cod_usuario,
now(),
identidad
);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_himno` (IN `ncuenta` BIGINT(20), IN `id` BIGINT(10))  BEGIN
START TRANSACTION;
/*###################################*/
SELECT @id_persona := id_persona, @id_horario := hh.id_horario_himno
FROM tbl_personas p, tbl_horario_himno hh
WHERE P.documento = ncuenta
AND hh.id_horario_himno = id;
/*###################################*/
insert into `tbl_alumnos_himno`(
`id_persona`,
`aprobado`,
`Fecha_creacion`,
`id_horario_himno`
)
values
(
@id_persona,
'desaprobado',
now(),
@id_horario
);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_primera_visita` (IN `cuenta` VARCHAR(255), IN `comentario` VARCHAR(255), IN `nombre` VARCHAR(255), IN `lugar` VARCHAR(255), IN `numero` VARCHAR(255), IN `funciones_an` VARCHAR(255), IN `funciones_di` VARCHAR(255), IN `funciones_re` VARCHAR(255), IN `funciones_ca` VARCHAR(255), IN `funciones_se` VARCHAR(255), IN `funciones_au` VARCHAR(255), IN `funciones_ba` VARCHAR(255), IN `funciones_so` VARCHAR(255), IN `funciones_pr` VARCHAR(255), IN `comunicacion` VARCHAR(255), IN `puntualidad` VARCHAR(255), IN `responsabilidad` VARCHAR(255), IN `creatividad` VARCHAR(255), IN `presentacion` VARCHAR(255), IN `atencion` VARCHAR(255), IN `colaborativo` VARCHAR(255), IN `trabajo` VARCHAR(255), IN `proactivo` VARCHAR(255), IN `relacion` VARCHAR(255), IN `analisis` VARCHAR(255), IN `diseno` VARCHAR(255), IN `programador` VARCHAR(255), IN `mantenimiento` VARCHAR(255), IN `aspecto_a` VARCHAR(255), IN `aspecto_s` VARCHAR(255))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona FROM tbl_personas_extendidas
WHERE valor = cuenta;
INSERT INTO `tbl_comentarios_alumnos`
(
`id_persona`,
`comentario_evaluacion`,
`nombre_representante`,
`lugar`,
`fecha`,
`numero_visita`
)
VALUES
(
@id_persona,
comentario,
nombre,
lugar,
now(),
numero
);
INSERT INTO `tbl_funciones_practica`
(
`id_persona`,
`funciones_analisis`,
`funciones_diseno`,
`funciones_redes`,
`funciones_capacitacion`,
`funciones_seguridad`,
`funciones_auditoria`,
`funciones_base`,
`funciones_soporte`,
`funciones_programacion`,
`numero_visita`
)
VALUES
(
@id_persona,
funciones_an,
funciones_di,
funciones_re,
funciones_ca,
funciones_se,
funciones_au,
funciones_ba,
funciones_so,
funciones_pr,
numero
);
INSERT INTO `tbl_evaluaciones_practica`
(
`id_persona`,
`comunicacion`,
`puntualidad`,
`responsabilidad`,
`creatividad`,
`presentacion`,
`atencion_cliente`,
`colaborativo`,
`trabajo_equipo`,
`proactivo_iniciativa`,
`relacion_interpersonal`,
`analisis_sistema`,
`diseno_aplicacion`,
`programador_aplicacion`,
`mantenimiento_aplicacion`,
`aspecto_auditoria`,
`aspecto_seguridad`,
`numero_visita`
)
VALUES
(
@id_persona,
comunicacion,
puntualidad,
responsabilidad,
creatividad,
presentacion,
atencion,
colaborativo,
trabajo,
proactivo,
relacion,
analisis,
diseno,
programador,
mantenimiento,
aspecto_a,
aspecto_s,
numero
);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_segunda_visita` (IN `cuenta` VARCHAR(255), IN `comentario` VARCHAR(255), IN `area` VARCHAR(255), IN `calificacion` VARCHAR(255), IN `solicitar` VARCHAR(255), IN `oportunidad` VARCHAR(255), IN `nombre` VARCHAR(255), IN `lugar` VARCHAR(255), IN `numero` VARCHAR(255), IN `asistencia` VARCHAR(255), IN `horario` VARCHAR(255), IN `adaptacion` VARCHAR(255), IN `cumplimiento` VARCHAR(255), IN `calidad` VARCHAR(255), IN `percepcion_c` VARCHAR(255), IN `percepcion_h` VARCHAR(255))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona FROM tbl_personas_extendidas
WHERE valor = cuenta;
INSERT INTO `tbl_comentarios_alumnos`
(
`id_persona`,
`comentario_evaluacion`,
`area_refuerzo`,
`calificacion_global`,
`solicitar_practicante`,
`oportunidad_empleo`,
`nombre_representante`,
`lugar`,
`fecha`,
`numero_visita`
)
VALUES
(
@id_persona,
comentario,
area,
calificacion,
solicitar,
oportunidad,
nombre,
lugar,
now(),
numero
);
INSERT INTO `tbl_desempeno_practica`
(
`id_persona`,
`asistencia_practicante`,
`horario_practicante`,
`adaptacion_practicante`,
`cumplimiento_practicante`,
`calidad_trabajo_practicante`,
`percepcion_conocimiento`,
`percepcion_habilidades`,
`numero_visita`
)
VALUES
(
@id_persona,
asistencia,
horario,
adaptacion,
cumplimiento,
calidad,
percepcion_c,
percepcion_h,
numero
);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_unica_visita` (IN `cuenta` VARCHAR(255), IN `comentario` VARCHAR(255), IN `area` VARCHAR(255), IN `calificacion` VARCHAR(255), IN `solicitar` VARCHAR(255), IN `oportunidad` VARCHAR(255), IN `nombre` VARCHAR(255), IN `lugar` VARCHAR(255), IN `numero` VARCHAR(255), IN `funciones_an` VARCHAR(255), IN `funciones_di` VARCHAR(255), IN `funciones_re` VARCHAR(255), IN `funciones_ca` VARCHAR(255), IN `funciones_se` VARCHAR(255), IN `funciones_au` VARCHAR(255), IN `funciones_ba` VARCHAR(255), IN `funciones_so` VARCHAR(255), IN `funciones_pr` VARCHAR(255), IN `comunicacion` VARCHAR(255), IN `puntualidad` VARCHAR(255), IN `responsabilidad` VARCHAR(255), IN `creatividad` VARCHAR(255), IN `presentacion` VARCHAR(255), IN `atencion` VARCHAR(255), IN `colaborativo` VARCHAR(255), IN `trabajo` VARCHAR(255), IN `proactivo` VARCHAR(255), IN `relacion` VARCHAR(255), IN `analisis` VARCHAR(255), IN `diseno` VARCHAR(255), IN `programador` VARCHAR(255), IN `mantenimiento` VARCHAR(255), IN `aspecto_a` VARCHAR(255), IN `aspecto_s` VARCHAR(255), IN `asistencia` VARCHAR(255), IN `horario` VARCHAR(255), IN `adaptacion` VARCHAR(255), IN `cumplimiento` VARCHAR(255), IN `calidad` VARCHAR(255), IN `percepcion_c` VARCHAR(255), IN `percepcion_h` VARCHAR(255))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona FROM tbl_personas_extendidas
WHERE valor = cuenta;
INSERT INTO `tbl_comentarios_alumnos`
(
`id_persona`,
`comentario_evaluacion`,
`area_refuerzo`,
`calificacion_global`,
`solicitar_practicante`,
`oportunidad_empleo`,
`nombre_representante`,
`lugar`,
`fecha`,
`numero_visita`
)
VALUES
(
@id_persona,
comentario,
area,
calificacion,
solicitar,
oportunidad,
nombre,
lugar,
now(),
numero
);
INSERT INTO `tbl_funciones_practica`
(
`id_persona`,
`funciones_analisis`,
`funciones_diseno`,
`funciones_redes`,
`funciones_capacitacion`,
`funciones_seguridad`,
`funciones_auditoria`,
`funciones_base`,
`funciones_soporte`,
`funciones_programacion`,
`numero_visita`
)
VALUES
(
@id_persona,
funciones_an,
funciones_di,
funciones_re,
funciones_ca,
funciones_se,
funciones_au,
funciones_ba,
funciones_so,
funciones_pr,
numero
);
INSERT INTO `tbl_evaluaciones_practica`
(
`id_persona`,
`comunicacion`,
`puntualidad`,
`responsabilidad`,
`creatividad`,
`presentacion`,
`atencion_cliente`,
`colaborativo`,
`trabajo_equipo`,
`proactivo_iniciativa`,
`relacion_interpersonal`,
`analisis_sistema`,
`diseno_aplicacion`,
`programador_aplicacion`,
`mantenimiento_aplicacion`,
`aspecto_auditoria`,
`aspecto_seguridad`,
`numero_visita`
)
VALUES
(
@id_persona,
comunicacion,
puntualidad,
responsabilidad,
creatividad,
presentacion,
atencion,
colaborativo,
trabajo,
proactivo,
relacion,
analisis,
diseno,
programador,
mantenimiento,
aspecto_a,
aspecto_s,
numero
);
INSERT INTO `tbl_desempeno_practica`
(
`id_persona`,
`asistencia_practicante`,
`horario_practicante`,
`adaptacion_practicante`,
`cumplimiento_practicante`,
`calidad_trabajo_practicante`,
`percepcion_conocimiento`,
`percepcion_habilidades`,
`numero_visita`
)
VALUES
(
@id_persona,
asistencia,
horario,
adaptacion,
cumplimiento,
calidad,
percepcion_c,
percepcion_h,
numero
);
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_historial_alumno` (IN `cuenta` VARCHAR(255))  BEGIN
   SELECT tbl_voae_asistencias.id_asistencia,  
   tbl_voae_asistencias.id_actividad_voae, tbl_voae_asistencias.nombre_alumno, tbl_voae_actividades.nombre_actividad, tbl_voae_actividades.fch_inicial_actividad, tbl_voae_ambitos.nombre_ambito AS ambito, tbl_voae_asistencias.cant_horas FROM tbl_voae_asistencias JOIN tbl_voae_actividades ON tbl_voae_asistencias.id_actividad_voae= tbl_voae_actividades.id_actividad_voae JOIN tbl_voae_ambitos ON tbl_voae_actividades.id_ambito = tbl_voae_ambitos.id_ambito where cuenta = cuenta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_actividades` (IN `actividad_` VARCHAR(150), IN `descripcion_` VARCHAR(50), IN `nombre_proyecto_` VARCHAR(50), IN `horas_semanales_` VARCHAR(50), IN `id_comisiones_` BIGINT, IN `Usuario_` VARCHAR(50), IN `id_actividad_` VARCHAR(50))  BEGIN
UPDATE tbl_actividades SET   actividad=actividad_, descripcion=descripcion_, nombre_proyecto=nombre_proyecto_, horas_semanales=horas_semanales_ ,id_comisiones=id_comisiones_,  Fecha_modificación=sysdate() , Modificado_por=Usuario_ WHERE id_actividad= id_actividad_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_area` (IN `area_` VARCHAR(50), IN `id_area_` INT)  BEGIN
UPDATE tbl_areas SET area = area_, descripcion = area_ WHERE id_area = id_area_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_asistencia_charla` (IN `Id_charla_` BIGINT, IN `jornada_` VARCHAR(50), IN `asistencia_` INT, IN `fecha_recibida_` DATE)  BEGIN
update tbl_charla_practica set fecha_recibida=fecha_recibida_,estado_asistencia_charla=asistencia_, fecha_valida=(select DATE_ADD(fecha_recibida_,INTERVAL (select valor from tbl_parametros where parametro="DIAS_CHARLA") DAY))
where Id_charla=Id_charla_ and jornada=jornada_;
update tbl_charla_practica set charla_impartida=1 where fecha_recibida=fecha_recibida_;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_atributo` (IN `atributo_` VARCHAR(50), IN `requerido_` VARCHAR(50), IN `id_tipo_persona_` INT, IN `Usuario_` VARCHAR(50), IN `id_atributos_` VARCHAR(50))  BEGIN
UPDATE tbl_atributos SET   atributo=atributo_, requerido=requerido_, id_tipo_persona=id_tipo_persona_,  Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_atributos= id_atributos_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_aula` (IN `codigo_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `capacidad_` INT, IN `id_edificio_` INT, IN `id_tipo_aula_` INT, IN `Usuario_` VARCHAR(50), IN `id_aula_` INT)  BEGIN
UPDATE tbl_aula SET  id_aula=id_aula_, codigo=codigo_, descripcion=descripcion_, capacidad=capacidad_, id_edificio=id_edificio_ ,id_tipo_aula=id_tipo_aula_,  Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_aula= id_aula_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_cambio_empresa_estudiante_practica` (IN `cuenta_` VARCHAR(255))  BEGIN
UPDATE tbl_subida_documentacion set estado_vinculacion=3 , estado_coordinacion=null where Id_usuario=(select Id_usuario from tbl_usuarios where numero_cuenta=cuenta_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_carga_academica` (IN `control_` VARCHAR(50), IN `seccion_` VARCHAR(50), IN `hora_inicial_` VARCHAR(50), IN `hora_final_` VARCHAR(50), IN `num_alumnos_` INT, IN `id_aula_` BIGINT, IN `id_asignatura_` BIGINT, IN `dias_` VARCHAR(50), IN `id_modalidad_` BIGINT, IN `id_carga_academica_` BIGINT)  BEGIN
UPDATE tbl_carga_academica
SET 
control=control_,
seccion=seccion_,
hora_inicial=hora_inicial_,
hora_final=hora_final_,
num_alumnos=num_alumnos_,
id_aula=id_aula_,
id_asignatura=id_asignatura_,
dias=dias_,
id_modalidad=id_modalidad_
WHERE id_carga_academica=id_carga_academica_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_carga_academica_virtual` (IN `control_` VARCHAR(50), IN `seccion_` VARCHAR(50), IN `hora_inicial_` VARCHAR(50), IN `hora_final_` VARCHAR(50), IN `num_alumnos_` INT, IN `id_asignatura_` BIGINT, IN `dias_` VARCHAR(50), IN `id_modalidad_` BIGINT, IN `id_carga_academica_` BIGINT)  BEGIN
UPDATE tbl_carga_academica
SET 
control=control_,
seccion=seccion_,
hora_inicial=hora_inicial_,
hora_final=hora_final_,
num_alumnos=num_alumnos_,
id_aula=NULL,
id_asignatura=id_asignatura_,
dias=dias_,
id_modalidad=id_modalidad_
WHERE id_carga_academica=id_carga_academica_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_carrera` (IN `Descripcion_` VARCHAR(50), IN `Id_facultad_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `Id_carrera_` INT)  BEGIN
UPDATE tbl_carrera SET   Descripcion=Descripcion_, Id_facultad=Id_facultad_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_carrera= id_carrera_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_categoria` (IN `categoria_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_categoria_` VARCHAR(50))  BEGIN
UPDATE tbl_categorias SET  categoria=categoria_, descripcion=descripcion_, Fecha_modificacion=SYSDATE(), Modificado_por=Usuario_ WHERE id_categoria= id_categoria_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_clave_x_pregunta` (`contrasena_` VARCHAR(150), `Id_usuario_` INTEGER)  begin
UPDATE tbl_usuarios SET    Contrasena=contrasena_ WHERE Id_usuario=Id_usuario_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_comisiones` (IN `comision_` VARCHAR(50), IN `carrera_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_comisiones_` INT)  begin
UPDATE tbl_comisiones SET   comision=comision_, id_carrera=carrera_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_comisiones= id_comisiones_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_departamento` (IN `departamento_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_departamento_` VARCHAR(50))  BEGIN
UPDATE tbl_departamentos SET   departamento=departamento_,  Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_departamento= id_departamento_ ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_documentos_practica_vinculacion` (IN `cuenta_` VARCHAR(255), IN `vinculacion_` INT, IN `observacion_vinculacion_` VARCHAR(255))  BEGIN
UPDATE `tbl_subida_documentacion` SET `fecha_vinculacion`=sysdate(),`estado_vinculacion`=vinculacion_,`observacion_vinculacion`=observacion_vinculacion_
 WHERE `id_persona`=(SELECT p.id_persona from tbl_personas p, tbl_personas_extendidas px WHERE px.id_persona=p.id_persona and px.valor=cuenta_ );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_edificio` (IN `nombre_` VARCHAR(50), IN `codigo_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_edificio_` VARCHAR(50))  BEGIN
UPDATE tbl_edificios SET   nombre= nombre_, codigo=codigo_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_edificio= id_edificio_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_empresa_practica` (IN `nombre_empresa_` VARCHAR(255), IN `direccion_empresa_` VARCHAR(255), IN `departamento_empresa_` VARCHAR(255), IN `jefe_inmediato_` VARCHAR(255), IN `titulo_jefe_inmediato_` VARCHAR(255), IN `cargo_jefe_inmediato_` VARCHAR(255), IN `correo_jefe_inmediato_` VARCHAR(255), IN `telefono_jefe_inmediato_` VARCHAR(10), IN `id_persona_` BIGINT(16), IN `Id_empresa_` BIGINT(16))  BEGIN
UPDATE tbl_empresas_practica
SET nombre_empresa = nombre_empresa_,
direccion_empresa= direccion_empresa_,
departamento_empresa = departamento_empresa_,
jefe_inmediato = jefe_inmediato_,
titulo_jefe_inmediato =titulo_jefe_inmediato_,
cargo_jefe_inmediato =cargo_jefe_inmediato_,
correo_jefe_inmediato =correo_jefe_inmediato_,
telefono_jefe_inmediato =telefono_jefe_inmediato_,
id_persona=id_persona_
WHERE
Id_empresa = Id_empresa_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_estado_civil` (IN `estado_civil_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_estado_civil_` VARCHAR(50))  begin
UPDATE tbl_estadocivil SET   estado_civil=estado_civil_, descripcion=descripcion_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_estado_civil= id_estado_civil_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_genero` (IN `genero_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_genero_` VARCHAR(50))  BEGIN
UPDATE tbl_genero SET genero=genero_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_genero= id_genero_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_grados_academicos` (IN `grado_academico_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_grado_academico_` BIGINT)  BEGIN
UPDATE tbl_grados_academicos SET  grado_academico=grado_academico_, descripcion=descripcion_,
 Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_grado_academico= id_grado_academico_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_horario_docente` (IN `hora_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `horario_` VARCHAR(50))  BEGIN
UPDATE tbl_hora SET hora=hora_,Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE hora=horario_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_horas` (IN `horas_semanales_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_actividad_` INT)  BEGIN
UPDATE tbl_actividades SET horas_semanales = horas_semanales_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_actividad= id_actividad_; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_informe_voae` (IN `id_informe_` BIGINT(20), IN `id_repositorio_` BIGINT(20), IN `nombre_archivo_` VARCHAR(50), IN `dir_repositorio_` VARCHAR(150), IN `id_actividad_` BIGINT(20), IN `introduccion_` VARCHAR(1000), IN `objetivos_` VARCHAR(1000), IN `desarrollo_` TEXT, IN `conclusiones_` VARCHAR(1000), IN `id_usuario_registro_` BIGINT(20), IN `id_estado_` BIGINT(20))  BEGIN 
 
UPDATE tbl_voae_repositorios
SET nombre_archivo = nombre_archivo_,
	dir_repositorio = dir_repositorio_,
    fecha_carga = curdate(),
    id_usuario_registro = id_usuario_registro_
WHERE  id_repositorio = id_repositorio_;

UPDATE tbl_voae_informes
SET id_actividad = id_actividad_,
	introduccion = introduccion_,
	objetivos = objetivos_,
    desarrollo= desarrollo_,
    conclusiones = conclusiones_,
    fch_informe = curdate(),
    id_usuario_registro = id_usuario_registro_
WHERE  id_informe = id_informe_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_jornada` (IN `jornada_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_jornada_` INT)  BEGIN
UPDATE tbl_jornadas SET   jornada=jornada_, descripcion=descripcion_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_jornada= id_jornada_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_municipio` (IN `municipio_` VARCHAR(50), IN `codigo_` VARCHAR(50), IN `id_departamento_` VARCHAR(50), IN `Usuario_` VARCHAR(50), IN `id_municipio_` INT)  BEGIN
UPDATE tbl_municipios_hn SET   municipio=municipio_, codigo=codigo_, id_departamento=id_departamento_,  Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_municipio= id_municipio_ ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_nacionalidad` (IN `nacionalidad_` VARCHAR(50), IN `PAIS_NAC_` CHAR(50), IN `Usuario_` VARCHAR(50), IN `id_nacionalidad_` VARCHAR(50))  BEGIN
UPDATE tbl_nacionalidad SET nacionalidad=nacionalidad_, PAIS_NAC=PAIS_NAC_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_nacionalidad= id_nacionalidad_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_periodo_carga` (IN `fecha_inicio_` DATE, IN `fecha_final_` DATE, IN `Usuario_` VARCHAR(50), IN `id_tipo_periodo_` INT, IN `fecha_adic_canc_` DATE, IN `fecha_desbloqueo_` DATE, IN `num_periodo_` BIGINT, IN `num_anno_` YEAR, IN `id_periodo_` BIGINT)  BEGIN
UPDATE tbl_periodo SET fecha_inicio = fecha_inicio_, fecha_final = fecha_final_, 
Fecha_modificacion=sysdate() , Modificado_por = Usuario_, id_tipo_periodo = id_tipo_periodo_, fecha_adic_canc = fecha_adic_canc_, fecha_desbloqueo = fecha_desbloqueo_, num_periodo = num_periodo_, num_anno = num_anno_ WHERE id_periodo= id_periodo_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_permiso_usuario` (IN `insertar_` INT, IN `Modificar_` INT, IN `Eliminar_` INT, IN `Visualizar_` INT, IN `usuario_` VARCHAR(150), IN `id_permiso_` INT)  BEGIN
UPDATE tbl_permisos_usuarios SET   insertar=insertar_ , modificar=Modificar_, eliminar=Eliminar_, visualizar=Visualizar_ , Fecha_modificacion=sysdate() , Modificado_por=usuario_ WHERE Id_permisos_usuario= id_permiso_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_plan_estudio` (IN `nombre_` VARCHAR(50), IN `num_clases_` INT, IN `codigo_plan_` VARCHAR(50), IN `id_tipo_plan_` BIGINT, IN `fecha_modificacion_` DATE, IN `modificado_por_` VARCHAR(50), IN `id_plan_estudio_` BIGINT)  BEGIN
UPDATE tbl_plan_estudio
SET 
nombre=nombre_,
num_clases=num_clases_,
codigo_plan=codigo_plan_,
id_tipo_plan=id_tipo_plan_,
fecha_modificacion=fecha_modificacion_,
modificado_por=modificado_por_
WHERE id_plan_estudio=id_plan_estudio_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_pregunta` (IN `pregunta` VARCHAR(150), IN `estado` INT, IN `usuario` VARCHAR(100), IN `cod_pregunta` INT)  BEGIN
UPDATE `tbl_preguntas` SET `pregunta`=pregunta,`estado`=estado,`Modificado_por`=usuario,`Fecha_modificacion`=sysdate() WHERE Id_pregunta=cod_pregunta;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_respuesta_seguridad` (IN `Respuesta_` VARCHAR(150), IN `pregunta_` INT(150), IN `Usuario_` INT)  begin
UPDATE tbl_preguntas_seguridad SET Respuesta=Respuesta_
where Id_pregunta=pregunta_ and Id_usuario=usuario_;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_rol` (`Rol_` VARCHAR(150), `Descripcion_` VARCHAR(150), `Estado_` INTEGER, `Usuario_` VARCHAR(150), `Id_rol_` INTEGER)  begin
UPDATE tbl_roles SET   Rol=Rol_, descripcion=Descripcion_, estado=Estado_, Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE Id_rol= Id_rol_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_usuario` (IN `Usuario_` VARCHAR(150), IN `Id_rol_` INT, IN `Modificado_` VARCHAR(150), IN `Id_usuario_` INT, IN `Estado_` INT)  begin
UPDATE tbl_usuarios SET   Usuario=Usuario_, Id_rol=Id_rol_,  Fecha_modificacion=sysdate() , Modificado_por=Modificado_ ,Estado=Estado_  WHERE Id_usuario= Id_usuario_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actulizar_egresado` (IN `tel_fijo_` VARCHAR(13), IN `celular_` VARCHAR(13), IN `correo_personal_` VARCHAR(100), IN `posee_maestria_` VARCHAR(2), IN `maestria_` VARCHAR(100), IN `posee_certificado_` VARCHAR(2), IN `certificado_` VARCHAR(100), IN `labora_` VARCHAR(2), IN `empresa_` VARCHAR(100), IN `departamento_` VARCHAR(100), IN `direccion_` VARCHAR(100), IN `tel_empresa_` VARCHAR(13), IN `correo_profesional_` VARCHAR(130), IN `nombre_` VARCHAR(150), IN `id_egresado_` VARCHAR(20))  BEGIN
UPDATE
tbl_egresados
SET
telefono_egresado = tel_fijo_,
celular_egresado = celular_,
correo_electronico = correo_personal_,
posee_maestria = posee_maestria_,
maestria = maestria_,
posee_certificado = posee_certificado_,
certificado = certificado_,
labora = labora_,
nombre_empresa = empresa_,
departamento_egresado = departamento_,
direccion_empresa = direccion_,
telefono_empresa = tel_empresa_,
correo_profesional = correo_profesional_
WHERE
Id_egresado = Id_egresado_ AND nombre = nombre_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actulizar_parametro` (`descripcion_` VARCHAR(150), `valor_` VARCHAR(150), `modificado_` VARCHAR(150), `id_parametro_` INTEGER)  begin
UPDATE tbl_parametros SET  Descripcion=descripcion_, Valor=valor_ , Fecha_modificacion=sysdate() , Modificado_por=modificado_ WHERE Id_parametro= id_parametro_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_agregar_especialidad` (IN `par_id_grado_academico` INT, IN `par_especialidad` VARCHAR(100), IN `id_persona_` INT)  BEGIN

INSERT INTO tbl_especialidad_grado (ID_GRADO_ACADEMICO,ESPECIALIDAD) VALUES(par_id_grado_academico,par_especialidad);
SET @id_especialidad:=(select id_especialidad FROM  tbl_especialidad_grado where ESPECIALIDAD=par_especialidad);
INSERT INTO tbl_grados_academicos_personas(ID_ESPECIALIDAD,ID_PERSONA) VALUES(@id_especialidad, id_persona_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_aprobacion_practica` (IN `cuenta_` VARCHAR(50), IN `obs_` VARCHAR(255), IN `tipo_` INT, IN `empresa_` VARCHAR(255), IN `horas_pps_` INT, IN `fecha_inicio_` DATE, IN `fecha_finaliza_` DATE)  BEGIN
IF tipo_=1 THEN
UPDATE tbl_subida_documentacion set estado_coordinacion=1, fecha_coordinacion=sysdate(),motivo_coordinacion=obs_ 
where id_persona=(SELECT p.id_persona from tbl_personas p , tbl_personas_extendidas px WHERE  px.id_persona=p.id_persona and px.valor=cuenta_);
update tbl_practica_estudiantes SET horas=horas_pps_, fecha_inicio=fecha_inicio_, fecha_finaliza=fecha_finaliza_ where id_persona=(SELECT p.id_persona from tbl_personas p , tbl_personas_extendidas px WHERE  px.id_persona=p.id_persona and px.valor=cuenta_);
ELSEIF tipo_=0 then
UPDATE tbl_subida_documentacion set estado_coordinacion=0 , fecha_coordinacion=sysdate(), motivo_coordinacion=obs_ 
where id_persona=(SELECT p.id_persona from tbl_personas p , tbl_personas_extendidas px WHERE  px.id_persona=p.id_persona and px.valor=cuenta_);
INSERT INTO `tbl_practica_rechazo`(`id_persona`, `nombre_empresa`, `motivo`, `fecha_creacion`)
 VALUES ((SELECT p.id_persona from tbl_personas p , tbl_personas_extendidas px WHERE  px.id_persona=p.id_persona and px.valor=cuenta_),empresa_,obs_,sysdate());
ELSE
UPDATE tbl_subida_documentacion set estado_coordinacion=NULL, estado_vinculacion=0, fecha_coordinacion=sysdate(), observacion_vinculacion=obs_ 
where id_persona=(SELECT p.id_persona from tbl_personas p , tbl_personas_extendidas px WHERE  px.id_persona=p.id_persona AND  px.valor=cuenta_);
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_count_carga` (IN `id_persona_` INT)  BEGIN
SELECT COUNT(id_persona) AS carga FROM tbl_carga_academica WHERE id_persona = id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_count_preg1` (IN `id_persona_` BIGINT)  BEGIN
SELECT COUNT(id_pref_area_doce) AS registro FROM tbl_pref_area_docen WHERE id_persona = id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_count_preg2` (IN `id_persona_` BIGINT)  BEGIN
SELECT COUNT(id_expe_academi_docente) AS registro FROM tbl_expe_academica_docente WHERE id_persona = id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_count_preg3` (IN `id_persona_` BIGINT)  BEGIN
SELECT COUNT(id_pref_asig_docen) AS registro FROM tbl_pref_asig_docen WHERE id_persona = id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_count_preg4` (IN `id_persona_` BIGINT)  BEGIN
SELECT COUNT(id_desea_asig_doce) AS registro FROM tbl_desea_asig_doce WHERE id_persona = id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_actividades` (IN `actividad_` VARCHAR(50))  BEGIN
DELETE FROM tbl_actividades WHERE actividad = actividad_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_area` (IN `id_area_` INT)  BEGIN
DELETE FROM tbl_areas WHERE id_area = id_area_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_atributo` (IN `atributo_` VARCHAR(50))  BEGIN
DELETE FROM tbl_atributos WHERE atributo = atributo_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_aula` (IN `id_aula_` INT)  BEGIN
DELETE FROM tbl_aula WHERE id_aula = id_aula_; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_carga_academica` (IN `id_carga_academica_` BIGINT)  BEGIN
DELETE FROM tbl_carga_academica WHERE id_carga_academica =id_carga_academica_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_carrera` (IN `Descripcion_` VARCHAR(50))  BEGIN
DELETE FROM tbl_carrera WHERE Descripcion = Descripcion_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_categoria` (IN `categoria_` VARCHAR(50))  BEGIN
DELETE FROM tbl_categorias WHERE categoria = categoria_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_comision` (IN `comision_` VARCHAR(50))  BEGIN
DELETE FROM tbl_comisiones WHERE comision = comision_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_departamento` (IN `departamento_` VARCHAR(50))  BEGIN
DELETE FROM tbl_departamentos WHERE departamento = departamento_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_edificio` (IN `nombre_` VARCHAR(50))  BEGIN
DELETE FROM tbl_edificios WHERE nombre = nombre_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_estado_civil` (IN `estado_civil_` VARCHAR(50))  BEGIN
DELETE FROM tbl_estadocivil WHERE estado_civil = estado_civil_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_genero` (IN `genero_` VARCHAR(50))  BEGIN
DELETE FROM tbl_genero WHERE genero = genero_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_grados_academicos` (IN `grado_academico_` VARCHAR(50))  BEGIN
DELETE FROM tbl_grados_academicos WHERE grado_academico = grado_academico_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_horario_docente` (IN `hora_` INT)  BEGIN
DELETE FROM tbl_hora WHERE hora = hora_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_informe_voae` (IN `id_informe_` BIGINT)  BEGIN

	SET @id_actividad = (SELECT id_actividad FROM tbl_voae_informes WHERE id_informe = id_informe_);
	
  DELETE FROM tbl_voae_asistencias WHERE id_actividad_voae = @id_actividad;
  
  DELETE FROM tbl_voae_informes WHERE id_informe = id_informe_;
  
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_jornada` (IN `jornada` VARCHAR(50))  BEGIN
DELETE FROM tbl_jornadas WHERE jornada = jornada_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_municipio` (IN `municipio_` VARCHAR(50))  BEGIN
DELETE FROM tbl_municipios_hn WHERE municipio = municipio_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_nacionalidad` (IN `nacionalidad_` VARCHAR(50))  BEGIN
DELETE FROM tbl_nacionalidad WHERE nacionalidad = nacionalidad_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_periodo` (IN `id_periodo_` INT)  BEGIN
DELETE FROM tbl_periodo WHERE id_periodo = id_periodo_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_pregunta` (`preguntaname` VARCHAR(100))  BEGIN
DELETE FROM tbl_preguntas WHERE Pregunta =preguntaname;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_rol` (IN `rol_` VARCHAR(150))  BEGIN
DELETE FROM tbl_roles WHERE Rol = rol_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_usuario` (`usuario_` VARCHAR(150))  BEGIN
DELETE FROM tbl_usuarios WHERE Usuario =usuario_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_estado_usuario` (IN `estado_` VARCHAR(50), IN `id_persona_` BIGINT)  BEGIN
UPDATE tbl_personas SET Estado= estado_
WHERE id_persona = id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_existe_municipio_depto` (IN `codigo_` INT)  BEGIN
SELECT COUNT(codigo) AS regis FROM tbl_municipios_hn WHERE codigo = codigo_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_gestion_docente` ()  BEGIN
set @idnumero_empleado=(select id_atributos from tbl_atributos where atributo="numero_empleado" or atributo="NUMERO_EMPLEADO");
set @idfecha_ingreso=(select id_atributos from tbl_atributos where atributo="fecha_ingreso" or atributo="FECHA_INGRESO");
set @id_tipo_docente=(select id_atributos from tbl_atributos where atributo="SUED" or atributo="sued");



select DISTINCT tp.id_persona,tp.identidad, tp.nacionalidad,tp.Estado, concat(tp.nombres," ",tp.apellidos) as "nombre"
,tj.jornada,tj.id_jornada,thd.hr_inicial, thd.hr_final,tca.categoria,tca.id_categoria,(SELECT GROUP_CONCAT( DISTINCT valor, "\n") from tbl_contactos tc1,
tbl_tipo_contactos ttc1, tbl_personas tp1 where ttc1.id_tipo_contacto=tc1.id_tipo_contacto and ttc1.descripcion="TELEFONO CELULAR" and tp1.id_persona=tc1.id_persona and tp.id_persona=tp1.id_persona) as contactos ,
(SELECT GROUP_CONCAT( DISTINCT valor,  "\n") from tbl_contactos tc2, tbl_personas tp2, tbl_tipo_contactos ttc2 
where tp2.id_persona=tc2.id_persona and tp.id_persona=tp2.id_persona and tc2.id_tipo_contacto=ttc2.id_tipo_contacto and ttc2.descripcion="CORREO") as correos,
tpx1.valor numero_empleado, tpx3.valor as sued, tpx2.valor as fecha_ingreso ,(select GROUP_CONCAT( DISTINCT concat(tga.grado_academico,":",teg.especialidad,"\n")) from tbl_personas tp5, tbl_especialidad_grado teg, tbl_grados_academicos tga,tbl_grados_academicos_personas tgap where tgap.id_persona=tp5.id_persona and tgap.id_persona=tp.id_persona and tgap.id_especialidad=teg.id_especialidad and tga.id_grado_academico=teg.id_grado_academico ) as formacion_academica, (select GROUP_CONCAT( DISTINCT concat(tcom.comision,":",tac.actividad,"\n")) FROM tbl_personas tp6, tbl_actividades tac, tbl_comisiones tcom, tbl_actividades_persona tap WHERE tap.id_persona=tp6.id_persona AND tap.id_persona=tp.id_persona AND tap.id_actividad=tac.id_actividad AND tcom.id_comisiones=tac.id_comisiones) AS Comisiones_Actividades
from tbl_personas tp
JOIN tbl_contactos tc on tp.id_persona=tc.id_persona
JOIN tbl_personas_extendidas tpx1 on tp.id_persona=tpx1.id_persona
    JOIN tbl_personas_extendidas tpx2 on tp.id_persona=tpx2.id_persona
    JOIN tbl_personas_extendidas tpx3 on tp.id_persona=tpx3.id_persona
    JOIN tbl_personas_extendidas tpx4 ON tp.id_persona=tpx4.id_persona
    JOIN tbl_personas_extendidas tpx5 ON tp.id_persona=tpx5.id_persona
JOIN tbl_atributos ta1 on tpx1.id_atributo=ta1.id_atributos and @idnumero_empleado=ta1.id_atributos
    JOIN tbl_atributos ta2 on tpx2.id_atributo=ta2.id_atributos and @idfecha_ingreso=ta2.id_atributos
    JOIN tbl_atributos ta3 on tpx3.id_atributo=ta3.id_atributos and @id_tipo_docente=ta3.id_atributos
     
   
JOIN tbl_horario_docentes thd on tp.id_persona=thd.id_persona
JOIN tbl_jornadas tj on thd.id_jornada = tj.id_jornada AND tj.id_jornada = tj.id_jornada AND thd.hr_inicial = thd.hr_inicial AND thd.hr_final = thd.hr_final
JOIN tbl_categoria_personas tcap on tp.id_persona = tcap.id_persona
JOIN tbl_categorias tca on tcap.id_categoria = tca.id_categoria AND tca.id_categoria = tca.id_categoria


where ta1.id_atributos = tpx1.id_atributo  AND ta2.id_atributos=tpx2.id_atributo and ta3.id_atributos=tpx3.id_atributo
;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_guardar_solicitud_practica` (IN `_id_persona` INT, IN `_telefono` VARCHAR(50), IN `_celular` VARCHAR(50), IN `_direccion` VARCHAR(255), IN `_fecha_nacimiento` VARCHAR(50), IN `_tipo_empresa` VARCHAR(255), IN `_labora_dentro` VARCHAR(255), IN `_fecha_inicio` VARCHAR(255), IN `_fecha_finalizada` VARCHAR(255), IN `_identidad` VARCHAR(16))  BEGIN
set @id_telefono_fijo=(select id_tipo_contacto from tbl_tipo_contactos where descripcion='TELEFONO FIJO');
set @id_telefono_celular=(select id_tipo_contacto from tbl_tipo_contactos where descripcion='TELEFONO CELULAR');
set @id_direccion=(select id_tipo_contacto from tbl_tipo_contactos where descripcion='DIRECCION');
set @id_empresa=(select Id_empresa from tbl_empresas_practica where id_persona=_id_persona);
/*update datos del estudiantes*/
UPDATE tbl_personas SET fecha_nacimiento=_fecha_nacimiento , identidad=_identidad WHERE id_persona=_id_persona ;
/*insert telefono fijo*/
insert into tbl_contactos (id_persona, id_tipo_contacto, valor)
values (_id_persona,@id_telefono_fijo,_telefono);
/*insert telefono celular*/
insert into tbl_contactos (id_persona, id_tipo_contacto, valor)
values (_id_persona,@id_telefono_celular,_celular);
/*insert direccion*/
insert into tbl_contactos (id_persona, id_tipo_contacto, valor)
values (_id_persona,@id_direccion,_direccion);
/*update datos de la empresa*/
UPDATE tbl_empresas_practica set tipo_empresa=_tipo_empresa, labora_dentro=_labora_dentro WHERE id_persona=_id_persona  ;
/*insert fecha de inicio y finalizacion*/
insert into tbl_practica_estudiantes(id_persona, Id_empresa, fecha_inicio, fecha_finaliza, docente_supervisor)
values (_id_persona,@id_empresa,_fecha_inicio,_fecha_finalizada,'');
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_actividades` (IN `actividad_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `nombre_proyecto_` VARCHAR(50), IN `horas_semanales_` VARCHAR(50), IN `id_comisiones_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_actividades (actividad,descripcion,nombre_proyecto,horas_semanales, id_comisiones, Fecha_creacion,Creado_por)
VALUES (actividad_, descripcion_,nombre_proyecto_,horas_semanales_, id_comisiones_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_actividades_gestion` (IN `id_actividad_` INT, IN `id_persona_` INT)  BEGIN

INSERT INTO tbl_actividades_persona(id_actividad, id_persona)
VALUES(id_actividad_, id_persona_);
SELECT LAST_INSERT_ID() AS id_act_persona;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_asignaturas_aprobadas` (IN `Id_asignatura_` INT, IN `id_persona_` INT)  BEGIN
INSERT INTO `tbl_asignaturas_aprobadas`( `Id_asignatura`, `id_persona`, `Fecha_creacion`)
VALUES (Id_asignatura_ ,id_persona_, sysdate());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_atributo` (IN `atributo_` VARCHAR(50), IN `requerido_` VARCHAR(50), IN `id_tipo_persona_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_atributos(atributo, requerido, id_tipo_persona, Fecha_creacion,Creado_por)
VALUES (atributo_, requerido_, id_tipo_persona_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_atributos` (IN `valor_` VARCHAR(50), IN `valor2_` VARCHAR(50), IN `valor3_` VARCHAR(50), IN `valor4_` VARCHAR(50))  BEGIN
set @idnumero_empleado:=(select id_atributos from tbl_atributos where atributo="numero_empleado" or atributo="NUMERO_EMPLEADO");
set @idfecha_ingreso:=(select id_atributos from tbl_atributos where atributo="fecha_ingreso" or atributo="FECHA_INGRESO");
SET @idcurriculum:=(select id_atributos from tbl_atributos where atributo="curriculum" or atributo="CURRICULUM");
SET @idfoto:=(select id_atributos from tbl_atributos where atributo="foto" or atributo="FOTO");

INSERT INTO tbl_personas_extendidas(id_atributo, id_persona, valor)
VALUES(@idnumero_empleado, (SELECT MAX(id_persona)FROM tbl_personas), valor_),
(@idfecha_ingreso, (SELECT MAX(id_persona)FROM tbl_personas), valor2_),
(@idcurriculum, (SELECT MAX(id_persona)FROM tbl_personas), valor3_),
(@idfoto, (SELECT MAX(id_persona)FROM tbl_personas), valor4_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_aula` (IN `codigo_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `capacidad_` INT, IN `id_edificio_` BIGINT, IN `id_tipo_aula_` BIGINT, IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_aula (codigo,descripcion,capacidad,id_edificio, id_tipo_aula, Fecha_creacion,Creado_por)
VALUES (codigo_,descripcion_,capacidad_,id_edificio_, id_tipo_aula_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_carrera` (IN `descripcion_` VARCHAR(50), IN `Id_facultad_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_carrera(descripcion, Id_facultad, Fecha_creacion,Creado_por)
VALUES (descripcion_, Id_facultad_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_comision` (IN `comision_` VARCHAR(50), IN `id_carrera_` BIGINT, IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_comisiones(comision, id_carrera, Fecha_creacion,Creado_por)
VALUES (comision_, id_carrera_, SYSDATE(),usuario_);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_comisiones_actividades` (IN `id_actividad_` INT)  BEGIN

INSERT INTO tbl_actividades_persona(id_actividad, id_persona)
VALUES(id_actividad_,(SELECT MAX(id_persona)FROM tbl_personas));
SELECT LAST_INSERT_ID() AS id_act_persona;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_copia_carga` (IN `id_periodo_nuevo_` INT, IN `id_periodo_antiguo_` BIGINT)  BEGIN

INSERT INTO tbl_carga_academica(control, seccion, num_alumnos, id_persona, id_aula, id_asignatura, id_periodo, dias, id_modalidad, hora_inicial, hora_final) 
SELECT control, seccion, num_alumnos, id_persona, id_aula, id_asignatura, id_periodo_nuevo_, dias, id_modalidad, hora_inicial, hora_final 
from tbl_carga_academica 
WHERE id_periodo = id_periodo_antiguo_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_correos` (IN `valor_` VARCHAR(50))  BEGIN 
SET @idcorreo:=(select id_tipo_contacto from tbl_tipo_contactos where descripcion="CORREO" or descripcion="correo");

INSERT INTO tbl_contactos(id_persona, id_tipo_contacto, valor)
VALUES((SELECT MAX(id_persona)FROM tbl_personas),@idcorreo, valor_);


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_curriculum` (IN `valor1_` VARCHAR(50))  BEGIN
SET @idcurriculum:=(select id_atributos from tbl_atributos where atributo="curriculum" or atributo="CURRICULUM");

INSERT INTO tbl_personas_extendidas(id_atributo, id_persona, valor)
VALUES(@idcurriculum, (SELECT MAX(id_persona)FROM tbl_personas), valor1_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_departamento` (IN `departamento_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_departamentos(departamento, Fecha_creacion,Creado_por)
VALUES (departamento_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_desea_asig_docen` (IN `Id_asignatura_` BIGINT, IN `id_persona_` BIGINT)  BEGIN
INSERT INTO tbl_desea_asig_doce(Id_asignatura,id_persona)
VALUES (Id_asignatura_,id_persona_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_docentes_personas` (IN `nombres_` VARCHAR(50), IN `apellidos_` VARCHAR(50), IN `sexo_` VARCHAR(50), IN `identidad_` VARCHAR(50), IN `nacionalidad_` VARCHAR(50), IN `estado_civil_` VARCHAR(50), IN `fecha_nacimiento_` VARCHAR(50), IN `id_tipo_persona_` VARCHAR(50), IN `Estado_` VARCHAR(50), IN `id_categoria_` INT, IN `id_jornada_` BIGINT, IN `hr_inicial_` VARCHAR(50), IN `hr_final_` VARCHAR(50), IN `valor_` VARCHAR(50), IN `valor2_` VARCHAR(50), IN `sued_` VARCHAR(50))  BEGIN
set @idnumero_empleado:=(select id_atributos from tbl_atributos where atributo="numero_empleado" or atributo="NUMERO_EMPLEADO");
set @idfecha_ingreso:=(select id_atributos from tbl_atributos where atributo="fecha_ingreso" or atributo="FECHA_INGRESO");
set @tipo_docente:=(select id_atributos from tbl_atributos where atributo="sued" or atributo="SUED");

INSERT INTO tbl_personas(nombres, apellidos, sexo, identidad, nacionalidad, estado_civil, fecha_nacimiento, id_tipo_persona, Estado)
VALUES (nombres_, apellidos_, sexo_,identidad_,nacionalidad_, estado_civil_, fecha_nacimiento_, id_tipo_persona_, Estado_);

INSERT INTO tbl_categoria_personas(id_persona, id_categoria)
VALUES ((SELECT MAX(id_persona)FROM tbl_personas), id_categoria_);

INSERT INTO tbl_horario_docentes(id_jornada, id_categoria_persona, hr_inicial, hr_final, id_persona)
VALUES (id_jornada_, (SELECT MAX(id_categoria_persona)FROM tbl_categoria_personas), hr_inicial_, hr_final_, (SELECT MAX(id_persona)FROM tbl_personas));


INSERT INTO tbl_personas_extendidas(id_atributo, id_persona, valor)
VALUES(@idnumero_empleado, (SELECT MAX(id_persona)FROM tbl_personas), valor_),
(@tipo_docente, (SELECT MAX(id_persona)FROM tbl_personas), sued_),
(@idfecha_ingreso, (SELECT MAX(id_persona)FROM tbl_personas), valor2_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_edificio` (IN `nombre_` VARCHAR(50), IN `codigo_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_edificios (nombre, codigo, Fecha_creacion,Creado_por)
VALUES (nombre_, codigo_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_egresado` (IN `nombre_` VARCHAR(255), IN `cuenta_` BIGINT(13), IN `correo_` VARCHAR(255), IN `celular_` VARCHAR(12), IN `telefono_` VARCHAR(12), IN `fecha_graduacion_` VARCHAR(5), IN `posee_maestria_` CHAR(2), IN `maestria_` VARCHAR(255), IN `posee_certificado_` CHAR(2), IN `certificado_` VARCHAR(255), IN `labora_` CHAR(2), IN `nombre_empresa_` VARCHAR(255), IN `direccion_empresa_` VARCHAR(255), IN `telefono_empresa_` VARCHAR(12), IN `departamento_egresado_` VARCHAR(255), IN `correo_profesional_` VARCHAR(255))  BEGIN
INSERT INTO tbl_egresados(nombre, cuenta, correo_electronico, celular_egresado,telefono_egresado, fecha_graduacion,posee_maestria,maestria,posee_certificado,certificado,labora,nombre_empresa,direccion_empresa, telefono_empresa,departamento_egresado,correo_profesional,Fecha_creacion) VALUES (nombre_,cuenta_,correo_, celular_,telefono_,fecha_graduacion_,posee_maestria_,maestria_,posee_certificado_,certificado_, labora_, nombre_empresa_,direccion_empresa_,telefono_empresa_,departamento_egresado_,correo_profesional_,sysdate());
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_empresa_practica` (IN `nombre_empresa_` VARCHAR(255), IN `direccion_empresa_` VARCHAR(255), IN `departamento_empresa_` VARCHAR(255), IN `jefe_inmediato_` VARCHAR(255), IN `titulo_jefe_inmediato_` VARCHAR(255), IN `cargo_jefe_inmediato_` VARCHAR(255), IN `correo_jefe_inmediato_` VARCHAR(255), IN `telefono_jefe_inmediato_` VARCHAR(10), IN `id_persona_` BIGINT(16))  BEGIN
INSERT INTO `tbl_empresas_practica`(`id_persona`, `nombre_empresa`, `direccion_empresa`, `departamento_empresa`, `jefe_inmediato`, `titulo_jefe_inmediato`, `cargo_jefe_inmediato`, `correo_jefe_inmediato`, `telefono_jefe_inmediato`, `Fecha_creacion`)
VALUES( id_persona_,nombre_empresa_ , direccion_empresa_ , departamento_empresa_ , jefe_inmediato_ , titulo_jefe_inmediato_ , cargo_jefe_inmediato_ , correo_jefe_inmediato_ ,telefono_jefe_inmediato_  ,SYSDATE());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_estado_civil` (IN `estado_civil_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_estadocivil(estado_civil, descripcion, Fecha_creacion,Creado_por)
VALUES (estado_civil_, descripcion_, SYSDATE(),usuario_);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_estudiante` (IN `nombre_` VARCHAR(255), IN `apellido_` VARCHAR(255), IN `numero_cuenta_` BIGINT(16), IN `correo_` VARCHAR(50), IN `contraseña_` VARCHAR(255), IN `sexo_` VARCHAR(255), IN `usuario_` VARCHAR(20))  BEGIN
/*insert en tabla personas*/
SET @tpersona=(select id_tipo_persona from tbl_tipos_persona where tipo_persona='ESTUDIANTE');
insert into tbl_personas
(nombres, apellidos, sexo,id_tipo_persona)
value
(
  nombre_,apellido_,sexo_,@tpersona
);
SET  @id_persona = (SELECT LAST_INSERT_ID());
SET  @id_atributo=(select id_atributos from tbl_atributos where atributo='numero_cuenta');
SET  @rol=(select Id_rol from tbl_roles where Rol='ESTUDIANTE');
/*insert en tabla personas extendidas*/
insert into tbl_personas_extendidas(id_atributo, id_persona, valor)
value (@id_atributo,@id_persona,numero_cuenta_);
/*insert en tabla usuarios*/
INSERT INTO tbl_usuarios
        (
       id_persona, Usuario, Id_rol, estado, Contrasena, Fec_vence_contrasena,Fecha_creacion
        )
        VALUES(
        @id_persona,
        usuario_,
        @rol,
        2,
        contraseña_,
        sysdate(),
        sysdate()
        );
/*insert en tabla contactos*/
insert into tbl_contactos
(id_persona, id_tipo_contacto, valor)
value
(@id_persona,4,correo_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_expe_asig_docen` (IN `Id_asignatura_` BIGINT, IN `id_persona_` BIGINT)  BEGIN
INSERT INTO tbl_pref_asig_docen(Id_asignatura,id_persona)
VALUES (Id_asignatura_,id_persona_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_extendidas` (IN `valor_` BIGINT, IN `valor1_` DATE, IN `valor2_` VARCHAR(50), IN `valor3_` VARCHAR(50))  BEGIN
set @idnumero_empleado:=(select id_atributos from tbl_atributos where atributo="numero_empleado" or atributo="NUMERO_EMPLEADO");
set @idfecha_ingreso:=(select id_atributos from tbl_atributos where atributo="fecha_ingreso" or atributo="FECHA_INGRESO");
set @idcurriculum:=(select id_atributos from tbl_atributos where atributo="curriculum" or atributo="CURRICULUM");
set @idfoto:=(select id_atributos from tbl_atributos where atributo="foto" or atributo="FOTO");

INSERT INTO  tbl_personas_extendidas(id_persona, id_atributo, valor) 
VALUES((SELECT MAX(id_persona)FROM tbl_personas),@idnumero_empleado, valor_);

INSERT INTO  tbl_personas_extendidas(id_persona, id_atributo, valor)  
VALUES((SELECT MAX(id_persona)FROM tbl_personas),@idfecha_ingreso, valor1_);

INSERT INTO  tbl_personas_extendidas(id_persona, id_atributo, valor) 
VALUES((SELECT MAX(id_persona)FROM tbl_personas),@idcurriculum, valor2_);

INSERT INTO  tbl_personas_extendidas(id_persona, id_atributo, valor) 
VALUES((SELECT MAX(id_persona)FROM tbl_personas),@idfoto, valor3_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_foto` (IN `valor1_` VARCHAR(50))  BEGIN
SET @idfoto:=(select id_atributos from tbl_atributos where atributo="foto" or atributo="FOTO");

INSERT INTO tbl_personas_extendidas(id_atributo, id_persona, valor)
VALUES(@idfoto, (SELECT MAX(id_persona)FROM tbl_personas), valor1_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_gacademico` (IN `id_grado_academico_` INT, IN `especialidad_` VARCHAR(50))  BEGIN

INSERT INTO tbl_especialidad_grado(id_grado_academico, especialidad)
VALUES(id_grado_academico_,especialidad_);

INSERT INTO tbl_grados_academicos_personas(id_especialidad, id_persona)
VALUES((SELECT MAX(id_especialidad)FROM tbl_especialidad_grado),(SELECT MAX(id_persona)FROM tbl_personas));


SELECT LAST_INSERT_ID() AS id_grado_academico;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_genero` (IN `genero_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_genero(genero,Fecha_creacion,Creado_por)
VALUES (genero_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_grado_academico` (IN `grados_academicos_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `usuario_` VARCHAR(50))  INSERT INTO  tbl_grados_academicos(grado_academico, descripcion, Fecha_creacion,Creado_por)
VALUES (grados_academicos_, descripcion_, SYSDATE(),usuario_)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_horario_docente` (IN `hora_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_hora(hora,Fecha_creacion,Creado_por)
VALUES (hora_,SYSDATE(),usuario_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_informe_cve` (IN `nombre_archivo_` VARCHAR(50), IN `dir_repositorio_` VARCHAR(150), IN `id_actividad_` BIGINT(20), IN `introduccion_` VARCHAR(1000), IN `objetivos_` VARCHAR(1000), IN `desarrollo_` TEXT, IN `conclusiones_` VARCHAR(1000), IN `id_usuario_registro_` BIGINT(20), IN `id_estado_` BIGINT(20))  BEGIN

   SET @id_tipo_repositorio = (select id_repositorio from tbl_voae_tipos_repositorios where nombre_repositorio="PDF");
   
	insert into tbl_voae_repositorios (id_tipo_repositorio, nombre_archivo, dir_repositorio, fecha_carga, id_usuario_registro) 
	VALUE(@id_tipo_repositorio, nombre_archivo_, dir_repositorio_, CURDATE(), id_usuario_registro_);
	
	SET  @id_repositorio = (SELECT LAST_INSERT_ID());
	
	INSERT INTO tbl_voae_informes (id_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, id_usuario_registro, id_estado) 
	VALUES (id_actividad_, introduccion_, objetivos_, desarrollo_, conclusiones_, CURDATE(), @id_repositorio, id_usuario_registro_, id_estado);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_informe_voae` (IN `id_tipo_repositorio_` BIGINT(20), IN `nombre_archivo_` VARCHAR(50), IN `dir_repositorio_` VARCHAR(150), IN `id_actividad_` BIGINT(20), IN `introduccion_` VARCHAR(1000), IN `objetivos_` VARCHAR(1000), IN `desarrollo_` TEXT, IN `conclusiones_` VARCHAR(1000), IN `fch_informe_` DATE, IN `id_usuario_registro_` BIGINT(20), IN `id_estado_` BIGINT(20))  BEGIN
    insert into tbl_voae_repositorios (id_tipo_repositorio, nombre_archivo, dir_repositorio, fecha_carga, id_usuario_registro) 
	VALUE(id_tipo_repositorio_, nombre_archivo_, dir_repositorio_, CURDATE(), id_usuario_registro_);
SET  @id_repositorio = (SELECT LAST_INSERT_ID());
INSERT INTO tbl_voae_informes (id_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, id_usuario_registro, id_estado) 
VALUES (id_actividad_, introduccion_, objetivos_, desarrollo_, conclusiones_, curdate(), @id_repositorio, id_usuario_registro_, id_estado);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_inscripcion_charla` (IN `id_persona_` BIGINT(16), IN `no_constancia_` VARCHAR(15), IN `promedio_global_` VARCHAR(15), IN `clases_aprobadas_` VARCHAR(15), IN `porcentaje_clases_` VARCHAR(10), IN `jornada_` VARCHAR(50))  BEGIN
INSERT INTO tbl_charla_practica ( `id_persona`, `no_constancia`, `promedio_global`, `clases_aprobadas`, `porcentaje_clases`, `jornada`, `estado_asistencia_charla`,`charla_impartida`) VALUES (id_persona_,no_constancia_,promedio_global_, clases_aprobadas_,porcentaje_clases_,jornada_,0,0);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_jornada` (IN `jornada_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN

INSERT INTO  tbl_jornadas(jornada, descripcion, Fecha_creacion,Creado_por)
VALUES (jornada_, descripcion_, SYSDATE(),usuario_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_municipio` (IN `municipio_` VARCHAR(50), IN `codigo_` VARCHAR(50), IN `id_departamento_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_municipios_hn(municipio, codigo, id_departamento, Fecha_creacion,Creado_por)
VALUES (municipio_, codigo_, id_departamento_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_nacionalidad` (IN `nacionalidad_` VARCHAR(50), IN `pais_nac_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO  tbl_nacionalidad(nacionalidad, PAIS_NAC, Fecha_creacion,Creado_por)
VALUES (nacionalidad_, pais_nac_, SYSDATE(),usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_periodo_plan` (IN `periodo_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN
INSERT INTO tbl_periodo_plan(periodo, Fecha_creacion, Creado_por) 
VALUES (periodo_, SYSDATE(), usuario_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_personas` (IN `nombres_` VARCHAR(2555), IN `apellidos_` VARCHAR(50), IN `sexo_` VARCHAR(255), IN `identidad_` VARCHAR(255), IN `nacionalidad_` VARCHAR(50), IN `estado_civil_` VARCHAR(25), IN `fecha_nacimiento_` DATE)  BEGIN

INSERT INTO tbl_personas(nombres, apellidos, sexo, identidad, nacionalidad, estado_civil, fecha_nacimiento)
VALUES (nombres_, apellidos_, sexo_, identidad_,nacionalidad_, estado_civil_, fecha_nacimiento_);



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_persona_estudiante` (IN `numero_cuenta_` BIGINT(16), IN `nombre_` VARCHAR(255), IN `apellido_` VARCHAR(255), IN `identidad_` VARCHAR(255), IN `nacionalidad_` VARCHAR(50), IN `fecha_nacimiento_` DATE, IN `estado_civil_` VARCHAR(25), IN `sexo_` VARCHAR(255), IN `telefono_` VARCHAR(50), IN `correo_` VARCHAR(50), IN `direccion_` VARCHAR(50))  BEGIN
/*insert en tabla personas*/
SET @tpersona=(select id_tipo_persona from tbl_tipos_persona where tipo_persona='ESTUDIANTE');
insert into tbl_personas
(nombres, apellidos, identidad, nacionalidad, estado_civil, fecha_nacimiento, sexo, id_tipo_persona)
value
(
  nombre_,apellido_,  identidad_, nacionalidad_, estado_civil_,  fecha_nacimiento_, sexo_,    @tpersona
);
SET  @id_persona = (SELECT LAST_INSERT_ID());
SET  @id_atributo=(select id_atributos from tbl_atributos where atributo='numero_cuenta');
/*insert en tabla personas extendidas*/
insert into tbl_personas_extendidas(id_atributo, id_persona, valor)
value (@id_atributo,@id_persona,numero_cuenta_);
/*insert en tabla contactos telefono*/
insert into tbl_contactos
(id_persona, id_tipo_contacto, valor)
value
(@id_persona,1,telefono_);
/*insert en tabla contactos correo*/
insert into tbl_contactos
(id_persona, id_tipo_contacto, valor)
value
(@id_persona,4,correo_);
/*insert en tabla contactos direccion*/
insert into tbl_contactos
(id_persona, id_tipo_contacto, valor)
value
(@id_persona,3,direccion_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_plan_estudio` (IN `nombre_` VARCHAR(50), IN `num_clases_` INT, IN `fecha_creacion_` DATE, IN `codigo_plan_` VARCHAR(50), IN `plan_vigente_` VARCHAR(50), IN `id_tipo_plan_` BIGINT, IN `creado_por_` VARCHAR(50))  BEGIN
INSERT INTO tbl_plan_estudio(nombre, num_clases, fecha_creacion, codigo_plan, plan_vigente, id_tipo_plan,creado_por) 
VALUES (nombre_, num_clases_, fecha_creacion_, codigo_plan_, plan_vigente_, id_tipo_plan_,creado_por_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_pref_area_docen` (IN `id_area_` VARCHAR(50), IN `id_persona_` INT)  BEGIN
INSERT INTO tbl_pref_area_docen(id_area,id_persona)
VALUES (id_area_,id_persona_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_pregunta` (`preguntav` VARCHAR(150), `estadov` INTEGER, `Creado_porv` VARCHAR(200))  BEGIN
INSERT INTO  tbl_preguntas(pregunta,estado,Fecha_creacion,Creado_por)
VALUES (preguntav,estadov,sysdate(),Creado_porv);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_pregunta_usuario` (`Id_pregunta_` INTEGER, `Id_usuario_` INTEGER, `Respuesta_` VARCHAR(150))  begin
INSERT INTO  tbl_preguntas_seguridad (Id_pregunta,Id_usuario,Respuesta)
VALUES (Id_pregunta_,Id_usuario_, Respuesta_ );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_proyecto` (IN `Id_tipo_v_` BIGINT(16), IN `Id_modalidad_` BIGINT(16), IN `nombre_` VARCHAR(255), IN `codigo_proyecto_` BIGINT(16), IN `estado_` BIGINT(16), IN `beneficiarios_directos_` BIGINT(16), IN `beneficiarios_indirectos_` BIGINT(16), IN `nombre_empresa_` VARCHAR(255), IN `nombre_contacto_institucional_` VARCHAR(255), IN `cargo_contacto_institucional_` VARCHAR(255), IN `telefono_contacto_institucional_` VARCHAR(50), IN `correo_contacto_institucional_` VARCHAR(255), IN `cant_beneficiarios_` BIGINT(16), IN `fecha_inicio_ejecucion_` DATE, IN `fecha_final_ejecucion_` DATE, IN `fecha_inicio_evaluacion_` DATE, IN `fecha_final_evaluacion_` DATE, IN `costo_` INT, IN `Id_tipo_formalizacion_` BIGINT(16), IN `Id_aporte_` BIGINT(16), IN `region_` VARCHAR(255), IN `departamento_pais_` VARCHAR(255), IN `municipio_` VARCHAR(255), IN `aldea_caserio_` VARCHAR(255), IN `barrio_colonia_` VARCHAR(255), IN `entidad_beneficiaria_` VARCHAR(255), IN `objetivos_desarrollo_` VARCHAR(255), IN `objetivos_inmediatos_` VARCHAR(255), IN `resultados_` VARCHAR(255), IN `actividades_` VARCHAR(255), IN `departamento_` VARCHAR(255), IN `tipo_proyecto_` VARCHAR(255), IN `nombre_estudiante_` VARCHAR(100), IN `cargo_estudiante_` VARCHAR(100), IN `telefono_estudiante_` INT, IN `correo_estudiante_` VARCHAR(150), IN `numero_empleado_` INT, IN `direccion_estudiante_` VARCHAR(200))  BEGIN
INSERT
INTO
tbl_proyectos(
Id_tipo_v,
Id_modalidad,
nombre,
codigo_proyecto,
estado,
beneficiarios_directos,
beneficiarios_indirectos,
nombre_empresa,
nombre_contacto_institucional,
cargo_contacto_institucional,
telefono_contacto_institucional,
correo_contacto_institucional,
cant_beneficiarios,
fecha_inicio_ejecucion,
fecha_final_ejecucion,
fecha_inicio_evaluacion,
fecha_final_evaluacion,
costo,
Fecha_creación,
Id_tipo_formalizacion,
Id_aporte,
region,
departamento_pais,
municipio,
aldea_caserio,
barrio_colonia,
entidad_beneficiaria,
objetivos_desarrollo,
objetivos_inmediatos,
resultados,
actividades,
departamento,
tipo_proyecto
)
VALUES(
Id_tipo_v_,
Id_modalidad_,
nombre_,
codigo_proyecto_,
estado_,
beneficiarios_directos_,
beneficiarios_indirectos_,
nombre_empresa_,
nombre_contacto_institucional_,
cargo_contacto_institucional_,
telefono_contacto_institucional_,
correo_contacto_institucional_,
cant_beneficiarios_,
fecha_inicio_ejecucion_, 
fecha_final_ejecucion_, 
fecha_inicio_evaluacion_,
fecha_final_evaluacion_, 
costo_,
SYSDATE(), 
Id_tipo_formalizacion_, 
Id_aporte_, 
region_, 
departamento_pais_, 
municipio_, 
aldea_caserio_, 
barrio_colonia_, 
entidad_beneficiaria_, 	
objetivos_desarrollo_, 
objetivos_inmediatos_, 
resultados_, 
actividades_, 
departamento_,
tipo_proyecto_);

INSERT INTO tbl_estudiantes_proyecto(nombre_estudiante, cargo_estudiante, telefono_estudiante, 
correo_estudiante, numero_empleado, direccion_estudiante, id_proyecto)
VALUES(nombre_estudiante_, cargo_estudiante_, telefono_estudiante_, correo_estudiante_, numero_empleado_, direccion_estudiante_, (SELECT MAX(Id_proyecto)FROM tbl_proyectos));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_rol` (`n_rol` VARCHAR(150), `descripcionrol` VARCHAR(250), `estado_` INTEGER, `usuario_` VARCHAR(150))  BEGIN
INSERT INTO  tbl_roles(rol, descripcion, estado,Fecha_creacion,Creado_por)
VALUES (n_rol, descripcionrol, estado_, sysdate()
,usuario_);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_subida_informacion` (IN `id_persona_` BIGINT(16))  begin
INSERT INTO `tbl_subida_documentacion`( `id_persona`,`fecha_creacion`) VALUES (id_persona_,sysdate());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_tabla_categoria` (IN `categoria_` VARCHAR(50), IN `descripcion_` VARCHAR(50), IN `usuario_` VARCHAR(50))  BEGIN

INSERT INTO tbl_categorias(categoria, descripcion, Fecha_creacion, Creado_por)
VALUES(categoria_, descripcion_, SYSDATE(), usuario_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_tabla_comisiones` (IN `comision_` VARCHAR(50), IN `carrera_` VARCHAR(50))  BEGIN

INSERT INTO tbl_comisiones(comision, carrera)
VALUES(comision_, carrera_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_tabla_grados` (IN `grados_` VARCHAR(50), IN `descripcion_` VARCHAR(50))  BEGIN

INSERT INTO tbl_grados_academicos(grado_academico, descripcion)
VALUES(grados_, descripcion_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_telefonos` (IN `valor_` VARCHAR(50))  BEGIN 
set @idtelefonocelular:=(select id_tipo_contacto from tbl_tipo_contactos where descripcion="TELEFONO CELULAR" or descripcion="telefono celular");

INSERT INTO tbl_contactos(id_persona, id_tipo_contacto, valor)
VALUES((SELECT MAX(id_persona)FROM tbl_personas),@idtelefonocelular, valor_);


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_usuario` (`Id_persona_` BIGINT(16), `Usuario_` VARCHAR(150), `Id_rol_` INTEGER, `Contrasena_` VARCHAR(150), `creado_por_` VARCHAR(255))  BEGIN
INSERT INTO  tbl_usuarios(id_persona, usuario, Id_rol , Contrasena, estado,Fecha_creacion, Creado_por)
VALUES (Id_persona_, Usuario_ ,Id_rol_, Contrasena_,2, sysdate(), creado_por_);




end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insert_area` (IN `area_` VARCHAR(100), IN `descripcion_` VARCHAR(100))  BEGIN
INSERT INTO tbl_areas(AREA, descripcion) 
VALUES (area_, descripcion_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insert_aula_carga` (IN `codigo_` INT, IN `descripcion_` VARCHAR(50), IN `capacidad_` INT, IN `id_edificio_` INT, IN `id_tipo_aula_` INT)  BEGIN
INSERT INTO tbl_aula(codigo, descripcion, capacidad, id_edificio, id_tipo_aula) 
VALUES (codigo_, descripcion_, capacidad_, id_edificio_, id_tipo_aula_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insert_carga_academica` (IN `control_` VARCHAR(50), IN `seccion_` VARCHAR(50), IN `num_alumnos_` INT, IN `id_persona_` BIGINT, IN `id_aula_` BIGINT, IN `id_asignatura_` BIGINT, IN `dias_` VARCHAR(50), IN `id_modalidad_` BIGINT, IN `hora_inicial_` VARCHAR(50), IN `hora_final_` VARCHAR(50))  BEGIN
INSERT INTO tbl_carga_academica(control, seccion, num_alumnos, id_persona, id_aula, id_asignatura, id_periodo, dias, id_modalidad, hora_inicial, hora_final) 
VALUES (control_, seccion_, num_alumnos_, id_persona_, id_aula_, id_asignatura_, (SELECT MAX(id_periodo)FROM tbl_periodo), dias_, id_modalidad_, hora_inicial_, hora_final_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insert_carga_virtual` (IN `control_` VARCHAR(50), IN `seccion_` VARCHAR(50), IN `num_alumnos_` INT, IN `id_persona_` BIGINT, IN `id_asignatura_` BIGINT, IN `dias_` VARCHAR(50), IN `id_modalidad_` BIGINT, IN `hora_inicial_` VARCHAR(50), IN `hora_final_` VARCHAR(50))  BEGIN
INSERT INTO tbl_carga_academica(control, seccion, num_alumnos, id_persona, id_asignatura, id_periodo, dias, id_modalidad, hora_inicial, hora_final) 
VALUES (control_, seccion_, num_alumnos_, id_persona_, id_asignatura_, (SELECT MAX(id_periodo)FROM tbl_periodo), dias_, id_modalidad_, hora_inicial_, hora_final_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insert_edifico_carga` (IN `nombre_` VARCHAR(50), IN `codigo_` VARCHAR(50))  BEGIN
INSERT INTO tbl_edificios(nombre, codigo) 
VALUES (nombre_, codigo_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insert_exp_area_docen` (IN `id_area_` BIGINT, IN `id_persona_` BIGINT)  BEGIN
INSERT INTO tbl_expe_academica_docente(id_area,id_persona)
VALUES (id_area_,id_persona_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insert_periodo_carga` (IN `num_periodo_` INT, IN `num_anno_` YEAR, IN `fecha_inicio_` DATE, IN `fecha_final_` DATE, IN `usuario_` VARCHAR(50), IN `id_tipo_periodo_` INT, IN `fecha_adic_canc_` DATE, IN `fecha_desbloqueo_` DATE)  BEGIN
INSERT INTO tbl_periodo(num_periodo, num_anno, fecha_inicio, fecha_final, Fecha_creacion,Creado_por, id_tipo_periodo, fecha_adic_canc, fecha_desbloqueo) 
VALUES (num_periodo_, num_anno_, fecha_inicio_, fecha_final_, SYSDATE(),usuario_, id_tipo_periodo_, fecha_adic_canc_, fecha_desbloqueo_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_ins_personas` (IN `nombre_` VARCHAR(255), IN `apellido_` VARCHAR(255), IN `sexo_` VARCHAR(255), IN `identidad_` VARCHAR(255), IN `nacionalidad_` VARCHAR(50), IN `estado_civil_` VARCHAR(25), IN `fecha_nacimiento_` DATE, IN `tipo_persona_` INT, IN `telefono_` VARCHAR(50), `correo_` VARCHAR(50), IN `direccion_` VARCHAR(50))  BEGIN
INSERT INTO tbl_personas(nombres, apellidos, sexo, identidad, nacionalidad, estado_civil, fecha_nacimiento, id_tipo_persona)
VALUES(nombre_, apellido_, sexo_, identidad_, nacionalidad_, estado_civil_, fecha_nacimiento_, tipo_persona_);   

SET @id_persona=(last_insert_id()); 
SET @id_telefono=(SELECT id_tipo_contacto FROM tbl_tipo_contactos WHERE descripcion = 'TELEFONO CELULAR');
SET @id_correo=(SELECT id_tipo_contacto FROM tbl_tipo_contactos WHERE descripcion = 'CORREO');
SET @id_direccion=(SELECT id_tipo_contacto FROM tbl_tipo_contactos WHERE descripcion = 'DIRECCION');
/*INSERTAR TELEFONO */
INSERT INTO tbl_contactos(id_persona, id_tipo_contacto, valor)
VALUES(@id_persona, @id_telefono, telefono_);
/*INSERTAR CORREO */
INSERT INTO tbl_contactos(id_persona, id_tipo_contacto, valor)
VALUES(@id_persona, @id_correo, correo_);
/*INSERTAR DIRECCION */
INSERT INTO tbl_contactos(id_persona, id_tipo_contacto, valor)
VALUES(@id_persona, @id_direccion, direccion_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_modificar_gestion` (IN `valor1_` VARCHAR(50), IN `valor_` VARCHAR(50), IN `identidad_` VARCHAR(50), IN `id_jornada_` INT, IN `id_categoria_` INT, IN `hr_inicial_` VARCHAR(50), IN `hr_final_` VARCHAR(50), IN `id_persona_` INT)  BEGIN
UPDATE tbl_horario_docentes hd
INNER JOIN tbl_categoria_personas cp ON cp.id_persona=hd.id_persona
INNER JOIN tbl_personas p ON p.id_persona=hd.id_persona
INNER JOIN tbl_personas_extendidas pe ON pe.id_persona=hd.id_persona AND pe.id_atributo=1
INNER JOIN tbl_personas_extendidas pe1 ON pe1.id_persona=hd.id_persona AND pe1.id_atributo=14
SET 
pe1.valor= valor1_,
pe.valor=valor_,
p.identidad=identidad_,
hd.id_jornada=id_jornada_, cp.id_categoria=id_categoria_, 
hr_inicial=hr_inicial_, hr_final=hr_final_ WHERE hd.id_persona=id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_modificar_horas` (IN `horas_semanales_` VARCHAR(50), IN `id_actividad_` INT)  BEGIN
UPDATE tbl_actividades SET horas_semanales=horas_semanales_
WHERE id_actividad=id_actividad_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_prueba_api` (IN `id_actividad_` INT, IN `id_persona_` INT)  BEGIN
INSERT INTO tbl_actividades_persona(id_actividad, id_persona)
VALUES(id_actividad_,id_persona_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_sel_actividad` (IN `actividad_` VARCHAR(50))  BEGIN
SELECT ac.id_actividad, c.comision, ac.actividad, ac.horas_semanales
FROM tbl_comisiones c
INNER JOIN tbl_personas p 
INNER JOIN tbl_usuarios u ON u.id_persona=p.id_persona
inner JOIN tbl_actividades ac ON ac.id_comisiones=c.id_comisiones
INNER JOIN tbl_actividades_persona ap ON ac.id_actividad=ap.id_actividad and u.id_persona=ap.id_persona
WHERE ac.actividad= actividad_ AND u.Id_usuario=8;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_sel_actividad_docente` (IN `id_persona_` BIGINT)  BEGIN
SELECT ACTP.id_actividad, COM.comision, ACT.actividad  FROM tbl_actividades ACT
JOIN tbl_actividades_persona ACTP ON ACT.id_actividad= ACTP.id_actividad
JOIN tbl_comisiones COM ON COM.id_comisiones = ACT.id_comisiones
WHERE ACTP.id_persona = id_persona_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_sel_tabla_historial` ()  BEGIN
SELECT p.id_periodo, num_periodo,p.num_anno,count(id_carga_academica) AS total_carga FROM tbl_periodo p JOIN tbl_carga_academica ca ON ca.id_periodo=p.id_periodo 
GROUP BY(p.id_periodo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_update_periodo_carga` (IN `num_periodo_` INT, IN `num_anno_` INT, IN `fecha_inicio_` DATE, IN `fecha_final_` DATE, IN `Usuario_` VARCHAR(50), IN `id_periodo_` INT)  BEGIN

UPDATE tbl_periodo SET  num_periodo= num_periodo_,  num_anno=num_anno_, fecha_inicio=fecha_inicio_, fecha_final=fecha_final_, 
Fecha_modificacion=sysdate() , Modificado_por=Usuario_ WHERE id_periodo= id_periodo_ ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_update_personas` (IN `nombre_` VARCHAR(255), IN `apellido_` VARCHAR(255), IN `identidad_` VARCHAR(255), IN `nacionalidad_` VARCHAR(50), IN `estado_civil_` VARCHAR(25), IN `telefono_` VARCHAR(50), `correo_` VARCHAR(50), IN `direccion_` VARCHAR(50), IN `id_persona_` BIGINT(16))  BEGIN
UPDATE tbl_personas SET nombres=nombre_, 
						apellidos=apellido_,
						identidad=identidad_,
                        nacionalidad=nacionalidad_,
                        estado_civil=estado_civil_
                        WHERE id_persona=id_persona_;
                        
SET @id_telefono=(SELECT id_tipo_contacto FROM tbl_tipo_contactos WHERE descripcion = 'TELEFONO CELULAR');
SET @id_correo=(SELECT id_tipo_contacto FROM tbl_tipo_contactos WHERE descripcion = 'CORREO');
SET @id_direccion=(SELECT id_tipo_contacto FROM tbl_tipo_contactos WHERE descripcion = 'DIRECCION');

UPDATE tbl_contactos SET valor=telefono_
WHERE id_persona=id_persona_ AND id_tipo_contacto=@id_telefono;

UPDATE tbl_contactos SET valor=correo_
WHERE id_persona=id_persona_ AND id_tipo_contacto=@id_correo;

UPDATE tbl_contactos SET valor=direccion_
WHERE id_persona=id_persona_ AND id_tipo_contacto=@id_direccion;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_verificar_carga_modificar` (IN `hora_inicial_` VARCHAR(4), IN `id_aula_` BIGINT, IN `id_periodo_` BIGINT, IN `hora_final_` BIGINT)  BEGIN
SELECT COUNT(id_carga_academica) as registro FROM tbl_carga_academica WHERE hora_inicial= hora_inicial_ AND id_aula=id_aula_
AND id_periodo=id_periodo_ AND hora_final=hora_final_ LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_verificar_nombre_plan` (IN `nombre_` VARCHAR(50))  BEGIN
SELECT COUNT(id_plan_estudio) as registro FROM tbl_plan_estudio WHERE nombre = nombre_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_verificar_plan_activo` (IN `opcion_` VARCHAR(50))  BEGIN
SELECT COUNT(id_plan_estudio) as registro FROM tbl_plan_estudio WHERE plan_vigente = opcion_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_verifica_carga_crear` (IN `hora_inicial_` INT, IN `id_periodo_` INT, IN `hora_final_` INT, IN `id_aula_` INT)  BEGIN
SELECT COUNT(id_carga_academica) as registro FROM tbl_carga_academica WHERE hora_inicial = hora_inicial_
AND id_periodo = id_periodo_ AND hora_final = hora_final_ AND id_aula = id_aula_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_verifica_periodo` (IN `fecha_inicio_` DATE, IN `fecha_final_` DATE)  BEGIN
SELECT fecha_inicio, fecha_final FROM tbl_periodo WHERE fecha_inicio >= fecha_inicio_ AND fecha_final <= fecha_final_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_insertar_permisos` (`Id_rol_` INTEGER, `Id_objeto_` INTEGER, `Insertar_` INTEGER, `Modificar_` INTEGER, `Eliminar_` INTEGER, `Visualizar_` INTEGER, `Creado_por_` VARCHAR(150))  BEGIN
INSERT INTO  tbl_permisos_usuarios(Id_rol, Id_objeto, Insertar , Modificar, Eliminar, Visualizar,Fecha_creacion,Creado_por)
VALUES (Id_rol_, Id_objeto_, Insertar_ , Modificar_, Eliminar_, Visualizar_, sysdate(),Creado_por_);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_alumnos_himno` ()  BEGIN
START TRANSACTION;
SELECT e.nombre_completo,e.numero_cuenta,e.correo_electronico
FROM tbl_usuarios e, tbl_carta_egresado f
WHERE e.Id_usuario = f.Id_usuario
AND
f.aprobado = 'aprobado';
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_actividad` (IN `actividad_` VARCHAR(50))  SELECT ac.id_actividad, c.comision, ac.actividad, ac.horas_semanales
FROM tbl_comisiones c
INNER JOIN tbl_personas p 
INNER JOIN tbl_usuarios u ON u.id_persona=p.id_persona
inner JOIN tbl_actividades ac ON ac.id_comisiones=c.id_comisiones
INNER JOIN tbl_actividades_persona ap ON ac.id_actividad=ap.id_actividad and u.id_persona=ap.id_persona
 WHERE ac.actividad= actividad_ AND u.Id_usuario=8$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_actividades_personas` (IN `persona_` INT, IN `actividad_` INT)  BEGIN
SELECT id_persona, id_actividad FROM tbl_actividades_persona
WHERE id_persona = persona_ AND id_actividad = actividad_ ;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_area_pref_doce` (IN `id_persona_` BIGINT)  BEGIN
SELECT id_pref_area_doce,
(SELECT a.area FROM tbl_areas AS a WHERE a.id_area = tbl_pref_area_docen.id_area LIMIT 8) area_docente
FROM tbl_pref_area_docen
WHERE id_persona = id_persona_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_asignaturas_ca` ()  begin
SELECT *
from tbl_asignaturas
commit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_aula_ca` ()  BEGIN

SELECT tbl_aula.id_aula, tbl_aula.codigo, tbl_aula.descripcion, tbl_aula.capacidad,

(SELECT edif.nombre FROM tbl_edificios AS edif INNER JOIN  tbl_aula AS aula ON edif.id_edificio = aula.id_aula LIMIT 1) AS nombre,
(SELECT edif.id_edificio FROM tbl_edificios AS edif LIMIT 1) AS id_edificio,
(SELECT tp.id_tipo_aula FROM tbl_tipo_aula AS tp LIMIT 1) AS id_tipo_aula,
(SELECT tp.tipo_aula FROM tbl_tipo_aula AS tp INNER JOIN tbl_tipo_aula AS ta ON tp.id_tipo_aula=ta.id_tipo_aula LIMIT 1) AS tipo_aula

FROM tbl_aula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_campos_carga` ()  BEGIN
SELECT tbl_carga_academica.id_carga_academica,
(SELECT tbl_carga_academica.control),
(SELECT tbl_carga_academica.seccion),
(SELECT tbl_carga_academica.hra_inicio),
(select tbl_carga_academica.hra_final),
(SELECT tbl_carga_academica.num_alumnos)
FROM tbl_carga_academica;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_carga_historial_ca` (IN `num_anno_` INT, IN `num_periodo_` INT)  BEGIN
SET @STRING = (SELECT id_periodo FROM tbl_periodo WHERE num_periodo = num_periodo_  AND num_anno = num_anno_);


SELECT tbl_carga_academica.id_carga_academica AS id_carga_academica,
(SELECT pe.valor FROM tbl_personas_extendidas AS pe WHERE pe.id_persona = tbl_carga_academica.id_persona AND id_atributo = 1 LIMIT 1) AS num_empleado,	
(SELECT CONCAT(p.nombres,' ', p.apellidos) nombres FROM tbl_personas p WHERE p.id_persona = tbl_carga_academica.id_persona LIMIT 1) AS nombres,
(SELECT id_persona FROM tbl_personas p where p.id_persona = tbl_carga_academica.id_persona LIMIT 1 )as id_persona,
(SELECT tbl_carga_academica.control) AS control,
(SELECT a.codigo FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS codigo,
(SELECT a.asignatura FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS asignatura,
(SELECT a.id_asignatura FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS id_asignatura,
(SELECT tbl_carga_academica.seccion) AS seccion,
(SELECT tbl_carga_academica.hora_inicial) AS hra_inicio,
(select tbl_carga_academica.hora_final) AS hra_final,
(SELECT a.codigo FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS aula,
(SELECT a.id_aula FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS id_aula,
        
(SELECT a.id_edificio FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS id_edificio,
        
(SELECT e.nombre FROM tbl_edificios AS e INNER JOIN tbl_aula AS au ON e.id_edificio=au.id_edificio
       WHERE au.id_aula=tbl_carga_academica.id_aula  LIMIT 1) AS edificio,
(SELECT tbl_carga_academica.num_alumnos) AS  num_alumnos,
(SELECT tbl_carga_academica.dias) AS dia

FROM tbl_carga_academica WHERE id_periodo = @STRING;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_carga_id_periodo_nuevo` (IN `id_periodo_` BIGINT)  BEGIN
SELECT COUNT(id_carga_academica) AS suma FROM tbl_carga_academica WHERE id_periodo=id_periodo_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_carta_presentacion` (IN `cod_empresa` BIGINT)  begin
select ep.cod_empresa,  ep.nombre
,ep.contacto_interno, ep.puesto,
ep.grado_academico, e.nombre, e.numero_cuenta
from empresas ep, estudiantes e
where  cp.cod_estudiante= e.cod_estudiante
group by cp.cod_estudiante;
commit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_comisiones_reporte` (IN `Id_usuario_` BIGINT)  BEGIN
SELECT tac.id_actividad, tcom.comision, tac.actividad, tac.horas_semanales
FROM tbl_personas tp
INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona
INNER JOIN tbl_comisiones tcom
INNER JOIN tbl_actividades tac on tcom.id_comisiones = tac.id_comisiones
INNER JOIN tbl_actividades_persona tap on tac.id_actividad = tap.id_actividad and us.id_persona=tap.id_persona
WHERE us.Id_usuario = Id_usuario_  and tp.id_tipo_persona = 1;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_constancia_clases` (IN `cod_estudiante` BIGINT)  begin
select e.cod_estudiante,  e.nombres
,e.apellidos,e.numero_cuenta, cp.clases_aprobadas,
cp.porcentaje_clases
from charla_practica cp, estudiantes e
where  cp.cod_estudiante= e.cod_estudiante
group by cp.cod_estudiante;
commit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_datos_usuario` (IN `usuario_` VARCHAR(255))  BEGIN
set @id_persona=(select id_persona from tbl_personas_extendidas where valor=usuario_);
select id_usuario,id_persona,usuario, estado from tbl_usuarios where id_persona=@id_persona;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_docente_ca` ()  begin
SELECT id_persona,nombres,apellidos
from tbl_personas
WHERE id_tipo_persona = 1;
COMMIT;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_editar_ca` ()  BEGIN
SELECT tbl_carga_academica.id_carga_academica AS id,tbl_carga_academica.control AS control,
(SELECT a.codigo FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS codigo,
(SELECT a.asignatura FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS asignatura,
(SELECT tbl_carga_academica.seccion) AS seccion,
(SELECT tbl_carga_academica.hra_inicio) AS hra_inicio,
(select tbl_carga_academica.hra_final) AS hra_final,
(SELECT d.dia FROM tbl_dias AS d INNER JOIN  tbl_carga_dias AS cd ON d.id_dia = cd.id_dia
        WHERE cd.id_carga_academica = tbl_carga_academica.id_carga_academica LIMIT 1) AS dia,
(SELECT a.codigo FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS aula,
(SELECT e.nombre FROM tbl_edificios AS e INNER JOIN tbl_aula AS au ON e.id_edificio=au.id_edificio
       WHERE au.id_aula=tbl_carga_academica.id_aula  LIMIT 1) AS edificio,
(SELECT tbl_carga_academica.num_alumnos) AS  num_alumnos
FROM tbl_carga_academica
WHERE id_persona = 18;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_estudiante_charla` (IN `cod_charla` BIGINT)  begin
select cp.cod_charla, cp.no_constancia
,e.numero_cuenta, e.nombres
,e.apellidos, cp.fecha_valida,
cp.fecha_recibida, d.cod_docente,
d.nombres, d.apellidos
from charla_practica cp, docentes d,
estudiantes e
where  cp.cod_estudiante= e.cod_estudiante
and cp.cod_docente= d.cod_docente
group by cp.cod_charla;
commit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_existe_usuario` (IN `usuario_` VARCHAR(255), IN `contraseña_` VARCHAR(255))  BEGIN
set @id_persona=(select id_persona from tbl_personas_extendidas where valor=usuario_);
select count(p.valor) as usuario  from tbl_usuarios u, tbl_personas_extendidas p where u.id_persona=@id_persona and p.id_persona and p.valor=usuario_;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_gestion_ca` ()  BEGIN
SELECT tbl_carga_academica.id_carga_academica AS id_carga_academica,
(SELECT pe.valor FROM tbl_personas_extendidas AS pe WHERE pe.id_persona = tbl_carga_academica.id_persona AND id_atributo = 1 LIMIT 1) AS num_empleado,	
(SELECT CONCAT(p.nombres,' ', p.apellidos) nombres FROM tbl_personas p WHERE p.id_persona = tbl_carga_academica.id_persona LIMIT 1) AS nombres,
(SELECT id_persona FROM tbl_personas p where p.id_persona = tbl_carga_academica.id_persona LIMIT 1 )as idpersona,
(SELECT tbl_carga_academica.control) AS control,
(SELECT a.codigo FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS codigo,
(SELECT a.asignatura FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS asignatura,
(SELECT a.id_asignatura FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS id_asignatura,

(SELECT a.uv FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS unidades_valorativas,

(SELECT tbl_carga_academica.seccion) AS seccion,
(SELECT tbl_carga_academica.hora_inicial) AS hra_inicio,
(select tbl_carga_academica.hora_final) AS hra_final,
(SELECT a.codigo FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS aula,
(SELECT a.id_aula FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS id_aula,
        
(SELECT a.id_edificio FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS id_edificio,
        
(SELECT e.nombre FROM tbl_edificios AS e INNER JOIN tbl_aula AS au ON e.id_edificio=au.id_edificio
       WHERE au.id_aula=tbl_carga_academica.id_aula  LIMIT 1) AS edificio,
       
(SELECT tbl_carga_academica.num_alumnos) AS  num_alumnos,
(SELECT tbl_carga_academica.num_alumnos) AS  num_alumnos,
(SELECT tbl_carga_academica.dias) AS dia,
(SELECT m.modalidad FROM tbl_modalidad AS m INNER JOIN tbl_carga_academica AS ca ON m.id_modalidad=ca.id_modalidad 
			WHERE m.id_modalidad = tbl_carga_academica.id_modalidad LIMIT 1) AS modalidad,
(SELECT m.id_modalidad FROM tbl_modalidad AS m INNER JOIN tbl_carga_academica AS ca ON m.id_modalidad=ca.id_modalidad 
			WHERE m.id_modalidad = tbl_carga_academica.id_modalidad LIMIT 1) AS id_modalidad

FROM tbl_carga_academica WHERE id_periodo = (SELECT MAX(id_periodo)FROM tbl_periodo);


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_gestion_plan_estudio` ()  BEGIN
SELECT tbl_plan_estudio.id_plan_estudio AS id_plan_estudio,

(SELECT tp.nombre FROM tbl_tipo_plan tp WHERE tp.id_tipo_plan = tbl_plan_estudio.id_tipo_plan LIMIT 1) AS nombre_tipo_plan,
(SELECT tbl_plan_estudio.nombre) AS  nombre_plan,
(SELECT tbl_plan_estudio.num_clases) AS  num_clases,
(SELECT tbl_plan_estudio.codigo_plan) AS codigo_plan,
(SELECT tbl_plan_estudio.plan_vigente) AS plan_vigente,
(SELECT tbl_plan_estudio.id_tipo_plan) AS id_tipo_plan


FROM tbl_plan_estudio;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_himno` (IN `jornada` VARCHAR(255))  BEGIN
SELECT p.nombre,p.documento, c.valor, h.fecha, h.hora
from tbl_personas p, tbl_contactos c,tbl_alumnos_himno ah,tbl_horario_himno h,tbl_tipo_contactos t
WHERE p.id_persona = c.id_persona
AND ah.id_persona = p.id_persona
AND ah.id_horario_himno = h.id_horario_himno
AND h.jornada  = jornada
AND ah.aprobado !='aprobado'
AND t.descripcion ='CORREO'
AND t.id_tipo_contacto= c.id_tipo_contacto;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_himno_unica` (IN `numero_cuenta` BIGINT(25))  BEGIN
SELECT p.nombre,p.documento,c.valor
FROM tbl_personas p, tbl_contactos c
WHERE  p.documento = numero_cuenta
AND c.id_persona = p.id_persona
AND c.id_tipo_contacto = 4;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_historial_plan_estudio` ()  BEGIN
SELECT plan.id_plan_estudio, plan.nombre, plan.codigo_plan, plan.num_clases, plan.fecha_creacion, plan.plan_vigente
FROM tbl_plan_estudio plan 
WHERE plan.plan_vigente = 'NO'; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_asignatura_ca` (IN `id_asignatura_` INT)  BEGIN
SELECT Id_asignatura AS id_a, asignatura AS asig, codigo AS codA, uv AS uv FROM tbl_asignaturas WHERE Id_asignatura = id_asignatura_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_dia_ca` (IN `id_dia_` INT)  BEGIN
SELECT Id_dia, dia FROM tbl_dias WHERE Id_dia = id_dia_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_edificio` (IN `id_edificio_` INT)  BEGIN
SELECT id_edificio, nombre FROM tbl_edificios WHERE id_edificio = id_edificio_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_estado_civil_ca` (IN `id_estado_civil_` INT)  BEGIN
SELECT id_estado_civil FROM tbl_estadocivil WHERE id_estado_civil = id_estado_civil_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_genero_ca` (IN `id_genero_` INT)  BEGIN
SELECT id_genero FROM tbl_genero WHERE id_genero = id_genero_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_hora_ca` (IN `hora_` INT)  BEGIN
SELECT hora FROM tbl_hora WHERE hora = hora_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_jornada` (IN `id_jornada_` VARCHAR(50))  BEGIN
SELECT id_jornada FROM tbl_jornadas WHERE id_jornada = id_jornada_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_modalidad_ca` (IN `id_modalidad_` INT)  BEGIN
SELECT id_modalidad, modalidad FROM tbl_modalidad WHERE id_modalidad = id_modalidad_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_periodo_ca` (IN `num_anno_` INT, IN `num_periodo_` INT)  BEGIN
SELECT id_periodo FROM tbl_periodo WHERE num_anno=num_anno_ AND num_periodo=num_periodo_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_id_tipo_periodo` (IN `id_periodo_` INT)  BEGIN
SELECT descripcion FROM tbl_tipo_periodo WHERE id_periodo = id_periodo_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_jornada_docente` (IN `id_jornada_` BIGINT)  BEGIN
SELECT jornada FROM tbl_jornadas WHERE id_jornada = id_jornada_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_modal_ca` (IN `id_persona_` BIGINT)  BEGIN

set @idnumero_empleado=(select id_atributos from tbl_atributos where atributo="numero_empleado" or atributo="NUMERO_EMPLEADO");

select DISTINCT tp.id_persona, concat(tp.nombres," ",tp.apellidos) as "nombre",tpx1.valor as numero_empleado,(select GROUP_CONCAT( DISTINCT concat(tga.grado_academico,": ",teg.especialidad," \n")) from tbl_personas tp5, tbl_especialidad_grado teg, tbl_grados_academicos tga,tbl_grados_academicos_personas tgap where tgap.id_persona=tp5.id_persona and tgap.id_persona=tp.id_persona and tgap.id_especialidad=teg.id_especialidad and tga.id_grado_academico=teg.id_grado_academico ) as formacion_academica,
tj.jornada as Jornada,tca.categoria as Categoria,thd.hr_inicial as 'Hora_Entrada', thd.hr_final as 'Hora_Salida',

(SELECT IFNULL(GROUP_CONCAT(a.area SEPARATOR ', '), '') FROM tbl_areas AS a 
JOIN tbl_pref_area_docen on a.id_area = tbl_pref_area_docen.id_area) AS pregunta1,

(SELECT  IFNULL(GROUP_CONCAT(a.area SEPARATOR ', '), '') FROM tbl_areas AS a 
JOIN tbl_expe_academica_docente on a.id_area = tbl_expe_academica_docente.id_area) AS pregunta2,

(SELECT  IFNULL(GROUP_CONCAT(a.asignatura SEPARATOR ', '), '') FROM tbl_asignaturas AS a 
JOIN tbl_pref_asig_docen on a.Id_asignatura = tbl_pref_asig_docen.Id_asignatura) AS pregunta3,

(SELECT IFNULL(GROUP_CONCAT(a.asignatura SEPARATOR ', '), '') FROM tbl_asignaturas AS a 
JOIN tbl_desea_asig_doce on a.Id_asignatura = tbl_desea_asig_doce.Id_asignatura) AS pregunta4

from tbl_personas tp

JOIN tbl_personas_extendidas tpx1 on tp.id_persona=tpx1.id_persona
JOIN tbl_atributos ta1 on tpx1.id_atributo=ta1.id_atributos and @idnumero_empleado=ta1.id_atributos
JOIN tbl_horario_docentes thd on tp.id_persona=thd.id_persona
JOIN tbl_jornadas tj on thd.id_jornada = tj.id_jornada
JOIN tbl_categoria_personas tcap on tp.id_persona = tcap.id_persona
JOIN tbl_categorias tca on tcap.id_categoria = tca.id_categoria
JOIN tbl_comisiones tcom
JOIN tbl_areas tas
JOIN tbl_actividades tac on tcom.id_comisiones = tac.id_comisiones
JOIN tbl_actividades_persona tap on tac.id_actividad = tap.id_actividad and tp.id_persona=tap.id_persona
where ta1.id_atributos = tpx1.id_atributo  and tp.id_persona = id_persona_;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_municipio` ()  BEGIN
SELECT tbl_municipios_hn.id_municipio AS id_municipio,tbl_municipios_hn.municipio AS municipio,tbl_municipios_hn.codigo AS codigo,
(SELECT d.departamento FROM tbl_departamentos d WHERE d.id_departamento= tbl_municipios_hn.id_departamento LIMIT 1) AS departamento
FROM tbl_municipios_hn;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_periodo_ca` ()  BEGIN
SELECT id_periodo, num_periodo, num_anno FROM tbl_periodo;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_reporte_carga` (IN `id_periodo_` BIGINT)  SELECT tbl_carga_academica.id_carga_academica AS id_carga_academica,	
(SELECT p.nombres FROM tbl_personas p WHERE p.id_persona = tbl_carga_academica.id_persona LIMIT 1) AS nombres,
(SELECT tbl_carga_academica.control) AS control,
(SELECT a.codigo FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS codigo,
(SELECT a.asignatura FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS asignatura,
(SELECT tbl_carga_academica.seccion) AS seccion,
(SELECT tbl_carga_academica.hora_inicial) AS hra_inicio,
(select tbl_carga_academica.hora_final) AS hra_final,
(SELECT tbl_carga_academica.dias LIMIT 1) AS dia,
(SELECT a.codigo FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS aula,
(SELECT e.nombre FROM tbl_edificios AS e INNER JOIN tbl_aula AS au ON e.id_edificio=au.id_edificio
       WHERE au.id_aula=tbl_carga_academica.id_aula  LIMIT 1) AS edificio,
(SELECT tbl_carga_academica.num_alumnos) AS  num_alumnos
FROM tbl_carga_academica WHERE id_periodo=id_periodo_$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_reporte_docente` (IN `Id_persona_` BIGINT)  BEGIN
SELECT tbl_carga_academica.id_carga_academica AS id,tbl_carga_academica.control AS control,
(SELECT a.codigo FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS codigo,
(SELECT a.asignatura FROM tbl_asignaturas a WHERE a.Id_asignatura = tbl_carga_academica.id_asignatura LIMIT 1) AS asignatura,
(SELECT tbl_carga_academica.seccion) AS seccion,
(SELECT tbl_carga_academica.hora_inicial) AS hra_inicial,
(select tbl_carga_academica.hora_final) AS hra_final,
(SELECT tbl_carga_academica.dias) AS dia,
(SELECT a.codigo FROM tbl_aula AS a INNER JOIN tbl_tipo_aula AS ta ON a.id_tipo_aula=ta.id_tipo_aula
        WHERE a.id_aula = tbl_carga_academica.id_aula LIMIT 1) AS aula,
(SELECT e.nombre FROM tbl_edificios AS e INNER JOIN tbl_aula AS au ON e.id_edificio=au.id_edificio
       WHERE au.id_aula=tbl_carga_academica.id_aula  LIMIT 1) AS edificio,
(SELECT tbl_carga_academica.num_alumnos) AS  num_alumnos

FROM tbl_carga_academica
WHERE id_persona = Id_persona_;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_simultanea` (IN `tipo` VARCHAR(255))  BEGIN
SELECT p.nombre, p.documento, c.valor, cc.razon_cambio
FROM tbl_personas p, tbl_cambio_carrera cc, tbl_contactos c, tbl_tipo_contactos t
WHERE cc.id_persona = p.id_persona
AND cc.tipo = tipo
AND cc.aprobado != 'aprobado'
AND t.id_tipo_contacto = 4
AND c.id_persona = p.id_persona
GROUP BY p.nombre;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_tipo_aula_carga` (IN `id_tipo_aula_` INT)  BEGIN
SELECT id_tipo_aula, tipo_aula FROM tbl_tipo_aula WHERE id_tipo_aula = id_tipo_aula_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_cambio_carrera` (IN `APROBADO` VARCHAR(50), IN `ncuenta` BIGINT(20), IN `tipo` VARCHAR(50))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona
FROM tbl_personas
WHERE documento = ncuenta;
UPDATE `tbl_cambio_carrera`
SET `aprobado` = APROBADO,
`fecha_creacion` = now()
WHERE id_persona = @id_persona
AND tipo = tipo;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_cambio_carrera_observacion` (IN `APROBADO` VARCHAR(50), IN `OBSERVACION` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona
FROM tbl_personas
WHERE documento = ncuenta;
UPDATE `tbl_cambio_carrera`
SET `aprobado`        = APROBADO,
`observacion`     = OBSERVACION,
`fecha_creacion`  = now()
WHERE id_persona = @id_persona;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_equivalencias` (IN `APROBADO` VARCHAR(50), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona
FROM tbl_personas
WHERE documento = ncuenta;
UPDATE `tbl_equivalencias`
SET `aprobado` = APROBADO,
`fecha_creacion` = now()
WHERE id_persona = @id_persona;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_equivalencias_observacion` (IN `APROBADO` VARCHAR(50), IN `OBSERVACION` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona
FROM tbl_personas
WHERE documento = ncuenta;
UPDATE `tbl_equivalencias`
SET `aprobado` = APROBADO,
`observacion`     = OBSERVACION,
`fecha_creacion`  = now()
WHERE id_persona = @id_persona;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_finalizacion_practica_observacion` (IN `aprobado` VARCHAR(255), IN `observacion` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;
SELECT @id_persona := id_persona
FROM tbl_personas
WHERE documento = ncuenta;
UPDATE `tbl_finalizacion_practica`
SET `aprobado`        = APROBADO,
`observacion`     = OBSERVACION,
`fecha_creacion`  = now()
WHERE id_persona = @id_persona;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_himno` (IN `aprobado` VARCHAR(255), IN `ncuenta` BIGINT(20), IN `jornada` VARCHAR(255))  BEGIN
START TRANSACTION;
SELECT @id_persona := p.id_persona,  @id_horario := hh.id_horario_himno
FROM tbl_personas p, tbl_horario_himno hh
WHERE p.documento = ncuenta
AND hh.jornada = jornada;
UPDATE `tbl_alumnos_himno`
SET `aprobado` = aprobado,
`fecha_creacion` = now()
WHERE id_persona = @id_persona
AND id_horario_himno = @id_horario ;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_finalizar` (IN `usuario` INT)  BEGIN
IF usuario = 1 THEN
SELECT * FROM vista_actividad_cve_2;
ELSE
SELECT * FROM vista_actividad_cve_2 WHERE id_usuario_registro = usuario;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_horas` (IN `usuario` VARCHAR(255))  BEGIN
set @valor = (select tbl_personas_extendidas.valor from tbl_usuarios JOIN tbl_personas_extendidas on tbl_usuarios.id_persona=tbl_personas_extendidas.id_persona where Id_usuario = usuario);

IF usuario = 1 THEN
select `automatizacion`.`tbl_voae_asistencias`.`id_asistencia` AS `id_asistencia`,`automatizacion`.`tbl_voae_asistencias`.`cuenta` AS `cuenta`,`automatizacion`.`tbl_voae_asistencias`.`nombre_alumno` AS `nombre_alumno`,count(`automatizacion`.`tbl_voae_asistencias`.`id_actividad_voae`) AS `total_actividades`,sum(`automatizacion`.`tbl_voae_asistencias`.`cant_horas`) AS `total_horas` from `automatizacion`.`tbl_voae_asistencias` where `automatizacion`.`tbl_voae_asistencias`.`carrera` like '%tica Administrativa%' group by `automatizacion`.`tbl_voae_asistencias`.`cuenta`;
ELSE 
select `automatizacion`.`tbl_voae_asistencias`.`id_asistencia` AS `id_asistencia`,`automatizacion`.`tbl_voae_asistencias`.`cuenta` AS `cuenta`,`automatizacion`.`tbl_voae_asistencias`.`nombre_alumno` AS `nombre_alumno`,count(`automatizacion`.`tbl_voae_asistencias`.`id_actividad_voae`) AS `total_actividades`,sum(`automatizacion`.`tbl_voae_asistencias`.`cant_horas`) AS `total_horas` from `automatizacion`.`tbl_voae_asistencias` where `automatizacion`.`tbl_voae_asistencias`.`carrera` like '%tica Administrativa%' and `automatizacion`.`tbl_voae_asistencias`.`cuenta` = @valor 
group by `automatizacion`.`tbl_voae_asistencias`.`cuenta`;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_informes` (IN `id_usuario` INT)  BEGIN
IF id_usuario = 1 THEN
SELECT * FROM view_informes_actividades;
ELSE
SELECT * FROM view_informes_actividades WHERE id_usuario_registro = id_usuario;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vista_solicitud` (IN `usuario` INT)  BEGIN
IF usuario = 1 THEN
SELECT * FROM vista_actividad_cve;
ELSE
SELECT * FROM vista_actividad_cve WHERE id_usuario_registro = 
usuario;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_actividades`
--

CREATE TABLE `tbl_actividades` (
  `id_actividad` int(11) NOT NULL,
  `actividad` varchar(150) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `nombre_proyecto` varchar(50) DEFAULT NULL,
  `horas_semanales` varchar(50) DEFAULT NULL,
  `id_comisiones` int(11) NOT NULL,
  `Fecha_creacion` date DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificación` date DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_actividades`
--

INSERT INTO `tbl_actividades` (`id_actividad`, `actividad`, `descripcion`, `nombre_proyecto`, `horas_semanales`, `id_comisiones`, `Fecha_creacion`, `Creado_por`, `Fecha_modificación`, `Modificado_por`) VALUES
(1, 'Supervisar Práctica Profesional', 'prueba', 'prueba', '11', 1, '2021-03-16', NULL, '2021-03-16', NULL),
(2, 'actividad2', '', '', '', 2, '2021-03-16', NULL, '2021-04-29', 'ADMIN'),
(3, 'ACTIVIDAD 3', ' B', 'B', '2', 4, NULL, NULL, NULL, NULL),
(4, 'ACTIVIDAD 5', 'BB', 'B', '5', 3, NULL, NULL, NULL, NULL),
(5, 'ACTIVIDAD 6', 'B', 'B', '0', 4, NULL, NULL, NULL, NULL),
(6, 'ACTIVIDAD 4', 'B', 'B', '4', 2, NULL, NULL, NULL, NULL),
(7, '1. PROMOVER EL DESARROLLO DE LA REFORMA UNIVERSITA', 'BASCI', 'B', '5', 19, NULL, NULL, '2021-04-29', 'ADMIN'),
(8, '2. ASESORAR AL JEFE  EN TODOS LOS ASUNTOS ACA-CIEN', 'B', 'B', '6', 19, NULL, NULL, NULL, NULL),
(9, '3. DICTAMINAR SOBRE LAS PROPUESTAS DE CREACIÓN. ', 'B', 'B', '3', 19, NULL, NULL, NULL, NULL),
(10, '4. REVISAR LOS OBJETIVOS, CONTENIDO DE CADA UNIDAD', NULL, NULL, '4', 19, NULL, NULL, NULL, NULL),
(11, '5. EVALUAR EL FUNCIONAMIENTO GLOBAL DEL DEPARTAMEN', NULL, NULL, '6', 19, NULL, NULL, NULL, NULL),
(12, '6. PROMOVER PRIORIDADES Y LÍNEAS DE INVESTIGACIÓN ', NULL, NULL, '4', 19, NULL, NULL, NULL, NULL),
(13, '1. DIRIGIR LOS PROCESOS ACADÉMICOS DE LA CARRERA', 'PRUEBA', 'PROBANDO', '3', 13, NULL, NULL, '2021-04-29', 'ADMIN'),
(14, '2. DESARROLLAR LA PROPUESTA DEL MODELO EDUCATIVO ', NULL, NULL, '9', 13, NULL, NULL, NULL, NULL),
(15, '3. VIGILAR EL CUMPLIMIENTO DEL PLAN CURRICULAR ', NULL, NULL, '8', 13, NULL, NULL, NULL, NULL),
(16, '4. EVALUAR PERMANENTEMENTE LOS PROGRAMAS DE LA CAR', NULL, NULL, '6', 13, NULL, NULL, NULL, NULL),
(17, '5. GESTIONAR RECURSOS PARA EL DESARROLLO DE LA CAR', NULL, NULL, '6', 13, NULL, NULL, NULL, NULL),
(18, '7. RECOMENDAR SANCIONES PARA PROFESORES Y ESTUDIAN', NULL, NULL, '8', 13, NULL, NULL, NULL, NULL),
(19, '1. VELAR POR LAS RELACIONES PUBLICAS Y LA PROMOCIO', NULL, NULL, '5', 17, NULL, NULL, NULL, NULL),
(20, '2. PROMOCIONAR LAS ACTIVIDADES DE COMITÉ DE VINCU.', NULL, NULL, '5', 17, NULL, NULL, NULL, NULL),
(21, '3. PRESENTAR INFORMES POR PERIODO DE LAS ACTIVIDAD', NULL, NULL, '4', 17, NULL, NULL, NULL, NULL),
(22, '1- PLANIFICAR Y SISTEMATIZAR ACCIONES DE VINCUL.', 'HOLA', 'PRUEBA', '4', 27, NULL, NULL, '2021-04-29', 'ADMIN'),
(23, '2. HACER EL REGISTRO DE LOS PROYECTOS EN LA OFICIN', NULL, NULL, '7', 14, NULL, NULL, NULL, NULL),
(24, '3. ACTUALIZAR Y PROMOCIONAR SU OFERTA DE VINCULACI', NULL, NULL, '3', 14, NULL, NULL, NULL, NULL),
(25, '4. DESARROLLAR ACCIONES DE IDENTIFICACIÓN Y ATENCI', NULL, NULL, '4', 14, NULL, NULL, NULL, NULL),
(26, '5. COORDINAR CON QUIEN CORRESPONDA, DENTRO Y FUERA', NULL, NULL, '8', 14, NULL, NULL, NULL, NULL),
(27, '6. PROMOVER EVENTOS DE EDUCACIÓN NO FORMAL Y DE FO', NULL, NULL, '6', 14, NULL, NULL, NULL, NULL),
(28, '7. IMPLEMENTAR PROGRAMAS Y MEDIDAS ORIENTADAS A LA', NULL, NULL, '9', 14, NULL, NULL, NULL, NULL),
(29, '8. ESTABLECER MECANISMOS PARA SEGUIMIENTO A EGRESA', NULL, NULL, '6', 14, NULL, NULL, NULL, NULL),
(30, '9. PROPICIAR MEDIDAS Y ACCIONES DE VINCULACIÓN ', NULL, NULL, '7', 14, NULL, NULL, NULL, NULL),
(31, '10. IMPLEMENTAR Y DIFUNDIR ACTIVIDADES CULTURALES ', NULL, NULL, '4', 14, NULL, NULL, NULL, NULL),
(32, '11. ORGANIZAR Y EJECUTAR EL REGISTRO DEL PENSUM AC', NULL, NULL, '4', 14, NULL, NULL, NULL, NULL),
(33, '12. APLICAR E INTRODUCIR EN LA BASE DE DATOS LOS I', NULL, NULL, '7', 14, NULL, NULL, NULL, NULL),
(34, '1. DEBE LLEVAR UN EXPEDIENTE DE CONTROL DE HORAS VOAE', 'HOLA', '', '8', 15, NULL, NULL, '2021-04-29', 'ADMIN'),
(35, '2. DEBE REGISTRAR LAS ACTIVIDADES A PROGRAMAR CON ESTUDIANTE', NULL, NULL, '5', 15, NULL, NULL, NULL, NULL),
(36, '3. REGISTRAR LOS PROYECTOS JUNTO CON EL COORDINADO', NULL, NULL, '6', 15, NULL, NULL, NULL, NULL),
(37, '1. IDENTIFICAR, DISEÑAR LAS PRIORIDADES DE INVESTIGACION', NULL, NULL, '3', 18, NULL, NULL, NULL, NULL),
(38, '2. EJECUTAR ORGANIZAR Y PROMOVER ACTIVIDADES DE GE', NULL, NULL, '7', 18, NULL, NULL, NULL, NULL),
(39, '3. REVISAR Y DAR SEGUIMIENTO AL DESARROLLO DE LA E', NULL, NULL, '3', 18, NULL, NULL, NULL, NULL),
(40, '4. APROBAR EN PRIMERA INSTANCIA LOS PROYECTOS DE I', NULL, NULL, '2', 18, NULL, NULL, NULL, NULL),
(41, '5. DICTAMINAR SOBRE LOS AVANCES E INFORMES FINALES', NULL, NULL, '8', 18, NULL, NULL, NULL, NULL),
(42, '1. ELABORACIÓN Y CUSTODIA DE LAS ACTAS Y DOCUMENTO', NULL, NULL, '4', 26, NULL, NULL, NULL, NULL),
(43, '2. LA COLABORACIÓN EN LA COORDINACIÓN DE LA GESTIÓ', NULL, NULL, '3', 26, NULL, NULL, NULL, NULL),
(44, '3. DAR FE DE LOS ACUERDOS DE LA ASAMBLEA DEL DEPARTAMENTO', NULL, NULL, '6', 26, NULL, NULL, NULL, NULL),
(45, '4. ASISTIR A LAS ASAMBLEAS DEL DEPARTAMENTO', NULL, NULL, '4', 26, NULL, NULL, NULL, NULL),
(46, '5. CUANTAS FUNCIONES PUEDAN SERLE CONSIGNADAS POR ', NULL, NULL, '8', 26, NULL, NULL, NULL, NULL),
(47, '1.RESPONSABLE DE MONITOREAR EL REGISTRO DEL PLAN DE ESTUDIOS', NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL),
(48, '2.RESPONSABLE DE REDISEÑAR EL PLAN DE ESTUDIO Y DEL PROCESO ', NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL),
(49, '3.RESPONSABLE DE MANTENER EL COMPENDIO DOCUMENTAL DEL PROCES', NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL),
(51, 'ZRR', 'ZRR', 'ZRR', '1', 4, '2021-04-08', 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_actividades_persona`
--

CREATE TABLE `tbl_actividades_persona` (
  `id_act_persona` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL,
  `id_persona` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_actividades_persona`
--

INSERT INTO `tbl_actividades_persona` (`id_act_persona`, `id_actividad`, `id_persona`) VALUES
(1, 1, 6),
(133, 1, 82),
(134, 4, 83),
(136, 5, 85),
(137, 6, 86),
(138, 6, 87),
(139, 4, 88),
(140, 6, 89),
(141, 14, 90),
(142, 35, 91),
(143, 21, 92),
(144, 21, 93),
(145, 48, 94),
(146, 47, 95),
(147, 28, 96),
(148, 35, 97),
(149, 30, 98),
(150, 17, 99),
(151, 1, 100),
(152, 27, 101),
(153, 49, 102),
(154, 25, 103),
(155, 6, 104),
(156, 1, 105),
(157, 1, 106),
(158, 34, 107),
(159, 6, 108),
(160, 48, 109),
(161, 48, 110),
(162, 49, 111),
(163, 4, 112),
(164, 5, 113),
(165, 36, 114),
(166, 1, 115),
(167, 6, 116),
(168, 1, 117),
(169, 6, 118),
(197, 37, 24),
(212, 2, 108),
(213, 1, 108),
(214, 5, 148),
(217, 3, 149),
(219, 37, 149),
(220, 48, 150),
(221, 15, 150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_aldeas_caserios_hn`
--

CREATE TABLE `tbl_aldeas_caserios_hn` (
  `id_aldea_caserio` bigint(20) NOT NULL,
  `nombre_aldea_caserio` varchar(100) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `creado_por` varchar(80) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(80) DEFAULT NULL,
  `id_municipio` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_aldeas_caserios_hn`
--

INSERT INTO `tbl_aldeas_caserios_hn` (`id_aldea_caserio`, `nombre_aldea_caserio`, `codigo`, `fecha_creacion`, `creado_por`, `fecha_modificacion`, `modificado_por`, `id_municipio`) VALUES
(1, 'La Ceiba', 10101, '2021-05-31 21:53:52', 'ADMIN', NULL, NULL, 1),
(2, ' Armenia Bonito ', 10102, '2021-05-31 21:54:30', 'ADMIN', NULL, NULL, 1),
(3, 'Bontilo', 10103, '2021-05-31 21:54:58', 'ADMIN', NULL, NULL, 1),
(4, 'Coroza', 10104, '2021-05-31 21:56:14', 'ADMIN', NULL, NULL, 1),
(5, 'Dantilo', 10105, '2021-05-31 21:56:38', 'ADMIN', NULL, NULL, 1),
(6, 'El Búfalo', 10106, '2021-05-31 21:57:01', 'ADMIN', NULL, NULL, 1),
(7, 'El paralso o Bataca', 10107, '2021-05-31 21:57:43', 'ADMIN', NULL, NULL, 1),
(8, 'El Perú', 10108, '2021-05-31 21:58:08', 'ADMIN', NULL, NULL, 1),
(9, 'El Pital', 10109, '2021-05-31 21:58:41', 'ADMIN', NULL, NULL, 1),
(10, 'La Ausencia', 10110, '2021-05-31 21:59:00', 'ADMIN', NULL, NULL, 1),
(11, 'La Presa', 10111, '2021-05-31 21:59:14', 'ADMIN', NULL, NULL, 1),
(12, 'Las Mangas', 10112, '2021-05-31 21:59:35', 'ADMIN', NULL, NULL, 1),
(13, 'Los Limpios', 10113, '2021-05-31 21:59:53', 'ADMIN', NULL, NULL, 1),
(14, 'Piedra Pintada o la Cok>rada', 10114, '2021-05-31 22:00:36', 'ADMIN', NULL, NULL, 1),
(15, 'Rlo Marta', 10115, '2021-05-31 22:00:47', 'ADMIN', NULL, NULL, 1),
(16, 'Rlo Viejo', 10116, '2021-05-31 22:01:14', 'ADMIN', NULL, NULL, 1),
(17, 'Sambo Creek', 10117, '2021-05-31 22:01:33', 'ADMIN', NULL, NULL, 1),
(18, 'Satuye', 10118, '2021-05-31 22:01:49', 'ADMIN', NULL, NULL, 1),
(19, 'Toncontin', 10119, '2021-05-31 22:02:05', 'ADMIN', NULL, NULL, 1),
(20, 'El Urraco', 10120, '2021-05-31 22:02:19', 'ADMIN', NULL, NULL, 1),
(21, 'Yaruca', 10121, '2021-05-31 22:02:36', 'ADMIN', NULL, NULL, 1),
(22, 'El Porvenir', 10201, '2021-05-31 22:03:28', 'ADMIN', NULL, NULL, 2),
(23, 'Burgos', 10202, '2021-05-31 22:04:43', 'ADMIN', NULL, NULL, 2),
(24, 'Cáceres', 10203, '2021-05-31 22:04:53', 'ADMIN', NULL, NULL, 2),
(25, 'Campo Salado Barra', 10204, '2021-05-31 22:05:14', 'ADMIN', NULL, NULL, 2),
(26, 'Caracas', 10205, '2021-05-31 22:05:28', 'ADMIN', NULL, NULL, 2),
(27, 'Ceiba Mocha', 10206, '2021-05-31 22:05:42', 'ADMIN', NULL, NULL, 2),
(28, 'El Pino', 10208, '2021-05-31 22:06:15', 'ADMIN', NULL, NULL, 2),
(29, 'La Ruidosa', 10209, '2021-05-31 22:06:29', 'ADMIN', NULL, NULL, 2),
(30, 'La Unión', 10210, '2021-05-31 22:06:44', 'ADMIN', NULL, NULL, 2),
(31, 'López Bonito', 10211, '2021-05-31 22:07:02', 'ADMIN', NULL, NULL, 2),
(32, 'Orotino', 10212, '2021-05-31 22:07:20', 'ADMIN', NULL, NULL, 2),
(33, 'San José de Montevideo', 10213, '2021-05-31 22:08:00', 'ADMIN', NULL, NULL, 2),
(34, 'Esparta', 10301, '2021-05-31 22:08:25', 'ADMIN', NULL, NULL, 3),
(35, 'Agua Caliente', 10302, '2021-05-31 22:40:00', 'ADMIN', NULL, NULL, 3),
(36, 'Barranquilla Norte', 10303, '2021-05-31 22:40:35', 'ADMIN', NULL, NULL, 3),
(37, 'Buenos Aires', 10304, '2021-05-31 22:40:52', 'ADMIN', NULL, NULL, 3),
(38, 'Campo Nuevo', 10305, '2021-05-31 22:41:09', 'ADMIN', NULL, NULL, 3),
(39, 'Cayo de Venado ', 10306, '2021-05-31 22:41:28', 'ADMIN', NULL, NULL, 3),
(40, 'Ceibita Way', 10307, '2021-05-31 22:42:05', 'ADMIN', NULL, NULL, 3),
(41, 'Colonia Brisas de América', 10308, '2021-05-31 22:42:33', 'ADMIN', NULL, NULL, 3),
(42, 'Colorado Barra', 10309, '2021-05-31 22:42:48', 'ADMIN', NULL, NULL, 3),
(43, 'El Jazmin', 10310, '2021-05-31 22:43:02', 'ADMIN', NULL, NULL, 3),
(44, 'El Suspiro', 10311, '2021-05-31 22:43:15', 'ADMIN', NULL, NULL, 3),
(45, 'Flores de Italia', 10312, '2021-05-31 22:44:04', 'ADMIN', NULL, NULL, 3),
(46, 'La Guadalupe', 10313, '2021-05-31 22:44:32', 'ADMIN', NULL, NULL, 3),
(47, 'La libertad', 10314, '2021-05-31 22:44:54', 'ADMIN', NULL, NULL, 3),
(48, 'La Tarralosa', 10315, '2021-05-31 22:45:09', 'ADMIN', NULL, NULL, 3),
(49, 'Las Américas', 10316, '2021-05-31 22:45:47', 'ADMIN', NULL, NULL, 3),
(50, 'Las Delicias', 10317, '2021-05-31 22:46:11', 'ADMIN', NULL, NULL, 3),
(51, 'Las Delicias del Norte', 10318, '2021-05-31 22:46:38', 'ADMIN', NULL, NULL, 3),
(52, 'Las Flores de Leán', 10319, '2021-05-31 22:46:53', 'ADMIN', NULL, NULL, 3),
(53, 'Lombardilla o la Curva', 10320, '2021-05-31 22:47:23', 'ADMIN', NULL, NULL, 3),
(54, 'Los Cerritos', 10321, '2021-05-31 22:47:44', 'ADMIN', NULL, NULL, 3),
(55, 'Manta de Guineo', 10322, '2021-05-31 22:48:01', 'ADMIN', NULL, NULL, 3),
(56, 'Nueva Esperanza', 10323, '2021-05-31 22:48:38', 'ADMIN', NULL, NULL, 3),
(57, 'Nueva Go', 10324, '2021-05-31 22:48:48', 'ADMIN', NULL, NULL, 3),
(58, 'Paris de Leán', 10325, '2021-05-31 22:49:09', 'ADMIN', NULL, NULL, 3),
(59, 'Piedras de Afilar', 10326, '2021-05-31 22:49:26', 'ADMIN', NULL, NULL, 3),
(60, 'Rio Chiquito Norte', 10327, '2021-05-31 22:49:49', 'ADMIN', NULL, NULL, 3),
(61, 'Rosita', 10328, '2021-05-31 22:50:09', 'ADMIN', NULL, NULL, 3),
(62, 'San José', 10329, '2021-05-31 22:50:22', 'ADMIN', NULL, NULL, 3),
(63, 'Siempre Viva', 10330, '2021-05-31 22:50:37', 'ADMIN', NULL, NULL, 3),
(64, 'Sombre Verde', 10331, '2021-05-31 22:51:04', 'ADMIN', NULL, NULL, 3),
(67, 'Jutiapa', 10401, '2021-05-31 23:03:01', 'ADMIN', NULL, NULL, 310),
(68, 'Berlín No. 1', 10402, '2021-05-31 23:03:36', 'ADMIN', NULL, NULL, 310),
(69, 'Cantor', 10403, '2021-05-31 23:03:49', 'ADMIN', NULL, NULL, 310),
(70, 'Cefalú', 10404, '2021-05-31 23:04:07', 'ADMIN', NULL, NULL, 310),
(71, 'Ceiba Grande', 10405, '2021-05-31 23:04:27', 'ADMIN', NULL, NULL, 310),
(72, 'Corralitos', 10406, '2021-05-31 23:04:47', 'ADMIN', NULL, NULL, 310),
(73, 'Descombros', 10407, '2021-05-31 23:05:00', 'ADMIN', NULL, NULL, 310),
(74, 'El Aguacate en Linea', 10408, '2021-05-31 23:05:19', 'ADMIN', NULL, NULL, 310),
(75, 'El Cacao', 10409, '2021-05-31 23:05:32', 'ADMIN', NULL, NULL, 310),
(76, 'El Cacao', 10409, '2021-05-31 23:05:48', 'ADMIN', NULL, NULL, 310),
(77, 'El Diamante', 10410, '2021-05-31 23:12:09', 'ADMIN', NULL, NULL, 310),
(78, 'El Urraco', 10412, '2021-05-31 23:12:49', 'ADMIN', NULL, NULL, 310),
(79, 'El Zapotal', 10413, '2021-05-31 23:13:02', 'ADMIN', NULL, NULL, 310),
(80, 'El Zapote', 10412, '2021-05-31 23:13:10', 'ADMIN', NULL, NULL, 310),
(81, 'Enteina', 10413, '2021-05-31 23:13:49', 'ADMIN', NULL, NULL, 310),
(82, 'Llamapa', 10416, '2021-05-31 23:14:10', 'ADMIN', NULL, NULL, 310),
(83, 'La Bomba', 10418, '2021-05-31 23:14:41', 'ADMIN', NULL, NULL, 310),
(84, 'Las Marias', 10419, '2021-05-31 23:14:54', 'ADMIN', NULL, NULL, 310),
(85, 'Los Olanchitos', 10420, '2021-05-31 23:15:24', 'ADMIN', NULL, NULL, 310),
(86, 'Papaloteca', 10422, '2021-05-31 23:20:20', 'ADMIN', NULL, NULL, 310),
(87, 'Piedras Amarilas', 10423, '2021-05-31 23:20:32', 'ADMIN', NULL, NULL, 310),
(88, 'Roma', 10425, '2021-05-31 23:20:56', 'ADMIN', NULL, NULL, 310),
(89, 'Saltos', 10427, '2021-05-31 23:21:33', 'ADMIN', NULL, NULL, 310),
(90, 'Sonaguerita', 10429, '2021-05-31 23:22:05', 'ADMIN', NULL, NULL, 310),
(91, 'Subirana', 10430, '2021-05-31 23:22:20', 'ADMIN', NULL, NULL, 310),
(92, 'Tomalá', 10431, '2021-05-31 23:22:33', 'ADMIN', NULL, NULL, 310),
(93, 'La Masica', 10501, '2021-05-31 23:26:15', 'ADMIN', NULL, NULL, 5),
(94, 'Agua Caliente', 10502, '2021-05-31 23:26:46', 'ADMIN', NULL, NULL, 5),
(95, 'Agua Fría', 10503, '2021-05-31 23:26:55', 'ADMIN', NULL, NULL, 5),
(96, 'Boca Cerrada', 10504, '2021-05-31 23:28:22', 'ADMIN', NULL, NULL, 5),
(97, 'Colinas', 10505, '2021-05-31 23:28:34', 'ADMIN', NULL, NULL, 5),
(98, 'El Desvio', 10506, '2021-05-31 23:28:47', 'ADMIN', NULL, NULL, 5),
(99, 'El Naranjal', 10507, '2021-05-31 23:29:00', 'ADMIN', NULL, NULL, 5),
(100, 'El Oro', 10508, '2021-05-31 23:30:15', 'ADMIN', NULL, NULL, 5),
(101, 'San Antonio', 10512, '2021-05-31 23:32:10', 'ADMIN', NULL, NULL, 5),
(102, 'San Juan Benque', 10513, '2021-05-31 23:34:42', 'ADMIN', NULL, NULL, 5),
(103, 'San Juan Pueblo', 10514, '2021-05-31 23:34:58', 'ADMIN', NULL, NULL, 5),
(104, 'San Marcos', 10515, '2021-05-31 23:35:12', 'ADMIN', NULL, NULL, 5),
(105, 'Santa Fé', 10516, '2021-05-31 23:35:31', 'ADMIN', NULL, NULL, 5),
(106, 'Soledad', 10517, '2021-05-31 23:35:44', 'ADMIN', NULL, NULL, 5),
(107, 'Tierra Firme', 10518, '2021-05-31 23:35:57', 'ADMIN', NULL, NULL, 5),
(108, 'Trípoli', 10519, '2021-05-31 23:36:19', 'ADMIN', NULL, NULL, 5),
(109, 'San Francisco', 10601, '2021-05-31 23:37:01', 'ADMIN', NULL, NULL, 6),
(110, 'Frisco No.1', 10602, '2021-05-31 23:37:30', 'ADMIN', NULL, NULL, 6),
(111, 'La Frutera', 10603, '2021-05-31 23:37:51', 'ADMIN', NULL, NULL, 6),
(112, 'La Llave', 10604, '2021-05-31 23:38:02', 'ADMIN', NULL, NULL, 6),
(113, 'Las Camelias', 10605, '2021-05-31 23:38:17', 'ADMIN', NULL, NULL, 6),
(114, 'Micelly', 10606, '2021-05-31 23:38:35', 'ADMIN', NULL, NULL, 6),
(115, 'Paguales', 10607, '2021-05-31 23:38:47', 'ADMIN', NULL, NULL, 6),
(116, 'Río Cuero', 10608, '2021-05-31 23:39:02', 'ADMIN', NULL, NULL, 6),
(117, 'Saladito', 10609, '2021-05-31 23:39:14', 'ADMIN', NULL, NULL, 6),
(118, 'Santa Ana', 10609, '2021-05-31 23:39:37', 'ADMIN', NULL, NULL, 6),
(119, 'Santiago', 10610, '2021-05-31 23:39:51', 'ADMIN', NULL, NULL, 6),
(120, 'Santiago Aniba', 10611, '2021-05-31 23:40:01', 'ADMIN', NULL, NULL, 6),
(121, 'Tela', 10701, '2021-05-31 23:40:30', 'ADMIN', NULL, NULL, 7),
(122, 'Agua Blanca', 10702, '2021-05-31 23:40:44', 'ADMIN', NULL, NULL, 7),
(123, 'Agua Chiquita', 10703, '2021-05-31 23:40:54', 'ADMIN', NULL, NULL, 7),
(124, '8arra Ulúa ', 10704, '2021-05-31 23:41:13', 'ADMIN', NULL, NULL, 7),
(125, '8risas de Leán ', 10705, '2021-05-31 23:41:36', 'ADMIN', NULL, NULL, 7),
(126, 'Buena Vista', 10706, '2021-05-31 23:41:49', 'ADMIN', NULL, NULL, 7),
(127, 'Buenos Aires No.1 ', 10707, '2021-05-31 23:42:14', 'ADMIN', NULL, NULL, 7),
(128, 'Buenos Aires No.2 ', 10708, '2021-05-31 23:42:20', 'ADMIN', NULL, NULL, 7),
(129, 'Campo Elvir', 10709, '2021-05-31 23:42:41', 'ADMIN', NULL, NULL, 7),
(130, 'Camngelica o el Corozal', 10710, '2021-05-31 23:43:11', 'ADMIN', NULL, NULL, 7),
(131, 'Cangeliquilla Abajo', 10711, '2021-05-31 23:43:33', 'ADMIN', NULL, NULL, 7),
(132, 'Cangeliquilla Arriba', 10712, '2021-05-31 23:43:49', 'ADMIN', NULL, NULL, 7),
(133, 'Colonia los Laureles', 10713, '2021-05-31 23:44:12', 'ADMIN', NULL, NULL, 7),
(134, 'Concepción la Florida Vieja ', 10714, '2021-05-31 23:44:41', 'ADMIN', NULL, NULL, 7),
(135, 'Creek Martínez', 10715, '2021-05-31 23:45:16', 'ADMIN', NULL, NULL, 7),
(136, 'Champerío o el Triunfo de Esquipulas', 10716, '2021-05-31 23:45:45', 'ADMIN', NULL, NULL, 7),
(137, 'El Barrio o Buena Vista', 10717, '2021-05-31 23:46:02', 'ADMIN', NULL, NULL, 7),
(138, 'El Cedro', 10718, '2021-05-31 23:47:00', 'ADMIN', NULL, NULL, 7),
(139, 'El Desvío del Zapote Mojimán', 10719, '2021-05-31 23:47:37', 'ADMIN', NULL, NULL, 7),
(140, 'El Dorado', 10720, '2021-05-31 23:47:48', 'ADMIN', NULL, NULL, 7),
(141, 'El Encanto', 10721, '2021-05-31 23:48:00', 'ADMIN', NULL, NULL, 7),
(142, 'El Guáno', 10722, '2021-05-31 23:48:28', 'ADMIN', NULL, NULL, 7),
(143, 'El Guayabal', 10723, '2021-05-31 23:48:40', 'ADMIN', NULL, NULL, 7),
(144, 'El Junco', 10724, '2021-05-31 23:48:50', 'ADMIN', NULL, NULL, 7),
(145, 'El Jute', 10725, '2021-05-31 23:48:59', 'ADMIN', NULL, NULL, 7),
(146, 'El Rodeo', 10726, '2021-05-31 23:49:08', 'ADMIN', NULL, NULL, 7),
(147, 'El Tigre', 10727, '2021-05-31 23:49:19', 'ADMIN', NULL, NULL, 7),
(148, 'El Triunfo de la Crúz', 10728, '2021-05-31 23:49:34', 'ADMIN', NULL, NULL, 7),
(149, 'El Zapote No 1', 10729, '2021-05-31 23:50:32', 'ADMIN', NULL, NULL, 7),
(150, 'El Zapote No 2', 10730, '2021-05-31 23:50:38', 'ADMIN', NULL, NULL, 7),
(151, 'Kiómetro Trece', 10731, '2021-05-31 23:50:53', 'ADMIN', NULL, NULL, 7),
(152, 'Lanncetila ', 10732, '2021-05-31 23:51:12', 'ADMIN', NULL, NULL, 7),
(153, 'La Ezperanza ', 10733, '2021-05-31 23:51:25', 'ADMIN', NULL, NULL, 7),
(154, 'La Ezperanza de Santiago', 10734, '2021-05-31 23:51:39', 'ADMIN', NULL, NULL, 7),
(155, 'La Fortuna', 10735, '2021-05-31 23:51:59', 'ADMIN', NULL, NULL, 7),
(156, 'La Páz', 10737, '2021-05-31 23:52:20', 'ADMIN', NULL, NULL, 7),
(157, 'La Unión', 10738, '2021-05-31 23:52:39', 'ADMIN', NULL, NULL, 7),
(158, 'La Yusa', 10739, '2021-05-31 23:53:06', 'ADMIN', NULL, NULL, 7),
(159, 'Las Mercedes', 10741, '2021-06-01 17:22:16', 'ADMIN', NULL, NULL, 7),
(160, 'Las Meta6as', 10742, '2021-06-01 17:22:30', 'ADMIN', NULL, NULL, 7),
(161, 'Las Minas', 10743, '2021-06-01 17:22:45', 'ADMIN', NULL, NULL, 7),
(162, 'Las Palmas', 10744, '2021-06-01 17:22:55', 'ADMIN', NULL, NULL, 7),
(163, 'Las Quebradas', 10745, '2021-06-01 17:23:04', 'ADMIN', NULL, NULL, 7),
(164, 'Las Cerritos', 10746, '2021-06-01 17:23:13', 'ADMIN', NULL, NULL, 7),
(165, 'Mecher Diez y Siete', 10747, '2021-06-01 17:23:47', 'ADMIN', NULL, NULL, 7),
(166, 'Meroa Ocho', 10748, '2021-06-01 17:24:14', 'ADMIN', NULL, NULL, 7),
(167, 'Meroa Río', 10749, '2021-06-01 17:24:32', 'ADMIN', NULL, NULL, 7),
(168, 'Mezapa o Santa Rosa del Norte', 10750, '2021-06-01 17:24:59', 'ADMIN', NULL, NULL, 7),
(169, 'Monte Si6n', 10751, '2021-06-01 17:25:18', 'ADMIN', NULL, NULL, 7),
(170, 'Morazán', 10752, '2021-06-01 17:25:39', 'ADMIN', NULL, NULL, 7),
(171, 'Nombre de Dtos', 10753, '2021-06-01 17:26:00', 'ADMIN', NULL, NULL, 7),
(172, 'Nueva Esperanza', 10754, '2021-06-01 17:26:20', 'ADMIN', NULL, NULL, 7),
(173, 'Nuevo Ber1ín o Las Jicoteas', 10756, '2021-06-01 17:27:24', 'ADMIN', NULL, NULL, 7),
(174, 'Paujiles', 10757, '2021-06-01 17:27:42', 'ADMIN', NULL, NULL, 7),
(175, 'Peman o Otuita Adentro', 10758, '2021-06-01 17:28:00', 'ADMIN', NULL, NULL, 7),
(176, 'Piedras Gordas', 10759, '2021-06-01 17:28:18', 'ADMIN', NULL, NULL, 7),
(177, 'Planes', 10760, '2021-06-01 17:28:41', 'ADMIN', NULL, NULL, 7),
(178, 'Procon', 10761, '2021-06-01 17:28:55', 'ADMIN', NULL, NULL, 7),
(179, 'Puerto Arturo', 10762, '2021-06-01 17:29:20', 'ADMIN', NULL, NULL, 7),
(180, 'Río Tinto', 10763, '2021-06-01 17:29:50', 'ADMIN', NULL, NULL, 7),
(181, 'San Alejo', 10764, '2021-06-01 17:29:58', 'ADMIN', NULL, NULL, 7),
(182, 'San Antonio', 10765, '2021-06-01 17:30:09', 'ADMIN', NULL, NULL, 7),
(183, 'San Antonio de Villa Franca', 10766, '2021-06-01 17:30:40', 'ADMIN', NULL, NULL, 7),
(184, 'San José', 10767, '2021-06-01 17:30:58', 'ADMIN', NULL, NULL, 7),
(187, 'San Juan', 10768, '2021-06-01 17:32:49', 'ADMIN', NULL, NULL, 7),
(188, 'San Juan Lempira', 10769, '2021-06-01 17:33:01', 'ADMIN', NULL, NULL, 7),
(189, 'Santiago', 10770, '2021-06-01 17:33:16', 'ADMIN', NULL, NULL, 7),
(190, 'Tarralosa', 10771, '2021-06-01 17:33:29', 'ADMIN', NULL, NULL, 7),
(191, 'Toloa Adentro', 10772, '2021-06-01 17:33:50', 'ADMIN', NULL, NULL, 7),
(192, 'Toloa Creek', 10773, '2021-06-01 17:34:02', 'ADMIN', NULL, NULL, 7),
(193, 'Tornabé', 10774, '2021-06-01 17:34:18', 'ADMIN', NULL, NULL, 7),
(194, 'Villa Franca', 10775, '2021-06-01 17:34:34', 'ADMIN', NULL, NULL, 7),
(195, 'Zollabé', 10776, '2021-06-01 17:34:49', 'ADMIN', NULL, NULL, 7),
(196, 'La Grant', 10777, '2021-06-01 17:35:07', 'ADMIN', NULL, NULL, 7),
(197, 'Arizona', 10801, '2021-06-01 17:38:21', 'ADMIN', NULL, NULL, 8),
(198, 'Agua Caliente', 10802, '2021-06-01 17:38:31', 'ADMIN', NULL, NULL, 8),
(199, 'Atenas de San Cristobal', 10803, '2021-06-01 17:38:58', 'ADMIN', NULL, NULL, 8),
(200, 'Barranquilla Sur', 10804, '2021-06-01 17:39:20', 'ADMIN', NULL, NULL, 8),
(201, 'Colonia Río Platano', 10805, '2021-06-01 17:39:47', 'ADMIN', NULL, NULL, 8),
(202, 'Coloradillo', 10806, '2021-06-01 17:40:52', 'ADMIN', NULL, NULL, 8),
(203, 'El Coco', 10807, '2021-06-01 17:41:12', 'ADMIN', NULL, NULL, 8),
(204, 'El Empalme', 10808, '2021-06-01 17:41:28', 'ADMIN', NULL, NULL, 8),
(205, 'El Retiro', 10809, '2021-06-01 17:41:36', 'ADMIN', NULL, NULL, 8),
(206, 'El Hicaque', 10810, '2021-06-01 17:41:48', 'ADMIN', NULL, NULL, 8),
(207, 'Hisopo', 10811, '2021-06-01 17:41:59', 'ADMIN', NULL, NULL, 8),
(208, 'Jilamito Nuevo', 10812, '2021-06-01 17:42:15', 'ADMIN', NULL, NULL, 8),
(209, 'Jilamito Viejo', 10813, '2021-06-01 17:42:30', 'ADMIN', NULL, NULL, 8),
(210, 'Jilamo Nuevo', 10814, '2021-06-01 17:42:47', 'ADMIN', NULL, NULL, 8),
(211, 'Jilamo Viejo', 10815, '2021-06-01 17:42:55', 'ADMIN', NULL, NULL, 8),
(212, 'La Leona', 10816, '2021-06-01 17:43:08', 'ADMIN', NULL, NULL, 8),
(213, 'Las Lomas', 10817, '2021-06-01 17:43:22', 'ADMIN', NULL, NULL, 8),
(214, 'Mezapa', 10818, '2021-06-01 17:43:35', 'ADMIN', NULL, NULL, 8),
(215, 'Mezapita', 10819, '2021-06-01 17:43:46', 'ADMIN', NULL, NULL, 8),
(216, 'Planes de Hicaque', 10820, '2021-06-01 17:44:03', 'ADMIN', NULL, NULL, 8),
(217, 'Rio Chiquito Sur', 10821, '2021-06-01 17:44:22', 'ADMIN', NULL, NULL, 8),
(218, 'San Francisco de Saco', 10822, '2021-06-01 17:44:45', 'ADMIN', NULL, NULL, 8),
(219, 'San José de Texiguat', 10823, '2021-06-01 17:45:16', 'ADMIN', NULL, NULL, 8),
(220, 'San José de Tiburón', 10824, '2021-06-01 17:45:33', 'ADMIN', NULL, NULL, 8),
(221, 'Santa Maria', 10825, '2021-06-01 17:45:52', 'ADMIN', NULL, NULL, 8),
(222, 'Sisama', 10826, '2021-06-01 17:46:00', 'ADMIN', NULL, NULL, 8),
(223, 'Suyapa de Leán o Mataras', 10827, '2021-06-01 17:46:20', 'ADMIN', NULL, NULL, 8),
(224, 'Trujillo', 20101, '2021-06-01 17:49:33', 'ADMIN', NULL, NULL, 9),
(225, 'Colonia Aguán', 20102, '2021-06-01 17:49:47', 'ADMIN', NULL, NULL, 9),
(226, 'Chapagua', 20103, '2021-06-01 17:49:59', 'ADMIN', NULL, NULL, 9),
(227, 'El Coco N.1', 20104, '2021-06-01 17:50:31', 'ADMIN', NULL, NULL, 9),
(228, 'Ilanga', 20105, '2021-06-01 17:50:50', 'ADMIN', NULL, NULL, 9),
(229, 'Jericó', 20106, '2021-06-01 17:53:50', 'ADMIN', NULL, NULL, 9),
(230, 'La Brea', 20107, '2021-06-01 17:54:05', 'ADMIN', NULL, NULL, 9),
(231, 'Puerto Castilla', 20108, '2021-06-01 17:54:21', 'ADMIN', NULL, NULL, 9),
(232, 'Tarros', 20109, '2021-06-01 17:55:53', 'ADMIN', NULL, NULL, 9),
(233, 'Balfate', 20201, '2021-06-01 17:56:47', 'ADMIN', NULL, NULL, 10),
(234, 'Arenaloza', 20202, '2021-06-01 17:57:06', 'ADMIN', NULL, NULL, 10),
(235, 'Bambú', 20203, '2021-06-01 17:57:19', 'ADMIN', NULL, NULL, 10),
(236, 'Cuyamel', 20204, '2021-06-01 17:57:32', 'ADMIN', NULL, NULL, 10),
(237, 'El Cenizo', 20205, '2021-06-01 17:57:51', 'ADMIN', NULL, NULL, 10),
(238, 'El Porvenir', 20206, '2021-06-01 17:58:04', 'ADMIN', NULL, NULL, 10),
(239, 'El Satal', 20207, '2021-06-01 17:58:17', 'ADMIN', NULL, NULL, 10),
(240, 'El Satalito', 20208, '2021-06-01 17:58:29', 'ADMIN', NULL, NULL, 10),
(241, 'Las Cruzitas', 20209, '2021-06-01 17:58:49', 'ADMIN', NULL, NULL, 10),
(242, 'Las Flores', 20210, '2021-06-01 17:59:02', 'ADMIN', NULL, NULL, 10),
(243, 'Las Mangas', 20211, '2021-06-01 17:59:33', 'ADMIN', NULL, NULL, 10),
(244, 'Limera', 20212, '2021-06-01 17:59:46', 'ADMIN', NULL, NULL, 10),
(245, 'Lis Lis', 20213, '2021-06-01 18:00:00', 'ADMIN', NULL, NULL, 10),
(246, 'Lucinda', 20214, '2021-06-01 18:00:12', 'ADMIN', NULL, NULL, 10),
(247, 'Planes de Bambú', 20215, '2021-06-01 18:00:24', 'ADMIN', NULL, NULL, 10),
(248, 'Rio Coco', 20216, '2021-06-01 18:00:48', 'ADMIN', NULL, NULL, 10),
(249, 'Rio Esteban', 20217, '2021-06-01 18:00:59', 'ADMIN', NULL, NULL, 10),
(250, 'San Luis', 20218, '2021-06-01 18:01:08', 'ADMIN', NULL, NULL, 10),
(251, 'Iriona', 20301, '2021-06-01 18:01:50', 'ADMIN', NULL, NULL, 11),
(252, 'Ciriboya', 20302, '2021-06-01 18:02:02', 'ADMIN', NULL, NULL, 11),
(253, 'Cusuna', 20303, '2021-06-01 18:02:13', 'ADMIN', NULL, NULL, 11),
(254, 'Iriona Viejo', 20304, '2021-06-01 18:02:23', 'ADMIN', NULL, NULL, 11),
(255, 'Las Champas u Ocotales', 20305, '2021-06-01 18:02:53', 'ADMIN', NULL, NULL, 11),
(256, 'Punta de Piedra', 20307, '2021-06-01 18:03:16', 'ADMIN', NULL, NULL, 11),
(257, 'San José de La Punta', 20308, '2021-06-01 18:03:41', 'ADMIN', NULL, NULL, 11),
(258, 'Sangrelaya', 20309, '2021-06-01 18:04:21', 'ADMIN', NULL, NULL, 11),
(259, 'Sico', 20310, '2021-06-01 18:04:45', 'ADMIN', NULL, NULL, 11),
(260, 'Tocamacho', 20311, '2021-06-01 18:04:58', 'ADMIN', NULL, NULL, 11),
(262, 'Paya', 20306, NULL, NULL, NULL, NULL, 11),
(263, 'Francia', 20402, '2021-06-01 18:12:14', 'ADMIN', NULL, NULL, 12),
(264, 'Vallecito', 20403, '2021-06-01 18:12:24', 'ADMIN', NULL, NULL, 12),
(265, 'Sabá', 20501, '2021-06-01 18:12:34', 'ADMIN', NULL, NULL, 13),
(266, 'Barranco Chele', 20502, '2021-06-01 18:15:21', 'ADMIN', NULL, NULL, 13),
(267, 'Campo Bohemio o Alianza', 20503, '2021-06-01 18:15:43', 'ADMIN', NULL, NULL, 13),
(268, 'Campo Copete', 20504, '2021-06-01 18:16:00', 'ADMIN', NULL, NULL, 13),
(269, 'Campo Nerones', 20505, '2021-06-01 18:16:11', 'ADMIN', NULL, NULL, 13),
(270, 'Campo Vally', 20506, '2021-06-01 18:16:19', 'ADMIN', NULL, NULL, 13),
(271, 'Ceibita', 20507, '2021-06-01 18:16:28', 'ADMIN', NULL, NULL, 13),
(272, 'Cooperativa El Esfuerzo', 20508, '2021-06-01 18:16:44', 'ADMIN', NULL, NULL, 13),
(273, 'El Achiote', 20509, '2021-06-01 18:17:16', 'ADMIN', NULL, NULL, 13),
(274, 'El Jaguillo Muerto', 20510, '2021-06-01 18:17:38', 'ADMIN', NULL, NULL, 13),
(275, 'Elixir', 20511, '2021-06-01 18:17:51', 'ADMIN', NULL, NULL, 13),
(276, 'Finca El Carmen', 20512, '2021-06-01 18:18:08', 'ADMIN', NULL, NULL, 13),
(277, 'Las Golondrinas', 20513, '2021-06-01 18:18:37', 'ADMIN', NULL, NULL, 13),
(278, 'Orica', 20514, '2021-06-01 18:18:52', 'ADMIN', NULL, NULL, 13),
(279, 'Paguates', 20515, '2021-06-01 18:19:01', 'ADMIN', NULL, NULL, 13),
(280, 'Palos de Agua Abajo', 20516, '2021-06-01 18:19:18', 'ADMIN', NULL, NULL, 13),
(281, 'Sonámbula', 20517, '2021-06-01 18:19:45', 'ADMIN', NULL, NULL, 13),
(282, 'Tiburones', 20518, '2021-06-01 18:19:57', 'ADMIN', NULL, NULL, 13),
(283, 'Santa Fe', 20601, '2021-06-01 18:20:31', 'ADMIN', NULL, NULL, 14),
(284, 'Guadalpue', 20602, '2021-06-01 18:21:02', 'ADMIN', NULL, NULL, 14),
(285, 'Plan Grande', 20603, '2021-06-01 18:21:11', 'ADMIN', NULL, NULL, 14),
(286, 'San Antonio', 20604, '2021-06-01 18:21:22', 'ADMIN', NULL, NULL, 14),
(287, 'Santa Rosa de Aguán', 20701, '2021-06-01 18:21:41', 'ADMIN', NULL, NULL, 15),
(288, 'Vuelta Grande', 20702, '2021-06-01 18:23:20', 'ADMIN', NULL, NULL, 15),
(289, 'Sonaguera', 20801, '2021-06-01 18:24:15', 'ADMIN', NULL, NULL, 16),
(290, 'Agua Caliente', 20802, '2021-06-01 18:24:38', 'ADMIN', NULL, NULL, 16),
(291, 'Alto Seco', 20803, '2021-06-01 18:25:06', 'ADMIN', NULL, NULL, 16),
(292, 'Colonia El Sinal', 20804, '2021-06-01 18:25:23', 'ADMIN', NULL, NULL, 16),
(293, 'Campo El Olvido', 20805, '2021-06-01 18:26:15', 'ADMIN', NULL, NULL, 16),
(294, 'Campo Guanacaste', 20806, '2021-06-01 18:26:26', 'ADMIN', NULL, NULL, 16),
(295, 'Campo La Paz', 20807, '2021-06-01 18:26:36', 'ADMIN', NULL, NULL, 16),
(296, 'Cooperativa 21 de Noviembre', 20808, '2021-06-01 18:27:26', 'ADMIN', NULL, NULL, 16),
(297, 'Churrusquera', 20809, '2021-06-01 18:27:53', 'ADMIN', NULL, NULL, 16),
(298, 'El Café', 20810, '2021-06-01 18:28:12', 'ADMIN', NULL, NULL, 16),
(299, 'El Guayabal', 20811, '2021-06-01 18:28:49', 'ADMIN', NULL, NULL, 16),
(300, 'El Limón', 20812, '2021-06-01 18:29:03', 'ADMIN', NULL, NULL, 16),
(301, 'El Porvenir de Aída o El Berrinche', 20813, '2021-06-01 18:29:35', 'ADMIN', NULL, NULL, 16),
(302, 'El Sastre', 20814, '2021-06-01 18:29:47', 'ADMIN', NULL, NULL, 16),
(303, 'Fausto', 20815, '2021-06-01 18:30:00', 'ADMIN', NULL, NULL, 16),
(304, 'Flores del Este', 20816, '2021-06-01 18:30:10', 'ADMIN', NULL, NULL, 16),
(305, 'Flores del Terreno', 20817, '2021-06-01 18:30:25', 'ADMIN', NULL, NULL, 16),
(306, 'Gioconda', 20818, '2021-06-01 18:30:38', 'ADMIN', NULL, NULL, 16),
(307, 'Isleta Central', 20819, '2021-06-01 18:30:56', 'ADMIN', NULL, NULL, 16),
(308, 'Juan Lázaro Abajo', 20820, '2021-06-01 18:31:12', 'ADMIN', NULL, NULL, 16),
(309, 'La Cubana', 20821, '2021-06-01 18:31:27', 'ADMIN', NULL, NULL, 16),
(310, 'La Curva de Isleta', 20822, '2021-06-01 18:31:41', 'ADMIN', NULL, NULL, 16),
(311, 'La Hoya de Arriba', 20823, '2021-06-01 18:31:56', 'ADMIN', NULL, NULL, 16),
(312, 'La Presa o Juan Lázaro de Arriba', 20824, '2021-06-01 18:32:16', 'ADMIN', NULL, NULL, 16),
(313, 'Lanza', 20825, '2021-06-01 18:32:29', 'ADMIN', NULL, NULL, 16),
(314, 'Lezcano', 20826, '2021-06-01 18:32:38', 'ADMIN', NULL, NULL, 16),
(315, 'Lorelay', 20827, '2021-06-01 18:32:48', 'ADMIN', NULL, NULL, 16),
(316, 'Lorencillo', 20828, '2021-06-01 18:33:00', 'ADMIN', NULL, NULL, 16),
(317, 'Lucía', 20829, '2021-06-01 18:33:32', 'ADMIN', NULL, NULL, 16),
(318, 'Los Carrioles', 20830, '2021-06-01 18:33:48', 'ADMIN', NULL, NULL, 16),
(319, 'Los Planes', 20831, '2021-06-01 18:33:57', 'ADMIN', NULL, NULL, 16),
(320, 'Miramar', 20832, '2021-06-01 18:34:15', 'ADMIN', NULL, NULL, 16),
(321, 'Monte de Oro', 20833, '2021-06-01 18:34:39', 'ADMIN', NULL, NULL, 16),
(322, 'Parnas', 20834, '2021-06-01 18:34:57', 'ADMIN', NULL, NULL, 16),
(323, 'Puente Alto', 20835, '2021-06-01 18:35:08', 'ADMIN', NULL, NULL, 16),
(324, 'Quebrada de Arena', 20836, '2021-06-01 18:35:23', 'ADMIN', NULL, NULL, 16),
(325, 'Rio de Piedra', 20837, '2021-06-01 18:35:41', 'ADMIN', NULL, NULL, 16),
(326, 'Sabana de la Pita', 20838, '2021-06-01 18:35:53', 'ADMIN', NULL, NULL, 16),
(327, 'Sabana de Utila', 20839, '2021-06-01 18:36:03', 'ADMIN', NULL, NULL, 16),
(328, 'Tres Luces', 20840, '2021-06-01 18:36:20', 'ADMIN', NULL, NULL, 16),
(329, 'Tosca', 20841, '2021-06-01 18:36:32', 'ADMIN', NULL, NULL, 16),
(330, 'Trovador', 20842, '2021-06-01 18:37:38', 'ADMIN', NULL, NULL, 16),
(331, 'Utila', 20843, '2021-06-01 18:37:53', 'ADMIN', NULL, NULL, 16),
(332, 'Tocoa', 20901, '2021-06-01 18:51:15', 'ADMIN', NULL, NULL, 17),
(333, 'Cayo Sierra', 20902, '2021-06-01 18:51:53', 'ADMIN', NULL, NULL, 17),
(334, 'Cuaca Nueva o Jaral', 20903, '2021-06-01 18:52:19', 'ADMIN', NULL, NULL, 17),
(335, 'Cuaca Vieja o Cuaca Zona', 20904, '2021-06-01 18:52:46', 'ADMIN', NULL, NULL, 17),
(336, 'Chiripa', 20905, '2021-06-01 18:53:02', 'ADMIN', NULL, NULL, 17),
(337, 'El Guapinol', 20906, '2021-06-01 18:53:12', 'ADMIN', NULL, NULL, 17),
(338, 'Juan Antonio', 20907, '2021-06-01 18:53:25', 'ADMIN', NULL, NULL, 17),
(339, 'La Abisinia', 20908, '2021-06-01 18:53:41', 'ADMIN', NULL, NULL, 17),
(340, 'La Ceibita', 20909, '2021-06-01 18:53:59', 'ADMIN', NULL, NULL, 17),
(341, 'La Concepción', 20910, '2021-06-01 18:54:08', 'ADMIN', NULL, NULL, 17),
(342, 'Las Mangas', 20911, '2021-06-01 18:54:22', 'ADMIN', NULL, NULL, 17),
(343, 'Lirida', 20912, '2021-06-01 18:54:36', 'ADMIN', NULL, NULL, 17),
(344, 'Prieta', 20913, '2021-06-01 18:54:44', 'ADMIN', NULL, NULL, 17),
(345, 'Quebrada de Agua', 20914, '2021-06-01 18:54:58', 'ADMIN', NULL, NULL, 17),
(346, 'Quebrada de Arena', 20915, '2021-06-01 18:55:09', 'ADMIN', NULL, NULL, 17),
(347, 'Salam', 20916, '2021-06-01 18:55:19', 'ADMIN', NULL, NULL, 17),
(348, 'Taujica', 20917, '2021-06-01 18:55:32', 'ADMIN', NULL, NULL, 17),
(349, 'Zamora', 20918, '2021-06-01 18:55:50', 'ADMIN', NULL, NULL, 17),
(350, 'Bonito Oriente', 21001, '2021-06-01 18:56:24', 'ADMIN', NULL, NULL, 18),
(351, 'Corocito', 21002, '2021-06-01 18:56:47', 'ADMIN', NULL, NULL, 18),
(352, 'El Achiote', 21003, '2021-06-01 18:57:00', 'ADMIN', NULL, NULL, 18),
(353, 'El Antigual', 21004, '2021-06-01 18:57:11', 'ADMIN', NULL, NULL, 18),
(354, 'Feo', 21005, '2021-06-01 18:57:22', 'ADMIN', NULL, NULL, 18),
(355, 'La Esperanza', 21006, '2021-06-01 18:57:34', 'ADMIN', NULL, NULL, 18),
(356, 'Playa de Ganado', 21007, '2021-06-01 18:57:45', 'ADMIN', NULL, NULL, 18),
(357, 'Rio Piedra Blanca', 21008, '2021-06-01 18:58:02', 'ADMIN', NULL, NULL, 18),
(358, 'San josé del Cinco', 21009, '2021-06-01 18:58:20', 'ADMIN', NULL, NULL, 18),
(359, 'Vista Hermosa', 21010, '2021-06-01 18:58:34', 'ADMIN', NULL, NULL, 18),
(360, 'Comayagua', 30101, '2021-06-01 22:47:46', 'ADMIN', NULL, NULL, 23),
(361, 'Agua Salada', 30102, '2021-06-01 22:49:57', 'ADMIN', NULL, NULL, 23),
(362, 'Cacahuapa', 30103, '2021-06-01 22:50:12', 'ADMIN', NULL, NULL, 23),
(363, 'Cantoral', 30104, '2021-06-01 22:50:21', 'ADMIN', NULL, NULL, 23),
(364, 'El Ciruelo', 30105, '2021-06-01 22:51:38', 'ADMIN', NULL, NULL, 23),
(365, 'El Guachipilin', 30106, '2021-06-01 22:53:06', 'ADMIN', NULL, NULL, 23),
(366, 'El Horno', 30107, '2021-06-01 22:53:26', 'ADMIN', NULL, NULL, 23),
(367, 'El Plan de la Rosa', 30109, '2021-06-01 22:54:44', 'ADMIN', NULL, NULL, 23),
(369, 'El Paralso', 30108, '2021-06-01 23:00:46', 'ADMIN', NULL, NULL, 23),
(370, 'El Portillo de La More', 30110, '2021-06-01 23:01:27', 'ADMIN', NULL, NULL, 23),
(371, 'El Resumidero', 30111, '2021-06-01 23:01:40', 'ADMIN', NULL, NULL, 23),
(372, 'El Sauce', 30112, '2021-06-01 23:01:52', 'ADMIN', NULL, NULL, 23),
(373, 'El Sitio', 30113, '2021-06-01 23:02:02', 'ADMIN', NULL, NULL, 23),
(374, 'El Taladro', 30114, '2021-06-01 23:02:12', 'ADMIN', NULL, NULL, 23),
(375, 'El Volcán', 30115, '2021-06-01 23:02:21', 'ADMIN', NULL, NULL, 23),
(376, 'Guacamaya', 30116, '2021-06-01 23:02:40', 'ADMIN', NULL, NULL, 23),
(377, 'La Cooperativa', 30117, '2021-06-01 23:02:55', 'ADMIN', NULL, NULL, 23),
(378, 'La Escalera', 30118, '2021-06-01 23:03:08', 'ADMIN', NULL, NULL, 23),
(379, 'La Flor', 30119, '2021-06-01 23:03:18', 'ADMIN', NULL, NULL, 23),
(380, 'La Jaguita', 30120, '2021-06-01 23:03:38', 'ADMIN', NULL, NULL, 23),
(381, 'La Laguna', 30121, '2021-06-01 23:04:35', 'ADMIN', NULL, NULL, 23),
(382, 'La Palma', 30122, '2021-06-01 23:04:53', 'ADMIN', NULL, NULL, 23),
(383, 'La Sampedrana', 30123, '2021-06-01 23:05:29', 'ADMIN', NULL, NULL, 23),
(384, 'Las Anonas', 30124, '2021-06-01 23:06:17', 'ADMIN', NULL, NULL, 23),
(385, 'Las Liconas', 30125, '2021-06-01 23:06:47', 'ADMIN', NULL, NULL, 23),
(386, 'Las Mesas', 30126, '2021-06-01 23:07:00', 'ADMIN', NULL, NULL, 23),
(387, 'Lomas del Cordero', 30127, '2021-06-01 23:07:45', 'ADMIN', NULL, NULL, 23),
(388, 'Lomas Planes', 30128, '2021-06-01 23:08:08', 'ADMIN', NULL, NULL, 23),
(389, 'Motagua del Roblito', 30129, '2021-06-01 23:09:58', 'ADMIN', NULL, NULL, 23),
(390, 'Nueva Valladolid de Capiro', 30130, '2021-06-01 23:10:43', 'ADMIN', NULL, NULL, 23),
(391, 'Palo Pintado', 30131, '2021-06-01 23:11:11', 'ADMIN', NULL, NULL, 23),
(392, 'Piedraz Azules', 30132, '2021-06-01 23:11:38', 'ADMIN', NULL, NULL, 23),
(393, 'Planes de Churune', 30133, '2021-06-01 23:11:57', 'ADMIN', NULL, NULL, 23),
(394, 'Rio Blanco', 30134, '2021-06-01 23:12:22', 'ADMIN', NULL, NULL, 23),
(395, 'San Antonio de Cañas', 30135, '2021-06-01 23:13:05', 'ADMIN', NULL, NULL, 23),
(396, 'San Antonio deLa Libertad', 30136, '2021-06-01 23:13:45', 'ADMIN', NULL, NULL, 23),
(397, 'San Joséde Pane', 30137, '2021-06-01 23:14:19', 'ADMIN', NULL, NULL, 23),
(398, 'San Miguel de Selguapa', 30138, '2021-06-01 23:15:34', 'ADMIN', NULL, NULL, 23),
(399, 'Valle de Angeles', 30139, '2021-06-01 23:15:50', 'ADMIN', NULL, NULL, 23),
(400, 'Veracrúz', 30140, '2021-06-01 23:16:13', 'ADMIN', NULL, NULL, 23),
(401, 'La Libertad', 30601, '2021-06-01 23:18:59', 'ADMIN', NULL, NULL, 24),
(402, 'Cabeceras', 30602, '2021-06-01 23:19:59', 'ADMIN', NULL, NULL, 24),
(403, 'Cantón San Antonio', 30603, '2021-06-01 23:20:34', 'ADMIN', NULL, NULL, 24),
(404, 'Cuesta del Neo', 30604, '2021-06-01 23:20:52', 'ADMIN', NULL, NULL, 24),
(405, 'El Higuerón', 30605, '2021-06-01 23:21:11', 'ADMIN', NULL, NULL, 24),
(406, 'El Olvido', 30606, '2021-06-01 23:21:30', 'ADMIN', NULL, NULL, 24),
(407, 'El Pinabetoso', 30607, '2021-06-01 23:21:48', 'ADMIN', NULL, NULL, 24),
(408, 'Goteras', 30608, '2021-06-01 23:21:57', 'ADMIN', NULL, NULL, 24),
(409, 'La Pita', 30609, '2021-06-01 23:22:11', 'ADMIN', NULL, NULL, 24),
(410, 'Loma Alta', 30610, '2021-06-01 23:22:29', 'ADMIN', NULL, NULL, 24),
(411, 'Los Alfaros', 30611, '2021-06-01 23:22:44', 'ADMIN', NULL, NULL, 24),
(412, 'Montañuelas', 30612, '2021-06-01 23:22:59', 'ADMIN', NULL, NULL, 24),
(413, 'Plan de Alejandro', 30613, '2021-06-01 23:23:19', 'ADMIN', NULL, NULL, 24),
(414, 'San Andrés', 30614, '2021-06-01 23:23:41', 'ADMIN', NULL, NULL, 24),
(415, 'San Antonio de Saque ', 30615, '2021-06-01 23:24:12', 'ADMIN', NULL, NULL, 24),
(416, 'San José', 30616, '2021-06-01 23:25:26', 'ADMIN', NULL, NULL, 24),
(417, 'Santa Fe', 30617, '2021-06-01 23:25:56', 'ADMIN', NULL, NULL, 24),
(418, 'Terreritos', 30618, '2021-06-01 23:26:14', 'ADMIN', NULL, NULL, 24),
(419, 'Valle Bonito', 30619, '2021-06-01 23:26:34', 'ADMIN', NULL, NULL, 24),
(420, 'Valle de Angeles', 30620, '2021-06-01 23:26:49', 'ADMIN', NULL, NULL, 24),
(421, 'Vallecitos', 30621, '2021-06-01 23:27:08', 'ADMIN', NULL, NULL, 24),
(422, 'Zacatalitos', 30622, '2021-06-01 23:27:28', 'ADMIN', NULL, NULL, 24),
(423, 'Lamaní', 30701, '2021-06-01 23:29:27', 'ADMIN', NULL, NULL, 25),
(424, 'Guachipilin', 30702, '2021-06-01 23:29:55', 'ADMIN', NULL, NULL, 25),
(425, 'Lagunetas', 30703, '2021-06-01 23:30:06', 'ADMIN', NULL, NULL, 25),
(426, 'Las Mesetas', 30704, '2021-06-01 23:30:17', 'ADMIN', NULL, NULL, 25),
(427, 'Mulacagua', 30705, '2021-06-01 23:30:35', 'ADMIN', NULL, NULL, 25),
(428, 'Ojo de Agua', 30706, '2021-06-01 23:30:51', 'ADMIN', NULL, NULL, 25),
(429, 'Tablazón', 30707, '2021-06-01 23:31:07', 'ADMIN', NULL, NULL, 25),
(430, 'Valladolid', 30708, '2021-06-01 23:31:31', 'ADMIN', NULL, NULL, 25),
(431, 'La Trinidad', 30801, '2021-06-01 23:32:29', 'ADMIN', NULL, NULL, 26),
(432, 'El Cordoncillo', 30802, '2021-06-01 23:32:46', 'ADMIN', NULL, NULL, 26),
(433, 'El Peñón', 30803, '2021-06-01 23:33:23', 'ADMIN', NULL, NULL, 26),
(434, 'Guacamaya', 30804, '2021-06-01 23:34:16', 'ADMIN', NULL, NULL, 26),
(435, 'Las Tierras', 30805, '2021-06-01 23:34:30', 'ADMIN', NULL, NULL, 26),
(436, 'Los Anises', 30806, '2021-06-01 23:34:55', 'ADMIN', NULL, NULL, 26),
(437, 'Tierra Blanca', 30807, '2021-06-01 23:35:16', 'ADMIN', NULL, NULL, 26),
(438, 'Lejamaní', 30901, '2021-06-01 23:37:15', 'ADMIN', NULL, NULL, 27),
(439, 'Membar', 31001, '2021-06-01 23:38:31', 'ADMIN', NULL, NULL, 28),
(440, 'Agua Caliente', 31003, '2021-06-01 23:38:47', 'ADMIN', NULL, NULL, 28),
(441, 'Chichipate', 31004, '2021-06-01 23:40:47', 'ADMIN', NULL, NULL, 28),
(442, 'El Aguaje', 31005, '2021-06-01 23:41:04', 'ADMIN', NULL, NULL, 28),
(443, 'El Buen Pastor', 31006, '2021-06-01 23:41:42', 'ADMIN', NULL, NULL, 28),
(444, 'El Cienegal', 31007, '2021-06-01 23:42:06', 'ADMIN', NULL, NULL, 28),
(445, 'El Palmital', 31008, '2021-06-01 23:42:32', 'ADMIN', NULL, NULL, 28),
(446, 'El Zapote', 31009, '2021-06-01 23:42:46', 'ADMIN', NULL, NULL, 28),
(447, 'Jicaro', 31010, '2021-06-01 23:43:04', 'ADMIN', NULL, NULL, 28),
(448, 'La Concepción', 31011, '2021-06-01 23:43:22', 'ADMIN', NULL, NULL, 28),
(449, 'La Joya', 31012, '2021-06-01 23:43:44', 'ADMIN', NULL, NULL, 28),
(450, 'La Mesa', 31013, '2021-06-01 23:43:56', 'ADMIN', NULL, NULL, 28),
(451, 'La Pimienta', 31014, '2021-06-01 23:44:09', 'ADMIN', NULL, NULL, 28),
(452, 'La Lajas', 31015, '2021-06-01 23:44:20', 'ADMIN', NULL, NULL, 28),
(453, 'Los Globos', 31016, '2021-06-01 23:44:38', 'ADMIN', NULL, NULL, 28),
(454, 'Los Planes', 31017, '2021-06-01 23:44:50', 'ADMIN', NULL, NULL, 28),
(455, 'Matapalo', 31018, '2021-06-01 23:45:04', 'ADMIN', NULL, NULL, 28),
(456, 'Monte de Dios', 31019, '2021-06-01 23:45:20', 'ADMIN', NULL, NULL, 28),
(457, 'Ojo de Agua', 31020, '2021-06-01 23:45:34', 'ADMIN', NULL, NULL, 28),
(458, 'Potrerilios', 31021, '2021-06-01 23:45:54', 'ADMIN', NULL, NULL, 28),
(459, 'Pueblo Nuevo', 31022, '2021-06-01 23:46:09', 'ADMIN', NULL, NULL, 28),
(460, 'San Antonio de Buenos Aires', 31023, '2021-06-01 23:46:36', 'ADMIN', NULL, NULL, 28),
(461, 'San Isidro', 31024, '2021-06-01 23:47:11', 'ADMIN', NULL, NULL, 28),
(462, 'Santa Ana', 31025, '2021-06-01 23:47:29', 'ADMIN', NULL, NULL, 28),
(463, 'Santa Elena', 31026, '2021-06-01 23:47:44', 'ADMIN', NULL, NULL, 28),
(464, 'Minas de Oro', 31101, '2021-06-01 23:52:16', 'ADMIN', NULL, NULL, 29),
(465, 'Agua Blanca', 31102, '2021-06-01 23:52:36', 'ADMIN', NULL, NULL, 29),
(466, 'El Socorro', 31103, '2021-06-01 23:52:55', 'ADMIN', NULL, NULL, 29),
(468, 'El Zompopero', 31104, '2021-06-01 23:55:32', 'ADMIN', NULL, NULL, 29),
(469, 'La Hoya de la Puerta', 31105, '2021-06-01 23:56:02', 'ADMIN', NULL, NULL, 29),
(470, 'Las Huertas', 31106, '2021-06-01 23:56:18', 'ADMIN', NULL, NULL, 29),
(471, 'Minas de San Antonio', 31107, '2021-06-01 23:57:18', 'ADMIN', NULL, NULL, 29),
(472, 'Montecitos', 31108, '2021-06-01 23:57:53', 'ADMIN', NULL, NULL, 29),
(473, 'San Isidro del Mal Paso', 31110, '2021-06-01 23:58:48', 'ADMIN', NULL, NULL, 29),
(474, 'Santa Cruz', 31111, '2021-06-01 23:59:10', 'ADMIN', NULL, NULL, 29),
(475, 'Ojos de Agua', 31201, '2021-06-02 00:00:32', 'ADMIN', NULL, NULL, 30),
(476, 'Agua Blanca', 31202, '2021-06-02 00:00:48', 'ADMIN', NULL, NULL, 30),
(477, 'Buen Pastor', 31203, '2021-06-02 00:01:04', 'ADMIN', NULL, NULL, 30),
(478, 'Campo Dos', 31204, '2021-06-02 00:01:29', 'ADMIN', NULL, NULL, 30),
(479, 'Corralitos', 31205, '2021-06-02 00:01:46', 'ADMIN', NULL, NULL, 30),
(480, 'El Hielo', 31206, '2021-06-02 00:02:30', 'ADMIN', NULL, NULL, 30),
(481, 'El Payacal', 31207, '2021-06-02 00:02:57', 'ADMIN', NULL, NULL, 30),
(482, 'El Pinabetoso', 31208, '2021-06-02 00:03:13', 'ADMIN', NULL, NULL, 30),
(483, 'El Robledal', 31209, '2021-06-02 00:03:32', 'ADMIN', NULL, NULL, 30),
(484, 'La Balastrera o Buenos Aires', 31210, '2021-06-02 00:04:20', 'ADMIN', NULL, NULL, 30),
(485, 'La Candelaria', 31211, '2021-06-02 00:05:28', 'ADMIN', NULL, NULL, 30),
(486, 'La Cañada', 31212, '2021-06-02 00:06:40', 'ADMIN', NULL, NULL, 30),
(487, 'La Providencia', 31213, '2021-06-02 00:06:52', 'ADMIN', NULL, NULL, 30),
(488, 'Los Anises', 31214, '2021-06-02 00:07:07', 'ADMIN', NULL, NULL, 30),
(489, 'Los Dos Rios', 31215, '2021-06-02 00:07:23', 'ADMIN', NULL, NULL, 30),
(490, 'Los Guineos', 31216, '2021-06-02 00:07:43', 'ADMIN', NULL, NULL, 30),
(491, 'Portillo Grande', 31217, '2021-06-02 00:08:11', 'ADMIN', NULL, NULL, 30),
(492, 'San Rafael', 31218, '2021-06-02 00:08:34', 'ADMIN', NULL, NULL, 30),
(493, 'San José de Comayagua', 31401, '2021-06-02 00:10:54', 'ADMIN', NULL, NULL, 32),
(494, 'El Calichito', 31402, '2021-06-02 00:11:25', 'ADMIN', NULL, NULL, 32),
(495, 'El Chaparral', 31403, '2021-06-02 00:11:42', 'ADMIN', NULL, NULL, 32),
(496, 'El Porvenir', 31404, '2021-06-02 00:11:57', 'ADMIN', NULL, NULL, 32),
(497, 'El Zarzal', 31405, '2021-06-02 00:12:14', 'ADMIN', NULL, NULL, 32),
(498, 'Higuerones', 31406, '2021-06-02 00:12:31', 'ADMIN', NULL, NULL, 32),
(499, 'La Laguna Seca', 31407, '2021-06-02 00:12:56', 'ADMIN', NULL, NULL, 32),
(500, 'La Pimienta', 31408, '2021-06-02 00:13:15', 'ADMIN', NULL, NULL, 32),
(501, 'La Pita', 31409, '2021-06-02 00:13:27', 'ADMIN', NULL, NULL, 32),
(502, 'Las Delicias', 31410, '2021-06-02 00:13:40', 'ADMIN', NULL, NULL, 32),
(503, 'Las Anises', 31411, '2021-06-02 00:13:53', 'ADMIN', NULL, NULL, 32),
(504, 'Los llanos de San José o Sunzapote ', 31412, '2021-06-02 00:15:08', 'ADMIN', NULL, NULL, 32),
(505, 'Puerta del Potrero', 31413, '2021-06-02 00:15:37', 'ADMIN', NULL, NULL, 32),
(506, 'San José del Potrero', 31501, '2021-06-02 00:21:21', 'ADMIN', NULL, NULL, 33),
(507, 'El Chorro', 31502, '2021-06-02 00:22:30', 'ADMIN', NULL, NULL, 33),
(508, 'Minas de Plata', 31503, '2021-06-02 00:22:49', 'ADMIN', NULL, NULL, 33),
(509, 'Ojo de Agua', 31504, '2021-06-02 00:23:04', 'ADMIN', NULL, NULL, 33),
(510, 'Potreritos', 31505, '2021-06-02 00:23:17', 'ADMIN', NULL, NULL, 33),
(511, 'Quezalapa', 31506, '2021-06-02 00:23:38', 'ADMIN', NULL, NULL, 33),
(512, 'Terreritos', 31507, '2021-06-02 00:23:49', 'ADMIN', NULL, NULL, 33),
(513, 'Terreritos de Las Trancas', 31508, '2021-06-02 00:24:19', 'ADMIN', NULL, NULL, 33),
(514, 'San Luis', 31601, '2021-06-02 00:25:02', 'ADMIN', NULL, NULL, 34),
(515, 'El Tablón', 31602, '2021-06-02 00:25:21', 'ADMIN', NULL, NULL, 34),
(516, 'El Tule', 31603, '2021-06-02 00:25:37', 'ADMIN', NULL, NULL, 34),
(517, 'Las Minitas', 31604, '2021-06-02 00:25:50', 'ADMIN', NULL, NULL, 34),
(518, 'Las Quebradas', 31605, '2021-06-02 00:26:07', 'ADMIN', NULL, NULL, 34),
(519, 'Loma Pelada', 31606, '2021-06-02 00:26:21', 'ADMIN', NULL, NULL, 34),
(520, 'Los Anisales', 31607, '2021-06-02 00:26:35', 'ADMIN', NULL, NULL, 34),
(521, 'Los Puentes', 31608, '2021-06-02 00:26:46', 'ADMIN', NULL, NULL, 34),
(522, 'Los Tres Palos', 31609, '2021-06-02 00:27:04', 'ADMIN', NULL, NULL, 34),
(523, 'Los Zacatales', 31610, '2021-06-02 00:27:20', 'ADMIN', NULL, NULL, 34),
(524, 'El Plan Grande', 31611, '2021-06-02 00:27:34', 'ADMIN', NULL, NULL, 34),
(525, 'Quebrada Amarilla', 31612, '2021-06-02 00:27:51', 'ADMIN', NULL, NULL, 34),
(526, 'Trojes', 31613, '2021-06-02 00:28:05', 'ADMIN', NULL, NULL, 34),
(527, 'San Sebastián', 31701, '2021-06-02 00:29:17', 'ADMIN', NULL, NULL, 35),
(528, 'El Ojo de Agua', 31702, '2021-06-02 00:29:32', 'ADMIN', NULL, NULL, 35),
(529, 'La Peñita', 31703, '2021-06-02 00:29:53', 'ADMIN', NULL, NULL, 35),
(530, 'Siguatepeque', 31801, '2021-06-02 00:30:27', 'ADMIN', NULL, NULL, 36),
(531, 'Agua Dulce', 31802, '2021-06-02 00:30:40', 'ADMIN', NULL, NULL, 36),
(532, 'Aguas del Padre', 31803, '2021-06-02 00:30:56', 'ADMIN', NULL, NULL, 36),
(533, 'Buena Vistor del Río Bonito', 31804, '2021-06-02 00:31:23', 'ADMIN', NULL, NULL, 36),
(534, 'Chorreritas', 31805, '2021-06-02 00:31:58', 'ADMIN', NULL, NULL, 36),
(535, 'El Achiote', 31806, '2021-06-02 00:32:19', 'ADMIN', NULL, NULL, 36),
(536, 'El Caobanál', 31807, '2021-06-02 00:32:41', 'ADMIN', NULL, NULL, 36),
(537, 'El Payacal', 31808, '2021-06-02 00:33:00', 'ADMIN', NULL, NULL, 36),
(538, 'El Pito', 31809, '2021-06-02 00:33:21', 'ADMIN', NULL, NULL, 36),
(539, 'El Porvenir', 31810, '2021-06-02 00:33:37', 'ADMIN', NULL, NULL, 36),
(540, 'El Potrerón', 31811, '2021-06-02 00:33:56', 'ADMIN', NULL, NULL, 36),
(541, 'El Rincón', 31812, '2021-06-02 00:34:13', 'ADMIN', NULL, NULL, 36),
(542, 'El Sauce', 31813, '2021-06-02 00:34:24', 'ADMIN', NULL, NULL, 36),
(543, 'El Socorro', 31814, '2021-06-02 00:34:34', 'ADMIN', NULL, NULL, 36),
(544, 'El Zapote', 31815, '2021-06-02 00:34:50', 'ADMIN', NULL, NULL, 36),
(545, 'Guarajao Nuevo', 31816, '2021-06-02 00:35:09', 'ADMIN', NULL, NULL, 36),
(546, 'Guarajao Nuevo No.1', 31817, '2021-06-02 00:35:18', 'ADMIN', NULL, NULL, 36),
(547, 'La Crucita', 31818, '2021-06-02 00:35:45', 'ADMIN', NULL, NULL, 36),
(548, 'La Unión del Sute', 31819, '2021-06-02 00:35:58', 'ADMIN', NULL, NULL, 36),
(549, 'Ojo de Agua', 31820, '2021-06-02 00:36:15', 'ADMIN', NULL, NULL, 36),
(550, 'Potrerillos', 31821, '2021-06-02 00:36:29', 'ADMIN', NULL, NULL, 36),
(551, 'Río Bonito', 31822, '2021-06-02 00:36:46', 'ADMIN', NULL, NULL, 36),
(552, 'San Antonio de la Chuchilla', 31823, '2021-06-02 00:37:11', 'ADMIN', NULL, NULL, 36),
(553, 'San Ignacio', 31824, '2021-06-02 00:37:25', 'ADMIN', NULL, NULL, 36),
(554, 'San José de La Cuesta', 31825, '2021-06-02 00:37:48', 'ADMIN', NULL, NULL, 36),
(555, 'San José de Los Changuites', 31826, '2021-06-02 00:38:18', 'ADMIN', NULL, NULL, 36),
(556, 'San Cruz del Dulce', 31827, '2021-06-02 00:38:31', 'ADMIN', NULL, NULL, 36),
(557, 'Santa Rosita', 31828, '2021-06-02 00:38:48', 'ADMIN', NULL, NULL, 36),
(558, 'Taupaz', 31829, '2021-06-02 00:38:59', 'ADMIN', NULL, NULL, 36),
(559, 'Villa de San Antonio', 31901, '2021-06-02 00:41:09', 'ADMIN', NULL, NULL, 37),
(560, 'Flores', 31902, '2021-06-02 00:41:39', 'ADMIN', NULL, NULL, 37),
(561, 'Las Botijas', 31903, '2021-06-02 00:41:52', 'ADMIN', NULL, NULL, 37),
(562, 'Los Cimientos', 31904, '2021-06-02 00:42:19', 'ADMIN', NULL, NULL, 37),
(563, 'Potero Grande o Quebrada Honda', 31905, '2021-06-02 00:42:52', 'ADMIN', NULL, NULL, 37),
(564, 'Protección', 31906, '2021-06-02 00:43:07', 'ADMIN', NULL, NULL, 37),
(565, 'Las Lajas', 31907, '2021-06-02 00:44:11', 'ADMIN', NULL, NULL, 38),
(566, 'Las Lajas', 32001, '2021-06-02 00:45:32', 'ADMIN', NULL, NULL, 38),
(567, 'Buen Pastor', 32002, '2021-06-02 00:45:53', 'ADMIN', NULL, NULL, 38),
(568, 'La Dalia', 32004, '2021-06-02 00:46:18', 'ADMIN', NULL, NULL, 38),
(569, 'Las Piñas', 32005, '2021-06-02 00:46:50', 'ADMIN', NULL, NULL, 38),
(570, 'Los Portones', 32006, '2021-06-02 00:47:07', 'ADMIN', NULL, NULL, 38),
(571, 'Nueva Concepción ', 32007, '2021-06-02 00:47:33', 'ADMIN', NULL, NULL, 38),
(572, 'San Manuel de La Parra', 32008, '2021-06-02 00:47:56', 'ADMIN', NULL, NULL, 38),
(573, 'Santa Rosa', 32009, '2021-06-02 00:48:16', 'ADMIN', NULL, NULL, 38),
(574, 'Valle Sucio', 32010, '2021-06-02 00:48:29', 'ADMIN', NULL, NULL, 38),
(575, 'Taulabé', 32101, '2021-06-02 00:49:17', 'ADMIN', NULL, NULL, 39),
(576, 'Buena Vista de Varsonia', 32102, '2021-06-02 00:50:01', 'ADMIN', NULL, NULL, 39),
(577, 'Buenos Aires', 32103, '2021-06-02 00:50:14', 'ADMIN', NULL, NULL, 39),
(578, 'Camalotales', 32104, '2021-06-02 00:50:27', 'ADMIN', NULL, NULL, 39),
(579, 'Cerro Azul', 32105, '2021-06-02 00:50:38', 'ADMIN', NULL, NULL, 39),
(580, 'Choloma', 32106, '2021-06-02 00:50:49', 'ADMIN', NULL, NULL, 39),
(581, 'El Carrizal', 32107, '2021-06-02 00:51:02', 'ADMIN', NULL, NULL, 39),
(582, 'El Cerrón', 32108, '2021-06-02 00:51:15', 'ADMIN', NULL, NULL, 39),
(583, 'El Palmichal o La Fátima', 32109, '2021-06-02 00:51:33', 'ADMIN', NULL, NULL, 39),
(584, 'Jaitique', 32110, '2021-06-02 00:51:54', 'ADMIN', NULL, NULL, 39),
(585, 'Jardines', 32111, '2021-06-02 00:52:05', 'ADMIN', NULL, NULL, 39),
(586, 'La Angostura', 32112, '2021-06-02 00:52:17', 'ADMIN', NULL, NULL, 39),
(587, 'La Misión', 32113, '2021-06-02 00:52:30', 'ADMIN', NULL, NULL, 39),
(588, 'La Unión de San Antonio', 32114, '2021-06-02 00:52:53', 'ADMIN', NULL, NULL, 39),
(589, 'Las Alejandras', 32115, '2021-06-02 00:53:08', 'ADMIN', NULL, NULL, 39),
(590, 'Las Conchas', 32116, '2021-06-02 00:53:20', 'ADMIN', NULL, NULL, 39),
(591, 'Las Lajas', 32117, '2021-06-02 00:53:30', 'ADMIN', NULL, NULL, 39),
(592, 'Montañuelas', 32118, '2021-06-02 00:53:45', 'ADMIN', NULL, NULL, 39),
(593, 'Ocomán', 32119, '2021-06-02 00:54:01', 'ADMIN', NULL, NULL, 39),
(594, 'Quebraditas', 32120, '2021-06-02 00:54:19', 'ADMIN', NULL, NULL, 39),
(595, 'Terrero Blanco', 32122, '2021-06-02 00:54:55', 'ADMIN', NULL, NULL, 39),
(596, 'Vocadilla', 32123, '2021-06-02 00:55:25', 'ADMIN', NULL, NULL, 39),
(597, 'Varsovia', 32124, '2021-06-02 00:55:39', 'ADMIN', NULL, NULL, 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_alumnos_himno`
--

CREATE TABLE `tbl_alumnos_himno` (
  `Id_himno` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `id_horario_himno` bigint(20) NOT NULL,
  `aprobado` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `entregado` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_alumnos_himno`
--

INSERT INTO `tbl_alumnos_himno` (`Id_himno`, `id_persona`, `id_horario_himno`, `aprobado`, `Fecha_creacion`, `entregado`) VALUES
(18, 6, 12, 'desaprobado', '2020-10-19 19:09:14', NULL),
(19, 6, 13, 'aprobado', '2020-10-26 16:55:49', NULL),
(20, 3, 12, 'desaprobado', '2020-10-22 20:05:22', NULL),
(21, 3, 13, 'desaprobado', '2020-10-22 20:07:51', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_areas`
--

CREATE TABLE `tbl_areas` (
  `id_area` bigint(16) NOT NULL,
  `area` varchar(50) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `Fecha_creacion` time DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` time DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL,
  `id_carrera` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_areas`
--

INSERT INTO `tbl_areas` (`id_area`, `area`, `descripcion`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`, `id_carrera`) VALUES
(7, 'DISEÑO', 'analisis y diseño', '16:42:22', 'ADMIN', '16:42:26', 'ADMIN', 1),
(8, 'PROGRAMACION', 'programacion de sistemas', '16:42:57', 'ADMIN', '16:43:02', 'ADMIN', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignaturas`
--

CREATE TABLE `tbl_asignaturas` (
  `Id_asignatura` bigint(16) NOT NULL,
  `asignatura` varchar(255) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `uv` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `id_tipo_asignatura` bigint(20) DEFAULT NULL,
  `id_area` bigint(20) DEFAULT NULL,
  `id_plan_estudio` bigint(20) DEFAULT NULL,
  `id_periodo_plan` bigint(20) DEFAULT NULL,
  `equivalencias` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_asignaturas`
--

INSERT INTO `tbl_asignaturas` (`Id_asignatura`, `asignatura`, `codigo`, `uv`, `estado`, `id_tipo_asignatura`, `id_area`, `id_plan_estudio`, `id_periodo_plan`, `equivalencias`) VALUES
(9, 'TALLER DE HARDWARE I', 'TA-111', 4, 0, 1, 7, 1, 1, 'cosas'),
(10, 'METODOLOGIA DE LA PROGRAMACION', 'IA-033', 4, 0, 1, 7, 1, NULL, NULL),
(11, 'INTRODUCCION A LA INFORMATICA', 'IA-012', 4, 0, 1, 7, 1, NULL, NULL),
(16, 'LENGUAJE DE PROGRAMACION I', 'IA-044', 4, 0, 1, 8, 2, NULL, NULL),
(19, 'TALLER DE HARDWARE II', 'IA-054', 4, 0, 1, 8, 2, NULL, NULL),
(20, 'LENGUAJE DE PROGRAMACION III', 'IA-118', 4, 0, 1, NULL, NULL, NULL, NULL),
(21, 'LENGUAJE DE PROGRAMACION II', 'IA-150', 4, 0, 1, NULL, NULL, NULL, NULL),
(22, 'SISTEMAS OPERATIVOS I', 'IA-075', 4, 0, 1, NULL, NULL, NULL, NULL),
(24, 'ANALISIS NUMERICO', 'IA-222', 5, 0, 1, NULL, NULL, NULL, NULL),
(26, 'PERSPECTIVAS DE LA TECNOLOGIA INFORMATICA', 'IA-112', 4, 0, 1, NULL, NULL, NULL, NULL),
(27, 'SISTEMAS OPERATIVOS II', 'IA-096', 4, 0, 1, NULL, NULL, NULL, NULL),
(29, 'BASE DE DATOS I', 'IA-106', 4, 0, 1, NULL, NULL, NULL, NULL),
(31, 'LENGUAJE DE PROGRAMACION IV', 'IA-150', 4, 0, 1, NULL, NULL, NULL, NULL),
(32, 'TEORIA DE SISTEMAS', 'IA-127', 4, 0, 1, NULL, NULL, NULL, NULL),
(33, 'BASE DE DATOS II', 'IA-137', 4, 0, 1, NULL, NULL, NULL, NULL),
(36, 'COMUNICACION ELECTRONICA DE DATOS', 'IA-148', 4, 0, 1, NULL, NULL, NULL, NULL),
(37, 'ANALISIS Y DISEÑO DE SISTEMAS', 'IA-158', 4, 0, 1, NULL, NULL, NULL, NULL),
(38, 'RECURSOS HUMANOS EN INFORMATICA', 'IA-168', 4, 0, 1, NULL, NULL, NULL, NULL),
(40, 'REDES DE COMPUTADORAS', 'IA-179', 4, 0, 1, NULL, NULL, NULL, NULL),
(41, 'PROGRAMACION E IMPLEMENTACION DE SISTEMAS', 'IA-153', 4, 0, 1, NULL, NULL, NULL, NULL),
(42, 'ADMINISTRACION PUBLICA Y POLITICA INFORMATICA', 'IA-199', 4, 0, 1, NULL, NULL, NULL, NULL),
(44, 'ORGANIZACION Y METODOS DE LA INFORMATICA', 'IA-200', 4, 0, 1, NULL, NULL, NULL, NULL),
(45, 'GERENCIA EN INFORMATICA I', 'IA-210', 4, 0, 1, NULL, NULL, NULL, NULL),
(46, 'EVALUACION DE SISTEMAS', 'IA-220', 4, 0, 1, NULL, NULL, NULL, NULL),
(48, 'PERSPECTIVA DE LA TECNOLOGIA INFORMATICA', 'IA-231', 3, 0, 1, NULL, NULL, NULL, NULL),
(49, 'AUDITORIA EN INFORMATICA', 'IA-241', 4, 0, 1, NULL, NULL, NULL, NULL),
(50, 'GERENCIA EN INFORMATICA II', 'IA-251', 4, 0, 1, NULL, NULL, NULL, NULL),
(51, 'SEMINARIO DE INVESTIGACION', 'IA-271', 4, 0, 1, NULL, NULL, NULL, NULL),
(52, 'ADMON Y EVALUACION DE PROYECTOS EN INFORMATICA', 'IA-261', 4, 0, 1, NULL, NULL, NULL, NULL),
(53, 'COMERCIO ELECTRONICO', 'IA-1778', 4, 0, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignaturas_aprobadas`
--

CREATE TABLE `tbl_asignaturas_aprobadas` (
  `Id_asignatura_aprobada` bigint(16) NOT NULL,
  `Id_asignatura` bigint(16) NOT NULL DEFAULT 0,
  `id_persona` bigint(16) NOT NULL DEFAULT 0,
  `Fecha_creacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_asignaturas_aprobadas`
--

INSERT INTO `tbl_asignaturas_aprobadas` (`Id_asignatura_aprobada`, `Id_asignatura`, `id_persona`, `Fecha_creacion`) VALUES
(1, 27, 27, '2021-03-24 18:26:18'),
(2, 52, 27, '2021-03-24 18:26:19'),
(3, 24, 27, '2021-03-24 18:26:20'),
(4, 22, 22, '2021-03-24 18:46:52'),
(5, 27, 22, '2021-03-24 18:46:53'),
(6, 9, 22, '2021-03-24 18:46:54'),
(7, 19, 22, '2021-03-24 18:46:55'),
(8, 32, 22, '2021-03-24 18:46:57'),
(10, 52, 22, '2021-03-25 05:36:52'),
(11, 52, 27, '2021-03-25 05:48:29'),
(12, 42, 27, '2021-03-25 05:50:28'),
(13, 37, 22, '2021-03-25 05:53:26'),
(14, 49, 27, '2021-03-25 05:56:56'),
(15, 42, 26, '2021-03-26 20:24:49'),
(16, 52, 26, '2021-03-26 20:24:50'),
(17, 24, 26, '2021-03-26 20:24:51'),
(18, 37, 26, '2021-03-26 20:24:52'),
(19, 49, 26, '2021-03-26 20:24:55'),
(20, 29, 26, '2021-03-26 20:24:57'),
(21, 33, 26, '2021-03-26 20:24:58'),
(22, 36, 26, '2021-03-26 20:25:00'),
(23, 46, 26, '2021-03-26 20:25:01'),
(24, 37, 27, '2021-03-26 20:28:02'),
(25, 33, 27, '2021-03-26 20:28:06'),
(26, 36, 27, '2021-03-26 20:28:09'),
(27, 46, 27, '2021-03-26 20:28:13'),
(28, 45, 27, '2021-03-26 20:28:17'),
(29, 50, 27, '2021-03-26 20:28:18'),
(30, 11, 27, '2021-03-26 20:28:21'),
(31, 16, 27, '2021-03-26 20:28:25'),
(32, 21, 27, '2021-03-26 20:28:27'),
(33, 42, 22, '2021-03-26 20:30:06'),
(34, 24, 22, '2021-03-26 20:30:07'),
(35, 49, 22, '2021-03-26 20:30:09'),
(36, 29, 22, '2021-03-26 20:30:10'),
(37, 33, 22, '2021-03-26 20:30:11'),
(38, 42, 61, '2021-03-26 23:40:25'),
(39, 52, 61, '2021-03-26 23:40:26'),
(40, 24, 61, '2021-03-26 23:40:27'),
(41, 37, 61, '2021-03-26 23:40:28'),
(42, 49, 61, '2021-03-26 23:40:30'),
(43, 29, 61, '2021-03-26 23:40:31'),
(44, 33, 61, '2021-03-26 23:40:32'),
(45, 36, 61, '2021-03-26 23:40:33'),
(46, 46, 61, '2021-03-26 23:40:34'),
(47, 45, 61, '2021-03-26 23:40:35'),
(48, 50, 61, '2021-03-26 23:40:36'),
(49, 22, 61, '2021-03-26 23:43:12'),
(50, 27, 61, '2021-03-26 23:43:13'),
(51, 9, 61, '2021-03-26 23:43:14'),
(52, 19, 61, '2021-03-26 23:43:16'),
(53, 32, 61, '2021-03-26 23:43:17'),
(54, 42, 77, '2021-04-14 02:15:29'),
(55, 52, 77, '2021-04-14 02:15:29'),
(56, 24, 77, '2021-04-14 02:15:29'),
(57, 37, 77, '2021-04-14 02:15:29'),
(58, 49, 77, '2021-04-14 02:15:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_atributos`
--

CREATE TABLE `tbl_atributos` (
  `id_atributos` int(11) NOT NULL,
  `atributo` varchar(50) NOT NULL,
  `requerido` varchar(50) NOT NULL,
  `id_tipo_persona` int(11) NOT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_atributos`
--

INSERT INTO `tbl_atributos` (`id_atributos`, `atributo`, `requerido`, `id_tipo_persona`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'numero_empleado', '1', 1, NULL, NULL, NULL, NULL),
(3, 'fecha_ingreso', '1', 1, NULL, NULL, NULL, NULL),
(8, 'curriculum', '1', 1, NULL, NULL, NULL, NULL),
(11, 'foto', '1', 1, NULL, NULL, NULL, NULL),
(12, 'numero_cuenta', '1', 2, NULL, NULL, NULL, NULL),
(14, 'SUED', '1', 1, NULL, NULL, NULL, NULL),
(15, '20151023854', '1', 2, '2021-07-04 05:37:12', NULL, '2021-07-04 05:37:12', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_aula`
--

CREATE TABLE `tbl_aula` (
  `id_aula` bigint(16) NOT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `id_edificio` bigint(16) DEFAULT NULL,
  `id_tipo_aula` bigint(16) DEFAULT NULL,
  `Fecha_creacion` date DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` date DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_aula`
--

INSERT INTO `tbl_aula` (`id_aula`, `codigo`, `descripcion`, `capacidad`, `id_edificio`, `id_tipo_aula`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(7, '123', 'INSERT', 200, 6, 2, NULL, NULL, '2021-07-05', 'ADMIN'),
(8, '100', 'inserto', 80, 6, 1, NULL, NULL, NULL, NULL),
(9, '201', 'aula', 50, 2, 2, NULL, NULL, NULL, NULL),
(11, '404', 'AULA', 35, 6, 2, NULL, NULL, NULL, NULL),
(14, '500', 'PRUEBAS', 20, 7, 1, '2021-04-08', 'ADMIN', '2021-04-13', 'ADMIN'),
(16, '346', 'AULA', 400, 6, 2, '2021-04-08', 'ADMIN', '2021-04-08', 'ADMIN'),
(17, '203', 'AULA ', 45, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(18, '205', 'AULA', 50, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(19, '302', 'AULA', 50, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(20, '303', 'AULA', 50, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(21, '304', 'AULA', 45, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(22, '305', 'AULA', 50, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(23, '306', 'AULA', 40, 7, 2, '2021-04-09', 'ADMIN', '2021-04-13', 'ADMIN'),
(24, '200', 'AULA', 55, 1, 2, '2021-04-09', 'ADMIN', '2021-04-16', 'ADMIN'),
(25, '308', 'AULA', 35, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(26, '401', 'AULA', 46, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(27, '402', 'AULA', 52, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(28, '408', 'AULA', 45, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(29, '409', 'AULA', 50, 1, 2, '2021-04-09', 'ADMIN', NULL, NULL),
(30, '410', 'AULA', 40, 2, 2, '2021-04-09', 'ADMIN', '2021-04-16', 'ADMIN'),
(31, '554', 'FJSDFLSDFS', 50, 6, 2, '2021-07-05', 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_bitacora`
--

CREATE TABLE `tbl_bitacora` (
  `Id_bitacora` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `Id_objeto` bigint(16) NOT NULL,
  `Fecha` varchar(255) NOT NULL,
  `Accion` varchar(255) NOT NULL,
  `Descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_bitacora`
--

INSERT INTO `tbl_bitacora` (`Id_bitacora`, `Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES
(31408, 1, 114, '2021-08-08 21:51:55', 'INGRESO', 'A Horas VOAE Gestión'),
(31409, 1, 114, '2021-08-08 21:52:17', 'INSERTO', 'HORAS VOAE AL ALUMNO: Samanta Ramirez, LA CANTIDAD DE: 10 HORAS, DE LA ACTIVIDAD: '),
(31410, 1, 114, '2021-08-08 21:52:26', 'INGRESO', 'A Horas VOAE Gestión'),
(31411, 1, 114, '2021-08-08 21:52:40', 'INGRESO', 'A Actividades Externas'),
(31412, 1, 114, '2021-08-09 18:31:58', 'INGRESO', 'A Horas VOAE Gestión'),
(31413, 1, 114, '2021-08-09 18:32:01', 'INGRESO', 'A Actividades Externas'),
(31414, 1, 113, '2021-08-09 18:36:26', 'INGRESO', 'A registro de faltas'),
(31415, 1, 118, '2021-08-09 18:52:15', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31416, 1, 114, '2021-08-09 18:58:41', 'INGRESO', 'A Horas VOAE Gestión'),
(31417, 1, 114, '2021-08-09 18:58:44', 'INGRESO', 'A Actividades Externas'),
(31418, 1, 114, '2021-08-09 18:59:34', 'INSERTO', 'LA ACTIVIDAD EXTERNA: \"DEPORTES\" CON EL ID: \"104\" '),
(31419, 1, 110, '2021-08-09 19:07:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31420, 1, 110, '2021-08-09 19:07:56', 'ENVIO', 'EL No DE SOLICITUD \"13\"'),
(31421, 1, 115, '2021-08-09 19:08:13', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31422, 1, 115, '2021-08-09 19:08:40', 'APROBO', 'EL No DE SOLICITUD\"13\"'),
(31423, 1, 115, '2021-08-09 19:08:53', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31424, 1, 121, '2021-08-09 19:09:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31425, 1, 121, '2021-08-09 19:09:52', 'FINALIZO', 'EL NO DE SOLICITUD \"13\"'),
(31426, 1, 118, '2021-08-09 19:10:19', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31427, 1, 118, '2021-08-09 19:11:14', 'INSERTO', 'EL INFORME CON ID: \"\"'),
(31428, 1, 118, '2021-08-09 19:11:58', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31429, 1, 118, '2021-08-09 19:12:04', 'INGRESO', 'A LA LISTA DE ASISTENCIA DE LA ACTIVIDAD ID: 65'),
(31430, 1, 118, '2021-08-09 19:12:51', 'IMPORTO', 'LISTADO DE ASISTENCIA DE LA ACTIVIDAD CON ID \"65\", CON: 134 REGISTROS NUEVOS Y 0 ACTUALIZACIONES'),
(31431, 1, 114, '2021-08-09 19:15:06', 'INGRESO', 'A Horas VOAE Gestión'),
(31432, 1, 116, '2021-08-09 19:15:47', 'INGRESO', 'A Historial de Horas Alumno'),
(31433, 1, 114, '2021-08-09 19:16:09', 'INGRESO', 'A Horas VOAE Gestión'),
(31434, 1, 114, '2021-08-09 19:16:44', 'INSERTO', 'HORAS VOAE AL ALUMNO: Enrique  Rivera, LA CANTIDAD DE: 15 HORAS, DE LA ACTIVIDAD: DEPORTES'),
(31435, 1, 114, '2021-08-09 19:16:58', 'INGRESO', 'A Actividades Externas'),
(31436, 1, 114, '2021-08-09 19:18:08', 'INGRESO', 'A Horas VOAE Gestión'),
(31437, 1, 119, '2021-08-09 19:18:19', 'INGRESO', 'A Memorandums'),
(31438, 1, 119, '2021-08-09 19:18:55', 'INGRESO', 'A Memorandums'),
(31439, 1, 113, '2021-08-09 19:20:37', 'INGRESO', 'A registro de faltas'),
(31440, 1, 113, '2021-08-09 19:21:42', 'INSERTO', 'UNA NUEVA FALTA PARA EL ALUMNO ALUMNO: Daniel Enrique  Ramirez Rivera'),
(31441, 1, 113, '2021-08-09 19:21:42', 'INGRESO', 'A registro de faltas'),
(31442, 1, 113, '2021-08-09 19:22:59', 'INGRESO', 'A registro de faltas'),
(31443, 1, 105, '2021-08-09 19:23:22', 'INGRESO', 'A Mantenimiento de ambitos'),
(31444, 1, 105, '2021-08-09 19:23:32', 'DESACTIVO', 'EL AMBITO: DEPORTIVO'),
(31445, 1, 105, '2021-08-09 19:23:38', 'ACTIVO', 'EL AMBITO: DEPORTIVO'),
(31446, 1, 114, '2021-08-10 20:55:51', 'INGRESO', 'A Horas VOAE Gestión'),
(31447, 1, 114, '2021-08-10 20:55:54', 'INGRESO', 'A Actividades Externas'),
(31448, 1, 114, '2021-08-10 20:56:28', 'INGRESO', 'A Actividades Externas'),
(31449, 1, 114, '2021-08-10 20:56:57', 'INGRESO', 'A Actividades Externas'),
(31450, 1, 114, '2021-08-10 20:57:12', 'INGRESO', 'A Actividades Externas'),
(31451, 1, 114, '2021-08-10 20:57:27', 'INGRESO', 'A Actividades Externas'),
(31452, 1, 114, '2021-08-10 20:57:39', 'INGRESO', 'A Actividades Externas'),
(31453, 1, 114, '2021-08-10 20:58:50', 'INGRESO', 'A Actividades Externas'),
(31454, 1, 114, '2021-08-10 20:59:05', 'INGRESO', 'A Actividades Externas'),
(31455, 1, 114, '2021-08-10 21:00:24', 'INGRESO', 'A Actividades Externas'),
(31456, 1, 114, '2021-08-10 21:00:36', 'INGRESO', 'A Actividades Externas'),
(31457, 1, 114, '2021-08-10 21:00:47', 'INGRESO', 'A Actividades Externas'),
(31458, 1, 114, '2021-08-10 21:01:32', 'INGRESO', 'A Actividades Externas'),
(31459, 1, 114, '2021-08-10 21:01:48', 'INGRESO', 'A Actividades Externas'),
(31460, 1, 114, '2021-08-10 21:02:16', 'INGRESO', 'A Actividades Externas'),
(31461, 1, 114, '2021-08-10 21:03:54', 'INGRESO', 'A Actividades Externas'),
(31462, 1, 114, '2021-08-10 21:04:18', 'INGRESO', 'A Actividades Externas'),
(31463, 1, 114, '2021-08-10 21:04:45', 'INGRESO', 'A Actividades Externas'),
(31464, 1, 114, '2021-08-10 21:04:54', 'INGRESO', 'A Actividades Externas'),
(31465, 1, 114, '2021-08-10 21:05:44', 'INGRESO', 'A Actividades Externas'),
(31466, 1, 114, '2021-08-10 21:05:53', 'INGRESO', 'A Actividades Externas'),
(31467, 1, 118, '2021-08-10 21:07:53', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31468, 1, 118, '2021-08-10 21:08:01', 'INGRESO', 'A LA LISTA DE ASISTENCIA DE LA ACTIVIDAD ID: 65'),
(31469, 1, 119, '2021-08-10 21:38:56', 'INGRESO', 'A Memorandums'),
(31470, 1, 119, '2021-08-10 21:39:17', 'MODIFICO', ' EL MEMORANDUM \"NM-0001\" POR \"NM-0003\" Y LA ACTIVIDAD \"0\"POR\"\" '),
(31471, 1, 114, '2021-08-10 21:55:32', 'INGRESO', 'A Horas VOAE Gestión'),
(31472, 1, 110, '2021-08-11 18:55:28', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31473, 1, 110, '2021-08-11 18:55:46', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31474, 1, 121, '2021-08-11 18:56:10', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31475, 1, 115, '2021-08-11 18:56:13', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31476, 1, 110, '2021-08-11 18:56:20', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31477, 1, 110, '2021-08-11 18:57:02', 'INSERTO', 'LA ACTIVIDAD: \"dfdsfsd\"'),
(31478, 1, 110, '2021-08-11 18:57:05', 'ENVIO', 'EL No DE SOLICITUD \"2\"'),
(31479, 1, 115, '2021-08-11 18:57:10', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31480, 1, 110, '2021-08-11 19:07:26', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31481, 1, 110, '2021-08-11 19:10:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31482, 1, 115, '2021-08-11 19:10:10', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31483, 1, 115, '2021-08-11 19:10:52', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31484, 1, 115, '2021-08-11 19:11:19', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31485, 1, 115, '2021-08-11 19:11:25', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31486, 1, 115, '2021-08-11 19:12:09', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31487, 1, 115, '2021-08-11 19:12:23', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31488, 1, 115, '2021-08-11 19:12:36', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31489, 1, 115, '2021-08-11 19:12:44', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31490, 1, 115, '2021-08-11 19:13:01', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31491, 1, 115, '2021-08-11 19:13:18', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31492, 1, 115, '2021-08-11 19:15:41', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31493, 1, 115, '2021-08-11 19:17:18', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31494, 1, 115, '2021-08-11 19:17:46', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31495, 1, 115, '2021-08-11 19:19:15', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31496, 1, 115, '2021-08-11 19:22:21', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31497, 1, 115, '2021-08-11 19:22:57', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31498, 1, 115, '2021-08-11 19:30:26', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31499, 1, 115, '2021-08-11 19:30:44', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31500, 1, 115, '2021-08-11 19:31:05', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31501, 1, 115, '2021-08-11 19:32:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31502, 1, 115, '2021-08-11 19:33:07', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31503, 1, 115, '2021-08-11 19:33:49', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31504, 1, 115, '2021-08-11 19:34:12', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31505, 1, 114, '2021-08-11 19:35:47', 'INGRESO', 'A Horas VOAE Gestión'),
(31506, 1, 114, '2021-08-11 19:35:49', 'INGRESO', 'A Actividades Externas'),
(31507, 1, 114, '2021-08-11 19:36:27', 'INGRESO', 'A Horas VOAE Gestión'),
(31508, 1, 115, '2021-08-11 19:36:30', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31509, 1, 115, '2021-08-11 19:36:49', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31510, 1, 115, '2021-08-11 19:37:37', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31511, 1, 115, '2021-08-11 19:37:51', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31512, 1, 115, '2021-08-11 19:38:41', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31513, 1, 115, '2021-08-11 19:39:06', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31514, 1, 115, '2021-08-11 19:39:28', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31515, 1, 115, '2021-08-11 19:39:41', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31516, 1, 115, '2021-08-11 19:39:55', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31517, 1, 115, '2021-08-11 19:40:32', 'DENEGO', 'EL No DE SOLICITUD\"\"'),
(31518, 1, 115, '2021-08-11 19:41:20', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31519, 1, 115, '2021-08-11 19:41:33', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31520, 1, 115, '2021-08-11 19:43:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31521, 1, 115, '2021-08-11 19:44:24', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31522, 1, 115, '2021-08-11 19:44:36', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31523, 1, 115, '2021-08-11 19:45:49', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31524, 1, 115, '2021-08-11 19:45:52', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31525, 1, 115, '2021-08-11 19:46:00', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31526, 1, 115, '2021-08-11 19:46:04', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31527, 1, 115, '2021-08-11 19:46:14', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31528, 1, 115, '2021-08-11 19:46:24', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31529, 1, 115, '2021-08-11 19:46:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31530, 1, 115, '2021-08-11 19:46:55', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31531, 1, 115, '2021-08-11 19:48:16', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31532, 1, 115, '2021-08-11 19:51:40', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31533, 1, 115, '2021-08-11 19:52:36', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31534, 1, 115, '2021-08-11 19:53:26', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31535, 1, 115, '2021-08-11 20:42:52', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31536, 1, 114, '2021-08-11 20:49:48', 'INGRESO', 'A Horas VOAE Gestión'),
(31537, 1, 114, '2021-08-11 20:49:50', 'INGRESO', 'A Actividades Externas'),
(31538, 1, 113, '2021-08-11 20:50:01', 'INGRESO', 'A registro de faltas'),
(31539, 1, 113, '2021-08-11 20:51:13', 'INGRESO', 'A registro de faltas'),
(31540, 1, 114, '2021-08-11 20:51:26', 'INGRESO', 'A Horas VOAE Gestión'),
(31541, 1, 110, '2021-08-11 20:54:28', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31542, 1, 115, '2021-08-11 20:54:34', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31543, 1, 115, '2021-08-11 21:00:37', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31544, 1, 115, '2021-08-11 21:22:34', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31545, 1, 115, '2021-08-11 21:22:50', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31546, 1, 110, '2021-08-11 21:23:04', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31547, 1, 110, '2021-08-11 21:23:28', 'INSERTO', 'LA ACTIVIDAD: \"Cultura\"'),
(31548, 1, 110, '2021-08-11 21:23:31', 'ENVIO', 'EL No DE SOLICITUD \"13\"'),
(31549, 1, 115, '2021-08-11 21:23:35', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31550, 1, 115, '2021-08-11 21:24:08', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31551, 1, 115, '2021-08-11 21:24:21', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31552, 1, 115, '2021-08-11 21:24:32', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31553, 1, 115, '2021-08-11 21:25:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31554, 1, 115, '2021-08-11 21:25:49', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31555, 1, 115, '2021-08-11 21:27:22', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31556, 1, 115, '2021-08-11 21:27:35', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31557, 1, 115, '2021-08-11 21:28:11', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31558, 1, 115, '2021-08-11 21:28:16', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31559, 1, 115, '2021-08-11 21:29:16', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31560, 1, 115, '2021-08-11 21:29:40', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31561, 1, 115, '2021-08-11 21:38:57', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31562, 1, 115, '2021-08-11 21:39:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31563, 1, 115, '2021-08-11 21:40:08', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31564, 1, 115, '2021-08-11 21:40:16', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31565, 1, 115, '2021-08-11 21:40:40', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31566, 1, 115, '2021-08-11 21:40:45', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31567, 1, 115, '2021-08-11 21:41:38', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31568, 1, 115, '2021-08-11 21:41:50', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31569, 1, 114, '2021-08-12 18:12:04', 'INGRESO', 'A Horas VOAE Gestión'),
(31570, 1, 110, '2021-08-12 18:14:32', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31571, 1, 110, '2021-08-12 18:15:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31572, 1, 110, '2021-08-12 18:15:20', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31573, 1, 115, '2021-08-12 18:16:18', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31574, 1, 115, '2021-08-12 18:17:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31575, 1, 115, '2021-08-12 18:18:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31576, 1, 115, '2021-08-12 18:19:05', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31577, 1, 115, '2021-08-12 18:19:23', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31578, 1, 115, '2021-08-12 18:20:00', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31579, 1, 110, '2021-08-12 18:40:20', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31580, 1, 114, '2021-08-12 18:42:40', 'INGRESO', 'A Horas VOAE Gestión'),
(31581, 1, 114, '2021-08-12 18:42:47', 'INGRESO', 'A Actividades Externas'),
(31582, 1, 114, '2021-08-12 18:43:06', 'INGRESO', 'A Horas VOAE Gestión'),
(31583, 1, 118, '2021-08-12 18:43:30', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31584, 1, 118, '2021-08-12 18:44:29', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31585, 1, 118, '2021-08-12 18:45:52', 'MODIFICO', 'EL INFORME CON ID: \"8\"'),
(31586, 1, 118, '2021-08-12 18:46:37', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31587, 1, 110, '2021-08-14 22:49:10', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31588, 1, 110, '2021-08-14 22:50:16', 'INSERTO', 'LA ACTIVIDAD: \"TORNEO VOLEIBOL\"'),
(31589, 1, 110, '2021-08-14 22:55:03', 'ENVIO', 'EL No DE SOLICITUD \"13\"'),
(31590, 1, 115, '2021-08-14 22:57:24', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31591, 1, 121, '2021-08-14 23:04:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31592, 1, 121, '2021-08-14 23:05:01', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31593, 1, 118, '2021-08-14 23:09:01', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31594, 1, 118, '2021-08-14 23:14:23', 'INGRESO', 'A LA LISTA DE ASISTENCIA DE LA ACTIVIDAD ID: 65'),
(31595, 1, 118, '2021-08-14 23:15:45', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31596, 1, 121, '2021-08-14 23:15:48', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31597, 1, 113, '2021-08-14 23:17:38', 'INGRESO', 'A registro de faltas'),
(31598, 1, 113, '2021-08-14 23:22:02', 'ELIMINO', ' LA FALTA CON EL ID 83: DEL ALUMNO: Fredy andersson MOTINO FLORES'),
(31599, 1, 119, '2021-08-14 23:22:07', 'INGRESO', 'A Memorandums'),
(31600, 1, 114, '2021-08-14 23:26:53', 'INGRESO', 'A Horas VOAE Gestión'),
(31601, 1, 116, '2021-08-14 23:30:48', 'INGRESO', 'A Historial de Horas Alumno'),
(31602, 1, 114, '2021-08-14 23:30:51', 'INGRESO', 'A Horas VOAE Gestión'),
(31603, 1, 116, '2021-08-14 23:30:52', 'INGRESO', 'A Historial de Horas Alumno'),
(31604, 1, 114, '2021-08-14 23:34:05', 'INGRESO', 'A Horas VOAE Gestión'),
(31605, 1, 114, '2021-08-14 23:34:09', 'INGRESO', 'A Actividades Externas'),
(31606, 1, 121, '2021-08-15 18:31:01', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31607, 1, 115, '2021-08-15 18:31:11', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31608, 1, 115, '2021-08-15 18:35:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31609, 1, 115, '2021-08-15 18:36:00', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31610, 1, 115, '2021-08-15 18:36:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31611, 1, 115, '2021-08-15 18:37:59', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31612, 1, 115, '2021-08-15 18:39:18', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31613, 1, 115, '2021-08-15 18:40:37', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31614, 1, 115, '2021-08-15 18:40:42', 'DENEGO', 'EL No DE SOLICITUD DE ACTIVIDAD\"13\"'),
(31615, 1, 115, '2021-08-15 18:41:00', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31616, 1, 8, '2021-08-15 18:41:25', 'Ingreso', 'A Bitacora del sistema'),
(31617, 1, 115, '2021-08-15 18:41:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31618, 1, 115, '2021-08-15 18:42:10', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31619, 1, 115, '2021-08-15 18:42:25', 'DENEGO', 'EL No DE SOLICITUD DE ACTIVIDAD \"2\"'),
(31620, 1, 115, '2021-08-15 18:45:27', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31621, 1, 115, '2021-08-15 18:46:00', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31622, 1, 115, '2021-08-15 18:46:16', 'DENEGO', 'EL No DE SOLICITUD DE ACTIVIDAD \"2\"'),
(31623, 1, 121, '2021-08-15 18:47:02', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31624, 1, 121, '2021-08-15 18:49:25', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31625, 1, 121, '2021-08-15 18:49:29', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31626, 1, 121, '2021-08-15 18:49:41', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31627, 1, 121, '2021-08-15 18:50:15', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31628, 1, 121, '2021-08-15 18:50:29', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31629, 1, 121, '2021-08-15 18:50:48', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31630, 1, 121, '2021-08-15 18:50:53', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31631, 1, 121, '2021-08-15 18:52:27', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31632, 1, 121, '2021-08-15 18:52:35', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31633, 1, 121, '2021-08-15 18:53:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31634, 1, 121, '2021-08-15 18:58:17', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31635, 1, 121, '2021-08-15 18:58:27', 'CANCELO', 'EL No DE SOLICITUD DE ACTIVIDAD \"\"'),
(31636, 1, 8, '2021-08-15 18:58:44', 'Ingreso', 'A Bitacora del sistema'),
(31637, 1, 121, '2021-08-15 19:00:46', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31638, 1, 121, '2021-08-15 19:01:24', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31639, 1, 121, '2021-08-15 19:01:50', 'CANCELO', 'LA ACTIVIDAD \"TORNEO VOLEIBOL\"'),
(31640, 1, 110, '2021-08-15 19:02:19', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31641, 1, 121, '2021-08-15 19:03:25', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31642, 1, 115, '2021-08-15 19:03:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31643, 1, 121, '2021-08-15 19:03:39', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31644, 1, 121, '2021-08-15 19:04:02', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31645, 1, 121, '2021-08-15 19:04:09', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31646, 1, 121, '2021-08-15 19:05:01', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31647, 1, 121, '2021-08-15 19:05:10', 'FINALIZO', 'EL NO DE SOLICITUD \"13\"'),
(31648, 1, 121, '2021-08-15 19:05:34', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31649, 1, 121, '2021-08-15 19:05:53', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31650, 1, 121, '2021-08-15 19:06:00', 'FINALIZO', 'EL NO DE SOLICITUD \"22\"'),
(31651, 1, 121, '2021-08-15 19:06:07', 'FINALIZO', 'EL NO DE SOLICITUD \"13\"'),
(31652, 1, 121, '2021-08-15 19:06:10', 'CANCELO', 'LA ACTIVIDAD \"DEPORTES\"'),
(31653, 1, 121, '2021-08-15 19:06:17', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31654, 1, 115, '2021-08-15 19:06:19', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31655, 1, 105, '2021-08-15 19:10:39', 'INGRESO', 'A Mantenimiento de ambitos'),
(31656, 1, 110, '2021-08-15 19:11:41', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31657, 1, 115, '2021-08-15 19:11:44', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31658, 1, 121, '2021-08-15 19:11:48', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31659, 1, 105, '2021-08-15 19:12:38', 'INGRESO', 'A Mantenimiento de ambitos'),
(31660, 1, 120, '2021-08-15 19:14:07', 'INGRESO', 'A Mantenimiento de tipo Meorandum'),
(31661, 1, 120, '2021-08-15 19:15:37', 'INGRESO', 'A Mantenimiento de tipo Meorandum'),
(31662, 1, 120, '2021-08-15 19:15:58', 'INGRESO', 'A Mantenimiento de tipo Meorandum'),
(31663, 1, 105, '2021-08-15 19:16:14', 'INGRESO', 'A Mantenimiento de ambitos'),
(31664, 1, 106, '2021-08-15 19:16:21', 'INGRESO', 'A Mantenimiento de estados'),
(31665, 1, 107, '2021-08-15 19:16:25', 'INGRESO', 'A Mantenimiento de repositorios'),
(31666, 1, 112, '2021-08-15 19:16:30', 'INGRESO', 'A Mantenimiento de tipos faltas'),
(31667, 1, 110, '2021-08-15 21:57:47', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31668, 1, 110, '2021-08-15 21:59:59', 'INSERTO', 'LA ACTIVIDAD: \"Actividad de Baile\"'),
(31669, 1, 115, '2021-08-15 22:04:56', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31670, 1, 121, '2021-08-15 22:07:04', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31671, 1, 118, '2021-08-15 22:09:35', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31672, 1, 118, '2021-08-15 22:09:50', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31673, 1, 118, '2021-08-15 22:17:24', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31674, 1, 118, '2021-08-15 22:17:30', 'INGRESO', 'A LA LISTA DE ASISTENCIA DE LA ACTIVIDAD ID: 65'),
(31675, 1, 118, '2021-08-15 22:18:40', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31676, 1, 113, '2021-08-15 22:18:45', 'INGRESO', 'A registro de faltas'),
(31677, 1, 113, '2021-08-15 22:21:50', 'INGRESO', 'A registro de faltas'),
(31678, 1, 119, '2021-08-15 22:21:54', 'INGRESO', 'A Memorandums'),
(31679, 1, 119, '2021-08-15 22:24:06', 'INGRESO', 'A Memorandums'),
(31680, 1, 114, '2021-08-15 22:24:10', 'INGRESO', 'A Horas VOAE Gestión'),
(31681, 1, 116, '2021-08-15 22:26:09', 'INGRESO', 'A Historial de Horas Alumno'),
(31682, 1, 114, '2021-08-15 22:26:39', 'INGRESO', 'A Horas VOAE Gestión'),
(31683, 1, 116, '2021-08-15 22:27:13', 'INGRESO', 'A Historial de Horas Alumno'),
(31684, 1, 114, '2021-08-15 22:31:33', 'INGRESO', 'A Horas VOAE Gestión'),
(31685, 1, 114, '2021-08-15 22:31:38', 'INGRESO', 'A Horas VOAE Gestión'),
(31686, 1, 114, '2021-08-15 22:31:41', 'INGRESO', 'A Actividades Externas'),
(31687, 1, 114, '2021-08-15 22:35:32', 'INGRESO', 'A Horas VOAE Gestión'),
(31688, 1, 105, '2021-08-15 22:36:37', 'INGRESO', 'A Mantenimiento de ambitos'),
(31689, 1, 105, '2021-08-15 22:38:16', 'DESACTIVO', 'EL AMBITO: SOCIAL'),
(31690, 1, 106, '2021-08-15 22:41:10', 'INGRESO', 'A Mantenimiento de estados'),
(31691, 1, 107, '2021-08-15 22:43:59', 'INGRESO', 'A Mantenimiento de repositorios'),
(31692, 1, 112, '2021-08-15 22:45:51', 'INGRESO', 'A Mantenimiento de tipos faltas'),
(31693, 1, 120, '2021-08-15 22:48:01', 'INGRESO', 'A Mantenimiento de tipo Meorandum'),
(31694, 1, 8, '2021-08-15 22:51:22', 'Ingreso', 'A Bitacora del sistema'),
(31695, 1, 10, '2021-08-15 22:52:21', 'Ingreso', 'A Gestion de permisos usuarios'),
(31696, 1, 10, '2021-08-15 22:54:59', 'Ingreso', 'A Gestion de permisos usuarios'),
(31697, 1, 10, '2021-08-15 22:55:10', 'Ingreso', 'A Gestion de permisos usuarios'),
(31698, 1, 110, '2021-08-16 19:55:08', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31699, 1, 110, '2021-08-16 19:56:23', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31700, 1, 110, '2021-08-16 19:57:11', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31701, 1, 110, '2021-08-16 19:59:08', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31702, 1, 110, '2021-08-16 19:59:13', 'MODIFICO', 'EL PERIODO DE LA ACTIVIDAD: PRIMER PERIODO POR:  '),
(31703, 1, 110, '2021-08-16 20:00:09', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31704, 1, 110, '2021-08-16 20:01:22', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31705, 1, 110, '2021-08-16 20:02:31', 'MODIFICO', 'EL PERIODO DE LA ACTIVIDAD:  POR: Primer Periodo '),
(31706, 1, 110, '2021-08-16 20:06:42', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31707, 1, 110, '2021-08-16 20:06:54', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31708, 1, 110, '2021-08-16 20:08:22', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31709, 1, 110, '2021-08-16 20:08:56', 'INSERTO', 'LA ACTIVIDAD: \"Cultura\"'),
(31710, 1, 110, '2021-08-16 20:09:58', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31711, 1, 110, '2021-08-16 20:10:24', 'INSERTO', 'LA ACTIVIDAD: \"Prueba\"'),
(31712, 1, 115, '2021-08-16 20:10:37', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31713, 1, 110, '2021-08-16 20:10:56', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31714, 1, 110, '2021-08-16 20:11:12', 'MODIFICO', 'LA UBICACION DE LA ACTIVIDAD: POLIDEPORTIVO UNAH POR: UNAH '),
(31715, 1, 110, '2021-08-16 20:13:18', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31716, 1, 110, '2021-08-16 20:13:24', 'INSERTO', 'LA ACTIVIDAD: \"ACTIVIDAD DE BAILE\"'),
(31717, 1, 110, '2021-08-16 20:17:15', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31718, 1, 110, '2021-08-16 20:17:30', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31719, 1, 110, '2021-08-16 20:18:04', 'INSERTO', 'LA ACTIVIDAD: \"ACTIVIDAD DE BAILE\"'),
(31720, 1, 110, '2021-08-16 20:19:24', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31721, 1, 110, '2021-08-16 20:19:31', 'INSERTO', 'LA ACTIVIDAD: \"ACTIVIDAD DE BAILE\"'),
(31722, 1, 110, '2021-08-16 20:19:38', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31723, 1, 110, '2021-08-16 20:19:41', 'INSERTO', 'LA ACTIVIDAD: \"ACTIVIDAD DE BAILE\"'),
(31724, 1, 110, '2021-08-16 20:20:19', 'INSERTO', 'LA ACTIVIDAD: \"ACTIVIDAD DE BAILE\"'),
(31725, 1, 110, '2021-08-16 20:20:39', 'INSERTO', 'LA ACTIVIDAD: \"Cultura\"'),
(31726, 1, 110, '2021-08-16 20:21:21', 'INSERTO', 'LA ACTIVIDAD: \"ACTIVIDAD DE BAILE\"'),
(31727, 1, 110, '2021-08-16 20:21:30', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31728, 1, 110, '2021-08-16 20:21:33', 'INSERTO', 'LA ACTIVIDAD: \"ACTIVIDAD DE BAILE\"'),
(31729, 1, 121, '2021-08-16 20:22:45', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31730, 1, 115, '2021-08-16 20:22:50', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31731, 1, 115, '2021-08-16 20:22:55', 'APROBO', 'EL No DE SOLICITUD\"15\"'),
(31732, 1, 121, '2021-08-16 20:23:00', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31733, 1, 121, '2021-08-16 20:23:05', 'CANCELO', 'LA ACTIVIDAD \"ACTIVIDAD DE BAILE\"'),
(31734, 1, 9, '2021-08-24 17:38:30', 'Ingreso', 'A Permisos a roles y pantallas'),
(31735, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Menú Mantenimiento CVE'),
(31736, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Mantenimiento Ámbitos CVE'),
(31737, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Mantenimiento Estados CVE'),
(31738, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Mantenimiento Tipos de Repositorio CVE'),
(31739, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Mantenimiento Tipos de Faltas CVE'),
(31740, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Menú Actividades CVE'),
(31741, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Solicitud de Actividades CVE'),
(31742, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Registro Faltas Menú CVE'),
(31743, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Registro Falta CVE Vista'),
(31744, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Horas Voae CVE'),
(31745, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Gestión Actividades CVE'),
(31746, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Historial Alumnos CVE'),
(31747, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Menu Documentación'),
(31748, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Informe Actividad Vista CVE'),
(31749, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Memorandums Vista CVE'),
(31750, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Tipos de Memorandums Vista CVE'),
(31751, 1, 8, '2021-08-24 17:39:08', 'INSERTO', 'EL PERMISO Finalizar Actividades CVE'),
(31752, 1, 9, '2021-08-24 17:39:08', 'Ingreso', 'A Permisos a roles y pantallas'),
(31753, 1, 228, '2021-08-24 17:39:14', 'INGRESO', 'A Horas VOAE Gestión'),
(31754, 1, 228, '2021-08-24 17:41:38', 'INGRESO', 'A Horas VOAE Gestión'),
(31755, 1, 228, '2021-08-24 17:41:42', 'INGRESO', 'A Actividades Externas'),
(31756, 1, 228, '2021-08-24 17:41:57', 'INSERTO', 'LA ACTIVIDAD EXTERNA: \"Prueba\" CON EL ID: \"111\" '),
(31757, 1, 220, '2021-08-24 17:42:15', 'INGRESO', 'A Mantenimiento de ambitos'),
(31758, 1, 220, '2021-08-24 17:42:18', 'ACTIVO', 'EL AMBITO: SOCIAL'),
(31759, 1, 220, '2021-08-24 17:45:38', 'INGRESO', 'A Mantenimiento de ambitos'),
(31760, 1, 228, '2021-08-24 17:45:40', 'INGRESO', 'A Horas VOAE Gestión'),
(31761, 1, 228, '2021-08-24 17:45:42', 'INGRESO', 'A Actividades Externas'),
(31762, 1, 228, '2021-08-24 17:45:55', 'INSERTO', 'LA ACTIVIDAD EXTERNA: \"CULTURADSDS\" CON EL ID: \"111\" '),
(31763, 1, 228, '2021-08-24 17:46:12', 'ELIMINO', 'LA ACTIVIDAD EXTERNA: \"DEPORTES\" CON EL ID: \"104\" '),
(31764, 1, 235, '2021-08-24 17:48:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31765, 1, 229, '2021-08-24 17:48:22', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31766, 1, 229, '2021-08-24 17:48:30', 'APROBO', 'EL No DE SOLICITUD\"13\"'),
(31767, 1, 235, '2021-08-24 17:48:32', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31768, 1, 232, '2021-08-24 17:48:36', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31769, 1, 232, '2021-08-24 17:48:45', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31770, 1, 225, '2021-08-26 10:11:48', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31771, 1, 10, '2021-08-26 10:15:13', 'Ingreso', 'A Gestion de permisos usuarios'),
(31772, 1, 9, '2021-08-26 10:15:27', 'Ingreso', 'A Permisos a roles y pantallas'),
(31773, 1, 8, '2021-08-26 10:15:39', 'INSERTO', 'EL PERMISO Reporte Actividades CVE'),
(31774, 1, 9, '2021-08-26 10:15:39', 'Ingreso', 'A Permisos a roles y pantallas'),
(31775, 1, 10, '2021-08-26 10:15:45', 'Ingreso', 'A Gestion de permisos usuarios'),
(31776, 1, 228, '2021-08-26 10:15:57', 'INGRESO', 'A Horas VOAE Gestión'),
(31777, 1, 236, '2021-08-26 10:16:04', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31778, 1, 236, '2021-08-26 10:19:04', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31779, 1, 236, '2021-08-26 10:19:33', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31780, 1, 236, '2021-08-26 10:21:25', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31781, 1, 236, '2021-08-26 10:25:24', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31782, 1, 236, '2021-08-26 10:26:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31783, 1, 236, '2021-08-26 10:27:33', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31784, 1, 236, '2021-08-26 10:27:37', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31785, 1, 236, '2021-08-26 10:28:09', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31786, 1, 236, '2021-08-26 10:28:22', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31787, 1, 236, '2021-08-26 10:29:12', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31788, 1, 236, '2021-08-26 10:29:32', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31789, 1, 236, '2021-08-26 10:29:53', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31790, 1, 236, '2021-08-26 10:30:14', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31791, 1, 236, '2021-08-26 10:30:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31792, 1, 236, '2021-08-26 10:31:16', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31793, 1, 236, '2021-08-26 10:32:13', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31794, 1, 236, '2021-08-26 10:32:26', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31795, 1, 236, '2021-08-26 10:32:54', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31796, 1, 236, '2021-08-26 10:33:26', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31797, 1, 236, '2021-08-26 10:34:41', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31798, 1, 236, '2021-08-26 10:35:57', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31799, 1, 236, '2021-08-26 10:36:53', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31800, 1, 236, '2021-08-26 10:37:56', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31801, 1, 236, '2021-08-26 10:38:29', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31802, 1, 236, '2021-08-26 10:38:45', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31803, 1, 236, '2021-08-26 10:40:50', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31804, 1, 236, '2021-08-26 10:41:08', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31805, 1, 236, '2021-08-26 10:44:24', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31806, 1, 236, '2021-08-26 10:45:03', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31807, 1, 236, '2021-08-26 10:45:22', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31808, 1, 236, '2021-08-26 10:45:32', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31809, 1, 236, '2021-08-26 10:46:27', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31810, 1, 236, '2021-08-26 10:46:47', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31811, 1, 236, '2021-08-26 10:47:19', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31812, 1, 236, '2021-08-26 10:47:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31813, 1, 236, '2021-08-26 10:48:16', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31814, 1, 236, '2021-08-26 10:48:41', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31815, 1, 236, '2021-08-26 10:49:10', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31816, 1, 236, '2021-08-26 10:49:34', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31817, 1, 236, '2021-08-26 10:49:55', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31818, 1, 236, '2021-08-26 10:53:59', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31819, 1, 236, '2021-08-26 10:55:45', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31820, 1, 236, '2021-08-26 10:56:47', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31821, 1, 236, '2021-08-26 10:57:07', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31822, 1, 236, '2021-08-26 10:57:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31823, 1, 236, '2021-08-26 10:57:59', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31824, 1, 236, '2021-08-26 10:58:22', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31825, 1, 228, '2021-09-17 20:15:35', 'INGRESO', 'A Horas VOAE Gestión'),
(31826, 1, 230, '2021-09-17 20:16:10', 'INGRESO', 'A Historial de Horas Alumno'),
(31827, 1, 228, '2021-09-17 20:16:18', 'INGRESO', 'A Horas VOAE Gestión'),
(31828, 1, 228, '2021-09-17 20:16:27', 'INGRESO', 'A Actividades Externas'),
(31829, 1, 228, '2021-09-17 20:16:29', 'INGRESO', 'A Horas VOAE Gestión'),
(31830, 1, 227, '2021-09-17 20:16:33', 'INGRESO', 'A registro de faltas'),
(31831, 1, 227, '2021-09-17 20:19:00', 'INGRESO', 'A registro de faltas'),
(31832, 1, 227, '2021-09-17 20:53:34', 'INGRESO', 'A registro de faltas'),
(31833, 1, 227, '2021-09-17 20:54:30', 'INGRESO', 'A registro de faltas'),
(31834, 1, 227, '2021-09-17 20:55:54', 'INGRESO', 'A registro de faltas'),
(31835, 1, 227, '2021-09-17 20:56:27', 'INGRESO', 'A registro de faltas'),
(31836, 1, 227, '2021-09-17 20:56:42', 'INGRESO', 'A registro de faltas'),
(31837, 1, 227, '2021-09-17 20:57:32', 'INGRESO', 'A registro de faltas'),
(31838, 1, 227, '2021-09-17 20:58:48', 'INGRESO', 'A registro de faltas'),
(31839, 1, 227, '2021-09-17 20:58:55', 'INGRESO', 'A registro de faltas'),
(31840, 1, 227, '2021-09-17 20:59:18', 'INGRESO', 'A registro de faltas'),
(31841, 1, 227, '2021-09-17 20:59:57', 'INGRESO', 'A registro de faltas'),
(31842, 1, 227, '2021-09-17 21:01:19', 'INGRESO', 'A registro de faltas'),
(31843, 1, 227, '2021-09-17 21:01:31', 'INGRESO', 'A registro de faltas'),
(31844, 1, 227, '2021-09-17 21:02:12', 'INGRESO', 'A registro de faltas'),
(31845, 1, 227, '2021-09-17 21:02:54', 'INGRESO', 'A registro de faltas'),
(31846, 1, 227, '2021-09-17 21:04:40', 'INGRESO', 'A registro de faltas'),
(31847, 1, 227, '2021-09-17 21:04:57', 'INGRESO', 'A registro de faltas'),
(31848, 1, 227, '2021-09-17 21:07:21', 'INGRESO', 'A registro de faltas'),
(31849, 1, 227, '2021-09-17 21:07:36', 'INGRESO', 'A registro de faltas'),
(31850, 1, 227, '2021-09-17 21:09:48', 'INGRESO', 'A registro de faltas'),
(31851, 1, 227, '2021-09-17 21:10:06', 'INGRESO', 'A registro de faltas'),
(31852, 1, 227, '2021-09-17 21:10:18', 'INGRESO', 'A registro de faltas'),
(31853, 1, 227, '2021-09-17 21:10:28', 'INGRESO', 'A registro de faltas'),
(31854, 1, 228, '2021-09-17 21:11:23', 'INGRESO', 'A Horas VOAE Gestión'),
(31855, 1, 228, '2021-09-17 21:11:26', 'INGRESO', 'A Actividades Externas'),
(31856, 1, 228, '2021-09-17 21:11:32', 'INGRESO', 'A Horas VOAE Gestión'),
(31857, 1, 225, '2021-09-17 21:11:39', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31858, 1, 235, '2021-09-17 21:11:46', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31859, 1, 228, '2021-09-17 21:11:54', 'INGRESO', 'A Horas VOAE Gestión'),
(31860, 1, 228, '2021-09-17 21:11:56', 'INGRESO', 'A Actividades Externas'),
(31861, 1, 227, '2021-09-20 09:00:21', 'INGRESO', 'A registro de faltas'),
(31862, 1, 227, '2021-09-20 09:00:41', 'ELIMINO', ' LA FALTA CON EL ID 84: DEL ALUMNO: Lisa Lucas'),
(31863, 1, 227, '2021-09-20 09:00:44', 'ELIMINO', ' LA FALTA CON EL ID 82: DEL ALUMNO: Lisa Lucas'),
(31864, 1, 227, '2021-09-20 09:00:49', 'INGRESO', 'A registro de faltas'),
(31865, 1, 228, '2021-09-20 09:01:09', 'INGRESO', 'A Horas VOAE Gestión'),
(31866, 1, 236, '2021-09-20 09:01:20', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31867, 1, 236, '2021-09-20 09:01:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31868, 1, 235, '2021-09-20 09:02:04', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31869, 1, 235, '2021-09-20 09:11:08', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31870, 1, 235, '2021-09-20 09:11:51', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31871, 1, 235, '2021-09-20 09:13:20', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31872, 1, 235, '2021-09-20 09:13:51', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31873, 1, 235, '2021-09-20 09:14:55', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31874, 1, 235, '2021-09-20 09:15:39', 'CANCELO', 'LA ACTIVIDAD \"CULTURA\"'),
(31875, 1, 235, '2021-09-20 09:16:13', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31876, 1, 235, '2021-09-20 09:16:32', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31877, 1, 235, '2021-09-20 09:16:45', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31878, 1, 232, '2021-09-20 09:16:50', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31879, 1, 235, '2021-09-20 09:20:31', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31880, 1, 232, '2021-09-20 09:20:35', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31881, 1, 235, '2021-09-20 09:20:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31882, 1, 229, '2021-09-20 09:20:47', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31883, 1, 229, '2021-09-20 09:20:55', 'APROBO', 'EL No DE SOLICITUD\"2\"'),
(31884, 1, 235, '2021-09-20 09:21:01', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31885, 1, 235, '2021-09-20 09:21:19', 'FINALIZO', 'EL NO DE SOLICITUD \"2\"'),
(31886, 1, 232, '2021-09-20 09:21:24', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31887, 1, 232, '2021-09-20 09:22:35', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31888, 1, 232, '2021-09-20 09:23:16', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31889, 1, 3, '2021-09-20 09:28:14', 'Ingreso', 'A Crear Usuarios'),
(31890, 1, 9, '2021-09-20 09:32:38', 'Ingreso', 'A Permisos a roles y pantallas'),
(31891, 1, 8, '2021-09-20 09:33:51', 'INSERTO', 'EL PERMISO Menú Actividades CVE'),
(31892, 1, 8, '2021-09-20 09:33:51', 'INSERTO', 'EL PERMISO Solicitud de Actividades CVE'),
(31893, 1, 8, '2021-09-20 09:33:51', 'INSERTO', 'EL PERMISO Horas Voae CVE'),
(31894, 1, 8, '2021-09-20 09:33:51', 'INSERTO', 'EL PERMISO Historial Alumnos CVE'),
(31895, 1, 8, '2021-09-20 09:33:51', 'INSERTO', 'EL PERMISO Menu Documentación'),
(31896, 1, 8, '2021-09-20 09:33:51', 'INSERTO', 'EL PERMISO Informe Actividad Vista CVE'),
(31897, 1, 8, '2021-09-20 09:33:51', 'INSERTO', 'EL PERMISO Finalizar Actividades CVE'),
(31898, 1, 9, '2021-09-20 09:33:51', 'Ingreso', 'A Permisos a roles y pantallas'),
(31899, 1, 10, '2021-09-20 09:34:14', 'Ingreso', 'A Gestion de permisos usuarios'),
(31900, 1, 10, '2021-09-20 09:34:34', 'Ingreso', 'A Gestion de permisos usuarios'),
(31901, 1, 10, '2021-09-20 09:34:38', 'MODIFICO', 'EL INSERTAR AACTIVO,EL MODIFICAR AACTIVO ,EL ELIMINAR AACTIVO ,EL VISUALIZAR AINACTIVO '),
(31902, 1, 10, '2021-09-20 09:34:38', 'Ingreso', 'A Gestion de permisos usuarios'),
(31903, 59, 235, '2021-09-20 09:37:46', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31904, 59, 235, '2021-09-20 09:40:04', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31905, 59, 228, '2021-09-20 09:41:41', 'INGRESO', 'A Horas VOAE Gestión'),
(31906, 59, 228, '2021-09-20 09:41:43', 'INGRESO', 'A Actividades Externas'),
(31907, 59, 228, '2021-09-20 09:41:47', 'INGRESO', 'A Horas VOAE Gestión'),
(31908, 59, 228, '2021-09-20 09:41:53', 'INGRESO', 'A Horas VOAE Gestión'),
(31909, 59, 232, '2021-09-20 09:44:56', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31910, 1, 10, '2021-09-20 09:52:23', 'Ingreso', 'A Gestion de permisos usuarios'),
(31911, 1, 10, '2021-09-20 09:52:42', 'Ingreso', 'A Gestion de permisos usuarios'),
(31912, 1, 10, '2021-09-20 09:52:45', 'MODIFICO', 'EL INSERTAR AACTIVO,EL MODIFICAR AACTIVO ,EL ELIMINAR AACTIVO ,EL VISUALIZAR AACTIVO '),
(31913, 1, 10, '2021-09-20 09:52:45', 'Ingreso', 'A Gestion de permisos usuarios'),
(31914, 1, 9, '2021-09-20 09:54:03', 'Ingreso', 'A Permisos a roles y pantallas'),
(31915, 1, 8, '2021-09-20 09:54:40', 'INSERTO', 'EL PERMISO Gestión Actividades CVE'),
(31916, 1, 8, '2021-09-20 09:54:40', 'INSERTO', 'EL PERMISO Reporte Actividades CVE'),
(31917, 1, 9, '2021-09-20 09:54:40', 'Ingreso', 'A Permisos a roles y pantallas'),
(31918, 1, 10, '2021-09-20 09:55:06', 'Ingreso', 'A Gestion de permisos usuarios'),
(31919, 1, 10, '2021-09-20 09:55:24', 'Ingreso', 'A Gestion de permisos usuarios'),
(31920, 1, 10, '2021-09-20 09:55:29', 'MODIFICO', 'EL INSERTAR AINACTIVO,EL MODIFICAR AINACTIVO ,EL ELIMINAR AINACTIVO ,EL VISUALIZAR AINACTIVO '),
(31921, 1, 10, '2021-09-20 09:55:29', 'Ingreso', 'A Gestion de permisos usuarios'),
(31922, 59, 225, '2021-09-20 09:56:45', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31923, 59, 225, '2021-09-20 09:58:13', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31924, 59, 225, '2021-09-20 09:59:36', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31925, 59, 235, '2021-09-20 09:59:42', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31926, 59, 232, '2021-09-20 09:59:46', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31927, 1, 225, '2021-09-20 13:50:53', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31928, 1, 235, '2021-09-20 13:50:57', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31929, 1, 235, '2021-09-20 13:51:28', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31930, 1, 235, '2021-09-20 13:51:49', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31931, 1, 225, '2021-09-20 13:52:10', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31932, 1, 225, '2021-09-20 13:52:19', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31933, 1, 225, '2021-09-20 13:53:17', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31934, 1, 235, '2021-09-20 13:55:23', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31935, 1, 235, '2021-09-20 13:55:54', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31936, 1, 235, '2021-09-20 13:58:07', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31937, 1, 232, '2021-09-20 13:58:11', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31938, 1, 232, '2021-09-20 13:58:50', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31939, 1, 232, '2021-09-20 13:58:58', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31940, 1, 232, '2021-09-20 13:59:02', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31941, 1, 232, '2021-09-20 13:59:43', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31942, 1, 232, '2021-09-20 14:04:00', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31943, 1, 232, '2021-09-20 14:04:06', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31944, 1, 225, '2021-09-20 14:04:38', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31945, 1, 225, '2021-09-20 14:05:14', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31946, 59, 225, '2021-09-20 14:05:44', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31947, 59, 225, '2021-09-20 14:06:43', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31948, 59, 225, '2021-09-20 14:08:16', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31949, 59, 225, '2021-09-20 14:08:47', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31950, 1, 225, '2021-09-20 14:09:58', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31951, 1, 225, '2021-09-20 14:10:01', 'ENVIO', 'EL No DE SOLICITUD \"15\"'),
(31952, 1, 229, '2021-09-20 14:10:05', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31953, 1, 229, '2021-09-20 14:10:10', 'APROBO', 'EL No DE SOLICITUD\"15\"'),
(31954, 59, 235, '2021-09-20 14:10:25', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31955, 59, 235, '2021-09-20 14:10:38', 'FINALIZO', 'EL NO DE SOLICITUD \"15\"'),
(31956, 59, 232, '2021-09-20 14:10:55', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31957, 1, 228, '2021-09-20 19:30:41', 'INGRESO', 'A Horas VOAE Gestión'),
(31958, 1, 230, '2021-09-20 19:31:06', 'INGRESO', 'A Historial de Horas Alumno'),
(31959, 1, 228, '2021-09-20 19:31:15', 'INGRESO', 'A Horas VOAE Gestión'),
(31960, 1, 228, '2021-09-20 22:05:53', 'INGRESO', 'A Horas VOAE Gestión'),
(31961, 1, 228, '2021-09-20 22:30:23', 'INSERTO', 'HORAS VOAE AL ALUMNO: Samanta Ramirez, LA CANTIDAD DE: 12 HORAS, DE LA ACTIVIDAD: CULTURADSDS'),
(31962, 1, 228, '2021-09-20 22:39:47', 'INGRESO', 'A Horas VOAE Gestión'),
(31963, 1, 228, '2021-09-20 22:39:57', 'INSERTO', 'HORAS VOAE AL ALUMNO: Helmer Calix, LA CANTIDAD DE: 20 HORAS, DE LA ACTIVIDAD: CULTURADSDS'),
(31964, 1, 228, '2021-09-20 22:41:04', 'INGRESO', 'A Horas VOAE Gestión'),
(31965, 1, 230, '2021-09-20 22:41:15', 'INGRESO', 'A Historial de Horas Alumno'),
(31966, 1, 228, '2021-09-20 22:41:28', 'INGRESO', 'A Horas VOAE Gestión'),
(31967, 1, 228, '2021-09-20 22:41:35', 'INGRESO', 'A Horas VOAE Gestión'),
(31968, 1, 236, '2021-09-22 20:01:18', 'INGRESO', 'A MENU CARGA ACADEMICA JEFATURA.'),
(31969, 1, 228, '2021-09-22 22:37:48', 'INGRESO', 'A Horas VOAE Gestión'),
(31970, 1, 227, '2021-09-22 22:37:52', 'INGRESO', 'A registro de faltas'),
(31971, 1, 227, '2021-09-22 22:38:18', 'INGRESO', 'A registro de faltas'),
(31972, 1, 236, '2021-09-22 22:38:27', 'INGRESO', 'A Solicitud de Actividades CVE'),
(31973, 1, 232, '2021-09-22 22:38:38', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31974, 1, 232, '2021-09-22 22:38:53', 'INGRESO', 'A GESTION DE DOCUMENTACION'),
(31975, 1, 9, '2021-09-26 12:43:39', 'Ingreso', 'A Permisos a roles y pantallas'),
(31976, 1, 228, '2021-09-27 18:07:41', 'INGRESO', 'A Horas VOAE Gestión'),
(31977, 1, 230, '2021-09-27 18:07:44', 'INGRESO', 'A Historial de Horas Alumno'),
(31978, 1, 228, '2021-09-27 18:07:47', 'INGRESO', 'A Horas VOAE Gestión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cambio_carrera`
--

CREATE TABLE `tbl_cambio_carrera` (
  `Id_cambio` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `razon_cambio` varchar(255) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `aprobado` varchar(255) NOT NULL,
  `Id_centro_regional` bigint(16) DEFAULT NULL,
  `fecha_creacion` varchar(30) DEFAULT NULL,
  `documento` longtext DEFAULT NULL,
  `Id_facultad` bigint(16) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_cambio_carrera`
--

INSERT INTO `tbl_cambio_carrera` (`Id_cambio`, `id_persona`, `razon_cambio`, `observacion`, `aprobado`, `Id_centro_regional`, `fecha_creacion`, `documento`, `Id_facultad`, `tipo`, `correo`) VALUES
(57, 6, 'sa', '', 'desaprobado', 1, '2020-10-12 16:23:40', '[\"../archivos/cambio/interno/20141011506/Abrir acceso por red a Xampp.pdf\",\"../archivos/cambio/interno/20141011506/bd_Automatizacion.pdf\",\"../archivos/cambio/interno/20141011506/doc(1).pdf\",\"../archivos/cambio/interno/20141011506/doc(2).pdf\",\"../archivos/', 1, 'INTERNO', 'sa@unah.hn'),
(58, 6, '', '', 'desaprobado', 1, '2020-10-12 16:45:09', '[\"../archivos/cambio/simultanea/20141011506/Abrir acceso por red a Xampp.pdf\",\"../archivos/cambio/simultanea/20141011506/doc(1).pdf\",\"../archivos/cambio/simultanea/20141011506/doc(3).pdf\",\"../archivos/cambio/simultanea/20141011506/doc.pdf\"]', 1, 'SIMULTANEA', 'nicole@unah.hn'),
(60, 4, 'sa', '', 'desaprobado', 1, '2020-10-13 16:10:42', '[\"../archivos/cambio/interno/20131015093/doc(1).pdf\",\"../archivos/cambio/interno/20131015093/doc(2).pdf\",\"../archivos/cambio/interno/20131015093/doc(3).pdf\",\"../archivos/cambio/interno/20131015093/doc.pdf\",\"../archivos/cambio/interno/20131015093/Abrir acc', 1, 'INTERNO', 'hcalix92@unah.hn'),
(63, 153, '', '', 'desaprobado', 1, '2021-05-20 21:53:27', '[\"../archivos/cambio/simultanea/20131015093/doc.pdf\",\"../archivos/cambio/simultanea/20131015093/doc(1).pdf\",\"../archivos/cambio/simultanea/20131015093/doc(2).pdf\",\"../archivos/cambio/simultanea/20131015093/doc(3).pdf\"]', 1, 'SIMULTANEA', 'sa@unah.hn'),
(72, 153, 'sa', '', 'desaprobado', 1, '2021-05-20 23:53:23', '', 1, 'INTERNO', 'sa@unah.hn'),
(73, 153, 'sa', '', 'desaprobado', 1, '2021-05-21 00:07:54', '', 1, 'INTERNO', 'sa@unah.hn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cancelar_clases`
--

CREATE TABLE `tbl_cancelar_clases` (
  `Id_cancelar_clases` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `Fecha_creacion` varchar(255) NOT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `cambio` varchar(255) DEFAULT NULL,
  `observacion` varchar(2000) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_cancelar_clases`
--

INSERT INTO `tbl_cancelar_clases` (`Id_cancelar_clases`, `id_persona`, `motivo`, `Fecha_creacion`, `documento`, `cambio`, `observacion`, `correo`) VALUES
(27, 6, 'sa', '2020-10-12 16:26:16', '[\"../archivos/cancelar_clases/20141011506/Abrir acceso por red a Xampp.pdf\",\"../archivos/cancelar_clases/20141011506/bd_Automatizacion.pdf\",\"../archivos/cancelar_clases/20141011506/doc(1).pdf\",\"../archivos/cancelar_clases/20141011506/doc.pdf\"]', 'desaprobado', NULL, 'nicolle@unah.hn'),
(28, 4, 'sa', '2020-10-12 17:43:25', '[\"../archivos/cancelar_clases/20131015093/doc(1).pdf\",\"../archivos/cancelar_clases/20131015093/doc(2).pdf\",\"../archivos/cancelar_clases/20131015093/doc.pdf\",\"../archivos/cancelar_clases/20131015093/bd_Automatizacion.pdf\"]', 'desaprobado', NULL, 'hcalix92@gmail.com'),
(29, 153, 'sa', '2021-05-20 22:46:16', '[\"../archivos/cancelar_clases/20131015093/doc.pdf\",\"../archivos/cancelar_clases/20131015093/doc(1).pdf\",\"../archivos/cancelar_clases/20131015093/doc(2).pdf\",\"../archivos/cancelar_clases/20131015093/doc(3).pdf\"]', 'desaprobado', NULL, 'sa@unah.hn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carga_academica`
--

CREATE TABLE `tbl_carga_academica` (
  `id_carga_academica` bigint(16) NOT NULL,
  `control` varchar(100) DEFAULT NULL,
  `seccion` varchar(50) DEFAULT NULL,
  `num_alumnos` int(11) DEFAULT NULL,
  `id_persona` bigint(16) DEFAULT NULL,
  `id_aula` bigint(16) DEFAULT NULL,
  `id_asignatura` bigint(16) DEFAULT NULL,
  `id_periodo` bigint(16) DEFAULT NULL,
  `dias` varchar(50) DEFAULT NULL,
  `id_modalidad` bigint(20) DEFAULT NULL,
  `hora_inicial` varchar(50) DEFAULT NULL,
  `hora_final` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_carga_academica`
--

INSERT INTO `tbl_carga_academica` (`id_carga_academica`, `control`, `seccion`, `num_alumnos`, `id_persona`, `id_aula`, `id_asignatura`, `id_periodo`, `dias`, `id_modalidad`, `hora_inicial`, `hora_final`) VALUES
(97, '55602', '0800', 50, 116, 22, 53, 3, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(98, '55602', '1100', 50, 116, 22, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(99, '55644', '1300', 45, 80, 21, 19, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(100, '55605', '1500', 40, 80, 23, 9, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(101, '55648', '1800', 50, 80, 19, 19, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(102, '55604', '0700', 35, 80, 19, 9, 3, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(103, '55605', '1000', 35, 81, 25, 9, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(104, '55694', '1400', 45, 82, 21, 37, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(105, '55686', '1500', 35, 82, 25, 32, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(106, '55688', '1700', 35, 82, 25, 32, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(107, '557216', '1700', 50, 25, 20, 52, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(108, '556996', '1700', 40, 83, 23, 38, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(109, '556801', '0700', 50, 84, 20, 53, 3, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(110, '556256', '1300', 50, 85, 20, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(112, '563300', '1700', 50, 86, 19, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(113, '585476', '1900', 46, 86, 26, 42, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(114, '557249', '2000', 50, 86, 19, 51, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(115, '556274', '1400', 55, 15, 24, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(117, '556350', '1600', 35, 15, 25, 16, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(118, '556845', '1900', 35, 15, 25, 31, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(119, '557182', '1600', 50, 87, 22, 50, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(120, '557118', '1700', 50, 87, 22, 45, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(121, '556030', '1300', 35, 88, 25, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(122, '556038', '1100', 40, 88, 23, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(123, '556038', '1400', 50, 88, 20, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(124, '556475', '1500', 50, 89, 19, 19, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(125, '557026', '1600', 50, 89, 20, 40, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(126, '556653', '1800', 35, 90, 25, 20, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(127, '556713', '1900', 45, 90, 21, 20, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(128, '557009', '1600', 40, 92, 23, 38, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(129, '557067', '1700', 55, 93, 24, 42, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(130, '556043', '1900', 50, 93, 22, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(131, '556972', '1300', 40, 19, 23, 38, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(132, '556049', '0800', 55, 95, 24, 9, 3, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(133, '556294', '0900', 35, 95, 25, 16, 3, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(134, '556608', '1000', 40, 95, 23, 22, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(135, '556766', '1700', 45, 96, 21, 27, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(136, '556398', '1900', 55, 96, 24, 16, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(137, '556598', '0700', 45, 97, 21, 22, 3, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(138, '586464', '0900', 45, 97, 21, 10, 3, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(139, '556740', '1000', 50, 97, 19, 27, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(140, '556557', '1500', 45, 98, 17, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(141, '556566', '1600', 45, 98, 21, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(142, '556041', '1800', 55, 98, 24, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(143, '556335', '1400', 50, 99, 19, 16, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(144, '556033', '0800', 40, 18, 23, 11, 3, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(145, '556232', '1000', 50, 18, 17, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(146, '556035', '1300', 55, 18, 24, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(147, '556061', '0900', 50, 101, 22, 10, 3, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(148, '556536', '1000', 45, 101, 21, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(149, '556632', '1200', 45, 101, 21, 20, 3, 'Lu,Ma,Mi,Ju', 1, '1200', '1300'),
(150, '556917', '1800', 50, 102, 17, 33, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(151, '556822', '2000', 45, 102, 21, 29, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(152, '557139', '1900', 50, 103, 20, 46, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(153, '563282', '1800', 50, 105, 29, 22, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(154, '563298', '1900', 40, 24, 23, 37, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(155, '563290', '2000', 50, 24, 22, 46, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(156, '586497', '1400', 45, 107, 28, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(157, '563303', '1500', 55, 107, 24, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(158, '585535', '1800', 40, 109, 23, 52, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(159, '586510', '2000', 45, 109, 28, 11, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(160, '586510', '1600', 55, 110, 24, 53, 3, 'Vi', 1, '1600', '1700'),
(161, '586510', '1900', 50, 111, 29, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(162, '586510', '2001', 50, 111, 18, 29, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(164, '586510', '1900', 52, 112, 27, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(165, '586510', '1800', 46, 112, 26, 9, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(166, '586510', '1600', 45, 63, 28, 31, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(167, '586510', '1800', 52, 63, 27, 41, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(168, '586510', '2000', 52, 63, 27, 41, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(169, '586510', '1800', 50, 115, 21, 36, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(170, '586510', '2000', 40, 115, 23, 9, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(171, '586442', '1300', 50, 117, 19, 48, 3, 'Lu,Ma,Mi', 1, '1300', '1400'),
(172, '557149', '1400', 35, 117, 25, 48, 3, 'Lu,Ma,Mi', 1, '1400', '1500'),
(173, '55602', '0800', 50, 116, 22, 53, 3, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(174, '55602', '1100', 50, 116, 22, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(175, '55644', '1300', 45, 80, 21, 19, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(176, '55605', '1500', 40, 80, 23, 9, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(177, '55648', '1800', 50, 80, 19, 19, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(178, '55604', '0700', 35, 80, 19, 9, 3, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(179, '55605', '1000', 35, 81, 25, 9, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(180, '55694', '1400', 45, 82, 21, 37, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(181, '55686', '1500', 35, 82, 25, 32, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(182, '55688', '1700', 35, 82, 25, 32, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(183, '557216', '1700', 50, 25, 20, 52, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(184, '556996', '1700', 40, 83, 23, 38, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(185, '556801', '0700', 50, 84, 20, 53, 3, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(186, '556256', '1300', 50, 85, 20, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(187, '563300', '1700', 50, 86, 19, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(188, '585476', '1900', 46, 86, 26, 42, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(189, '557249', '2000', 50, 86, 19, 51, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(190, '556274', '1400', 55, 15, 24, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(191, '556350', '1600', 35, 15, 25, 16, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(192, '556845', '1900', 35, 15, 25, 31, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(193, '557182', '1600', 50, 87, 22, 50, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(194, '557118', '1700', 50, 87, 22, 45, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(195, '556030', '1300', 35, 88, 25, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(196, '556038', '1100', 40, 88, 23, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(197, '556038', '1400', 50, 88, 20, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(198, '556475', '1500', 50, 89, 19, 19, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(199, '557026', '1600', 50, 89, 20, 40, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(200, '556653', '1800', 35, 90, 25, 20, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(201, '556713', '1900', 45, 90, 21, 20, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(202, '557009', '1600', 40, 92, 23, 38, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(203, '557067', '1700', 55, 93, 24, 42, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(204, '556043', '1900', 50, 93, 22, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(205, '556972', '1300', 40, 19, 23, 38, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(206, '556049', '0800', 55, 95, 24, 9, 3, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(207, '556294', '0900', 35, 95, 25, 16, 3, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(208, '556608', '1000', 40, 95, 23, 22, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(209, '556766', '1700', 45, 96, 21, 27, 3, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(210, '556398', '1900', 55, 96, 24, 16, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(211, '556598', '0700', 45, 97, 21, 22, 3, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(212, '586464', '0900', 45, 97, 21, 10, 3, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(213, '556740', '1000', 50, 97, 19, 27, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(214, '556557', '1500', 45, 98, 17, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(215, '556566', '1600', 45, 98, 21, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(216, '556041', '1800', 55, 98, 24, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(217, '556335', '1400', 50, 99, 19, 16, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(218, '556033', '0800', 40, 18, 23, 11, 3, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(219, '556232', '1000', 50, 18, 17, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(220, '556035', '1300', 55, 18, 24, 11, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(221, '556061', '0900', 50, 101, 22, 10, 3, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(222, '556536', '1000', 45, 101, 21, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(223, '556632', '1200', 45, 101, 21, 20, 3, 'Lu,Ma,Mi,Ju', 1, '1200', '1300'),
(224, '556917', '1800', 50, 102, 17, 33, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(225, '556822', '2000', 45, 102, 21, 29, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(226, '557139', '1900', 50, 103, 20, 46, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(227, '563282', '1800', 50, 105, 29, 22, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(228, '563298', '1900', 40, 24, 23, 37, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(229, '563290', '2000', 50, 24, 22, 46, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(230, '586497', '1400', 45, 107, 28, 53, 3, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(231, '563303', '1500', 55, 107, 24, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(232, '585535', '1800', 40, 109, 23, 52, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(233, '586510', '2000', 45, 109, 28, 11, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(234, '586510', '1600', 55, 110, 24, 53, 3, 'Vi', 1, '1600', '1700'),
(235, '586510', '1900', 50, 111, 29, 21, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(236, '586510', '2001', 50, 111, 18, 29, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(237, '586510', '1900', 52, 112, 27, 10, 3, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(238, '586510', '1800', 46, 112, 26, 9, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(239, '586510', '1600', 45, 63, 28, 31, 3, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(240, '586510', '1800', 52, 63, 27, 41, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(241, '586510', '2000', 52, 63, 27, 41, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(242, '586510', '1800', 50, 115, 21, 36, 3, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(243, '586510', '2000', 40, 115, 23, 9, 3, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(244, '586442', '1300', 50, 117, 19, 48, 3, 'Lu,Ma,Mi', 1, '1300', '1400'),
(246, '11111', '0800', 11, 104, NULL, 52, 3, 'Lu,Ma,Mi,Ju', 3, '0800', '0900'),
(247, '22222', '0900', 50, 80, 18, 49, 3, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(248, '', '0800', 45, 80, 21, 24, 3, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(249, '', '0800', 45, 18, 21, 24, 3, 'Lu,Ma,Mi,Ju', 1, '1300', '1500'),
(250, '55601', '0800', 56, 116, NULL, 53, 4, 'Lu,Ma,Mi,Ju', 3, '0800', '0900'),
(251, '55602', '1100', 50, 116, 22, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(252, '55644', '1300', 45, 80, 21, 19, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(253, '55605', '1500', 40, 80, 23, 9, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(254, '55648', '1800', 50, 80, 19, 19, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(255, '55604', '0700', 35, 80, 19, 9, 4, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(256, '55605', '1000', 35, 81, 25, 9, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(257, '55694', '1400', 45, 82, 21, 37, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(258, '55686', '1500', 35, 82, 25, 32, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(259, '55688', '1700', 35, 82, 25, 32, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(260, '557216', '1700', 50, 25, 20, 52, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(262, '556801', '0700', 50, 84, 20, 53, 4, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(263, '556256', '1300', 50, 85, 20, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(264, '563300', '1700', 50, 86, 19, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(265, '585476', '1900', 46, 86, 26, 42, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(266, '557249', '2000', 50, 86, 19, 51, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(267, '556274', '1400', 55, 15, 24, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(268, '556350', '1600', 35, 15, 25, 16, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(269, '556845', '1900', 35, 15, 25, 31, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(270, '557182', '1600', 50, 87, 22, 50, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(271, '557118', '1700', 50, 87, 22, 45, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(272, '556030', '1300', 35, 88, 25, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(273, '556038', '1100', 40, 88, 23, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(274, '556038', '1400', 50, 88, 20, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(275, '556475', '1500', 50, 89, 19, 19, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(276, '557026', '1600', 50, 89, 20, 40, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(277, '556653', '1800', 35, 90, 25, 20, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(278, '556713', '1900', 45, 90, 21, 20, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(279, '557009', '1600', 40, 92, 23, 38, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(280, '557067', '1700', 55, 93, 24, 42, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(281, '556043', '1900', 50, 93, 22, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(282, '556972', '1300', 40, 19, 23, 38, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(283, '556049', '0800', 55, 95, 24, 9, 4, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(284, '556294', '0900', 35, 95, 25, 16, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(285, '556608', '1000', 40, 95, 23, 22, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(286, '556766', '1700', 45, 96, 21, 27, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(287, '556398', '1900', 55, 96, 24, 16, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(288, '556598', '0700', 45, 97, 21, 22, 4, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(289, '586464', '0900', 45, 97, 21, 10, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(290, '556740', '1000', 50, 97, 19, 27, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(291, '556557', '1500', 45, 98, 17, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(292, '556566', '1600', 45, 98, 21, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(293, '556041', '1800', 55, 98, 24, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(294, '556335', '1400', 50, 99, 19, 16, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(295, '556033', '0800', 40, 18, 23, 11, 4, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(296, '556232', '1000', 50, 18, 17, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(297, '556035', '1300', 55, 18, 24, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(298, '556061', '0900', 50, 101, 22, 10, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(299, '556536', '1000', 45, 101, 21, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(300, '556632', '1200', 45, 101, 21, 20, 4, 'Lu,Ma,Mi,Ju', 1, '1200', '1300'),
(301, '556917', '1800', 50, 102, 17, 33, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(302, '556822', '2000', 45, 102, 21, 29, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(303, '557139', '1900', 50, 103, 20, 46, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(304, '563282', '1800', 50, 105, 29, 22, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(305, '563298', '1900', 40, 24, 23, 37, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(306, '563290', '2000', 50, 24, 22, 46, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(307, '586497', '1400', 45, 107, 28, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(308, '563303', '1500', 55, 107, 24, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(309, '585535', '1800', 40, 109, 23, 52, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(310, '586510', '2000', 45, 109, 28, 11, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(311, '586510', '1600', 55, 110, 24, 53, 4, 'Vi', 1, '1600', '1700'),
(312, '586510', '1900', 50, 111, 29, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(313, '586510', '2001', 50, 111, 18, 29, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(314, '586510', '1900', 52, 112, 27, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(315, '586510', '1800', 46, 112, 26, 9, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(316, '586510', '1600', 45, 63, 28, 31, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(317, '586510', '1800', 52, 63, 27, 41, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(318, '586510', '2000', 52, 63, 27, 41, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(319, '586510', '1800', 50, 115, 21, 36, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(320, '586510', '2000', 40, 115, 23, 9, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(321, '586442', '1300', 50, 117, 19, 48, 4, 'Lu,Ma,Mi', 1, '1300', '1400'),
(322, '557149', '1400', 35, 117, 25, 48, 4, 'Lu,Ma,Mi', 1, '1400', '1500'),
(323, '55602', '0800', 50, 116, 22, 53, 4, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(324, '55602', '1100', 50, 116, 22, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(325, '55644', '1300', 45, 80, 21, 19, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(326, '55605', '1500', 40, 80, 23, 9, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(327, '55648', '1800', 50, 80, 19, 19, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(328, '55604', '0700', 35, 80, 19, 9, 4, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(329, '55605', '1000', 35, 81, 25, 9, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(330, '55694', '1400', 45, 82, 21, 37, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(331, '55686', '1500', 35, 82, 25, 32, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(332, '55688', '1700', 35, 82, 25, 32, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(333, '557216', '1700', 50, 25, 20, 52, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(334, '556996', '1700', 40, 83, 23, 38, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(335, '556801', '0700', 50, 84, 20, 53, 4, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(336, '556256', '1300', 50, 85, 20, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(337, '563300', '1700', 50, 86, 19, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(338, '585476', '1900', 46, 86, 26, 42, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(339, '557249', '2000', 50, 86, 19, 51, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(340, '556274', '1400', 55, 15, 24, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(341, '556350', '1600', 35, 15, 25, 16, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(342, '556845', '1900', 35, 15, 25, 31, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(343, '557182', '1600', 50, 87, 22, 50, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(344, '557118', '1700', 50, 87, 22, 45, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(345, '556030', '1300', 35, 88, 25, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(346, '556038', '1100', 40, 88, 23, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1100', '1200'),
(347, '556038', '1400', 50, 88, 20, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(348, '556475', '1500', 50, 89, 19, 19, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(349, '557026', '1600', 50, 89, 20, 40, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(350, '556653', '1800', 35, 90, 25, 20, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(351, '556713', '1900', 45, 90, 21, 20, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(352, '557009', '1600', 40, 92, 23, 38, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(353, '557067', '1700', 55, 93, 24, 42, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(354, '556043', '1900', 50, 93, 22, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(355, '556972', '1300', 40, 19, 23, 38, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(356, '556049', '0800', 55, 95, 24, 9, 4, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(357, '556294', '0900', 35, 95, 25, 16, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(358, '556608', '1000', 40, 95, 23, 22, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(359, '556766', '1700', 45, 96, 21, 27, 4, 'Lu,Ma,Mi,Ju', 1, '1700', '1800'),
(360, '556398', '1900', 55, 96, 24, 16, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(361, '556598', '0700', 45, 97, 21, 22, 4, 'Lu,Ma,Mi,Ju', 1, '0700', '0800'),
(362, '586464', '0900', 45, 97, 21, 10, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(363, '556740', '1000', 50, 97, 19, 27, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(364, '556557', '1500', 45, 98, 17, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(365, '556566', '1600', 45, 98, 21, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(366, '556041', '1800', 55, 98, 24, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(367, '556335', '1400', 50, 99, 19, 16, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(368, '556033', '0800', 40, 18, 23, 11, 4, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(369, '556232', '1000', 50, 18, 17, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(370, '556035', '1300', 55, 18, 24, 11, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1400'),
(371, '556061', '0900', 50, 101, 22, 10, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(372, '556536', '1000', 45, 101, 21, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1000', '1100'),
(373, '556632', '1200', 45, 101, 21, 20, 4, 'Lu,Ma,Mi,Ju', 1, '1200', '1300'),
(374, '556917', '1800', 50, 102, 17, 33, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(375, '556822', '2000', 45, 102, 21, 29, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(376, '557139', '1900', 50, 103, 20, 46, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(377, '563282', '1800', 50, 105, 29, 22, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(378, '563298', '1900', 40, 24, 23, 37, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(379, '563290', '2000', 50, 24, 22, 46, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(380, '586497', '1400', 45, 107, 28, 53, 4, 'Lu,Ma,Mi,Ju', 1, '1400', '1500'),
(381, '563303', '1500', 55, 107, 24, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1500', '1600'),
(382, '585535', '1800', 40, 109, 23, 52, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(383, '586510', '2000', 45, 109, 28, 11, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(384, '586510', '1600', 55, 110, 24, 53, 4, 'Vi', 1, '1600', '1700'),
(385, '586510', '1900', 50, 111, 29, 21, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(386, '586510', '2001', 50, 111, 18, 29, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(387, '586510', '1900', 52, 112, 27, 10, 4, 'Lu,Ma,Mi,Ju', 1, '1900', '2000'),
(388, '586510', '1800', 46, 112, 26, 9, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(389, '586510', '1600', 45, 63, 28, 31, 4, 'Lu,Ma,Mi,Ju', 1, '1600', '1700'),
(390, '586510', '1800', 52, 63, 27, 41, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(391, '586510', '2000', 52, 63, 27, 41, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(392, '586510', '1800', 50, 115, 21, 36, 4, 'Lu,Ma,Mi,Ju', 1, '1800', '1900'),
(393, '586510', '2000', 40, 115, 23, 9, 4, 'Lu,Ma,Mi,Ju', 1, '2000', '2100'),
(394, '586442', '1300', 50, 117, 19, 48, 4, 'Lu,Ma,Mi', 1, '1300', '1400'),
(395, '11111', '0800', 11, 104, NULL, 52, 4, 'Lu,Ma,Mi,Ju', 3, '0800', '0900'),
(396, '22222', '0900', 50, 80, 18, 49, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(397, '', '0800', 45, 80, 21, 24, 4, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(398, '', '0800', 45, 18, 21, 24, 4, 'Lu,Ma,Mi,Ju', 1, '1300', '1500'),
(505, '1', '0900', 60, 83, 19, 37, 4, 'Lu,Ma,Mi,Ju', 1, '0900', '1000'),
(506, '2', '1400', 70, 81, 30, 53, 4, 'Lu,Ma,Ju,Vi', 2, '1400', '1500'),
(507, '23', '1400', 80, 81, 8, 24, 4, 'Lu,Ma,Mi,Ju,Vi', 2, '1400', '1500'),
(510, '2', '1500', 30, 81, 11, 48, 4, 'Lu,Ma,Mi', 2, '1500', '1600'),
(511, '2', '19', 30, 82, 11, 36, 4, 'Lu,Ma,Mi,Ju', 2, '1600', '1700'),
(512, '34', '1700', 20, 82, 11, 16, 4, 'Lu,Ma,Mi,Ju', 2, '1700', '1800'),
(513, '111111', '0801', 33, 105, 26, 52, 4, 'Lu,Ma,Mi,Ju', 1, '0800', '0900'),
(516, '2', '1400', 23, 83, NULL, 21, 4, 'Lu', 3, '1400', '1500');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carga_dias`
--

CREATE TABLE `tbl_carga_dias` (
  `id_carga_academica` bigint(16) NOT NULL,
  `dias` varchar(50) DEFAULT NULL,
  `id_dia` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carrera`
--

CREATE TABLE `tbl_carrera` (
  `id_carrera` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `Id_facultad` int(11) NOT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_carrera`
--

INSERT INTO `tbl_carrera` (`id_carrera`, `Descripcion`, `Id_facultad`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'INFORMATICA ADMINISTRATIVA', 1, NULL, NULL, '2021-04-06 02:44:59', 'ADMIN'),
(2, 'ADMINISTRACION DE EMPRESAS', 1, '2021-03-19 01:52:15', 'ADMIN', '2021-04-12 08:44:36', 'ADMIN'),
(8, 'LENGUAS EXTRANJERAS', 3, '2021-04-06 01:54:40', 'ADMIN', '2021-04-06 04:00:03', 'ADMIN'),
(10, 'ADMINISTRACION ADUANERA', 1, '2021-04-12 08:42:36', 'ADMIN', NULL, NULL),
(11, 'DATOS MAESTROS', 2, '2021-04-13 04:49:12', 'ADMIN', '2021-04-17 07:27:20', 'ADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carta_egresado`
--

CREATE TABLE `tbl_carta_egresado` (
  `Id_carta` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `aprobado` varchar(255) DEFAULT NULL,
  `documento` varchar(250) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_carta_egresado`
--

INSERT INTO `tbl_carta_egresado` (`Id_carta`, `id_persona`, `observacion`, `Fecha_creacion`, `aprobado`, `documento`, `correo`) VALUES
(24, 6, '', '2020-10-12 17:52:35', 'aprobado', '[\"../archivos/carta_egresado/20141011506/doc(1).pdf\",\"../archivos/carta_egresado/20141011506/doc(2).pdf\",\"../archivos/carta_egresado/20141011506/doc(3).pdf\",\"../archivos/carta_egresado/20141011506/doc.pdf\"]', 'sa@unah.hn'),
(25, 4, '', '2020-10-27 02:34:29', 'desaprobado', '[\"../archivos/carta_egresado/20131015093/doc.pdf\",\"../archivos/carta_egresado/20131015093/doc(1).pdf\",\"../archivos/carta_egresado/20131015093/doc(2).pdf\",\"../archivos/carta_egresado/20131015093/doc(3).pdf\"]', 'helmer.calix@unah.hn'),
(27, 6, '', '2021-05-19 18:26:42', 'desaprobado', '[\"../archivos/carta_egresado/20141011506/doc.pdf\",\"../archivos/carta_egresado/20141011506/doc(1).pdf\",\"../archivos/carta_egresado/20141011506/doc(2).pdf\",\"../archivos/carta_egresado/20141011506/doc(3).pdf\"]', 'sa@unah.hn'),
(28, 153, '', '2021-05-20 22:10:02', 'desaprobado', '[\"../archivos/carta_egresado/20131015093/doc.pdf\",\"../archivos/carta_egresado/20131015093/doc(1).pdf\",\"../archivos/carta_egresado/20131015093/doc(2).pdf\",\"../archivos/carta_egresado/20131015093/doc(3).pdf\"]', 'sa@unah.hn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categorias`
--

CREATE TABLE `tbl_categorias` (
  `id_categoria` bigint(20) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_categorias`
--

INSERT INTO `tbl_categorias` (`id_categoria`, `categoria`, `descripcion`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'AUXILIAR', '', NULL, NULL, NULL, NULL),
(2, 'TITULAR 1', '', NULL, NULL, NULL, NULL),
(4, 'TITULAR 2', '', NULL, NULL, NULL, NULL),
(5, 'TITULAR 3', '', NULL, NULL, NULL, NULL),
(6, 'TITULAR 4', '', NULL, NULL, NULL, NULL),
(7, 'TITULAR 5', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoria_personas`
--

CREATE TABLE `tbl_categoria_personas` (
  `id_categoria_persona` bigint(20) NOT NULL,
  `id_persona` bigint(20) NOT NULL,
  `id_categoria` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_categoria_personas`
--

INSERT INTO `tbl_categoria_personas` (`id_categoria_persona`, `id_persona`, `id_categoria`) VALUES
(18, 39, 1),
(46, 80, 2),
(47, 81, 1),
(48, 82, 2),
(49, 83, 2),
(50, 84, 2),
(51, 85, 2),
(52, 86, 2),
(53, 87, 2),
(54, 88, 2),
(55, 89, 2),
(56, 90, 2),
(57, 91, 2),
(58, 92, 2),
(59, 93, 2),
(60, 94, 2),
(61, 95, 2),
(62, 96, 2),
(63, 97, 2),
(64, 98, 2),
(65, 99, 2),
(66, 100, 2),
(67, 101, 2),
(68, 102, 2),
(69, 103, 2),
(70, 104, 2),
(71, 105, 2),
(72, 106, 2),
(73, 107, 2),
(74, 108, 2),
(75, 109, 2),
(76, 110, 2),
(77, 111, 2),
(78, 112, 2),
(79, 113, 2),
(80, 114, 2),
(81, 115, 2),
(82, 116, 2),
(83, 117, 2),
(84, 118, 2),
(113, 148, 2),
(114, 149, 7),
(115, 150, 4),
(116, 155, 2),
(117, 156, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_centros_regionales`
--

CREATE TABLE `tbl_centros_regionales` (
  `Id_centro_regional` bigint(16) NOT NULL,
  `centro_regional` varchar(255) NOT NULL,
  `acronimo` varchar(255) NOT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Id_facultad` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_centros_regionales`
--

INSERT INTO `tbl_centros_regionales` (`Id_centro_regional`, `centro_regional`, `acronimo`, `Fecha_creacion`, `Id_facultad`) VALUES
(1, 'Ciudad Universitaria', 'CU', '2020-05-31 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_charla_practica`
--

CREATE TABLE `tbl_charla_practica` (
  `Id_charla` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `no_constancia` bigint(16) NOT NULL,
  `promedio_global` varchar(255) NOT NULL,
  `fecha_recibida` varchar(255) DEFAULT NULL,
  `fecha_valida` varchar(255) DEFAULT NULL,
  `clases_aprobadas` varchar(255) NOT NULL,
  `porcentaje_clases` float NOT NULL,
  `jornada` varchar(255) NOT NULL,
  `estado_asistencia_charla` int(2) NOT NULL,
  `charla_impartida` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_charla_practica`
--

INSERT INTO `tbl_charla_practica` (`Id_charla`, `id_persona`, `no_constancia`, `promedio_global`, `fecha_recibida`, `fecha_valida`, `clases_aprobadas`, `porcentaje_clases`, `jornada`, `estado_asistencia_charla`, `charla_impartida`) VALUES
(1, 6, 202104085, '90', NULL, NULL, '45', 86, 'MATUTINA', 0, 0),
(2, 6, 202104094, '99', NULL, NULL, '50', 96, 'VESPERTINA', 0, 0),
(3, 22, 202105095, '85', '2021-05-05', '2021-08-03', '49', 94, 'VESPERTINA', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_comentarios_alumnos`
--

CREATE TABLE `tbl_comentarios_alumnos` (
  `id_comentario_alumno` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `comentario_evaluacion` varchar(255) NOT NULL,
  `area_refuerzo` varchar(255) DEFAULT NULL,
  `calificacion_global` varchar(255) DEFAULT NULL,
  `solicitar_practicante` varchar(255) DEFAULT NULL,
  `oportunidad_empleo` varchar(255) DEFAULT NULL,
  `nombre_representante` varchar(255) NOT NULL,
  `lugar` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `numero_visita` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_comentarios_alumnos`
--

INSERT INTO `tbl_comentarios_alumnos` (`id_comentario_alumno`, `id_persona`, `comentario_evaluacion`, `area_refuerzo`, `calificacion_global`, `solicitar_practicante`, `oportunidad_empleo`, `nombre_representante`, `lugar`, `fecha`, `numero_visita`) VALUES
(1, 26, '', NULL, NULL, NULL, NULL, 'aaaa', 'aaaa', '2021-03-24 20:19:02', 'Primera Supervisión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_comisiones`
--

CREATE TABLE `tbl_comisiones` (
  `id_comisiones` int(11) NOT NULL,
  `comision` varchar(100) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_creacion` date DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_comisiones`
--

INSERT INTO `tbl_comisiones` (`id_comisiones`, `comision`, `id_carrera`, `Creado_por`, `Fecha_creacion`, `Modificado_por`, `Fecha_modificacion`) VALUES
(1, 'VINCULACION', 2, NULL, NULL, 'ADMIN', '2021-04-08'),
(2, 'AUTOMATIZACION ', 1, NULL, NULL, 'ADMIN', '2021-05-03'),
(3, 'INVESTIGACION', 1, NULL, NULL, NULL, NULL),
(4, 'VOAE', 1, NULL, NULL, 'ADMIN', '2021-02-22'),
(12, 'COMITE DESARROLLO CURRICULAR', 1, NULL, NULL, NULL, NULL),
(13, 'COMITE TÉCNICO', 1, NULL, NULL, NULL, NULL),
(14, 'COMITE VUS-DEPTO ', 1, NULL, NULL, NULL, NULL),
(15, 'COMITE LOCAL DE ORIENTACION ESTUDIANTIL', 1, NULL, NULL, NULL, NULL),
(16, 'COMITE DE CONCURSO', 1, NULL, NULL, NULL, NULL),
(17, 'COMITÉ DE PROMOCION DE LA CARRERA', 1, NULL, NULL, NULL, NULL),
(18, 'UNIDAD INVESTIGACION CIENTIFICA DEL DEPTO  ', 1, NULL, NULL, NULL, NULL),
(19, ' CONSEJO ASESOR', 1, NULL, NULL, NULL, NULL),
(20, 'COMISION DE REDISEÑO CURRICULAR', 1, NULL, NULL, NULL, NULL),
(21, 'GESTOR ACADEMICO DE ASIGNATURAS SED EN LOS CRAED', 1, NULL, NULL, NULL, NULL),
(22, 'JEFE DE SECCIONES REGIONALES', 1, NULL, NULL, NULL, NULL),
(23, 'GESTOR TECNOLOGICO', 1, NULL, NULL, NULL, NULL),
(25, 'GESTIÓN UNIVERSITARIA', 1, NULL, NULL, 'ADMIN', '2021-05-28'),
(26, 'SECRETARIA ACADEMICA DEL DEPARTAMENTO', 1, NULL, NULL, NULL, NULL),
(27, 'REGISTROO', 1, 'ADMIN', '2021-03-12', 'ADMIN', '2021-05-03'),
(28, 'PROBANDO', 11, 'ADMIN', '2021-07-05', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_contactos`
--

CREATE TABLE `tbl_contactos` (
  `id_contacto` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL DEFAULT 0,
  `id_tipo_contacto` bigint(16) NOT NULL DEFAULT 0,
  `valor` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_contactos`
--

INSERT INTO `tbl_contactos` (`id_contacto`, `id_persona`, `id_tipo_contacto`, `valor`) VALUES
(1, 4, 1, '9898-8888'),
(2, 6, 1, '9876-5666'),
(3, 6, 4, 'giancarlo@unah.edu.hn'),
(4, 6, 4, 'gh@gmail.com'),
(22, 15, 1, '88888888'),
(23, 15, 4, 'EDIS.REYES@UNAH.EDU.HN'),
(24, 15, 3, 'TEGUCIGALPA'),
(25, 16, 1, '88888888'),
(26, 16, 4, 'CAROLD.RITHENHOUSE@UNAH.EDU.HN'),
(27, 16, 3, 'TEGUCIGALPA'),
(28, 17, 1, '88888888'),
(29, 17, 4, 'NELSON.DIAZ@UNAH.EDU.HN'),
(30, 17, 3, 'TEGUCIGALPA'),
(31, 18, 1, '88888888'),
(32, 18, 4, 'R_CORRALES@UNAH.EDU.HN'),
(33, 18, 3, 'TEGUCIGALPA'),
(34, 19, 1, '88888888'),
(35, 19, 4, 'PATRICIA.ELLNER@UNAH.EDU.HN'),
(36, 19, 3, 'TEGUCIGALPA'),
(37, 20, 1, '89136654'),
(38, 20, 4, 'FMOTINO@UNAH.HN'),
(39, 20, 3, 'TEGUCIGALPA'),
(43, 22, 4, 'r1912ramirez@gmail.com'),
(44, 22, 2, ' 2222-3333'),
(45, 22, 1, ' 8989-8988'),
(46, 22, 3, 'TEGUCIGALPA'),
(47, 23, 1, '88888888'),
(48, 23, 4, 'DULCE.DELCID@UNAH.EDU.HN'),
(49, 23, 3, 'TEGUCIGALPA'),
(50, 24, 1, '88888888'),
(51, 24, 4, 'GIANCARLOS.SCALICI@UNAH.EDU.HN'),
(52, 24, 3, 'TEGUCIGALPA'),
(53, 25, 1, '88888888'),
(54, 25, 4, 'CRISTIAN.RIVERA@UNAH.EDU.HN'),
(55, 25, 3, 'TEGUCIGALPA'),
(56, 26, 4, 'r1912ramirez@gmail.com'),
(57, 26, 2, ' 1222-2222'),
(58, 26, 1, ' 9999-9999'),
(59, 26, 3, 'TEGUCIGALPA'),
(60, 27, 4, 'r1912ramirez@gmail.com'),
(61, 27, 2, ' 2222-2222'),
(62, 27, 1, ' 9898-9998'),
(63, 27, 3, 'COL. CERRO GRANDE'),
(124, 61, 4, 'r1912ramirez@gmail.com'),
(125, 61, 2, ' 2223-2322'),
(126, 61, 1, ' 9888-8888'),
(127, 61, 3, 'TEGUCIGALPA'),
(169, 66, 1, '88888888'),
(170, 66, 4, 'FMOTINO@UNAH.HN'),
(171, 66, 3, 'TEGUCIGALPA'),
(172, 67, 1, '88888888'),
(173, 67, 4, 'a@unah.hn'),
(174, 67, 3, 'tgu'),
(175, 68, 1, '88888u888'),
(176, 68, 4, 'a@unah.hn'),
(177, 68, 3, 'gu'),
(178, 69, 1, '66666666'),
(179, 69, 4, 'aa@unah.hn'),
(180, 69, 3, 'tgu'),
(181, 70, 1, '88888888'),
(182, 70, 4, 'ae@unah.hn'),
(183, 70, 3, 'tgu'),
(184, 71, 1, '8888888'),
(185, 71, 4, 'ander@unah.hn'),
(186, 71, 3, 'tgu'),
(187, 72, 1, '33333333'),
(188, 72, 4, 'anderf@unah.hn'),
(189, 72, 3, 'olancho'),
(192, 73, 1, ' 9999-9999'),
(193, 73, 4, 'r_corrales@hotmail.com'),
(194, 73, 3, 'RESIDENCIAL EL SAUVE, VIL'),
(195, 74, 1, ' 0801-1967'),
(196, 74, 4, ''),
(197, 74, 3, ''),
(213, 77, 4, 'HANSY@yahoo.com'),
(257, 81, 1, '9098-9898'),
(258, 81, 4, 'carmen@unah.edu.hn'),
(260, 82, 4, 'claudia@unah.edu.hn'),
(264, 84, 4, 'dilma@unah.edu.hn'),
(266, 85, 4, 'dinora@unah.edu.hn'),
(267, 86, 1, '9898-9899'),
(268, 86, 4, 'dulis@unah.edu.hn'),
(269, 87, 4, 'hector@unah.edu.hn'),
(271, 88, 1, '9090-9999'),
(272, 88, 4, 'irma@unah.edu.hn'),
(273, 89, 1, '8989-8989'),
(274, 89, 4, 'isaac@unah.edu.hn'),
(275, 90, 1, '9090-9090'),
(276, 90, 4, 'jorge@unah.edu.hn'),
(277, 91, 1, '9090-0909'),
(278, 91, 4, 'karla@unah.edu.hn'),
(281, 93, 1, '9123-4566'),
(282, 93, 4, 'marco@unah.edu.hn'),
(283, 94, 4, 'maria@unah.edu.hn'),
(285, 95, 1, '9654-3212'),
(286, 95, 4, 'marvin@unah.edu.hn'),
(287, 96, 1, '9123-4567'),
(288, 96, 4, 'josue@unah.edu.hn'),
(289, 97, 4, 'noe@unah.edu.hn'),
(290, 97, 1, '9234-5678'),
(291, 98, 1, '9324-5678'),
(292, 98, 4, 'milvia@unah.edu.hn'),
(293, 99, 1, '8345-6789'),
(294, 99, 4, 'obed@unah.edu.hn'),
(295, 100, 1, '9324-5678'),
(296, 100, 4, 'sandra@unah.edu.hn'),
(297, 101, 1, '9099-8766'),
(298, 101, 4, 'yolani@unah.edu.hn'),
(299, 102, 1, '9232-4567'),
(300, 102, 4, 'eduardo@unah.edu.hn'),
(301, 103, 1, '9235-4657'),
(302, 103, 4, 'melisa@unah.edu.hn'),
(303, 104, 1, '9123-4546'),
(304, 104, 4, 'carlos@unah.edu.hn'),
(305, 105, 4, 'cesar@unah.edu.hn'),
(307, 106, 1, '9876-5431'),
(308, 106, 4, 'dilma@unah.edu.hn'),
(310, 107, 4, 'heber@unah.edu.hn'),
(311, 108, 1, '9456-7687'),
(312, 108, 4, 'hector@unah.edu.hn'),
(313, 109, 4, 'jose@unah.edu.hn'),
(314, 109, 1, '9546-7890'),
(315, 110, 1, '9456-7890'),
(316, 110, 4, 'jose@unah.edu.hn'),
(317, 111, 1, '9567-6890'),
(318, 111, 4, 'jose@unah.edu.hn'),
(319, 112, 1, '9565-6787'),
(320, 112, 4, 'leonardo@unah.edu.hn'),
(321, 113, 1, '9657-8909'),
(322, 113, 4, 'lester@unah.edu.hn'),
(323, 114, 1, '9897-8789'),
(324, 114, 4, 'rebeca@unah.edu.hn'),
(325, 115, 1, '9435-4678'),
(326, 115, 4, 'tania@unah.edu.hn'),
(327, 116, 1, '9787-8787'),
(328, 116, 4, 'angelica@unah.edu.hn'),
(329, 117, 1, '9899-8997'),
(330, 117, 4, 'jose@unah.edu.hn'),
(331, 118, 1, '3123-4567'),
(332, 118, 4, 'hector@unah.edu.hn'),
(354, 130, 4, 'r1912ramirez@gmail.com'),
(355, 130, 2, ' 9608-0186'),
(356, 130, 1, ' 3333-3333'),
(357, 130, 3, 'TEGUCIGALPA'),
(374, 153, 1, '3456-7899'),
(423, 148, 1, '8998-9989'),
(424, 148, 4, 'prueba@unah.edu.hn'),
(425, 149, 1, '9888-8888'),
(426, 149, 4, 'jj@unah.edu.hn'),
(427, 83, 1, '9898-9898'),
(429, 83, 4, 'prueba.prueba@gmail.com'),
(430, 150, 1, '9898-9898'),
(431, 150, 4, 'pruebac@unah.edu.hn'),
(432, 151, 4, 'gabriel.obando@unah.hn'),
(433, 152, 1, '96333560'),
(434, 152, 4, 'gabriel.obando@unah.hn'),
(435, 152, 3, 'loma linda sur'),
(436, 153, 4, 'hcalix@unah.hn'),
(437, 154, 4, 'r1912ramirez@gmail.com'),
(438, 155, 1, '2220-4469'),
(439, 155, 4, 'cristiano@unah.edu.hn'),
(440, 157, 1, '98497481'),
(441, 157, 4, 'paladaever@yahoo.com'),
(442, 157, 3, 'col.carrizal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_contador_constancia`
--

CREATE TABLE `tbl_contador_constancia` (
  `id_contador` int(11) NOT NULL,
  `contador` int(11) NOT NULL,
  `estado_realizada` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_contador_constancia`
--

INSERT INTO `tbl_contador_constancia` (`id_contador`, `contador`, `estado_realizada`, `descripcion`) VALUES
(1, 85, 0, 'MATUTINA'),
(2, 95, 0, 'VESPERTINA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_departamentos`
--

CREATE TABLE `tbl_departamentos` (
  `id_departamento` bigint(20) NOT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_departamentos`
--

INSERT INTO `tbl_departamentos` (`id_departamento`, `departamento`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'ATLÁNTIDA', NULL, NULL, NULL, NULL),
(2, 'COLÓN', NULL, NULL, NULL, NULL),
(3, 'COMAYAGUA', NULL, NULL, NULL, NULL),
(4, 'COPÁN', NULL, NULL, NULL, NULL),
(5, 'CORTÉS', NULL, NULL, NULL, NULL),
(6, 'CHOLUTECA', NULL, NULL, NULL, NULL),
(7, 'El PARAÍSO', NULL, NULL, NULL, NULL),
(8, 'FRANCISCO MORAZÁN', NULL, NULL, NULL, NULL),
(9, 'GRACIAS A DIOS', NULL, NULL, NULL, NULL),
(10, 'INTIBUCÁ', NULL, NULL, NULL, NULL),
(11, 'ISLAS DE LA BAHÍA', NULL, NULL, NULL, NULL),
(12, 'LA PAZ', NULL, NULL, NULL, NULL),
(13, 'LEMPIRA', NULL, NULL, NULL, NULL),
(14, 'OCOTEPEQUE', NULL, NULL, NULL, NULL),
(15, 'OLANCHO', NULL, NULL, NULL, NULL),
(16, 'SANTA BÁRBARA', NULL, NULL, NULL, NULL),
(17, 'VALLE', NULL, NULL, NULL, NULL),
(18, 'YORO', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_desea_asig_doce`
--

CREATE TABLE `tbl_desea_asig_doce` (
  `id_desea_asig_doce` bigint(20) NOT NULL,
  `id_persona` bigint(16) DEFAULT NULL,
  `Id_asignatura` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_desempeno_practica`
--

CREATE TABLE `tbl_desempeno_practica` (
  `id_desempeno_practica` bigint(16) NOT NULL,
  `id_persona` bigint(20) NOT NULL,
  `asistencia_practicante` varchar(255) NOT NULL,
  `horario_practicante` varchar(255) NOT NULL,
  `adaptacion_practicante` varchar(255) NOT NULL,
  `cumplimiento_practicante` varchar(255) NOT NULL,
  `calidad_trabajo_practicante` varchar(255) NOT NULL,
  `percepcion_conocimiento` varchar(255) NOT NULL,
  `percepcion_habilidades` varchar(255) NOT NULL,
  `numero_visita` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_dias`
--

CREATE TABLE `tbl_dias` (
  `id_dia` bigint(16) NOT NULL DEFAULT 0,
  `dia` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_dias`
--

INSERT INTO `tbl_dias` (`id_dia`, `dia`, `descripcion`) VALUES
(1, 'LuMaMiJu', 'lunes a jueves'),
(2, 'LuMaMiJuVi', 'lunes a viernes'),
(3, 'LuMi', ''),
(4, 'Ma', ''),
(5, 'Miercoles', ''),
(6, 'Jueves', ''),
(7, 'Viernes', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_dias_feriados`
--

CREATE TABLE `tbl_dias_feriados` (
  `id_dia_feriado` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_dias_feriados`
--

INSERT INTO `tbl_dias_feriados` (`id_dia_feriado`, `fecha`, `descripcion`, `estado`) VALUES
(1, '2021-03-25', 'dia de prueba', 1),
(2, '2021-04-02', 'Dia de prueba dos', 1),
(3, '2021-04-15', 'Feriado 3.1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_docentes_proyecto`
--

CREATE TABLE `tbl_docentes_proyecto` (
  `id_docente_proyecto` bigint(16) NOT NULL,
  `Id_proyecto` bigint(16) NOT NULL,
  `nombre_coordinador` varchar(255) NOT NULL,
  `numero_empleado` bigint(12) NOT NULL,
  `direccion_coordinador` varchar(50) NOT NULL,
  `cargo_coordinador` varchar(50) NOT NULL,
  `correo_coordinador` varchar(40) NOT NULL,
  `telefono_coordinador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_edificios`
--

CREATE TABLE `tbl_edificios` (
  `id_edificio` bigint(16) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_edificios`
--

INSERT INTO `tbl_edificios` (`id_edificio`, `nombre`, `codigo`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'C2', ' C2 ', NULL, NULL, NULL, NULL),
(2, 'C1', 'C1', NULL, NULL, '2021-03-31 02:57:07', 'ADMIN'),
(6, 'C3', 'C3', NULL, NULL, '2021-05-03 06:57:47', 'ADMIN'),
(7, 'K2', 'K2', NULL, NULL, '2021-05-03 06:56:53', 'ADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_egresados`
--

CREATE TABLE `tbl_egresados` (
  `Id_egresado` bigint(16) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cuenta` bigint(13) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `celular_egresado` varchar(12) DEFAULT NULL,
  `telefono_egresado` varchar(12) DEFAULT NULL,
  `fecha_graduacion` varchar(30) NOT NULL,
  `posee_maestria` char(2) DEFAULT NULL,
  `maestria` varchar(255) DEFAULT NULL,
  `posee_certificado` char(2) DEFAULT NULL,
  `certificado` varchar(255) DEFAULT NULL,
  `labora` char(2) DEFAULT NULL,
  `nombre_empresa` varchar(255) DEFAULT NULL,
  `direccion_empresa` varchar(255) DEFAULT NULL,
  `telefono_empresa` varchar(12) DEFAULT NULL,
  `departamento_egresado` varchar(255) DEFAULT NULL,
  `correo_profesional` varchar(255) DEFAULT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_egresados`
--

INSERT INTO `tbl_egresados` (`Id_egresado`, `nombre`, `cuenta`, `correo_electronico`, `celular_egresado`, `telefono_egresado`, `fecha_graduacion`, `posee_maestria`, `maestria`, `posee_certificado`, `certificado`, `labora`, `nombre_empresa`, `direccion_empresa`, `telefono_empresa`, `departamento_egresado`, `correo_profesional`, `Fecha_creacion`) VALUES
(2, 'LUISA', 732332532455, 'PRUEBA@PRUEBA.COM', ' 8888-3222', ' 2222-3333', '0000-00-00', 'NO', 'S', 'NO', 'PRUEBA', 'SI', 'PRUEBA', 'N/A', ' 2222-2222', 'N/A', '', '2020-05-30 19:50:36'),
(3, 'LUISSA', 7786372, 'PRUEBA@PRUEBA.COM', ' 2277-7687', ' 2222-2222', '0000-00-00', 'NO', '', 'NO', '', 'NO', 'N/A', 'N/A', 'N/A', 'N/A', '', '2020-05-30 19:53:38'),
(4, 'PRUEBAS', 657647, 'PRUEBA@PRUEBA.COM', ' 8888-8888', ' 2222-2222', '2020', 'SI', 'PRUEBAS', 'NO', 'N/A', 'NO', 'N/A', 'N/A', '', 'N/A', '', '2020-05-30 19:57:33'),
(6, 'CHRISTEL NEUMANN', 20141011506, 'PRUEBA@PRUEBA.COM', ' 9999-9999', ' 2234-0131', '2020', 'SI', 'BI', 'SI', 'CNNA', 'NO', 'N/A', 'N/A', '', 'N/A', '', '2020-05-31 17:21:08'),
(7, 'HYHY', 5665645, 'PRUEBASSS@PPAA.COM', ' 5665-6565', ' 5656-5656', '2019', 'SI', 'K', 'SI', 'CNNA', 'SI', 'CXX', 'GFHFH', ' 7969-6767', 'DSD', 'BVCN@INH.COM', '2020-06-01 00:12:37'),
(8, 'MARIA CALLEJAS', 20141011539, 'MARIA@YAHOO.COM', ' 8951-6364', ' 2569-8114', '2020', 'SI', 'SEGURIDAD', 'SI', 'CNNA', 'SI', 'TIGO', 'LA SOSA', ' 2236-8956', 'SISTEMAS', 'TIGO@YAHOO.COM', '2020-06-25 14:37:08'),
(9, 'RAMBO', 20201002000, 'KJH@YAHOO.COM', ' 8898-6632', ' 2235-9874', '2020', 'SI', 'SEGURIDAD', 'SI', 'CNNA', 'SI', 'CASA', 'LA SOSA', ' 2236-9845', 'CUARTO', 'HH@YAHOO.COM', '2020-09-28 10:43:30'),
(10, 'DDDDDDDDDDDDDDDDDDD', 544555555555, 'TRHYR@JHJK.COM', ' 5444-4444', ' 2222-2222', '2020', 'SI', 'SEGURIDAD', 'SI', 'CISCO', 'NO', 'N/A', 'N/A', '', 'N/A', '', '2020-10-09 20:05:50'),
(11, 'LUIS PONCE', 20141011508, 'HJFJH@YAHOO.COM', ' 8888-8888', ' 2222-2222', '2020', 'SI', 'CIBERSEGURIDAD', 'SI', 'CNNA', 'SI', 'CONCISA', 'COLONIA LAS BRISAS BLOQUE G', ' 2222-2222', 'BASE DE DATOS', 'HJFJH@YAHOO.COM', '2021-03-05 01:54:10'),
(12, 'ROSA', 20111002345, 'R_CORRALES@UNAH.EDU.HN', ' 9768-0826', ' 9768-0826', '2021', 'SI', 'DDD', 'SI', 'DSDS', 'SI', 'ROSMERY ', 'DSDSD', ' 9768-0826', 'DSD', 'R_CORRALES@HOTMAIL.COM', '2021-04-06 01:05:56'),
(14, 'LULU LOLO', 200000000000, 'HJHGJH@YAHOO.COM', ' 8888-8888', ' 2333-3333', '2020', 'NO', 'N/A', 'SI', 'ISO ', 'NO', 'N/A', 'N/A', 'N/A', 'N/A', '', '2021-04-14 02:27:42'),
(15, 'ASD', 12312312312, 'QWE@ASDASD', ' 9872-4654', ' 2131-2312', '2021', 'NO', 'N/A', 'NO', 'N/A', 'NO', 'N/A', 'N/A', 'N/A', 'N/A', '', '2021-04-26 05:52:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empresas_practica`
--

CREATE TABLE `tbl_empresas_practica` (
  `Id_empresa` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `direccion_empresa` varchar(255) NOT NULL,
  `tipo_empresa` varchar(255) DEFAULT NULL,
  `labora_dentro` varchar(255) DEFAULT NULL,
  `departamento_empresa` varchar(255) NOT NULL,
  `jefe_inmediato` varchar(255) NOT NULL,
  `titulo_jefe_inmediato` varchar(255) NOT NULL,
  `cargo_jefe_inmediato` varchar(255) NOT NULL,
  `correo_jefe_inmediato` varchar(255) NOT NULL,
  `telefono_jefe_inmediato` varchar(10) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_empresas_practica`
--

INSERT INTO `tbl_empresas_practica` (`Id_empresa`, `id_persona`, `nombre_empresa`, `direccion_empresa`, `tipo_empresa`, `labora_dentro`, `departamento_empresa`, `jefe_inmediato`, `titulo_jefe_inmediato`, `cargo_jefe_inmediato`, `correo_jefe_inmediato`, `telefono_jefe_inmediato`, `Fecha_creacion`) VALUES
(17, 22, 'UNAH', 'B. SUYAPA', 'PUBLICA', 'NO', 'TI', 'CARLO BANEGAS', 'LIC', 'JEFE', 'R1912RAMIREZ@UNAH.HN', ' 8998-9988', '2021-03-18 23:23:30'),
(18, 26, 'HOLA', 'HOLA', 'PRIVADA', 'SI', 'HOLA', 'HOLA', 'HOLA', 'HOLA', 'R1912RAMIREZ@GMAIL.COM', ' 2222-2222', '2021-03-19 16:30:07'),
(19, 27, 'UPN', 'B. SUYAPA', 'PUBLICA', 'NO', 'TI', 'ROSMERY CORRALES', 'LIC', 'JEFE', 'R1912RAMIREZ@GMAIL.COM', ' 9999-9999', '2021-03-19 17:13:13'),
(20, 61, 'EMANUEL TRAVEL', 'TEGUCIGALPA', 'PUBLICA', 'NO', 'TI', 'DANIEL', 'LIC', 'JEFE', 'R1912RAMIREZ@GMAIL.COM', ' 9608-0186', '2021-03-23 22:21:07'),
(21, 18, 'INTELNEG', 'RESIDENCIAL EL SAUVE, VILLAS LAS ACACIAS', NULL, NULL, 'FRAC', 'ER', 'ING SISTEMAS', 'JEFE DE INFORMATICA', 'R_CORRALES@HOTMAIL.COM', ' 9768-0826', '2021-04-04 19:37:46'),
(22, 6, 'CONCISA', 'BULEVAR SUYAPA', NULL, NULL, 'BASE DE DATOS', 'KARY PONCE', 'LICENCIADA', 'RRHH', 'JHHJH@YAHOO.COM', ' 2222-2222', '2021-04-14 02:29:01'),
(23, 130, 'EMANUEL TRAVELW', 'TEGUCIGALPA', 'PRIVADA', 'SI', 'TI', 'DANIEL', 'LICENCIATURA', 'JEFE', 'R1912RAMIREZ@GMAIL.COM', ' 9608-0186', '2021-04-19 20:57:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empresa_aporte_proyecto`
--

CREATE TABLE `tbl_empresa_aporte_proyecto` (
  `Id_aporte` bigint(16) NOT NULL,
  `aporte` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_empresa_aporte_proyecto`
--

INSERT INTO `tbl_empresa_aporte_proyecto` (`Id_aporte`, `aporte`, `Fecha_creacion`) VALUES
(1, 'ACADEMICO', '2020-05-31 00:00:00'),
(2, 'FINANCIERO', '2020-05-31 00:00:00'),
(3, 'ADMINSTRATIVO', '2020-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_equivalencias`
--

CREATE TABLE `tbl_equivalencias` (
  `Id_equivalencia` bigint(16) NOT NULL,
  `id_persona` bigint(16) DEFAULT NULL,
  `observacion` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `aprobado` varchar(255) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_equivalencias`
--

INSERT INTO `tbl_equivalencias` (`Id_equivalencia`, `id_persona`, `observacion`, `Fecha_creacion`, `aprobado`, `documento`, `tipo`, `correo`) VALUES
(17, 6, '', '2020-10-12 16:25:01', 'desaprobado', '[\"../archivos/equivalencias/contenido/20141011506/Abrir acceso por red a Xampp.pdf\",\"../archivos/equivalencias/contenido/20141011506/bd_Automatizacion.pdf\"]', 'CONTENIDO', 'nicolle@unah.hn'),
(18, 6, '', '2020-10-12 16:25:31', 'desaprobado', '[\"../archivos/equivalencias/codigo/20141011506/doc(1).pdf\",\"../archivos/equivalencias/codigo/20141011506/doc(2).pdf\"]', 'CODIGO', 'nicole@unah.hn'),
(19, 4, '', '2020-10-12 17:38:53', 'desaprobado', '[\"../archivos/equivalencias/contenido/20131015093/Abrir acceso por red a Xampp.pdf\",\"../archivos/equivalencias/contenido/20131015093/bd_Automatizacion.pdf\"]', 'CONTENIDO', 'hcalix92@gmail.com'),
(20, 153, '', '2021-05-20 22:21:10', 'desaprobado', '[\"../archivos/equivalencias/codigo/20131015093/doc.pdf\",\"../archivos/equivalencias/codigo/20131015093/doc(2).pdf\"]', 'CODIGO', 'sa@unah.hn'),
(21, 153, '', '2021-05-20 22:21:57', 'desaprobado', '[\"../archivos/equivalencias/contenido/20131015093/doc.pdf\",\"../archivos/equivalencias/contenido/20131015093/doc(1).pdf\"]', 'CONTENIDO', 'sa@unah.hn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_especialidad_grado`
--

CREATE TABLE `tbl_especialidad_grado` (
  `id_especialidad` int(11) NOT NULL,
  `id_grado_academico` int(11) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_especialidad_grado`
--

INSERT INTO `tbl_especialidad_grado` (`id_especialidad`, `id_grado_academico`, `especialidad`) VALUES
(1, 4, 'redes'),
(2, 4, 'inf'),
(3, 4, 'informatica'),
(4, 1, 'DOCTORADO -PROBANDO'),
(5, 1, 'DOCTORADO -PRUEBA'),
(6, 2, 'DOCTORADO - PRABANDA'),
(7, 2, 'DOCTORADO -PROBANDO'),
(8, 3, 'DOCTORADO -PROBANDO'),
(9, 3, 'tocar flauta'),
(10, 2, 'informatica'),
(11, 2, 'infx'),
(12, 3, 'informma'),
(13, 4, 'redes'),
(14, 2, 'inf'),
(15, 2, 'inf'),
(16, 2, 'redes'),
(17, 2, 'h'),
(19, 1, 's'),
(20, 4, 'DOCTORADO -PROBANDO'),
(21, 1, 'f'),
(22, 1, 'hh'),
(23, 1, 'tec'),
(24, 3, 'rtrt'),
(25, 2, 'er'),
(26, 4, 'DOCTORADO -PRUEBA'),
(27, 1, 'rtyui'),
(28, 4, 'DOCTORADO -PRUEBA'),
(29, 2, 'PREGRADO -PRBANDOX'),
(30, 2, 'xd'),
(31, 3, 'df'),
(32, 1, 'er'),
(33, 2, 'dgg'),
(34, 1, 'rtgrgrg'),
(35, 3, 'gh'),
(36, 1, 'rtrt'),
(37, 1, 'r'),
(38, 1, 'rt'),
(39, 1, 'gf'),
(40, 3, 'actuacion'),
(41, 4, 'directora de cine'),
(42, 1, 'TÉCNICO -PRU'),
(43, 1, 'actuacion'),
(44, 1, 'cine'),
(45, 1, 'TÉCNICO -CAMINAR'),
(46, 2, 'PREGRADO -CORRER'),
(47, 3, 'POSGRADO -VOLAR'),
(48, 4, 'futbol'),
(49, 4, 'pelota'),
(50, 1, 'hoteleria'),
(51, 3, 'futbol'),
(52, 3, 'POSGRADO -A'),
(53, 3, 'POSGRADO -INFORMATICA'),
(54, 3, 'informatica'),
(55, 3, 'informatica'),
(56, 3, 'informatica'),
(57, 3, 'informatica'),
(58, 3, 'informatica'),
(59, 3, 'informatica'),
(60, 3, 'informatica'),
(61, 3, 'informatica'),
(62, 3, 'informatica'),
(63, 3, 'informatica'),
(64, 3, 'informatica'),
(65, 3, 'informatica'),
(66, 3, 'informatica'),
(67, 3, 'informatica'),
(68, 3, 'informatica'),
(69, 3, 'informatica'),
(70, 3, 'informatica'),
(71, 3, 'informatica'),
(72, 3, 'informatica'),
(73, 3, 'informatica'),
(74, 3, 'informatica'),
(75, 3, 'informatica'),
(76, 3, 'informatica'),
(77, 3, 'informatica'),
(78, 3, 'informatica'),
(79, 3, 'informatica'),
(80, 3, 'informatica'),
(81, 3, 'informatica'),
(82, 3, 'informatica'),
(83, 3, 'informatica'),
(84, 3, 'informatica'),
(85, 3, 'informatica'),
(86, 3, 'informatica'),
(87, 3, 'informatica'),
(88, 3, 'informatica'),
(89, 3, 'informatica'),
(90, 3, 'informatica'),
(91, 1, 'TÉCNICO -CORRER'),
(92, 2, 'PREGRADO -COMER'),
(93, 1, 'TÉCNICO -PERREAR'),
(94, 2, 'PREGRADO -AAAAAA'),
(95, 2, 'PREGRADO -HHH'),
(96, 2, 'PREGRADO -KKK'),
(97, 2, 'CORRER'),
(98, 1, 'HH'),
(99, 2, 'KIK'),
(100, 1, 'TT'),
(101, 2, 'JJ'),
(102, 4, 'nada'),
(103, 2, 'HJFFF'),
(104, 4, 'neles'),
(105, 3, 'INFORMÁTICA'),
(106, 1, 'INFORMATICA'),
(107, 1, 'SDF'),
(108, 1, 'DDD'),
(109, 1, 'DDD'),
(110, 2, 'KL'),
(111, 3, 'DSSSS'),
(112, 3, 'SSS'),
(113, 3, 'AAAAA'),
(114, 3, 'EEEEEE'),
(115, 2, 'TTTTTTT'),
(116, 2, 'GGGGGG'),
(117, 2, 'LLLLLLL'),
(118, 4, 'BBBBBBBB'),
(119, 3, 'MMMMM'),
(120, 3, 'GGGGGG'),
(121, 3, 'DDDDDD'),
(122, 2, 'ADFFDFSFSDFDF'),
(123, 3, 'DDDDD'),
(124, 4, 'ADF'),
(125, 2, 'INFORMATICA'),
(126, 3, 'APLICADO'),
(127, 4, 'A LA EDUCACION'),
(128, 4, 'inf'),
(129, 3, 'ed'),
(130, 3, 'rgrt'),
(131, 2, 'cine actuacion'),
(132, 2, 'FF'),
(133, 2, 'INFORMATICA'),
(134, 3, 'DISEÑO GRAFICO'),
(135, 2, 'INFORMTICA'),
(136, 2, 'INFORMATICA'),
(137, 2, 'INFORMATICA'),
(138, 4, 'CIENCIA DE LA INFORMACIÓN'),
(139, 2, 'INFORMATICA'),
(140, 1, 'd'),
(141, 2, 'INFORMATICA'),
(142, 2, 'INFORMATICA'),
(143, 3, 'INFORMATICA'),
(144, 3, 'B'),
(145, 1, 'G'),
(146, 4, 'H'),
(147, 4, 'GGG'),
(148, 1, 'GGGGGGGGGJH'),
(149, 3, 'INFORMATICA'),
(150, 2, 'CFF'),
(151, 2, 'DD'),
(152, 2, 'hjdhjkas'),
(153, 2, 'fhghkj'),
(154, 3, 'fg'),
(155, 2, 'fghhjkkl'),
(156, 1, 'ghgh'),
(157, 3, 'gfs'),
(158, 2, 'gfds'),
(159, 2, 'dfdsfdfds'),
(160, 2, 'GDH'),
(161, 2, 'FAJDSSDS'),
(162, 1, 'DFJL'),
(163, 3, 'ADGHJ'),
(164, 2, 'INFOMATICA ADMINISTRATIVA'),
(165, 3, 'RECURSOS HUMANOS'),
(166, 2, 'sdss'),
(167, 4, 'ff'),
(168, 2, 'hh'),
(169, 2, 'er'),
(170, 1, 're'),
(171, 3, 'fghj'),
(172, 2, 'informatica'),
(173, 1, 'informatica'),
(174, 4, 'redes informaticas'),
(175, 3, 'DISEÑO WEB'),
(176, 5, 'INFORMATICA'),
(177, 1, 'PROFESIONAL EN INFORMATICA'),
(178, 4, 'INFORMATICA'),
(179, 2, 'PRUEBA'),
(180, 1, 'INFORMATICA'),
(181, 3, 'pruea'),
(182, 2, 'probando'),
(183, 4, 'informatica'),
(184, 2, 'prueba'),
(185, 3, 'INFORMATICA'),
(186, 2, 'INFORMATICA'),
(187, 3, 'futbolista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estadocivil`
--

CREATE TABLE `tbl_estadocivil` (
  `id_estado_civil` int(11) NOT NULL,
  `estado_civil` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_estadocivil`
--

INSERT INTO `tbl_estadocivil` (`id_estado_civil`, `estado_civil`, `descripcion`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'SOLTERO', 'SOLTERO', NULL, NULL, '2021-04-15 07:16:45', 'ADMIN'),
(4, 'UNION LIBRE', 'UNION LIBRE', '2020-12-05 02:14:33', 'ADMIN', '2021-04-15 07:17:30', 'ADMIN'),
(10, 'CASADO', 'CASADO', '2020-12-05 03:00:20', 'ADMIN', '2021-04-15 07:18:11', 'ADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estudiantes_proyecto`
--

CREATE TABLE `tbl_estudiantes_proyecto` (
  `Id_estudiante_proyecto` bigint(16) NOT NULL,
  `nombre_estudiante` varchar(255) DEFAULT NULL,
  `cargo_estudiante` varchar(255) DEFAULT NULL,
  `telefono_estudiante` int(8) DEFAULT NULL,
  `correo_estudiante` varchar(255) DEFAULT NULL,
  `numero_empleado` bigint(16) DEFAULT NULL,
  `direccion_estudiante` varchar(255) DEFAULT NULL,
  `Id_proyecto` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_estudiantes_proyecto`
--

INSERT INTO `tbl_estudiantes_proyecto` (`Id_estudiante_proyecto`, `nombre_estudiante`, `cargo_estudiante`, `telefono_estudiante`, `correo_estudiante`, `numero_empleado`, `direccion_estudiante`, `Id_proyecto`) VALUES
(57, 'SDSD', 'DASD', 12312, 'DSDS', 31232, 'DSDDSD', 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_evaluaciones_practica`
--

CREATE TABLE `tbl_evaluaciones_practica` (
  `id_evaluacion_practica` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `comunicacion` varchar(255) NOT NULL,
  `puntualidad` varchar(255) NOT NULL,
  `responsabilidad` varchar(255) NOT NULL,
  `creatividad` varchar(255) NOT NULL,
  `presentacion` varchar(255) NOT NULL,
  `atencion_cliente` varchar(255) NOT NULL,
  `colaborativo` varchar(255) NOT NULL,
  `trabajo_equipo` varchar(255) NOT NULL,
  `proactivo_iniciativa` varchar(255) NOT NULL,
  `relacion_interpersonal` varchar(255) NOT NULL,
  `analisis_sistema` varchar(255) NOT NULL,
  `diseno_aplicacion` varchar(255) NOT NULL,
  `programador_aplicacion` varchar(255) NOT NULL,
  `mantenimiento_aplicacion` varchar(255) NOT NULL,
  `aspecto_auditoria` varchar(255) NOT NULL,
  `aspecto_seguridad` varchar(255) NOT NULL,
  `numero_visita` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_evaluaciones_practica`
--

INSERT INTO `tbl_evaluaciones_practica` (`id_evaluacion_practica`, `id_persona`, `comunicacion`, `puntualidad`, `responsabilidad`, `creatividad`, `presentacion`, `atencion_cliente`, `colaborativo`, `trabajo_equipo`, `proactivo_iniciativa`, `relacion_interpersonal`, `analisis_sistema`, `diseno_aplicacion`, `programador_aplicacion`, `mantenimiento_aplicacion`, `aspecto_auditoria`, `aspecto_seguridad`, `numero_visita`) VALUES
(1, 26, 'Muy bueno', 'Muy bueno', 'Muy Bueno', 'Muy Bueno', 'Muy Bueno', 'Muy Bueno', 'Intermedio', 'Intermedio', 'Intermedio', 'Intermedio', 'Intermedio', 'Intermedio', 'Intermedio', 'Intermedio', 'Intermedio', 'Intermedio', 'Primera Supervisión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_expe_academica_docente`
--

CREATE TABLE `tbl_expe_academica_docente` (
  `id_expe_academi_docente` bigint(16) NOT NULL,
  `id_area` bigint(16) DEFAULT NULL,
  `id_persona` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_facultades`
--

CREATE TABLE `tbl_facultades` (
  `Id_facultad` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_facultades`
--

INSERT INTO `tbl_facultades` (`Id_facultad`, `nombre`, `Fecha_creacion`) VALUES
(1, 'Ciencias Economicas', '2020-05-31 00:00:00'),
(2, 'Medicina', '2021-03-18 18:50:48'),
(3, 'Facultad de Humanidades y arte', '2021-04-05 19:18:47'),
(4, 'Informatica Administrativa', '2021-05-27 16:30:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_feriado`
--

CREATE TABLE `tbl_feriado` (
  ` id_feriado` bigint(11) NOT NULL,
  `nombre_dia` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_feriado`
--

INSERT INTO `tbl_feriado` (` id_feriado`, `nombre_dia`, `fecha`) VALUES
(1, 'Lunes', '2021-04-19 00:00:00'),
(2, 'Martes', '2021-05-19 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_finalizacion_practica`
--

CREATE TABLE `tbl_finalizacion_practica` (
  `Id_finalizacion` bigint(16) NOT NULL,
  `Id_practica` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `observacion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `aprobado` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `archivo` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_finalizacion_practica`
--

INSERT INTO `tbl_finalizacion_practica` (`Id_finalizacion`, `Id_practica`, `id_persona`, `observacion`, `aprobado`, `fecha_creacion`, `archivo`, `correo`) VALUES
(89, 1, 6, '', 'desaprobado', '2020-10-12 17:45:04', ' ../archivos/finalizacion/20141011506/Abrir acceso por red a Xampp.pdf', 'nicole@unah.hn'),
(90, 3, 4, '', 'desaprobado', '2020-10-12 17:34:12', ' ../archivos/finalizacion/20131015093/doc(1).pdf', 'hcalix92@gmail.com'),
(91, 3, 4, '', 'desaprobado', '2020-10-22 17:32:24', ' ../archivos/finalizacion/20131015093/Abrir acceso por red a Xampp.pdf', 'helmer.calix@unah.hn'),
(92, 16, 153, '', 'desaprobado', '2021-05-20 21:26:56', ' ../archivos/finalizacion/20131015093/doc.pdf', 'sa@unah.hn');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_funciones_practica`
--

CREATE TABLE `tbl_funciones_practica` (
  `id_funcion_practica` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `funciones_analisis` varchar(255) NOT NULL,
  `numero_visita` varchar(255) NOT NULL,
  `funciones_diseno` varchar(255) NOT NULL,
  `funciones_redes` varchar(255) NOT NULL,
  `funciones_capacitacion` varchar(255) NOT NULL,
  `funciones_seguridad` varchar(255) NOT NULL,
  `funciones_auditoria` varchar(255) NOT NULL,
  `funciones_base` varchar(255) NOT NULL,
  `funciones_soporte` varchar(255) NOT NULL,
  `funciones_programacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_funciones_practica`
--

INSERT INTO `tbl_funciones_practica` (`id_funcion_practica`, `id_persona`, `funciones_analisis`, `numero_visita`, `funciones_diseno`, `funciones_redes`, `funciones_capacitacion`, `funciones_seguridad`, `funciones_auditoria`, `funciones_base`, `funciones_soporte`, `funciones_programacion`) VALUES
(1, 26, 'Análisis de Sistemas', 'Primera Supervisión', '', 'Redes y Comunicación de Datos', '', '', '', 'Base de Datos', 'Soporte de Aplicaciones', 'Programación de Aplicaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_genero`
--

CREATE TABLE `tbl_genero` (
  `id_genero` int(11) NOT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_genero`
--

INSERT INTO `tbl_genero` (`id_genero`, `genero`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'MASCULINO', NULL, NULL, NULL, NULL),
(2, 'FEMENINO', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_grados_academicos`
--

CREATE TABLE `tbl_grados_academicos` (
  `id_grado_academico` int(11) NOT NULL,
  `grado_academico` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `Fecha_Creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_grados_academicos`
--

INSERT INTO `tbl_grados_academicos` (`id_grado_academico`, `grado_academico`, `descripcion`, `Fecha_Creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'TÉCNICO', 'PRUEBA', NULL, NULL, '2021-04-29 01:29:38', 'ADMIN'),
(2, 'PREGRADO', NULL, NULL, NULL, NULL, NULL),
(3, 'POSGRADO', 'POSGRADO', NULL, NULL, '2021-04-27 04:32:40', 'ADMIN'),
(4, 'DOCTORADO', 'DOCTORADO', NULL, NULL, '2021-04-27 04:31:52', 'ADMIN'),
(5, 'POSGRADOO', 'POSGRADOO', '2021-04-27 10:03:22', 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_grados_academicos_personas`
--

CREATE TABLE `tbl_grados_academicos_personas` (
  `id_grado_aca_personas` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `id_persona` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_grados_academicos_personas`
--

INSERT INTO `tbl_grados_academicos_personas` (`id_grado_aca_personas`, `id_especialidad`, `id_persona`) VALUES
(50, 54, 81),
(51, 55, 82),
(53, 57, 84),
(54, 58, 85),
(55, 59, 86),
(56, 60, 88),
(57, 61, 89),
(58, 62, 90),
(59, 63, 91),
(60, 64, 92),
(61, 65, 93),
(62, 66, 94),
(63, 67, 95),
(64, 68, 96),
(65, 69, 97),
(66, 70, 98),
(67, 71, 99),
(68, 72, 100),
(69, 73, 101),
(70, 74, 102),
(71, 75, 103),
(72, 76, 104),
(73, 77, 105),
(74, 78, 106),
(75, 79, 107),
(76, 80, 108),
(77, 81, 109),
(78, 82, 110),
(79, 83, 111),
(80, 84, 112),
(81, 85, 113),
(82, 86, 114),
(83, 87, 115),
(84, 88, 116),
(85, 89, 117),
(86, 90, 118),
(162, 179, 83),
(165, 183, 148),
(166, 184, 149),
(167, 186, 150),
(168, 187, 155);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_hora`
--

CREATE TABLE `tbl_hora` (
  `hora` varchar(4) NOT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_hora`
--

INSERT INTO `tbl_hora` (`hora`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
('0600', NULL, NULL, '2021-05-08 06:25:56', 'ADMIN'),
('0700', NULL, NULL, NULL, NULL),
('0800', NULL, NULL, NULL, NULL),
('0900', NULL, NULL, NULL, NULL),
('1000', NULL, NULL, NULL, NULL),
('1100', NULL, NULL, NULL, NULL),
('1200', NULL, NULL, '2021-03-08 18:55:09', '(NULL)'),
('1300', NULL, NULL, NULL, NULL),
('1400', NULL, NULL, NULL, NULL),
('1500', NULL, NULL, NULL, NULL),
('1600', NULL, NULL, NULL, NULL),
('1700', NULL, NULL, NULL, NULL),
('1800', NULL, NULL, NULL, NULL),
('1900', NULL, NULL, NULL, NULL),
('2000', NULL, NULL, NULL, NULL),
('2100', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_horario_docentes`
--

CREATE TABLE `tbl_horario_docentes` (
  `id_horario_docente` bigint(20) NOT NULL,
  `id_jornada` bigint(20) DEFAULT NULL,
  `id_categoria_persona` bigint(20) DEFAULT NULL,
  `hr_inicial` varchar(50) DEFAULT NULL,
  `hr_final` varchar(50) DEFAULT NULL,
  `id_persona` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_horario_docentes`
--

INSERT INTO `tbl_horario_docentes` (`id_horario_docente`, `id_jornada`, `id_categoria_persona`, `hr_inicial`, `hr_final`, `id_persona`) VALUES
(16, 3, 18, '0600', '2000', 39),
(44, 5, 46, '1200', '1800', 80),
(45, 3, 47, '0900', '1500', 81),
(46, 5, 48, '1200', '1800', 82),
(47, 5, 49, '1200', '1800', 83),
(48, 5, 50, '1200', '1800', 84),
(49, 5, 51, '1200', '1800', 85),
(50, 5, 52, '1200', '1800', 86),
(51, 5, 53, '1200', '1800', 87),
(52, 5, 54, '1200', '1800', 88),
(53, 5, 55, '1200', '1800', 89),
(54, 5, 56, '1200', '1800', 90),
(55, 5, 57, '1200', '1800', 91),
(56, 5, 58, '1200', '1800', 92),
(57, 5, 59, '1200', '1800', 93),
(58, 5, 60, '1200', '1800', 94),
(59, 5, 61, '1200', '1800', 95),
(60, 5, 62, '1200', '1800', 96),
(61, 5, 63, '1200', '1800', 97),
(62, 5, 64, '1200', '1800', 98),
(63, 5, 65, '1200', '1800', 99),
(64, 5, 66, '1200', '1800', 100),
(65, 5, 67, '1200', '1800', 101),
(66, 5, 68, '1200', '1800', 102),
(67, 4, 69, '1200', '1500', 103),
(68, 3, 70, '0800', '1000', 104),
(69, 3, 71, '0800', '1000', 105),
(70, 3, 72, '1100', '1300', 106),
(71, 3, 73, '1000', '1200', 107),
(72, 3, 74, '1200', '1800', 108),
(73, 3, 75, '1100', '1300', 109),
(74, 3, 76, '1300', '1400', 110),
(75, 3, 77, '0700', '1000', 111),
(76, 3, 78, '1200', '1400', 112),
(77, 3, 79, '1500', '1700', 113),
(78, 3, 80, '1300', '1500', 114),
(79, 3, 81, '1200', '1400', 115),
(80, 5, 82, '1200', '1800', 116),
(81, 5, 83, '1200', '1800', 117),
(82, 5, 84, '1200', '1800', 118),
(111, 5, 113, '0600', '1200', 148),
(112, 3, 114, '1800', '2000', 149),
(113, 5, 115, '0800', '1400', 150),
(114, 4, 116, '1000', '1700', 155),
(115, 3, 117, '0600', '1700', 156);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_horario_himno`
--

CREATE TABLE `tbl_horario_himno` (
  `id_horario_himno` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `jornada` varchar(10) NOT NULL,
  `cupos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_horario_himno`
--

INSERT INTO `tbl_horario_himno` (`id_horario_himno`, `fecha`, `hora`, `jornada`, `cupos`) VALUES
(12, '2020-11-17', '02:15:00', 'VESPERTINA', 19),
(13, '2020-12-01', '09:00:00', 'MATUTINA', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_jornadas`
--

CREATE TABLE `tbl_jornadas` (
  `id_jornada` bigint(20) NOT NULL,
  `jornada` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_jornadas`
--

INSERT INTO `tbl_jornadas` (`id_jornada`, `jornada`, `descripcion`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(3, 'POR HORA', 'POR HORA', NULL, NULL, NULL, NULL),
(4, 'MEDIO TIEMPO', 'MEDIO TIEMPO', NULL, NULL, NULL, NULL),
(5, 'TIEMPO COMPLETO', 'TIEMPO COMPLETO', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modalidad`
--

CREATE TABLE `tbl_modalidad` (
  `id_modalidad` bigint(20) NOT NULL,
  `modalidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_modalidad`
--

INSERT INTO `tbl_modalidad` (`id_modalidad`, `modalidad`) VALUES
(1, 'Presencial'),
(2, 'Semi-Presencial'),
(3, 'Virtual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modalidades_proyecto`
--

CREATE TABLE `tbl_modalidades_proyecto` (
  `Id_modalidad` bigint(16) NOT NULL,
  `modalidad` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_modalidades_proyecto`
--

INSERT INTO `tbl_modalidades_proyecto` (`Id_modalidad`, `modalidad`, `Fecha_creacion`) VALUES
(1, 'UNIDISCIPLINARIA', '2020-05-31 00:00:00'),
(2, 'INTRADISCIPLINARIA', '2020-05-31 00:00:00'),
(3, 'INTERDISCIPLINARIA', '2020-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_municipios_hn`
--

CREATE TABLE `tbl_municipios_hn` (
  `id_municipio` bigint(20) NOT NULL,
  `municipio` varchar(50) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `id_departamento` bigint(20) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_municipios_hn`
--

INSERT INTO `tbl_municipios_hn` (`id_municipio`, `municipio`, `codigo`, `id_departamento`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'La ceiba', '0101', 1, NULL, NULL, NULL, NULL),
(2, 'El Porvenir', '0102', 1, NULL, NULL, NULL, NULL),
(3, 'Esparta', '0103', 1, NULL, NULL, '2021-03-18 07:28:39', 'rre'),
(5, 'La Masica', '0105', 1, NULL, NULL, NULL, NULL),
(6, 'San Francisco', '0106', 1, NULL, NULL, NULL, NULL),
(7, 'Tela', '0107', 1, NULL, NULL, NULL, NULL),
(8, 'Arizona', '0108', 1, NULL, NULL, NULL, NULL),
(9, 'Trujillo ', '0201', 2, NULL, NULL, NULL, NULL),
(10, 'Balfate', '0202', 2, NULL, NULL, NULL, NULL),
(11, 'Iriona', '0203', 2, NULL, NULL, NULL, NULL),
(12, 'Limón', '0204', 2, NULL, NULL, NULL, NULL),
(13, 'Sabá', '0205', 2, NULL, NULL, NULL, NULL),
(14, 'Santa Fe', '0206', 2, NULL, NULL, NULL, NULL),
(15, 'Santa Rosa de Aguán', '0207', 2, NULL, NULL, NULL, NULL),
(16, 'Sonaguera', '0208', 2, NULL, NULL, NULL, NULL),
(17, 'Tocoa', '0209', 2, NULL, NULL, NULL, NULL),
(18, 'Bonito Oriental', '0210', 2, NULL, NULL, NULL, NULL),
(23, 'Humuya ', '0305', 3, NULL, NULL, NULL, NULL),
(24, 'La Libertad', '0306', 3, NULL, NULL, NULL, NULL),
(25, 'Lamaní', '0307', 3, NULL, NULL, NULL, NULL),
(26, 'La Trinidad', '0308', 3, NULL, NULL, NULL, NULL),
(27, 'Lejamaní', '0309', 3, NULL, NULL, NULL, NULL),
(28, 'Meámbar', '0310', 3, NULL, NULL, NULL, NULL),
(29, 'Minas de Oro', '0311', 3, NULL, NULL, NULL, NULL),
(30, 'Ojos de Agua', '0312', 3, NULL, NULL, NULL, NULL),
(31, 'Ojos de Agua 0312', '0313', 3, NULL, NULL, NULL, NULL),
(32, 'San José de Comayagua', '0314', 3, NULL, NULL, NULL, NULL),
(33, 'San José del Potrero', '0315', 3, NULL, NULL, NULL, NULL),
(34, 'San Luis', '0316', 3, NULL, NULL, NULL, NULL),
(35, 'San Sebastián', '0317', 3, NULL, NULL, NULL, NULL),
(36, 'Siguatepeque', '0318', 3, NULL, NULL, NULL, NULL),
(37, 'Villa de San Antonio', '0319', 3, NULL, NULL, NULL, NULL),
(38, 'Las Lajas', '0320', 3, NULL, NULL, NULL, NULL),
(39, 'Taulabé', '0321', 3, NULL, NULL, NULL, NULL),
(40, 'Santa Rosa de Copán', '0401', 4, NULL, NULL, NULL, NULL),
(41, 'Cabañas', '0402', 4, NULL, NULL, NULL, NULL),
(42, 'Concepción', '0403', 4, NULL, NULL, NULL, NULL),
(43, 'Copán Ruinas', '0404', 4, NULL, NULL, NULL, NULL),
(44, 'corquin', '0405', 4, NULL, NULL, '2021-03-18 07:32:01', 'gr'),
(45, 'Cucuyagua', '0406', 4, NULL, NULL, NULL, NULL),
(46, 'Dolores', '0407', 4, NULL, NULL, NULL, NULL),
(47, 'Dulce Nombre', '0408', 4, NULL, NULL, NULL, NULL),
(48, 'El Paraíso', '0409', 4, NULL, NULL, NULL, NULL),
(49, 'Florida', '0410', 4, NULL, NULL, NULL, NULL),
(50, 'La Jigua', '0411', 4, NULL, NULL, NULL, NULL),
(51, 'La Unión', '0412', 4, NULL, NULL, NULL, NULL),
(52, 'Nueva Arcadia', '0413', 4, NULL, NULL, NULL, NULL),
(53, 'San Agustín', '0414', 4, NULL, NULL, NULL, NULL),
(54, 'San Antonio ', '0415', 4, NULL, NULL, NULL, NULL),
(55, 'San Jerónimo', '0416', 4, NULL, NULL, NULL, NULL),
(56, 'San José', '0417', 4, NULL, NULL, NULL, NULL),
(57, 'San Juan de Opoa', '0418', 4, NULL, NULL, NULL, NULL),
(58, 'San Nicolás', '0419', 4, NULL, NULL, NULL, NULL),
(59, 'San Pedro', '0420', 4, NULL, NULL, NULL, NULL),
(60, 'Santa Rita ', '0421', 4, NULL, NULL, NULL, NULL),
(61, 'Trinidad de Copán', '0422', 4, NULL, NULL, NULL, NULL),
(62, 'Veracruz', '0423', 4, NULL, NULL, NULL, NULL),
(63, 'San Pedro Sula', '0501', 5, NULL, NULL, NULL, NULL),
(64, 'Choloma', '0502', 5, NULL, NULL, NULL, NULL),
(65, 'Omoa', '0503', 5, NULL, NULL, NULL, NULL),
(66, 'Pimienta', '0504', 5, NULL, NULL, NULL, NULL),
(67, 'Potrerillos', '0505', 5, NULL, NULL, NULL, NULL),
(68, 'Puerto Cortés', '0506', 5, NULL, NULL, NULL, NULL),
(69, 'San Antonio de Cortés', '0507', 5, NULL, NULL, NULL, NULL),
(70, 'San Francisco de Yojoa', '0508', 5, NULL, NULL, NULL, NULL),
(71, 'San Manuel', '0509', 5, NULL, NULL, NULL, NULL),
(72, 'Santa Cruz de Yojoa', '0510', 5, NULL, NULL, NULL, NULL),
(73, 'Villanueva', '0511', 5, NULL, NULL, NULL, NULL),
(74, 'La Lima', '0512', 5, NULL, NULL, NULL, NULL),
(75, 'Choluteca', '0601', 6, NULL, NULL, NULL, NULL),
(76, 'Apacilagua', '0602', 6, NULL, NULL, NULL, NULL),
(77, 'Concepción de María', '0603', 6, NULL, NULL, NULL, NULL),
(78, 'Duyure', '0604', 6, NULL, NULL, NULL, NULL),
(79, 'El Corpus', '0605', 6, NULL, NULL, NULL, NULL),
(80, 'El Triunfo', '0606', 6, NULL, NULL, NULL, NULL),
(81, 'Marcovia', '0607', 6, NULL, NULL, NULL, NULL),
(82, 'Morolica', '0608', 6, NULL, NULL, NULL, NULL),
(83, 'Namasigüe', '0609', 6, NULL, NULL, NULL, NULL),
(84, 'Orocuina', '0610', 6, NULL, NULL, NULL, NULL),
(85, 'Pespire', '0611', 6, NULL, NULL, NULL, NULL),
(86, 'San Antonio de Flores', '0612', 6, NULL, NULL, NULL, NULL),
(87, 'San Isidro', '0613', 6, NULL, NULL, NULL, NULL),
(88, 'San José', '0614', 6, NULL, NULL, NULL, NULL),
(89, 'San Marcos de Colón', '0615', 6, NULL, NULL, NULL, NULL),
(90, 'Santa Ana de Yusguare', '0616', 6, NULL, NULL, NULL, NULL),
(91, 'Yuscarán', '0701', 7, NULL, NULL, NULL, NULL),
(92, 'Alauca', '0702', 7, NULL, NULL, NULL, NULL),
(93, 'Danlí', '0703', 7, NULL, NULL, NULL, NULL),
(94, 'El Paraíso', '0704', 7, NULL, NULL, NULL, NULL),
(95, 'Güinope', '0705', 7, NULL, NULL, NULL, NULL),
(96, 'Jacaleapa', '0706', 7, NULL, NULL, NULL, NULL),
(97, 'Liure', '0707', 7, NULL, NULL, NULL, NULL),
(98, 'Morocelí', '0708', 7, NULL, NULL, NULL, NULL),
(99, 'Oropolí', '0709', 7, NULL, NULL, NULL, NULL),
(100, 'Potrerillos', '0710', 7, NULL, NULL, NULL, NULL),
(101, 'San Antonio de Flores', '0711', 7, NULL, NULL, NULL, NULL),
(102, 'San Lucas', '0712', 7, NULL, NULL, NULL, NULL),
(103, 'San Matías', '0713', 7, NULL, NULL, NULL, NULL),
(104, 'Soledad', '0714', 7, NULL, NULL, NULL, NULL),
(105, 'Teupasenti ', '0715', 7, NULL, NULL, NULL, NULL),
(106, 'Texiguat', '0716', 7, NULL, NULL, NULL, NULL),
(107, 'Vado Ancho', '0717', 7, NULL, NULL, NULL, NULL),
(108, 'Yauyupe ', '0718', 7, NULL, NULL, NULL, NULL),
(109, 'Trojes', '0719', 7, NULL, NULL, NULL, NULL),
(110, 'Distrito Central', '0801', 8, NULL, NULL, NULL, NULL),
(111, 'Alubarén', '0802', 8, NULL, NULL, NULL, NULL),
(112, 'Cedros', '0803', 8, NULL, NULL, NULL, NULL),
(113, 'Curarén', '0804', 8, NULL, NULL, NULL, NULL),
(114, 'El Porvenir', '0805', 8, NULL, NULL, NULL, NULL),
(115, 'Guaimaca', '0806', 8, NULL, NULL, NULL, NULL),
(116, 'La Libertad', '0807', 8, NULL, NULL, NULL, NULL),
(117, 'La Venta ', '0808', 8, NULL, NULL, NULL, NULL),
(118, 'Lepaterique ', '0809', 8, NULL, NULL, NULL, NULL),
(119, 'Maraita', '0810', 8, NULL, NULL, NULL, NULL),
(120, 'Marale', '0811', 8, NULL, NULL, NULL, NULL),
(121, 'Nueva Armenia', '0812', 8, NULL, NULL, NULL, NULL),
(122, 'Ojojona ', '0813', 8, NULL, NULL, NULL, NULL),
(123, 'Orica', '0814', 8, NULL, NULL, NULL, NULL),
(124, 'Reitoca', '0815', 8, NULL, NULL, NULL, NULL),
(125, 'Sabanagrande', '0816', 8, NULL, NULL, NULL, NULL),
(126, 'San Antonio de Oriente', '0817', 8, NULL, NULL, NULL, NULL),
(127, 'San Buenaventura', '0818', 8, NULL, NULL, NULL, NULL),
(128, 'San Ignacio ', '0819', 8, NULL, NULL, NULL, NULL),
(129, 'San Juan de Flores o Cantarranas', '0820', 8, NULL, NULL, NULL, NULL),
(130, 'San Miguelito', '0821', 8, NULL, NULL, NULL, NULL),
(131, 'Santa Ana', '0822', 8, NULL, NULL, NULL, NULL),
(132, 'Santa Lucía', '0823', 8, NULL, NULL, NULL, NULL),
(133, 'Talanga', '0824', 8, NULL, NULL, NULL, NULL),
(134, 'Tatumbla ', '0825', 8, NULL, NULL, NULL, NULL),
(135, 'Valle de Ángeles', '0826', 8, NULL, NULL, NULL, NULL),
(136, 'Villa de San Francisco', '0827', 8, NULL, NULL, NULL, NULL),
(137, 'Vallecillo', '0828', 8, NULL, NULL, NULL, NULL),
(138, 'Puerto Lempira', '0901', 9, NULL, NULL, NULL, NULL),
(139, 'Brus Laguna', '0902', 9, NULL, NULL, NULL, NULL),
(140, 'Ahuas', '0903', 9, NULL, NULL, NULL, NULL),
(141, 'Juan Francisco Bulnes', '0904', 9, NULL, NULL, NULL, NULL),
(142, 'Ramón Villeda Morales', '0905', 9, NULL, NULL, NULL, NULL),
(143, 'Wampusirpe ', '0906', 9, NULL, NULL, NULL, NULL),
(144, 'La Esperanza', '1001', 10, NULL, NULL, NULL, NULL),
(145, 'Camasca', '1002', 10, NULL, NULL, NULL, NULL),
(146, 'Colomoncagua', '1003', 10, NULL, NULL, NULL, NULL),
(147, 'Concepción', '1004', 10, NULL, NULL, NULL, NULL),
(148, 'Dolores', '1005', 10, NULL, NULL, NULL, NULL),
(149, 'Intibucá', '1006', 10, NULL, NULL, NULL, NULL),
(150, 'Jesús de Otoro', '1007', 10, NULL, NULL, NULL, NULL),
(151, 'Magdalena', '1008', 10, NULL, NULL, NULL, NULL),
(152, 'Masaguara', '1009', 10, NULL, NULL, NULL, NULL),
(153, 'San Antonio', '1010', 10, NULL, NULL, NULL, NULL),
(154, 'San Isidro', '1011', 10, NULL, NULL, NULL, NULL),
(155, 'San Juan', '1012', 10, NULL, NULL, NULL, NULL),
(156, 'San Marcos de la Sierra', '1013', 10, NULL, NULL, NULL, NULL),
(157, 'San Miguel Guancapla', '1014', 10, NULL, NULL, NULL, NULL),
(158, 'Santa Lucía', '1015', 10, NULL, NULL, NULL, NULL),
(159, 'Yamaranguila', '1016', 10, NULL, NULL, NULL, NULL),
(160, 'San Francisco de Opalaca', '1017', 10, NULL, NULL, NULL, NULL),
(161, 'Roatán', '1101', 11, NULL, NULL, NULL, NULL),
(162, 'Guanaja', '1102', 11, NULL, NULL, NULL, NULL),
(163, 'José Santos Guardiola', '1103', 11, NULL, NULL, NULL, NULL),
(164, 'Utila', '1104', 11, NULL, NULL, NULL, NULL),
(165, 'La Paz', '1201', 12, NULL, NULL, NULL, NULL),
(166, 'AGUANQUETERIQUE', '1202', 12, NULL, NULL, '2021-03-18 07:57:18', 'ADMIN'),
(167, 'Cabañas', '1203', 12, NULL, NULL, NULL, NULL),
(168, 'Cane', '1204', 12, NULL, NULL, NULL, NULL),
(169, 'Chinacla', '1205', 12, NULL, NULL, NULL, NULL),
(170, 'Guajiquiro', '1206', 12, NULL, NULL, NULL, NULL),
(171, 'Lauterique', '1207', 12, NULL, NULL, NULL, NULL),
(172, 'Marcala', '1208', 12, NULL, NULL, NULL, NULL),
(173, 'Mercedes de Oriente', '1209', 12, NULL, NULL, NULL, NULL),
(174, 'Opatoro', '1210', 12, NULL, NULL, NULL, NULL),
(175, 'San Antonio del Norte', '1211', 12, NULL, NULL, NULL, NULL),
(176, 'San José', '1212', 12, NULL, NULL, NULL, NULL),
(177, 'San Juan', '1213', 12, NULL, NULL, NULL, NULL),
(178, 'San Pedro de Tutule', '1214', 12, NULL, NULL, NULL, NULL),
(179, 'Santa Ana', '1215', 12, NULL, NULL, NULL, NULL),
(180, 'Santa Elena', '1216', 12, NULL, NULL, NULL, NULL),
(181, 'Santa María ', '1217', 12, NULL, NULL, NULL, NULL),
(182, 'Santiago de Puringla', '1218', 12, NULL, NULL, NULL, NULL),
(183, 'Yarula', '1219', 12, NULL, NULL, NULL, NULL),
(184, 'Gracias ', '1301', 13, NULL, NULL, NULL, NULL),
(185, 'Belén', '1302', 13, NULL, NULL, NULL, NULL),
(186, 'Candelaria', '1303', 13, NULL, NULL, NULL, NULL),
(187, 'Cololaca', '1304', 13, NULL, NULL, NULL, NULL),
(188, 'Erandique', '1305', 13, NULL, NULL, NULL, NULL),
(189, 'Gualcince ', '1306', 13, NULL, NULL, NULL, NULL),
(190, 'Guarita', '1307', 13, NULL, NULL, NULL, NULL),
(191, 'La Campa ', '1308', 13, NULL, NULL, NULL, NULL),
(192, 'La Iguala', '1309', 13, NULL, NULL, NULL, NULL),
(193, 'Las Flores', '1310', 13, NULL, NULL, NULL, NULL),
(194, 'La Unión ', '1311', 13, NULL, NULL, NULL, NULL),
(195, 'La Virtud', '1312', 13, NULL, NULL, NULL, NULL),
(196, 'Lepaera', '1313', 13, NULL, NULL, NULL, NULL),
(197, 'Mapulaca', '1314', 13, NULL, NULL, NULL, NULL),
(198, 'Piraera', '1315', 13, NULL, NULL, NULL, NULL),
(199, 'San Andrés', '1316', 13, NULL, NULL, NULL, NULL),
(200, 'San Francisco', '1317', 13, NULL, NULL, NULL, NULL),
(201, 'San Juan Guarita', '1318', 13, NULL, NULL, NULL, NULL),
(202, 'San Manuel Colohete', '1319', 13, NULL, NULL, NULL, NULL),
(203, 'San Rafael', '1320', 13, NULL, NULL, NULL, NULL),
(204, 'San Sebastián ', '1321', 13, NULL, NULL, NULL, NULL),
(205, 'Santa Cruz', '1322', 13, NULL, NULL, NULL, NULL),
(206, 'Talgua', '1323', 13, NULL, NULL, NULL, NULL),
(207, 'Tambla', '1324', 13, NULL, NULL, NULL, NULL),
(208, 'Tomalá', '1325', 13, NULL, NULL, NULL, NULL),
(209, 'Valladolid ', '1326', 13, NULL, NULL, NULL, NULL),
(210, 'Virginia ', '1327', 13, NULL, NULL, NULL, NULL),
(211, 'San Marcos de Caiquín', '1328', 13, NULL, NULL, NULL, NULL),
(212, 'Nueva Ocotepeque', '1401', 14, NULL, NULL, NULL, NULL),
(213, 'Belén Gualcho', '1402', 14, NULL, NULL, NULL, NULL),
(214, 'Concepción', '1403', 14, NULL, NULL, NULL, NULL),
(215, 'Dolores Merendón', '1404', 14, NULL, NULL, NULL, NULL),
(216, 'Fraternidad', '1405', 14, NULL, NULL, NULL, NULL),
(217, 'La Encarnación', '1406', 14, NULL, NULL, NULL, NULL),
(218, 'La Labor', '1407', 14, NULL, NULL, NULL, NULL),
(219, 'Lucerna', '1408', 14, NULL, NULL, NULL, NULL),
(220, 'Mercedes ', '1409', 14, NULL, NULL, NULL, NULL),
(221, 'San Fernando', '1410', 14, NULL, NULL, NULL, NULL),
(222, 'San Francisco del Valle', '1411', 14, NULL, NULL, NULL, NULL),
(223, 'San Jorge', '1412', 14, NULL, NULL, NULL, NULL),
(224, 'San Marcos', '1413', 14, NULL, NULL, NULL, NULL),
(225, 'Santa Fe', '1414', 14, NULL, NULL, NULL, NULL),
(226, 'Sensenti', '1415', 14, NULL, NULL, NULL, NULL),
(227, 'Sinuapa', '1416', 14, NULL, NULL, NULL, NULL),
(228, 'Juticalpa ', '1501', 15, NULL, NULL, NULL, NULL),
(229, 'Campamento', '1502', 15, NULL, NULL, NULL, NULL),
(230, 'Catacamas', '1503', 15, NULL, NULL, NULL, NULL),
(231, 'Concordia', '1504', 15, NULL, NULL, NULL, NULL),
(232, 'Dulce Nombre de Culmí', '1505', 15, NULL, NULL, NULL, NULL),
(233, 'El Rosario', '1506', 15, NULL, NULL, NULL, NULL),
(234, 'Esquipulas del Norte', '1507', 15, NULL, NULL, NULL, NULL),
(235, 'Gualaco', '1508', 15, NULL, NULL, NULL, NULL),
(236, 'Guarizama', '1509', 15, NULL, NULL, NULL, NULL),
(237, 'Guata', '1510', 15, NULL, NULL, NULL, NULL),
(238, 'Guayape', '1511', 15, NULL, NULL, NULL, NULL),
(239, 'Jano', '1512', 15, NULL, NULL, NULL, NULL),
(240, 'La Unión ', '1513', 15, NULL, NULL, NULL, NULL),
(241, 'Mangulile ', '1514', 15, NULL, NULL, NULL, NULL),
(242, 'Manto', '1515', 15, NULL, NULL, NULL, NULL),
(243, 'Salamá ', '1516', 15, NULL, NULL, NULL, NULL),
(244, 'San Esteban', '1517', 15, NULL, NULL, NULL, NULL),
(245, 'San Francisco de Becerra', '1518', 15, NULL, NULL, NULL, NULL),
(246, 'San Francisco de la Paz', '1519', 15, NULL, NULL, NULL, NULL),
(247, 'Santa María del Real', '1520', 15, NULL, NULL, NULL, NULL),
(248, 'Silca', '1521', 15, NULL, NULL, NULL, NULL),
(249, 'Yocón', '1522', 15, NULL, NULL, NULL, NULL),
(250, 'Patuca', '1523', 15, NULL, NULL, NULL, NULL),
(251, 'Santa Bárbara ', '1601', 16, NULL, NULL, NULL, NULL),
(252, 'Arada', '1602', 16, NULL, NULL, NULL, NULL),
(253, 'Atima', '1603', 16, NULL, NULL, NULL, NULL),
(254, 'Azacualpa', '1604', 16, NULL, NULL, NULL, NULL),
(255, 'Ceguaca', '1605', 16, NULL, NULL, NULL, NULL),
(256, 'San José de las Colinas', '1606', 16, NULL, NULL, NULL, NULL),
(257, 'Concepción del Norte', '1607', 16, NULL, NULL, NULL, NULL),
(258, 'Concepción del Sur', '1608', 16, NULL, NULL, NULL, NULL),
(259, 'Chinda', '1609', 16, NULL, NULL, NULL, NULL),
(260, 'El Níspero', '1610', 16, NULL, NULL, NULL, NULL),
(261, 'Gualala ', '1611', 16, NULL, NULL, NULL, NULL),
(262, 'Ilama', '1612', 16, NULL, NULL, NULL, NULL),
(263, 'Macuelizo ', '1613', 16, NULL, NULL, NULL, NULL),
(264, 'Naranjito', '1614', 16, NULL, NULL, NULL, NULL),
(265, 'Nuevo Celilac', '1615', 16, NULL, NULL, NULL, NULL),
(266, 'Petoa', '1616', 16, NULL, NULL, NULL, NULL),
(267, 'Protección', '1617', 16, NULL, NULL, NULL, NULL),
(268, 'Quimistán', '1618', 16, NULL, NULL, NULL, NULL),
(269, 'San Francisco de Ojuera', '1619', 16, NULL, NULL, NULL, NULL),
(270, 'San Luis', '1620', 16, NULL, NULL, NULL, NULL),
(271, 'San Marcos', '1621', 16, NULL, NULL, NULL, NULL),
(272, 'San Nicolás', '1622', 16, NULL, NULL, NULL, NULL),
(273, 'San Pedro Zacapa', '1623', 16, NULL, NULL, NULL, NULL),
(274, 'Santa Rita ', '1624', 16, NULL, NULL, NULL, NULL),
(275, 'San Vicente Centenario', '1625', 16, NULL, NULL, NULL, NULL),
(276, 'Trinidad', '1626', 16, NULL, NULL, NULL, NULL),
(277, 'Las Vegas', '1627', 16, NULL, NULL, NULL, NULL),
(278, 'Nueva Frontera', '1628', 16, NULL, NULL, NULL, NULL),
(279, 'Alianza', '1702', 17, NULL, NULL, NULL, NULL),
(280, 'Amapala', '1703', 17, NULL, NULL, NULL, NULL),
(281, 'Aramecina', '1704', 17, NULL, NULL, NULL, NULL),
(282, 'Caridad ', '1705', 17, NULL, NULL, NULL, NULL),
(283, 'Goascorán', '1706', 17, NULL, NULL, NULL, NULL),
(284, 'Langue', '1707', 17, NULL, NULL, NULL, NULL),
(285, 'Nacaome', '1701', 17, NULL, NULL, NULL, NULL),
(286, 'San Francisco de Coray', '1708', 17, NULL, NULL, NULL, NULL),
(287, 'San Lorenzo', '1709', 17, NULL, NULL, NULL, NULL),
(288, 'Yoro', '1801', 18, NULL, NULL, NULL, NULL),
(289, 'Arenal', '1802', 18, NULL, NULL, NULL, NULL),
(290, 'El Negrito ', '1803', 18, NULL, NULL, NULL, NULL),
(291, 'EL PROGRESO', '1804', 18, NULL, NULL, '2021-03-18 07:16:19', 'ADMIN'),
(292, 'Jocón ', '1805', 18, NULL, NULL, NULL, NULL),
(293, 'Morazán', '1806', 18, NULL, NULL, NULL, NULL),
(294, 'Olanchito', '1807', 18, NULL, NULL, NULL, NULL),
(295, 'Santa Rita ', '1808', 18, NULL, NULL, NULL, NULL),
(296, 'Sulaco', '1809', 18, NULL, NULL, NULL, NULL),
(297, 'Victoria ', '1810', 18, NULL, NULL, NULL, NULL),
(298, 'Yorito', '1811', 18, NULL, NULL, NULL, NULL),
(307, 'EXA', '0012', 5, '2021-04-06 03:24:20', 'ADMIN', NULL, NULL),
(309, 'ZEDE ', '1811', 7, '2021-04-13 04:57:35', 'ADMIN', '2021-04-16 19:52:47', 'ADMIN'),
(310, 'Jutiapa', '4', 1, '2021-05-31 14:56:05', 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_nacionalidad`
--

CREATE TABLE `tbl_nacionalidad` (
  `id_nacionalidad` int(11) NOT NULL,
  `PAIS_NAC` varchar(50) NOT NULL DEFAULT '0',
  `nacionalidad` varchar(50) DEFAULT NULL,
  `ISO_NAC` varchar(50) DEFAULT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_nacionalidad`
--

INSERT INTO `tbl_nacionalidad` (`id_nacionalidad`, `PAIS_NAC`, `nacionalidad`, `ISO_NAC`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'Afganistán', 'AFGANA', 'AFG', NULL, NULL, NULL, NULL),
(2, 'Albania', 'ALBANESA', 'ALB', NULL, NULL, NULL, NULL),
(3, 'Alemania', 'ALEMANA', 'DEU', NULL, NULL, NULL, NULL),
(4, 'Andorra', 'ANDORRANA', 'AND', NULL, NULL, NULL, NULL),
(5, 'Angola', 'ANGOLEÑA', 'AGO', NULL, NULL, NULL, NULL),
(6, 'AntiguayBarbuda', 'ANTIGUANA', 'ATG', NULL, NULL, NULL, NULL),
(7, 'ArabiaSaudita', 'SAUDÍ', 'SAU', NULL, NULL, NULL, NULL),
(8, 'Argelia', 'ARGELINA', 'DZA', NULL, NULL, NULL, NULL),
(9, 'Argentina', 'ARGENTINA', 'ARG', NULL, NULL, NULL, NULL),
(10, 'Armenia', 'ARMENIA', 'ARM', NULL, NULL, NULL, NULL),
(11, 'Aruba', 'ARUBEÑA', 'ABW', NULL, NULL, NULL, NULL),
(12, 'Australia', 'AUSTRALIANA', 'AUS', NULL, NULL, NULL, NULL),
(13, 'Austria', 'AUSTRIACA', 'AUT', NULL, NULL, NULL, NULL),
(14, 'Azerbaiyán', 'AZERBAIYANA', 'AZE', NULL, NULL, NULL, NULL),
(15, 'Bahamas', 'BAHAMEÑA', 'BHS', NULL, NULL, NULL, NULL),
(16, 'Bangladés', 'BANGLADESÍ', 'BGD', NULL, NULL, NULL, NULL),
(17, 'Barbados', 'BARBADENSE', 'BRB', NULL, NULL, NULL, NULL),
(18, 'Baréin', 'BAREINÍ', 'BHR', NULL, NULL, NULL, NULL),
(19, 'Bélgica', 'BELGA', 'BEL', NULL, NULL, NULL, NULL),
(20, 'Belice', 'BELICEÑA', 'BLZ', NULL, NULL, NULL, NULL),
(21, 'Benín', 'BENINÉSA', 'BEN', NULL, NULL, NULL, NULL),
(22, 'Bielorrusia', 'BIELORRUSA', 'BLR', NULL, NULL, NULL, NULL),
(23, 'Birmania', 'BIRMANA', 'MMR', NULL, NULL, NULL, NULL),
(24, 'Bolivia', 'BOLIVIANA', 'BOL', NULL, NULL, NULL, NULL),
(25, 'BosniayHerzegovina', 'BOSNIA', 'BIH', NULL, NULL, NULL, NULL),
(26, 'Botsuana', 'BOTSUANA', 'BWA', NULL, NULL, NULL, NULL),
(27, 'Brasil', 'BRASILEÑA', 'BRA', NULL, NULL, NULL, NULL),
(28, 'Brunéi', 'BRUNEANA', 'BRN', NULL, NULL, NULL, NULL),
(29, 'Bulgaria', 'BÚLGARA', 'BGR', NULL, NULL, NULL, NULL),
(30, 'BurkinaFaso', 'BURKINÉS', 'BFA', NULL, NULL, NULL, NULL),
(31, 'Burundi', 'BURUNDÉSA', 'BDI', NULL, NULL, NULL, NULL),
(32, 'Bután', 'BUTANÉSA', 'BTN', NULL, NULL, NULL, NULL),
(33, 'CaboVerde', 'CABOVERDIANA', 'CPV', NULL, NULL, NULL, NULL),
(34, 'Camboya', 'CAMBOYANA', 'KHM', NULL, NULL, NULL, NULL),
(35, 'Camerún', 'CAMERUNESA', 'CMR', NULL, NULL, NULL, NULL),
(36, 'Canadá', 'CANADIENSE', 'CAN', NULL, NULL, NULL, NULL),
(37, 'Catar', 'CATARÍ', 'QAT', NULL, NULL, NULL, NULL),
(38, 'Chad', 'CHADIANA', 'TCD', NULL, NULL, NULL, NULL),
(39, 'Chile', 'CHILENA', 'CHL', NULL, NULL, NULL, NULL),
(40, 'China', 'CHINA', 'CHN', NULL, NULL, NULL, NULL),
(41, 'Chipre', 'CHIPRIOTA', 'CYP', NULL, NULL, NULL, NULL),
(42, 'CiudaddelVaticano', 'VATICANA', 'VAT', NULL, NULL, NULL, NULL),
(43, 'Colombia', 'COLOMBIANA', 'COL', NULL, NULL, NULL, NULL),
(44, 'Comoras', 'COMORENSE', 'COM', NULL, NULL, NULL, NULL),
(45, 'CoreadelNorte', 'NORCOREANA', 'PRK', NULL, NULL, NULL, NULL),
(46, 'CoreadelSur', 'SURCOREANA', 'KOR', NULL, NULL, NULL, NULL),
(47, 'CostadeMarfil', 'MARFILEÑA', 'CIV', NULL, NULL, NULL, NULL),
(48, 'CostaRica', 'COSTARRICENSE', 'CRI', NULL, NULL, NULL, NULL),
(49, 'Croacia', 'CROATA', 'HRV', NULL, NULL, NULL, NULL),
(50, 'Cuba', 'CUBANA', 'CUB', NULL, NULL, NULL, NULL),
(51, 'Dinamarca', 'DANÉSA', 'DNK', NULL, NULL, NULL, NULL),
(52, 'Dominica', 'DOMINIQUÉS', 'DMA', NULL, NULL, NULL, NULL),
(53, 'Ecuador', 'ECUATORIANA', 'ECU', NULL, NULL, NULL, NULL),
(54, 'Egipto', 'EGIPCIA', 'EGY', NULL, NULL, NULL, NULL),
(55, 'ElSalvador', 'SALVADOREÑA', 'SLV', NULL, NULL, NULL, NULL),
(56, 'EmiratosÁrabesUnidos', 'EMIRATÍ', 'ARE', NULL, NULL, NULL, NULL),
(57, 'Eritrea', 'ERITREA', 'ERI', NULL, NULL, NULL, NULL),
(58, 'Eslovaquia', 'ESLOVACA', 'SVK', NULL, NULL, NULL, NULL),
(59, 'Eslovenia', 'ESLOVENA', 'SVN', NULL, NULL, NULL, NULL),
(60, 'España', 'ESPAÑOLA', 'ESP', NULL, NULL, NULL, NULL),
(61, 'EstadosUnidos', 'ESTADOUNIDENSE', 'USA', NULL, NULL, NULL, NULL),
(62, 'Estonia', 'ESTONIA', 'EST', NULL, NULL, NULL, NULL),
(63, 'Etiopía', 'ETÍOPE', 'ETH', NULL, NULL, NULL, NULL),
(64, 'Filipinas', 'FILIPINA', 'PHL', NULL, NULL, NULL, NULL),
(65, 'Finlandia', 'FINLANDÉSA', 'FIN', NULL, NULL, NULL, NULL),
(66, 'Fiyi', 'FIYIANA', 'FJI', NULL, NULL, NULL, NULL),
(67, 'Francia', 'FRANCÉSA', 'FRA', NULL, NULL, NULL, NULL),
(68, 'Gabón', 'GABONÉSA', 'GAB', NULL, NULL, NULL, NULL),
(69, 'Gambia', 'GAMBIANA', 'GMB', NULL, NULL, NULL, NULL),
(70, 'Georgia', 'GEORGIANA', 'GEO', NULL, NULL, NULL, NULL),
(71, 'Gibraltar', 'GIBRALTAREÑA', 'GIB', NULL, NULL, NULL, NULL),
(72, 'Ghana', 'GHANÉSA', 'GHA', NULL, NULL, NULL, NULL),
(73, 'Granada', 'GRANADINA', 'GRD', NULL, NULL, NULL, NULL),
(74, 'Grecia', 'GRIEGA', 'GRC', NULL, NULL, NULL, NULL),
(75, 'Groenlandia', 'GROENLANDÉSA', 'GRL', NULL, NULL, NULL, NULL),
(76, 'Guatemala', 'GUATEMALTECA', 'GTM', NULL, NULL, NULL, NULL),
(77, 'Guineaecuatorial', 'ECUATOGUINEANA', 'GNQ', NULL, NULL, NULL, NULL),
(78, 'Guinea', 'GUINEANA', 'GIN', NULL, NULL, NULL, NULL),
(79, 'Guinea-Bisáu', 'GUINEANA', 'GNB', NULL, NULL, NULL, NULL),
(80, 'Guyana', 'GUYANESA', 'GUY', NULL, NULL, NULL, NULL),
(81, 'Haití', 'HAITIANA', 'HTI', NULL, NULL, NULL, NULL),
(82, 'Honduras', 'HONDUREÑA', 'HND', NULL, NULL, NULL, NULL),
(83, 'Hungría', 'HÚNGARA', 'HUN', NULL, NULL, NULL, NULL),
(84, 'India', 'HINDÚ', 'IND', NULL, NULL, NULL, NULL),
(85, 'Indonesia', 'INDONESIA', 'IDN', NULL, NULL, NULL, NULL),
(86, 'Irak', 'IRAQUÍ', 'IRQ', NULL, NULL, NULL, NULL),
(87, 'Irán', 'IRANÍ', 'IRN', NULL, NULL, NULL, NULL),
(88, 'Irlanda', 'IRLANDÉSA', 'IRL', NULL, NULL, NULL, NULL),
(89, 'Islandia', 'ISLANDÉSA', 'ISL', NULL, NULL, NULL, NULL),
(90, 'IslasCook', 'COOKIANA', 'COK', NULL, NULL, NULL, NULL),
(91, 'IslasMarshall', 'MARSHALÉSA', 'MHL', NULL, NULL, NULL, NULL),
(92, 'IslasSalomón', 'SALOMONENSE', 'SLB', NULL, NULL, NULL, NULL),
(93, 'Israel', 'ISRAELÍ', 'ISR', NULL, NULL, NULL, NULL),
(94, 'Italia', 'ITALIANA', 'ITA', NULL, NULL, NULL, NULL),
(95, 'Jamaica', 'JAMAIQUINA', 'JAM', NULL, NULL, NULL, NULL),
(96, 'Japón', 'JAPONÉSA', 'JPN', NULL, NULL, NULL, NULL),
(97, 'Jordania', 'JORDANA', 'JOR', NULL, NULL, NULL, NULL),
(98, 'Kazajistán', 'KAZAJA', 'KAZ', NULL, NULL, NULL, NULL),
(99, 'Kenia', 'KENIATA', 'KEN', NULL, NULL, NULL, NULL),
(100, 'Kirguistán', 'KIRGUISA', 'KGZ', NULL, NULL, NULL, NULL),
(101, 'Kiribati', 'KIRIBATIANA', 'KIR', NULL, NULL, NULL, NULL),
(102, 'Kuwait', 'KUWAITÍ', 'KWT', NULL, NULL, NULL, NULL),
(103, 'Laos', 'LAOSIANA', 'LAO', NULL, NULL, NULL, NULL),
(104, 'Lesoto', 'LESOTENSE', 'LSO', NULL, NULL, NULL, NULL),
(105, 'Letonia', 'LETÓNA', 'LVA', NULL, NULL, NULL, NULL),
(106, 'Líbano', 'LIBANÉSA', 'LBN', NULL, NULL, NULL, NULL),
(107, 'Liberia', 'LIBERIANA', 'LBR', NULL, NULL, NULL, NULL),
(108, 'Libia', 'LIBIA', 'LBY', NULL, NULL, NULL, NULL),
(109, 'Liechtenstein', 'LIECHTENSTEINIANA', 'LIE', NULL, NULL, NULL, NULL),
(110, 'Lituania', 'LITUANA', 'LTU', NULL, NULL, NULL, NULL),
(111, 'Luxemburgo', 'LUXEMBURGUÉSA', 'LUX', NULL, NULL, NULL, NULL),
(112, 'Madagascar', 'MALGACHE', 'MDG', NULL, NULL, NULL, NULL),
(113, 'Malasia', 'MALASIA', 'MYS', NULL, NULL, NULL, NULL),
(114, 'Malaui', 'MALAUÍ', 'MWI', NULL, NULL, NULL, NULL),
(115, 'Maldivas', 'MALDIVA', 'MDV', NULL, NULL, NULL, NULL),
(116, 'Malí', 'MALIENSE', 'MLI', NULL, NULL, NULL, NULL),
(117, 'Malta', 'MALTÉSA', 'MLT', NULL, NULL, NULL, NULL),
(118, 'Marruecos', 'MARROQUÍ', 'MAR', NULL, NULL, NULL, NULL),
(119, 'Martinica', 'MARTINIQUÉS', 'MTQ', NULL, NULL, NULL, NULL),
(120, 'Mauricio', 'MAURICIANA', 'MUS', NULL, NULL, NULL, NULL),
(121, 'Mauritania', 'MAURITANA', 'MRT', NULL, NULL, NULL, NULL),
(122, 'México', 'MEXICANA', 'MEX', NULL, NULL, NULL, NULL),
(123, 'Micronesia', 'MICRONESIA', 'FSM', NULL, NULL, NULL, NULL),
(124, 'Moldavia', 'MOLDAVA', 'MDA', NULL, NULL, NULL, NULL),
(125, 'Mónaco', 'MONEGASCA', 'MCO', NULL, NULL, NULL, NULL),
(126, 'Mongolia', 'MONGOLA', 'MNG', NULL, NULL, NULL, NULL),
(127, 'Montenegro', 'MONTENEGRINA', 'MNE', NULL, NULL, NULL, NULL),
(128, 'Mozambique', 'MOZAMBIQUEÑA', 'MOZ', NULL, NULL, NULL, NULL),
(129, 'Namibia', 'NAMIBIA', 'NAM', NULL, NULL, NULL, NULL),
(130, 'Nauru', 'NAURUANA', 'NRU', NULL, NULL, NULL, NULL),
(131, 'Nepal', 'NEPALÍ', 'NPL', NULL, NULL, NULL, NULL),
(132, 'Nicaragua', 'NICARAGÜENSE', 'NIC', NULL, NULL, NULL, NULL),
(133, 'Níger', 'NIGERINA', 'NER', NULL, NULL, NULL, NULL),
(134, 'Nigeria', 'NIGERIANA', 'NGA', NULL, NULL, NULL, NULL),
(135, 'Noruega', 'NORUEGA', 'NOR', NULL, NULL, NULL, NULL),
(136, 'NuevaZelanda', 'NEOZELANDÉSA', 'NZL', NULL, NULL, NULL, NULL),
(137, 'Omán', 'OMANÍ', 'OMN', NULL, NULL, NULL, NULL),
(138, 'PaísesBajos', 'NEERLANDÉSA', 'NLD', NULL, NULL, NULL, NULL),
(139, 'Pakistán', 'PAKISTANÍ', 'PAK', NULL, NULL, NULL, NULL),
(140, 'Palaos', 'PALAUANA', 'PLW', NULL, NULL, NULL, NULL),
(141, 'Palestina', 'PALESTINA', 'PSE', NULL, NULL, NULL, NULL),
(142, 'Panamá', 'PANAMEÑA', 'PAN', NULL, NULL, NULL, NULL),
(143, 'PapúaNuevaGuinea', 'PAPÚ', 'PNG', NULL, NULL, NULL, NULL),
(144, 'Paraguay', 'PARAGUAYA', 'PRY', NULL, NULL, NULL, NULL),
(145, 'Perú', 'PERUANA', 'PER', NULL, NULL, NULL, NULL),
(146, 'Polonia', 'POLACA', 'POL', NULL, NULL, NULL, NULL),
(147, 'Portugal', 'PORTUGUÉSA', 'PRT', NULL, NULL, NULL, NULL),
(148, 'PuertoRico', 'PUERTORRIQUEÑA', 'PRI', NULL, NULL, NULL, NULL),
(149, 'ReinoUnido', 'BRITÁNICA', 'GBR', NULL, NULL, NULL, NULL),
(150, 'RepúblicaCentroafricana', 'CENTROAFRICANA', 'CAF', NULL, NULL, NULL, NULL),
(151, 'RepúblicaCheca', 'CHECA', 'CZE', NULL, NULL, NULL, NULL),
(152, 'RepúblicadeMacedonia', 'MACEDONIA', 'MKD', NULL, NULL, NULL, NULL),
(153, 'RepúblicadelCongo', 'CONGOLEÑA', 'COG', NULL, NULL, NULL, NULL),
(154, 'RepúblicaDemocráticadelCongo', 'CONGOLEÑA', 'COD', NULL, NULL, NULL, NULL),
(155, 'RepúblicaDominicana', 'DOMINICANA', 'DOM', NULL, NULL, NULL, NULL),
(156, 'RepúblicaSudafricana', 'SUDAFRICANA', 'ZAF', NULL, NULL, NULL, NULL),
(157, 'Ruanda', 'RUANDÉSA', 'RWA', NULL, NULL, NULL, NULL),
(158, 'Rumanía', 'RUMANA', 'ROU', NULL, NULL, NULL, NULL),
(159, 'Rusia', 'RUSA', 'RUS', NULL, NULL, NULL, NULL),
(160, 'Samoa', 'SAMOANA', 'WSM', NULL, NULL, NULL, NULL),
(161, 'SanCristóbalyNieves', 'CRISTOBALEÑA', 'KNA', NULL, NULL, NULL, NULL),
(162, 'SanMarino', 'SANMARINENSE', 'SMR', NULL, NULL, NULL, NULL),
(163, 'SanVicenteylasGranadinas', 'SANVICENTINA', 'VCT', NULL, NULL, NULL, NULL),
(164, 'SantaLucía', 'SANTALUCENSE', 'LCA', NULL, NULL, NULL, NULL),
(165, 'SantoToméyPríncipe', 'SANTOTOMENSE', 'STP', NULL, NULL, NULL, NULL),
(166, 'Senegal', 'SENEGALÉSA', 'SEN', NULL, NULL, NULL, NULL),
(167, 'Serbia', 'SERBIA', 'SRB', NULL, NULL, NULL, NULL),
(168, 'Seychelles', 'SEYCHELLENSE', 'SYC', NULL, NULL, NULL, NULL),
(169, 'SierraLeona', 'SIERRALEONÉSA', 'SLE', NULL, NULL, NULL, NULL),
(170, 'Singapur', 'SINGAPURENSE', 'SGP', NULL, NULL, NULL, NULL),
(171, 'Siria', 'SIRIA', 'SYR', NULL, NULL, NULL, NULL),
(172, 'Somalia', 'SOMALÍ', 'SOM', NULL, NULL, NULL, NULL),
(173, 'SriLanka', 'CEILANÉSA', 'LKA', NULL, NULL, NULL, NULL),
(174, 'Suazilandia', 'SUAZI', 'SWZ', NULL, NULL, NULL, NULL),
(175, 'SudándelSur', 'SURSUDANÉSA', 'SSD', NULL, NULL, NULL, NULL),
(176, 'Sudán', 'SUDANÉSA', 'SDN', NULL, NULL, NULL, NULL),
(177, 'Suecia', 'SUECA', 'SWE', NULL, NULL, NULL, NULL),
(178, 'Suiza', 'SUIZA', 'CHE', NULL, NULL, NULL, NULL),
(179, 'Surinam', 'SURINAMESA', 'SUR', NULL, NULL, NULL, NULL),
(180, 'Tailandia', 'TAILANDÉSA', 'THA', NULL, NULL, NULL, NULL),
(181, 'Tanzania', 'TANZANA', 'TZA', NULL, NULL, NULL, NULL),
(182, 'Tayikistán', 'TAYIKA', 'TJK', NULL, NULL, NULL, NULL),
(183, 'TimorOriental', 'TIMORENSE', 'TLS', NULL, NULL, NULL, NULL),
(184, 'Togo', 'TOGOLÉSA', 'TGO', NULL, NULL, NULL, NULL),
(185, 'Tonga', 'TONGANA', 'TON', NULL, NULL, NULL, NULL),
(186, 'TrinidadyTobago', 'TRINITENSE', 'TTO', NULL, NULL, NULL, NULL),
(187, 'Túnez', 'TUNECINA', 'TUN', NULL, NULL, NULL, NULL),
(188, 'Turkmenistán', 'TURCOMANA', 'TKM', NULL, NULL, NULL, NULL),
(189, 'Turquía', 'TURCA', 'TUR', NULL, NULL, NULL, NULL),
(190, 'Tuvalu', 'TUVALUANA', 'TUV', NULL, NULL, NULL, NULL),
(191, 'Ucrania', 'UCRANIANA', 'UKR', NULL, NULL, NULL, NULL),
(192, 'Uganda', 'UGANDÉSA', 'UGA', NULL, NULL, NULL, NULL),
(193, 'Uruguay', 'URUGUAYA', 'URY', NULL, NULL, NULL, NULL),
(194, 'Uzbekistán', 'UZBEKA', 'UZB', NULL, NULL, NULL, NULL),
(195, 'Vanuatu', 'VANUATUENSE', 'VUT', NULL, NULL, NULL, NULL),
(196, 'Venezuela', 'VENEZOLANA', 'VEN', NULL, NULL, NULL, NULL),
(197, 'Vietnam', 'VIETNAMITA', 'VNM', NULL, NULL, NULL, NULL),
(198, 'Yemen', 'YEMENÍ', 'YEM', NULL, NULL, NULL, NULL),
(199, 'Yibuti', 'YIBUTIANA', 'DJI', NULL, NULL, NULL, NULL),
(200, 'Zambia', 'ZAMBIANA', 'ZMB', NULL, NULL, NULL, NULL),
(201, 'Zimbabue', 'ZIMBABUENSE', 'ZWE', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_objetos`
--

CREATE TABLE `tbl_objetos` (
  `Id_objeto` bigint(16) NOT NULL,
  `objeto` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_objetos`
--

INSERT INTO `tbl_objetos` (`Id_objeto`, `objeto`, `descripcion`) VALUES
(1, 'Creación de preguntas ', 'Creacion de preguntas de seguridad'),
(2, 'Gestión de preguntas ', 'Gestionar las preguntas de seguridad'),
(3, 'Registro de usuario', 'Registrar los usuarios del sistema'),
(4, 'Gestión de usuario', 'Gestionar los usuarios'),
(5, 'Creación  de roles', 'Crear de roles'),
(6, 'Gestión de roles', 'Gestionar los roles'),
(7, 'Gestión de parámetros ', 'Gestionar los parámetros '),
(8, 'Bitácora ', 'Bitacora del sistema'),
(9, 'Creación de permisos a usuarios', 'Dar permisos a los roles de los usuarios'),
(10, 'Gestión de permisos a usuarios', 'Gestionar permisos a usuarios'),
(11, 'Gestión de respuestas de preguntas de seguridad', 'Gestionar las respuestas de preguntas de seguridad'),
(12, 'Cambiar contraseña\r\n', 'Cambiar contraseña dentro del sistema'),
(13, 'Inscripción para charla PPS', 'Inscripción de los estudiantes para charla de pps'),
(14, 'Gestión de asistencia a charla PPS', 'Gestión de asistencia a charla de PPS'),
(15, 'Registro de clases aprobadas', 'Registro de clases aprobadas para constancia'),
(16, 'Gestión de clases aprobadas', 'Gestión de clases aprobadas'),
(17, 'Registro de datos de empresa', 'Registro de datos de empresa por PPS'),
(18, 'Historial de constancias y/o cartas', 'Historial de constancias y/o cartas'),
(19, 'Entrega de documentación ', 'Documentación de PPS'),
(20, 'Recepción/supervisión de documentos', 'Recepción/supervisión de documentos de PPS'),
(21, 'Aprobación/rechazo de PPS', 'Aprobación/rechazo de PPS'),
(22, 'Registro de egresados', 'Registro de egresados de IA'),
(23, 'Gestión de egresados', 'Gestion de egresados de IA'),
(24, 'Registro de proyectos', 'Registro de proyectos vinculación universidad sociedad'),
(25, 'Gestión de proyectos', 'Gestion de proyectos vinculación universidad sociedad'),
(26, 'Supervisar documentación de PPS', 'Comite de vinculación supervisa documentacion de PPS'),
(27, 'Historial de prácticas aprobadas', 'Historial de prácticas aprobadas'),
(28, 'Historial de prácticas rechazadas', 'Historial de prácticas rechazadas'),
(29, 'Solicitud de finalización de práctica', 'Solicitud de finalización de práctica alumno'),
(30, 'Cambio de carrera', 'Solicitud cambio de carrera alumno'),
(31, 'Carta de egresado', 'Solicitud carta de egresado'),
(32, 'Equivalencias', 'Solicitud de equivalencias'),
(33, 'Cancelación de clases', 'Solicitud de cancelacion de clases'),
(34, 'Revisión de finalización de PPS ', 'Coordinador revision finalizacion practica'),
(35, 'Revisión de cambio carrera', 'Coordinador revision cambio carrera'),
(36, 'Revisión de carta egresado', 'Coordinador revision carta egresado'),
(37, 'Revisión de equivalencias', 'Coordinador revision equivalencias'),
(38, 'Revisión de cancelacion de clases', 'Coordinador revision cancelacion de clases'),
(39, 'Solicitud de PPS', 'Solicitud de pp1 y pps2'),
(40, 'Menú de solicitud de PPS ', 'Menú de solicitud de pps'),
(41, 'Creación de asignaturas ', 'Crear asignaturas'),
(42, 'Gestión de asignaturas', 'Gestionar asignaturas'),
(43, 'Solicitud de examen del himno', 'Solicitud para la realizacion del examnen del himno'),
(44, 'Revisión de alumnos himno', 'Revisión de coordinación de los alumnos disponibles para realizar el examen del himno'),
(45, 'Menú de carga académica ', 'Creacion de carga académica '),
(46, 'Creación de carga académica ', 'Generar carga académica '),
(47, 'Gestión de carga académica ', 'Editar carga académica '),
(48, 'Historial de carga académica ', 'Control y revision de la carga académica '),
(49, 'Menú de docentes', 'Creacion de registro docentes'),
(50, 'Registro de  docentes', 'Crear nuevos docentes'),
(51, 'Gestión de docentes', 'Gestionar docentes'),
(52, 'Comisiones y actividades docentes', 'Agregar comisiones y actividades'),
(53, 'Reporte carga academica docentes', 'Mostrar reporte carga academica docentes'),
(54, 'Perfil docentes', 'Mostrar perfil docentes'),
(55, 'Mantenimiento periodo', 'Mantenimiento gestion periodo'),
(56, 'Mantenimiento jornadas docente', 'Mantenimiento gestion jornadas'),
(57, 'Mantenimiento comisiones docente', 'Mantenimiento gestion comisiones'),
(58, 'Mantenimiento edificio', 'Mantenimiento gestion edificios'),
(59, 'Mantenimiento categorías ', 'Mantenimiento gestion categorias'),
(60, 'Mantenimiento aulas', 'Mantenimiento gestion aulas'),
(61, 'Mantenimiento grados académicos ', 'Mantenimiento gestion grados academicos'),
(62, 'Mantenimiento estado civil', 'Mantenimiento gestion estados civil'),
(63, 'Mantenimiento crear periodo', 'Mantenimiento crear nuevo periodo'),
(64, 'Mantenimiento crear comisiones', 'Mantenimiento crear comisiones'),
(65, 'Mantenimiento crear grados', 'Mantenimiento crear grados academicos'),
(66, 'Mantenimiento crear categorías ', 'Mantenimiento crear categorias docentes'),
(67, 'Mantenimiento crear jornadas', 'Mantenimiento crear jornadas'),
(68, 'Mantenimiento crear estado civil', 'Mantenimiento crear estado civil'),
(69, 'Menú supervisión vista', 'Menú para gestionar las supervisiones'),
(70, 'Menú mantenimientos', 'Menú para todos los mantenimientos existentes'),
(71, 'Menú ayuda', 'Menú los manuales de usuario'),
(72, 'Menú vinculación ', 'Menú de vinculacion'),
(73, 'Mantenimiento crear genero', 'Mantenimiento crear genero'),
(74, 'Mantenimiento actividades', 'Mantenimiento gestion actividades'),
(75, 'Mantenimiento crear actividades', 'Mantenimiento crear actividades'),
(76, 'Mantenimiento crear departamento', 'Mantenimiento crear departamento'),
(77, 'Mantenimiento departamento', 'Mantenimiento gestion departamento'),
(78, 'Mantenimiento crear municipio', 'Mantenimiento crear municipio'),
(79, 'Mantenimiento municipio', 'Mantenimiento gestion municipio'),
(80, 'Mantenimiento atributos', 'Mantenimiento gestion atributos'),
(81, 'Mantenimiento crear atributos', 'Mantenimiento crear atributos'),
(82, 'Mantenimiento crear aula', 'Mantenimiento crear aulas'),
(83, 'Mantenimiento crear edificios', 'Mantenimiento crear edificios'),
(84, 'Mantenimiento genero', 'Mantenimiento gestion genero'),
(85, 'Mantenimiento horario', 'Mantenimiento gestion horario'),
(86, 'Mantenimiento crear horario', 'Mantenimiento crear horario'),
(87, 'Menú práctica profesional', 'Menú para solicitar pps'),
(88, 'Mantenimiento crear carrera', 'Crear carrera'),
(89, 'Mantenimiento carrera', 'Gestionar carrera'),
(90, 'Mantenimiento nacionalidad', 'Mantenimiento gestion nacionalidad'),
(91, 'Mantenimiento crear nacionalidad', 'Mantenimiento crear nacionalidad'),
(92, 'Mantenimiento feriados', 'Mantenimiento de días feriados'),
(93, 'Mantenimiento áreas asignaturas', 'Mantenimiento áreas asignaturas'),
(94, 'Menu mantenimientos Carga', 'Menu mantenimientos Carga'),
(95, 'Menu mantenimiento plan de estudios', 'Menu mantenimientos plan'),
(96, 'Crear plan de estudio', 'Crear plan de estudio'),
(97, 'Historial plan de estudio', 'Historial plan de estudio'),
(98, 'Gestion plan de estudio', 'Gestion plan de estudio'),
(99, 'Mantenimiento crear periodo plan', 'Mantenimiento crear periodo plan'),
(100, 'Mantenimiento periodo plan', 'Mantenimiento periodo plan'),
(101, 'Mantenimiento crear tipo plan', 'Mantenimiento crear tipo plan'),
(102, 'Mantenimiento tipo plan', 'Mantenimiento tipo plan'),
(103, 'Menu plan de estudio', 'Menu plan de estudio'),
(104, 'Menú Mantenimiento CVE', 'Administración del módulo de Horas VOAE'),
(105, 'Mantenimiento Ámbitos CVE', 'Administración de ámbitos Horas VOAE'),
(106, 'Mantenimiento Estados CVE', 'Administración Estados Horas Voae'),
(107, 'Mantenimiento Tipos de Repositorio CVE', 'Administración Tipos de repositorio Horas VOAE'),
(108, 'Mantenimiento Tipos de Faltas CVE', 'Administración tipos de faltas Horas VOAE'),
(109, 'Menú Actividades CVE', 'Administración de las actividades Horas VOAE'),
(110, 'Solicitud de Actividades CVE', 'Solicitar una nueva actividad'),
(112, 'Registro Faltas Menú CVE', 'Se registran todos los alumnos que tengan cualquier tipo de faltas'),
(113, 'Registro Falta CVE Vista', 'Gestiòn de faltas de alumnos'),
(114, 'Horas Voae CVE', 'Gestionar las horas VOAE de los estudiantes'),
(115, 'Gestión Actividades CVE', 'El usuario asignado podrá aprobar, denegar las actividades'),
(116, 'Historial Alumnos CVE', 'Detalle de todas las actividades VOAE realizadas por los alumnos'),
(117, 'Menu Documentación', 'Contiene el permiso para acceder a la página de Informe de Actividades '),
(118, 'Informe Actividad Vista CVE', 'Gestión para la creación de los informes de las actividades ya finalizadas'),
(119, 'Memorandums Vista CVE', 'Guardar memorandums de diferentes tipos'),
(120, 'Tipos de Memorandums Vista CVE', 'Getsión de los diferentes tipos de memos que se puedan agregar'),
(121, 'Finalizar Actividades CVE', 'finalizar Actividades'),
(219, 'Menú Mantenimiento CVE', 'Administración del módulo de Horas VOAE'),
(220, 'Mantenimiento Ámbitos CVE', 'Administración de ámbitos Horas VOAE'),
(221, 'Mantenimiento Estados CVE', 'Administración Estados Horas Voae'),
(222, 'Mantenimiento Tipos de Repositorio CVE', 'Administración Tipos de repositorio Horas VOAE'),
(223, 'Mantenimiento Tipos de Faltas CVE', 'Administración tipos de faltas Horas VOAE'),
(224, 'Menú Actividades CVE', 'Administración de las actividades Horas VOAE'),
(225, 'Solicitud de Actividades CVE', 'Solicitar una nueva actividad'),
(226, 'Registro Faltas Menú CVE', 'Se registran todos los alumnos que tengan cualquier tipo de faltas'),
(227, 'Registro Falta CVE Vista', 'Gestiòn de faltas de alumnos'),
(228, 'Horas Voae CVE', 'Gestionar las horas VOAE de los estudiantes'),
(229, 'Gestión Actividades CVE', 'El usuario asignado podrá aprobar, denegar las actividades'),
(230, 'Historial Alumnos CVE', 'Detalle de todas las actividades VOAE realizadas por los alumnos'),
(231, 'Menu Documentación', 'Contiene el permiso para acceder a la página de Informe de Actividades '),
(232, 'Informe Actividad Vista CVE', 'Gestión para la creación de los informes de las actividades ya finalizadas'),
(233, 'Memorandums Vista CVE', 'Guardar memorandums de diferentes tipos'),
(234, 'Tipos de Memorandums Vista CVE', 'Getsión de los diferentes tipos de memos que se puedan agregar'),
(235, 'Finalizar Actividades CVE', 'finalizar Actividades'),
(236, 'Reporte Actividades CVE', 'Generar un reporte especializado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_parametros`
--

CREATE TABLE `tbl_parametros` (
  `Id_parametro` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `Parametro` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Valor` varchar(255) NOT NULL,
  `Modificado_por` varchar(255) NOT NULL,
  `Fecha_modificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_parametros`
--

INSERT INTO `tbl_parametros` (`Id_parametro`, `Id_usuario`, `Parametro`, `Descripcion`, `Valor`, `Modificado_por`, `Fecha_modificacion`) VALUES
(1, 1, 'INTENTOS', 'INTENTOS SESIONES', '3', ' ADMIN', '2021-02-11 17:41:37'),
(2, 1, 'Tamano_min_clave', 'TAMANO MINIMO DE LA CLAVE', '8', 'ADMIN', '2020-05-11 00:00:00'),
(4, 1, 'Cantidad_preguntas', 'PREGUNTAS INGRESADAS', '3', 'ADMIN', '2020-05-11 00:00:00'),
(5, 1, 'Tamano_max_clave', 'TAMANO MAXIMO DE CLAVE', '10', 'ADMIN', '2020-05-11 00:00:00'),
(6, 1, 'Tamano_clave_correo', 'TAMANO POR EL CORREO', '8', 'ADMIN', '2020-05-11 00:00:00'),
(7, 1, 'CAMBIO_CLAVE', 'TIEMPO PARA CAMBIAR CLAVE', '30', 'ADMIN', '2020-05-11 00:00:00'),
(8, 1, 'correo_institucional', 'CORREO DE LA EMPRESA', 'ainformatica2020@gmail.com', ' ADMIN', '2020-05-23 23:53:27'),
(9, 1, 'clave_correo', 'CLAVE DEL CORREO', 'Mumu123*', ' ADMIN', '2020-05-23 23:54:16'),
(10, 1, 'Puerto', 'PUERTO DEL GMAIL', '465', 'admin', '2020-05-12 00:00:00'),
(11, 1, 'HOST_SMTP', 'HOST DEL SERVIDOR', 'smtp.gmail.com', 'admin', '2020-05-11 00:00:00'),
(12, 1, 'Admin_correo', 'PERSONA QUE ADMINISTRA EL CORRE', 'Comite de Automatizacion ', ' ADMIN', '2021-05-29 04:48:34'),
(13, 1, 'AUTO_REGISTRO', 'AUTO REGISTRO USUARIO', '1', ' ADMIN', '2021-04-14 01:51:29'),
(16, 1, 'DOCENTE_VINCULACION_MATUTINA_1', 'DOCENTE ENCARGADO DE CHARLA', 'MSC. SANDRA QUAN ', 'ADMIN', '2020-06-04 17:49:38'),
(17, 1, 'DOCENTE_VINCULACION_MATUTINA_2', 'DOCENTE ENCARGADO DE CHARLA', 'MSC. ANGELICA MUÑOZ', ' ADMIN', '2020-08-11 06:08:06'),
(18, 1, 'DOCENTE_VINCULACION_VESPERTINA_1', 'DOCENTE ENCARGADO DE CHARLA', 'MSC. CAROLD RITHENHOUSE', 'ADMIN', '2020-06-04 00:00:00'),
(20, 1, 'DOCENTE_VINCULACION_VESPERTINA_2', 'DOCENTE ENCARGADO DE CHARLA', 'LIC. JULIAN ', 'ADMIN', '2020-06-04 00:00:00'),
(21, 1, 'DIAS_CHARLA', 'VALIDACION EN DIAS , PARA FECHA VALIDAS PARA CHARLA ', '90', 'ADMIN', '2020-06-04 00:00:00'),
(22, 1, 'CANTIDAD_DOCUMENTOS', 'MÁXIMA CANTIDAD DE DOCUMENTOS DEL PRACTICANTE.', '9', 'ADMIN', '2020-06-04 00:00:00'),
(23, 1, 'mayoria_edad', 'validacion para mayoria edad', '18', 'ADMIN', '2021-03-16 18:35:16'),
(24, 1, 'num_periodo_maximo', 'el maximo de periodos en un año', '3', 'ADMIN', '2021-04-08 10:14:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_periodo`
--

CREATE TABLE `tbl_periodo` (
  `id_periodo` bigint(16) NOT NULL,
  `num_periodo` int(11) NOT NULL DEFAULT 0,
  `num_anno` year(4) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `Fecha_creacion` date DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` date DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL,
  `id_tipo_periodo` int(11) DEFAULT NULL,
  `fecha_adic_canc` date DEFAULT NULL,
  `fecha_desbloqueo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_periodo`
--

INSERT INTO `tbl_periodo` (`id_periodo`, `num_periodo`, `num_anno`, `fecha_inicio`, `fecha_final`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`, `id_tipo_periodo`, `fecha_adic_canc`, `fecha_desbloqueo`) VALUES
(1, 3, 2020, '2020-09-09', '2020-12-24', '2021-03-11', 'ADMIN', '0000-00-00', '0000-00-00', 1, '2021-09-14', '2021-01-11'),
(3, 1, 2021, '2021-03-20', '2021-04-20', '2021-03-12', 'ADMIN', '0000-00-00', '0000-00-00', 1, '2021-03-30', '2021-02-12'),
(4, 2, 2021, '2021-05-03', '2021-06-30', '2021-05-01', 'ADMIN', '2021-05-01', 'ADMIN', 1, '2021-05-19', '2021-06-01'),
(5, 3, 2021, '2021-07-06', '2021-09-27', '2021-07-05', 'ADMIN', NULL, NULL, 2, '2021-08-25', '2021-08-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_periodo_plan`
--

CREATE TABLE `tbl_periodo_plan` (
  `id_periodo_plan` bigint(20) NOT NULL,
  `periodo` varchar(50) NOT NULL DEFAULT '',
  `Fecha_creacion` date DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `Fecha_modificacion` date DEFAULT NULL,
  `Modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_periodo_plan`
--

INSERT INTO `tbl_periodo_plan` (`id_periodo_plan`, `periodo`, `Fecha_creacion`, `Creado_por`, `Fecha_modificacion`, `Modificado_por`) VALUES
(1, 'periodo 1', NULL, NULL, NULL, NULL),
(2, 'PERIODO 2', '2021-05-29', 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos_usuarios`
--

CREATE TABLE `tbl_permisos_usuarios` (
  `Id_permisos_usuario` bigint(16) NOT NULL,
  `Id_rol` bigint(16) NOT NULL,
  `Id_objeto` bigint(16) NOT NULL,
  `insertar` varchar(255) NOT NULL,
  `modificar` varchar(255) NOT NULL,
  `eliminar` varchar(255) NOT NULL,
  `visualizar` varchar(255) NOT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(255) DEFAULT NULL,
  `Modificado_por` varchar(255) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_permisos_usuarios`
--

INSERT INTO `tbl_permisos_usuarios` (`Id_permisos_usuario`, `Id_rol`, `Id_objeto`, `insertar`, `modificar`, `eliminar`, `visualizar`, `Fecha_creacion`, `Creado_por`, `Modificado_por`, `Fecha_modificacion`) VALUES
(1, 46, 1, '0', '1', '1', '1', NULL, NULL, 'ADMIN', '2021-07-05 01:20:36'),
(2, 46, 2, '1', '1', '1', '1', NULL, NULL, 'ADMIN', '2021-06-23 23:27:59'),
(4, 46, 8, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(5, 46, 3, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(6, 46, 4, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(7, 46, 5, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(8, 46, 6, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(9, 46, 7, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(10, 46, 9, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(11, 46, 10, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(12, 46, 11, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(14, 46, 12, '1', '1', '1', '1', '2020-05-22 22:32:56', ' admin ', NULL, NULL),
(40, 46, 13, '1', '1', '1', '1', '2020-05-28 22:57:35', ' ADMIN ', NULL, NULL),
(41, 46, 14, '1', '1', '1', '1', '2020-05-28 22:57:37', ' ADMIN ', NULL, NULL),
(42, 46, 15, '1', '1', '1', '1', '2020-05-28 22:57:39', ' ADMIN ', NULL, NULL),
(43, 46, 16, '1', '1', '1', '1', '2020-05-28 22:57:41', ' ADMIN ', NULL, NULL),
(44, 46, 17, '1', '1', '1', '1', '2020-05-28 22:57:44', ' ADMIN ', NULL, NULL),
(45, 46, 18, '1', '1', '1', '1', '2020-05-28 22:57:46', ' ADMIN ', NULL, NULL),
(46, 46, 19, '1', '1', '1', '1', '2020-05-28 22:57:48', ' ADMIN ', NULL, NULL),
(47, 46, 20, '1', '1', '1', '1', '2020-05-28 22:57:50', ' ADMIN ', NULL, NULL),
(48, 46, 21, '1', '1', '1', '1', '2020-05-28 22:57:52', ' ADMIN ', NULL, NULL),
(49, 46, 22, '1', '1', '1', '1', '2020-05-28 22:57:54', ' ADMIN ', NULL, NULL),
(50, 46, 23, '1', '1', '1', '1', '2020-05-28 22:57:57', ' ADMIN ', NULL, NULL),
(51, 46, 24, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(52, 46, 25, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(53, 46, 26, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(54, 49, 13, '1', '0', '0', '1', '2020-06-24 23:41:47', ' ADMIN ', NULL, NULL),
(55, 49, 17, '1', '1', '0', '1', '2020-06-24 23:41:51', ' ADMIN ', 'ADMIN', '2021-03-05 23:59:28'),
(56, 49, 19, '1', '0', '0', '1', '2020-06-24 23:41:54', ' ADMIN ', NULL, NULL),
(57, 46, 27, '1', '1', '1', '1', '2020-06-24 23:44:09', ' ADMIN ', NULL, NULL),
(58, 46, 28, '1', '1', '1', '1', '2020-06-24 23:44:12', ' ADMIN ', NULL, NULL),
(59, 46, 29, '1', '1', '1', '1', '2020-07-30 19:32:01', ' ADMIN ', 'ADMIN', '2021-04-14 01:38:03'),
(60, 46, 30, '1', '1', '0', '1', '2020-07-30 19:32:04', ' ADMIN ', 'ADMIN', '2021-06-23 23:47:30'),
(61, 46, 31, '1', '1', '0', '1', '2020-07-30 19:32:07', ' ADMIN ', NULL, NULL),
(62, 46, 32, '1', '1', '0', '1', '2020-07-30 19:32:11', ' ADMIN ', NULL, NULL),
(63, 46, 33, '1', '1', '0', '1', '2020-07-30 19:32:14', ' ADMIN ', NULL, NULL),
(64, 46, 34, '1', '1', '0', '1', '2020-07-30 19:32:17', ' ADMIN ', NULL, NULL),
(65, 46, 35, '1', '1', '0', '1', '2020-07-30 19:32:20', ' ADMIN ', NULL, NULL),
(66, 46, 36, '1', '1', '0', '1', '2020-07-30 19:32:23', ' ADMIN ', NULL, NULL),
(67, 46, 37, '1', '1', '1', '1', '2020-07-30 19:32:26', ' ADMIN ', 'ADMIN', '2021-04-14 01:43:21'),
(68, 46, 38, '1', '1', '1', '1', '2020-07-30 19:32:29', ' ADMIN ', 'ADMIN', '2021-04-14 01:42:40'),
(69, 49, 29, '1', '1', '1', '1', '2020-08-03 10:04:32', ' ADMIN ', NULL, NULL),
(70, 49, 30, '1', '1', '1', '1', '2020-08-03 10:04:32', ' ADMIN ', NULL, NULL),
(71, 49, 31, '1', '1', '1', '1', '2020-08-03 10:04:32', ' ADMIN ', NULL, NULL),
(72, 49, 32, '1', '1', '1', '1', '2020-08-03 10:04:32', ' ADMIN ', NULL, NULL),
(73, 49, 33, '1', '1', '1', '1', '2020-08-03 10:04:32', ' ADMIN ', NULL, NULL),
(74, 51, 13, '0', '0', '0', '1', '2020-08-05 16:46:08', ' ADMIN ', NULL, NULL),
(75, 53, 29, '1', '0', '0', '1', '2020-08-11 06:07:25', ' ADMIN ', 'RCORRALES', '2021-04-04 18:52:13'),
(76, 53, 30, '0', '0', '0', '1', '2020-08-11 06:07:25', ' ADMIN ', NULL, NULL),
(77, 54, 1, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(78, 54, 2, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(79, 54, 3, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(80, 54, 4, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(81, 54, 5, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(82, 54, 6, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(83, 54, 7, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(84, 54, 8, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(85, 54, 9, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(86, 54, 10, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(87, 54, 11, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(88, 54, 12, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(89, 54, 13, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(90, 54, 14, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(91, 54, 15, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(92, 54, 16, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(93, 54, 17, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(94, 54, 18, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(95, 54, 19, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(96, 54, 20, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(97, 54, 21, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(98, 54, 22, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(99, 54, 23, '1', '1', '0', '1', '2020-08-18 22:55:03', ' ADMIN ', NULL, NULL),
(100, 54, 24, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(101, 54, 25, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(102, 54, 26, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(103, 54, 27, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(104, 54, 28, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(105, 54, 29, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(106, 54, 30, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(107, 54, 31, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(108, 54, 32, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(109, 54, 33, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(110, 54, 34, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(111, 54, 35, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(112, 54, 36, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(113, 54, 37, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(114, 54, 38, '1', '1', '0', '1', '2020-08-18 22:55:04', ' ADMIN ', NULL, NULL),
(115, 55, 11, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(116, 55, 12, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(117, 55, 13, '0', '0', '0', '0', '2020-08-18 22:56:43', ' ADMIN ', 'ADMIN', '2021-03-19 15:53:34'),
(118, 55, 14, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', 'ADMIN', '2021-03-19 15:49:30'),
(119, 55, 15, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(120, 55, 16, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(121, 55, 17, '0', '0', '0', '0', '2020-08-18 22:56:43', ' ADMIN ', 'ADMIN', '2021-03-19 15:54:29'),
(122, 55, 18, '0', '0', '0', '0', '2020-08-18 22:56:43', ' ADMIN ', 'ADMIN', '2021-03-19 15:57:35'),
(123, 55, 19, '0', '0', '0', '0', '2020-08-18 22:56:43', ' ADMIN ', 'ADMIN', '2021-03-19 15:56:58'),
(124, 55, 20, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', 'ADMIN', '2021-03-19 15:56:23'),
(125, 55, 21, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(126, 55, 22, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(127, 55, 23, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(128, 55, 24, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(129, 55, 25, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(130, 55, 26, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(131, 55, 27, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(132, 55, 28, '1', '1', '0', '1', '2020-08-18 22:56:43', ' ADMIN ', NULL, NULL),
(133, 56, 11, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(134, 56, 12, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(135, 56, 29, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(136, 56, 30, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(137, 56, 31, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(138, 56, 32, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(139, 56, 33, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(140, 56, 34, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(141, 56, 35, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(142, 56, 36, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(143, 56, 37, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(144, 56, 38, '1', '1', '0', '1', '2020-08-18 22:57:37', ' ADMIN ', NULL, NULL),
(145, 57, 1, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(146, 57, 2, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(147, 57, 3, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(148, 57, 4, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(149, 57, 5, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(150, 57, 6, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(151, 57, 7, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(152, 57, 8, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(153, 57, 9, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(154, 57, 10, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(155, 57, 11, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(156, 57, 12, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(157, 57, 13, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(158, 57, 14, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(159, 57, 15, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(160, 57, 16, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(161, 57, 17, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(162, 57, 18, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(163, 57, 19, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(164, 57, 20, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(165, 57, 21, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(166, 57, 22, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(167, 57, 23, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(168, 57, 24, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(169, 57, 25, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(170, 57, 26, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(171, 57, 27, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(172, 57, 28, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(173, 57, 29, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(174, 57, 30, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(175, 57, 31, '1', '1', '0', '1', '2020-08-18 22:58:42', ' ADMIN ', NULL, NULL),
(176, 57, 32, '1', '1', '0', '1', '2020-08-18 22:58:43', ' ADMIN ', NULL, NULL),
(177, 57, 33, '1', '1', '0', '1', '2020-08-18 22:58:43', ' ADMIN ', NULL, NULL),
(178, 57, 34, '1', '1', '0', '1', '2020-08-18 22:58:43', ' ADMIN ', NULL, NULL),
(179, 57, 35, '1', '1', '0', '1', '2020-08-18 22:58:43', ' ADMIN ', NULL, NULL),
(180, 57, 36, '1', '1', '0', '1', '2020-08-18 22:58:43', ' ADMIN ', NULL, NULL),
(181, 57, 37, '1', '1', '0', '1', '2020-08-18 22:58:43', ' ADMIN ', NULL, NULL),
(182, 57, 38, '1', '1', '0', '1', '2020-08-18 22:58:43', ' ADMIN ', NULL, NULL),
(183, 46, 39, '1', '1', '1', '1', '2020-08-29 02:49:22', ' ADMIN ', NULL, NULL),
(184, 46, 40, '1', '1', '1', '1', '2020-08-29 02:49:22', ' ADMIN ', NULL, NULL),
(185, 46, 41, '1', '1', '1', '1', '2020-08-31 20:18:46', ' ADMIN ', NULL, NULL),
(186, 46, 42, '1', '1', '1', '1', '2020-08-31 20:18:46', ' ADMIN ', NULL, NULL),
(187, 46, 43, '1', '1', '1', '1', '2020-10-19 19:15:21', ' ADMIN ', NULL, NULL),
(188, 46, 44, '1', '1', '1', '1', '2020-10-19 19:15:25', ' ADMIN ', NULL, NULL),
(189, 49, 43, '1', '0', '0', '1', '2020-10-22 19:57:13', ' ADMIN ', NULL, NULL),
(190, 49, 39, '1', '0', '0', '1', '2020-10-27 21:53:44', ' ADMIN ', NULL, NULL),
(191, 49, 40, '1', '0', '0', '1', '2020-10-27 21:53:47', ' ADMIN ', NULL, NULL),
(192, 49, 41, '1', '0', '0', '1', '2020-10-27 21:53:50', ' ADMIN ', NULL, NULL),
(193, 49, 42, '1', '0', '0', '1', '2020-10-27 21:53:53', ' ADMIN ', NULL, NULL),
(194, 49, 15, '1', '0', '0', '1', '2020-10-27 22:04:07', ' ADMIN ', NULL, NULL),
(195, 49, 16, '1', '0', '0', '1', '2020-10-27 22:04:10', ' ADMIN ', NULL, NULL),
(196, 46, 45, '1', '1', '1', '1', '2020-11-02 16:34:35', ' ADMIN ', 'ADMIN', '2021-06-24 00:10:46'),
(197, 46, 46, '1', '1', '1', '1', '2020-11-02 16:34:38', ' ADMIN ', NULL, NULL),
(198, 46, 47, '1', '1', '1', '1', '2020-11-02 16:34:42', ' ADMIN ', NULL, NULL),
(199, 46, 48, '1', '1', '1', '1', '2020-11-02 16:34:45', ' ADMIN ', NULL, NULL),
(200, 46, 49, '1', '1', '1', '1', '2020-11-02 19:42:23', ' ADMIN ', 'ADMIN', '2021-06-24 00:10:01'),
(201, 46, 50, '1', '1', '1', '1', '2020-11-02 19:42:25', ' ADMIN ', 'ADMIN', '2020-11-03 19:47:05'),
(202, 46, 51, '1', '1', '1', '1', '2020-11-02 19:42:26', ' ADMIN ', NULL, NULL),
(203, 46, 52, '1', '1', '1', '1', '2020-11-02 19:42:28', ' ADMIN ', NULL, NULL),
(204, 46, 53, '1', '1', '1', '1', '2020-11-02 19:42:29', ' ADMIN ', NULL, NULL),
(205, 46, 54, '1', '1', '1', '1', '2020-11-02 19:42:31', ' ADMIN ', NULL, NULL),
(206, 46, 55, '1', '1', '1', '1', '2020-11-28 20:11:55', ' ADMIN ', NULL, NULL),
(207, 46, 56, '1', '1', '1', '1', '2020-12-02 00:51:57', ' ADMIN ', NULL, NULL),
(208, 46, 57, '1', '1', '1', '1', '2020-12-02 20:47:09', ' ADMIN ', NULL, NULL),
(209, 46, 58, '1', '1', '1', '1', '2020-12-02 22:27:11', ' ADMIN ', NULL, NULL),
(210, 46, 59, '1', '1', '1', '1', '2020-12-02 22:54:55', ' ADMIN ', NULL, NULL),
(211, 46, 60, '1', '1', '1', '1', '2020-12-02 23:25:41', ' ADMIN ', NULL, NULL),
(212, 46, 61, '1', '1', '1', '1', '2020-12-03 00:24:52', ' ADMIN ', NULL, NULL),
(213, 46, 62, '1', '1', '1', '1', '2020-12-04 22:00:52', ' ADMIN ', NULL, NULL),
(214, 46, 63, '1', '1', '1', '1', '2020-12-05 23:45:34', ' ADMIN ', NULL, NULL),
(215, 46, 64, '1', '1', '1', '1', '2020-12-05 23:45:35', ' ADMIN ', NULL, NULL),
(216, 46, 65, '1', '1', '1', '1', '2020-12-05 23:45:37', ' ADMIN ', NULL, NULL),
(217, 46, 66, '1', '1', '1', '1', '2020-12-05 23:45:38', ' ADMIN ', NULL, NULL),
(218, 46, 67, '1', '1', '1', '1', '2020-12-05 23:45:39', ' ADMIN ', NULL, NULL),
(219, 46, 68, '1', '1', '1', '1', '2020-12-05 23:45:41', ' ADMIN ', NULL, NULL),
(220, 63, 41, '1', '1', '0', '0', '2021-02-11 17:37:47', ' ADMIN ', 'ADMIN', '2021-02-11 17:38:54'),
(221, 49, 18, '1', '0', '0', '1', '2021-03-05 23:07:01', ' ADMIN ', NULL, NULL),
(222, 46, 69, '1', '1', '1', '1', '2021-03-10 22:49:46', ' ADMIN ', NULL, NULL),
(223, 46, 70, '1', '1', '1', '1', '2021-03-11 04:59:42', ' ADMIN ', 'ADMIN', '2021-06-23 23:49:45'),
(224, 46, 72, '1', '1', '1', '1', '2021-03-17 05:58:17', ' ADMIN ', NULL, NULL),
(225, 46, 76, '1', '1', '1', '1', '2021-03-17 18:14:10', ' ADMIN ', NULL, NULL),
(226, 46, 77, '1', '1', '1', '1', '2021-03-17 18:14:12', ' ADMIN ', NULL, NULL),
(227, 46, 78, '1', '1', '1', '1', '2021-03-17 22:51:32', ' ADMIN ', NULL, NULL),
(228, 46, 79, '1', '1', '1', '1', '2021-03-17 22:51:33', ' ADMIN ', NULL, NULL),
(229, 46, 87, '1', '1', '1', '1', '2021-03-18 22:47:32', ' ADMIN ', 'ADMIN', '2021-06-23 23:45:47'),
(230, 46, 88, '1', '1', '1', '1', '2021-03-19 01:45:33', ' ADMIN ', NULL, NULL),
(231, 46, 89, '1', '1', '1', '1', '2021-03-19 01:45:35', ' ADMIN ', NULL, NULL),
(232, 46, 73, '1', '1', '1', '1', '2021-03-19 03:29:43', ' ADMIN ', NULL, NULL),
(233, 46, 74, '1', '1', '1', '1', '2021-03-19 03:29:45', ' ADMIN ', NULL, NULL),
(234, 46, 75, '1', '1', '1', '1', '2021-03-19 03:29:47', ' ADMIN ', NULL, NULL),
(235, 46, 80, '1', '1', '1', '1', '2021-03-19 03:29:49', ' ADMIN ', NULL, NULL),
(236, 46, 81, '1', '1', '1', '1', '2021-03-19 03:29:50', ' ADMIN ', NULL, NULL),
(237, 46, 82, '1', '1', '1', '1', '2021-03-19 03:29:51', ' ADMIN ', NULL, NULL),
(238, 46, 83, '1', '1', '1', '1', '2021-03-19 03:29:53', ' ADMIN ', NULL, NULL),
(239, 46, 84, '1', '1', '1', '1', '2021-03-19 03:29:54', ' ADMIN ', NULL, NULL),
(240, 46, 85, '1', '1', '1', '1', '2021-03-19 03:29:57', ' ADMIN ', NULL, NULL),
(241, 46, 86, '1', '1', '1', '1', '2021-03-19 03:29:58', ' ADMIN ', NULL, NULL),
(242, 46, 90, '1', '1', '1', '1', '2021-03-19 03:30:02', ' ADMIN ', NULL, NULL),
(243, 46, 91, '1', '1', '1', '1', '2021-03-19 03:30:04', ' ADMIN ', NULL, NULL),
(244, 64, 49, '1', '1', '1', '1', '2021-03-23 00:10:57', ' ADMIN ', NULL, NULL),
(245, 64, 50, '0', '0', '0', '0', '2021-03-23 00:10:58', ' ADMIN ', 'ADMIN', '2021-04-08 22:07:18'),
(246, 64, 51, '0', '0', '0', '0', '2021-03-23 00:11:00', ' ADMIN ', 'ADMIN', '2021-04-08 22:03:23'),
(247, 64, 54, '1', '1', '1', '1', '2021-03-23 00:11:01', ' ADMIN ', NULL, NULL),
(248, 65, 24, '1', '0', '0', '1', '2021-04-04 18:53:18', ' RCORRALES ', NULL, NULL),
(249, 65, 51, '0', '1', '0', '0', '2021-04-04 18:57:41', ' RCORRALES ', NULL, NULL),
(250, 46, 92, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(251, 54, 92, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(252, 55, 92, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(253, 64, 53, '1', '1', '1', '1', '2021-04-08 22:05:20', ' ADMIN ', NULL, NULL),
(254, 46, 93, '1', '1', '1', '1', '2021-04-11 05:32:53', ' ADMIN ', NULL, NULL),
(255, 46, 94, '1', '1', '1', '1', '2021-04-21 08:06:55', ' ADMIN ', 'ADMIN', '2021-06-24 00:11:14'),
(256, 68, 1, '1', '0', '1', '1', '2021-04-23 01:58:16', ' ADMIN ', 'ADMIN', '2021-04-23 02:03:55'),
(257, 68, 3, '1', '1', '0', '1', '2021-04-23 01:58:17', ' ADMIN ', NULL, NULL),
(258, 56, 45, '1', '1', '1', '1', '2021-04-30 19:18:28', ' ADMIN ', NULL, NULL),
(259, 56, 47, '1', '1', '1', '1', '2021-04-30 19:18:29', ' ADMIN ', NULL, NULL),
(260, 56, 48, '1', '1', '1', '1', '2021-04-30 19:18:30', ' ADMIN ', NULL, NULL),
(261, 56, 49, '1', '1', '1', '1', '2021-04-30 19:18:32', ' ADMIN ', NULL, NULL),
(262, 56, 51, '1', '1', '1', '1', '2021-04-30 19:18:34', ' ADMIN ', NULL, NULL),
(263, 56, 55, '1', '1', '1', '1', '2021-04-30 19:18:35', ' ADMIN ', NULL, NULL),
(264, 56, 56, '1', '1', '1', '1', '2021-04-30 19:18:37', ' ADMIN ', NULL, NULL),
(265, 56, 57, '1', '1', '1', '1', '2021-04-30 19:18:38', ' ADMIN ', NULL, NULL),
(266, 56, 58, '1', '1', '1', '1', '2021-04-30 19:18:40', ' ADMIN ', NULL, NULL),
(267, 56, 59, '1', '1', '1', '1', '2021-04-30 19:18:42', ' ADMIN ', NULL, NULL),
(268, 56, 60, '1', '1', '1', '1', '2021-04-30 19:18:43', ' ADMIN ', NULL, NULL),
(269, 56, 61, '1', '1', '1', '1', '2021-04-30 19:18:45', ' ADMIN ', NULL, NULL),
(270, 56, 62, '1', '1', '1', '1', '2021-04-30 19:18:47', ' ADMIN ', NULL, NULL),
(271, 56, 63, '1', '1', '1', '1', '2021-04-30 19:18:49', ' ADMIN ', NULL, NULL),
(272, 56, 64, '1', '1', '1', '1', '2021-04-30 19:18:51', ' ADMIN ', NULL, NULL),
(273, 56, 65, '1', '1', '1', '1', '2021-04-30 19:18:52', ' ADMIN ', NULL, NULL),
(274, 56, 66, '1', '1', '1', '1', '2021-04-30 19:18:53', ' ADMIN ', NULL, NULL),
(275, 56, 67, '1', '1', '1', '1', '2021-04-30 19:18:55', ' ADMIN ', NULL, NULL),
(276, 56, 68, '1', '1', '1', '1', '2021-04-30 19:18:57', ' ADMIN ', NULL, NULL),
(277, 56, 69, '1', '1', '1', '1', '2021-04-30 19:18:59', ' ADMIN ', NULL, NULL),
(278, 56, 70, '1', '1', '1', '1', '2021-04-30 19:19:00', ' ADMIN ', NULL, NULL),
(279, 56, 71, '1', '1', '1', '1', '2021-04-30 19:19:02', ' ADMIN ', 'ADMIN', '2021-06-23 23:32:52'),
(280, 56, 73, '1', '1', '1', '1', '2021-04-30 19:19:04', ' ADMIN ', NULL, NULL),
(281, 56, 74, '1', '1', '1', '1', '2021-04-30 19:19:06', ' ADMIN ', NULL, NULL),
(282, 56, 75, '1', '1', '1', '1', '2021-04-30 19:19:07', ' ADMIN ', NULL, NULL),
(283, 56, 76, '1', '1', '1', '1', '2021-04-30 19:19:09', ' ADMIN ', NULL, NULL),
(284, 56, 77, '1', '1', '1', '1', '2021-04-30 19:19:10', ' ADMIN ', NULL, NULL),
(285, 56, 78, '1', '1', '1', '1', '2021-04-30 19:19:13', ' ADMIN ', NULL, NULL),
(286, 56, 79, '1', '1', '1', '1', '2021-04-30 19:19:15', ' ADMIN ', NULL, NULL),
(287, 56, 80, '1', '1', '1', '1', '2021-04-30 19:19:16', ' ADMIN ', NULL, NULL),
(288, 56, 81, '1', '1', '1', '1', '2021-04-30 19:19:18', ' ADMIN ', NULL, NULL),
(289, 56, 82, '1', '1', '1', '1', '2021-04-30 19:19:21', ' ADMIN ', NULL, NULL),
(290, 56, 83, '1', '1', '1', '1', '2021-04-30 19:19:23', ' ADMIN ', NULL, NULL),
(291, 56, 84, '1', '1', '1', '1', '2021-04-30 19:19:25', ' ADMIN ', NULL, NULL),
(292, 56, 85, '1', '1', '1', '1', '2021-04-30 19:19:26', ' ADMIN ', NULL, NULL),
(293, 56, 86, '1', '1', '1', '1', '2021-04-30 19:19:29', ' ADMIN ', NULL, NULL),
(294, 56, 88, '1', '1', '1', '1', '2021-04-30 19:19:30', ' ADMIN ', NULL, NULL),
(295, 56, 89, '1', '1', '1', '1', '2021-04-30 19:19:32', ' ADMIN ', NULL, NULL),
(296, 56, 90, '1', '1', '1', '1', '2021-04-30 19:19:33', ' ADMIN ', NULL, NULL),
(297, 56, 91, '1', '1', '1', '1', '2021-04-30 19:19:35', ' ADMIN ', NULL, NULL),
(298, 56, 92, '1', '1', '1', '1', '2021-04-30 19:19:37', ' ADMIN ', NULL, NULL),
(299, 56, 93, '1', '1', '1', '1', '2021-04-30 19:19:39', ' ADMIN ', NULL, NULL),
(300, 56, 94, '1', '1', '1', '1', '2021-04-30 19:19:40', ' ADMIN ', NULL, NULL),
(301, 46, 95, '1', '1', '1', '1', '2021-05-28 23:32:08', ' ADMIN ', NULL, NULL),
(302, 46, 99, '1', '1', '1', '1', '2021-05-28 23:32:35', ' ADMIN ', NULL, NULL),
(303, 46, 100, '1', '1', '1', '1', '2021-05-28 23:32:49', ' ADMIN ', NULL, NULL),
(304, 46, 101, '1', '1', '1', '1', '2021-05-28 23:33:03', ' ADMIN ', NULL, NULL),
(305, 46, 102, '1', '1', '1', '1', '2021-05-28 23:33:10', ' ADMIN ', NULL, NULL),
(306, 46, 96, '1', '1', '1', '1', '2021-05-28 23:48:39', ' ADMIN ', NULL, NULL),
(307, 46, 97, '1', '1', '1', '1', '2021-05-28 23:48:40', ' ADMIN ', NULL, NULL),
(308, 46, 98, '1', '1', '1', '1', '2021-05-28 23:48:44', ' ADMIN ', NULL, NULL),
(309, 46, 103, '1', '1', '1', '1', '2021-05-28 23:48:50', ' ADMIN ', NULL, NULL),
(310, 46, 104, '1', '1', '1', '1', '2021-06-23 22:10:53', ' ADMIN ', 'ADMIN', '2021-06-28 13:27:33'),
(311, 46, 105, '1', '1', '1', '1', '2021-06-23 22:10:53', ' ADMIN ', 'ADMIN', '2021-08-02 20:38:18'),
(312, 46, 106, '1', '1', '1', '1', '2021-06-23 22:10:53', ' ADMIN ', 'ADMIN', '2021-08-01 23:46:33'),
(313, 46, 107, '1', '1', '1', '1', '2021-06-23 22:26:13', ' ADMIN ', 'ADMIN', '2021-07-07 20:19:20'),
(314, 46, 108, '1', '1', '0', '1', '2021-06-23 22:26:13', ' ADMIN ', 'ADMIN', '2021-06-28 16:41:12'),
(315, 46, 109, '1', '1', '1', '1', '2021-06-23 23:41:52', ' ADMIN ', 'ADMIN', '2021-08-06 16:55:58'),
(316, 46, 110, '1', '1', '1', '1', '2021-06-23 23:41:52', ' ADMIN ', 'ADMIN', '2021-08-06 16:56:36'),
(317, 46, 111, '1', '1', '1', '1', '2021-06-25 21:10:06', ' ADMIN ', NULL, NULL),
(318, 46, 112, '1', '1', '1', '1', '2021-06-30 23:19:12', ' ADMIN ', 'ADMIN', '2021-08-06 15:31:28'),
(319, 46, 113, '1', '1', '1', '1', '2021-07-01 16:22:57', ' ADMIN ', 'ADMIN', '2021-08-06 15:32:01'),
(320, 49, 112, '0', '0', '0', '1', '2021-07-05 17:52:59', ' ADMIN ', NULL, NULL),
(321, 49, 113, '0', '0', '0', '1', '2021-07-05 17:52:59', ' ADMIN ', NULL, NULL),
(322, 46, 114, '1', '1', '1', '1', '2021-07-09 18:40:05', ' ADMIN ', 'ADMIN', '2021-08-06 16:57:34'),
(323, 46, 115, '1', '1', '1', '1', '2021-07-27 22:02:59', ' ADMIN ', 'ADMIN', '2021-08-06 11:47:16'),
(324, 46, 116, '1', '1', '1', '1', '2021-07-31 21:36:13', ' ADMIN ', 'ADMIN', '2021-08-06 16:57:03'),
(325, 46, 117, '1', '1', '1', '1', '2021-08-04 22:01:36', ' ADMIN ', NULL, NULL),
(326, 46, 118, '1', '1', '1', '1', '2021-08-04 22:01:36', ' ADMIN ', 'ADMIN', '2021-08-05 02:17:08'),
(327, 46, 119, '1', '1', '1', '1', '2021-08-04 22:01:36', ' ADMIN ', 'ADMIN', '2021-08-06 16:58:06'),
(328, 46, 120, '1', '1', '1', '1', '2021-08-04 22:01:36', ' ADMIN ', NULL, NULL),
(329, 46, 121, '1', '1', '1', '1', '2021-08-06 00:51:27', ' ADMIN ', NULL, NULL),
(330, 46, 219, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(331, 46, 220, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(332, 46, 221, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(333, 46, 222, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(334, 46, 223, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(335, 46, 224, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(336, 46, 225, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(337, 46, 226, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(338, 46, 227, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(339, 46, 228, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(340, 46, 229, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(341, 46, 230, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(342, 46, 231, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(343, 46, 232, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(344, 46, 233, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(345, 46, 234, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(346, 46, 235, '1', '1', '1', '1', '2021-08-24 17:39:08', ' ADMIN ', NULL, NULL),
(347, 46, 236, '1', '1', '1', '1', '2021-08-26 10:15:39', ' ADMIN ', NULL, NULL),
(348, 64, 224, '1', '1', '1', '1', '2021-09-20 09:33:51', ' ADMIN ', NULL, NULL),
(349, 64, 225, '1', '1', '1', '1', '2021-09-20 09:33:51', ' ADMIN ', 'ADMIN', '2021-09-20 09:52:45'),
(350, 64, 228, '1', '1', '1', '1', '2021-09-20 09:33:51', ' ADMIN ', NULL, NULL),
(351, 64, 230, '1', '1', '1', '1', '2021-09-20 09:33:51', ' ADMIN ', NULL, NULL),
(352, 64, 231, '1', '1', '1', '1', '2021-09-20 09:33:51', ' ADMIN ', NULL, NULL),
(353, 64, 232, '1', '1', '1', '1', '2021-09-20 09:33:51', ' ADMIN ', NULL, NULL),
(354, 64, 235, '1', '1', '1', '1', '2021-09-20 09:33:51', ' ADMIN ', NULL, NULL),
(355, 64, 229, '0', '0', '0', '0', '2021-09-20 09:54:40', ' ADMIN ', 'ADMIN', '2021-09-20 09:55:29'),
(356, 64, 236, '1', '1', '1', '1', '2021-09-20 09:54:40', ' ADMIN ', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_personas`
--

CREATE TABLE `tbl_personas` (
  `id_persona` bigint(16) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `sexo` varchar(255) NOT NULL,
  `identidad` varchar(255) DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  `estado_civil` varchar(25) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `id_tipo_persona` int(11) DEFAULT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  `id_tipo_docente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_personas`
--

INSERT INTO `tbl_personas` (`id_persona`, `nombres`, `apellidos`, `sexo`, `identidad`, `nacionalidad`, `estado_civil`, `fecha_nacimiento`, `id_tipo_persona`, `Estado`, `id_tipo_docente`) VALUES
(3, 'Daniel ', '20161002890', 'numero de cuenta', 'Alumno', NULL, NULL, NULL, 2, 'INACTIVO', 1),
(4, 'Helmer Ernesto ', 'Calix', 'numero de cuenta', 'Alumno', NULL, NULL, NULL, 2, 'INACTIVO', NULL),
(6, 'CHRISTEL NICOLE ', 'NEUMANN CALLEJAS', 'NUMERO_CUENTA', '0801-1996-15579', NULL, NULL, '2020-10-20', 2, 'INACTIVO', NULL),
(10, 'FANY', 'BARAHONA', 'FEMENINO', '0801-1997-23034', 'HODURENA', 'CASADO', '2020-01-02', 1, 'INACTIVO', NULL),
(14, 'SANDRA JANETH ', 'QUAN GOMEZ', 'FEMENINO', '080100000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 3, 'INACTIVO', NULL),
(15, 'EDIS JULIAN', 'REYES GARCIA', 'MASCULINO', '0808000000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(16, 'CAROLD ARGENTINA', 'RITHENHOUSE SABILLON', 'FEMENINO', '0808000000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(17, 'NELSON FRANCISCO', 'DIAZ VALLEJO', 'MASCULINO', '080800000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(18, 'ROSMERY CORRALES', 'APLICANO', 'FEMENINO', '0808000000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(19, 'MARTHA PATRICIA', 'ELLNER VILLALONGA', 'FEMENINO', '080800000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(20, 'FREDY ANDERSSON', 'MOTIÑO FLORES', 'MASCULINO', '0801199508298', 'HONDUREÑA', 'SOLTERO', '1995-05-04', 2, 'INACTIVO', NULL),
(21, 'DANIEL ENRIQUE', 'RAMIREZ', 'MASCULINO', '080800000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'INACTIVO', NULL),
(22, 'Linda Ceciclia', 'Villatoro Hernandez', 'Femenino', ' 0801-1111-1111_', NULL, NULL, '1997-06-12', 2, 'INACTIVO', NULL),
(23, 'DULCE MONSERRAT', 'DEL CID FIALLOS', 'FEMENINO', '0801000000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(24, 'GIANCARLO MARTINI', 'SCALICI AGUILAR', 'MASCULINO', '0808000000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(25, 'CRISTIAN JOSUE', 'RIVERA RAMIREZ', 'MASCULINO', '080800000000', 'HONDUREÑA', 'SOLTERO', '2021-03-01', 1, 'ACTIVO', NULL),
(26, 'Samanta', 'Ramirez', 'Femenino', ' 1111-1111-11111', NULL, NULL, '2021-03-05', 2, 'INACTIVO', NULL),
(27, 'Edward Alberto', 'Alvarenga Rodriguez', 'Masculino', ' 0801-2222-02022', NULL, NULL, '1992-07-17', 2, 'INACTIVO', NULL),
(39, 'ROSMERY ', 'CORRALES', 'FEMENINO', '0801-1273-33232', 'HONDUREÑA', 'CASADO', '2001-03-22', 1, 'INACTIVO', NULL),
(61, 'Enrique ', 'Rivera', 'Masculino', ' 2222-2222-22222', NULL, NULL, '2021-03-07', 2, 'INACTIVO', NULL),
(63, 'LESTER JOSUE ', 'FIALLOS PERALTA', 'MASCULINO', ' 0801-1990-01243', 'HONDUREÑA', 'SOLTERO', '1990-12-05', 1, 'ACTIVO', NULL),
(66, 'Fredy andersson', 'MOTINO FLORES', 'MASCULINO', '0801199508298', 'FRANCÉSA', 'SOLTERO', '2021-03-01', 2, 'INACTIVO', NULL),
(67, 'fredy', 'andersson cruz', 'FEMENINO', '0000000000000', 'AFGANA', 'SOLTERO', '2021-03-01', 1, 'INACTIVO', NULL),
(68, 'fredy', 'a', 'MASCULINO', '00000000000', 'AFGANA', 'SOLTERO', '2021-03-01', 1, 'INACTIVO', NULL),
(69, 'ander', 'fredy', '', '999999999999', 'AFGANA', 'UNION LIBRE', '2021-03-02', 1, 'INACTIVO', NULL),
(70, 'andersson', 'flores', '', '8888888888', 'AFGANA', 'SOLTERO', '2021-03-03', 1, 'INACTIVO', NULL),
(71, 'fredy', 'pao', 'MASCULINO', '9999999999', 'AFGANA', 'SOLTERO', '2021-03-02', 1, 'INACTIVO', NULL),
(72, 'fred', 'an', '', '5555555555555', 'AFGANA', 'SOLTERO', '2021-03-01', 1, 'INACTIVO', NULL),
(73, 'katherine andrea', 'alonzo', 'FEMENINO', ' 0801-1967-02806', 'AUSTRALIANA', 'SOLTERO', '1967-06-09', 1, 'INACTIVO', NULL),
(74, 'Lisa', 'Lucas', 'FEMENINO', ' 0801-1985-29999', 'ALEMANA', 'SOLTERO', '1985-06-01', 2, 'INACTIVO', NULL),
(77, 'HANSY NICOL', 'PONCE PONCE', 'Femenino', NULL, NULL, NULL, NULL, 2, 'INACTIVO', NULL),
(80, 'CARLOS GUSTAVO', 'ROMERO GALEANO', 'MASCULINO', '0805-1990-00123', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(81, 'CARMEN SUYAPA', 'GONZALEZ SANTOS', 'FEMENINO', '0801-1990-00135', 'HONDUREÑA', 'CASADO', '1990-04-05', 1, 'INACTIVO', NULL),
(82, 'CLAUDIA REGINA', 'NUÑEZ GALINDO', 'FEMENINO', '0901-1990-12300', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(83, 'DAVID MARTIN', 'ROVELO HERNANDEZ', 'MASCULINO', '0901-1990-12344', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(84, 'DILMA DORIS', 'ORTEGA TROCHE', 'FEMENINO', '0801-1990-00456', 'HONDUREÑA', 'CASADO', '1990-03-31', 1, 'INACTIVO', NULL),
(85, 'DINORA PATRICIA', 'VELASQUEZ VELASQUEZ', 'FEMENINO', '0801-1990-12345', 'HONDUREÑA', 'CASADO', '1990-03-30', 1, 'ACTIVO', NULL),
(86, 'DULIS PATRICIA', 'CORDOVA GALO', 'FEMENINO', '0901-1990-67890', 'HONDUREÑA', 'CASADO', '1990-03-29', 1, 'ACTIVO', NULL),
(87, 'HECTOR ALBERTO', 'BERRIOS RODRIGUEZ', 'MASCULINO', '0901-1990-67853', 'HONDUREÑA', 'CASADO', '1990-04-21', 1, 'INACTIVO', NULL),
(88, 'IRMA YADIRA', 'GAMEZ SUAZO', 'FEMENINO', '0801-1990-66543', 'HONDUREÑA', 'CASADO', '1990-03-07', 1, 'INACTIVO', NULL),
(89, 'ISAAC ARMANDO', 'DUBON SAM', 'MASCULINO', '0901-1990-12689', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(90, 'JORGE ALBERTO', 'REYES GARCIA', 'MASCULINO', '0901-1990-00565', 'HONDUREÑA', 'CASADO', '1990-03-30', 1, 'INACTIVO', NULL),
(91, 'KARLA MARIA', 'CHEVEZ FLORES', 'FEMENINO', '0801-1990-08654', 'HONDUREÑA', 'CASADO', '1990-04-13', 1, 'ACTIVO', NULL),
(92, 'LUIS EDUARDO', 'ERAZO TRIMARCHI', 'FEMENINO', '0801-1990-09876', 'HONDUREÑA', 'CASADO', '1990-04-05', 1, 'ACTIVO', NULL),
(93, 'MARCO ANTONIO', 'AVILA ORTEGA', 'MASCULINO', '0808-1990-21313', 'HONDUREÑA', 'CASADO', '1990-03-31', 1, 'ACTIVO', NULL),
(94, 'MARIA LORENA', 'ALVARADO LEVERON', 'FEMENINO', '0801-1990-98765', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(95, 'MARVIN JOSUE', 'AGUILAR ROMERO', 'MASCULINO', '0801-1990-87654', 'HONDUREÑA', 'CASADO', '1990-04-04', 1, 'ACTIVO', NULL),
(96, 'MARVIN LEONEL', 'MENDOZA DIAZ', 'MASCULINO', '0901-1990-11112', 'HONDUREÑA', 'CASADO', '1990-03-30', 1, 'ACTIVO', NULL),
(97, 'MARVIN NOE', 'JAIME MERINO', 'MASCULINO', '0801-1990-11111', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(98, 'MILVIA ESPERANZA', 'GUERRA', 'FEMENINO', '0901-1990-56789', 'HONDUREÑA', 'CASADO', '1990-01-06', 1, 'ACTIVO', NULL),
(99, 'OBED HUMBERTO', 'MARTINEZ REYES', 'FEMENINO', '0801-1990-04546', 'HONDUREÑA', 'CASADO', '1990-04-15', 1, 'ACTIVO', NULL),
(100, 'SANDRA JANETH', 'QUAN GOMEZ', 'FEMENINO', '0901-1990-45678', 'HONDUREÑA', 'CASADO', '1990-03-29', 1, 'ACTIVO', NULL),
(101, 'YOLANY MARITZA', 'FLORES NAZAR', 'FEMENINO', '0801-1990-65778', 'HONDUREÑA', 'CASADO', '1990-04-14', 1, 'ACTIVO', NULL),
(102, 'EDUARDO ENRIQUE', 'SANTOS CASTILLO', 'MASCULINO', '0801-1990-67890', 'HONDUREÑA', 'CASADO', '1990-04-13', 1, 'ACTIVO', NULL),
(103, 'KARLA MELISA', 'GARCIA PINEDA', 'FEMENINO', '0801-1990-16578', 'HONDUREÑA', 'CASADO', '1988-03-30', 1, 'ACTIVO', NULL),
(104, 'CARLOS EDUARDO', 'ORDOÑEZ RODRIGUEZ', 'MASCULINO', '0801-1990-43546', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(105, 'CESAR ALEJANDRO', 'MALDONADO CRUZ', 'MASCULINO', '0801-1990-90898', 'HONDUREÑA', 'CASADO', '1990-03-31', 1, 'ACTIVO', NULL),
(106, 'DILMA AURORA', 'MONCADA AVILA', 'FEMENINO', '0801-1990-88383', 'HONDUREÑA', 'CASADO', '1990-04-05', 1, 'ACTIVO', NULL),
(107, 'HEBER DE JESUS', 'AGUILERA RIVERA', 'MASCULINO', '0801-1990-55777', 'HONDUREÑA', 'CASADO', '1990-03-28', 1, 'ACTIVO', NULL),
(108, 'HECTOR ENRIQUE', 'HERNANDEZ PEDRANO', 'MASCULINO', '0801-1990-55141', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(109, 'JOSE ADALBERTO', 'SIERRA RODAS', 'MASCULINO', '0801-1990-53131', 'HONDUREÑA', 'CASADO', '1990-03-30', 1, 'ACTIVO', NULL),
(110, 'JOSE FRANCISCO', 'PAGOAGA ACOSTA', 'MASCULINO', '0801-1990-66372', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(111, 'JOSE MARIO', 'REYES AGUILAR', 'MASCULINO', '0801-1990-44151', 'HONDUREÑA', 'CASADO', '1990-04-06', 1, 'ACTIVO', NULL),
(112, 'LEONARDO ALFREDO', 'ZAMBRANA AGUILAR', 'MASCULINO', '0801-1990-17727', 'HONDUREÑA', 'CASADO', '1990-03-30', 1, 'ACTIVO', NULL),
(113, 'LESTER JOSUE', 'FIALLOS PERALTA', 'MASCULINO', '0801-1990-11188', 'HONDUREÑA', 'CASADO', '1990-03-31', 1, 'ACTIVO', NULL),
(114, 'REBECA ISABEL', 'ESPINAL DIAZ', 'FEMENINO', '0801-1990-65611', 'HONDUREÑA', 'CASADO', '1990-03-30', 1, 'ACTIVO', NULL),
(115, 'TANIA YESENIA', 'VALLADARES BAISA', 'FEMENINO', '0801-1990-11113', 'HONDUREÑA', 'CASADO', '1990-03-30', 1, 'ACTIVO', NULL),
(116, 'ANGELICA AMELISA', 'MUÑOZ SALINAS', 'FEMENINO', '0801-1990-66551', 'HONDUREÑA', 'CASADO', '1991-03-30', 1, 'ACTIVO', NULL),
(117, 'JOSE LUIS', 'RODRIGUEZ GARCIA', 'MASCULINO', '0801-1990-11101', 'HONDUREÑA', 'CASADO', '1990-04-20', 1, 'ACTIVO', NULL),
(118, 'HECTOR', 'GALINDO PINEDA', 'MASCULINO', '0801-1990-11103', 'HONDUREÑA', 'CASADO', '1990-04-21', 1, 'ACTIVO', NULL),
(130, 'Elia', 'Rivera', 'Femenino', ' 2222-2222-22222', NULL, NULL, '2021-04-02', 2, 'INACTIVO', NULL),
(148, 'PRUEBA', 'PRUEBA', 'MASCULINO', '0801-1999-88999', 'HONDUREÑA', 'UNION LIBRE', '1994-04-23', 1, 'ACTIVO', NULL),
(149, 'PRUEBA', 'PRUEBAA', 'FEMENINO', '0801-1887-88280', 'HONDUREÑA', 'SOLTERO', '2000-04-30', 1, 'ACTIVO', NULL),
(150, 'PRUEBAC', 'PRUEBAD', 'FEMENINO', '0801-1995-00433', 'HONDUREÑA', 'SOLTERO', '1995-04-15', 1, 'ACTIVO', NULL),
(151, 'Gabriel', 'Obando', 'Masculino', NULL, NULL, NULL, NULL, 2, NULL, NULL),
(152, 'Gabriel', 'Obando', 'MASCULINO', '0801199902356', 'HONDUREÑA', 'SOLTERO', '1997-02-05', 2, NULL, NULL),
(153, 'Helmer', 'Calix', 'Masculino', NULL, NULL, NULL, NULL, 2, NULL, NULL),
(154, 'Daniel Enrique ', 'Ramirez Rivera', 'Masculino', NULL, NULL, NULL, NULL, 2, NULL, NULL),
(155, 'CRISTIANO', 'RONALDO', 'MASCULINO', '44445', 'PORTUGUÉSA', 'UNION LIBRE', '1992-05-12', 1, 'ACTIVO', 1),
(156, 'KFSDLFKSD', 'KDFKDKFDKF', 'MASCULINO', '0801-1996-10578', 'HONDUREÑA', 'SOLTERO', '1996-05-28', 1, 'ACTIVO', NULL),
(157, 'Ever antonio', 'palada espinal', 'MASCULINO', '0801199610578', 'HONDUREÑA', 'SOLTERO', '1996-05-28', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_personas_extendidas`
--

CREATE TABLE `tbl_personas_extendidas` (
  `id_persona_ext` int(11) NOT NULL,
  `id_atributo` int(11) NOT NULL,
  `id_persona` bigint(16) NOT NULL DEFAULT 0,
  `valor` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_personas_extendidas`
--

INSERT INTO `tbl_personas_extendidas` (`id_persona_ext`, `id_atributo`, `id_persona`, `valor`) VALUES
(1, 11, 6, '20141011506'),
(16, 12, 22, '20211002890'),
(17, 12, 26, '20141010101'),
(18, 12, 27, '20151002890'),
(46, 1, 39, '14'),
(47, 3, 39, '2021-03-22'),
(126, 12, 61, '20101002890'),
(135, 12, 66, '20131015579'),
(136, 12, 74, '20102546957'),
(144, 12, 77, '20202020100'),
(152, 1, 80, '123000'),
(153, 3, 80, '2021-04-08'),
(154, 1, 81, '10000'),
(155, 3, 81, '2021-04-08'),
(156, 11, 81, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(157, 8, 81, '../curriculum_docentes/DFo_3_1_esp.pdf'),
(158, 1, 82, '123000'),
(159, 3, 82, '2021-04-08'),
(160, 11, 82, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(161, 8, 82, '../curriculum_docentes/DFo_3_1_esp.pdf'),
(162, 1, 83, '123000'),
(163, 3, 83, '2021-04-08'),
(164, 11, 83, '../Imagenes_Perfil_Docente/imagen01021905.jpeg'),
(165, 8, 83, '../curriculum_docentes/curriculum de prueba.pdf'),
(166, 1, 84, '123000'),
(167, 3, 84, '2021-04-08'),
(168, 11, 84, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(169, 8, 84, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(170, 1, 85, '123000'),
(171, 3, 85, '2021-04-08'),
(172, 11, 85, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(173, 8, 85, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(174, 1, 86, '123000'),
(175, 3, 86, '2021-04-08'),
(176, 11, 86, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(177, 8, 86, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(178, 1, 87, '123000'),
(179, 3, 87, '2021-04-07'),
(180, 11, 87, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(181, 8, 87, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(182, 1, 88, '123000'),
(183, 3, 88, '2021-04-08'),
(184, 11, 88, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(185, 8, 88, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(186, 1, 89, '123566'),
(187, 3, 89, '2021-04-08'),
(188, 11, 89, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(189, 8, 89, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(190, 1, 90, '123456'),
(191, 3, 90, '2021-04-08'),
(192, 11, 90, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(193, 8, 90, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(194, 1, 91, '123456'),
(195, 3, 91, '2021-04-08'),
(196, 11, 91, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(197, 8, 91, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(198, 1, 92, '345654'),
(199, 3, 92, '2021-04-08'),
(200, 11, 92, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(201, 8, 92, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(202, 1, 93, '123455'),
(203, 3, 93, '2021-04-08'),
(204, 11, 93, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(205, 8, 93, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(206, 1, 94, '123476'),
(207, 3, 94, '2021-04-08'),
(208, 11, 94, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(209, 8, 94, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(210, 1, 95, '123876'),
(211, 3, 95, '2021-04-08'),
(212, 11, 95, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(213, 8, 95, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(214, 1, 96, '567890'),
(215, 3, 96, '2021-04-08'),
(216, 11, 96, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(217, 8, 96, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(218, 1, 97, '565789'),
(219, 3, 97, '2021-04-08'),
(220, 11, 97, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(221, 8, 97, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(222, 1, 98, '324345'),
(223, 3, 98, '2021-04-08'),
(224, 11, 98, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(225, 8, 98, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(226, 1, 99, '345678'),
(227, 3, 99, '2021-04-08'),
(228, 11, 99, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(229, 8, 99, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(230, 1, 100, '213456'),
(231, 3, 100, '2021-04-08'),
(232, 11, 100, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(233, 8, 100, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(234, 1, 101, '657879'),
(235, 3, 101, '2021-04-08'),
(236, 11, 101, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(237, 8, 101, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(238, 1, 102, '76890'),
(239, 3, 102, '2021-04-08'),
(240, 11, 102, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(241, 8, 102, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(242, 1, 103, '233445'),
(243, 3, 103, '2021-04-08'),
(244, 11, 103, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(245, 8, 103, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(246, 1, 104, '546567'),
(247, 3, 104, '2021-04-08'),
(248, 11, 104, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(249, 8, 104, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(250, 1, 105, '989023'),
(251, 3, 105, '2021-04-08'),
(252, 11, 105, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(253, 8, 105, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(254, 1, 106, '221111'),
(255, 3, 106, '2021-04-08'),
(256, 11, 106, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(257, 8, 106, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(258, 1, 107, '237654'),
(259, 3, 107, '2021-04-08'),
(260, 11, 107, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(261, 8, 107, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(262, 1, 108, '676890'),
(263, 3, 108, '2021-04-08'),
(264, 11, 108, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(265, 8, 108, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(266, 1, 109, '345465'),
(267, 3, 109, '2021-04-08'),
(268, 11, 109, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(269, 8, 109, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(270, 1, 110, '111111'),
(271, 3, 110, '2021-04-08'),
(272, 11, 110, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(273, 8, 110, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(274, 1, 111, '567611'),
(275, 3, 111, '2021-04-08'),
(276, 11, 111, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(277, 8, 111, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(278, 1, 112, '555555'),
(279, 3, 112, '2021-04-08'),
(280, 11, 112, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(281, 8, 112, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(282, 1, 113, '777777'),
(283, 3, 113, '2021-04-08'),
(284, 11, 113, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(285, 8, 113, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(286, 1, 114, '888888'),
(287, 3, 114, '2021-04-08'),
(288, 11, 114, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(289, 8, 114, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(290, 1, 115, '888888'),
(291, 3, 115, '2021-04-08'),
(292, 11, 115, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(293, 8, 115, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(295, 1, 116, '124325'),
(296, 3, 116, '2021-04-08'),
(297, 11, 116, '../Imagenes_Perfil_Docente/perfil_docente2.jpg'),
(298, 8, 116, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(299, 1, 117, '111111'),
(300, 3, 117, '2021-04-08'),
(301, 11, 117, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(302, 8, 117, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(303, 1, 118, '555555'),
(304, 3, 118, '2021-04-08'),
(305, 11, 118, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(306, 8, 118, '../curriculum_docentes/DFo_3_2_esp.pdf'),
(349, 12, 130, '20211000612'),
(428, 14, 104, 'SI'),
(429, 14, 14, 'NO'),
(430, 14, 15, 'NO'),
(431, 14, 16, 'NO'),
(432, 14, 17, 'NO'),
(433, 14, 18, 'NO'),
(434, 14, 19, 'NO'),
(435, 14, 23, 'NO'),
(436, 14, 24, 'NO'),
(437, 14, 63, 'NO'),
(438, 14, 80, 'NO'),
(439, 14, 81, 'NO'),
(440, 14, 82, 'NO'),
(441, 14, 83, 'NO'),
(442, 14, 84, 'NO'),
(443, 14, 85, 'NO'),
(444, 14, 86, 'NO'),
(445, 14, 87, 'NO'),
(446, 14, 88, 'NO'),
(447, 14, 89, 'NO'),
(448, 14, 90, 'NO'),
(449, 14, 91, 'NO'),
(450, 14, 92, 'NO'),
(451, 14, 93, 'NO'),
(452, 14, 94, 'NO'),
(453, 14, 95, 'NO'),
(454, 14, 96, 'NO'),
(455, 14, 97, 'NO'),
(456, 14, 98, 'NO'),
(457, 14, 99, 'NO'),
(458, 14, 100, 'NO'),
(459, 14, 101, 'NO'),
(460, 14, 102, 'NO'),
(461, 14, 103, 'NO'),
(462, 14, 104, 'NO'),
(463, 14, 105, 'NO'),
(464, 14, 106, 'NO'),
(465, 14, 107, 'NO'),
(466, 14, 108, 'NO'),
(467, 14, 109, 'NO'),
(468, 14, 110, 'NO'),
(469, 14, 111, 'NO'),
(470, 14, 111, 'NO'),
(471, 14, 114, 'NO'),
(472, 14, 115, 'NO'),
(473, 14, 116, 'NO'),
(474, 14, 117, 'NO'),
(475, 14, 118, 'NO'),
(476, 1, 148, '121212'),
(477, 14, 148, 'NO'),
(478, 3, 148, '2021-04-27'),
(479, 11, 148, '../Imagenes_Perfil_Docente/perfil_docente.jpg'),
(480, 8, 148, '../curriculum_docentes/DFo_2_5_esp.pdf'),
(481, 1, 149, '56'),
(482, 14, 149, 'SI'),
(483, 3, 149, '2021-04-30'),
(484, 11, 149, '../Imagenes_Perfil_Docente/carmen villalobos.jpg'),
(485, 1, 150, '50'),
(486, 14, 150, 'SI'),
(487, 3, 150, '2021-04-30'),
(488, 8, 150, '../curriculum_docentes/curriculum de prueba.docx'),
(489, 12, 151, '20141002205'),
(490, 12, 152, '20141002205'),
(491, 12, 153, '20131015093'),
(492, 12, 154, '20161002890'),
(493, 1, 155, '999899'),
(494, 14, 155, 'NO'),
(495, 3, 155, '2021-05-20'),
(496, 11, 155, '../Imagenes_Perfil_Docente/cristiano.jpg'),
(497, 8, 155, '../curriculum_docentes/DFo_2_2_Practice_esp.pdf'),
(498, 12, 3, '20134525694'),
(499, 1, 156, '86'),
(500, 14, 156, 'NO'),
(501, 3, 156, '2021-07-01'),
(502, 8, 156, '../curriculum_docentes/INFORME DE AVANCE.docx'),
(503, 11, 156, '../Imagenes_Perfil_Docente/10701487_jesucristo-a-t');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_plan_estudio`
--

CREATE TABLE `tbl_plan_estudio` (
  `id_plan_estudio` bigint(20) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `num_clases` int(11) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `codigo_plan` varchar(50) DEFAULT NULL,
  `plan_vigente` varchar(50) DEFAULT NULL,
  `id_tipo_plan` bigint(20) DEFAULT NULL,
  `Creado_por` varchar(50) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `modificado_por` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_plan_estudio`
--

INSERT INTO `tbl_plan_estudio` (`id_plan_estudio`, `nombre`, `num_clases`, `fecha_creacion`, `codigo_plan`, `plan_vigente`, `id_tipo_plan`, `Creado_por`, `fecha_modificacion`, `modificado_por`) VALUES
(1, 'plan 1', 52, '2021-05-27', 'PLAN1', 'SI', 1, NULL, '2021-06-01', 'ADMIN'),
(2, 'plan 2', 52, '2021-05-29', 'PLAN2', 'NO', 1, NULL, NULL, NULL),
(3, 'plan 3', 52, '2021-05-31', 'PLAN3', 'NO', 1, NULL, NULL, NULL),
(4, 'q', 12, '2021-05-31', 'q', '', 1, NULL, NULL, NULL),
(5, 'plan 4', 12, '2021-05-31', 'IA-160', 'NO', 1, NULL, NULL, NULL),
(6, 'plan 5', 32, '2021-05-31', 'IA-1456', 'NO', 1, NULL, NULL, NULL),
(7, 'plan 6', 12, '2021-05-31', 'aaaaaa', 'NO', 1, NULL, NULL, NULL),
(8, 'e', 1, '2021-05-31', 'q', 'NO', 1, NULL, NULL, NULL),
(9, 'ii', 2, '2021-05-31', 'qq', 'NO', 1, 'ADMIN', NULL, NULL),
(10, 'ff', 11, '2021-05-31', 'iajj', 'NO', 1, 'ADMIN', NULL, NULL),
(11, 'ww', 52, '2021-05-31', 'ww', 'NO', 1, 'ADMIN', '2021-06-01', 'ADMIN'),
(12, 'oo', 22, '2021-05-31', 'aa', 'NO', 1, 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_practica_estudiantes`
--

CREATE TABLE `tbl_practica_estudiantes` (
  `Id_practica` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `Id_empresa` bigint(255) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finaliza` date DEFAULT NULL,
  `horas` varchar(255) DEFAULT NULL,
  `docente_supervisor` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_practica_estudiantes`
--

INSERT INTO `tbl_practica_estudiantes` (`Id_practica`, `id_persona`, `Id_empresa`, `fecha_inicio`, `fecha_finaliza`, `horas`, `docente_supervisor`, `estado`) VALUES
(13, 22, 17, '2021-03-01', '2021-07-22', '400', '21', 1),
(14, 26, 18, '2021-03-19', '2021-03-20', '800', '21', 1),
(15, 27, 19, '2021-03-01', '2021-07-22', '800', 'DANIEL ENRIQUE', NULL),
(16, 153, 20, '2021-03-24', '2021-09-11', NULL, '18', NULL),
(17, 130, 23, '2021-06-24', '2021-12-01', '400', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_practica_rechazo`
--

CREATE TABLE `tbl_practica_rechazo` (
  `id_practica_rechazo` bigint(20) NOT NULL,
  `id_persona` bigint(20) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `motivo` text NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_practica_rechazo`
--

INSERT INTO `tbl_practica_rechazo` (`id_practica_rechazo`, `id_persona`, `nombre_empresa`, `motivo`, `fecha_creacion`) VALUES
(1, 1, '	UNAH CURLA', ' LO SENTIMOS NO CUMPLE CON LOS REQUISITOS', '2020-06-24 23:37:48'),
(3, 1, '	UNAH CURLA', ' VJHV VJHVGHJVH GHGHFHGF FHFHFHF HGFHGF', '2020-06-25 00:25:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pref_area_docen`
--

CREATE TABLE `tbl_pref_area_docen` (
  `id_pref_area_doce` bigint(20) NOT NULL,
  `id_persona` bigint(16) DEFAULT NULL,
  `id_area` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pref_asig_docen`
--

CREATE TABLE `tbl_pref_asig_docen` (
  `id_pref_asig_docen` bigint(16) NOT NULL,
  `id_persona` bigint(16) DEFAULT NULL,
  `Id_asignatura` bigint(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_preguntas`
--

CREATE TABLE `tbl_preguntas` (
  `Id_pregunta` bigint(16) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `estado` int(1) NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `Creado_por` varchar(255) NOT NULL,
  `Modificado_por` varchar(255) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_preguntas`
--

INSERT INTO `tbl_preguntas` (`Id_pregunta`, `pregunta`, `estado`, `Fecha_creacion`, `Creado_por`, `Modificado_por`, `Fecha_modificacion`) VALUES
(13, 'COMIDA FAVORITA', 1, '2020-05-13 17:08:09', 'admin', NULL, NULL),
(43, 'PRIMER AUTOMOVIL', 1, '2020-05-17 21:18:55', 'admin', NULL, NULL),
(52, 'NOMBRE DE TU MASCOTA', 1, '2020-05-24 00:00:00', 'admin', 'ADMIN', '2020-05-24 18:04:18'),
(53, 'EQUIPO FAVORITO', 1, '2020-06-03 21:59:53', 'ADMIN', NULL, NULL),
(54, 'BEBIDA FAVORITA', 0, '2020-06-03 22:01:58', 'ADMIN', NULL, NULL),
(55, 'ACTIVIDAD FAVORITA JKJK', 1, '2020-06-03 22:02:59', 'ADMIN', 'ADMIN', '2021-05-06 03:39:16'),
(56, 'CUAL ES TU COLOR FAVORITO', 1, '2020-08-05 16:11:47', 'ADMIN', NULL, NULL),
(57, 'FRUTA FAVORITA', 1, '2020-08-20 22:11:08', 'RCORRALES', NULL, NULL),
(58, 'QUE EDAD TIENES', 1, '2021-03-24 16:04:11', 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_preguntas_seguridad`
--

CREATE TABLE `tbl_preguntas_seguridad` (
  `Id_pregunta_seguridad` bigint(16) NOT NULL,
  `Respuesta` varchar(255) NOT NULL,
  `Fecha_creacion` varchar(255) NOT NULL,
  `Id_pregunta` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_preguntas_seguridad`
--

INSERT INTO `tbl_preguntas_seguridad` (`Id_pregunta_seguridad`, `Respuesta`, `Fecha_creacion`, `Id_pregunta`, `Id_usuario`) VALUES
(3, 'SI', '', 13, 1),
(7, 'SI', '', 43, 1),
(54, 'SI', '', 52, 1),
(55, 'SUBARU ', '', 43, 12),
(56, 'CARNE AZADA', '', 13, 9),
(57, 'DOGUI', '', 52, 9),
(58, 'FCB', '', 53, 3),
(59, 'HONDA', '', 43, 3),
(60, 'VERDE', '', 56, 3),
(61, 'BONO', '', 52, 12),
(62, 'MOTAGUA', '', 53, 12),
(63, 'REAL MADRID', '', 53, 4),
(64, 'PESCADO', '', 13, 4),
(65, 'AGUA', '', 54, 4),
(66, 'CRATO', '', 52, 11),
(67, 'OLIMPIA', '', 53, 11),
(68, 'CHINA', '', 13, 11),
(69, 'COCO', '', 52, 19),
(70, 'HOLA', '', 53, 19),
(71, 'COCO', '', 13, 19),
(72, 'PIZZA', '', 13, 24),
(73, 'FORD', '', 43, 24),
(74, 'COCO', '', 52, 24),
(75, 'PIZZA', '', 13, 27),
(76, 'COCO', '', 52, 27),
(77, 'OLIMPIA', '', 53, 27),
(78, 'PIZZA', '', 13, 28),
(79, 'FUTBOL', '', 55, 28),
(80, 'NEGRO', '', 56, 28),
(81, 'MUSTANG', '', 43, 29),
(82, 'UVAS', '', 57, 29),
(83, 'ROJO', '', 56, 29),
(84, 'ARROZ', '', 13, 31),
(85, 'RAMBO', '', 52, 31),
(86, 'MORADO', '', 56, 31),
(87, 'PIZZA', '', 13, 40),
(88, 'COCO', '', 52, 40),
(89, 'UVAS', '', 57, 40),
(90, 'MAZDA', '', 43, 41),
(91, 'OLIMPIA', '', 53, 41),
(92, 'ROJO', '', 56, 41),
(93, 'PIZZA', '', 13, 42),
(94, 'COCO', '', 52, 42),
(95, 'ROJO', '', 56, 42),
(96, 'PIZZA', '', 13, 43),
(97, 'OLIMPIA', '', 53, 43),
(98, 'ROJO', '', 56, 43),
(99, 'PIZZA', '', 13, 2),
(100, 'ROJO', '', 53, 2),
(101, 'ROJO', '', 56, 2),
(102, 'PIZZA', '', 13, 52),
(103, 'COCO', '', 52, 52),
(104, 'ROJO', '', 56, 52),
(105, 'DDD', '', 13, 53),
(106, 'DDD', '', 43, 53),
(107, 'XD', '', 53, 53),
(108, 'PIZZA', '', 13, 54),
(109, 'PEPSI', '', 54, 54),
(110, 'CORRER', '', 55, 54),
(111, 'PIZZA', '', 13, 58),
(112, 'COCO', '', 52, 58),
(113, 'CORRER', '', 55, 58),
(114, 'SUBARU ', '', 43, 49),
(115, 'BONO', '', 52, 49),
(116, 'MANGO', '', 57, 49),
(117, 'LANGOSTA', '', 13, 60),
(118, 'SANDIA', '', 57, 60),
(119, '32', '', 58, 60),
(126, 'YO', '', 13, 61),
(127, 'YO', '', 43, 61),
(128, 'YO', '', 52, 61),
(129, 'KIA', '', 43, 51),
(130, 'CHISPITA', '', 52, 51),
(131, 'ROJO', '', 56, 51),
(132, 'COCO', '', 13, 63),
(133, 'COCO', '', 43, 63),
(134, 'COCO', '', 52, 63),
(135, 'HAMBURGUESA', '', 13, 70),
(136, 'LANA', '', 52, 70),
(137, 'FUTBOL', '', 55, 70),
(138, 'SASA', '', 13, 71),
(139, 'SASA', '', 52, 71),
(140, 'SASA', '', 53, 71);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proyectos`
--

CREATE TABLE `tbl_proyectos` (
  `Id_proyecto` bigint(16) NOT NULL,
  `Id_tipo_v` bigint(16) NOT NULL,
  `Id_modalidad` bigint(16) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `codigo_proyecto` int(16) NOT NULL,
  `estado` int(2) NOT NULL,
  `beneficiarios_directos` bigint(16) NOT NULL,
  `beneficiarios_indirectos` bigint(16) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `nombre_contacto_institucional` varchar(255) NOT NULL,
  `cargo_contacto_institucional` varchar(255) NOT NULL,
  `telefono_contacto_institucional` varchar(50) NOT NULL DEFAULT '',
  `correo_contacto_institucional` varchar(255) NOT NULL,
  `cant_beneficiarios` bigint(16) NOT NULL,
  `fecha_inicio_ejecucion` datetime NOT NULL,
  `fecha_final_ejecucion` datetime NOT NULL,
  `fecha_inicio_evaluacion` datetime NOT NULL,
  `fecha_final_evaluacion` datetime NOT NULL,
  `costo` int(10) NOT NULL,
  `Fecha_creación` datetime NOT NULL,
  `Id_tipo_formalizacion` bigint(16) NOT NULL,
  `Id_aporte` bigint(16) NOT NULL,
  `region` varchar(255) NOT NULL,
  `departamento_pais` bigint(16) NOT NULL DEFAULT 0,
  `municipio` bigint(16) NOT NULL DEFAULT 0,
  `aldea_caserio` bigint(16) NOT NULL DEFAULT 0,
  `barrio_colonia` varchar(255) NOT NULL,
  `entidad_beneficiaria` varchar(255) NOT NULL,
  `objetivos_desarrollo` varchar(255) NOT NULL,
  `objetivos_inmediatos` varchar(255) NOT NULL,
  `resultados` varchar(255) NOT NULL,
  `actividades` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL,
  `tipo_proyecto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_proyectos`
--

INSERT INTO `tbl_proyectos` (`Id_proyecto`, `Id_tipo_v`, `Id_modalidad`, `nombre`, `codigo_proyecto`, `estado`, `beneficiarios_directos`, `beneficiarios_indirectos`, `nombre_empresa`, `nombre_contacto_institucional`, `cargo_contacto_institucional`, `telefono_contacto_institucional`, `correo_contacto_institucional`, `cant_beneficiarios`, `fecha_inicio_ejecucion`, `fecha_final_ejecucion`, `fecha_inicio_evaluacion`, `fecha_final_evaluacion`, `costo`, `Fecha_creación`, `Id_tipo_formalizacion`, `Id_aporte`, `region`, `departamento_pais`, `municipio`, `aldea_caserio`, `barrio_colonia`, `entidad_beneficiaria`, `objetivos_desarrollo`, `objetivos_inmediatos`, `resultados`, `actividades`, `departamento`, `tipo_proyecto`) VALUES
(46, 2, 1, 'PROBANDO PRUEBA', 323, 1, 3232, 2132, 'WEEW', 'DSD', 'EQWEQWE', ' 3231-2321', 'SDSAD@GMAIL.COM', 5364, '2021-06-10 00:00:00', '2021-06-24 00:00:00', '2021-06-10 00:00:00', '2021-06-24 00:00:00', 31234, '2021-06-01 21:31:05', 4, 2, 'DSDAD', 1, 3, 39, 'ASDAS', 'DASD', ' DASD', ' FDGFD', ' FDGF', ' GDFGFDGDF', 'ASDAS', 'ASDAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_requisito_asignatura`
--

CREATE TABLE `tbl_requisito_asignatura` (
  `id_requisito_asig` bigint(20) NOT NULL,
  `Id_asignatura` bigint(20) DEFAULT NULL,
  `asignatura_requisito` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_requisito_asignatura`
--

INSERT INTO `tbl_requisito_asignatura` (`id_requisito_asig`, `Id_asignatura`, `asignatura_requisito`) VALUES
(1, 9, 'IA-250'),
(2, 42, 'IA-255');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `Id_rol` bigint(16) NOT NULL,
  `Rol` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` int(1) NOT NULL,
  `Fecha_creacion` datetime DEFAULT NULL,
  `Creado_por` varchar(255) DEFAULT NULL,
  `Modificado_por` varchar(255) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_roles`
--

INSERT INTO `tbl_roles` (`Id_rol`, `Rol`, `descripcion`, `estado`, `Fecha_creacion`, `Creado_por`, `Modificado_por`, `Fecha_modificacion`) VALUES
(46, 'ADMIN', 'PRUEBA', 1, '2020-05-20 00:00:00', 'da', 'admin', '2020-05-22 20:45:47'),
(49, 'ESTUDIANTE', 'ES ESTUDIANTE', 1, '2020-06-11 00:19:42', 'ADMIN', NULL, NULL),
(51, 'PRUEBAE', 'DE PRUEBA', 1, '2020-08-05 16:38:41', 'ADMIN', NULL, NULL),
(53, 'OPERADOR', 'OPERADOR DE SOLICITUDES', 1, '2020-08-11 06:06:20', 'ADMIN', NULL, NULL),
(54, 'JEFE VINCULACION', 'JEFE DEL DEPTO DE VINCULACION', 1, '2020-08-18 16:43:56', 'ADMIN', NULL, NULL),
(55, 'VINCULACION', 'PERSONAL DE VINCULACION', 1, '2020-08-18 16:44:58', 'ADMIN', NULL, NULL),
(56, 'COORDINADORES', 'COORDINADORES DE CARRERA', 1, '2020-08-18 16:45:42', 'ADMIN', 'ADMIN', '2020-08-18 23:45:50'),
(57, 'COMITE AUTOMATIZACION', 'DOCENTES PERTENECIENTES COMITE', 1, '2020-08-18 16:46:57', 'ADMIN', NULL, NULL),
(59, 'PRACTICA PROFESIONAL', 'PRACTICA PROFESIONAL', 0, '2020-08-28 06:24:33', 'RCORRALES', NULL, NULL),
(61, 'PRUEBAEE', 'DF', 1, '2020-12-05 02:59:21', 'ADMIN', 'ADMIN', '2021-04-14 01:44:12'),
(62, 'PRUEBAX', 'PRUEBAX', 0, '2020-12-05 21:19:40', 'ADMIN', NULL, NULL),
(63, 'PRUEBAPRUEBA', 'PRUEBAS', 1, '2021-02-11 17:36:06', 'ADMIN', NULL, NULL),
(64, 'DOCENTE', 'prubando', 1, '2021-03-22 17:07:46', 'ADMIN', NULL, NULL),
(65, 'OPERATIVO', 'PAA EL PERSONAL OPERATIVO I', 1, '2021-04-04 18:22:31', 'RCORRALES', NULL, NULL),
(66, 'PRUEBAFINAL', 'FINAL FINAL', 1, '2021-04-14 00:27:34', 'ADMIN', NULL, NULL),
(67, 'PRUEBANINI', 'LLKJ', 1, '2021-04-14 01:40:32', 'ADMIN', 'ADMIN', '2021-04-14 01:41:18'),
(68, 'EJEMPLO', 'PRUEBA', 1, '2021-04-23 01:36:51', 'ADMIN', 'ADMIN', '2021-04-23 01:47:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_subida_documentacion`
--

CREATE TABLE `tbl_subida_documentacion` (
  `Id_subida` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_vinculacion` datetime DEFAULT NULL,
  `fecha_coordinacion` datetime DEFAULT NULL,
  `estado_vinculacion` int(1) DEFAULT NULL,
  `estado_coordinacion` int(1) DEFAULT NULL,
  `observacion_vinculacion` varchar(255) DEFAULT NULL,
  `motivo_coordinacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_subida_documentacion`
--

INSERT INTO `tbl_subida_documentacion` (`Id_subida`, `id_persona`, `fecha_creacion`, `fecha_vinculacion`, `fecha_coordinacion`, `estado_vinculacion`, `estado_coordinacion`, `observacion_vinculacion`, `motivo_coordinacion`) VALUES
(7, 6, '2021-03-12 19:57:53', '2021-03-13 22:29:23', '2021-03-13 22:45:15', 1, 1, 'SIN OBSERVACION', ' APROBADA'),
(8, 297, '2021-03-12 20:01:47', '2021-03-13 22:01:15', NULL, 1, NULL, 'SIN OBSERVACION', NULL),
(9, 337, '2021-03-14 00:56:07', '2021-03-14 01:06:34', '2021-03-14 01:08:12', 1, 1, 'SIN OBSERVACION', ' APROBADA'),
(10, 338, '2021-03-15 01:41:13', '2021-03-15 01:44:25', '2021-03-15 01:44:55', 1, 1, 'SIN OBSERVACION', ' APROBADA'),
(11, 341, '2021-03-16 15:27:55', '2021-03-16 15:33:45', '2021-03-16 15:35:26', 1, 1, 'SIN OBSERVACION', ' APROBADA'),
(12, 22, '2021-03-19 05:11:13', '2021-04-19 21:05:49', '2021-04-20 03:32:01', 1, 1, 'SIN OBSERVACION', ' '),
(13, 27, '2021-03-19 17:24:01', '2021-04-20 04:05:35', '2021-04-20 04:34:58', 1, 1, '', ' '),
(14, 130, '2021-04-19 21:03:22', '2021-04-20 04:04:56', '2021-05-31 19:12:33', 1, 1, '', ' ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_persona`
--

CREATE TABLE `tbl_tipos_persona` (
  `id_tipo_persona` int(11) NOT NULL DEFAULT 0,
  `tipo_persona` varchar(50) NOT NULL DEFAULT '',
  `descripcion` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_tipos_persona`
--

INSERT INTO `tbl_tipos_persona` (`id_tipo_persona`, `tipo_persona`, `descripcion`) VALUES
(1, 'DOCENTE', 'ingresado para prueba'),
(2, 'ESTUDIANTE', 'ingresado para prueba'),
(3, 'COORDINADOR', 'ingresado para prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipos_vinculacion`
--

CREATE TABLE `tbl_tipos_vinculacion` (
  `Id_tipo_v` bigint(16) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_tipos_vinculacion`
--

INSERT INTO `tbl_tipos_vinculacion` (`Id_tipo_v`, `tipo`, `Fecha_creacion`) VALUES
(1, 'EDUCACION Y CAPACITACION', '2020-05-31 00:00:00'),
(2, 'ASESORIA TECNICA', '2020-05-31 00:00:00'),
(3, 'ASISTENCIA DIRECTA', '2020-05-31 00:00:00'),
(4, 'INVESTIGACION APLICADA', '2020-05-31 00:00:00'),
(5, 'TRANSFERENCIA DE TECNOLOGIA', '2020-05-31 00:00:00'),
(6, 'USO DE CAPACIDADES INSTALADAS', '2020-05-31 00:00:00'),
(7, 'DIFUSION', '2020-05-31 00:00:00'),
(8, 'OTROS', '2020-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_asignatura`
--

CREATE TABLE `tbl_tipo_asignatura` (
  `id_tipo_asignatura` bigint(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_tipo_asignatura`
--

INSERT INTO `tbl_tipo_asignatura` (`id_tipo_asignatura`, `descripcion`) VALUES
(1, 'normal'),
(2, 'servicio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_aula`
--

CREATE TABLE `tbl_tipo_aula` (
  `id_tipo_aula` bigint(16) NOT NULL DEFAULT 0,
  `tipo_aula` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_tipo_aula`
--

INSERT INTO `tbl_tipo_aula` (`id_tipo_aula`, `tipo_aula`) VALUES
(0, 'laboratorio'),
(1, 'auditorio'),
(2, 'normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_contactos`
--

CREATE TABLE `tbl_tipo_contactos` (
  `id_tipo_contacto` bigint(16) NOT NULL,
  `descripcion` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_tipo_contactos`
--

INSERT INTO `tbl_tipo_contactos` (`id_tipo_contacto`, `descripcion`) VALUES
(1, 'TELEFONO CELULAR'),
(2, 'TELEFONO FIJO'),
(3, 'DIRECCION'),
(4, 'CORREO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_docente`
--

CREATE TABLE `tbl_tipo_docente` (
  `id_tipo_docente` int(11) NOT NULL,
  `tipo_docente` varchar(50) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_tipo_docente`
--

INSERT INTO `tbl_tipo_docente` (`id_tipo_docente`, `tipo_docente`, `descripcion`) VALUES
(1, 'SUED', ''),
(2, 'CU', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_formalizacion_proyecto`
--

CREATE TABLE `tbl_tipo_formalizacion_proyecto` (
  `Id_tipo_formalizacion` bigint(16) NOT NULL,
  `tipo_formalizacion` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_tipo_formalizacion_proyecto`
--

INSERT INTO `tbl_tipo_formalizacion_proyecto` (`Id_tipo_formalizacion`, `tipo_formalizacion`, `Fecha_creacion`) VALUES
(1, 'CONVENIO', '2020-05-31 00:00:00'),
(2, 'CARTA', '2020-05-31 00:00:00'),
(3, 'ACUERDO', '2020-05-31 00:00:00'),
(4, 'CARTA DE INTENCION', '2020-05-31 00:00:00'),
(5, 'CONTRATO', '2020-05-31 00:00:00'),
(6, 'OTROS', '2020-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_periodo`
--

CREATE TABLE `tbl_tipo_periodo` (
  `id_tipo_periodo` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `horas_validas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_tipo_periodo`
--

INSERT INTO `tbl_tipo_periodo` (`id_tipo_periodo`, `descripcion`, `horas_validas`) VALUES
(1, 'normal', 1),
(2, 'corto', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_plan`
--

CREATE TABLE `tbl_tipo_plan` (
  `id_tipo_plan` bigint(20) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_tipo_plan`
--

INSERT INTO `tbl_tipo_plan` (`id_tipo_plan`, `nombre`) VALUES
(1, 'PRUEBA 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `Id_usuario` bigint(16) NOT NULL,
  `id_persona` bigint(16) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Id_rol` bigint(16) NOT NULL,
  `estado` int(1) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Intentos` int(15) DEFAULT NULL,
  `Ultima_conexion` datetime DEFAULT NULL,
  `Fec_vence_contrasena` datetime DEFAULT NULL,
  `Fecha_creacion` varchar(255) DEFAULT NULL,
  `Creado_por` varchar(255) DEFAULT NULL,
  `Modificado_por` varchar(255) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`Id_usuario`, `id_persona`, `Usuario`, `Id_rol`, `estado`, `Contrasena`, `Intentos`, `Ultima_conexion`, `Fec_vence_contrasena`, `Fecha_creacion`, `Creado_por`, `Modificado_por`, `Fecha_modificacion`) VALUES
(1, 6, 'ADMIN', 46, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, '2020-09-21 00:00:00', '2023-11-29 10:13:57', '2020-09-21 00:00:00', NULL, 'ADMIN', '2021-04-14 01:52:38'),
(2, 20, 'ANDERMFL', 46, 1, 'SHcwQVp4OEFBeFZuM3B5SUpiSzQ0UT09', 0, NULL, '2022-03-18 21:22:59', NULL, NULL, NULL, NULL),
(43, 22, 'LVILLATORO', 49, 1, 'MjZROTgrU3RPV3pLMVNVNTEwSXU4QT09', 0, NULL, '2021-05-31 18:11:08', '2021-03-18 23:17:10', NULL, NULL, NULL),
(45, 14, 'SQUAN', 55, 2, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(46, 15, 'EREYES', 55, 2, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(47, 16, 'CSABILLON', 55, 2, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(48, 17, 'NDIAZ', 64, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(49, 18, 'RCORRALES', 46, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(50, 19, 'MVILLALONGA', 46, 2, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(51, 23, 'DFIALLOS', 56, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(52, 21, 'DRAMIREZ', 55, 1, 'SHcwQVp4OEFBeFZuM3B5SUpiSzQ0UT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-18', 'ADMIN', NULL, NULL),
(53, 23, 'SRAMIREZ', 64, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2021-03-19 16:27:55', '2021-03-19 16:27:55', NULL, NULL, NULL),
(54, 27, 'EALVARENGA', 49, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2021-03-19 17:07:29', '2021-03-19 17:07:29', NULL, NULL, NULL),
(55, 10, 'FANY', 64, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 61, 'ERIVERA', 49, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2021-03-23 22:18:39', '2021-03-23 22:18:39', NULL, NULL, NULL),
(59, 24, 'GSCALICI', 64, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-25 00:00:00', 'ADMIN', NULL, NULL),
(60, 63, 'LFIALLOS', 46, 2, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-12-30 00:00:00', '2021-03-25 00:00:00', 'ADMIN', NULL, NULL),
(61, 77, 'HPONCE', 49, 2, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2021-04-06 19:09:57', '2021-04-06 19:09:57', NULL, NULL, NULL),
(63, 130, 'ERIVERA', 49, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2021-04-19 20:53:49', '2021-04-19 20:53:49', NULL, NULL, NULL),
(64, 23, 'DCID', 56, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, '2021-04-30 11:10:27', '2023-11-29 10:13:57', NULL, 'ADMIN', NULL, NULL),
(65, 23, 'MCID', 64, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-04-30 11:22:12', NULL, NULL, NULL, NULL),
(66, 83, 'DROVELO', 64, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-04-30 11:46:12', NULL, NULL, NULL, NULL),
(69, 148, 'PRUEBA', 64, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2022-04-30 13:37:38', NULL, NULL, NULL, NULL),
(70, 151, 'GOBANDO', 49, 1, 'amhEMEVzRmRHUWF5OTk5dERDRzlMQT09', 0, NULL, '2021-05-18 17:10:27', '2021-05-18 17:10:27', NULL, NULL, NULL),
(71, 153, 'HCALIX', 49, 1, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2021-05-19 17:58:30', '2021-05-19 17:58:30', NULL, NULL, NULL),
(72, 154, 'DRAMIREZ', 49, 2, 'RE9mSEpzSGJpQnAvTXpDUEdtZTFvUT09', 0, NULL, '2021-05-26 05:12:49', '2021-05-26 05:12:49', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_actividades`
--

CREATE TABLE `tbl_voae_actividades` (
  `id_actividad_voae` bigint(20) NOT NULL COMMENT 'Campo llave - índice de la tabla',
  `no_solicitud` varchar(10) DEFAULT NULL COMMENT 'Asignación de Número de Actividad aprobada',
  `fch_solicitud` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nombre_actividad` varchar(45) NOT NULL,
  `ubicacion` varchar(50) NOT NULL COMMENT 'Ubicación del lugar donde se desarollará la Actividad',
  `fch_inicial_actividad` date NOT NULL COMMENT 'Fecha y hora que da inicio la actividad que se está registrando',
  `fch_final_actividad` date NOT NULL COMMENT 'Fecha y hora que finaliza la actividad que se está registrando',
  `descripcion` varchar(200) NOT NULL COMMENT 'Detalles sobre la actividad que se registra.',
  `poblacion_objetivo` varchar(50) NOT NULL COMMENT 'Detalla el público objetivo de la actividad',
  `presupuesto` decimal(10,0) NOT NULL COMMENT 'Monto presupuestado requerido para el desarrollo de la actividad.',
  `staff_alumnos` varchar(100) NOT NULL COMMENT 'Listado de Estudiantes que colaboran en la organizacion de la actividad.',
  `observaciones` varchar(100) DEFAULT NULL COMMENT 'Comentarios extras a considerar en el regitro de la actividad.',
  `id_estado` bigint(20) NOT NULL DEFAULT 0 COMMENT 'FK - indice que hace referencia l PK de la tabla de estados',
  `id_usuario_registro` bigint(20) NOT NULL DEFAULT 0 COMMENT 'FK - indice que hace referencia al PK de la tabla de usuarios para identificar el usuario que realiza el registro.',
  `id_ambito` bigint(20) NOT NULL DEFAULT 0 COMMENT 'FK - indice que hace referencia al PK de la tabla de ambitos.',
  `periodo` varchar(50) NOT NULL,
  `tipo_actividad` varchar(55) NOT NULL DEFAULT 'ACTIVIDAD INTERNA',
  `condicion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla que registra las actividades VOAE del Comite de Vida Estudiantil';

--
-- Volcado de datos para la tabla `tbl_voae_actividades`
--

INSERT INTO `tbl_voae_actividades` (`id_actividad_voae`, `no_solicitud`, `fch_solicitud`, `nombre_actividad`, `ubicacion`, `fch_inicial_actividad`, `fch_final_actividad`, `descripcion`, `poblacion_objetivo`, `presupuesto`, `staff_alumnos`, `observaciones`, `id_estado`, `id_usuario_registro`, `id_ambito`, `periodo`, `tipo_actividad`, `condicion`) VALUES
(65, '22', '2021-09-20 09:23:13', 'CULTURA', 'UNAH', '2021-08-03', '2021-08-05', 'PRUEBA', '500', '3000', 'JUAN, PEDRO', 'NINGUNA', 6, 1, 23, 'SEGUNDO PERIODO', 'ACTIVIDAD INTERNA', 1),
(66, '2', '2021-08-06 19:29:20', 'INFORMATICA ADMINISTRATIVA', 'UNAH', '2021-08-07', '2021-08-05', 'PRUEBA', '500', '3000', 'JUAN, PEDRO', 'NINGUNA', 6, 1, 5, 'PRIMER PERIODO', 'ACTIVIDAD INTERNA', 1),
(72, '13', '2021-08-15 19:06:10', 'DEPORTES', 'UNAH', '2021-08-10', '2021-08-24', 'PRUEBA', '500', '3000', 'JUAN, PEDRO', 'NINGUNA', 7, 1, 5, 'SEGUNDO PERIODO', 'ACTIVIDAD INTERNA', 0),
(105, '2', '2021-09-20 09:21:19', 'DFDSFSD', 'UNAH', '2021-08-14', '2021-08-24', 'PROBANDO ACTIVIDAD', '500', '3000', 'INGENIERIA ELECTRICA', 'por falta de tiempo', 6, 1, 23, 'PRIMER PERIODO', 'ACTIVIDAD INTERNA', 1),
(106, '13', '2021-09-20 09:15:39', 'CULTURA', 'UNAH', '2021-08-13', '2021-08-25', 'PROBANDO ACTIVIDAD', '500', '3000', 'AMBIENTAL', 'NINGUNA', 7, 1, 23, 'SEGUNDO PERIODO', 'ACTIVIDAD INTERNA', 0),
(107, '13', '2021-08-15 19:01:50', 'TORNEO VOLEIBOL', 'UNAH', '2021-08-16', '2021-08-24', 'PROBANDO ACTIVIDAD', '500', '3000', 'JUAN, PEDRO', 'NINGUNA', 7, 1, 5, 'PRIMER PERIODO', 'ACTIVIDAD INTERNA', 0),
(108, '15', '2021-09-20 14:10:38', 'ACTIVIDAD DE BAILE', 'UNAH', '2021-08-18', '2021-08-31', 'GFGFGDFG', '500', '3000', 'JUAN, PEDRO', 'NINGUNA', 6, 59, 23, 'Primer Periodo', 'ACTIVIDAD INTERNA', 1),
(109, '13', '2021-08-16 20:10:24', 'PRUEBA', 'CIIE', '2021-08-18', '2021-08-26', '0', '500', '3000', 'JUAN, PEDRO', 'NINGUNA', 2, 1, 23, '0', 'ACTIVIDAD INTERNA', 0),
(110, '15', '2021-09-20 14:05:10', 'ACTIVIDAD DE BAILE', 'UNAH', '2021-08-18', '2021-08-31', '0', '500', '3000', 'JUAN, PEDRO', 'NINGUNA', 7, 59, 23, '0', 'ACTIVIDAD INTERNA', 0),
(111, '32', '2021-09-20 09:07:30', 'CULTURA', 'CIIE', '2021-08-19', '2021-08-30', '0', '500', '500', 'JUAN, PEDRO', 'NINGUNA', 2, 53, 23, '0', 'ACTIVIDAD INTERNA', 0),
(112, NULL, '2021-08-24 17:45:55', 'CULTURADSDS', '', '0000-00-00', '0000-00-00', '', '', '0', 'VOAE', NULL, 6, 1, 1, 'TERCER PERIODO', 'ACTIVIDAD EXTERNA', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_ambitos`
--

CREATE TABLE `tbl_voae_ambitos` (
  `id_ambito` bigint(20) NOT NULL,
  `nombre_ambito` varchar(25) NOT NULL COMMENT 'Nombre del ámbito',
  `descripcion_ambito` varchar(200) NOT NULL COMMENT 'Descripción del ámbito, con ejemplos de alguna actividad relacionada.',
  `condicion` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar los tipos de ámbitos al que puede pertenecer una actividad del CVE-VOAE.';

--
-- Volcado de datos para la tabla `tbl_voae_ambitos`
--

INSERT INTO `tbl_voae_ambitos` (`id_ambito`, `nombre_ambito`, `descripcion_ambito`, `condicion`) VALUES
(1, 'SOCIAL', 'PROBANDO AMBITOS', 1),
(5, 'DEPORTIVO', 'PRUEBA AMBITO', 1),
(23, 'CULTURAL-ARTÍSTICO', 'GFGFG', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_asistencias`
--

CREATE TABLE `tbl_voae_asistencias` (
  `id_asistencia` bigint(20) NOT NULL,
  `id_actividad_voae` bigint(20) NOT NULL COMMENT 'Identificador de la actividad que se está asignando asistencia.',
  `cuenta` varchar(55) NOT NULL DEFAULT '' COMMENT 'No. cuenta del alumno',
  `nombre_alumno` varchar(55) NOT NULL DEFAULT '' COMMENT 'Nombre del Alumno',
  `cant_horas` decimal(10,0) NOT NULL COMMENT 'Cantidad de horas que se le asignan al alumno por participar en la actividad.',
  `carrera` varchar(80) NOT NULL DEFAULT '' COMMENT 'Carrera a la que pertenece el alumno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla para llevar registro de las asistencias de los estudiantes a las actividades del CVE';

--
-- Volcado de datos para la tabla `tbl_voae_asistencias`
--

INSERT INTO `tbl_voae_asistencias` (`id_asistencia`, `id_actividad_voae`, `cuenta`, `nombre_alumno`, `cant_horas`, `carrera`) VALUES
(454, 65, '20131014386', 'BRAYAN ALEJANDRO CENTENO ROSALES', '8', 'ADMINISTRACION ADUANERA'),
(455, 65, '20131016521', 'ZULMA ARACELY VALLECIO UMANZOR', '7', 'CONTADURIA PUBLICA Y FINANZAS'),
(456, 65, '20141003016', 'ANDREA PAOLA PORTILLO COELLO', '8', 'ADMINISTRACION ADUANERA'),
(457, 65, '20141010388', 'DELSY ZUGELY GONZALES ESPINAL', '8', 'COMERCIO INTERNACIONAL'),
(458, 65, '20151000158', 'CARLOS EDUARDO ALVAREZ', '8', 'ADMINISTRACION ADUANERA'),
(459, 65, '20151000349', 'JORGE ALFONSO BACA FLORES', '8', 'INFORMATICA ADMINISTRATIVA'),
(460, 65, '20151003274', 'LUIS ALEXANDER MORAN TORRES', '8', 'INFORMATICA ADMINISTRATIVA'),
(461, 65, '20151003957', 'IVIS JANCARLO PINEDA BANEGAS', '8', 'INFORMATICA ADMINISTRATIVA'),
(462, 65, '20151004130', 'ARLYS LARISSA MEZA ALMENDAREZ', '8', 'ADMINISTRACION ADUANERA'),
(463, 65, '20151004328', 'MIRIAN YANETH REYES GODOY', '8', 'INFORMATICA ADMINISTRATIVA'),
(464, 65, '20151004576', 'EDER JOEL HERNANDEZ CALDERON', '8', 'ECONOMIA'),
(465, 65, '20151005546', 'LEONARDO ARTURO CENTENO PAVON', '8', 'INFORMATICA ADMINISTRATIVA'),
(466, 65, '20151021130', 'LUIS EDUARDO GARCIA MENDEZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(467, 65, '20151021564', 'ANTHONY JAVIER LOPEZ GARAY', '8', 'ADMINISTRACION ADUANERA'),
(468, 65, '20151031250', 'ELBA FABIOLA SUAZO AGUILERA', '7', 'ADMINISTRACION ADUANERA'),
(469, 65, '20152030631', 'AMILCAR AYARI NUÑEZ RODRIGUEZ', '8', 'ADMINISTRACION ADUANERA'),
(470, 65, '20161000113', 'CARMEN ELIZABETH BACA GONZALEZ', '7', 'ADMINISTRACION ADUANERA'),
(471, 65, '20161002475', 'DANIA LISETH LEMUS LEMUS', '8', 'ECONOMIA'),
(472, 65, '20161002731', 'ERIK FERNANDO GUTIERREZ MANZANARES', '7', 'ADMINISTRACION ADUANERA'),
(473, 65, '20161003679', 'LINDA CECILIA VILLATORO HERNANDEZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(474, 65, '20161003774', 'DEYSI RAQUEL ZEPEDA CRUZ', '8', 'COMERCIO INTERNACIONAL'),
(475, 65, '20161004548', 'ANDRES EDUARDO OCHOA ARANDA', '8', 'ADMINISTRACION ADUANERA'),
(476, 65, '20161005026', 'DIANA CAROLINA AMADOR CORRALES', '7', 'COMERCIO INTERNACIONAL'),
(477, 65, '20161005222', 'BELKIS NOHELIA DIAZ FUENTES', '7', 'ECONOMIA'),
(478, 65, '20161005285', 'JENNIFER AZUCENA CLAROS FLORES', '8', 'INFORMATICA ADMINISTRATIVA'),
(479, 65, '20161030222', 'JEFFRY JOSEPH AGUILAR CORRALES', '8', 'INFORMATICA ADMINISTRATIVA'),
(480, 65, '20161030540', 'JENNY NOHEMY CRUZ AVILA', '8', 'INFORMATICA ADMINISTRATIVA'),
(481, 65, '20161030758', 'ALEXA FERNANDA FLORES AGUILAR', '8', 'ADMINISTRACION ADUANERA'),
(482, 65, '20161030913', 'DANIEL ARTURO LOBO CERNA', '8', 'ECONOMIA'),
(483, 65, '20161031104', 'DANIELA BRIYITH MENDOZA GOMEZ', '8', 'COMERCIO INTERNACIONAL'),
(484, 65, '20161031471', 'JORDY FERNANDO PADILLA LICONA', '8', 'INFORMATICA ADMINISTRATIVA'),
(485, 65, '20161031659', 'NOELIA VANESA RAMOS RODRIGUEZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(486, 65, '20161031741', 'LUIS FERNANDO SANCHEZ VALLADARES', '8', 'INFORMATICA ADMINISTRATIVA'),
(487, 65, '20161031941', 'LUIS FERNANDO VILLALTA ALFARO', '8', 'INFORMATICA ADMINISTRATIVA'),
(488, 65, '20161032555', 'BRAYAN ISAIAS AMAYA AMADOR', '7', 'ADMINISTRACION ADUANERA'),
(489, 65, '20171000119', 'ALLAN LEONEL BONILLA GALEANO', '7', 'ADMINISTRACION ADUANERA'),
(490, 65, '20171000490', 'DARIELA SOFIA CACERES HERNANDEZ', '8', 'ECONOMIA'),
(491, 65, '20171000658', 'ERICK DAVID CASTILLO MENDOZA', '8', 'ADMINISTRACION ADUANERA'),
(492, 65, '20171000783', 'DANIELA MICHELLE MEZA CARDONA', '7', 'ECONOMIA'),
(493, 65, '20171000803', 'LUIS FERNANDO MEJIA CRUZ', '7', 'INFORMATICA ADMINISTRATIVA'),
(494, 65, '20171000851', 'JEIMY NICOLLE BORGES LARIOS', '8', 'ADMINISTRACION ADUANERA'),
(495, 65, '20171001102', 'CARLOS OMAR GUEVARA AVELAR', '8', 'ADMINISTRACION ADUANERA'),
(496, 65, '20171001597', 'ALEJANDRO JOSE LAGOS CALIX', '8', 'ECONOMIA'),
(497, 65, '20171001652', 'ANDREA POLET LOPEZ REYES', '8', 'ADMINISTRACION ADUANERA'),
(498, 65, '20171001853', 'DIANA CAROLINA HENRIQUEZ LOPEZ', '8', 'COMERCIO INTERNACIONAL'),
(499, 65, '20171002045', 'MARIO DAVID MORAZAN LOPEZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(500, 65, '20171002196', 'ISIS MABEL MARTINEZ AMADOR', '8', 'INFORMATICA ADMINISTRATIVA'),
(501, 65, '20171002335', 'MAILYN LUCIA MARTINEZ PINEDA', '8', 'INFORMATICA ADMINISTRATIVA'),
(502, 65, '20171003205', 'DAYSI SARAI ORTEGA PONCE', '7', 'ADMINISTRACION ADUANERA'),
(503, 65, '20171003514', 'JOHANN RANSES FLORES ROMERO', '7', 'INFORMATICA ADMINISTRATIVA'),
(504, 65, '20171003565', 'MAURA ISABEL RODRIGUEZ OLIVA', '7', 'INFORMATICA ADMINISTRATIVA'),
(505, 65, '20171004284', 'HAROL DIDIER AMADOR VALLE', '7', 'ADMINISTRACION ADUANERA'),
(506, 65, '20171004396', 'CINTYA DANIELA COLINDRES CARRANZA', '8', 'ADMINISTRACION ADUANERA'),
(507, 65, '20171004457', 'ALEJANDRA SARAHI ZELAYA SALGADO', '8', 'ECONOMIA'),
(508, 65, '20171005087', 'JESSI MAYLIN ESTRADA MALDONADO', '8', 'INFORMATICA ADMINISTRATIVA'),
(509, 65, '20171005100', 'CINDY MARIELA PORTILLO SALGADO', '7', 'ECONOMIA'),
(510, 65, '20171005216', 'JAFET AXIEL ESPINO CARRASCO', '8', 'INFORMATICA ADMINISTRATIVA'),
(511, 65, '20171005336', 'ABEL JOSUE PEREZ LOPEZ', '8', 'ECONOMIA'),
(512, 65, '20171005416', 'MIGUEL FERNANDO ARAMBU SANCHEZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(513, 65, '20171005462', 'ALISSON ALEJANDRA ROQUE SALINAS', '8', 'ADMINISTRACION ADUANERA'),
(514, 65, '20171005901', 'EDGAR VIRGILIO MARTINEZ CASTILLO', '8', 'ADMINISTRACION ADUANERA'),
(515, 65, '20171006373', 'DEMILSON SAMUEL QUIROZ LOPEZ', '8', 'ADMINISTRACION ADUANERA'),
(516, 65, '20171030181', 'MARIO ANTONIO HERNANDEZ ROMERO', '8', 'INFORMATICA ADMINISTRATIVA'),
(517, 65, '20171030193', 'DENIS ALEXANDER ALVARADO FERRERA', '8', 'ECONOMIA'),
(518, 65, '20171030393', 'ELVIN EDUARDO BORJAS GIRON', '8', 'ECONOMIA'),
(519, 65, '20171030517', 'JONATHAN MAYCOL CARRASCO MATAMOROS', '8', 'INFORMATICA ADMINISTRATIVA'),
(520, 65, '20171030769', 'CLAUDIA GABRIELA CHACON PONCE', '8', 'COMERCIO INTERNACIONAL'),
(521, 65, '20171031019', 'DAYANA NICOL ESCOBAR LAGOS', '8', 'ADMINISTRACION ADUANERA'),
(522, 65, '20171031159', 'MARIA FERNANDA GUTIERREZ BELIZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(523, 65, '20171031255', 'JOEL POMPILIO GALLO PEÑA', '7', 'INFORMATICA ADMINISTRATIVA'),
(524, 65, '20171031295', 'DANIA GISEEL ESPINOZA ANDRADE', '8', 'ADMINISTRACION ADUANERA'),
(525, 65, '20171031352', 'FERNANDO JOSE GALO GUEVARA', '8', 'ECONOMIA'),
(526, 65, '20171032339', 'JEANINE ESTEFANIA PERDOMO PERNUDI', '8', 'INFORMATICA ADMINISTRATIVA'),
(527, 65, '20171033029', 'JADE ALEXA AYALA LOPEZ', '7', 'ADMINISTRACION ADUANERA'),
(528, 65, '20171033102', 'JOSE VICTOR SIERRA LAGOS', '8', 'INFORMATICA ADMINISTRATIVA'),
(529, 65, '20171033477', 'DANIA MERARY VARGAS GALO', '8', 'ADMINISTRACION ADUANERA'),
(530, 65, '20171033499', 'MIGUEL ANTONIO TORRES TREJO', '8', 'INFORMATICA ADMINISTRATIVA'),
(531, 65, '20171034113', 'JERSON URIEL CABALLERO CARRANZA', '8', 'ADMINISTRACION ADUANERA'),
(532, 65, '20171034560', 'JONATHAN FERNANDO DIAZ PARADA', '8', 'INFORMATICA ADMINISTRATIVA'),
(533, 65, '20171034822', 'CATHERIN ALEJANDRA MENDOZA ROSALES', '8', 'ADMINISTRACION ADUANERA'),
(534, 65, '20171035152', 'JARED JOSAFAT ORELLANA TOLEDO', '8', 'ADMINISTRACION ADUANERA'),
(535, 65, '20172030632', 'GERALDINA MICHELLE LAGOS FLORES', '8', 'ADMINISTRACION ADUANERA'),
(536, 65, '20172500072', 'CRISTIAN JOSUE HERNANDEZ MORGA', '8', 'ECONOMIA'),
(537, 65, '20172500214', 'DINORA YAMILETH VAQUEDANO SORIANO', '8', 'COMERCIO INTERNACIONAL'),
(538, 65, '20181000003', 'DANIELA MICHELL ALONZO GOMEZ', '8', 'COMERCIO INTERNACIONAL'),
(539, 65, '20181000028', 'ALLAN MAURICIO ARDON MONTALVAN', '8', 'ECONOMIA'),
(540, 65, '20181000479', 'MENDEL BREZHNEV AGUILAR ROMERO', '8', 'INFORMATICA ADMINISTRATIVA'),
(541, 65, '20181000755', 'LESLY PATRICIA CRUZ MARADIAGA', '8', 'INFORMATICA ADMINISTRATIVA'),
(542, 65, '20181000828', 'LUIS CARLOS DELCID BONILLA', '8', 'INFORMATICA ADMINISTRATIVA'),
(543, 65, '20181001457', 'ABBY JUDITH FLORES DELCID', '8', 'ADMINISTRACION ADUANERA'),
(544, 65, '20181001501', 'NANCY GICELA DOMINGUEZ CRUZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(545, 65, '20181001502', 'GUSTAVO ARMANDO FIGUEROA MOTIÑO', '8', 'ECONOMIA'),
(546, 65, '20181001947', 'MARIA JHOSE GARCIA MUNGUIA', '8', 'INFORMATICA ADMINISTRATIVA'),
(547, 65, '20181002794', 'ANA LUCIA MARTINEZ PEÑA', '8', 'ADMINISTRACION ADUANERA'),
(548, 65, '20181003053', 'JEYMY NOHEMY ZELAYA AMADOR', '8', 'INFORMATICA ADMINISTRATIVA'),
(549, 65, '20181003095', 'JORGE FRANCISCO BONILLA GALEANO', '8', 'INFORMATICA ADMINISTRATIVA'),
(550, 65, '20181003138', 'BEYRA NICOL MOLINA CASTRO', '7', 'ECONOMIA'),
(551, 65, '20181003172', 'LUZ MARIA MONTOYA MEDINA', '7', 'INFORMATICA ADMINISTRATIVA'),
(552, 65, '20181003320', 'DIEGO FERNANDO ANTUNEZ BUSTILLO', '8', 'COMERCIO INTERNACIONAL'),
(553, 65, '20181003485', 'DANELIA ESTHER MARTINEZ HENRIQUEZ', '7', 'ADMINISTRACION ADUANERA'),
(554, 65, '20181003751', 'ESCARLET MILAGRO ORTEGA LANZA', '8', 'ADMINISTRACION ADUANERA'),
(555, 65, '20181003799', 'LEONELA YASMIN PINEDA BARAHONA', '8', 'INFORMATICA ADMINISTRATIVA'),
(556, 65, '20181004409', 'DANIEL EDUARDO MARTINEZ SARAVIA', '8', 'COMERCIO INTERNACIONAL'),
(557, 65, '20181004447', 'HASLER FABIAN ROMERO ALVARADO', '7', 'ADMINISTRACION ADUANERA'),
(558, 65, '20181004602', 'ANDREA NICOLLE PAZ TORRES', '7', 'ADMINISTRACION ADUANERA'),
(559, 65, '20181004727', 'DARIELA LIZETH VILLANUEVA MOLINA', '8', 'ECONOMIA'),
(560, 65, '20181005028', 'MISAEL ESAU LAGOS BARRIENTOS', '7', 'INFORMATICA ADMINISTRATIVA'),
(561, 65, '20181005152', 'NELZON ANTONIO RODAS MEJIA', '8', 'INFORMATICA ADMINISTRATIVA'),
(562, 65, '20181005268', 'DELMY GUADALUPE SUAZO GARCIA', '8', 'ADMINISTRACION ADUANERA'),
(563, 65, '20181005354', 'MIRIAN REGINA RODRIGUEZ NUÑEZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(564, 65, '20181005483', 'DANIELA ISABEL ALCANTARA ZELAYA', '7', 'COMERCIO INTERNACIONAL'),
(565, 65, '20181005571', 'ANDREA YOSSANA RODAS CASTILLO', '8', 'ECONOMIA'),
(566, 65, '20181005628', 'GABRIELA MARISOL COLINDRES RIOS', '7', 'ECONOMIA'),
(567, 65, '20181005648', 'GABRIELA ALEJANDRA RAUDALES CARDENAS', '8', 'ECONOMIA'),
(568, 65, '20181005949', 'ELMER SAIT RODRIGUEZ REYES', '7', 'ECONOMIA'),
(569, 65, '20181006102', 'ALEXANDRA LISBETH GARCIA ANDINO', '8', 'ADMINISTRACION ADUANERA'),
(570, 65, '20181006449', 'HEIMY CRISTAL RODRIGUEZ CASTELLON', '8', 'ADMINISTRACION ADUANERA'),
(571, 65, '20181006730', 'ESTHER SARAHI BARRIENTOS MARTINEZ', '8', 'ADMINISTRACION ADUANERA'),
(572, 65, '20181006840', 'LUIS STEVEN VASQUEZ PEREZ', '7', 'INFORMATICA ADMINISTRATIVA'),
(573, 65, '20181007078', 'DIEGO GABRIEL VALLADARES SANCHEZ', '8', 'COMERCIO INTERNACIONAL'),
(574, 65, '20181007175', 'FARID DANIEL VILCHEZ GONZALES', '8', 'ADMINISTRACION ADUANERA'),
(575, 65, '20181007185', 'EDUARDO JOSUE VILLARS CASTILLO', '7', 'ADMINISTRACION ADUANERA'),
(576, 65, '20181007231', 'ANGEL DANIEL VASQUEZ ALMENDARES', '8', 'ECONOMIA'),
(577, 65, '20181007648', 'JASON OMAR RODRIGUEZ QUIÑONEZ', '8', 'INFORMATICA ADMINISTRATIVA'),
(578, 65, '20181007693', 'ZULMA YONARI FLORES AVILA', '8', 'CONTADURIA PUBLICA Y FINANZAS'),
(579, 65, '20181030559', 'MARYORIE GICELLE MENDOZA GARCIA', '8', 'INFORMATICA ADMINISTRATIVA'),
(580, 65, '20181031079', 'NANCY KARINA CHAVARRIA TACHE', '8', 'INFORMATICA ADMINISTRATIVA'),
(581, 65, '20181031181', 'JESSICA CAROLINA CARRANZA OSORTO', '8', 'INFORMATICA ADMINISTRATIVA'),
(582, 65, '20181031307', 'CLAUDIA MARIELA GALEAS REYES', '8', 'COMERCIO INTERNACIONAL'),
(583, 65, '20181031519', 'FRANKLIN ADALID DOMINGUEZ COELLO', '8', 'ADMINISTRACION ADUANERA'),
(584, 65, '20181032196', 'ANDREA SOFIA PONCE CASTRO', '7', 'ECONOMIA'),
(585, 65, '20181033131', 'LUISA LIZETH ARIAS COTO', '8', 'INFORMATICA ADMINISTRATIVA'),
(586, 65, '20191000015', 'JESSY MARIA ALVARADO ESPINAL', '8', 'INFORMATICA ADMINISTRATIVA'),
(587, 65, '20191000152', 'DULCE MARIA FRANCO VALLADARES', '8', 'COMERCIO INTERNACIONAL'),
(589, 112, '20141010101', 'Samanta Ramirez', '12', 'Informatica Administrativa'),
(590, 112, '20131015093', 'Helmer Calix', '20', 'Informatica Administrativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_estados`
--

CREATE TABLE `tbl_voae_estados` (
  `id_estado` bigint(20) NOT NULL,
  `nombre_estado` varchar(25) NOT NULL COMMENT 'Nombre que identifica el estado de una actividad.',
  `descripcion_estado` varchar(200) NOT NULL COMMENT 'Resumen que describe el estado de una actividad.',
  `condicion` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabala para describir el estado de una actividad VOAE del CVE.';

--
-- Volcado de datos para la tabla `tbl_voae_estados`
--

INSERT INTO `tbl_voae_estados` (`id_estado`, `nombre_estado`, `descripcion_estado`, `condicion`) VALUES
(1, 'ELABORACIÓN', 'PROBANO ESTAD', 1),
(2, 'SOLICITADO', 'PROBANDO ESTADOS DSDS', 1),
(3, 'APROBADO', 'PROBANDO ESTADOS DSDS', 1),
(4, 'DENEGADO', 'FDDFDFDFDFFGFG', 1),
(5, 'DOCUMENTADO', 'PIOJRQREQW', 1),
(6, 'FINALIZADO', 'ODIFIDFJKLSDFSD', 1),
(7, 'CANCELADO', 'KDFJDSIFSDFSD', 1),
(8, 'ELIMINADO', 'FDGDFGDFGDFG', 1),
(9, 'REPROGRAMADO', 'GFDGDFGDFGDFG', 1),
(10, 'ATRASADO', 'KFDJDFJKASDS', 1),
(11, 'ACTIVO', 'GJHGJUYUTYERTET', 1),
(12, 'DESACTIVO', 'GHGHGHGHGYUIO', 1),
(13, 'COMPLETO', 'COMPLETO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_faltas_conductas`
--

CREATE TABLE `tbl_voae_faltas_conductas` (
  `id_falta` bigint(20) NOT NULL,
  `id_tipo_falta` bigint(20) NOT NULL COMMENT 'FK del índice de la tabla que hace referencia al tipo de falta.',
  `fch_falta` date NOT NULL COMMENT 'Fecha en que se sucitó la insidencia / falta',
  `id_persona_alumno` bigint(20) NOT NULL COMMENT 'KF indice de referencia a la tabla que contiene el registro del estudiante.',
  `descripcion` varchar(200) NOT NULL COMMENT 'Descripción detallada de la falta cometida.',
  `id_usuario_registro` bigint(20) NOT NULL,
  `fch_registro` date NOT NULL COMMENT 'Fecha en que se registró la falta en el sistema.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla que registra las faltas de conducta de los estudiantes de la carrera de Informática Administrativa.';

--
-- Volcado de datos para la tabla `tbl_voae_faltas_conductas`
--

INSERT INTO `tbl_voae_faltas_conductas` (`id_falta`, `id_tipo_falta`, `fch_falta`, `id_persona_alumno`, `descripcion`, `id_usuario_registro`, `fch_registro`) VALUES
(74, 3, '2021-07-11', 154, 'fghfgfgfg5', 1, '2021-07-19'),
(76, 2, '2021-08-02', 154, 'HGJHGHG', 1, '2021-08-06'),
(79, 2, '2021-07-02', 66, 'JHJKKGHJGH', 1, '2021-08-06'),
(80, 3, '2021-08-05', 66, 'PRUEBA', 1, '2021-08-06'),
(85, 2, '2021-08-02', 22, 'PRUEBA', 1, '2021-08-06'),
(86, 2, '2021-08-02', 154, 'PRUEBA', 1, '2021-08-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_informes`
--

CREATE TABLE `tbl_voae_informes` (
  `id_informe` bigint(20) NOT NULL COMMENT 'indice de la tabla - identificador',
  `id_actividad` bigint(20) NOT NULL COMMENT 'Campo identificador de la actividad',
  `introduccion` varchar(1000) NOT NULL COMMENT 'Introducción del Informe',
  `objetivos` varchar(1000) NOT NULL COMMENT 'Objetivos del Informe',
  `desarrollo` text NOT NULL COMMENT 'Desarollo del Informe',
  `conclusiones` varchar(1000) NOT NULL COMMENT 'Conclusiones del Informe',
  `fch_informe` date NOT NULL COMMENT 'Fecha del Informe',
  `id_repositorio` bigint(20) DEFAULT NULL,
  `id_usuario_registro` bigint(20) NOT NULL,
  `id_estado` bigint(20) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla que registrará los informes de las actividades VOAE que se realizan por el CVE';

--
-- Volcado de datos para la tabla `tbl_voae_informes`
--

INSERT INTO `tbl_voae_informes` (`id_informe`, `id_actividad`, `introduccion`, `objetivos`, `desarrollo`, `conclusiones`, `fch_informe`, `id_repositorio`, `id_usuario_registro`, `id_estado`) VALUES
(8, 65, 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', '2021-08-12', 35, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_memorandums`
--

CREATE TABLE `tbl_voae_memorandums` (
  `id_memo` bigint(20) NOT NULL,
  `no_memo` varchar(10) NOT NULL,
  `id_actividad` bigint(20) DEFAULT NULL,
  `id_tipo_memo` bigint(20) NOT NULL,
  `remitente` varchar(50) NOT NULL,
  `destinatario` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `contenido` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla para registrar la elaboración de memorandums necesarios para la remision de las actividades VOAE del CVE';

--
-- Volcado de datos para la tabla `tbl_voae_memorandums`
--

INSERT INTO `tbl_voae_memorandums` (`id_memo`, `no_memo`, `id_actividad`, `id_tipo_memo`, `remitente`, `destinatario`, `fecha`, `asunto`, `contenido`) VALUES
(25, 'NM-0003', NULL, 0, 'EVER', 'EVERDYHFFGFG', '2021-08-06', 'FDFDSFSDFGDFGDFG', 'JHGJGHJGHJGHJGH'),
(26, 'NM-0002', NULL, 0, 'EVER', 'EVER', '2021-08-06', 'GFDGDFGDF', 'HGJGHJGHJG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_repositorios`
--

CREATE TABLE `tbl_voae_repositorios` (
  `id_repositorio` bigint(20) NOT NULL COMMENT 'Identificador o indice de la tabla',
  `id_tipo_repositorio` bigint(20) NOT NULL COMMENT 'Identificador del tipo de repositorio que corresponde al repositorio que se registra',
  `nombre_archivo` varchar(50) NOT NULL,
  `dir_repositorio` varchar(150) NOT NULL COMMENT 'Dirección de la ubicación del archivo guardado en el repositorio.',
  `fecha_carga` datetime NOT NULL,
  `id_usuario_registro` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla para registrar las direcciones de los archivos que documentan las actividades VOAE del CVE almacenados en repositorio.';

--
-- Volcado de datos para la tabla `tbl_voae_repositorios`
--

INSERT INTO `tbl_voae_repositorios` (`id_repositorio`, `id_tipo_repositorio`, `nombre_archivo`, `dir_repositorio`, `fecha_carga`, `id_usuario_registro`) VALUES
(19, 1, 'Comprobante.pdf', '../archivos/repositorio_voae/1628204806.pdf', '2021-08-05 00:00:00', 1),
(20, 1, 'Tareas3Parcial_Carlos_Sabillon_20171004062.pdf', '../archivos/repositorio_voae/1628202578.pdf', '2021-08-05 00:00:00', 1),
(21, 1, 'Comprobante.pdf', '../archivos/repositorio_voae/1628203491.pdf', '2021-08-05 00:00:00', 1),
(22, 1, 'Tareas3Parcial_Carlos_Sabillon_20171004062.pdf', '../archivos/repositorio_voae/1628204155.pdf', '2021-08-05 00:00:00', 1),
(23, 1, 'Tareas3Parcial_Carlos_Sabillon_20171004062.pdf', '../archivos/repositorio_voae/1628204178.pdf', '2021-08-05 00:00:00', 1),
(24, 1, 'Comprobante.pdf', '../archivos/repositorio_voae/1628204952.pdf', '2021-08-05 00:00:00', 1),
(25, 1, 'Comprobante.pdf', '../archivos/repositorio_voae/1628204976.pdf', '2021-08-05 00:00:00', 1),
(26, 1, 'Comprobante.pdf', '../archivos/repositorio_voae/1628204976.pdf', '2021-08-05 00:00:00', 1),
(27, 1, 'Comprobante.pdf', '../archivos/repositorio_voae/1628204976.pdf', '2021-08-05 00:00:00', 1),
(28, 1, 'Comprobante.pdf', '../archivos/repositorio_voae/1628206722.pdf', '2021-08-05 00:00:00', 1),
(29, 1, 'TECNICA LEGISLATIVA EN HONDURAS.pdf', '../archivos/repositorio_voae/1628209827.pdf', '2021-08-05 00:00:00', 1),
(30, 1, 'Informatica-Administrativa-2019.pdf', '../archivos/repositorio_voae/1628273508.pdf', '2021-08-06 00:00:00', 1),
(31, 1, 'Informatica-Administrativa-2019.pdf', '../archivos/repositorio_voae/1628286243.pdf', '2021-08-06 00:00:00', 1),
(32, 1, 'Informatica-Administrativa-2019.pdf', '../archivos/repositorio_voae/1628290346.pdf', '2021-08-06 00:00:00', 1),
(33, 1, 'Informatica-Administrativa-2019.pdf', '../archivos/repositorio_voae/1628297565.pdf', '2021-08-06 00:00:00', 1),
(34, 1, 'Informatica-Administrativa-2019.pdf', '../archivos/repositorio_voae/1628300021.pdf', '2021-08-06 00:00:00', 1),
(35, 1, 'Informatica-Administrativa-2019.pdf', '../archivos/repositorio_voae/1628815553.pdf', '2021-08-12 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_tipos_faltas`
--

CREATE TABLE `tbl_voae_tipos_faltas` (
  `id_falta` bigint(20) NOT NULL,
  `nombre_falta` varchar(25) NOT NULL COMMENT 'Nombre que identifica el tipo de la falta.',
  `descripcion_falta` varchar(200) NOT NULL COMMENT 'Resumen de el tipo de comportamiento que describe la falta.',
  `condicion` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para enlistar los tipos de faltas que pudiera n existir en la conducta de los estudiantes.';

--
-- Volcado de datos para la tabla `tbl_voae_tipos_faltas`
--

INSERT INTO `tbl_voae_tipos_faltas` (`id_falta`, `nombre_falta`, `descripcion_falta`, `condicion`) VALUES
(1, 'MODERADA', 'PRUEBA DE FALTAS FFF', 1),
(2, 'GRAVE', 'FALTAS QUE INCIDEN GRAVEMENTE', 1),
(3, 'BAJA', 'FALTAS COMETIDAS POR EL ALUMNO BAJAS', 1),
(5, 'ALTA', 'FALTAS QUE INCIDEN GRAVEMENTE', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_tipos_repositorios`
--

CREATE TABLE `tbl_voae_tipos_repositorios` (
  `id_repositorio` bigint(20) NOT NULL,
  `nombre_repositorio` varchar(25) NOT NULL COMMENT 'Nombre que hace referencia al tipo de repositorio.',
  `descripcion_repositorio` varchar(200) NOT NULL COMMENT 'Detalla las carateristicas del tipo de repositorio.',
  `condicion` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Define los tipos de repositorios que se utilizan para identificar la relación con el archivo que se importe al repositorio.';

--
-- Volcado de datos para la tabla `tbl_voae_tipos_repositorios`
--

INSERT INTO `tbl_voae_tipos_repositorios` (`id_repositorio`, `nombre_repositorio`, `descripcion_repositorio`, `condicion`) VALUES
(1, 'PDF', 'FORMATO  INCLUIR ARCHIVOS PDF', 0),
(2, 'WORD', 'TIPO REPOSITORIO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voae_tipo_memorandum`
--

CREATE TABLE `tbl_voae_tipo_memorandum` (
  `id_tipo_memorandum` bigint(20) NOT NULL COMMENT 'campo llave de la tabla',
  `nombre_tipo_memorandum` varchar(50) DEFAULT NULL COMMENT 'nombre del tipo de memorandum',
  `descripcion_memorandum` varchar(255) NOT NULL,
  `condicion` tinyint(4) DEFAULT NULL COMMENT 'estado del memorandum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para definir los tipos de memorandums';

--
-- Volcado de datos para la tabla `tbl_voae_tipo_memorandum`
--

INSERT INTO `tbl_voae_tipo_memorandum` (`id_tipo_memorandum`, `nombre_tipo_memorandum`, `descripcion_memorandum`, `condicion`) VALUES
(0, 'MEMORANDUM ACTIVIDADES', 'PROBANDO MEMOS', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_faltas_conducta`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_faltas_conducta` (
`id_falta` bigint(20)
,`id_tipo_falta` bigint(20)
,`id_persona_alumno` bigint(20)
,`fch_falta` date
,`nombre_falta` varchar(25)
,`descripcion` varchar(200)
,`nombres` varchar(511)
,`valor` varchar(200)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_horas_voae`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_horas_voae` (
`id_asistencia` bigint(20)
,`cuenta` varchar(55)
,`nombre_alumno` varchar(55)
,`total_actividades` bigint(21)
,`total_horas` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_informes_actividades`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_informes_actividades` (
`id_usuario_registro` bigint(20)
,`id_informe` bigint(20)
,`no_solicitud` varchar(10)
,`id_actividad_voae` bigint(20)
,`nombre` varchar(45)
,`asistentes` bigint(21)
,`fch_informe` date
,`usuario` varchar(255)
,`nombre_estado` varchar(25)
,`id_estado` bigint(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_informes_actividades_completa`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `view_informes_actividades_completa` (
`id_informe` bigint(20)
,`id_actividad` bigint(20)
,`no_solicitud` varchar(10)
,`nombre_actividad` varchar(45)
,`introduccion` varchar(1000)
,`objetivos` varchar(1000)
,`desarrollo` text
,`conclusiones` varchar(1000)
,`fch_informe` date
,`id_repositorio` bigint(20)
,`nombre_archivo` varchar(50)
,`dir_repositorio` varchar(150)
,`id_usuario_registro` bigint(20)
,`Usuario` varchar(255)
,`id_estado` bigint(20)
,`nombre_estado` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_actividad_cve`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_actividad_cve` (
`id_usuario_registro` bigint(20)
,`id_actividad_voae` bigint(20)
,`no_solicitud` varchar(10)
,`fch_solicitud` datetime
,`nombre_actividad` varchar(45)
,`id_estado` varchar(25)
,`usuario` varchar(255)
,`ambito` varchar(25)
,`periodo` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_actividad_cve_1`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_actividad_cve_1` (
`id_actividad_voae` bigint(20)
,`no_solicitud` varchar(10)
,`fch_solicitud` datetime
,`nombre_actividad` varchar(45)
,`id_estado` varchar(25)
,`usuario` varchar(255)
,`ambito` varchar(25)
,`periodo` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_actividad_cve_2`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_actividad_cve_2` (
`id_usuario_registro` bigint(20)
,`id_actividad_voae` bigint(20)
,`condicion` tinyint(1)
,`no_solicitud` varchar(10)
,`fch_solicitud` datetime
,`nombre_actividad` varchar(45)
,`id_estado` varchar(25)
,`usuario` varchar(255)
,`ambito` varchar(25)
,`periodo` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_faltas_conducta`
--
DROP TABLE IF EXISTS `view_faltas_conducta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_faltas_conducta`  AS SELECT `tbl_voae_faltas_conductas`.`id_falta` AS `id_falta`, `tbl_voae_faltas_conductas`.`id_tipo_falta` AS `id_tipo_falta`, `tbl_voae_faltas_conductas`.`id_persona_alumno` AS `id_persona_alumno`, `tbl_voae_faltas_conductas`.`fch_falta` AS `fch_falta`, `tbl_voae_tipos_faltas`.`nombre_falta` AS `nombre_falta`, `tbl_voae_faltas_conductas`.`descripcion` AS `descripcion`, concat(`tbl_personas`.`nombres`,' ',`tbl_personas`.`apellidos`) AS `nombres`, `tbl_personas_extendidas`.`valor` AS `valor` FROM (((`tbl_voae_faltas_conductas` join `tbl_personas` on(`tbl_voae_faltas_conductas`.`id_persona_alumno` = `tbl_personas`.`id_persona`)) join `tbl_voae_tipos_faltas` on(`tbl_voae_faltas_conductas`.`id_tipo_falta` = `tbl_voae_tipos_faltas`.`id_falta`)) join `tbl_personas_extendidas` on(`tbl_voae_faltas_conductas`.`id_persona_alumno` = `tbl_personas_extendidas`.`id_persona`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_horas_voae`
--
DROP TABLE IF EXISTS `view_horas_voae`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_horas_voae`  AS SELECT `tbl_voae_asistencias`.`id_asistencia` AS `id_asistencia`, `tbl_voae_asistencias`.`cuenta` AS `cuenta`, `tbl_voae_asistencias`.`nombre_alumno` AS `nombre_alumno`, count(`tbl_voae_asistencias`.`id_actividad_voae`) AS `total_actividades`, sum(`tbl_voae_asistencias`.`cant_horas`) AS `total_horas` FROM `tbl_voae_asistencias` WHERE `tbl_voae_asistencias`.`carrera` like '%tica Administrativa%' GROUP BY `tbl_voae_asistencias`.`cuenta` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_informes_actividades`
--
DROP TABLE IF EXISTS `view_informes_actividades`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_informes_actividades`  AS SELECT `a`.`id_usuario_registro` AS `id_usuario_registro`, `i`.`id_informe` AS `id_informe`, `a`.`no_solicitud` AS `no_solicitud`, `a`.`id_actividad_voae` AS `id_actividad_voae`, `a`.`nombre_actividad` AS `nombre`, count(`l`.`id_asistencia`) AS `asistentes`, `i`.`fch_informe` AS `fch_informe`, `u`.`Usuario` AS `usuario`, `e`.`nombre_estado` AS `nombre_estado`, `i`.`id_estado` AS `id_estado` FROM ((((`tbl_voae_actividades` `a` left join `tbl_voae_asistencias` `l` on(`l`.`id_actividad_voae` = `a`.`id_actividad_voae`)) left join `tbl_voae_informes` `i` on(`i`.`id_actividad` = `a`.`id_actividad_voae`)) join `tbl_voae_estados` `e` on(`i`.`id_estado` = `e`.`id_estado`)) join `tbl_usuarios` `u` on(`a`.`id_usuario_registro` = `u`.`Id_usuario`)) WHERE `i`.`id_estado` = 1 GROUP BY `i`.`id_informe` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `view_informes_actividades_completa`
--
DROP TABLE IF EXISTS `view_informes_actividades_completa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_informes_actividades_completa`  AS SELECT `i`.`id_informe` AS `id_informe`, `i`.`id_actividad` AS `id_actividad`, `a`.`no_solicitud` AS `no_solicitud`, `a`.`nombre_actividad` AS `nombre_actividad`, `i`.`introduccion` AS `introduccion`, `i`.`objetivos` AS `objetivos`, `i`.`desarrollo` AS `desarrollo`, `i`.`conclusiones` AS `conclusiones`, `i`.`fch_informe` AS `fch_informe`, `i`.`id_repositorio` AS `id_repositorio`, `r`.`nombre_archivo` AS `nombre_archivo`, `r`.`dir_repositorio` AS `dir_repositorio`, `i`.`id_usuario_registro` AS `id_usuario_registro`, `u`.`Usuario` AS `Usuario`, `i`.`id_estado` AS `id_estado`, `e`.`nombre_estado` AS `nombre_estado` FROM ((((`tbl_voae_informes` `i` join `tbl_voae_repositorios` `r` on(`i`.`id_repositorio` = `r`.`id_repositorio`)) join `tbl_voae_estados` `e` on(`i`.`id_estado` = `e`.`id_estado`)) join `tbl_usuarios` `u` on(`i`.`id_usuario_registro` = `u`.`Id_usuario`)) join `tbl_voae_actividades` `a` on(`a`.`id_actividad_voae` = `i`.`id_actividad`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_actividad_cve`
--
DROP TABLE IF EXISTS `vista_actividad_cve`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_actividad_cve`  AS SELECT `a`.`id_usuario_registro` AS `id_usuario_registro`, `a`.`id_actividad_voae` AS `id_actividad_voae`, `a`.`no_solicitud` AS `no_solicitud`, `a`.`fch_solicitud` AS `fch_solicitud`, `a`.`nombre_actividad` AS `nombre_actividad`, `e`.`nombre_estado` AS `id_estado`, `u`.`Usuario` AS `usuario`, `b`.`nombre_ambito` AS `ambito`, `a`.`periodo` AS `periodo` FROM (((`tbl_voae_actividades` `a` join `tbl_usuarios` `u` on(`a`.`id_usuario_registro` = `u`.`Id_usuario`)) join `tbl_voae_ambitos` `b` on(`a`.`id_ambito` = `b`.`id_ambito`)) join `tbl_voae_estados` `e` on(`a`.`id_estado` = `e`.`id_estado`)) WHERE `e`.`id_estado` = 1 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_actividad_cve_1`
--
DROP TABLE IF EXISTS `vista_actividad_cve_1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_actividad_cve_1`  AS SELECT `a`.`id_actividad_voae` AS `id_actividad_voae`, `a`.`no_solicitud` AS `no_solicitud`, `a`.`fch_solicitud` AS `fch_solicitud`, `a`.`nombre_actividad` AS `nombre_actividad`, `e`.`nombre_estado` AS `id_estado`, `u`.`Usuario` AS `usuario`, `b`.`nombre_ambito` AS `ambito`, `a`.`periodo` AS `periodo` FROM (((`tbl_voae_actividades` `a` join `tbl_usuarios` `u` on(`a`.`id_usuario_registro` = `u`.`Id_usuario`)) join `tbl_voae_ambitos` `b` on(`a`.`id_ambito` = `b`.`id_ambito`)) join `tbl_voae_estados` `e` on(`a`.`id_estado` = `e`.`id_estado`)) WHERE `e`.`id_estado` = 2 OR `e`.`id_estado` = 4 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_actividad_cve_2`
--
DROP TABLE IF EXISTS `vista_actividad_cve_2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_actividad_cve_2`  AS SELECT `a`.`id_usuario_registro` AS `id_usuario_registro`, `a`.`id_actividad_voae` AS `id_actividad_voae`, `a`.`condicion` AS `condicion`, `a`.`no_solicitud` AS `no_solicitud`, `a`.`fch_solicitud` AS `fch_solicitud`, `a`.`nombre_actividad` AS `nombre_actividad`, `e`.`nombre_estado` AS `id_estado`, `u`.`Usuario` AS `usuario`, `b`.`nombre_ambito` AS `ambito`, `a`.`periodo` AS `periodo` FROM (((`tbl_voae_actividades` `a` join `tbl_usuarios` `u` on(`a`.`id_usuario_registro` = `u`.`Id_usuario`)) join `tbl_voae_ambitos` `b` on(`a`.`id_ambito` = `b`.`id_ambito`)) join `tbl_voae_estados` `e` on(`a`.`id_estado` = `e`.`id_estado`)) WHERE `e`.`id_estado` = 3 OR `e`.`id_estado` = 6 AND `a`.`tipo_actividad` = 'ACTIVIDAD INTERNA' ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_actividades`
--
ALTER TABLE `tbl_actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `FK_tbl_actividades_tbl_comisones` (`id_comisiones`) USING BTREE;

--
-- Indices de la tabla `tbl_actividades_persona`
--
ALTER TABLE `tbl_actividades_persona`
  ADD PRIMARY KEY (`id_act_persona`),
  ADD KEY `FK_tbl_actividades_persona_tbl_actividades` (`id_actividad`),
  ADD KEY `FK_tbl_actividades_persona_tbl_personas` (`id_persona`);

--
-- Indices de la tabla `tbl_aldeas_caserios_hn`
--
ALTER TABLE `tbl_aldeas_caserios_hn`
  ADD PRIMARY KEY (`id_aldea_caserio`),
  ADD KEY `FK_tbl_aldeas_caserios_hn_tbl_municipios_hn` (`id_municipio`);

--
-- Indices de la tabla `tbl_alumnos_himno`
--
ALTER TABLE `tbl_alumnos_himno`
  ADD PRIMARY KEY (`Id_himno`),
  ADD KEY `FK_personas_alumnos_himno` (`id_persona`) USING BTREE,
  ADD KEY `horario_himno` (`id_horario_himno`);

--
-- Indices de la tabla `tbl_areas`
--
ALTER TABLE `tbl_areas`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indices de la tabla `tbl_asignaturas`
--
ALTER TABLE `tbl_asignaturas`
  ADD PRIMARY KEY (`Id_asignatura`),
  ADD KEY `id_tipo_asignatura` (`id_tipo_asignatura`) USING BTREE,
  ADD KEY `id_area` (`id_area`),
  ADD KEY `id_plan_estudio` (`id_plan_estudio`),
  ADD KEY `id_periodo_plan` (`id_periodo_plan`);

--
-- Indices de la tabla `tbl_asignaturas_aprobadas`
--
ALTER TABLE `tbl_asignaturas_aprobadas`
  ADD PRIMARY KEY (`Id_asignatura_aprobada`),
  ADD KEY `Columna 2` (`Id_asignatura`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tbl_atributos`
--
ALTER TABLE `tbl_atributos`
  ADD PRIMARY KEY (`id_atributos`) USING BTREE,
  ADD KEY `FK1id_tipo_persona` (`id_tipo_persona`);

--
-- Indices de la tabla `tbl_aula`
--
ALTER TABLE `tbl_aula`
  ADD PRIMARY KEY (`id_aula`),
  ADD KEY `FK_tbl_aula_tbl_tipo_aula` (`id_tipo_aula`),
  ADD KEY `FK_tbl_aula_tbl_edificio` (`id_edificio`);

--
-- Indices de la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  ADD PRIMARY KEY (`Id_bitacora`),
  ADD KEY `rel_bi_obj` (`Id_objeto`),
  ADD KEY `Id_objeto` (`Id_objeto`),
  ADD KEY `cod_usuario` (`Id_objeto`) USING BTREE,
  ADD KEY `FK_usuario_bitacora` (`Id_usuario`);

--
-- Indices de la tabla `tbl_cambio_carrera`
--
ALTER TABLE `tbl_cambio_carrera`
  ADD PRIMARY KEY (`Id_cambio`),
  ADD KEY `fk_cambio_centro` (`Id_centro_regional`),
  ADD KEY `FK_facultades` (`Id_facultad`),
  ADD KEY `FK_personas_cambio_carrera` (`id_persona`) USING BTREE;

--
-- Indices de la tabla `tbl_cancelar_clases`
--
ALTER TABLE `tbl_cancelar_clases`
  ADD PRIMARY KEY (`Id_cancelar_clases`),
  ADD KEY `FK_personas_usuario` (`id_persona`) USING BTREE;

--
-- Indices de la tabla `tbl_carga_academica`
--
ALTER TABLE `tbl_carga_academica`
  ADD PRIMARY KEY (`id_carga_academica`),
  ADD KEY `FK_tbl_carga_academica_tbl_asignaturas` (`id_asignatura`),
  ADD KEY `FK_tbl_carga_academica_tbl_personas` (`id_persona`),
  ADD KEY `FK_tbl_carga_academica_tbl_periodo` (`id_periodo`),
  ADD KEY `FK_tbl_carga_tbl_aula` (`id_aula`),
  ADD KEY `FK_tbl_modalidad` (`id_modalidad`),
  ADD KEY `FK_tbl_hora_inicial` (`hora_inicial`),
  ADD KEY `FK_tbl_hora_final` (`hora_final`);

--
-- Indices de la tabla `tbl_carga_dias`
--
ALTER TABLE `tbl_carga_dias`
  ADD PRIMARY KEY (`id_carga_academica`),
  ADD KEY `id_dia` (`id_dia`);

--
-- Indices de la tabla `tbl_carrera`
--
ALTER TABLE `tbl_carrera`
  ADD PRIMARY KEY (`id_carrera`),
  ADD KEY `Id_facultad` (`Id_facultad`);

--
-- Indices de la tabla `tbl_carta_egresado`
--
ALTER TABLE `tbl_carta_egresado`
  ADD PRIMARY KEY (`Id_carta`),
  ADD KEY `FK_personas_carta_egresado` (`id_persona`) USING BTREE;

--
-- Indices de la tabla `tbl_categorias`
--
ALTER TABLE `tbl_categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `tbl_categoria_personas`
--
ALTER TABLE `tbl_categoria_personas`
  ADD PRIMARY KEY (`id_categoria_persona`),
  ADD KEY `tbl_categoria_personas_tbl_categorias_id_categoria_fk` (`id_categoria`),
  ADD KEY `tbl_categoria_personas_tbl_personas_id_persona_fk` (`id_persona`);

--
-- Indices de la tabla `tbl_centros_regionales`
--
ALTER TABLE `tbl_centros_regionales`
  ADD PRIMARY KEY (`Id_centro_regional`),
  ADD KEY `FK_facultad` (`Id_facultad`);

--
-- Indices de la tabla `tbl_charla_practica`
--
ALTER TABLE `tbl_charla_practica`
  ADD PRIMARY KEY (`Id_charla`),
  ADD KEY `FK_personas_charla_practica` (`id_persona`);

--
-- Indices de la tabla `tbl_comentarios_alumnos`
--
ALTER TABLE `tbl_comentarios_alumnos`
  ADD PRIMARY KEY (`id_comentario_alumno`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tbl_comisiones`
--
ALTER TABLE `tbl_comisiones`
  ADD PRIMARY KEY (`id_comisiones`),
  ADD KEY `Id_carrera` (`id_carrera`) USING BTREE;

--
-- Indices de la tabla `tbl_contactos`
--
ALTER TABLE `tbl_contactos`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `FK_personas_contactos` (`id_persona`),
  ADD KEY `FK_tipos_contactos_contacto` (`id_tipo_contacto`);

--
-- Indices de la tabla `tbl_contador_constancia`
--
ALTER TABLE `tbl_contador_constancia`
  ADD PRIMARY KEY (`id_contador`);

--
-- Indices de la tabla `tbl_departamentos`
--
ALTER TABLE `tbl_departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `tbl_desea_asig_doce`
--
ALTER TABLE `tbl_desea_asig_doce`
  ADD PRIMARY KEY (`id_desea_asig_doce`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `Id_asignatura` (`Id_asignatura`);

--
-- Indices de la tabla `tbl_desempeno_practica`
--
ALTER TABLE `tbl_desempeno_practica`
  ADD PRIMARY KEY (`id_desempeno_practica`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tbl_dias`
--
ALTER TABLE `tbl_dias`
  ADD PRIMARY KEY (`id_dia`);

--
-- Indices de la tabla `tbl_dias_feriados`
--
ALTER TABLE `tbl_dias_feriados`
  ADD PRIMARY KEY (`id_dia_feriado`);

--
-- Indices de la tabla `tbl_docentes_proyecto`
--
ALTER TABLE `tbl_docentes_proyecto`
  ADD PRIMARY KEY (`id_docente_proyecto`),
  ADD KEY `Id_proyecto` (`Id_proyecto`);

--
-- Indices de la tabla `tbl_edificios`
--
ALTER TABLE `tbl_edificios`
  ADD PRIMARY KEY (`id_edificio`);

--
-- Indices de la tabla `tbl_egresados`
--
ALTER TABLE `tbl_egresados`
  ADD PRIMARY KEY (`Id_egresado`);

--
-- Indices de la tabla `tbl_empresas_practica`
--
ALTER TABLE `tbl_empresas_practica`
  ADD PRIMARY KEY (`Id_empresa`),
  ADD KEY `FK_personas_empresas_practica` (`id_persona`);

--
-- Indices de la tabla `tbl_empresa_aporte_proyecto`
--
ALTER TABLE `tbl_empresa_aporte_proyecto`
  ADD PRIMARY KEY (`Id_aporte`);

--
-- Indices de la tabla `tbl_equivalencias`
--
ALTER TABLE `tbl_equivalencias`
  ADD PRIMARY KEY (`Id_equivalencia`),
  ADD KEY `FK_personas_equivalencias` (`id_persona`);

--
-- Indices de la tabla `tbl_especialidad_grado`
--
ALTER TABLE `tbl_especialidad_grado`
  ADD PRIMARY KEY (`id_especialidad`),
  ADD KEY `FK_tbl_especialidad_grado_tbl_grados_academicos` (`id_grado_academico`);

--
-- Indices de la tabla `tbl_estadocivil`
--
ALTER TABLE `tbl_estadocivil`
  ADD PRIMARY KEY (`id_estado_civil`);

--
-- Indices de la tabla `tbl_estudiantes_proyecto`
--
ALTER TABLE `tbl_estudiantes_proyecto`
  ADD PRIMARY KEY (`Id_estudiante_proyecto`),
  ADD KEY `Id_proyecto` (`Id_proyecto`);

--
-- Indices de la tabla `tbl_evaluaciones_practica`
--
ALTER TABLE `tbl_evaluaciones_practica`
  ADD PRIMARY KEY (`id_evaluacion_practica`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tbl_expe_academica_docente`
--
ALTER TABLE `tbl_expe_academica_docente`
  ADD PRIMARY KEY (`id_expe_academi_docente`),
  ADD KEY `FK_tbl_expe_academica_docente_tbl_personas` (`id_persona`),
  ADD KEY `FK_tbl_expe_academica_docente_tbl_areas` (`id_area`);

--
-- Indices de la tabla `tbl_facultades`
--
ALTER TABLE `tbl_facultades`
  ADD PRIMARY KEY (`Id_facultad`);

--
-- Indices de la tabla `tbl_feriado`
--
ALTER TABLE `tbl_feriado`
  ADD PRIMARY KEY (` id_feriado`);

--
-- Indices de la tabla `tbl_finalizacion_practica`
--
ALTER TABLE `tbl_finalizacion_practica`
  ADD PRIMARY KEY (`Id_finalizacion`),
  ADD KEY `FK_practica` (`Id_practica`),
  ADD KEY `FK_personas_finalizacion_practica` (`id_persona`);

--
-- Indices de la tabla `tbl_funciones_practica`
--
ALTER TABLE `tbl_funciones_practica`
  ADD PRIMARY KEY (`id_funcion_practica`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tbl_genero`
--
ALTER TABLE `tbl_genero`
  ADD PRIMARY KEY (`id_genero`);

--
-- Indices de la tabla `tbl_grados_academicos`
--
ALTER TABLE `tbl_grados_academicos`
  ADD PRIMARY KEY (`id_grado_academico`);

--
-- Indices de la tabla `tbl_grados_academicos_personas`
--
ALTER TABLE `tbl_grados_academicos_personas`
  ADD PRIMARY KEY (`id_grado_aca_personas`),
  ADD KEY `FK1id_especialidad` (`id_especialidad`),
  ADD KEY `FK2id_categoria` (`id_persona`) USING BTREE;

--
-- Indices de la tabla `tbl_hora`
--
ALTER TABLE `tbl_hora`
  ADD PRIMARY KEY (`hora`);

--
-- Indices de la tabla `tbl_horario_docentes`
--
ALTER TABLE `tbl_horario_docentes`
  ADD PRIMARY KEY (`id_horario_docente`),
  ADD KEY `tbl_horario_docentes_tbl_jornadas_id_jornada_fk` (`id_jornada`),
  ADD KEY `tbl_horario_docentes_tbl_categoria_pers_id_categoria_persona_fk` (`id_categoria_persona`),
  ADD KEY `FK_tbl_horario_docentes_tbl_personas` (`id_persona`);

--
-- Indices de la tabla `tbl_horario_himno`
--
ALTER TABLE `tbl_horario_himno`
  ADD PRIMARY KEY (`id_horario_himno`);

--
-- Indices de la tabla `tbl_jornadas`
--
ALTER TABLE `tbl_jornadas`
  ADD PRIMARY KEY (`id_jornada`);

--
-- Indices de la tabla `tbl_modalidad`
--
ALTER TABLE `tbl_modalidad`
  ADD PRIMARY KEY (`id_modalidad`);

--
-- Indices de la tabla `tbl_modalidades_proyecto`
--
ALTER TABLE `tbl_modalidades_proyecto`
  ADD PRIMARY KEY (`Id_modalidad`);

--
-- Indices de la tabla `tbl_municipios_hn`
--
ALTER TABLE `tbl_municipios_hn`
  ADD PRIMARY KEY (`id_municipio`) USING BTREE,
  ADD KEY `id_departamento` (`id_departamento`);

--
-- Indices de la tabla `tbl_nacionalidad`
--
ALTER TABLE `tbl_nacionalidad`
  ADD PRIMARY KEY (`id_nacionalidad`) USING BTREE;

--
-- Indices de la tabla `tbl_objetos`
--
ALTER TABLE `tbl_objetos`
  ADD PRIMARY KEY (`Id_objeto`);

--
-- Indices de la tabla `tbl_parametros`
--
ALTER TABLE `tbl_parametros`
  ADD PRIMARY KEY (`Id_parametro`),
  ADD KEY `FK_usuarios_parametros` (`Id_usuario`);

--
-- Indices de la tabla `tbl_periodo`
--
ALTER TABLE `tbl_periodo`
  ADD PRIMARY KEY (`id_periodo`),
  ADD UNIQUE KEY `num_periodo` (`num_periodo`,`num_anno`) USING BTREE,
  ADD KEY `FK1_tbl_tipo_periodo` (`id_tipo_periodo`);

--
-- Indices de la tabla `tbl_periodo_plan`
--
ALTER TABLE `tbl_periodo_plan`
  ADD PRIMARY KEY (`id_periodo_plan`);

--
-- Indices de la tabla `tbl_permisos_usuarios`
--
ALTER TABLE `tbl_permisos_usuarios`
  ADD PRIMARY KEY (`Id_permisos_usuario`),
  ADD KEY `cod_rol` (`Id_rol`),
  ADD KEY `cod_objeto` (`Id_objeto`);

--
-- Indices de la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `FK_tbl_personas_tbl_tipo_docente` (`id_tipo_docente`),
  ADD KEY `tbl_personas_tbl_tipos_persona_id_tipo_persona_fk` (`id_tipo_persona`) USING BTREE;

--
-- Indices de la tabla `tbl_personas_extendidas`
--
ALTER TABLE `tbl_personas_extendidas`
  ADD PRIMARY KEY (`id_persona_ext`),
  ADD KEY `FK_tbl_personas_extendidas_tbl_atributos` (`id_atributo`),
  ADD KEY `FK_tbl_personas_extendidas_tbl_personas` (`id_persona`);

--
-- Indices de la tabla `tbl_plan_estudio`
--
ALTER TABLE `tbl_plan_estudio`
  ADD PRIMARY KEY (`id_plan_estudio`),
  ADD KEY `id_tipo_plan` (`id_tipo_plan`);

--
-- Indices de la tabla `tbl_practica_estudiantes`
--
ALTER TABLE `tbl_practica_estudiantes`
  ADD PRIMARY KEY (`Id_practica`),
  ADD KEY `cod_empresa` (`Id_empresa`),
  ADD KEY `FK_personas_practica_estudiante` (`id_persona`);

--
-- Indices de la tabla `tbl_practica_rechazo`
--
ALTER TABLE `tbl_practica_rechazo`
  ADD PRIMARY KEY (`id_practica_rechazo`),
  ADD KEY `FK_personas_practica_rechazada` (`id_persona`);

--
-- Indices de la tabla `tbl_pref_area_docen`
--
ALTER TABLE `tbl_pref_area_docen`
  ADD PRIMARY KEY (`id_pref_area_doce`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_area` (`id_area`);

--
-- Indices de la tabla `tbl_pref_asig_docen`
--
ALTER TABLE `tbl_pref_asig_docen`
  ADD PRIMARY KEY (`id_pref_asig_docen`),
  ADD KEY `FK_tbl_pref_asig_docen_tbl_personas` (`id_persona`),
  ADD KEY `FK_tbl_pref_asig_docen_tbl_asignaturas` (`Id_asignatura`) USING BTREE;

--
-- Indices de la tabla `tbl_preguntas`
--
ALTER TABLE `tbl_preguntas`
  ADD PRIMARY KEY (`Id_pregunta`);

--
-- Indices de la tabla `tbl_preguntas_seguridad`
--
ALTER TABLE `tbl_preguntas_seguridad`
  ADD PRIMARY KEY (`Id_pregunta_seguridad`),
  ADD KEY `cod_pregunta` (`Id_pregunta`),
  ADD KEY `FK_personas_preguntas_seguridad` (`Id_usuario`);

--
-- Indices de la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  ADD PRIMARY KEY (`Id_proyecto`),
  ADD KEY `cod_tipo_v` (`Id_tipo_v`),
  ADD KEY `cod_modalidad` (`Id_modalidad`),
  ADD KEY `Id_tipo_formalizacion` (`Id_tipo_formalizacion`),
  ADD KEY `Id_aporte` (`Id_aporte`),
  ADD KEY `FK_tbl_proyectos_tbl_departamentos` (`departamento_pais`),
  ADD KEY `FK_tbl_proyectos_tbl_municipios_hn` (`municipio`),
  ADD KEY `FK_tbl_proyectos_tbl_aldeas_caserios_hn` (`aldea_caserio`);

--
-- Indices de la tabla `tbl_requisito_asignatura`
--
ALTER TABLE `tbl_requisito_asignatura`
  ADD PRIMARY KEY (`id_requisito_asig`),
  ADD KEY `id_asignatura` (`Id_asignatura`);

--
-- Indices de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`Id_rol`);

--
-- Indices de la tabla `tbl_subida_documentacion`
--
ALTER TABLE `tbl_subida_documentacion`
  ADD PRIMARY KEY (`Id_subida`),
  ADD KEY `FK_personas_subida_documento` (`id_persona`);

--
-- Indices de la tabla `tbl_tipos_persona`
--
ALTER TABLE `tbl_tipos_persona`
  ADD PRIMARY KEY (`id_tipo_persona`);

--
-- Indices de la tabla `tbl_tipos_vinculacion`
--
ALTER TABLE `tbl_tipos_vinculacion`
  ADD PRIMARY KEY (`Id_tipo_v`);

--
-- Indices de la tabla `tbl_tipo_asignatura`
--
ALTER TABLE `tbl_tipo_asignatura`
  ADD PRIMARY KEY (`id_tipo_asignatura`);

--
-- Indices de la tabla `tbl_tipo_aula`
--
ALTER TABLE `tbl_tipo_aula`
  ADD PRIMARY KEY (`id_tipo_aula`);

--
-- Indices de la tabla `tbl_tipo_contactos`
--
ALTER TABLE `tbl_tipo_contactos`
  ADD PRIMARY KEY (`id_tipo_contacto`);

--
-- Indices de la tabla `tbl_tipo_docente`
--
ALTER TABLE `tbl_tipo_docente`
  ADD PRIMARY KEY (`id_tipo_docente`);

--
-- Indices de la tabla `tbl_tipo_formalizacion_proyecto`
--
ALTER TABLE `tbl_tipo_formalizacion_proyecto`
  ADD PRIMARY KEY (`Id_tipo_formalizacion`);

--
-- Indices de la tabla `tbl_tipo_periodo`
--
ALTER TABLE `tbl_tipo_periodo`
  ADD PRIMARY KEY (`id_tipo_periodo`);

--
-- Indices de la tabla `tbl_tipo_plan`
--
ALTER TABLE `tbl_tipo_plan`
  ADD PRIMARY KEY (`id_tipo_plan`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`Id_usuario`),
  ADD KEY `FK_personas_usuarios` (`id_persona`),
  ADD KEY `FK_rol_usuarios` (`Id_rol`);

--
-- Indices de la tabla `tbl_voae_actividades`
--
ALTER TABLE `tbl_voae_actividades`
  ADD PRIMARY KEY (`id_actividad_voae`) USING BTREE,
  ADD KEY `FK1_tbl_actividades_voae_tbl_estados` (`id_estado`) USING BTREE,
  ADD KEY `FK2_tbl_actividades_voae_tbl_usuarios` (`id_usuario_registro`) USING BTREE,
  ADD KEY `FK3_tbl_actividades_voae_tbl_ambitos` (`id_ambito`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_ambitos`
--
ALTER TABLE `tbl_voae_ambitos`
  ADD PRIMARY KEY (`id_ambito`) USING BTREE,
  ADD UNIQUE KEY `id_ambito_UNIQUE` (`id_ambito`) USING BTREE,
  ADD UNIQUE KEY `nombre_ambito` (`nombre_ambito`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_asistencias`
--
ALTER TABLE `tbl_voae_asistencias`
  ADD PRIMARY KEY (`id_asistencia`) USING BTREE,
  ADD KEY `FK2_tbl_asistencias_tbl_actividad_voae` (`id_actividad_voae`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_estados`
--
ALTER TABLE `tbl_voae_estados`
  ADD PRIMARY KEY (`id_estado`) USING BTREE,
  ADD UNIQUE KEY `id_estado_UNIQUE` (`id_estado`) USING BTREE,
  ADD UNIQUE KEY `nombre_estado_unico` (`nombre_estado`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_faltas_conductas`
--
ALTER TABLE `tbl_voae_faltas_conductas`
  ADD PRIMARY KEY (`id_falta`) USING BTREE,
  ADD KEY `FK1_tbl_faltas_tbl_persona_alumno` (`id_persona_alumno`) USING BTREE,
  ADD KEY `FK2_tbl_faltas_tbl_usuario_registro` (`id_usuario_registro`) USING BTREE,
  ADD KEY `FK3_tbl_faltas_tbl_tipo_falta` (`id_tipo_falta`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_informes`
--
ALTER TABLE `tbl_voae_informes`
  ADD PRIMARY KEY (`id_informe`) USING BTREE,
  ADD KEY `FK1_tbl_informes_tbl_actividades` (`id_actividad`) USING BTREE,
  ADD KEY `FK2_tbl_informes_tbl_usuarios` (`id_usuario_registro`) USING BTREE,
  ADD KEY `FK3_tbl_informes_tbl_voae_repositorios` (`id_repositorio`) USING BTREE,
  ADD KEY `FK4_tbl_informes_tbl_voae_estados` (`id_estado`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_memorandums`
--
ALTER TABLE `tbl_voae_memorandums`
  ADD PRIMARY KEY (`id_memo`) USING BTREE,
  ADD KEY `FK1_tbl_memorandums_tbl_actividades` (`id_actividad`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_repositorios`
--
ALTER TABLE `tbl_voae_repositorios`
  ADD PRIMARY KEY (`id_repositorio`) USING BTREE,
  ADD KEY `FK1_tbl_repositorios_tbl_tipos_repositorios` (`id_tipo_repositorio`) USING BTREE,
  ADD KEY `FK3_tbl_repositorios_tbl_usuarios` (`id_usuario_registro`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_tipos_faltas`
--
ALTER TABLE `tbl_voae_tipos_faltas`
  ADD PRIMARY KEY (`id_falta`) USING BTREE,
  ADD UNIQUE KEY `id_falta_UNIQUE` (`id_falta`) USING BTREE,
  ADD UNIQUE KEY `nombre_tipo_falta_unico` (`nombre_falta`) USING BTREE;

--
-- Indices de la tabla `tbl_voae_tipos_repositorios`
--
ALTER TABLE `tbl_voae_tipos_repositorios`
  ADD PRIMARY KEY (`id_repositorio`) USING BTREE,
  ADD UNIQUE KEY `id_tipo_UNIQUE` (`id_repositorio`) USING BTREE,
  ADD UNIQUE KEY `nombre_tipo_repositorio_unico` (`nombre_repositorio`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_actividades`
--
ALTER TABLE `tbl_actividades`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tbl_actividades_persona`
--
ALTER TABLE `tbl_actividades_persona`
  MODIFY `id_act_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT de la tabla `tbl_aldeas_caserios_hn`
--
ALTER TABLE `tbl_aldeas_caserios_hn`
  MODIFY `id_aldea_caserio` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=598;

--
-- AUTO_INCREMENT de la tabla `tbl_alumnos_himno`
--
ALTER TABLE `tbl_alumnos_himno`
  MODIFY `Id_himno` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_areas`
--
ALTER TABLE `tbl_areas`
  MODIFY `id_area` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_asignaturas`
--
ALTER TABLE `tbl_asignaturas`
  MODIFY `Id_asignatura` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `tbl_asignaturas_aprobadas`
--
ALTER TABLE `tbl_asignaturas_aprobadas`
  MODIFY `Id_asignatura_aprobada` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `tbl_atributos`
--
ALTER TABLE `tbl_atributos`
  MODIFY `id_atributos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_aula`
--
ALTER TABLE `tbl_aula`
  MODIFY `id_aula` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  MODIFY `Id_bitacora` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31979;

--
-- AUTO_INCREMENT de la tabla `tbl_cambio_carrera`
--
ALTER TABLE `tbl_cambio_carrera`
  MODIFY `Id_cambio` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `tbl_cancelar_clases`
--
ALTER TABLE `tbl_cancelar_clases`
  MODIFY `Id_cancelar_clases` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_carga_academica`
--
ALTER TABLE `tbl_carga_academica`
  MODIFY `id_carga_academica` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=517;

--
-- AUTO_INCREMENT de la tabla `tbl_carga_dias`
--
ALTER TABLE `tbl_carga_dias`
  MODIFY `id_carga_academica` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_carrera`
--
ALTER TABLE `tbl_carrera`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_carta_egresado`
--
ALTER TABLE `tbl_carta_egresado`
  MODIFY `Id_carta` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tbl_categorias`
--
ALTER TABLE `tbl_categorias`
  MODIFY `id_categoria` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_categoria_personas`
--
ALTER TABLE `tbl_categoria_personas`
  MODIFY `id_categoria_persona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `tbl_centros_regionales`
--
ALTER TABLE `tbl_centros_regionales`
  MODIFY `Id_centro_regional` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_charla_practica`
--
ALTER TABLE `tbl_charla_practica`
  MODIFY `Id_charla` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_comentarios_alumnos`
--
ALTER TABLE `tbl_comentarios_alumnos`
  MODIFY `id_comentario_alumno` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_comisiones`
--
ALTER TABLE `tbl_comisiones`
  MODIFY `id_comisiones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tbl_contactos`
--
ALTER TABLE `tbl_contactos`
  MODIFY `id_contacto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=443;

--
-- AUTO_INCREMENT de la tabla `tbl_contador_constancia`
--
ALTER TABLE `tbl_contador_constancia`
  MODIFY `id_contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_departamentos`
--
ALTER TABLE `tbl_departamentos`
  MODIFY `id_departamento` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_desea_asig_doce`
--
ALTER TABLE `tbl_desea_asig_doce`
  MODIFY `id_desea_asig_doce` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `tbl_desempeno_practica`
--
ALTER TABLE `tbl_desempeno_practica`
  MODIFY `id_desempeno_practica` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_dias_feriados`
--
ALTER TABLE `tbl_dias_feriados`
  MODIFY `id_dia_feriado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_docentes_proyecto`
--
ALTER TABLE `tbl_docentes_proyecto`
  MODIFY `id_docente_proyecto` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_edificios`
--
ALTER TABLE `tbl_edificios`
  MODIFY `id_edificio` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_egresados`
--
ALTER TABLE `tbl_egresados`
  MODIFY `Id_egresado` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_empresas_practica`
--
ALTER TABLE `tbl_empresas_practica`
  MODIFY `Id_empresa` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tbl_empresa_aporte_proyecto`
--
ALTER TABLE `tbl_empresa_aporte_proyecto`
  MODIFY `Id_aporte` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_equivalencias`
--
ALTER TABLE `tbl_equivalencias`
  MODIFY `Id_equivalencia` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_especialidad_grado`
--
ALTER TABLE `tbl_especialidad_grado`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `tbl_estadocivil`
--
ALTER TABLE `tbl_estadocivil`
  MODIFY `id_estado_civil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_estudiantes_proyecto`
--
ALTER TABLE `tbl_estudiantes_proyecto`
  MODIFY `Id_estudiante_proyecto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `tbl_evaluaciones_practica`
--
ALTER TABLE `tbl_evaluaciones_practica`
  MODIFY `id_evaluacion_practica` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_expe_academica_docente`
--
ALTER TABLE `tbl_expe_academica_docente`
  MODIFY `id_expe_academi_docente` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_facultades`
--
ALTER TABLE `tbl_facultades`
  MODIFY `Id_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_feriado`
--
ALTER TABLE `tbl_feriado`
  MODIFY ` id_feriado` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_finalizacion_practica`
--
ALTER TABLE `tbl_finalizacion_practica`
  MODIFY `Id_finalizacion` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `tbl_funciones_practica`
--
ALTER TABLE `tbl_funciones_practica`
  MODIFY `id_funcion_practica` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_genero`
--
ALTER TABLE `tbl_genero`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_grados_academicos`
--
ALTER TABLE `tbl_grados_academicos`
  MODIFY `id_grado_academico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_grados_academicos_personas`
--
ALTER TABLE `tbl_grados_academicos_personas`
  MODIFY `id_grado_aca_personas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT de la tabla `tbl_horario_docentes`
--
ALTER TABLE `tbl_horario_docentes`
  MODIFY `id_horario_docente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `tbl_horario_himno`
--
ALTER TABLE `tbl_horario_himno`
  MODIFY `id_horario_himno` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_jornadas`
--
ALTER TABLE `tbl_jornadas`
  MODIFY `id_jornada` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_modalidad`
--
ALTER TABLE `tbl_modalidad`
  MODIFY `id_modalidad` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_modalidades_proyecto`
--
ALTER TABLE `tbl_modalidades_proyecto`
  MODIFY `Id_modalidad` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_municipios_hn`
--
ALTER TABLE `tbl_municipios_hn`
  MODIFY `id_municipio` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT de la tabla `tbl_nacionalidad`
--
ALTER TABLE `tbl_nacionalidad`
  MODIFY `id_nacionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT de la tabla `tbl_objetos`
--
ALTER TABLE `tbl_objetos`
  MODIFY `Id_objeto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT de la tabla `tbl_parametros`
--
ALTER TABLE `tbl_parametros`
  MODIFY `Id_parametro` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tbl_periodo`
--
ALTER TABLE `tbl_periodo`
  MODIFY `id_periodo` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_periodo_plan`
--
ALTER TABLE `tbl_periodo_plan`
  MODIFY `id_periodo_plan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos_usuarios`
--
ALTER TABLE `tbl_permisos_usuarios`
  MODIFY `Id_permisos_usuario` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT de la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  MODIFY `id_persona` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `tbl_personas_extendidas`
--
ALTER TABLE `tbl_personas_extendidas`
  MODIFY `id_persona_ext` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=504;

--
-- AUTO_INCREMENT de la tabla `tbl_plan_estudio`
--
ALTER TABLE `tbl_plan_estudio`
  MODIFY `id_plan_estudio` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tbl_practica_estudiantes`
--
ALTER TABLE `tbl_practica_estudiantes`
  MODIFY `Id_practica` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_practica_rechazo`
--
ALTER TABLE `tbl_practica_rechazo`
  MODIFY `id_practica_rechazo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_pref_area_docen`
--
ALTER TABLE `tbl_pref_area_docen`
  MODIFY `id_pref_area_doce` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `tbl_pref_asig_docen`
--
ALTER TABLE `tbl_pref_asig_docen`
  MODIFY `id_pref_asig_docen` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `tbl_preguntas`
--
ALTER TABLE `tbl_preguntas`
  MODIFY `Id_pregunta` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `tbl_preguntas_seguridad`
--
ALTER TABLE `tbl_preguntas_seguridad`
  MODIFY `Id_pregunta_seguridad` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  MODIFY `Id_proyecto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `tbl_requisito_asignatura`
--
ALTER TABLE `tbl_requisito_asignatura`
  MODIFY `id_requisito_asig` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `Id_rol` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `tbl_subida_documentacion`
--
ALTER TABLE `tbl_subida_documentacion`
  MODIFY `Id_subida` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbl_tipos_vinculacion`
--
ALTER TABLE `tbl_tipos_vinculacion`
  MODIFY `Id_tipo_v` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_asignatura`
--
ALTER TABLE `tbl_tipo_asignatura`
  MODIFY `id_tipo_asignatura` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_contactos`
--
ALTER TABLE `tbl_tipo_contactos`
  MODIFY `id_tipo_contacto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_docente`
--
ALTER TABLE `tbl_tipo_docente`
  MODIFY `id_tipo_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_formalizacion_proyecto`
--
ALTER TABLE `tbl_tipo_formalizacion_proyecto`
  MODIFY `Id_tipo_formalizacion` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_periodo`
--
ALTER TABLE `tbl_tipo_periodo`
  MODIFY `id_tipo_periodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_plan`
--
ALTER TABLE `tbl_tipo_plan`
  MODIFY `id_tipo_plan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `Id_usuario` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_actividades`
--
ALTER TABLE `tbl_voae_actividades`
  MODIFY `id_actividad_voae` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Campo llave - índice de la tabla', AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_ambitos`
--
ALTER TABLE `tbl_voae_ambitos`
  MODIFY `id_ambito` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_asistencias`
--
ALTER TABLE `tbl_voae_asistencias`
  MODIFY `id_asistencia` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_estados`
--
ALTER TABLE `tbl_voae_estados`
  MODIFY `id_estado` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_faltas_conductas`
--
ALTER TABLE `tbl_voae_faltas_conductas`
  MODIFY `id_falta` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_informes`
--
ALTER TABLE `tbl_voae_informes`
  MODIFY `id_informe` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'indice de la tabla - identificador', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_memorandums`
--
ALTER TABLE `tbl_voae_memorandums`
  MODIFY `id_memo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_repositorios`
--
ALTER TABLE `tbl_voae_repositorios`
  MODIFY `id_repositorio` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Identificador o indice de la tabla', AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_tipos_faltas`
--
ALTER TABLE `tbl_voae_tipos_faltas`
  MODIFY `id_falta` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_voae_tipos_repositorios`
--
ALTER TABLE `tbl_voae_tipos_repositorios`
  MODIFY `id_repositorio` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_actividades`
--
ALTER TABLE `tbl_actividades`
  ADD CONSTRAINT `FK_tbl_actividades_tbl_comisones` FOREIGN KEY (`id_comisiones`) REFERENCES `tbl_comisiones` (`id_comisiones`);

--
-- Filtros para la tabla `tbl_actividades_persona`
--
ALTER TABLE `tbl_actividades_persona`
  ADD CONSTRAINT `FK_tbl_actividades_persona_tbl_actividades` FOREIGN KEY (`id_actividad`) REFERENCES `tbl_actividades` (`id_actividad`),
  ADD CONSTRAINT `FK_tbl_actividades_persona_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_aldeas_caserios_hn`
--
ALTER TABLE `tbl_aldeas_caserios_hn`
  ADD CONSTRAINT `FK_tbl_aldeas_caserios_hn_tbl_municipios_hn` FOREIGN KEY (`id_municipio`) REFERENCES `tbl_municipios_hn` (`id_municipio`);

--
-- Filtros para la tabla `tbl_alumnos_himno`
--
ALTER TABLE `tbl_alumnos_himno`
  ADD CONSTRAINT `FK_personas_alumnos_himno` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`),
  ADD CONSTRAINT `horario_himno` FOREIGN KEY (`id_horario_himno`) REFERENCES `tbl_horario_himno` (`id_horario_himno`);

--
-- Filtros para la tabla `tbl_areas`
--
ALTER TABLE `tbl_areas`
  ADD CONSTRAINT `FK_tbl_areas_tbl_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `tbl_carrera` (`id_carrera`);

--
-- Filtros para la tabla `tbl_asignaturas`
--
ALTER TABLE `tbl_asignaturas`
  ADD CONSTRAINT `FK_tbl_asignaturas_tbl_areas` FOREIGN KEY (`id_area`) REFERENCES `tbl_areas` (`id_area`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_asignaturas_tbl_periodo_plan` FOREIGN KEY (`id_periodo_plan`) REFERENCES `tbl_periodo_plan` (`id_periodo_plan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_asignaturas_tbl_plan_estudio` FOREIGN KEY (`id_plan_estudio`) REFERENCES `tbl_plan_estudio` (`id_plan_estudio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_asignaturas_tbl_tipo_asignatura` FOREIGN KEY (`id_tipo_asignatura`) REFERENCES `tbl_tipo_asignatura` (`id_tipo_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_asignaturas_aprobadas`
--
ALTER TABLE `tbl_asignaturas_aprobadas`
  ADD CONSTRAINT `FK__tbl_asignaturas` FOREIGN KEY (`Id_asignatura`) REFERENCES `tbl_asignaturas` (`Id_asignatura`),
  ADD CONSTRAINT `FK__tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_atributos`
--
ALTER TABLE `tbl_atributos`
  ADD CONSTRAINT `FK1id_tipo_persona` FOREIGN KEY (`id_tipo_persona`) REFERENCES `tbl_tipos_persona` (`id_tipo_persona`);

--
-- Filtros para la tabla `tbl_aula`
--
ALTER TABLE `tbl_aula`
  ADD CONSTRAINT `FK_tbl_aula_tbl_edificio` FOREIGN KEY (`id_edificio`) REFERENCES `tbl_edificios` (`id_edificio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_aula_tbl_tipo_aula` FOREIGN KEY (`id_tipo_aula`) REFERENCES `tbl_tipo_aula` (`id_tipo_aula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_carga_academica`
--
ALTER TABLE `tbl_carga_academica`
  ADD CONSTRAINT `FK_tbl_carga_academica_tbl_asignaturas` FOREIGN KEY (`id_asignatura`) REFERENCES `tbl_asignaturas` (`Id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_carga_academica_tbl_periodo` FOREIGN KEY (`id_periodo`) REFERENCES `tbl_periodo` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_carga_academica_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_carga_tbl_aula` FOREIGN KEY (`id_aula`) REFERENCES `tbl_aula` (`id_aula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_hora_final` FOREIGN KEY (`hora_final`) REFERENCES `tbl_hora` (`hora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_hora_inicial` FOREIGN KEY (`hora_inicial`) REFERENCES `tbl_hora` (`hora`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_modalidad` FOREIGN KEY (`id_modalidad`) REFERENCES `tbl_modalidad` (`id_modalidad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_carga_dias`
--
ALTER TABLE `tbl_carga_dias`
  ADD CONSTRAINT `id_carga_academica` FOREIGN KEY (`id_carga_academica`) REFERENCES `tbl_carga_academica` (`id_carga_academica`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_dia` FOREIGN KEY (`id_dia`) REFERENCES `tbl_dias` (`id_dia`);

--
-- Filtros para la tabla `tbl_carrera`
--
ALTER TABLE `tbl_carrera`
  ADD CONSTRAINT `FK__tbl_facultades` FOREIGN KEY (`Id_facultad`) REFERENCES `tbl_facultades` (`Id_facultad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_categoria_personas`
--
ALTER TABLE `tbl_categoria_personas`
  ADD CONSTRAINT `tbl_categoria_personas_tbl_categorias_id_categoria_fk` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categorias` (`id_categoria`),
  ADD CONSTRAINT `tbl_categoria_personas_tbl_personas_id_persona_fk` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_comentarios_alumnos`
--
ALTER TABLE `tbl_comentarios_alumnos`
  ADD CONSTRAINT `personas_comentarios` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_comisiones`
--
ALTER TABLE `tbl_comisiones`
  ADD CONSTRAINT `FK_tbl_comisiones_tbl_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `tbl_carrera` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_contactos`
--
ALTER TABLE `tbl_contactos`
  ADD CONSTRAINT `FK_personas_contactos` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`),
  ADD CONSTRAINT `FK_tipo_contactos` FOREIGN KEY (`id_tipo_contacto`) REFERENCES `tbl_tipo_contactos` (`id_tipo_contacto`);

--
-- Filtros para la tabla `tbl_desea_asig_doce`
--
ALTER TABLE `tbl_desea_asig_doce`
  ADD CONSTRAINT `FK_tbl_desea_asig_doce_tbl_asignaturas` FOREIGN KEY (`Id_asignatura`) REFERENCES `tbl_asignaturas` (`Id_asignatura`),
  ADD CONSTRAINT `FK_tbl_desea_asig_doce_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_desempeno_practica`
--
ALTER TABLE `tbl_desempeno_practica`
  ADD CONSTRAINT `personas_desempeno` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_especialidad_grado`
--
ALTER TABLE `tbl_especialidad_grado`
  ADD CONSTRAINT `FK_tbl_especialidad_grado_tbl_grados_academicos` FOREIGN KEY (`id_grado_academico`) REFERENCES `tbl_grados_academicos` (`id_grado_academico`);

--
-- Filtros para la tabla `tbl_estudiantes_proyecto`
--
ALTER TABLE `tbl_estudiantes_proyecto`
  ADD CONSTRAINT `FK_tbl_estudiantes_proyecto_tbl_proyectos` FOREIGN KEY (`Id_proyecto`) REFERENCES `tbl_proyectos` (`Id_proyecto`);

--
-- Filtros para la tabla `tbl_evaluaciones_practica`
--
ALTER TABLE `tbl_evaluaciones_practica`
  ADD CONSTRAINT `personas_evaluaciones` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_expe_academica_docente`
--
ALTER TABLE `tbl_expe_academica_docente`
  ADD CONSTRAINT `FK_tbl_expe_academica_docente_tbl_areas` FOREIGN KEY (`id_area`) REFERENCES `tbl_areas` (`id_area`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_expe_academica_docente_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_funciones_practica`
--
ALTER TABLE `tbl_funciones_practica`
  ADD CONSTRAINT `personas_funciones` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_grados_academicos_personas`
--
ALTER TABLE `tbl_grados_academicos_personas`
  ADD CONSTRAINT `FK1id_especialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `tbl_especialidad_grado` (`id_especialidad`),
  ADD CONSTRAINT `FK_tbl_grados_academicos_personas_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_horario_docentes`
--
ALTER TABLE `tbl_horario_docentes`
  ADD CONSTRAINT `FK_tbl_horario_docentes_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_horario_docentes_tbl_categoria_pers_id_categoria_persona_fk` FOREIGN KEY (`id_categoria_persona`) REFERENCES `tbl_categoria_personas` (`id_categoria_persona`),
  ADD CONSTRAINT `tbl_horario_docentes_tbl_jornadas_id_jornada_fk` FOREIGN KEY (`id_jornada`) REFERENCES `tbl_jornadas` (`id_jornada`);

--
-- Filtros para la tabla `tbl_municipios_hn`
--
ALTER TABLE `tbl_municipios_hn`
  ADD CONSTRAINT `FK_tbl_municipios_hn_tbl_departamentos` FOREIGN KEY (`id_departamento`) REFERENCES `tbl_departamentos` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_periodo`
--
ALTER TABLE `tbl_periodo`
  ADD CONSTRAINT `FK1_tbl_tipo_periodo` FOREIGN KEY (`id_tipo_periodo`) REFERENCES `tbl_tipo_periodo` (`id_tipo_periodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  ADD CONSTRAINT `FK_tbl_personas_tbl_tipo_docente` FOREIGN KEY (`id_tipo_docente`) REFERENCES `tbl_tipo_docente` (`id_tipo_docente`),
  ADD CONSTRAINT `FK_tbl_personas_tbl_tipos_persona` FOREIGN KEY (`id_tipo_persona`) REFERENCES `tbl_tipos_persona` (`id_tipo_persona`),
  ADD CONSTRAINT `tbl_personas_tbl_tipos_persona_id_tipo_persona_fk` FOREIGN KEY (`id_tipo_persona`) REFERENCES `tbl_tipos_persona` (`id_tipo_persona`);

--
-- Filtros para la tabla `tbl_personas_extendidas`
--
ALTER TABLE `tbl_personas_extendidas`
  ADD CONSTRAINT `FK_tbl_personas_extendidas_tbl_atributos` FOREIGN KEY (`id_atributo`) REFERENCES `tbl_atributos` (`id_atributos`),
  ADD CONSTRAINT `FK_tbl_personas_extendidas_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_plan_estudio`
--
ALTER TABLE `tbl_plan_estudio`
  ADD CONSTRAINT `FK_tbl_plan_estudio_tbl_tipo_plan` FOREIGN KEY (`id_tipo_plan`) REFERENCES `tbl_tipo_plan` (`id_tipo_plan`);

--
-- Filtros para la tabla `tbl_pref_area_docen`
--
ALTER TABLE `tbl_pref_area_docen`
  ADD CONSTRAINT `FK_tbl_pref_area_docen_tbl_areas` FOREIGN KEY (`id_area`) REFERENCES `tbl_areas` (`id_area`),
  ADD CONSTRAINT `FK_tbl_pref_area_docen_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_pref_asig_docen`
--
ALTER TABLE `tbl_pref_asig_docen`
  ADD CONSTRAINT `FK_tbl_pref_asig_docen_tbl_asignaturas` FOREIGN KEY (`Id_asignatura`) REFERENCES `tbl_asignaturas` (`Id_asignatura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_pref_asig_docen_tbl_personas` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  ADD CONSTRAINT `FK_tbl_proyectos_tbl_aldeas_caserios_hn` FOREIGN KEY (`aldea_caserio`) REFERENCES `tbl_aldeas_caserios_hn` (`id_aldea_caserio`),
  ADD CONSTRAINT `FK_tbl_proyectos_tbl_departamentos` FOREIGN KEY (`departamento_pais`) REFERENCES `tbl_departamentos` (`id_departamento`),
  ADD CONSTRAINT `FK_tbl_proyectos_tbl_modalidades_proyecto` FOREIGN KEY (`Id_modalidad`) REFERENCES `tbl_modalidades_proyecto` (`Id_modalidad`),
  ADD CONSTRAINT `FK_tbl_proyectos_tbl_municipios_hn` FOREIGN KEY (`municipio`) REFERENCES `tbl_municipios_hn` (`id_municipio`),
  ADD CONSTRAINT `FK_tbl_proyectos_tbl_tipo_formalizacion_proyecto` FOREIGN KEY (`Id_tipo_formalizacion`) REFERENCES `tbl_tipo_formalizacion_proyecto` (`Id_tipo_formalizacion`),
  ADD CONSTRAINT `FK_tbl_proyectos_tbl_tipos_vinculacion` FOREIGN KEY (`Id_tipo_v`) REFERENCES `tbl_tipos_vinculacion` (`Id_tipo_v`);

--
-- Filtros para la tabla `tbl_requisito_asignatura`
--
ALTER TABLE `tbl_requisito_asignatura`
  ADD CONSTRAINT `FK_tbl_requisito_asignatura_tbl_asignaturas` FOREIGN KEY (`Id_asignatura`) REFERENCES `tbl_asignaturas` (`Id_asignatura`);

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `FK_tbl_usuarios_tbl_roles` FOREIGN KEY (`Id_rol`) REFERENCES `tbl_roles` (`Id_rol`),
  ADD CONSTRAINT `FKpersonas_usuario` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`);

--
-- Filtros para la tabla `tbl_voae_actividades`
--
ALTER TABLE `tbl_voae_actividades`
  ADD CONSTRAINT `FK1_tbl_actividades_voae_tbl_estados` FOREIGN KEY (`id_estado`) REFERENCES `tbl_voae_estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK2_tbl_actividades_voae_tbl_usuarios` FOREIGN KEY (`id_usuario_registro`) REFERENCES `tbl_usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK3_tbl_actividades_voae_tbl_ambitos` FOREIGN KEY (`id_ambito`) REFERENCES `tbl_voae_ambitos` (`id_ambito`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_voae_asistencias`
--
ALTER TABLE `tbl_voae_asistencias`
  ADD CONSTRAINT `FK1_tbl_asistencias_tbl_actividad_voae` FOREIGN KEY (`id_actividad_voae`) REFERENCES `tbl_voae_actividades` (`id_actividad_voae`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_voae_faltas_conductas`
--
ALTER TABLE `tbl_voae_faltas_conductas`
  ADD CONSTRAINT `FK1_tbl_faltas_tbl_usuario_alumno` FOREIGN KEY (`id_persona_alumno`) REFERENCES `tbl_personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK2_tbl_faltas_tbl_usuario_registro` FOREIGN KEY (`id_usuario_registro`) REFERENCES `tbl_usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK3_tbl_faltas_tbl_tipo_falta` FOREIGN KEY (`id_tipo_falta`) REFERENCES `tbl_voae_tipos_faltas` (`id_falta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_voae_informes`
--
ALTER TABLE `tbl_voae_informes`
  ADD CONSTRAINT `FK_tbl_voae_informes_tbl_usuarios` FOREIGN KEY (`id_usuario_registro`) REFERENCES `tbl_usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_voae_informes_tbl_voae_actividades` FOREIGN KEY (`id_actividad`) REFERENCES `tbl_voae_actividades` (`id_actividad_voae`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_voae_informes_tbl_voae_estados` FOREIGN KEY (`id_estado`) REFERENCES `tbl_voae_estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_voae_informes_tbl_voae_repositorios` FOREIGN KEY (`id_repositorio`) REFERENCES `tbl_voae_repositorios` (`id_repositorio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_voae_repositorios`
--
ALTER TABLE `tbl_voae_repositorios`
  ADD CONSTRAINT `FK_tbl_voae_repositorios_automatizacion.tbl_usuarios` FOREIGN KEY (`id_usuario_registro`) REFERENCES `tbl_usuarios` (`Id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbl_voae_repositorios_tbl_voae_tipos_repositorios` FOREIGN KEY (`id_tipo_repositorio`) REFERENCES `tbl_voae_tipos_repositorios` (`id_repositorio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
