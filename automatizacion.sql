-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2020 a las 17:51:55
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_cambio_carrera` (IN `NUMEROCUENTA` BIGINT(16), IN `RAZON` VARCHAR(2000), IN `COD_CENTROREGI` BIGINT(16), IN `id_facultad` BIGINT(16), IN `documento` VARCHAR(255))  BEGIN
START TRANSACTION;


 SELECT @id_estudiante := id_usuario FROM tbl_usuarios
 WHERE numero_cuenta = NUMEROCUENTA;
 

INSERT INTO `tbl_cambio_carrera`
  (
    `id_usuario`,
    `razon_cambio`,
    `id_centro_regional`,
    `id_facultad`,
    `documento`,
    `aprobado`,
    `fecha_creacion`
    
  )
VALUES
  (
     @id_estudiante,
    RAZON,
    COD_CENTROREGI,
    id_facultad,
    documento,
    'desaprobado',
    now()
  );

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_cancelar_clases` (IN `NUMEROCUENTA` BIGINT(16), IN `RAZON` VARCHAR(2000), IN `documento` VARCHAR(255))  BEGIN
START TRANSACTION;


SELECT @id_estudiante := id_usuario FROM tbl_usuarios
WHERE numero_cuenta = NUMEROCUENTA;

 
 

INSERT INTO `tbl_cancelar_clases`
  (
    `Id_usuario`,
    `motivo`,
    `documento`,
    `cambio`,
    `fecha_creacion`
    
  )
VALUES
  (
     @id_estudiante,
    RAZON,
    documento,
    'desaprobado',
    now()
  );

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_carta_egresado` (IN `ncuenta` BIGINT(20), IN `documento` VARCHAR(250))  BEGIN
START TRANSACTION;

  
  SELECT @id_estudiante := id_usuario
  FROM tbl_usuarios 
  WHERE numero_cuenta= ncuenta;
  
 
 insert into `tbl_carta_egresado`(
    `id_usuario`,
    `fecha_creacion`,
    `documento`,
    `aprobado`
    )
    
  values
    (
 
    @id_estudiante,
    now(),
    documento,
    'desaprobado'
    );
       
    
    COMMIT;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_equivalencias` (IN `NUMEROCUENTA` BIGINT(20), IN `documento` VARCHAR(255))  BEGIN
START TRANSACTION;


SELECT @COD_ESTUDIANTE := id_usuario FROM `tbl_usuarios`
WHERE numero_cuenta = NUMEROCUENTA;


INSERT INTO `tbl_equivalencias`
  (
    `id_usuario`,
    `fecha_creacion`,
    `aprobado`,
    `documento`
    
  )
VALUES
  (
    @COD_ESTUDIANTE,
    now(),
    'desaprobado',
    documento
  );

COMMIT;
END$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_finalizacion_practica` (IN `numero_cuenta` BIGINT(16), IN `documento` VARCHAR(255))  BEGIN
START TRANSACTION;

  
  SELECT @id_estudiante := e.id_usuario, @id_practica := ep.id_practica
  FROM tbl_usuarios e, tbl_practica_estudiantes ep
  WHERE e.id_usuario = ep.id_usuario and
  e.numero_cuenta= numero_cuenta;
  
 
 insert into `tbl_finalizacion_practica`(
    `id_practica`,
    `id_usuario`,
    `fecha_creacion`,
    `documento`,
    `aprobado`
    )
    
  values
    (
  
    @id_practica,
    @id_estudiante,
    now(),
    documento,
    'desaprobado'
    );
       
    
    COMMIT;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_asistencia_charla` (IN `Id_charla_` BIGINT, IN `jornada_` VARCHAR(50), IN `asistencia_` INT, IN `fecha_recibida_` DATE)  BEGIN
update tbl_charla_practica set fecha_recibida=fecha_recibida_,estado_asistencia_charla=asistencia_, fecha_valida=(select DATE_ADD(fecha_recibida_,INTERVAL (select valor from tbl_parametros where parametro="DIAS_CHARLA") DAY))

where Id_charla=Id_charla_ and jornada=jornada_;

update tbl_charla_practica set charla_impartida=1 where fecha_recibida=fecha_recibida_;


end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_cambio_empresa_estudiante_practica` (IN `cuenta_` VARCHAR(255))  BEGIN
 UPDATE tbl_subida_documentacion set estado_vinculacion=3 , estado_coordinacion=null where Id_usuario=(select Id_usuario from tbl_usuarios where numero_cuenta=cuenta_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_clave_x_pregunta` (`contrasena_` VARCHAR(150), `Id_usuario_` INTEGER)  begin
UPDATE tbl_usuarios SET    Contrasena=contrasena_ WHERE Id_usuario=Id_usuario_;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_documentos_practica_vinculacion` (IN `cuenta_` VARCHAR(255), IN `vinculacion_` INT, IN `observacion_vinculacion_` VARCHAR(255))  BEGIN

UPDATE `tbl_subida_documentacion` SET `fecha_vinculacion`=sysdate(),`estado_vinculacion`=vinculacion_,`observacion_vinculacion`=observacion_vinculacion_ WHERE `Id_usuario`=(select Id_usuario from tbl_usuarios where numero_cuenta=cuenta_);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_empresa_practica` (IN `nombre_empresa_` VARCHAR(255), IN `direccion_empresa_` VARCHAR(255), IN `departamento_empresa_` VARCHAR(255), IN `jefe_inmediato_` VARCHAR(255), IN `titulo_jefe_inmediato_` VARCHAR(255), IN `cargo_jefe_inmediato_` VARCHAR(255), IN `correo_jefe_inmediato_` VARCHAR(255), IN `telefono_jefe_inmediato_` VARCHAR(10), IN `Id_usuario_` BIGINT(16), IN `Id_empresa_` BIGINT(16))  BEGIN

UPDATE tbl_empresas_practica
SET nombre_empresa = nombre_empresa_,
direccion_empresa= direccion_empresa_,
departamento_empresa = departamento_empresa_,
jefe_inmediato = jefe_inmediato_,
titulo_jefe_inmediato =titulo_jefe_inmediato_,
cargo_jefe_inmediato =cargo_jefe_inmediato_,
correo_jefe_inmediato =correo_jefe_inmediato_,
telefono_jefe_inmediato =telefono_jefe_inmediato_, 
Id_usuario=Id_usuario_ 

WHERE
  Id_empresa = Id_empresa_ ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_permiso_usuario` (IN `insertar_` INT, IN `Modificar_` INT, IN `Eliminar_` INT, IN `Visualizar_` INT, IN `usuario_` VARCHAR(150), IN `id_permiso_` INT)  BEGIN

UPDATE tbl_permisos_usuarios SET   insertar=insertar_ , modificar=Modificar_, eliminar=Eliminar_, visualizar=Visualizar_ , Fecha_modificacion=sysdate() , Modificado_por=usuario_ WHERE Id_permisos_usuario= id_permiso_ ;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_actualizar_usuario` (IN `Usuario_` VARCHAR(150), IN `Id_rol_` INT, IN `Nombre_` VARCHAR(150), IN `correo_` VARCHAR(150), IN `Modificado_` VARCHAR(150), IN `Id_usuario_` INT, IN `Estado_` INT)  begin

UPDATE tbl_usuarios SET   Usuario=Usuario_, Id_rol=Id_rol_, nombre_completo=Nombre_, Correo_electronico=correo_ , Fecha_modificacion=sysdate() , Modificado_por=Modificado_ ,Estado=Estado_  WHERE Id_usuario= Id_usuario_ ;

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_aprobacion_practica` (IN `cuenta_` VARCHAR(50), IN `obs_` VARCHAR(255), IN `tipo_` INT, IN `empresa_` VARCHAR(255))  BEGIN

IF tipo_=1 THEN

UPDATE tbl_subida_documentacion set estado_coordinacion=1, fecha_coordinacion=sysdate(),motivo_coordinacion=obs_ where Id_usuario=(select Id_usuario from tbl_usuarios where numero_cuenta= cuenta_);

ELSEIF tipo_=0 then
UPDATE tbl_subida_documentacion set estado_coordinacion=0 , fecha_coordinacion=sysdate(), motivo_coordinacion=obs_ where Id_usuario=(select Id_usuario from tbl_usuarios where numero_cuenta= cuenta_);

INSERT INTO `tbl_practica_rechazo`(`Id_usuario`, `nombre_empresa`, `motivo`, `fecha_creacion`) VALUES ((select Id_usuario from tbl_usuarios where numero_cuenta= cuenta_),empresa_,obs_,sysdate());

ELSE
UPDATE tbl_subida_documentacion set estado_coordinacion=NULL, estado_vinculacion=0, fecha_coordinacion=sysdate(), observacion_vinculacion=obs_ where Id_usuario=(select Id_usuario from tbl_usuarios where numero_cuenta= cuenta_);


end if;


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

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_asignaturas_aprobadas` (IN `Id_asignatura_` INT, IN `Id_usuario_` INT)  BEGIN


INSERT INTO `tbl_asignaturas_aprobadas`( `Id_asignatura`, `Id_usuario`, `Fecha_creacion`)
VALUES (Id_asignatura_ ,Id_usuario_, sysdate());



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_egresado` (IN `nombre_` VARCHAR(255), IN `cuenta_` BIGINT(13), IN `correo_` VARCHAR(255), IN `celular_` VARCHAR(12), IN `telefono_` VARCHAR(12), IN `fecha_graduacion_` VARCHAR(5), IN `posee_maestria_` CHAR(2), IN `maestria_` VARCHAR(255), IN `posee_certificado_` CHAR(2), IN `certificado_` VARCHAR(255), IN `labora_` CHAR(2), IN `nombre_empresa_` VARCHAR(255), IN `direccion_empresa_` VARCHAR(255), IN `telefono_empresa_` VARCHAR(12), IN `departamento_egresado_` VARCHAR(255), IN `correo_profesional_` VARCHAR(255))  BEGIN

INSERT INTO tbl_egresados(nombre, cuenta, correo_electronico, celular_egresado,telefono_egresado, fecha_graduacion,posee_maestria,maestria,posee_certificado,certificado,labora,nombre_empresa,direccion_empresa, telefono_empresa,departamento_egresado,correo_profesional,Fecha_creacion) VALUES (nombre_,cuenta_,correo_, celular_,telefono_,fecha_graduacion_,posee_maestria_,maestria_,posee_certificado_,certificado_, labora_, nombre_empresa_,direccion_empresa_,telefono_empresa_,departamento_egresado_,correo_profesional_,sysdate());

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_empresa_practica` (IN `nombre_empresa_` VARCHAR(255), IN `direccion_empresa_` VARCHAR(255), IN `departamento_empresa_` VARCHAR(255), IN `jefe_inmediato_` VARCHAR(255), IN `titulo_jefe_inmediato_` VARCHAR(255), IN `cargo_jefe_inmediato_` VARCHAR(255), IN `correo_jefe_inmediato_` VARCHAR(255), IN `telefono_jefe_inmediato_` VARCHAR(10), IN `Id_usuario_` BIGINT(16))  BEGIN

INSERT INTO `tbl_empresas_practica`(`Id_usuario`, `nombre_empresa`, `direccion_empresa`, `departamento_empresa`, `jefe_inmediato`, `titulo_jefe_inmediato`, `cargo_jefe_inmediato`, `correo_jefe_inmediato`, `telefono_jefe_inmediato`, `Fecha_creacion`)

VALUES( Id_usuario_,nombre_empresa_ , direccion_empresa_ , departamento_empresa_ , jefe_inmediato_ , titulo_jefe_inmediato_ , cargo_jefe_inmediato_ , correo_jefe_inmediato_ ,telefono_jefe_inmediato_  ,SYSDATE());

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_estudiante` (`usuario_` VARCHAR(255), `nombre_completo_` VARCHAR(255), `numero_cuenta_` BIGINT(16), `correo_` VARCHAR(255), `contraseña_` VARCHAR(255))  BEGIN
INSERT
INTO
  tbl_usuarios(
    Id_rol,
    Usuario,
    nombre_completo,
    numero_cuenta,
    estado,
    Correo_Electronico,
    Contrasena,
    Fecha_creacion
  )
VALUES(
  49,
  usuario_,
  nombre_completo_,
  numero_cuenta_,
  2,
  correo_,
  contraseña_,
  SYSDATE());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_inscripcion_charla` (IN `Id_usuario_` BIGINT, IN `no_constancia_` VARCHAR(15), IN `promedio_global_` VARCHAR(15), IN `clases_aprobadas_` VARCHAR(15), IN `porcentaje_clases_` VARCHAR(10), IN `jornada_` VARCHAR(50))  BEGIN
INSERT INTO tbl_charla_practica ( `Id_usuario`, `no_constancia`, `promedio_global`, `clases_aprobadas`, `porcentaje_clases`, `jornada`, `estado_asistencia_charla`,`charla_impartida`) VALUES (Id_usuario_,no_constancia_,promedio_global_, clases_aprobadas_,porcentaje_clases_,jornada_,0,0);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_pregunta` (`preguntav` VARCHAR(150), `estadov` INTEGER, `Creado_porv` VARCHAR(200))  BEGIN

 INSERT INTO  tbl_preguntas(pregunta,estado,Fecha_creacion,Creado_por)
    			 VALUES (preguntav,estadov,sysdate(),Creado_porv);
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_pregunta_usuario` (`Id_pregunta_` INTEGER, `Id_usuario_` INTEGER, `Respuesta_` VARCHAR(150))  begin 
INSERT INTO  tbl_preguntas_seguridad (Id_pregunta,Id_usuario,Respuesta)
						    			 VALUES (Id_pregunta_,Id_usuario_, Respuesta_ );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_proyecto` (IN `Id_tipo_v_` BIGINT(16), IN `Id_modalidad_` BIGINT(16), IN `nombre_` VARCHAR(255), IN `codigo_proyecto_` BIGINT(16), IN `tipo_proyecto_` VARCHAR(255), IN `estado_` BIGINT(16), IN `beneficiarios_directos_` BIGINT(16), IN `beneficiarios_indirectos_` BIGINT(16), IN `nombre_empresa_` VARCHAR(255), IN `nombre_contacto_institucional_` VARCHAR(255), IN `cargo_contacto_institucional_` VARCHAR(255), IN `telefono_contacto_institucional_` INT(8), IN `correo_contacto_institucional_` VARCHAR(255), IN `cant_beneficiarios_` BIGINT(16), IN `fecha_inicio_ejecucion_` DATE, IN `fecha_final_ejecucion_` DATE, IN `fecha_inicio_evaluacion_` DATE, IN `fecha_final_evaluacion_` DATE, IN `costo_` INT(10), IN `Id_usuario_` BIGINT(16), IN `Id_asignatura_` BIGINT(16), IN `Id_tipo_formalizacion_` BIGINT(16), IN `Id_aporte_` BIGINT(16), IN `region_` VARCHAR(255), IN `departamento_pais_` VARCHAR(255), IN `municipio_` VARCHAR(255), IN `aldea_caserio_` VARCHAR(255), IN `barrio_colonia_` VARCHAR(255), IN `entidad_beneficiaria_` VARCHAR(255), IN `objetivos_desarrollo_` VARCHAR(255), IN `objetivos_inmediatos_` VARCHAR(255), IN `resultados_` VARCHAR(255), IN `actividades_` VARCHAR(255), IN `departamento_` VARCHAR(255))  BEGIN
INSERT
INTO
  `tbl_proyectos`(
    `Id_tipo_v`,
    `Id_modalidad`,
    `nombre`,
    `codigo_proyecto`,
    `tipo_proyecto`,
    `estado`,
    `beneficiarios_directos`,
    `beneficiarios_indirectos`,
    `nombre_empresa`,
    `nombre_contacto_institucional`,
    `cargo_contacto_institucional`,
    `telefono_contacto_institucional`,
    `correo_contacto_institucional`,
    `cant_beneficiarios`,
    `fecha_inicio_ejecucion`,
    `fecha_final_ejecucion`,
    `fecha_inicio_evaluacion`,
    `fecha_final_evaluacion`,
    `costo`,
    `Id_usuario`,
    `Fecha_creación`,
    `Id_asignatura`,
    `Id_tipo_formalizacion`,
    `Id_aporte`,
    `region`,
    `departamento_pais`,
    `municipio`,
    `aldea_caserio`,
    `barrio_colonia`,
    `entidad_beneficiaria`,
    `objetivos_desarrollo`,
    `objetivos_inmediatos`,
    `resultados`,
    `actividades`,
    `departamento`
  )
VALUES(
  Id_tipo_v_,
  Id_modalidad_,
  nombre_,
  codigo_proyecto_,
  tipo_proyecto_,
  estado_,
  beneficiarios_directos_,
  beneficiarios_indirectos_,
  nombre_empresa_,
  nombre_contacto_institucional_,
  cargo_contacto_institucional_,
  telefono_contacto_institucional_,
  correo_contacto_institucional_,
  cant_beneficiarios_,
 fecha_inicio_ejecucion_, fecha_final_ejecucion_, fecha_inicio_evaluacion_,fecha_final_evaluacion_, costo_, Id_usuario_, SYSDATE(), Id_asignatura_, Id_tipo_formalizacion_, Id_aporte_, region_, departamento_pais_, municipio_, aldea_caserio_, barrio_colonia_, entidad_beneficiaria_, objetivos_desarrollo_, objetivos_inmediatos_, resultados_, actividades_, departamento_);
 
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_rol` (`n_rol` VARCHAR(150), `descripcionrol` VARCHAR(250), `estado_` INTEGER, `usuario_` VARCHAR(150))  BEGIN


INSERT INTO  tbl_roles(rol, descripcion, estado,Fecha_creacion,Creado_por)
    			 VALUES (n_rol, descripcionrol, estado_, sysdate()
           ,usuario_);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_subida_informacion` (`Id_usuario_` BIGINT(16))  begin

INSERT INTO `tbl_subida_documentacion`( `Id_usuario`,`fecha_creacion`) VALUES (Id_usuario_,sysdate());


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_usuario` (`Usuario_` VARCHAR(150), `nombre_completo_` VARCHAR(150), `Id_rol_` INTEGER, `Contrasena_` VARCHAR(150), `Correo_electronico_` VARCHAR(150), `estado_` INTEGER, `Creado_por_` VARCHAR(150))  BEGIN

INSERT INTO  tbl_usuarios(Usuario, nombre_completo, Id_rol , Contrasena, Correo_electronico, estado,Fecha_creacion, Creado_por)
    			 VALUES (Usuario_, nombre_completo_ ,Id_rol_, Contrasena_,Correo_electronico_,estado_, sysdate(),Creado_por_ );
                 
end$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_cambio_carrera` ()  BEGIN

SELECT e.nombre_completo, e.numero_cuenta, e.correo_electronico, cc.razon_cambio,
cr.centro_regional, f.nombre
FROM tbl_usuarios e, tbl_cambio_carrera cc, tbl_centros_regionales cr, tbl_facultades f
WHERE cc.id_usuario = e.Id_usuario
AND cr.Id_centro_regional = cc.Id_centro_regional
AND f.Id_facultad = cc.id_facultad
AND cc.aprobado != 'aprobado'
GROUP BY e.nombre_completo;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_cambio_carrera_unica` (IN `numero_cuenta` BIGINT(25))  BEGIN

SELECT e.nombre_completo,e.numero_cuenta,e.correo_electronico, cc.documento, 
cc.razon_cambio ,cr.centro_regional, f.nombre
FROM tbl_usuarios e , tbl_cambio_carrera cc, tbl_centros_regionales cr , tbl_facultades f
WHERE e.Id_usuario = cc.Id_usuario
AND e.numero_cuenta = numero_cuenta
AND cr.Id_centro_regional = cc.Id_centro_regional
AND f.Id_facultad = cc.id_facultad
GROUP BY e.nombre_completo;



COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_cancelar_clases` ()  BEGIN

SELECT e.nombre_completo, e.numero_cuenta, e.correo_electronico, ca.motivo
FROM tbl_usuarios e, tbl_cancelar_clases ca
WHERE ca.Id_usuario = e.id_usuario
AND ca.cambio != 'aprobado'
GROUP BY e.nombre_completo;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_cancelar_clases_unica` (IN `cuenta` BIGINT(20))  BEGIN

SELECT e.nombre_completo, e.numero_cuenta, e.correo_electronico, ca.motivo, ca.documento
FROM tbl_usuarios e, tbl_cancelar_clases ca
WHERE ca.id_usuario = e.Id_usuario
AND e.numero_cuenta = cuenta
GROUP BY e.nombre_completo;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_carta_egresado` ()  BEGIN

SELECT e.nombre_completo,e.numero_cuenta,e.correo_electronico,e.telefono,c.aprobado
FROM tbl_usuarios e, tbl_carta_egresado c
WHERE  e.Id_usuario = c.id_usuario
AND c.aprobado != 'aprobado'
GROUP BY e.nombre_completo;



COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_carta_egresado_unica` (IN `numero_cuenta` BIGINT(25))  BEGIN

SELECT e.nombre_completo,e.numero_cuenta,e.correo_electronico,e.telefono, c.documento
FROM tbl_usuarios e , tbl_carta_egresado c
WHERE e.numero_cuenta = 20131015093
AND e.id_usuario = c.Id_usuario
GROUP BY e.nombre_completo;



COMMIT;
END$$

CREATE DEFINER=`cneumann`@`%` PROCEDURE `sel_carta_presentacion` (IN `cod_empresa` BIGINT)  begin

select ep.cod_empresa,  ep.nombre
,ep.contacto_interno, ep.puesto,
ep.grado_academico, e.nombre, e.numero_cuenta
from empresas ep, estudiantes e
where  cp.cod_estudiante= e.cod_estudiante
group by cp.cod_estudiante;

commit;
end$$

CREATE DEFINER=`cneumann`@`%` PROCEDURE `sel_constancia_clases` (IN `cod_estudiante` BIGINT)  begin

select e.cod_estudiante,  e.nombres
,e.apellidos,e.numero_cuenta, cp.clases_aprobadas,
cp.porcentaje_clases
from charla_practica cp, estudiantes e
where  cp.cod_estudiante= e.cod_estudiante
group by cp.cod_estudiante;

commit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_equivalencias` ()  BEGIN

SELECT e.nombre_completo, e.numero_cuenta, e.correo_electronico
FROM tbl_usuarios e, tbl_equivalencias eq
WHERE e.id_usuario = eq.Id_usuario
AND eq.aprobado != 'aprobado'
GROUP BY e.nombre_completo;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_equivalencias_unica` (IN `cuenta` BIGINT(20))  BEGIN

SELECT e.nombre_completo, e.numero_cuenta, e.correo_electronico, eq.documento
FROM tbl_usuarios e, tbl_equivalencias eq
WHERE eq.id_usuario = e.Id_usuario
AND e.numero_cuenta = cuenta
GROUP BY e.nombre_completo;


COMMIT;
END$$

CREATE DEFINER=`cneumann`@`%` PROCEDURE `sel_estudiante_charla` (IN `cod_charla` BIGINT)  begin

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_finalizacion_practica` ()  BEGIN

SELECT e.nombre_completo,e.numero_cuenta,e.correo_electronico,emp.nombre_empresa , emp.jefe_inmediato, f.aprobado
FROM tbl_usuarios e,tbl_empresas_practica emp , tbl_finalizacion_practica f
WHERE e.id_usuario = emp.id_usuario
AND e.Id_usuario = f.id_usuario
AND f.aprobado != 'aprobado'
GROUP BY e.nombre_completo;



COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sel_finalizacion_practica_unica` (IN `numero_cuenta` BIGINT(25))  BEGIN

SELECT e.nombre_completo,e.numero_cuenta,e.correo_electronico,emp.nombre_empresa , emp.jefe_inmediato, f.documento
FROM tbl_usuarios e,tbl_empresas_practica emp, tbl_finalizacion_practica f
WHERE e.id_usuario = emp.id_usuario
AND e.numero_cuenta = numero_cuenta
AND e.id_usuario = f.id_usuario
GROUP BY e.nombre_completo;



COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_cambio_carrera` (IN `APROBADO` VARCHAR(50), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

SELECT @id_estudiante := id_usuario
FROM tbl_usuarios 
WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_cambio_carrera`
  
  SET `aprobado` = APROBADO,
      `fecha_creacion` = now()
  WHERE id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_cambio_carrera_observacion` (IN `APROBADO` VARCHAR(50), IN `OBSERVACION` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

SELECT @id_estudiante := id_usuario
FROM tbl_usuarios 
WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_cambio_carrera`
  
  SET `aprobado`        = APROBADO,
      `observacion`     = OBSERVACION,
      `fecha_creacion`  = now()
  WHERE id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_cancelar_clases` (IN `APROBADO` VARCHAR(50), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

SELECT @id_estudiante := Id_usuario
FROM tbl_usuarios 
WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_cancelar_clases`
  
  SET `cambio` = APROBADO,
      `fecha_creacion`  = now()
  WHERE Id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_cancelar_clases_observacion` (IN `APROBADO` VARCHAR(50), IN `OBSERVACION` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

SELECT @id_estudiante := Id_usuario
FROM tbl_usuarios 
WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_cancelar_clases`
  
  SET `cambio` = APROBADO,
      `observacion`     = OBSERVACION,
      `fecha_creacion`  = now()
  WHERE Id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_carta_egresado` (IN `aprobado` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

 SELECT @id_estudiante := id_usuario
  FROM tbl_usuarios 
  WHERE numero_cuenta= ncuenta;


  UPDATE `tbl_carta_egresado`
  
  SET `aprobado` = APROBADO,
      `fecha_creacion` = now()
  WHERE id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_carta_egresado_observacion` (IN `aprobado` VARCHAR(255), IN `observacion` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

 SELECT @id_estudiante := id_usuario
  FROM tbl_usuarios 
  WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_carta_egresado`
  
  SET `aprobado`        = APROBADO,
      `observacion`     = OBSERVACION,
      `fecha_creacion`  = now()
  WHERE id_usuario = @id_estudiante;

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_equivalencias` (IN `APROBADO` VARCHAR(50), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

SELECT @id_estudiante := id_usuario
FROM tbl_usuarios 
WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_equivalencias`
  
  SET `aprobado` = APROBADO,
      `fecha_creacion` = now()
  WHERE id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_equivalencias_observacion` (IN `APROBADO` VARCHAR(50), IN `OBSERVACION` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

SELECT @id_estudiante := id_usuario
FROM tbl_usuarios 
WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_equivalencias`
  
  SET `aprobado` = APROBADO,
      `observacion`     = OBSERVACION,
      `fecha_creacion`  = now()
  WHERE id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_finalizacion_practica` (IN `aprobado` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

 SELECT @id_estudiante := id_usuario
  FROM tbl_usuarios 
  WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_finalizacion_practica`
  
  SET `aprobado` = APROBADO,
      `fecha_creacion` = now()
  WHERE id_usuario = @id_estudiante;


COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `upd_finalizacion_practica_observacion` (IN `aprobado` VARCHAR(255), IN `observacion` VARCHAR(255), IN `ncuenta` BIGINT(20))  BEGIN
START TRANSACTION;

 SELECT @id_estudiante := id_usuario
  FROM tbl_usuarios 
  WHERE numero_cuenta= ncuenta;

  UPDATE `tbl_finalizacion_practica`
  
  SET `aprobado`        = APROBADO,
      `observacion`     = OBSERVACION,
      `fecha_creacion`  = now()
  WHERE id_usuario = @id_estudiante;
  

COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignaturas`
--

CREATE TABLE `tbl_asignaturas` (
  `Id_asignatura` bigint(16) NOT NULL,
  `asignatura` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_asignaturas`
--

INSERT INTO `tbl_asignaturas` (`Id_asignatura`, `asignatura`) VALUES
(1, 'ESPAÑOL'),
(2, 'FILOSOFIAÑ'),
(3, 'SOCIOLOGIA'),
(4, 'METODOS CUANTITATIVOS I'),
(5, 'OPTATIVA_1'),
(6, 'INGLES I'),
(7, 'HISTORIA DE HONDURAS'),
(8, 'OPTATIVA_2'),
(9, 'TALLER DE HARDWARE I'),
(10, 'METODOLOGIA DE LA PROGRAMACION'),
(11, 'INTRODUCCION A LA INFORMATICA'),
(12, 'METODOS CUANTITATIVOS II'),
(13, 'CONTABILIDAD I'),
(14, 'PRINCIPIOS DE ECONOMIA'),
(15, 'METODOS CUANTITATIVOS III'),
(16, 'LENGUAJE DE PROGRAMACION I'),
(17, 'METODOS CUANTITATIVOS EN FINANZAS'),
(18, 'ADMINISTRACION I'),
(19, 'TALLER DE HARDWARE II'),
(20, 'LENGUAJE DE PROGRAMACION III'),
(21, 'LENGUAJE DE PROGRAMACION II'),
(22, 'SISTEMAS OPERATIVOS I'),
(23, 'ADMINISTRACION II'),
(24, 'ANALISIS NUMERICO'),
(25, 'CONTABILIDAD II'),
(26, 'PERSPECTIVAS DE LA TECNOLOGIA INFORMATICA'),
(27, 'SISTEMAS OPERATIVOS II'),
(28, 'ANALISIS CUANTITATIVO I'),
(29, 'BASE DE DATOS I'),
(30, 'MICROECONOMIA'),
(31, 'LENGUAJE DE PROGRAMACION IV'),
(32, 'TEORIA DE SISTEMAS'),
(33, 'BASE DE DATOS II'),
(34, 'CONTABILIDAD ADMINISTRATIVA I'),
(35, 'FINANZAS DE EMPRESAS'),
(36, 'COMUNICACION ELECTRONICA DE DATOS'),
(37, 'ANALISIS Y DISEÑO DE SISTEMAS'),
(38, 'RECURSOS HUMANOS EN INFORMATICA'),
(39, 'ANALISIS CUANTITATIVO II'),
(40, 'REDES DE COMPUTADORAS'),
(41, 'PROGRAMACION E IMPLEMENTACION DE SISTEMAS'),
(42, 'ADMINISTRACION PUBLICA Y POLITICA INFORMATICA'),
(43, 'MACROECONOMIA'),
(44, 'ORGANIZACION Y METODOS DE LA INFORMATICA'),
(45, 'GERENCIA EN INFORMATICA I'),
(46, 'EVALUACION DE SISTEMAS'),
(47, 'CONTABILIDAD ADMINSTRATIVA II'),
(48, 'PERSPECTIVA DE LA TECNOLOGIA INFORMATICA'),
(49, 'AUDITORIA EN INFORMATICA'),
(50, 'GERENCIA EN INFORMATICA II'),
(51, 'SEMINARIO DE INVESTIGACION'),
(52, 'ADMON Y EVALUACION DE PROYECTOS EN INFORMATICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignaturas_aprobadas`
--

CREATE TABLE `tbl_asignaturas_aprobadas` (
  `Id_asignatura_aprobada` bigint(16) NOT NULL,
  `Id_asignatura` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_asignaturas_aprobadas`
--

INSERT INTO `tbl_asignaturas_aprobadas` (`Id_asignatura_aprobada`, `Id_asignatura`, `Id_usuario`, `Fecha_creacion`) VALUES
(12, 1, 1, '2020-06-08 15:48:31'),
(13, 2, 1, '2020-06-08 15:48:32'),
(14, 42, 1, '2020-06-08 15:48:32'),
(15, 52, 1, '2020-06-08 15:48:32'),
(16, 39, 2, '2020-06-08 15:48:32'),
(17, 18, 2, '2020-06-09 16:50:50'),
(18, 23, 2, '2020-06-09 16:50:50'),
(19, 42, 2, '2020-06-09 16:51:37'),
(20, 52, 2, '2020-06-09 16:58:14'),
(21, 28, 2, '2020-06-09 16:58:36'),
(22, 24, 2, '2020-06-09 16:58:36'),
(23, 18, 1, '2020-06-09 17:05:21'),
(24, 23, 1, '2020-06-09 17:05:21'),
(25, 39, 1, '2020-06-09 17:17:23'),
(26, 28, 1, '2020-06-09 17:17:26'),
(27, 24, 1, '2020-06-09 17:17:30'),
(28, 37, 2, '2020-06-09 17:20:30'),
(29, 49, 2, '2020-06-09 17:20:33'),
(30, 29, 2, '2020-06-09 17:20:36'),
(31, 33, 1, '2020-06-16 17:04:10'),
(32, 36, 1, '2020-06-16 17:04:14'),
(33, 13, 1, '2020-06-16 17:04:17'),
(34, 25, 1, '2020-06-16 17:04:20'),
(35, 26, 1, '2020-06-16 17:12:01'),
(36, 31, 1, '2020-06-16 17:12:04'),
(37, 33, 2, '2020-06-16 17:17:07'),
(38, 36, 2, '2020-06-16 17:17:10'),
(39, 34, 2, '2020-06-16 17:17:13'),
(40, 47, 2, '2020-06-16 17:17:16'),
(41, 13, 2, '2020-06-16 17:17:19'),
(42, 25, 2, '2020-06-16 17:17:22'),
(43, 1, 2, '2020-06-16 17:17:25'),
(44, 26, 2, '2020-06-16 17:18:43'),
(45, 31, 2, '2020-06-16 17:18:46'),
(46, 19, 2, '2020-06-16 17:20:34'),
(47, 44, 2, '2020-06-16 17:24:06'),
(48, 3, 2, '2020-06-16 17:24:09'),
(49, 20, 1, '2020-06-18 17:44:15'),
(50, 37, 1, '2020-06-18 17:46:07'),
(51, 49, 1, '2020-06-18 17:46:07'),
(52, 46, 1, '2020-06-18 17:56:07'),
(53, 29, 1, '2020-06-18 18:00:49'),
(54, 47, 1, '2020-06-18 18:00:49'),
(55, 44, 1, '2020-06-18 18:00:50'),
(56, 9, 3, '2020-06-18 23:23:48'),
(57, 19, 3, '2020-06-18 23:23:51'),
(58, 23, 13, '2020-06-25 16:14:55'),
(59, 42, 13, '2020-06-25 16:14:58'),
(60, 52, 13, '2020-06-25 16:15:01'),
(61, 39, 13, '2020-06-25 16:15:04'),
(62, 28, 13, '2020-06-25 16:15:07'),
(63, 24, 13, '2020-06-25 16:15:11'),
(64, 37, 13, '2020-06-25 16:15:14'),
(65, 49, 13, '2020-06-25 16:15:17'),
(66, 29, 13, '2020-06-25 16:15:20'),
(67, 33, 13, '2020-06-25 16:15:23'),
(68, 36, 13, '2020-06-25 16:15:26'),
(69, 34, 13, '2020-06-25 16:15:29'),
(70, 47, 13, '2020-06-25 16:15:32'),
(71, 13, 13, '2020-06-25 16:15:35'),
(72, 25, 13, '2020-06-25 16:15:39'),
(73, 1, 13, '2020-06-25 16:15:42'),
(74, 46, 13, '2020-06-25 16:15:45'),
(75, 2, 13, '2020-06-25 16:15:48'),
(76, 35, 13, '2020-06-25 16:15:51'),
(77, 45, 13, '2020-06-25 16:15:54'),
(78, 50, 13, '2020-06-25 16:15:57'),
(79, 7, 13, '2020-06-25 16:16:00'),
(80, 6, 13, '2020-06-25 16:16:03'),
(81, 11, 13, '2020-06-25 16:16:06'),
(82, 16, 13, '2020-06-25 16:16:10'),
(83, 21, 13, '2020-06-25 16:16:13'),
(84, 20, 13, '2020-06-25 16:16:16'),
(85, 26, 13, '2020-06-25 16:16:19'),
(86, 31, 13, '2020-06-25 16:16:22'),
(87, 43, 13, '2020-06-25 16:16:25'),
(88, 10, 13, '2020-06-25 16:16:28'),
(89, 4, 13, '2020-06-25 16:16:31'),
(90, 17, 13, '2020-06-25 16:16:34'),
(91, 12, 13, '2020-06-25 16:16:37'),
(92, 15, 13, '2020-06-25 16:16:40'),
(93, 30, 13, '2020-06-25 16:16:44'),
(94, 5, 13, '2020-06-25 16:16:47'),
(95, 44, 13, '2020-06-25 16:16:50'),
(96, 48, 13, '2020-06-25 16:16:53'),
(97, 14, 13, '2020-06-25 16:16:56'),
(98, 41, 13, '2020-06-25 16:16:59'),
(99, 38, 13, '2020-06-25 16:17:02'),
(100, 40, 13, '2020-06-25 16:17:05'),
(101, 32, 13, '2020-06-25 16:17:08'),
(102, 51, 13, '2020-06-25 16:17:12'),
(103, 22, 13, '2020-06-25 16:17:15'),
(104, 27, 13, '2020-06-25 16:17:18'),
(105, 3, 13, '2020-06-25 16:17:21'),
(106, 9, 13, '2020-06-25 16:20:18'),
(107, 19, 13, '2020-06-25 16:20:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignatura_canceladas`
--

CREATE TABLE `tbl_asignatura_canceladas` (
  `Id_asig_cancelada` bigint(16) NOT NULL,
  `Id_asignatura` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `Fecha_creacion` varchar(255) NOT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `cambio` varchar(255) DEFAULT NULL,
  `observacion` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_asignatura_canceladas`
--

INSERT INTO `tbl_asignatura_canceladas` (`Id_asig_cancelada`, `Id_asignatura`, `Id_usuario`, `motivo`, `Fecha_creacion`, `documento`, `cambio`, `observacion`) VALUES
(15, 0, 14, 'nothing', '2020-07-23 16:34:51', '../archivos/les03_Rev2.pdf', 'desaprobar', 'hola');

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
  `Descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_bitacora`
--

INSERT INTO `tbl_bitacora` (`Id_bitacora`, `Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES
(2, 10, 1, '2020', 'inserto', 'inserto usuario'),
(3, 1, 23, '2020-06-14 21:50:58', 'INGRESO', 'A GESTION DE EGRESADOS'),
(4, 1, 13, '2020-06-14 22:11:03', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(5, 2, 13, '2020-06-14 22:14:17', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(6, 2, 13, '2020-06-14 22:14:47', 'INSERTO', 'LA INSCRIPCION DE CHARLA AL USUARIO DBA'),
(7, 2, 14, '2020-06-14 22:15:47', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(8, 2, 14, '2020-06-14 22:17:03', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(9, 2, 14, '2020-06-14 22:18:38', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(10, 2, 14, '2020-06-14 22:19:04', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(11, 2, 14, '2020-06-14 22:19:27', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(13, 2, 14, '2020-06-14 22:20:24', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(14, 2, 14, '2020-06-14 22:21:27', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(15, 2, 14, '2020-06-14 22:22:16', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(16, 2, 14, '2020-06-14 22:23:03', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(17, 2, 14, '2020-06-14 22:23:33', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(18, 1, 14, '2020-06-14 22:25:25', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(19, 1, 14, '2020-06-14 22:27:40', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(20, 1, 8, '2020-06-14 22:28:15', 'Ingreso', 'A Bitacora del sistema'),
(21, 1, 8, '2020-06-14 22:30:56', 'Ingreso', 'A Bitacora del sistema'),
(22, 1, 8, '2020-06-14 23:06:48', 'Ingreso', 'A Bitacora del sistema'),
(23, 1, 13, '2020-06-14 23:18:13', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(24, 1, 14, '2020-06-14 23:27:37', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(25, 1, 2, '2020-06-15 20:20:24', 'Ingreso', 'A Gestion de Preguntas'),
(26, 1, 2, '2020-06-15 20:20:53', 'Ingreso', 'A Gestion de Preguntas'),
(27, 1, 2, '2020-06-15 20:50:07', 'Ingreso', 'A Gestion de Preguntas'),
(28, 1, 2, '2020-06-15 20:50:27', 'Ingreso', 'A Gestion de Preguntas'),
(29, 1, 2, '2020-06-15 20:50:48', 'Ingreso', 'A Gestion de Preguntas'),
(30, 1, 2, '2020-06-15 20:51:03', 'Ingreso', 'A Gestion de Preguntas'),
(31, 1, 19, '2020-06-15 21:16:45', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(32, 1, 19, '2020-06-15 23:22:00', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(33, 1, 19, '2020-06-15 23:23:11', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(34, 1, 19, '2020-06-15 23:24:49', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(35, 1, 19, '2020-06-15 23:26:26', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(36, 1, 19, '2020-06-15 23:26:58', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(37, 1, 19, '2020-06-15 23:27:45', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(38, 1, 19, '2020-06-15 23:28:29', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(39, 1, 19, '2020-06-15 23:28:37', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(40, 1, 19, '2020-06-15 23:28:49', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(41, 1, 19, '2020-06-15 23:29:03', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(42, 1, 19, '2020-06-15 23:29:35', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(43, 1, 19, '2020-06-15 23:30:23', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(44, 1, 19, '2020-06-15 23:30:55', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(45, 1, 19, '2020-06-15 23:32:14', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(46, 1, 19, '2020-06-15 23:32:48', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(47, 1, 19, '2020-06-15 23:34:11', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(48, 1, 19, '2020-06-15 23:34:44', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(49, 1, 19, '2020-06-15 23:37:18', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(50, 1, 19, '2020-06-15 23:37:35', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(51, 1, 19, '2020-06-15 23:38:54', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(52, 1, 19, '2020-06-15 23:39:11', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(53, 1, 19, '2020-06-15 23:40:04', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(54, 1, 19, '2020-06-15 23:40:26', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(55, 1, 19, '2020-06-15 23:40:43', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(56, 1, 19, '2020-06-15 23:41:12', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(57, 1, 19, '2020-06-15 23:42:02', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(58, 1, 19, '2020-06-15 23:42:58', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(59, 1, 19, '2020-06-15 23:43:06', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(60, 1, 19, '2020-06-15 23:43:50', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(61, 1, 19, '2020-06-15 23:46:21', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(62, 1, 19, '2020-06-15 23:46:29', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(63, 1, 19, '2020-06-15 23:47:51', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(64, 1, 19, '2020-06-15 23:48:04', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(65, 1, 19, '2020-06-15 23:48:44', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(66, 1, 19, '2020-06-15 23:48:46', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(67, 1, 19, '2020-06-15 23:48:59', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(68, 1, 19, '2020-06-15 23:51:00', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(69, 1, 19, '2020-06-15 23:51:39', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(70, 1, 19, '2020-06-16 13:10:07', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(71, 1, 19, '2020-06-16 13:31:24', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(72, 1, 19, '2020-06-16 13:33:02', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(73, 1, 19, '2020-06-16 13:34:31', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(74, 1, 19, '2020-06-16 13:36:12', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(75, 1, 19, '2020-06-16 13:37:26', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(76, 1, 19, '2020-06-16 13:38:06', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(77, 1, 19, '2020-06-16 13:40:51', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(78, 1, 19, '2020-06-16 13:41:06', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(79, 1, 19, '2020-06-16 13:41:40', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(80, 1, 19, '2020-06-16 13:41:48', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(81, 1, 19, '2020-06-16 13:41:48', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(82, 1, 19, '2020-06-16 13:41:49', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(83, 1, 19, '2020-06-16 13:42:41', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(84, 1, 19, '2020-06-16 13:42:41', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(85, 1, 19, '2020-06-16 13:43:39', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(86, 1, 19, '2020-06-16 13:43:39', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(87, 1, 19, '2020-06-16 13:44:19', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(88, 1, 19, '2020-06-16 13:44:32', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(89, 1, 19, '2020-06-16 13:45:37', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(90, 1, 19, '2020-06-16 13:45:53', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(91, 1, 19, '2020-06-16 13:46:46', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(92, 1, 19, '2020-06-16 13:46:55', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(93, 1, 19, '2020-06-16 13:47:31', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(94, 1, 19, '2020-06-16 13:47:40', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(95, 1, 19, '2020-06-16 13:47:40', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(96, 1, 19, '2020-06-16 13:48:04', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(97, 1, 19, '2020-06-16 13:48:04', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(98, 1, 19, '2020-06-16 13:48:35', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(99, 1, 19, '2020-06-16 13:49:02', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(100, 1, 19, '2020-06-16 13:52:38', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(101, 1, 19, '2020-06-16 13:55:00', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(102, 1, 19, '2020-06-16 15:32:40', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(103, 1, 19, '2020-06-16 15:44:47', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(104, 1, 13, '2020-06-16 15:45:57', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(105, 1, 19, '2020-06-16 15:46:50', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(106, 1, 19, '2020-06-16 16:04:48', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(107, 1, 19, '2020-06-16 16:08:37', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(108, 1, 16, '2020-06-16 16:16:03', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(109, 1, 19, '2020-06-16 16:17:26', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(110, 1, 16, '2020-06-16 16:40:05', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(111, 1, 16, '2020-06-16 17:02:32', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(112, 1, 16, '2020-06-16 17:04:14', 'MODIFICO', 'LA  ASIGNATURA BASE DE DATOS II'),
(113, 1, 16, '2020-06-16 17:04:17', 'MODIFICO', 'LA  ASIGNATURA COMUNICACION ELECTRONICA DE DATOS'),
(114, 1, 16, '2020-06-16 17:04:20', 'MODIFICO', 'LA  ASIGNATURA CONTABILIDAD I'),
(115, 1, 16, '2020-06-16 17:04:23', 'MODIFICO', 'LA  ASIGNATURA CONTABILIDAD II'),
(116, 1, 16, '2020-06-16 17:04:26', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE christel nicole neumann callejas'),
(117, 1, 16, '2020-06-16 17:04:35', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(118, 1, 16, '2020-06-16 17:07:44', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(119, 1, 13, '2020-06-16 17:08:58', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(120, 1, 13, '2020-06-16 17:09:10', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(121, 1, 13, '2020-06-16 17:09:22', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(122, 1, 16, '2020-06-16 17:10:51', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(123, 1, 16, '2020-06-16 17:12:04', 'MODIFICO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION III'),
(124, 1, 16, '2020-06-16 17:12:07', 'MODIFICO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION IV'),
(125, 1, 16, '2020-06-16 17:12:10', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE christel nicole neumann callejas'),
(126, 1, 16, '2020-06-16 17:12:19', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(127, 1, 16, '2020-06-16 17:12:53', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(128, 1, 16, '2020-06-16 17:16:39', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(129, 1, 16, '2020-06-16 17:17:10', 'MODIFICO', 'LA  ASIGNATURA BASE DE DATOS II'),
(130, 1, 16, '2020-06-16 17:17:13', 'MODIFICO', 'LA  ASIGNATURA COMUNICACION ELECTRONICA DE DATOS'),
(131, 1, 16, '2020-06-16 17:17:16', 'MODIFICO', 'LA  ASIGNATURA CONTABILIDAD ADMINISTRATIVA I'),
(132, 1, 16, '2020-06-16 17:17:19', 'MODIFICO', 'LA  ASIGNATURA CONTABILIDAD ADMINSTRATIVA II'),
(133, 1, 16, '2020-06-16 17:17:22', 'MODIFICO', 'LA  ASIGNATURA CONTABILIDAD I'),
(134, 1, 16, '2020-06-16 17:17:25', 'MODIFICO', 'LA  ASIGNATURA CONTABILIDAD II'),
(135, 1, 16, '2020-06-16 17:17:29', 'MODIFICO', 'LA  ASIGNATURA ESPAÑOL'),
(136, 1, 16, '2020-06-16 17:17:32', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE HEINZ NEUMANN'),
(137, 1, 16, '2020-06-16 17:17:41', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(138, 1, 16, '2020-06-16 17:18:13', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(139, 1, 16, '2020-06-16 17:18:46', 'MODIFICO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION III'),
(140, 1, 16, '2020-06-16 17:18:49', 'MODIFICO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION IV'),
(141, 1, 16, '2020-06-16 17:18:52', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE HEINZ NEUMANN'),
(142, 1, 16, '2020-06-16 17:19:01', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(143, 1, 16, '2020-06-16 17:19:35', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(144, 1, 16, '2020-06-16 17:20:37', 'MODIFICO', 'LA  ASIGNATURA TALLER DE HARDWARE'),
(145, 1, 16, '2020-06-16 17:20:40', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE HEINZ NEUMANN'),
(146, 1, 16, '2020-06-16 17:20:49', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(147, 1, 16, '2020-06-16 17:21:26', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(148, 1, 16, '2020-06-16 17:22:02', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(149, 1, 16, '2020-06-16 17:23:27', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(150, 1, 16, '2020-06-16 17:24:09', 'MODIFICO', 'LA  ASIGNATURA ORGANIZACION Y METODOS DE LA IMFORMATICA'),
(151, 1, 16, '2020-06-16 17:24:12', 'MODIFICO', 'LA  ASIGNATURA SOCIOLOGIA'),
(152, 1, 16, '2020-06-16 17:24:15', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE HEINZ NEUMANN'),
(153, 1, 16, '2020-06-16 17:24:24', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(154, 1, 19, '2020-06-16 17:33:47', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(155, 1, 19, '2020-06-16 17:34:24', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(156, 1, 19, '2020-06-16 17:35:07', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(157, 1, 19, '2020-06-18 12:03:28', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(158, 1, 2, '2020-06-18 12:13:30', 'Ingreso', 'A Gestion de Preguntas'),
(159, 1, 19, '2020-06-18 12:22:55', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(160, 1, 19, '2020-06-18 12:24:16', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(161, 1, 19, '2020-06-18 12:25:59', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(162, 1, 19, '2020-06-18 12:28:57', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(163, 1, 19, '2020-06-18 12:29:56', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(164, 1, 19, '2020-06-18 12:32:56', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(165, 1, 19, '2020-06-18 12:33:47', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(166, 1, 19, '2020-06-18 12:36:22', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(167, 1, 19, '2020-06-18 12:44:13', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(168, 1, 19, '2020-06-18 12:45:47', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(169, 1, 19, '2020-06-18 12:46:23', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(170, 1, 19, '2020-06-18 12:47:43', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(171, 1, 19, '2020-06-18 12:48:59', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(172, 1, 19, '2020-06-18 12:51:34', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(173, 1, 19, '2020-06-18 12:52:35', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(174, 1, 19, '2020-06-18 12:53:09', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(175, 1, 19, '2020-06-18 12:53:29', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(176, 1, 19, '2020-06-18 12:54:15', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(177, 1, 19, '2020-06-18 13:17:45', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(178, 1, 26, '2020-06-18 17:41:22', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(179, 1, 19, '2020-06-18 17:43:50', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(180, 1, 16, '2020-06-18 17:43:59', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(181, 1, 16, '2020-06-18 17:44:05', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(182, 1, 16, '2020-06-18 17:44:15', 'MODIFICO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION III'),
(183, 1, 16, '2020-06-18 17:44:15', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE christel nicole neumann callejas'),
(184, 1, 16, '2020-06-18 17:44:15', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(185, 1, 16, '2020-06-18 17:44:26', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(186, 1, 16, '2020-06-18 17:44:33', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(187, 1, 16, '2020-06-18 17:46:00', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(188, 1, 16, '2020-06-18 17:46:03', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(189, 1, 16, '2020-06-18 17:46:07', 'MODIFICO', 'LA  ASIGNATURA ANALISIS Y DISEÑO DE SISTEMAS'),
(190, 1, 16, '2020-06-18 17:46:07', 'MODIFICO', 'LA  ASIGNATURA AUDITORIA EN INFORMATICA'),
(191, 1, 16, '2020-06-18 17:46:07', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE christel nicole neumann callejas'),
(192, 1, 16, '2020-06-18 17:46:07', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(193, 1, 16, '2020-06-18 17:48:30', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(194, 1, 16, '2020-06-18 17:49:00', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(195, 1, 16, '2020-06-18 17:49:03', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(196, 1, 16, '2020-06-18 17:52:03', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(197, 1, 16, '2020-06-18 17:52:09', 'MODIFICO', 'LA  ASIGNATURA '),
(198, 1, 16, '2020-06-18 17:52:09', 'MODIFICO', 'LA  ASIGNATURA '),
(199, 1, 16, '2020-06-18 17:52:09', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(200, 1, 16, '2020-06-18 17:54:09', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(201, 1, 16, '2020-06-18 17:54:11', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(202, 1, 16, '2020-06-18 17:55:10', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(203, 1, 16, '2020-06-18 17:55:12', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(204, 1, 16, '2020-06-18 17:55:48', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(205, 1, 16, '2020-06-18 17:55:54', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(206, 1, 16, '2020-06-18 17:55:56', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(207, 1, 16, '2020-06-18 17:56:08', 'MODIFICO', 'LA  ASIGNATURA EVALUACION DE SISTEMAS'),
(208, 1, 16, '2020-06-18 17:56:08', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE christel nicole neumann callejas'),
(209, 1, 16, '2020-06-18 17:56:08', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(210, 1, 16, '2020-06-18 17:57:42', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(211, 1, 16, '2020-06-18 17:57:44', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(212, 1, 16, '2020-06-18 18:00:21', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(213, 1, 16, '2020-06-18 18:00:23', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(214, 1, 16, '2020-06-18 18:00:49', 'MODIFICO', 'LA  ASIGNATURA BASE DE DATOS I'),
(215, 1, 16, '2020-06-18 18:00:49', 'MODIFICO', 'LA  ASIGNATURA CONTABILIDAD ADMINSTRATIVA II'),
(216, 1, 16, '2020-06-18 18:00:50', 'MODIFICO', 'LA  ASIGNATURA ORGANIZACION Y METODOS DE LA IMFORMATICA'),
(217, 1, 16, '2020-06-18 18:00:50', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE christel nicole neumann callejas'),
(218, 1, 16, '2020-06-18 18:00:50', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(219, 1, 16, '2020-06-18 18:01:17', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(220, 1, 16, '2020-06-18 18:02:08', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(221, 1, 16, '2020-06-18 18:02:10', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(222, 1, 16, '2020-06-18 18:02:29', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(223, 1, 16, '2020-06-18 18:02:46', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(224, 1, 16, '2020-06-18 18:03:19', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(225, 1, 26, '2020-06-18 18:06:32', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(226, 1, 26, '2020-06-18 18:07:07', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(227, 1, 23, '2020-06-18 18:07:40', 'INGRESO', 'A GESTION DE EGRESADOS'),
(228, 1, 23, '2020-06-18 18:08:01', 'INGRESO', 'A GESTION DE EGRESADOS'),
(229, 1, 26, '2020-06-18 18:08:41', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(230, 1, 26, '2020-06-18 18:11:21', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(231, 1, 26, '2020-06-18 18:14:36', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(232, 1, 16, '2020-06-18 18:18:04', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(233, 1, 16, '2020-06-18 18:18:24', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(234, 1, 16, '2020-06-18 18:19:17', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(235, 1, 2, '2020-06-18 18:20:12', 'Ingreso', 'A Gestion de Preguntas'),
(236, 1, 2, '2020-06-18 18:20:28', 'Ingreso', 'A Gestion de Preguntas'),
(237, 1, 26, '2020-06-18 18:20:49', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(238, 1, 26, '2020-06-18 21:38:57', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(239, 1, 23, '2020-06-18 21:39:11', 'INGRESO', 'A GESTION DE EGRESADOS'),
(240, 1, 16, '2020-06-18 21:40:00', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(241, 1, 16, '2020-06-18 21:40:16', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(242, 1, 16, '2020-06-18 21:40:36', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(243, 1, 26, '2020-06-18 21:40:39', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(244, 1, 26, '2020-06-18 21:41:03', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(245, 1, 26, '2020-06-18 21:51:09', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(246, 1, 26, '2020-06-18 21:55:59', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(247, 1, 26, '2020-06-18 21:56:25', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(248, 1, 26, '2020-06-18 21:59:29', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(249, 1, 26, '2020-06-18 22:00:34', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(250, 1, 26, '2020-06-18 22:01:02', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(251, 1, 26, '2020-06-18 22:02:34', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(252, 1, 26, '2020-06-18 22:03:28', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(253, 1, 26, '2020-06-18 22:04:15', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(254, 1, 26, '2020-06-18 22:05:19', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(255, 1, 26, '2020-06-18 22:05:19', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(256, 1, 26, '2020-06-18 22:05:52', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(257, 1, 26, '2020-06-18 22:07:39', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(258, 1, 26, '2020-06-18 22:08:25', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(259, 1, 26, '2020-06-18 22:10:19', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(260, 1, 26, '2020-06-18 22:12:11', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(261, 1, 26, '2020-06-18 22:12:47', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(262, 1, 26, '2020-06-18 22:13:19', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(263, 1, 26, '2020-06-18 22:13:56', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(264, 1, 26, '2020-06-18 22:14:26', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(265, 1, 26, '2020-06-18 22:14:54', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(266, 1, 26, '2020-06-18 22:16:09', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(267, 1, 26, '2020-06-18 22:16:45', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(268, 1, 26, '2020-06-18 22:18:13', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(269, 1, 26, '2020-06-18 22:18:57', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(270, 1, 26, '2020-06-18 22:20:51', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(271, 1, 26, '2020-06-18 22:21:14', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(272, 1, 26, '2020-06-18 22:22:05', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(273, 1, 26, '2020-06-18 22:22:33', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(274, 1, 26, '2020-06-18 22:23:27', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(275, 1, 26, '2020-06-18 22:25:45', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(276, 1, 26, '2020-06-18 22:31:47', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(277, 1, 26, '2020-06-18 22:32:06', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(278, 1, 26, '2020-06-18 22:39:34', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(279, 1, 26, '2020-06-18 22:40:11', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(280, 1, 26, '2020-06-18 22:40:16', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(281, 1, 26, '2020-06-18 22:42:33', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(282, 1, 26, '2020-06-18 22:43:03', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(283, 1, 26, '2020-06-18 22:43:53', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(284, 1, 26, '2020-06-18 22:44:28', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(285, 1, 21, '2020-06-18 22:57:17', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(286, 1, 21, '2020-06-18 22:58:04', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(287, 1, 22, '2020-06-18 22:58:33', 'INGRESO', 'A REGISTRAR EGRESADOS.'),
(288, 1, 21, '2020-06-18 22:59:44', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(289, 1, 26, '2020-06-18 23:04:45', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(290, 1, 26, '2020-06-18 23:07:01', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(291, 1, 26, '2020-06-18 23:07:37', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(292, 1, 16, '2020-06-18 23:09:08', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(293, 1, 15, '2020-06-18 23:09:23', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(294, 1, 16, '2020-06-18 23:09:35', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(295, 1, 16, '2020-06-18 23:13:43', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(296, 1, 26, '2020-06-18 23:13:52', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(297, 1, 26, '2020-06-18 23:14:54', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(298, 1, 16, '2020-06-18 23:15:20', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(299, 1, 20, '2020-06-18 23:16:54', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(300, 1, 16, '2020-06-18 23:17:14', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(301, 1, 16, '2020-06-18 23:17:59', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(302, 1, 16, '2020-06-18 23:19:34', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(303, 1, 16, '2020-06-18 23:20:25', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(304, 1, 15, '2020-06-18 23:21:12', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(305, 1, 15, '2020-06-18 23:23:00', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(306, 1, 15, '2020-06-18 23:23:51', 'INSERTO', 'LA  ASIGNATURA TALLER DE HARDWARE'),
(307, 1, 15, '2020-06-18 23:23:54', 'INSERTO', 'LA  ASIGNATURA TALLER DE HARDWARE'),
(308, 1, 15, '2020-06-18 23:23:57', 'INSERTO', 'LAS ASIGNATURAS AL ESTUDIANTE CON CUENTA 20141011508'),
(309, 1, 15, '2020-06-18 23:26:56', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(310, 1, 21, '2020-06-18 23:28:37', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(311, 1, 21, '2020-06-18 23:29:00', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(312, 1, 21, '2020-06-18 23:29:22', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(313, 1, 21, '2020-06-18 23:29:41', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(314, 1, 20, '2020-06-19 15:53:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(315, 1, 20, '2020-06-19 15:54:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(316, 1, 21, '2020-06-19 15:58:05', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(317, 1, 21, '2020-06-19 15:58:43', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(318, 1, 19, '2020-06-19 16:47:50', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(320, 1, 19, '2020-06-19 16:49:06', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(321, 1, 19, '2020-06-19 16:49:19', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(322, 1, 19, '2020-06-19 16:49:37', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(323, 1, 19, '2020-06-19 16:49:37', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(324, 1, 19, '2020-06-19 16:49:37', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(325, 1, 19, '2020-06-19 16:53:55', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(326, 1, 19, '2020-06-19 16:54:09', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(327, 1, 19, '2020-06-19 16:54:09', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(328, 1, 19, '2020-06-19 16:54:09', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(329, 1, 19, '2020-06-19 16:56:38', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(330, 1, 19, '2020-06-19 16:56:51', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(331, 1, 19, '2020-06-19 16:56:51', 'INGRESO', 'EL DOCUMENTO, EL USUARIO CON CUENTA: 1'),
(332, 1, 19, '2020-06-19 16:58:41', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(333, 1, 19, '2020-06-19 16:58:54', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 1'),
(334, 1, 19, '2020-06-19 16:58:54', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 1'),
(335, 1, 19, '2020-06-19 16:58:54', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 1'),
(336, 1, 19, '2020-06-19 16:58:54', 'INGRESO', 'EL DOCUMENTOhallazgos.docx, EL USUARIO CON CUENTA: 1'),
(337, 1, 20, '2020-06-19 17:00:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(338, 1, 19, '2020-06-19 17:00:17', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(339, 1, 19, '2020-06-19 17:00:25', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 1'),
(340, 1, 19, '2020-06-19 17:00:25', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 1'),
(341, 1, 19, '2020-06-19 17:01:22', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(342, 1, 19, '2020-06-19 17:01:32', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 1'),
(343, 1, 19, '2020-06-19 17:01:32', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 1'),
(344, 1, 19, '2020-06-19 17:01:33', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 1'),
(345, 1, 19, '2020-06-19 17:01:51', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 1'),
(346, 1, 19, '2020-06-19 17:02:29', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 1'),
(347, 1, 19, '2020-06-19 17:02:29', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 1'),
(348, 1, 19, '2020-06-19 17:02:29', 'INGRESO', 'EL DOCUMENTOhallazgos.docx, EL USUARIO CON CUENTA: 1'),
(349, 1, 19, '2020-06-19 17:02:49', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 1'),
(350, 1, 19, '2020-06-19 17:02:49', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 1'),
(351, 1, 19, '2020-06-19 17:02:49', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 1'),
(352, 1, 19, '2020-06-19 17:02:49', 'INGRESO', 'EL DOCUMENTOhallazgos.docx, EL USUARIO CON CUENTA: 1'),
(353, 1, 19, '2020-06-19 17:26:17', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 1'),
(354, 1, 19, '2020-06-19 17:26:18', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 1'),
(355, 1, 19, '2020-06-19 17:26:56', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(356, 1, 19, '2020-06-19 17:27:01', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(357, 1, 19, '2020-06-19 17:27:12', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 20141012159'),
(358, 1, 19, '2020-06-19 17:29:16', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(359, 1, 19, '2020-06-19 17:29:27', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 20141012159'),
(360, 1, 19, '2020-06-19 17:29:27', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 20141012159'),
(361, 1, 19, '2020-06-19 17:30:53', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(362, 1, 19, '2020-06-19 17:31:02', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 20141012159'),
(363, 1, 19, '2020-06-19 17:31:02', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 20141012159'),
(364, 1, 19, '2020-06-19 17:32:20', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(365, 1, 19, '2020-06-19 17:32:29', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 20141012159'),
(366, 1, 19, '2020-06-19 17:32:29', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 20141012159'),
(367, 1, 19, '2020-06-19 17:33:08', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(368, 1, 19, '2020-06-19 17:33:24', 'INGRESO', 'EL DOCUMENTOHallazgos de bitacora.docx, EL USUARIO CON CUENTA: 20141012159'),
(369, 1, 19, '2020-06-19 17:33:24', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 20141012159'),
(370, 1, 19, '2020-06-19 17:33:24', 'INGRESO', 'EL DOCUMENTOhallazgos.docx, EL USUARIO CON CUENTA: 20141012159'),
(371, 1, 19, '2020-06-19 17:36:02', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(372, 1, 19, '2020-06-19 17:36:10', 'INGRESO', 'EL DOCUMENTOhallazgos a VOAE segunda revision 23 feb.docx, EL USUARIO CON CUENTA: 20141012159'),
(373, 1, 19, '2020-06-19 17:36:10', 'INGRESO', 'EL DOCUMENTOHALLAZGOS ENCONTRADOS MANTENIMIENTO.docx, EL USUARIO CON CUENTA: 20141012159'),
(374, 1, 20, '2020-06-19 17:50:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(375, 1, 20, '2020-06-19 17:53:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(376, 1, 20, '2020-06-19 17:53:38', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(377, 1, 20, '2020-06-19 17:55:40', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(378, 1, 20, '2020-06-19 17:55:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(379, 1, 20, '2020-06-19 18:00:14', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(380, 1, 20, '2020-06-19 18:11:00', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(381, 1, 20, '2020-06-19 18:11:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(382, 1, 20, '2020-06-19 18:12:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(383, 1, 20, '2020-06-19 18:12:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(384, 1, 20, '2020-06-19 18:13:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(385, 1, 20, '2020-06-19 18:13:32', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(386, 1, 20, '2020-06-19 18:13:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(387, 1, 20, '2020-06-19 18:13:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(388, 1, 20, '2020-06-19 18:13:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(389, 1, 19, '2020-06-19 18:14:33', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(390, 1, 20, '2020-06-19 18:14:37', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(391, 1, 20, '2020-06-19 18:14:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(392, 1, 20, '2020-06-19 18:14:43', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(393, 1, 20, '2020-06-19 18:15:33', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(394, 1, 20, '2020-06-19 18:16:40', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(395, 1, 20, '2020-06-19 18:16:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(396, 1, 20, '2020-06-19 18:17:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(397, 1, 20, '2020-06-19 18:17:05', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(398, 1, 20, '2020-06-19 18:17:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(399, 1, 20, '2020-06-19 18:17:44', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(400, 1, 20, '2020-06-19 18:20:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(401, 1, 20, '2020-06-19 18:20:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(402, 1, 20, '2020-06-19 18:20:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(403, 1, 20, '2020-06-19 18:23:31', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(404, 1, 20, '2020-06-22 11:37:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(405, 1, 20, '2020-06-22 11:37:55', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(406, 1, 20, '2020-06-22 11:38:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(407, 1, 20, '2020-06-22 11:49:04', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(408, 1, 20, '2020-06-22 11:49:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(409, 1, 20, '2020-06-22 11:49:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(410, 1, 20, '2020-06-22 11:49:44', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(411, 1, 20, '2020-06-22 11:51:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(412, 1, 20, '2020-06-22 11:51:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(413, 1, 20, '2020-06-22 11:51:29', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(414, 1, 20, '2020-06-22 11:51:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(415, 1, 20, '2020-06-22 11:51:36', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(416, 1, 20, '2020-06-22 11:54:00', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(417, 1, 20, '2020-06-22 11:54:01', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(418, 1, 20, '2020-06-22 12:00:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(419, 1, 20, '2020-06-22 12:00:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(420, 1, 20, '2020-06-22 12:02:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(421, 1, 20, '2020-06-22 12:02:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(422, 1, 20, '2020-06-22 12:03:48', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(423, 1, 20, '2020-06-22 12:03:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(424, 1, 20, '2020-06-22 12:05:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(425, 1, 20, '2020-06-22 12:05:09', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(426, 1, 20, '2020-06-22 12:05:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(427, 1, 20, '2020-06-22 12:05:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(428, 1, 20, '2020-06-22 12:06:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(429, 1, 20, '2020-06-22 12:07:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(430, 1, 20, '2020-06-22 12:08:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(431, 1, 20, '2020-06-22 12:08:09', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(432, 1, 20, '2020-06-22 12:08:36', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(433, 1, 20, '2020-06-22 12:08:38', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(434, 1, 20, '2020-06-22 12:09:22', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(435, 1, 20, '2020-06-22 12:09:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(436, 1, 20, '2020-06-22 12:10:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(437, 1, 20, '2020-06-22 12:10:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(438, 1, 20, '2020-06-22 12:10:48', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(439, 1, 20, '2020-06-22 12:10:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(440, 1, 20, '2020-06-22 12:11:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(441, 1, 20, '2020-06-22 12:11:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(442, 1, 20, '2020-06-22 12:11:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(443, 1, 20, '2020-06-22 12:13:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(444, 1, 20, '2020-06-22 12:15:02', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(445, 1, 20, '2020-06-22 12:15:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(446, 1, 20, '2020-06-22 12:17:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(447, 1, 20, '2020-06-22 12:17:38', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(448, 1, 20, '2020-06-22 12:33:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(449, 1, 20, '2020-06-22 12:34:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(450, 1, 20, '2020-06-22 12:42:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(451, 1, 20, '2020-06-22 12:42:52', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(452, 1, 20, '2020-06-22 12:42:59', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(453, 1, 20, '2020-06-22 13:14:33', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(454, 1, 20, '2020-06-22 13:14:57', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(455, 1, 20, '2020-06-22 13:14:59', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(456, 1, 20, '2020-06-22 13:15:01', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(457, 1, 20, '2020-06-22 13:15:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(458, 1, 20, '2020-06-22 13:15:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(459, 1, 20, '2020-06-22 13:15:53', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(460, 1, 20, '2020-06-22 13:17:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(461, 1, 20, '2020-06-22 16:39:55', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(462, 1, 20, '2020-06-22 16:41:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(463, 1, 20, '2020-06-22 16:42:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(464, 1, 20, '2020-06-22 16:43:01', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(465, 1, 20, '2020-06-22 16:44:59', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(466, 1, 20, '2020-06-22 18:15:55', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(467, 1, 20, '2020-06-22 18:15:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(468, 1, 20, '2020-06-22 18:16:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(469, 1, 20, '2020-06-22 18:16:31', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(470, 1, 20, '2020-06-22 18:16:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(471, 1, 20, '2020-06-22 18:16:39', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(472, 1, 20, '2020-06-22 18:18:06', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(473, 1, 20, '2020-06-22 18:18:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(474, 1, 20, '2020-06-22 18:18:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(475, 1, 20, '2020-06-22 18:18:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(476, 1, 20, '2020-06-22 18:18:52', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(477, 1, 20, '2020-06-22 18:18:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(478, 1, 20, '2020-06-22 18:21:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(479, 1, 20, '2020-06-22 18:21:57', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(480, 1, 20, '2020-06-22 18:22:03', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACION\r\n                '),
(481, 1, 20, '2020-06-22 18:22:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(482, 1, 20, '2020-06-22 18:23:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(483, 1, 20, '2020-06-22 18:23:13', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACION\r\n                '),
(484, 1, 20, '2020-06-22 18:23:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(485, 1, 20, '2020-06-22 18:25:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(486, 1, 20, '2020-06-22 18:25:14', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(487, 1, 20, '2020-06-22 18:25:17', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(488, 1, 20, '2020-06-22 18:25:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(489, 1, 20, '2020-06-22 18:26:48', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(490, 1, 20, '2020-06-22 18:26:52', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(491, 1, 20, '2020-06-22 18:26:53', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(492, 1, 20, '2020-06-22 18:27:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(493, 1, 20, '2020-06-22 18:36:21', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(494, 1, 20, '2020-06-22 18:45:15', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(495, 1, 20, '2020-06-22 18:45:27', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(496, 1, 20, '2020-06-22 18:45:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(497, 1, 20, '2020-06-22 18:46:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(498, 1, 20, '2020-06-22 18:46:45', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(499, 1, 20, '2020-06-22 18:46:49', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACION\r\n                '),
(500, 1, 20, '2020-06-22 18:46:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(501, 1, 20, '2020-06-22 18:46:57', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(502, 1, 20, '2020-06-22 18:47:02', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONP\r\n RUEBA'),
(503, 1, 20, '2020-06-22 18:47:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(504, 1, 20, '2020-06-22 18:47:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(505, 1, 20, '2020-06-22 18:47:53', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(506, 1, 20, '2020-06-22 18:47:56', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACION\r\n                '),
(507, 1, 20, '2020-06-22 18:47:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(508, 1, 20, '2020-06-22 18:48:25', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(509, 1, 20, '2020-06-22 18:48:29', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACION\r\n                '),
(510, 1, 20, '2020-06-22 18:48:29', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(511, 1, 20, '2020-06-22 18:49:04', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(512, 1, 20, '2020-06-22 18:49:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(513, 1, 20, '2020-06-22 18:49:11', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACION\r\n                '),
(514, 1, 20, '2020-06-22 18:49:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(515, 1, 20, '2020-06-22 18:49:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(516, 1, 20, '2020-06-22 18:49:23', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(517, 1, 20, '2020-06-22 18:49:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(518, 1, 20, '2020-06-22 18:49:32', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(519, 1, 20, '2020-06-22 18:49:35', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONDS\r\n  A'),
(520, 1, 20, '2020-06-22 18:49:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(521, 1, 20, '2020-06-22 18:50:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(522, 1, 20, '2020-06-22 18:50:29', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACION\r\n                '),
(523, 1, 20, '2020-06-22 18:50:30', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(524, 1, 20, '2020-06-22 18:50:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(525, 1, 20, '2020-06-22 18:50:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(526, 1, 20, '2020-06-22 18:50:54', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(527, 1, 20, '2020-06-22 18:50:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(528, 1, 20, '2020-06-22 18:51:00', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(529, 1, 20, '2020-06-22 18:51:05', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONDA\r\n SD'),
(530, 1, 20, '2020-06-22 18:51:05', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(531, 1, 20, '2020-06-22 18:53:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(532, 1, 20, '2020-06-22 18:53:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(533, 1, 20, '2020-06-22 18:53:14', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(534, 1, 20, '2020-06-22 18:53:14', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(535, 1, 20, '2020-06-22 18:53:15', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(536, 1, 20, '2020-06-22 18:53:20', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(537, 1, 20, '2020-06-22 18:53:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(538, 1, 20, '2020-06-22 18:54:15', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(539, 1, 20, '2020-06-22 18:54:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(540, 1, 20, '2020-06-22 18:54:21', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(541, 1, 20, '2020-06-22 18:54:21', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(542, 1, 20, '2020-06-22 18:54:36', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(543, 1, 20, '2020-06-22 18:54:37', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(544, 1, 20, '2020-06-22 18:55:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(545, 1, 20, '2020-06-22 18:55:52', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(546, 1, 20, '2020-06-22 18:55:57', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONS\r\n  SS'),
(547, 1, 20, '2020-06-22 18:55:57', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(548, 1, 20, '2020-06-22 18:56:00', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(549, 1, 20, '2020-06-22 18:56:15', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONS\r\n  SS'),
(550, 1, 20, '2020-06-22 18:56:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(551, 1, 20, '2020-06-22 18:56:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(552, 1, 20, '2020-06-22 18:57:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(553, 1, 20, '2020-06-22 18:58:01', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(554, 1, 20, '2020-06-22 18:58:06', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(555, 1, 20, '2020-06-22 18:58:06', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(556, 1, 20, '2020-06-22 18:58:36', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(557, 1, 20, '2020-06-22 18:58:38', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(558, 1, 20, '2020-06-22 18:58:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(559, 1, 20, '2020-06-22 18:59:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(560, 1, 20, '2020-06-22 18:59:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(561, 1, 20, '2020-06-22 19:00:21', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(562, 1, 20, '2020-06-22 19:00:25', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(563, 1, 20, '2020-06-22 19:00:27', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(564, 1, 20, '2020-06-22 19:00:55', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(565, 1, 20, '2020-06-22 19:01:01', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(566, 1, 20, '2020-06-22 19:01:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(567, 1, 20, '2020-06-22 19:01:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(568, 1, 20, '2020-06-22 19:01:23', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(569, 1, 20, '2020-06-22 19:01:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA ');
INSERT INTO `tbl_bitacora` (`Id_bitacora`, `Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES
(570, 1, 20, '2020-06-22 19:57:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(571, 1, 20, '2020-06-22 19:57:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(572, 1, 20, '2020-06-22 19:58:31', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(573, 1, 20, '2020-06-22 19:58:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(574, 1, 20, '2020-06-22 19:58:36', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(575, 1, 20, '2020-06-22 19:58:39', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(576, 1, 20, '2020-06-22 19:58:40', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(577, 1, 20, '2020-06-22 19:58:43', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(578, 1, 20, '2020-06-22 19:58:48', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION'),
(579, 1, 20, '2020-06-22 19:58:48', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(580, 1, 20, '2020-06-22 19:59:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(581, 1, 20, '2020-06-22 19:59:52', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(582, 1, 20, '2020-06-22 19:59:56', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION'),
(583, 1, 20, '2020-06-22 19:59:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(584, 1, 20, '2020-06-22 20:00:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(585, 1, 20, '2020-06-22 20:00:57', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(586, 1, 20, '2020-06-22 20:01:02', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(587, 1, 20, '2020-06-22 20:01:02', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(588, 1, 20, '2020-06-22 20:03:06', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(589, 1, 20, '2020-06-22 20:03:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(590, 1, 20, '2020-06-22 20:03:12', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(591, 1, 20, '2020-06-22 20:03:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(592, 1, 20, '2020-06-22 20:03:19', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(593, 1, 20, '2020-06-22 20:03:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(594, 1, 20, '2020-06-22 20:03:24', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(595, 1, 20, '2020-06-22 20:03:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(596, 1, 20, '2020-06-22 20:03:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(597, 1, 20, '2020-06-22 20:04:00', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(598, 1, 20, '2020-06-22 20:04:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(599, 1, 20, '2020-06-22 20:04:19', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(600, 1, 20, '2020-06-22 20:04:19', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(601, 1, 20, '2020-06-22 20:05:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(602, 1, 20, '2020-06-22 20:05:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(603, 1, 20, '2020-06-22 20:05:45', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(604, 1, 20, '2020-06-22 20:05:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(605, 1, 20, '2020-06-22 20:05:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(606, 1, 20, '2020-06-22 20:06:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(607, 1, 20, '2020-06-22 20:06:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(608, 1, 20, '2020-06-22 20:06:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(609, 1, 20, '2020-06-22 20:06:39', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(610, 1, 20, '2020-06-22 20:06:39', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(611, 1, 20, '2020-06-22 20:07:39', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(612, 1, 20, '2020-06-22 20:07:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(613, 1, 20, '2020-06-22 20:08:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(614, 1, 20, '2020-06-22 20:08:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(615, 1, 20, '2020-06-22 20:08:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(616, 1, 20, '2020-06-22 20:09:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(617, 1, 20, '2020-06-22 20:09:30', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(618, 1, 20, '2020-06-22 20:10:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(619, 1, 20, '2020-06-22 20:10:36', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(620, 1, 20, '2020-06-22 20:10:39', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(621, 1, 20, '2020-06-22 20:10:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(622, 1, 20, '2020-06-22 20:11:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(623, 1, 20, '2020-06-22 20:11:15', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(624, 1, 20, '2020-06-22 20:11:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(625, 1, 20, '2020-06-22 20:11:37', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(626, 1, 20, '2020-06-22 20:11:39', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(627, 1, 20, '2020-06-22 20:11:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(628, 1, 20, '2020-06-22 20:11:48', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(629, 1, 20, '2020-06-22 20:12:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(630, 1, 20, '2020-06-22 20:14:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(631, 1, 20, '2020-06-22 20:14:05', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(632, 1, 20, '2020-06-22 20:14:09', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(633, 1, 20, '2020-06-22 20:14:09', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(634, 1, 20, '2020-06-22 20:14:43', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(635, 1, 20, '2020-06-22 20:14:45', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(636, 1, 20, '2020-06-22 20:14:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(637, 1, 20, '2020-06-22 20:14:51', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(638, 1, 20, '2020-06-22 20:14:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(639, 1, 20, '2020-06-22 20:15:06', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(640, 1, 20, '2020-06-22 20:15:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(641, 1, 20, '2020-06-22 20:15:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(642, 1, 20, '2020-06-22 20:15:18', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(643, 1, 20, '2020-06-22 20:15:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(644, 1, 20, '2020-06-22 20:15:45', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(645, 1, 20, '2020-06-22 20:15:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(646, 1, 20, '2020-06-22 20:15:58', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n'),
(647, 1, 20, '2020-06-22 20:15:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(648, 1, 20, '2020-06-22 20:16:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(649, 1, 20, '2020-06-22 20:16:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(650, 1, 20, '2020-06-22 20:16:39', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(651, 1, 20, '2020-06-22 20:16:39', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(652, 1, 20, '2020-06-22 20:17:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(653, 1, 20, '2020-06-22 20:17:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(654, 1, 20, '2020-06-22 20:17:15', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(655, 1, 20, '2020-06-22 20:17:15', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(656, 1, 20, '2020-06-22 20:18:00', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(657, 1, 20, '2020-06-22 20:18:02', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(658, 1, 20, '2020-06-22 20:18:05', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(659, 1, 20, '2020-06-22 20:18:05', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(660, 1, 20, '2020-06-22 20:19:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(661, 1, 20, '2020-06-22 20:19:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(662, 1, 20, '2020-06-22 20:19:16', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(663, 1, 20, '2020-06-22 20:19:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(664, 1, 20, '2020-06-22 20:19:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(665, 1, 20, '2020-06-22 20:19:22', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(666, 1, 20, '2020-06-22 20:19:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(667, 1, 20, '2020-06-22 20:19:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(668, 1, 20, '2020-06-22 20:19:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(669, 1, 20, '2020-06-22 20:21:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(670, 1, 20, '2020-06-22 20:21:52', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(671, 1, 20, '2020-06-22 20:21:56', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(672, 1, 20, '2020-06-22 20:21:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(673, 1, 20, '2020-06-22 20:21:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(674, 1, 20, '2020-06-22 20:22:09', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONDSCSDCDCDSCSD'),
(675, 1, 20, '2020-06-22 20:22:09', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(676, 1, 20, '2020-06-22 20:24:45', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(677, 1, 20, '2020-06-22 20:24:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(678, 1, 20, '2020-06-22 20:24:51', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(679, 1, 20, '2020-06-22 20:24:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(680, 1, 20, '2020-06-22 20:25:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(681, 1, 20, '2020-06-22 20:26:44', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(682, 1, 20, '2020-06-22 20:26:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(683, 1, 20, '2020-06-22 20:26:49', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACION\r\n                '),
(684, 1, 20, '2020-06-22 20:26:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(685, 1, 20, '2020-06-22 20:27:45', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(686, 1, 20, '2020-06-22 20:27:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(687, 1, 20, '2020-06-22 20:28:39', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(688, 1, 20, '2020-06-22 20:28:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(689, 1, 20, '2020-06-22 20:29:01', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(690, 1, 20, '2020-06-22 20:30:10', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONPRUEBA DE OBSERVACION'),
(691, 1, 20, '2020-06-22 20:30:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(692, 1, 20, '2020-06-22 20:30:20', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(693, 1, 20, '2020-06-22 20:30:23', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(694, 1, 20, '2020-06-22 20:30:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(695, 1, 20, '2020-06-22 21:08:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(696, 1, 20, '2020-06-22 21:09:02', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(697, 1, 20, '2020-06-22 21:09:02', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(698, 1, 20, '2020-06-22 21:09:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(699, 1, 20, '2020-06-22 21:09:18', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONKJGKJHK SD DS DSVD KJFNDSJFND'),
(700, 1, 20, '2020-06-22 21:09:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(701, 1, 20, '2020-06-23 16:14:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(702, 1, 20, '2020-06-23 16:14:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(703, 1, 20, '2020-06-23 16:14:19', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(704, 1, 20, '2020-06-23 16:14:50', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONPRUEBA DE LAS OBSERVACIONES '),
(705, 1, 20, '2020-06-23 16:14:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(706, 1, 20, '2020-06-23 16:16:29', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(707, 1, 20, '2020-06-23 16:16:33', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(708, 1, 20, '2020-06-23 16:16:33', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(709, 1, 20, '2020-06-23 16:31:15', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(710, 1, 20, '2020-06-23 16:31:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(711, 1, 20, '2020-06-23 16:31:37', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(712, 1, 20, '2020-06-23 16:31:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(713, 1, 20, '2020-06-23 16:31:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(714, 1, 20, '2020-06-23 16:31:53', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONCJKJBC CCDCBDHC DHC D DS D HJC D'),
(715, 1, 20, '2020-06-23 16:31:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(716, 1, 20, '2020-06-23 16:31:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(717, 1, 20, '2020-06-23 16:31:59', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(718, 1, 20, '2020-06-23 16:31:59', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(719, 1, 20, '2020-06-23 16:32:02', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(720, 1, 20, '2020-06-23 16:32:10', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONMDSBJDSB SCJ CSD CSDC DSCDS'),
(721, 1, 20, '2020-06-23 16:32:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(722, 1, 20, '2020-06-23 16:32:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(723, 1, 20, '2020-06-23 16:32:16', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(724, 1, 20, '2020-06-23 16:32:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(725, 1, 20, '2020-06-23 16:32:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(726, 1, 20, '2020-06-23 16:32:40', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONJHJ HIU IIU IH H IH I'),
(727, 1, 20, '2020-06-23 16:32:40', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(728, 1, 20, '2020-06-23 16:33:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(729, 1, 20, '2020-06-23 16:34:44', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(730, 1, 20, '2020-06-23 16:34:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(731, 1, 20, '2020-06-23 16:34:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(732, 1, 20, '2020-06-23 16:35:22', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(733, 1, 20, '2020-06-23 16:35:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(734, 1, 20, '2020-06-23 16:35:29', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(735, 1, 20, '2020-06-23 16:35:30', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(736, 1, 20, '2020-06-23 16:35:32', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(737, 1, 20, '2020-06-23 16:35:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(738, 1, 20, '2020-06-23 16:36:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(739, 1, 21, '2020-06-23 16:36:55', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(740, 1, 21, '2020-06-23 16:37:09', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(741, 1, 21, '2020-06-23 16:37:18', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(742, 1, 20, '2020-06-23 16:37:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(743, 1, 20, '2020-06-23 16:37:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(744, 1, 21, '2020-06-23 16:40:41', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(745, 1, 21, '2020-06-23 16:41:40', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(746, 1, 21, '2020-06-23 16:45:12', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(747, 1, 21, '2020-06-23 16:49:43', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(748, 1, 21, '2020-06-23 16:50:08', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(749, 1, 21, '2020-06-23 16:51:34', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(750, 1, 21, '2020-06-23 16:51:39', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(751, 1, 21, '2020-06-23 16:51:44', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(752, 1, 21, '2020-06-23 16:52:54', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(753, 1, 21, '2020-06-23 16:54:38', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(754, 1, 21, '2020-06-23 16:55:10', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(755, 1, 21, '2020-06-23 16:55:47', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(756, 1, 21, '2020-06-23 16:56:05', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(757, 1, 21, '2020-06-23 16:56:40', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(758, 1, 21, '2020-06-23 17:05:48', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(759, 1, 21, '2020-06-23 17:27:45', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(760, 1, 21, '2020-06-23 17:30:32', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(761, 1, 21, '2020-06-23 17:34:33', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(762, 1, 21, '2020-06-23 17:37:19', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(763, 1, 21, '2020-06-23 17:37:30', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(764, 1, 21, '2020-06-23 17:37:42', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(765, 1, 21, '2020-06-23 17:39:32', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(766, 1, 21, '2020-06-23 17:40:07', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(767, 1, 21, '2020-06-23 17:40:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(768, 1, 21, '2020-06-23 17:41:27', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(769, 1, 21, '2020-06-23 17:42:11', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(770, 1, 21, '2020-06-23 17:42:57', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(771, 1, 21, '2020-06-23 17:45:28', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(772, 1, 21, '2020-06-23 17:45:45', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(773, 1, 21, '2020-06-23 17:46:02', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(774, 1, 21, '2020-06-23 17:46:39', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(775, 1, 21, '2020-06-23 17:47:41', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(776, 1, 20, '2020-06-23 17:47:44', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(777, 1, 21, '2020-06-23 17:52:29', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(778, 1, 21, '2020-06-23 17:52:31', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(779, 1, 21, '2020-06-23 17:53:26', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(780, 1, 21, '2020-06-23 17:55:29', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(781, 1, 21, '2020-06-23 17:55:38', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(782, 1, 20, '2020-06-23 17:55:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(783, 1, 21, '2020-06-23 17:58:16', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(784, 1, 20, '2020-06-23 18:07:01', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(785, 1, 20, '2020-06-23 18:07:19', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(786, 1, 20, '2020-06-23 18:07:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(787, 1, 21, '2020-06-23 18:09:51', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(788, 1, 21, '2020-06-23 18:10:34', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(789, 1, 21, '2020-06-23 18:10:43', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(790, 1, 21, '2020-06-23 18:10:55', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(791, 1, 21, '2020-06-23 18:10:57', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(792, 1, 21, '2020-06-23 18:11:00', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(793, 1, 21, '2020-06-23 18:11:02', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(794, 1, 20, '2020-06-23 18:12:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(795, 1, 20, '2020-06-23 18:12:09', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(796, 1, 20, '2020-06-23 18:12:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(797, 1, 20, '2020-06-23 18:12:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(798, 1, 21, '2020-06-23 18:12:29', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(799, 1, 21, '2020-06-23 18:12:48', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(800, 1, 21, '2020-06-23 18:12:51', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(801, 1, 21, '2020-06-23 18:13:17', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(802, 1, 21, '2020-06-23 18:13:20', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(803, 1, 21, '2020-06-23 18:13:22', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(804, 1, 20, '2020-06-23 18:13:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(805, 1, 20, '2020-06-23 18:13:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(806, 1, 20, '2020-06-23 18:13:31', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(807, 1, 21, '2020-06-23 18:13:32', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(808, 1, 21, '2020-06-23 18:13:36', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(809, 1, 20, '2020-06-23 18:13:42', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(810, 1, 21, '2020-06-23 18:14:15', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(811, 1, 21, '2020-06-23 18:14:18', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(812, 1, 21, '2020-06-23 18:14:23', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(813, 1, 21, '2020-06-23 18:15:05', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(814, 1, 21, '2020-06-23 18:15:16', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(815, 1, 21, '2020-06-23 18:17:21', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(816, 1, 21, '2020-06-23 18:18:07', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(817, 1, 21, '2020-06-23 18:18:16', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(818, 1, 21, '2020-06-23 18:18:33', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(819, 1, 21, '2020-06-23 18:18:37', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(820, 1, 21, '2020-06-23 18:18:39', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(821, 1, 21, '2020-06-23 18:18:51', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(822, 1, 21, '2020-06-23 18:18:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(823, 1, 21, '2020-06-23 18:24:26', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(824, 1, 21, '2020-06-23 18:24:37', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(825, 1, 21, '2020-06-23 18:26:48', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(826, 1, 21, '2020-06-23 18:30:09', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(827, 1, 21, '2020-06-23 18:30:11', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(828, 1, 21, '2020-06-23 18:30:23', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(829, 1, 21, '2020-06-23 18:30:26', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(830, 1, 21, '2020-06-23 18:30:41', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(831, 1, 21, '2020-06-23 18:31:24', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(832, 1, 21, '2020-06-23 18:31:42', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(833, 1, 21, '2020-06-23 18:31:46', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(834, 1, 21, '2020-06-23 18:31:54', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(835, 1, 21, '2020-06-23 18:31:57', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(836, 1, 21, '2020-06-23 18:33:11', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(837, 1, 21, '2020-06-23 18:33:14', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(838, 1, 21, '2020-06-23 22:34:26', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(839, 1, 21, '2020-06-23 22:34:28', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(840, 1, 21, '2020-06-23 22:38:24', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(841, 1, 21, '2020-06-23 22:38:26', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(842, 1, 21, '2020-06-23 22:38:45', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(843, 1, 21, '2020-06-23 22:38:54', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(844, 1, 21, '2020-06-23 22:39:47', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(845, 1, 21, '2020-06-23 22:39:50', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(846, 1, 21, '2020-06-23 22:40:41', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(847, 1, 21, '2020-06-23 22:40:42', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(848, 1, 21, '2020-06-23 22:41:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(849, 1, 21, '2020-06-23 22:42:50', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(850, 1, 21, '2020-06-23 22:42:52', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(851, 1, 21, '2020-06-23 22:46:41', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(852, 1, 21, '2020-06-23 22:46:43', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(853, 1, 21, '2020-06-23 22:47:11', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(854, 1, 21, '2020-06-23 22:47:14', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(855, 1, 21, '2020-06-23 22:47:17', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(856, 1, 21, '2020-06-23 22:47:22', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(857, 1, 21, '2020-06-23 22:47:27', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(858, 1, 21, '2020-06-23 22:47:30', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(859, 1, 21, '2020-06-23 22:47:36', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(860, 1, 21, '2020-06-23 22:47:39', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(861, 1, 21, '2020-06-23 22:49:50', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(862, 1, 21, '2020-06-23 22:49:56', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(863, 1, 21, '2020-06-23 22:49:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(864, 1, 21, '2020-06-23 22:50:04', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(865, 1, 21, '2020-06-23 22:50:12', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(866, 1, 21, '2020-06-23 22:50:20', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(867, 1, 21, '2020-06-23 22:53:52', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(868, 1, 21, '2020-06-23 22:53:56', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(869, 1, 21, '2020-06-23 22:55:47', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(870, 1, 21, '2020-06-23 22:56:28', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(871, 1, 21, '2020-06-23 22:56:29', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(872, 1, 21, '2020-06-23 22:57:04', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(873, 1, 21, '2020-06-23 22:57:06', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(874, 1, 21, '2020-06-23 22:57:16', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(875, 1, 21, '2020-06-23 22:57:35', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(876, 1, 21, '2020-06-23 22:57:48', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(877, 1, 21, '2020-06-23 23:03:15', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(878, 1, 20, '2020-06-23 23:46:46', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(879, 1, 20, '2020-06-23 23:46:48', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(880, 1, 21, '2020-06-23 23:46:56', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(881, 1, 21, '2020-06-23 23:50:22', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(882, 1, 21, '2020-06-23 23:50:27', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(883, 1, 21, '2020-06-23 23:50:30', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(885, 1, 21, '2020-06-23 23:50:34', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(886, 1, 21, '2020-06-23 23:51:15', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(887, 1, 21, '2020-06-23 23:51:32', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(888, 1, 21, '2020-06-23 23:51:36', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(889, 1, 21, '2020-06-23 23:51:40', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(890, 1, 21, '2020-06-23 23:51:48', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(891, 1, 21, '2020-06-23 23:52:17', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(892, 1, 21, '2020-06-23 23:52:19', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(893, 1, 21, '2020-06-23 23:52:23', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(894, 1, 21, '2020-06-23 23:52:46', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(895, 1, 21, '2020-06-23 23:52:47', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(896, 1, 21, '2020-06-23 23:52:50', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(897, 1, 21, '2020-06-23 23:52:52', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(898, 1, 21, '2020-06-23 23:52:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(899, 1, 21, '2020-06-23 23:53:02', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(900, 1, 21, '2020-06-23 23:53:05', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(901, 1, 21, '2020-06-23 23:53:36', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(902, 1, 21, '2020-06-23 23:53:37', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(904, 1, 21, '2020-06-23 23:53:40', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(905, 1, 21, '2020-06-23 23:55:00', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(906, 1, 21, '2020-06-23 23:55:01', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(908, 1, 21, '2020-06-23 23:55:06', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(909, 1, 21, '2020-06-23 23:57:42', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(910, 1, 21, '2020-06-23 23:57:44', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(912, 1, 21, '2020-06-23 23:57:50', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(913, 1, 21, '2020-06-23 23:59:02', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(914, 1, 21, '2020-06-23 23:59:04', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(916, 1, 21, '2020-06-23 23:59:14', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(917, 1, 21, '2020-06-24 00:00:27', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(918, 1, 21, '2020-06-24 00:00:30', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(919, 1, 21, '2020-06-24 00:00:44', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(920, 1, 21, '2020-06-24 00:00:46', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(922, 1, 21, '2020-06-24 00:01:00', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(923, 1, 21, '2020-06-24 17:30:28', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(924, 1, 21, '2020-06-24 17:31:14', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(925, 1, 21, '2020-06-24 17:31:17', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(926, 1, 21, '2020-06-24 17:31:20', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(928, 1, 21, '2020-06-24 17:31:29', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(929, 1, 21, '2020-06-24 17:31:42', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(930, 1, 21, '2020-06-24 17:31:45', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(932, 1, 21, '2020-06-24 17:32:11', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(933, 1, 21, '2020-06-24 17:32:33', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(934, 1, 21, '2020-06-24 17:32:37', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(936, 1, 21, '2020-06-24 17:32:53', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(937, 1, 21, '2020-06-24 17:33:23', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(938, 1, 21, '2020-06-24 17:33:27', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(940, 1, 21, '2020-06-24 17:33:31', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(941, 1, 21, '2020-06-24 17:34:36', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(942, 1, 21, '2020-06-24 17:34:39', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(944, 1, 21, '2020-06-24 17:34:42', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(945, 1, 21, '2020-06-24 17:49:15', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(946, 1, 21, '2020-06-24 17:50:48', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(947, 1, 21, '2020-06-24 17:51:08', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(948, 1, 21, '2020-06-24 17:51:43', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(949, 1, 21, '2020-06-24 17:55:09', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(950, 1, 21, '2020-06-24 17:55:11', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(951, 1, 21, '2020-06-24 17:56:02', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(952, 1, 21, '2020-06-24 17:56:06', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(953, 1, 20, '2020-06-24 20:23:27', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(954, 1, 20, '2020-06-24 20:23:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(955, 1, 20, '2020-06-24 20:23:40', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(956, 1, 21, '2020-06-24 20:23:55', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(957, 1, 20, '2020-06-24 20:24:04', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(958, 1, 20, '2020-06-24 20:24:08', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(959, 1, 20, '2020-06-24 20:24:27', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONPRUEBA DE OBSERVACION DE VINCULACION'),
(960, 1, 20, '2020-06-24 20:24:27', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(961, 1, 20, '2020-06-24 20:27:18', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(962, 1, 20, '2020-06-24 20:27:22', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(963, 1, 20, '2020-06-24 20:27:25', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(964, 1, 20, '2020-06-24 20:27:30', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(965, 1, 20, '2020-06-24 20:27:31', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(966, 1, 20, '2020-06-24 20:27:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(967, 1, 21, '2020-06-24 20:28:20', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(968, 1, 21, '2020-06-24 20:28:46', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(969, 1, 21, '2020-06-24 20:28:55', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(970, 1, 21, '2020-06-24 20:28:57', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(971, 1, 21, '2020-06-24 20:29:03', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(973, 1, 21, '2020-06-24 20:29:10', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(974, 1, 21, '2020-06-24 20:29:39', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(975, 1, 21, '2020-06-24 20:29:43', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(977, 1, 21, '2020-06-24 20:29:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(978, 1, 21, '2020-06-24 20:30:40', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(979, 1, 21, '2020-06-24 20:30:42', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(981, 1, 21, '2020-06-24 20:30:57', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(982, 1, 20, '2020-06-24 20:31:05', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(983, 1, 21, '2020-06-24 20:31:13', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(984, 1, 21, '2020-06-24 20:31:34', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(985, 1, 20, '2020-06-24 20:31:38', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(986, 1, 21, '2020-06-24 20:31:45', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(988, 1, 21, '2020-06-24 20:31:51', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(989, 1, 20, '2020-06-24 20:31:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(990, 1, 21, '2020-06-24 20:32:19', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(991, 1, 20, '2020-06-24 20:32:22', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(992, 1, 21, '2020-06-24 20:32:25', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(994, 1, 21, '2020-06-24 20:32:35', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(995, 1, 20, '2020-06-24 20:32:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(996, 1, 21, '2020-06-24 20:32:49', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(997, 1, 21, '2020-06-24 20:33:06', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(998, 1, 20, '2020-06-24 20:33:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(999, 1, 21, '2020-06-24 20:33:13', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1001, 1, 21, '2020-06-24 20:33:33', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1002, 1, 20, '2020-06-24 20:33:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1003, 1, 20, '2020-06-24 20:34:14', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1004, 1, 20, '2020-06-24 20:34:19', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1005, 1, 20, '2020-06-24 20:34:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1006, 1, 20, '2020-06-24 20:34:59', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1007, 1, 20, '2020-06-24 20:35:04', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1008, 1, 20, '2020-06-24 20:35:09', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(1009, 1, 20, '2020-06-24 20:35:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1010, 1, 21, '2020-06-24 20:35:15', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1011, 1, 21, '2020-06-24 20:35:42', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1012, 1, 21, '2020-06-24 20:35:51', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1013, 1, 21, '2020-06-24 20:36:00', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1014, 1, 21, '2020-06-24 20:36:32', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1015, 1, 21, '2020-06-24 20:36:49', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1016, 1, 21, '2020-06-24 20:37:23', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1017, 1, 21, '2020-06-24 20:48:30', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1018, 1, 21, '2020-06-24 20:48:31', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1019, 1, 19, '2020-06-24 20:51:44', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(1020, 1, 19, '2020-06-24 20:52:03', 'INGRESO', 'EL DOCUMENTO5.1.1.7 Lab - Using Wireshark to Examine Ethernet Frames.pdf, EL USUARIO CON CUENTA: 20141012159'),
(1021, 1, 19, '2020-06-24 20:52:04', 'INGRESO', 'EL DOCUMENTO6.3.1.8 Packet Tracer - Exploring Internetworking Devices.pdf, EL USUARIO CON CUENTA: 20141012159'),
(1022, 1, 19, '2020-06-24 20:52:04', 'INGRESO', 'EL DOCUMENTO6.3.2.7 Lab - Exploring Router Physical Characteristics.pdf, EL USUARIO CON CUENTA: 20141012159'),
(1023, 1, 19, '2020-06-24 20:52:04', 'INGRESO', 'EL DOCUMENTO6.4.1.3 Packet Tracer - Configure Initial Router Settings.pdf, EL USUARIO CON CUENTA: 20141012159'),
(1024, 1, 20, '2020-06-24 20:52:11', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1025, 1, 20, '2020-06-24 20:52:22', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1026, 1, 19, '2020-06-24 20:53:02', 'INGRESO', 'EL DOCUMENTO7.1.2.8 Lab - Using the Windows Calculator with Network Addresses.pdf, EL USUARIO CON CUENTA: 20141012159'),
(1027, 1, 19, '2020-06-24 20:53:02', 'INGRESO', 'EL DOCUMENTO7.1.2.9 Lab - Converting IPv4 Addresses to Binary.pdf, EL USUARIO CON CUENTA: 20141012159'),
(1028, 1, 20, '2020-06-24 20:53:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1029, 1, 20, '2020-06-24 20:53:09', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1030, 1, 21, '2020-06-24 20:53:34', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1031, 1, 21, '2020-06-24 20:54:05', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1032, 1, 21, '2020-06-24 20:56:24', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1033, 1, 21, '2020-06-24 20:56:54', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1034, 1, 21, '2020-06-24 20:57:16', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1035, 1, 21, '2020-06-24 20:57:27', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1036, 1, 21, '2020-06-24 20:57:41', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1037, 1, 17, '2020-06-24 21:00:35', 'INGRESO', 'A REGISTRAR EMPRESAS PARA PRACTICA.'),
(1038, 1, 18, '2020-06-24 21:02:04', 'MODIFICO', 'LOS DATOS DE LA EMPRESA '),
(1039, 1, 17, '2020-06-24 21:02:14', 'INGRESO', 'A REGISTRAR EMPRESAS PARA PRACTICA.'),
(1040, 1, 21, '2020-06-24 21:02:18', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1041, 1, 17, '2020-06-24 21:02:29', 'INGRESO', 'A REGISTRAR EMPRESAS PARA PRACTICA.'),
(1042, 1, 20, '2020-06-24 22:28:51', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1043, 1, 20, '2020-06-24 22:29:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1044, 1, 20, '2020-06-24 22:29:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1045, 1, 21, '2020-06-24 22:29:54', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1046, 1, 21, '2020-06-24 22:29:59', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1048, 1, 21, '2020-06-24 22:30:03', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1049, 1, 20, '2020-06-24 22:30:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1050, 1, 20, '2020-06-24 22:30:19', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1051, 1, 20, '2020-06-24 22:30:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1052, 1, 21, '2020-06-24 22:30:36', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1053, 1, 21, '2020-06-24 22:34:32', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1054, 1, 21, '2020-06-24 22:34:55', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1055, 1, 21, '2020-06-24 22:34:59', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1056, 1, 21, '2020-06-24 22:45:51', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1057, 1, 21, '2020-06-24 22:47:23', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1058, 1, 21, '2020-06-24 22:47:39', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1059, 1, 21, '2020-06-24 22:48:36', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1060, 1, 21, '2020-06-24 22:49:00', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1061, 1, 21, '2020-06-24 22:50:15', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1062, 1, 21, '2020-06-24 22:50:45', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1063, 1, 22, '2020-06-24 22:56:25', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1064, 1, 22, '2020-06-24 22:56:32', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1065, 1, 22, '2020-06-24 22:56:42', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1066, 1, 22, '2020-06-24 23:02:59', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1067, 1, 22, '2020-06-24 23:03:01', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1068, 1, 22, '2020-06-24 23:03:09', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1069, 1, 22, '2020-06-24 23:03:44', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1070, 1, 22, '2020-06-24 23:03:46', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1071, 1, 22, '2020-06-24 23:03:48', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1072, 1, 22, '2020-06-24 23:03:50', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1073, 1, 22, '2020-06-24 23:03:53', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1074, 1, 22, '2020-06-24 23:03:57', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1075, 1, 22, '2020-06-24 23:04:03', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1076, 1, 22, '2020-06-24 23:04:04', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1077, 1, 22, '2020-06-24 23:05:20', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1078, 1, 22, '2020-06-24 23:05:22', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1079, 1, 22, '2020-06-24 23:05:24', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1080, 1, 22, '2020-06-24 23:05:26', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1081, 1, 22, '2020-06-24 23:05:28', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1082, 1, 22, '2020-06-24 23:05:32', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1083, 1, 22, '2020-06-24 23:05:39', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1084, 1, 22, '2020-06-24 23:05:43', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1085, 1, 22, '2020-06-24 23:05:49', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1086, 1, 22, '2020-06-24 23:05:57', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1087, 1, 22, '2020-06-24 23:06:05', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1088, 1, 22, '2020-06-24 23:06:11', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1089, 1, 22, '2020-06-24 23:06:12', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1090, 1, 22, '2020-06-24 23:13:08', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1091, 1, 27, '2020-06-24 23:13:12', 'ACTUALIZO', 'DERECHO PARA CAMBIO DE EMPRESA AL ESTUDIANTE CON CUENTA 20141012159'),
(1092, 1, 20, '2020-06-24 23:13:12', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1093, 1, 22, '2020-06-24 23:13:22', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1094, 1, 22, '2020-06-24 23:13:58', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1095, 1, 22, '2020-06-24 23:14:01', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1096, 1, 27, '2020-06-24 23:14:05', 'ACTUALIZO', 'DERECHO PARA CAMBIO DE EMPRESA AL ESTUDIANTE CON CUENTA 20141012159'),
(1097, 1, 22, '2020-06-24 23:14:05', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1098, 1, 21, '2020-06-24 23:14:11', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1099, 1, 20, '2020-06-24 23:14:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1100, 1, 11, '2020-06-24 23:18:24', 'Ingreso', 'A Gestion de respuestas a preguntas de seguridad'),
(1101, 11, 12, '2020-06-24 23:24:22', 'Ingreso', 'A Cambiar clave como usuario'),
(1102, 11, 12, '2020-06-24 23:26:02', 'Ingreso', 'A Cambiar clave como usuario'),
(1103, 1, 9, '2020-06-24 23:30:41', 'Ingreso', 'A Permisos a roles y pantallas'),
(1104, 1, 20, '2020-06-24 23:36:38', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1105, 1, 20, '2020-06-24 23:36:40', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1106, 1, 20, '2020-06-24 23:36:44', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(1107, 1, 20, '2020-06-24 23:36:44', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1108, 1, 21, '2020-06-24 23:36:52', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1109, 1, 21, '2020-06-24 23:36:53', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1111, 1, 21, '2020-06-24 23:36:57', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1112, 1, 22, '2020-06-24 23:37:03', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1113, 1, 22, '2020-06-24 23:37:05', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1114, 1, 27, '2020-06-24 23:37:08', 'ACTUALIZO', 'DERECHO PARA CAMBIO DE EMPRESA AL ESTUDIANTE CON CUENTA 20141012159'),
(1115, 1, 22, '2020-06-24 23:37:08', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1116, 1, 20, '2020-06-24 23:37:22', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1117, 1, 20, '2020-06-24 23:37:25', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1118, 1, 20, '2020-06-24 23:37:28', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(1119, 1, 20, '2020-06-24 23:37:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1120, 1, 21, '2020-06-24 23:37:32', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1121, 1, 21, '2020-06-24 23:37:35', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1123, 1, 21, '2020-06-24 23:37:49', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1124, 1, 8, '2020-06-24 23:41:51', 'INSERTO', 'EL PERMISO Inscripcion para charla practica'),
(1125, 1, 8, '2020-06-24 23:41:54', 'INSERTO', 'EL PERMISO Registro de datos de empresa'),
(1126, 1, 8, '2020-06-24 23:41:57', 'INSERTO', 'EL PERMISO Entrega de documentacion'),
(1127, 1, 9, '2020-06-24 23:42:06', 'Ingreso', 'A Permisos a roles y pantallas'),
(1128, 1, 9, '2020-06-24 23:43:45', 'Ingreso', 'A Permisos a roles y pantallas'),
(1129, 1, 8, '2020-06-24 23:44:12', 'INSERTO', 'EL PERMISO Historial de practicas aprobadas');
INSERT INTO `tbl_bitacora` (`Id_bitacora`, `Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES
(1130, 1, 8, '2020-06-24 23:44:15', 'INSERTO', 'EL PERMISO Historial de practicas rechazadas'),
(1131, 1, 9, '2020-06-24 23:44:24', 'Ingreso', 'A Permisos a roles y pantallas'),
(1132, 1, 28, '2020-06-24 23:46:21', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1133, 11, 13, '2020-06-24 23:46:22', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(1134, 1, 27, '2020-06-24 23:46:23', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1135, 1, 28, '2020-06-24 23:46:31', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1136, 1, 27, '2020-06-24 23:46:56', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1137, 1, 28, '2020-06-24 23:47:01', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1138, 1, 28, '2020-06-24 23:47:06', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1139, 1, 28, '2020-06-24 23:47:07', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1140, 1, 28, '2020-06-24 23:47:11', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1141, 1, 28, '2020-06-24 23:47:17', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1142, 11, 13, '2020-06-24 23:48:32', 'INSERTO', 'LA INSCRIPCION DE CHARLA AL USUARIO 20151005561'),
(1143, 1, 28, '2020-06-24 23:48:46', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1144, 1, 28, '2020-06-24 23:48:48', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1145, 11, 17, '2020-06-24 23:50:26', 'INGRESO', 'A REGISTRAR EMPRESAS PARA PRACTICA.'),
(1146, 1, 28, '2020-06-24 23:51:58', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1147, 1, 28, '2020-06-24 23:51:59', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1148, 1, 28, '2020-06-24 23:52:55', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1149, 1, 28, '2020-06-24 23:53:01', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1150, 1, 28, '2020-06-24 23:53:03', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1151, 1, 28, '2020-06-24 23:53:58', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1152, 1, 28, '2020-06-24 23:54:09', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1153, 1, 28, '2020-06-24 23:54:13', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1154, 1, 28, '2020-06-24 23:56:26', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1155, 11, 17, '2020-06-24 23:56:45', 'INSERTO', 'LA EMPRESA TIGO'),
(1156, 1, 14, '2020-06-24 23:57:31', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1157, 1, 14, '2020-06-24 23:58:09', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1159, 1, 14, '2020-06-25 00:00:44', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1160, 11, 19, '2020-06-25 00:11:33', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(1161, 11, 19, '2020-06-25 00:12:14', 'INGRESO', 'EL DOCUMENTO3.-Instructivo-de-Formato-de-Proyectos (1).pdf, EL USUARIO CON CUENTA: 20151005561'),
(1162, 11, 19, '2020-06-25 00:12:18', 'INGRESO', 'EL DOCUMENTO3.-Instructivo-de-Formato-de-Proyectos.pdf, EL USUARIO CON CUENTA: 20151005561'),
(1163, 11, 19, '2020-06-25 00:12:21', 'INGRESO', 'EL DOCUMENTOA U T O R I Z A C I O N DEDUCCION.doc, EL USUARIO CON CUENTA: 20151005561'),
(1164, 11, 19, '2020-06-25 00:12:24', 'INGRESO', 'EL DOCUMENTOACCIONES POR PARTE DEL GOBIERNO DE LA REPUBLICA EN CUANTO A LA PROTECCION DE DATOS.docx, EL USUARIO CON CUENTA: 20151005561'),
(1165, 1, 26, '2020-06-25 00:15:15', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(1166, 1, 26, '2020-06-25 00:16:38', 'INGRESO', 'A GESTION ESTUDIANTE PRACTICA '),
(1167, 1, 20, '2020-06-25 00:18:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1168, 1, 20, '2020-06-25 00:19:21', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1169, 1, 20, '2020-06-25 00:19:21', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1170, 1, 20, '2020-06-25 00:19:44', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1171, 1, 20, '2020-06-25 00:19:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1172, 1, 20, '2020-06-25 00:20:10', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1173, 1, 20, '2020-06-25 00:20:34', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1174, 1, 20, '2020-06-25 00:21:07', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20151005561 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(1175, 1, 20, '2020-06-25 00:21:16', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1176, 1, 20, '2020-06-25 00:21:28', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1177, 1, 21, '2020-06-25 00:22:41', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1178, 1, 21, '2020-06-25 00:23:20', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1180, 1, 21, '2020-06-25 00:24:10', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1181, 1, 21, '2020-06-25 00:25:12', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1183, 1, 21, '2020-06-25 00:25:48', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1184, 1, 20, '2020-06-25 00:26:31', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1185, 1, 21, '2020-06-25 00:26:52', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1186, 1, 21, '2020-06-25 00:27:13', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1187, 1, 21, '2020-06-25 00:27:16', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1189, 1, 21, '2020-06-25 00:27:22', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1190, 1, 21, '2020-06-25 00:27:50', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1191, 1, 21, '2020-06-25 00:28:22', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1192, 1, 20, '2020-06-25 00:30:37', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1193, 1, 21, '2020-06-25 00:30:49', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1194, 11, 13, '2020-06-25 13:30:18', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(1195, 11, 19, '2020-06-25 14:11:41', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(1196, 1, 20, '2020-06-25 14:19:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1197, 1, 20, '2020-06-25 14:20:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1198, 1, 20, '2020-06-25 14:20:30', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1199, 1, 20, '2020-06-25 14:20:35', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1200, 1, 20, '2020-06-25 14:20:38', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1201, 1, 20, '2020-06-25 14:20:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1202, 1, 20, '2020-06-25 14:20:47', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1203, 1, 20, '2020-06-25 14:20:48', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1204, 1, 20, '2020-06-25 14:21:45', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1205, 1, 20, '2020-06-25 14:22:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1206, 1, 20, '2020-06-25 14:22:57', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1207, 1, 20, '2020-06-25 14:23:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1208, 1, 20, '2020-06-25 14:24:23', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1209, 1, 20, '2020-06-25 14:24:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1210, 1, 21, '2020-06-25 14:29:44', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1211, 1, 20, '2020-06-25 14:29:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1212, 1, 21, '2020-06-25 14:29:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1213, 1, 22, '2020-06-25 14:34:02', 'INGRESO', 'A REGISTRAR EGRESADOS.'),
(1214, 1, 20, '2020-06-25 14:35:49', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1215, 1, 20, '2020-06-25 14:36:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1216, 1, 22, '2020-06-25 14:37:11', 'INSERTO', 'AL EGRESADO MARIA CALLEJAS'),
(1217, 1, 21, '2020-06-25 14:39:46', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1218, 1, 21, '2020-06-25 14:39:49', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1219, 1, 20, '2020-06-25 14:39:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1220, 1, 20, '2020-06-25 14:40:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1221, 1, 20, '2020-06-25 14:40:26', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1222, 1, 21, '2020-06-25 14:40:34', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1223, 1, 20, '2020-06-25 14:41:22', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1224, 1, 20, '2020-06-25 14:41:24', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1225, 1, 20, '2020-06-25 14:41:27', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20151005561 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(1226, 1, 20, '2020-06-25 14:41:27', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1227, 1, 21, '2020-06-25 14:41:32', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1228, 1, 21, '2020-06-25 14:41:34', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1230, 1, 21, '2020-06-25 14:41:58', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1231, 1, 23, '2020-06-25 14:42:03', 'INGRESO', 'A GESTION DE EGRESADOS'),
(1232, 1, 27, '2020-06-25 14:42:17', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1233, 1, 22, '2020-06-25 14:42:18', 'INGRESO', 'A REGISTRAR EGRESADOS.'),
(1234, 1, 28, '2020-06-25 14:42:26', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1235, 1, 28, '2020-06-25 14:42:32', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1236, 1, 28, '2020-06-25 14:42:36', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1237, 1, 28, '2020-06-25 14:42:38', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1238, 1, 28, '2020-06-25 14:42:42', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1239, 1, 28, '2020-06-25 14:42:45', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1240, 1, 23, '2020-06-25 14:42:51', 'INGRESO', 'A GESTION DE EGRESADOS'),
(1241, 1, 28, '2020-06-25 14:43:16', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1242, 1, 28, '2020-06-25 14:43:20', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1243, 1, 23, '2020-06-25 14:43:56', 'INGRESO', 'A GESTION DE EGRESADOS'),
(1244, 1, 23, '2020-06-25 14:44:13', 'INGRESO', 'A GESTION DE EGRESADOS'),
(1245, 1, 23, '2020-06-25 14:45:48', 'MODIFICO', 'LOS DATOS DEL EGRESADO HYHY'),
(1246, 1, 23, '2020-06-25 14:45:57', 'INGRESO', 'A GESTION DE EGRESADOS'),
(1247, 1, 28, '2020-06-25 14:46:35', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1248, 1, 28, '2020-06-25 14:46:39', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1249, 1, 28, '2020-06-25 14:46:42', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1250, 1, 28, '2020-06-25 14:46:44', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1251, 1, 23, '2020-06-25 14:47:22', 'INGRESO', 'A GESTION DE EGRESADOS'),
(1252, 1, 28, '2020-06-25 14:47:26', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1253, 1, 28, '2020-06-25 14:47:29', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1254, 1, 24, '2020-06-25 14:48:32', 'INGRESO', 'A REGISTRAR PROYECTOS.'),
(1255, 1, 20, '2020-06-25 14:50:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1256, 1, 28, '2020-06-25 14:50:12', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1257, 1, 27, '2020-06-25 14:50:22', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1258, 1, 21, '2020-06-25 14:50:28', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1259, 1, 20, '2020-06-25 14:50:32', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1260, 1, 27, '2020-06-25 14:53:02', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1261, 1, 27, '2020-06-25 14:53:21', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1262, 1, 27, '2020-06-25 14:53:35', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1263, 1, 27, '2020-06-25 14:53:59', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1264, 1, 27, '2020-06-25 14:55:22', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1265, 1, 27, '2020-06-25 14:55:35', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1266, 1, 27, '2020-06-25 14:55:48', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1267, 1, 27, '2020-06-25 14:55:51', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1268, 1, 27, '2020-06-25 14:55:53', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1269, 1, 27, '2020-06-25 14:55:56', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1270, 1, 27, '2020-06-25 14:56:26', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1271, 1, 27, '2020-06-25 14:56:29', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1272, 1, 27, '2020-06-25 14:56:32', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1273, 1, 24, '2020-06-25 14:56:33', 'INSERTO', 'EL PROYECTO AUTOMATIZAR'),
(1274, 1, 27, '2020-06-25 14:56:34', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1275, 1, 27, '2020-06-25 14:56:41', 'ACTUALIZO', 'DERECHO PARA CAMBIO DE EMPRESA AL ESTUDIANTE CON CUENTA 20151005561'),
(1276, 1, 27, '2020-06-25 14:56:41', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1277, 1, 27, '2020-06-25 14:56:48', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1278, 1, 27, '2020-06-25 14:57:04', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1279, 1, 27, '2020-06-25 14:57:45', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1280, 1, 27, '2020-06-25 14:57:58', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1281, 1, 27, '2020-06-25 15:00:05', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1282, 1, 27, '2020-06-25 15:00:27', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1283, 1, 27, '2020-06-25 15:00:30', 'ACTUALIZO', 'DERECHO PARA CAMBIO DE EMPRESA AL ESTUDIANTE CON CUENTA 20151005561'),
(1284, 1, 27, '2020-06-25 15:00:30', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1285, 1, 20, '2020-06-25 15:00:50', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1286, 1, 27, '2020-06-25 15:02:03', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1287, 1, 28, '2020-06-25 15:04:29', 'INGRESO', 'A  HISTORIAL DE PRACTICA RECHAZADAS '),
(1288, 1, 20, '2020-06-25 15:05:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1289, 1, 20, '2020-06-25 15:18:53', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1290, 1, 20, '2020-06-25 15:18:58', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1291, 1, 20, '2020-06-25 15:19:03', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20151005561 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(1292, 1, 20, '2020-06-25 15:19:03', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1293, 1, 21, '2020-06-25 15:19:12', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1294, 1, 21, '2020-06-25 15:19:15', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1296, 1, 21, '2020-06-25 15:19:32', 'INGRESO', 'A  APROBACION/RECHAZO DE PRACTICA '),
(1297, 1, 20, '2020-06-25 15:19:40', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1298, 1, 27, '2020-06-25 15:20:03', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1299, 1, 27, '2020-06-25 15:20:05', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1300, 1, 27, '2020-06-25 15:20:09', 'ACTUALIZO', 'DERECHO PARA CAMBIO DE EMPRESA AL ESTUDIANTE CON CUENTA 20151005561'),
(1301, 1, 27, '2020-06-25 15:20:10', 'INGRESO', 'A  HISTORIAL DE PRACTICA APROBADAS '),
(1302, 1, 20, '2020-06-25 15:20:14', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1303, 1, 20, '2020-06-25 15:20:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1304, 1, 20, '2020-06-25 15:20:21', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1305, 13, 12, '2020-06-25 15:51:10', 'Ingreso', 'A Cambiar clave como usuario'),
(1306, 13, 13, '2020-06-25 15:56:26', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(1307, 13, 13, '2020-06-25 16:00:23', 'INSERTO', 'LA INSCRIPCION DE CHARLA AL USUARIO 20202020200'),
(1308, 1, 14, '2020-06-25 16:03:29', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1309, 1, 14, '2020-06-25 16:05:58', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1312, 1, 14, '2020-06-25 16:07:25', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1313, 1, 15, '2020-06-25 16:11:38', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(1314, 1, 15, '2020-06-25 16:12:15', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(1315, 1, 15, '2020-06-25 16:14:58', 'INSERTO', 'LA  ASIGNATURA ADMINISTRACION II'),
(1316, 1, 15, '2020-06-25 16:15:01', 'INSERTO', 'LA  ASIGNATURA ADMINISTRACION PUBLICA Y POLITICA INFORMATICA'),
(1317, 1, 15, '2020-06-25 16:15:04', 'INSERTO', 'LA  ASIGNATURA ADMON Y EVALUACION DE PROYECTOS EN INFORMATICA'),
(1318, 1, 15, '2020-06-25 16:15:07', 'INSERTO', 'LA  ASIGNATURA ANALISIS CUANTITATIVO II'),
(1319, 1, 15, '2020-06-25 16:15:10', 'INSERTO', 'LA  ASIGNATURA ANALISIS CUANTITATIVO9S I'),
(1320, 1, 15, '2020-06-25 16:15:14', 'INSERTO', 'LA  ASIGNATURA ANALISIS NUMERICO'),
(1321, 1, 15, '2020-06-25 16:15:17', 'INSERTO', 'LA  ASIGNATURA ANALISIS Y DISEÑO DE SISTEMAS'),
(1322, 1, 15, '2020-06-25 16:15:20', 'INSERTO', 'LA  ASIGNATURA AUDITORIA EN INFORMATICA'),
(1323, 1, 15, '2020-06-25 16:15:23', 'INSERTO', 'LA  ASIGNATURA BASE DE DATOS I'),
(1324, 1, 15, '2020-06-25 16:15:26', 'INSERTO', 'LA  ASIGNATURA BASE DE DATOS II'),
(1325, 1, 15, '2020-06-25 16:15:29', 'INSERTO', 'LA  ASIGNATURA COMUNICACION ELECTRONICA DE DATOS'),
(1326, 1, 15, '2020-06-25 16:15:32', 'INSERTO', 'LA  ASIGNATURA CONTABILIDAD ADMINISTRATIVA I'),
(1327, 1, 15, '2020-06-25 16:15:35', 'INSERTO', 'LA  ASIGNATURA CONTABILIDAD ADMINSTRATIVA II'),
(1328, 1, 15, '2020-06-25 16:15:38', 'INSERTO', 'LA  ASIGNATURA CONTABILIDAD I'),
(1329, 1, 15, '2020-06-25 16:15:42', 'INSERTO', 'LA  ASIGNATURA CONTABILIDAD II'),
(1330, 1, 15, '2020-06-25 16:15:45', 'INSERTO', 'LA  ASIGNATURA ESPAÑOL'),
(1331, 1, 15, '2020-06-25 16:15:48', 'INSERTO', 'LA  ASIGNATURA EVALUACION DE SISTEMAS'),
(1332, 1, 15, '2020-06-25 16:15:51', 'INSERTO', 'LA  ASIGNATURA FILOSOFIA'),
(1333, 1, 15, '2020-06-25 16:15:54', 'INSERTO', 'LA  ASIGNATURA FINANZAS DE EMPRESAS'),
(1334, 1, 15, '2020-06-25 16:15:57', 'INSERTO', 'LA  ASIGNATURA GERENCIA EN INFORMATICA'),
(1335, 1, 15, '2020-06-25 16:16:00', 'INSERTO', 'LA  ASIGNATURA GERENCIA II'),
(1336, 1, 15, '2020-06-25 16:16:03', 'INSERTO', 'LA  ASIGNATURA HISTORIA DE HONDURAS'),
(1337, 1, 15, '2020-06-25 16:16:06', 'INSERTO', 'LA  ASIGNATURA INGLES I'),
(1338, 1, 15, '2020-06-25 16:16:10', 'INSERTO', 'LA  ASIGNATURA INTRODUCCION A LA INFORMATICA'),
(1339, 1, 15, '2020-06-25 16:16:13', 'INSERTO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION I'),
(1340, 1, 15, '2020-06-25 16:16:16', 'INSERTO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION II'),
(1341, 1, 15, '2020-06-25 16:16:19', 'INSERTO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION III'),
(1342, 1, 15, '2020-06-25 16:16:22', 'INSERTO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION III'),
(1343, 1, 15, '2020-06-25 16:16:25', 'INSERTO', 'LA  ASIGNATURA LENGUAJE DE PROGRAMACION IV'),
(1344, 1, 15, '2020-06-25 16:16:28', 'INSERTO', 'LA  ASIGNATURA MACROECONOMIA'),
(1345, 1, 15, '2020-06-25 16:16:31', 'INSERTO', 'LA  ASIGNATURA METODOLOGIA DE LA PROGRAMACION'),
(1346, 1, 15, '2020-06-25 16:16:34', 'INSERTO', 'LA  ASIGNATURA METODOS CUANTITATIVOS'),
(1347, 1, 15, '2020-06-25 16:16:37', 'INSERTO', 'LA  ASIGNATURA METODOS CUANTITATIVOS EN FINANZAS'),
(1348, 1, 15, '2020-06-25 16:16:40', 'INSERTO', 'LA  ASIGNATURA METODOS CUANTITATIVOS II'),
(1349, 1, 15, '2020-06-25 16:16:44', 'INSERTO', 'LA  ASIGNATURA METODOS CUANTITATIVOS III'),
(1350, 1, 15, '2020-06-25 16:16:47', 'INSERTO', 'LA  ASIGNATURA MICROECONOMIA'),
(1351, 1, 15, '2020-06-25 16:16:50', 'INSERTO', 'LA  ASIGNATURA OPTATIVA_1'),
(1352, 1, 15, '2020-06-25 16:16:53', 'INSERTO', 'LA  ASIGNATURA ORGANIZACION Y METODOS DE LA IMFORMATICA'),
(1353, 1, 15, '2020-06-25 16:16:56', 'INSERTO', 'LA  ASIGNATURA PERSPECTIVA DE LA TECNOLOGIA INFORMATICA'),
(1354, 1, 15, '2020-06-25 16:16:59', 'INSERTO', 'LA  ASIGNATURA PRINCIPIOS DE ECONOMIA'),
(1355, 1, 15, '2020-06-25 16:17:02', 'INSERTO', 'LA  ASIGNATURA PROGRAMACION E IMPLEMENTACION DE SISTEMAS'),
(1356, 1, 15, '2020-06-25 16:17:05', 'INSERTO', 'LA  ASIGNATURA RECURSOS HUMANOS EN INFORMATICA'),
(1357, 1, 15, '2020-06-25 16:17:08', 'INSERTO', 'LA  ASIGNATURA REDES DE COMPUTADORAS'),
(1358, 1, 15, '2020-06-25 16:17:11', 'INSERTO', 'LA  ASIGNATURA REORIA DE SISTEMAS'),
(1359, 1, 15, '2020-06-25 16:17:15', 'INSERTO', 'LA  ASIGNATURA SEMINARIO DE INVESTIGACION'),
(1360, 1, 15, '2020-06-25 16:17:18', 'INSERTO', 'LA  ASIGNATURA SISTEMAS OPERATIVOS II'),
(1361, 1, 15, '2020-06-25 16:17:21', 'INSERTO', 'LA  ASIGNATURA SISTEMAS OPERATIVOS II'),
(1362, 1, 15, '2020-06-25 16:17:24', 'INSERTO', 'LA  ASIGNATURA SOCIOLOGIA'),
(1363, 1, 15, '2020-06-25 16:17:27', 'INSERTO', 'LAS ASIGNATURAS AL ESTUDIANTE CON CUENTA 20202020200'),
(1364, 1, 16, '2020-06-25 16:18:46', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(1365, 1, 16, '2020-06-25 16:19:30', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(1366, 1, 16, '2020-06-25 16:20:22', 'MODIFICO', 'LA  ASIGNATURA TALLER DE HARDWARE'),
(1367, 1, 16, '2020-06-25 16:20:25', 'MODIFICO', 'LA  ASIGNATURA TALLER DE HARDWARE'),
(1368, 1, 16, '2020-06-25 16:20:28', 'MODIFICO', 'LAS ASIGNATURAS AL ESTUDIANTE CON NOMBRE ana sevilla'),
(1369, 1, 16, '2020-06-25 16:20:37', 'INGRESO', 'A GESTION ASIGNATURA APROBADAS'),
(1370, 13, 19, '2020-06-25 16:24:57', 'INGRESO', 'A DOCUMENTACION DE PRACTICA.'),
(1371, 13, 19, '2020-06-25 16:26:50', 'INGRESO', 'EL DOCUMENTO3.-Instructivo-de-Formato-de-Proyectos.pdf, EL USUARIO CON CUENTA: 20202020200'),
(1372, 13, 19, '2020-06-25 16:26:53', 'INGRESO', 'EL DOCUMENTOA U T O R I Z A C I O N DEDUCCION.doc, EL USUARIO CON CUENTA: 20202020200'),
(1373, 13, 19, '2020-06-25 16:26:56', 'INGRESO', 'EL DOCUMENTOACCIONES POR PARTE DEL GOBIERNO DE LA REPUBLICA EN CUANTO A LA PROTECCION DE DATOS.docx, EL USUARIO CON CUENTA: 20202020200'),
(1374, 13, 19, '2020-06-25 16:26:59', 'INGRESO', 'EL DOCUMENTOAcuerdos de Nivel de Servicios.pdf, EL USUARIO CON CUENTA: 20202020200'),
(1375, 13, 19, '2020-06-25 16:27:02', 'INGRESO', 'EL DOCUMENTOAnÃ¡lisis de la institucionalidad.docx, EL USUARIO CON CUENTA: 20202020200'),
(1376, 1, 20, '2020-06-25 16:29:02', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1377, 1, 20, '2020-06-25 16:29:41', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1378, 1, 20, '2020-06-25 16:31:55', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1379, 1, 20, '2020-06-25 16:35:58', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20202020200 CON LA DOCUMENTACION NO, APROBADA CON OBSERVACIONNO APLICA PORQUE NO CUMPLE LOS REQUISITOS'),
(1380, 1, 20, '2020-06-25 16:36:07', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1381, 1, 20, '2020-06-25 16:37:17', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1382, 1, 20, '2020-06-25 16:37:29', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1383, 1, 20, '2020-06-25 16:37:45', 'INGRESO', 'VINCULACION DEL ESTUDIANTE CON CUENTA20141012159 CON LA DOCUMENTACION SI, APROBADA CON OBSERVACIONSIN OBSERVACION'),
(1384, 1, 20, '2020-06-25 16:37:54', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1385, 1, 17, '2020-06-25 16:54:58', 'INGRESO', 'A REGISTRAR EMPRESAS PARA PRACTICA.'),
(1386, 1, 22, '2020-06-25 17:03:27', 'INGRESO', 'A REGISTRAR EGRESADOS.'),
(1387, 1, 15, '2020-06-29 23:09:47', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(1388, 1, 15, '2020-06-29 23:10:43', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(1389, 1, 15, '2020-06-29 23:11:48', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(1390, 1, 15, '2020-06-29 23:12:48', 'INGRESO', 'A REGISTRAR ASIGNATURA APROBADAS'),
(1391, 1, 4, '2020-06-30 22:26:29', 'Ingreso', 'A Gestion de Usuarios'),
(1392, 1, 7, '2020-06-30 22:27:16', 'Ingreso', 'A Gestion de Parametros'),
(1393, 1, 7, '2020-07-01 16:26:22', 'Ingreso', 'A Gestion de Parametros'),
(1394, 1, 14, '2020-07-01 22:59:55', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1395, 1, 14, '2020-07-01 23:49:21', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1396, 1, 14, '2020-07-01 23:49:46', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1397, 1, 14, '2020-07-03 15:46:13', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1398, 1, 14, '2020-07-03 16:17:09', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1399, 1, 14, '2020-07-03 16:17:29', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1400, 1, 14, '2020-07-03 16:17:55', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1401, 1, 14, '2020-07-03 16:26:02', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1402, 1, 14, '2020-07-03 16:26:25', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1403, 1, 14, '2020-07-03 16:28:30', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1404, 1, 14, '2020-07-03 16:29:04', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1405, 1, 14, '2020-07-03 16:30:42', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1406, 1, 14, '2020-07-03 16:31:06', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1407, 1, 14, '2020-07-03 16:31:28', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1408, 1, 14, '2020-07-03 16:32:22', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1409, 1, 14, '2020-07-03 16:32:45', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1410, 1, 23, '2020-07-03 16:40:17', 'INGRESO', 'A GESTION DE EGRESADOS'),
(1411, 1, 14, '2020-07-03 16:58:12', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1412, 1, 14, '2020-07-03 18:26:35', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1413, 1, 14, '2020-07-03 18:27:00', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1414, 1, 14, '2020-07-03 18:27:20', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1415, 1, 14, '2020-07-03 18:29:46', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1416, 1, 14, '2020-07-03 18:30:01', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1417, 1, 14, '2020-07-03 18:31:55', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1418, 1, 14, '2020-07-03 18:32:35', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1419, 1, 14, '2020-07-03 18:33:07', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1420, 1, 14, '2020-07-03 18:35:05', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1421, 1, 14, '2020-07-03 18:36:06', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1422, 1, 14, '2020-07-03 18:36:29', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1423, 1, 14, '2020-07-03 18:37:22', 'INGRESO', 'A ASISTENCIA CHARLA.'),
(1424, 1, 13, '2020-07-17 20:22:00', 'INGRESO', 'A INSCRIPCION CHARLA.'),
(1425, 1, 7, '2020-07-26 22:36:55', 'Ingreso', 'A Gestion de Parametros'),
(1426, 1, 20, '2020-07-27 10:44:56', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1427, 1, 20, '2020-07-27 10:45:13', 'INGRESO', 'A REVISION DE DOCUMENTACION PRACTICA '),
(1428, 1, 9, '2020-07-30 16:46:29', 'Ingreso', 'A Permisos a roles y pantallas'),
(1429, 1, 9, '2020-07-30 16:54:52', 'Ingreso', 'A Permisos a roles y pantallas'),
(1430, 1, 8, '2020-07-30 16:56:03', 'INSERTO', 'EL PERMISO cambio de carrera'),
(1431, 1, 8, '2020-07-30 16:56:06', 'INSERTO', 'EL PERMISO carta de egresado'),
(1432, 1, 8, '2020-07-30 16:56:09', 'INSERTO', 'EL PERMISO equivalencias'),
(1433, 1, 8, '2020-07-30 16:56:12', 'INSERTO', 'EL PERMISO cancelacion de clases'),
(1434, 1, 8, '2020-07-30 16:56:15', 'INSERTO', 'EL PERMISO revision finalizacion practica'),
(1435, 1, 8, '2020-07-30 16:56:18', 'INSERTO', 'EL PERMISO revision cambio carrera'),
(1436, 1, 8, '2020-07-30 16:56:21', 'INSERTO', 'EL PERMISO revision carta egresado'),
(1437, 1, 8, '2020-07-30 16:56:24', 'INSERTO', 'EL PERMISO revision equivalencias'),
(1438, 1, 8, '2020-07-30 16:56:28', 'INSERTO', 'EL PERMISO revision cancelacion de clases'),
(1439, 1, 9, '2020-07-30 16:58:08', 'Ingreso', 'A Permisos a roles y pantallas'),
(1440, 1, 9, '2020-07-30 18:29:08', 'Ingreso', 'A Permisos a roles y pantallas'),
(1441, 1, 9, '2020-07-30 19:20:47', 'Ingreso', 'A Permisos a roles y pantallas'),
(1442, 1, 8, '2020-07-30 19:21:44', 'INSERTO', 'EL PERMISO Solicitud de Finalizacion de practica'),
(1443, 1, 8, '2020-07-30 19:21:47', 'INSERTO', 'EL PERMISO cambio de carrera'),
(1444, 1, 8, '2020-07-30 19:21:50', 'INSERTO', 'EL PERMISO carta de egresado'),
(1445, 1, 8, '2020-07-30 19:21:53', 'INSERTO', 'EL PERMISO equivalencias'),
(1446, 1, 8, '2020-07-30 19:21:56', 'INSERTO', 'EL PERMISO cancelacion de clases'),
(1447, 1, 8, '2020-07-30 19:21:59', 'INSERTO', 'EL PERMISO revision finalizacion practica'),
(1448, 1, 8, '2020-07-30 19:22:02', 'INSERTO', 'EL PERMISO revision cambio carrera'),
(1449, 1, 8, '2020-07-30 19:22:06', 'INSERTO', 'EL PERMISO revision carta egresado'),
(1450, 1, 8, '2020-07-30 19:22:09', 'INSERTO', 'EL PERMISO revision equivalencias'),
(1451, 1, 8, '2020-07-30 19:22:12', 'INSERTO', 'EL PERMISO revision cancelacion de clases'),
(1452, 1, 8, '2020-07-30 19:32:04', 'INSERTO', 'EL PERMISO Solicitud de Finalizacion de practica'),
(1453, 1, 8, '2020-07-30 19:32:07', 'INSERTO', 'EL PERMISO cambio de carrera'),
(1454, 1, 8, '2020-07-30 19:32:11', 'INSERTO', 'EL PERMISO carta de egresado'),
(1455, 1, 8, '2020-07-30 19:32:14', 'INSERTO', 'EL PERMISO equivalencias'),
(1456, 1, 8, '2020-07-30 19:32:17', 'INSERTO', 'EL PERMISO cancelacion de clases'),
(1457, 1, 8, '2020-07-30 19:32:20', 'INSERTO', 'EL PERMISO revision finalizacion practica'),
(1458, 1, 8, '2020-07-30 19:32:23', 'INSERTO', 'EL PERMISO revision cambio carrera'),
(1459, 1, 8, '2020-07-30 19:32:26', 'INSERTO', 'EL PERMISO revision carta egresado'),
(1460, 1, 8, '2020-07-30 19:32:29', 'INSERTO', 'EL PERMISO revision equivalencias'),
(1461, 1, 8, '2020-07-30 19:32:32', 'INSERTO', 'EL PERMISO revision cancelacion de clases'),
(1462, 1, 9, '2020-07-30 19:32:42', 'Ingreso', 'A Permisos a roles y pantallas'),
(1463, 1, 29, '2020-07-30 19:34:30', 'INGRESO', 'A SOLICITUD FINALIZACION PRACTICA'),
(1464, 1, 30, '2020-07-30 19:46:21', 'INGRESO', 'A SOLICITUD CAMBIO DE CARRERA'),
(1465, 1, 31, '2020-07-30 19:46:30', 'INGRESO', 'A SOLICITUD CARTA DE EGRESADO'),
(1466, 1, 32, '2020-07-30 19:46:39', 'INGRESO', 'A SOLICITUD DE EQUIVALENCIAS'),
(1467, 1, 33, '2020-07-30 19:46:48', 'INGRESO', 'A SOLICITUD CANCELAR CLASES'),
(1468, 1, 34, '2020-07-30 20:03:26', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1469, 1, 35, '2020-07-30 20:03:58', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1470, 1, 35, '2020-07-30 20:04:21', 'INGRESO', 'A REVISION CAMBIO DE CARRERA christel nicole neumann callejas'),
(1471, 1, 35, '2020-07-30 20:05:33', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1472, 1, 35, '2020-07-30 20:05:50', 'INGRESO', 'A REVISION CAMBIO DE CARRERA SOFIA NUÃ‘EZ'),
(1473, 1, 31, '2020-07-30 20:06:00', 'INGRESO', 'A SOLICITUD CARTA DE EGRESADO'),
(1474, 1, 36, '2020-07-30 20:06:37', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1475, 1, 36, '2020-07-30 20:06:58', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1476, 1, 36, '2020-07-30 20:09:15', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1477, 1, 36, '2020-07-30 20:10:17', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1478, 1, 37, '2020-07-30 20:12:20', 'INGRESO', 'A REVISION LISTA DE EQUIVALENCIAS'),
(1479, 1, 37, '2020-07-30 20:12:43', 'INGRESO', 'A REVISION DE EQUIVALENCIAS ALUMNO HEINZ NEUMANN'),
(1480, 1, 38, '2020-07-30 20:13:06', 'INGRESO', 'A REVISION LISTA CANCELAR CLASES'),
(1481, 1, 38, '2020-07-30 20:13:32', 'INGRESO', 'A REVISION CANCELAR CLASES ALUMNO HEINZ NEUMANN'),
(1482, 1, 38, '2020-07-30 20:14:08', 'INGRESO', 'A REVISION LISTA CANCELAR CLASES'),
(1483, 1, 35, '2020-07-30 20:14:29', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1484, 1, 36, '2020-07-30 20:16:43', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1485, 1, 36, '2020-07-30 20:17:47', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1486, 1, 36, '2020-07-30 20:27:06', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1487, 1, 36, '2020-07-30 20:27:40', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1488, 1, 36, '2020-07-30 20:27:59', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1489, 1, 36, '2020-07-30 20:28:54', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1490, 1, 36, '2020-07-30 20:29:13', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1491, 1, 36, '2020-07-30 20:29:33', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1492, 1, 36, '2020-07-30 20:33:18', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1493, 1, 36, '2020-07-30 20:33:39', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1494, 1, 36, '2020-07-30 20:34:03', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO '),
(1495, 17, 12, '2020-07-30 22:20:41', 'Ingreso', 'A Cambiar clave como usuario'),
(1496, 1, 9, '2020-07-30 22:34:32', 'Ingreso', 'A Permisos a roles y pantallas'),
(1497, 1, 34, '2020-07-30 22:38:53', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1498, 1, 34, '2020-07-30 22:38:59', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO '),
(1499, 1, 34, '2020-07-30 22:40:22', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1500, 1, 30, '2020-07-30 22:43:18', 'INGRESO', 'A SOLICITUD CAMBIO DE CARRERA'),
(1501, 1, 35, '2020-07-30 22:44:05', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1502, 1, 35, '2020-07-30 22:44:45', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1503, 1, 35, '2020-07-30 22:44:56', 'INGRESO', 'A REVISION CAMBIO DE CARRERA '),
(1504, 1, 35, '2020-07-30 22:44:58', 'INGRESO', 'A REVISION CAMBIO DE CARRERA '),
(1505, 1, 35, '2020-07-30 22:45:15', 'INGRESO', 'A REVISION CAMBIO DE CARRERA helmer calix'),
(1506, 1, 35, '2020-07-30 22:45:36', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1507, 1, 35, '2020-07-30 22:48:17', 'INGRESO', 'A REVISION CAMBIO DE CARRERA helmer calix'),
(1508, 1, 35, '2020-07-30 22:48:29', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1509, 1, 32, '2020-07-30 22:48:45', 'INGRESO', 'A SOLICITUD DE EQUIVALENCIAS'),
(1510, 1, 33, '2020-07-30 22:49:11', 'INGRESO', 'A SOLICITUD CANCELAR CLASES'),
(1511, 1, 34, '2020-07-30 22:53:27', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1512, 1, 34, '2020-07-30 22:53:30', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1513, 1, 29, '2020-07-30 22:57:59', 'INGRESO', 'A SOLICITUD FINALIZACION PRACTICA'),
(1514, 1, 34, '2020-07-30 22:58:41', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1515, 1, 34, '2020-07-30 22:58:47', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1516, 1, 34, '2020-07-30 22:59:22', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1517, 1, 38, '2020-07-30 23:09:39', 'INGRESO', 'A REVISION LISTA CANCELAR CLASES'),
(1518, 1, 34, '2020-07-30 23:10:14', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1519, 1, 34, '2020-07-30 23:10:18', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1520, 1, 34, '2020-07-30 23:10:28', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1521, 1, 34, '2020-07-30 23:11:00', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1522, 1, 34, '2020-07-30 23:16:17', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1523, 1, 34, '2020-07-30 23:16:32', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1524, 1, 34, '2020-07-30 23:23:57', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1525, 1, 34, '2020-07-30 23:26:09', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1526, 1, 29, '2020-07-30 23:28:40', 'INGRESO', 'A SOLICITUD FINALIZACION PRACTICA'),
(1527, 1, 34, '2020-07-30 23:29:31', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1528, 1, 34, '2020-07-30 23:29:34', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1529, 1, 34, '2020-07-30 23:29:47', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1530, 1, 36, '2020-07-30 23:38:16', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1531, 1, 36, '2020-07-30 23:41:21', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1532, 1, 36, '2020-07-30 23:41:38', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1533, 1, 34, '2020-07-30 23:45:27', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1534, 1, 34, '2020-07-30 23:45:35', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1535, 1, 34, '2020-07-30 23:45:47', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1536, 1, 36, '2020-07-30 23:46:14', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1537, 1, 31, '2020-07-30 23:46:28', 'INGRESO', 'A SOLICITUD CARTA DE EGRESADO'),
(1538, 1, 36, '2020-07-30 23:46:51', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1539, 1, 36, '2020-07-30 23:46:58', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1540, 1, 36, '2020-07-30 23:47:45', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1541, 1, 31, '2020-07-30 23:48:06', 'INGRESO', 'A SOLICITUD CARTA DE EGRESADO'),
(1542, 1, 36, '2020-07-30 23:48:19', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1543, 1, 36, '2020-07-30 23:49:39', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1544, 1, 36, '2020-07-30 23:49:56', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO helmer calix'),
(1545, 1, 35, '2020-07-30 23:50:16', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1546, 1, 37, '2020-07-30 23:50:20', 'INGRESO', 'A REVISION LISTA DE EQUIVALENCIAS'),
(1547, 1, 36, '2020-07-30 23:50:28', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1548, 1, 34, '2020-07-30 23:50:31', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1549, 1, 36, '2020-07-30 23:52:02', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1550, 1, 36, '2020-07-30 23:52:11', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO helmer calix'),
(1551, 1, 36, '2020-07-30 23:52:24', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1552, 1, 37, '2020-07-30 23:55:26', 'INGRESO', 'A REVISION LISTA DE EQUIVALENCIAS'),
(1553, 1, 37, '2020-07-30 23:56:06', 'INGRESO', 'A REVISION LISTA DE EQUIVALENCIAS'),
(1554, 1, 37, '2020-07-31 00:00:14', 'INGRESO', 'A REVISION LISTA DE EQUIVALENCIAS'),
(1555, 1, 37, '2020-07-31 00:00:35', 'INGRESO', 'A REVISION DE EQUIVALENCIAS ALUMNO '),
(1556, 1, 37, '2020-07-31 00:01:07', 'INGRESO', 'A REVISION DE EQUIVALENCIAS ALUMNO helmer calix'),
(1557, 1, 37, '2020-07-31 00:01:27', 'INGRESO', 'A REVISION LISTA DE EQUIVALENCIAS'),
(1558, 1, 38, '2020-07-31 00:02:03', 'INGRESO', 'A REVISION LISTA CANCELAR CLASES'),
(1559, 1, 38, '2020-07-31 00:02:38', 'INGRESO', 'A REVISION LISTA CANCELAR CLASES'),
(1560, 1, 38, '2020-07-31 00:03:10', 'INGRESO', 'A REVISION CANCELAR CLASES ALUMNO helmer calix'),
(1561, 1, 38, '2020-07-31 00:06:55', 'INGRESO', 'A REVISION LISTA CANCELAR CLASES'),
(1562, 1, 34, '2020-07-31 00:10:53', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1563, 1, 34, '2020-07-31 00:14:07', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1564, 1, 35, '2020-07-31 00:14:30', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1565, 1, 35, '2020-07-31 00:14:45', 'INGRESO', 'A REVISION CAMBIO DE CARRERA helmer calix'),
(1566, 1, 36, '2020-07-31 00:15:07', 'INGRESO', 'A REVISION LISTA CARTA DE EGRESADO'),
(1567, 1, 36, '2020-07-31 00:15:20', 'INGRESO', 'A REVISION CARTA DE EGRESADO ALUMNO helmer calix'),
(1568, 1, 37, '2020-07-31 00:15:39', 'INGRESO', 'A REVISION LISTA DE EQUIVALENCIAS'),
(1569, 1, 37, '2020-07-31 00:15:55', 'INGRESO', 'A REVISION DE EQUIVALENCIAS ALUMNO helmer calix'),
(1570, 1, 38, '2020-07-31 00:16:16', 'INGRESO', 'A REVISION LISTA CANCELAR CLASES'),
(1571, 1, 38, '2020-07-31 00:16:34', 'INGRESO', 'A REVISION CANCELAR CLASES ALUMNO helmer calix'),
(1572, 1, 29, '2020-07-31 09:49:51', 'INGRESO', 'A SOLICITUD FINALIZACION PRACTICA'),
(1573, 1, 34, '2020-07-31 09:50:30', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1574, 1, 34, '2020-07-31 09:50:33', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1575, 1, 35, '2020-07-31 09:50:52', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1576, 1, 35, '2020-07-31 09:50:55', 'INGRESO', 'A REVISION CAMBIO DE CARRERA helmer calix'),
(1577, 1, 35, '2020-07-31 09:51:05', 'INGRESO', 'A REVISION LISTA CAMBIO DE CARRERA'),
(1578, 1, 34, '2020-07-31 09:51:08', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA'),
(1579, 1, 34, '2020-07-31 09:51:17', 'INGRESO', 'A REVISION DE FINALIZACION DE PRACTICA ALUMNO helmer calix'),
(1580, 1, 34, '2020-07-31 09:51:28', 'INGRESO', 'A REVISION LISTA DE FINALIZACION PRACTICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cambio_carrera`
--

CREATE TABLE `tbl_cambio_carrera` (
  `Id_cambio` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `razon_cambio` varchar(255) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `aprobado` varchar(255) NOT NULL,
  `Id_centro_regional` bigint(16) DEFAULT NULL,
  `fecha_creacion` varchar(30) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `id_facultad` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_cambio_carrera`
--

INSERT INTO `tbl_cambio_carrera` (`Id_cambio`, `Id_usuario`, `razon_cambio`, `observacion`, `aprobado`, `Id_centro_regional`, `fecha_creacion`, `documento`, `id_facultad`) VALUES
(21, 14, 'dale', 'nada', 'desaprobado', 1, '2020-07-23 11:40:25', '../archivos/les01_Rev2.pdf', 1),
(22, 1, 'nothing', 'nothing ', 'aprobado', 1, '2020-07-30 20:05:20', '../archivos/oracleSQL.pdf', 1),
(23, 17, 'nose', 'nose ', 'desaprobar', 1, '2020-07-31 09:51:04', '../archivos/141484658-Fiebre-en-Las-Gradas.pdf', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cancelar_clases`
--

CREATE TABLE `tbl_cancelar_clases` (
  `Id_cancelar_clases` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `Fecha_creacion` varchar(255) NOT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `cambio` varchar(255) DEFAULT NULL,
  `observacion` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_cancelar_clases`
--

INSERT INTO `tbl_cancelar_clases` (`Id_cancelar_clases`, `Id_usuario`, `motivo`, `Fecha_creacion`, `documento`, `cambio`, `observacion`) VALUES
(17, 14, 'ninguna', '2020-07-24 10:13:11', '../archivos/les01_Rev2.pdf', 'desaprobar', 'ninguna'),
(18, 15, 'hdtgfh', '2020-07-30 19:59:30', '../archivos/4P-RP-RE-02 PROCESO SOLICITUD DE CERTIFICACION DE ESTUDIOS PREG VR.pdf', 'desaprobado', NULL),
(19, 2, 'fhgfhg', '2020-07-30 20:13:53', '../archivos/8P-RP-CC-06 PROCESO SOLICITUD DE CONSTANCIA DE EGRESADO VF.pdf', 'aprobado', ' nnn'),
(20, 17, 'nose', '2020-07-30 22:49:35', '../archivos/Docs para Carta de Egresado_1.pdf', 'desaprobado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_capacidades_practica`
--

CREATE TABLE `tbl_capacidades_practica` (
  `Id_capacidad` bigint(16) NOT NULL,
  `Id_evalua_capacidad` bigint(16) NOT NULL,
  `capacidad` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `Id_usuario` bigint(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carreras`
--

CREATE TABLE `tbl_carreras` (
  `Id_carrera` bigint(16) NOT NULL,
  `Id_departamento` bigint(16) NOT NULL,
  `carrera` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_carreras`
--

INSERT INTO `tbl_carreras` (`Id_carrera`, `Id_departamento`, `carrera`, `Fecha_creacion`) VALUES
(1, 1, 'Informatica Adminstrativa', '2020-05-31 00:00:00'),
(2, 1, 'Admin. de Empresas', '2020-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carta_egresado`
--

CREATE TABLE `tbl_carta_egresado` (
  `Id_carta` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `aprobado` varchar(255) DEFAULT NULL,
  `documento` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_carta_egresado`
--

INSERT INTO `tbl_carta_egresado` (`Id_carta`, `Id_usuario`, `observacion`, `Fecha_creacion`, `aprobado`, `documento`) VALUES
(14, 14, '', '2020-07-23 15:38:38', 'desaprobado', '../archivos/Les13.pdf'),
(15, 1, '', '2020-07-14 13:38:46', 'desaprobado', '../archivos/oracleSQL.pdf'),
(16, 17, '', '2020-07-30 23:52:22', 'desaprobar', '../archivos/Abrir acceso por red a Xampp.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_centros_regionales`
--

CREATE TABLE `tbl_centros_regionales` (
  `Id_centro_regional` bigint(16) NOT NULL,
  `centro_regional` varchar(255) NOT NULL,
  `acronimo` varchar(255) NOT NULL,
  `Fecha_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_centros_regionales`
--

INSERT INTO `tbl_centros_regionales` (`Id_centro_regional`, `centro_regional`, `acronimo`, `Fecha_creacion`) VALUES
(1, 'Ciudad Universitaria', 'CU', '2020-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_charla_practica`
--

CREATE TABLE `tbl_charla_practica` (
  `Id_charla` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
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

INSERT INTO `tbl_charla_practica` (`Id_charla`, `Id_usuario`, `no_constancia`, `promedio_global`, `fecha_recibida`, `fecha_valida`, `clases_aprobadas`, `porcentaje_clases`, `jornada`, `estado_asistencia_charla`, `charla_impartida`) VALUES
(16, 1, 202006002, '6', '2020-06-25', '2020-09-23', '6', 11.5385, 'MATUTINA', 1, 1),
(19, 2, 202006072, '80', '2020-06-14', '2020-09-12', '52', 100, 'VESPERTINA', 1, 1),
(20, 11, 202006073, '95', '2020-06-25', '2020-09-23', '52', 100, 'VESPERTINA', 1, 1),
(21, 13, 202006051, '80', '2020-06-25', '2020-09-23', '45', 86.5385, 'MATUTINA', 1, 1);

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
(1, 51, 0, 'MATUTINA'),
(2, 73, 0, 'VESPERTINA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_docentes`
--

CREATE TABLE `tbl_docentes` (
  `Id_docente` bigint(16) NOT NULL,
  `nombre_docente` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `numero_empleado` bigint(16) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(6, 'CHRISTEL NEUMANN', 20141011506, 'PRUEBA@PRUEBA.COM', ' 8898-5501', '', '2020', 'NO', 'PRUEBA MAESTRIA', 'SI', 'CNNA', 'SI', 'N/A', 'N/A', '', 'N/A', '', '2020-05-31 17:21:08'),
(7, 'HYHY', 5665645, 'PRUEBASSS@PPAA.COM', ' 5665-6565', ' 5656-5656', '2019', 'SI', 'K', 'SI', 'CNNA', 'NO', 'CXX', '', '', 'DSD', '', '2020-06-01 00:12:37'),
(8, 'MARIA CALLEJAS', 20141011539, 'MARIA@YAHOO.COM', ' 8951-6364', ' 2569-8114', '2020', 'SI', 'SEGURIDAD', 'SI', 'CNNA', 'SI', 'TIGO', 'LA SOSA', ' 2236-8956', 'SISTEMAS', 'TIGO@YAHOO.COM', '2020-06-25 14:37:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empresas_practica`
--

CREATE TABLE `tbl_empresas_practica` (
  `Id_empresa` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `direccion_empresa` varchar(255) NOT NULL,
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

INSERT INTO `tbl_empresas_practica` (`Id_empresa`, `Id_usuario`, `nombre_empresa`, `direccion_empresa`, `departamento_empresa`, `jefe_inmediato`, `titulo_jefe_inmediato`, `cargo_jefe_inmediato`, `correo_jefe_inmediato`, `telefono_jefe_inmediato`, `Fecha_creacion`) VALUES
(1, 1, 'UNAH CURLA', 'LAS BRISAS', 'SISTEMAS', 'HEINZ NEUMANN', 'MASTER', 'GERENTe', 'HEINZ@DFFFFFF.COM', ' 5555-6666', '2020-06-11 23:35:09'),
(2, 11, 'TIGO', 'ALAMEDA', 'SISTEMAS', 'ALEX SEVILLA', 'LICENCIADO', 'JEFE DE DEPTO', 'ALEX@YAHOO.COM', ' 7987-9879', '2020-06-24 23:56:42'),
(3, 17, 'UNAH', '', '', 'nose', '', '', '', '', '0000-00-00 00:00:00');

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
  `Id_usuario` bigint(16) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `aprobado` varchar(255) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_equivalencias`
--

INSERT INTO `tbl_equivalencias` (`Id_equivalencia`, `Id_usuario`, `observacion`, `Fecha_creacion`, `aprobado`, `documento`) VALUES
(6, 14, '', '2020-07-23 16:24:10', 'desaprobado', '../archivos/oracleSQL.pdf'),
(7, 2, '', '2020-07-30 20:02:53', 'desaprobado', '../archivos/10P-RP-VO-03 PROCESO SOLICITUD DE MENCION HONORIFICA PREGRADO VP.pdf'),
(8, 17, '', '2020-07-31 00:01:25', 'desaprobar', '../archivos/Abrir acceso por red a Xampp.pdf');

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
(1, 'rr', 'rr', 0, 'r', 0, 'r', 1),
(2, 'sad', 'asdf', 32, 'dasd', 233, 'ded', 1),
(3, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(4, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(5, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(6, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(7, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(8, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(9, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(10, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(11, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(12, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(13, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(14, 'h', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(15, 'p', NULL, NULL, NULL, 9879836, 'lajhsnashad', 1),
(16, 'p', NULL, NULL, NULL, 0, 'lk', 1),
(17, 'k', NULL, NULL, NULL, 898, 'jnjnf', 1),
(18, NULL, NULL, NULL, NULL, 0, 'okkjj', 1),
(19, 'j', NULL, NULL, NULL, 29, 'jn ', 1),
(20, 'j', NULL, NULL, NULL, 29, 'jn ', 1),
(21, 'p', NULL, NULL, NULL, 22, 'nlksnd', 1),
(22, 'pkpkpk', NULL, NULL, NULL, 223, 'kpdk', 1),
(23, 'jhjv', NULL, NULL, NULL, 654, 'jhgg', 1),
(24, 'lknsc', NULL, NULL, NULL, 87987, 'kjnnljn', 1),
(25, 'kjg', NULL, NULL, NULL, 7567, 'kjn', 1),
(26, 'iygfgfd', NULL, NULL, NULL, 5656, 'dfgvb', 1),
(27, 'prueba', 'presidente', 89059328, 'luiseos@yahoo.es', 2020, 'colonia las brisas', 1),
(28, 'prueba1', 'kj', 986, 'kjh@yahoo.es', 1192929, 'prueba', 1),
(29, 'prueba2', 'kjhk', 876, 'kjh@yahoo.es', 76, 'jb', 1),
(30, 'prueba3', 'jkj', 76787, 'prueba@yahoo.es', 7687, 'bjkb', 1),
(31, 'lknlkj', 'kjjlkj', 9890808, 'prueba@prueba.com', 98987, 'jlkjlkj', 1),
(32, 'kjj', 'jbjk', 76687687, 'kjh86876@yahoo.es', 767, '87jbjb', 25),
(33, 'kjhkh', 'jgjgg', 87678678, 'gjgjg@gjg.com', 86876, 'hkhh', 25),
(34, 'sin ', 'kjhkjh', 9898908, 'kjhkh@uajn.com', 9877897, 'jhjkjhj', 25),
(35, 'k', 'kjhjkh', 7897, 'jkh@ygag.com', 879878, 'hkh', 37),
(36, 'knsn', 'mnmnnmn', 67678678, 'p@grupo.com', 7878789, 'nbnb', 38),
(37, 'pojhh', 'jkhjkh', 9888789, 'kd@psc.com', 77678, 'jhkhk', 39),
(38, 'hkjhj', 'kjhj', 76764545, 'jjkd@ks.com', 897, 'jjkb', 39),
(39, 'luise ', 'kjkhh', 77656756, 'hjgd@hgs.com', 766678, 'kockn', 39),
(40, 'cece', 'gfgfg', 4545, 'christel_ordonez29@yahoo.com', 445, 'sg', 1),
(41, 'sese', 'gffg', 455, 'christel_ordonez29@yahoo.com', 4545, 'sdgf', 40),
(42, 'NOEMI VARELA', 'DBA', 89520361, 'NOEMI@YAHOO.COM', 20151005561, 'LA SOSA', 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_evaluaciones_capacidad`
--

CREATE TABLE `tbl_evaluaciones_capacidad` (
  `Id_evalua_capacidad` bigint(16) NOT NULL,
  `bueno` varchar(255) NOT NULL,
  `regular` varchar(255) NOT NULL,
  `satisfactorio` varchar(255) NOT NULL,
  `mejorar` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL,
  `Id_usuario` bigint(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_facultades`
--

CREATE TABLE `tbl_facultades` (
  `Id_facultad` bigint(16) NOT NULL,
  `Id_carrera` bigint(16) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_facultades`
--

INSERT INTO `tbl_facultades` (`Id_facultad`, `Id_carrera`, `nombre`, `Fecha_creacion`) VALUES
(1, 1, 'Ciencias Economicas', '2020-05-31 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_finalizacion_practica`
--

CREATE TABLE `tbl_finalizacion_practica` (
  `Id_finalizacion` bigint(16) NOT NULL,
  `id_practica` bigint(16) NOT NULL,
  `id_usuario` bigint(16) NOT NULL,
  `observacion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `aprobado` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `documento` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tbl_finalizacion_practica`
--

INSERT INTO `tbl_finalizacion_practica` (`Id_finalizacion`, `id_practica`, `id_usuario`, `observacion`, `aprobado`, `fecha_creacion`, `documento`) VALUES
(80, 1, 17, '', 'desaprobar', '2020-07-31 09:51:27', ' ../archivos/141484658-Fiebre-en-Las-Gradas.pdf'),
(81, 1, 17, '', 'desaprobar', '2020-07-31 09:51:27', ' ../archivos/Docs para Carta de Egresado_1.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_funciones_practica`
--

CREATE TABLE `tbl_funciones_practica` (
  `Id_funcion` bigint(16) NOT NULL,
  `funcion` varchar(255) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `Fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Crear preguntas', 'Creacion de preguntas de seguridad'),
(2, 'Gestion de preguntas', 'Gestionar las preguntas de seguridad'),
(3, 'Registrar Usuario', 'Registrar los usuarios del sistema'),
(4, 'Gestion de usuario', 'Gestionar los usuarios'),
(5, 'Crear Roles', 'creacion de roles'),
(6, 'Gestion de roles', 'Gestionar los roles'),
(7, 'Gestion de Parametros', 'Gestionar los parametros'),
(8, 'Bitacora', 'Bitacora del sistema'),
(9, 'Crear Permisos a usuarios', 'Dar permisos a los roles de los usuarios'),
(10, 'Gestion de permisos a usuarios', 'Gestionar permisos a usuarios'),
(11, 'Gestion de respuestas de preguntas de seguridad', 'Gestionar las respuestas de preguntas de seguridad'),
(12, 'Cambiar contraseña\r\n', 'Cambiar contraseña dentro del sistema'),
(13, 'Inscripcion para charla practica', 'Inscripcion de los estudiantes para charla de pps'),
(14, 'Gestion de asistencia a charla', 'Gestion de asistencia a charla de PPS'),
(15, 'Registro de clases aprobadas', 'Registro de clases aprobadas para constancia'),
(16, 'Gestion de clases aprobadas', 'Gestion de clases aprobadas'),
(17, 'Registro de datos de empresa', 'Registro de datos de empresa por PPS'),
(18, 'Historial de constancias y/o cartas', 'Historial de constancias y/o cartas'),
(19, 'Entrega de documentacion', 'Documentacion de PPS'),
(20, 'Recencion/supervision de documentos', 'Recepcion/supervision de documentos de PPS'),
(21, 'Aprobacion/rechazo de PPS', 'Aprobacion/rechazo de PPS'),
(22, 'Registro de egresados', 'Registro de egresados de IA'),
(23, 'Gestion de egresados', 'Gestion de egresados de IA'),
(24, 'Registro de proyectos', 'Registro de proyectos vinculacion universidad sociedad'),
(25, 'Gestion de Proyectos', 'Gestion de proyectos vinculacion universidad sociedad'),
(26, 'Supervisar documentacion de PPS', 'Comite de vinculacion supervisa documentacion de PPS'),
(27, 'Historial de practicas aprobadas', 'Historial de practicas aprobadas'),
(28, 'Historial de practicas rechazadas', 'Historial de practicas rechazadas'),
(29, 'Solicitud de Finalizacion de practica', 'Solicitud de Finalizacion de practica alumno'),
(30, 'cambio de carrera', 'solicitud cambio de carrera alumno'),
(31, 'carta de egresado', 'solicitud carta de egresado'),
(32, 'equivalencias', 'Solicitud de equivalencias'),
(33, 'cancelacion de clases', 'solicitud de cancelacion de clases'),
(34, 'revision finalizacion practica', 'coordinador revision finalizacion practica'),
(35, 'revision cambio carrera', 'coordinador revision cambio carrera'),
(36, 'revision carta egresado', 'coordinador revision carta egresado'),
(37, 'revision equivalencias', 'coordinador revision equivalencias'),
(38, 'revision cancelacion de clases', 'coordinador revision cancelacion de clases');

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
(1, 1, 'INTENTOS', 'INTENTOS SESIONES', '3', 'ADMIN', '2020-05-11 00:00:00'),
(2, 1, 'Tamano_min_clave', 'TAMANO MINIMO DE LA CLAVE', '8', 'ADMIN', '2020-05-11 00:00:00'),
(4, 1, 'Cantidad_preguntas', 'PREGUNTAS INGRESADAS', '3', 'ADMIN', '2020-05-11 00:00:00'),
(5, 1, 'Tamano_max_clave', 'TAMANO MAXIMO DE CLAVE', '10', 'ADMIN', '2020-05-11 00:00:00'),
(6, 1, 'Tamano_clave_correo', 'TAMANO POR EL CORREO', '8', 'ADMIN', '2020-05-11 00:00:00'),
(7, 1, 'CAMBIO_CLAVE', 'TIEMPO PARA CAMBIAR CLAVE', '30', 'ADMIN', '2020-05-11 00:00:00'),
(8, 1, 'correo_institucional', 'CORREO DE LA EMPRESA', 'christel.ordonez29@gmail.com', ' ADMIN', '2020-05-23 23:53:27'),
(9, 1, 'clave_correo', 'CLAVE DEL CORREO', 'woaini290612', ' ADMIN', '2020-05-23 23:54:16'),
(10, 1, 'Puerto', 'PUERTO DEL GMAIL', '465', 'admin', '2020-05-12 00:00:00'),
(11, 1, 'HOST_SMTP', 'HOST DEL SERVIDOR', 'smtp.gmail.com', 'admin', '2020-05-11 00:00:00'),
(12, 1, 'Admin_correo', 'PERSONA QUE ADMINISTRA EL CORREO', 'Comite de Automatizacion ', ' ADMIN', '2020-05-24 18:22:53'),
(13, 1, 'AUTO_REGISTRO', 'AUTO REGISTRO USUARIO', '1', 'admin', '2020-05-11 00:00:00'),
(16, 1, 'DOCENTE_VINCULACION_MATUTINA_1', 'DOCENTE ENCARGADO DE CHARLA', 'MSC. SANDRA QUAN ', 'ADMIN', '2020-06-04 17:49:38'),
(17, 1, 'DOCENTE_VINCULACION_MATUTINA_2', 'DOCENTE ENCARGADO DE CHARLA', 'MSC. ANGELICA MUÑOZ', 'ADMIN', '2020-06-04 17:49:38'),
(18, 1, 'DOCENTE_VINCULACION_VESPERTINA_1', 'DOCENTE ENCARGADO DE CHARLA', 'MSC. CAROLD RITHENHOUSE', 'ADMIN', '2020-06-04 00:00:00'),
(20, 1, 'DOCENTE_VINCULACION_VESPERTINA_2', 'DOCENTE ENCARGADO DE CHARLA', 'LIC. JULIAN ', 'ADMIN', '2020-06-04 00:00:00'),
(21, 1, 'DIAS_CHARLA', 'VALIDACION EN DIAS , PARA FECHA VALIDAS PARA CHARLA ', '90', 'ADMIN', '2020-06-04 00:00:00'),
(22, 1, 'CANTIDAD_DOCUMENTOS', 'MÁXIMA CANTIDAD DE DOCUMENTOS DEL PRACTICANTE.', '9', 'ADMIN', '2020-06-04 00:00:00');

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
(1, 46, 1, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(2, 46, 2, '1', '1', '1', '1', NULL, NULL, 'admin', '2020-05-22 20:45:26'),
(4, 46, 8, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(5, 46, 3, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(6, 46, 4, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(7, 46, 5, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(8, 46, 6, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(9, 46, 7, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(10, 46, 9, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(11, 46, 10, '1', '1', '1', '0', NULL, NULL, NULL, NULL),
(12, 46, 11, '1', '1', '1', '1', NULL, NULL, NULL, NULL),
(14, 46, 12, '1', '1', '1', '1', '2020-05-22 22:32:56', ' admin ', NULL, NULL),
(18, 48, 2, '1', '0', '0', '0', '2020-05-22 23:30:55', ' admin ', NULL, NULL),
(19, 48, 1, '1', '0', '0', '0', '2020-05-22 23:32:35', ' admin ', NULL, NULL),
(21, 48, 3, '1', '0', '0', '0', '2020-05-22 23:34:07', ' admin ', NULL, NULL),
(25, 48, 4, '1', '0', '1', '0', '2020-05-22 23:41:09', ' admin ', NULL, NULL),
(26, 48, 5, '1', '0', '1', '0', '2020-05-22 23:41:12', ' admin ', NULL, NULL),
(33, 47, 1, '0', '0', '0', '1', '2020-05-22 23:54:11', ' admin ', 'ADMIN', '2020-05-24 18:21:53'),
(34, 47, 2, '0', '0', '0', '0', '2020-05-22 23:54:14', ' admin ', NULL, NULL),
(35, 47, 4, '0', '0', '0', '0', '2020-05-22 23:57:10', ' admin ', NULL, NULL),
(36, 47, 5, '0', '0', '0', '0', '2020-05-22 23:57:12', ' admin ', NULL, NULL),
(37, 47, 6, '0', '0', '0', '0', '2020-05-22 23:59:06', ' admin ', NULL, NULL),
(38, 47, 9, '0', '0', '0', '1', '2020-05-24 18:17:12', ' ADMIN ', NULL, NULL),
(39, 47, 10, '0', '0', '0', '1', '2020-05-24 18:17:14', ' ADMIN ', NULL, NULL),
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
(55, 49, 17, '1', '0', '0', '1', '2020-06-24 23:41:51', ' ADMIN ', NULL, NULL),
(56, 49, 19, '1', '0', '0', '1', '2020-06-24 23:41:54', ' ADMIN ', NULL, NULL),
(57, 46, 27, '1', '1', '1', '1', '2020-06-24 23:44:09', ' ADMIN ', NULL, NULL),
(58, 46, 28, '1', '1', '1', '1', '2020-06-24 23:44:12', ' ADMIN ', NULL, NULL),
(59, 46, 29, '1', '1', '0', '1', '2020-07-30 19:32:01', ' ADMIN ', NULL, NULL),
(60, 46, 30, '1', '1', '0', '1', '2020-07-30 19:32:04', ' ADMIN ', NULL, NULL),
(61, 46, 31, '1', '1', '0', '1', '2020-07-30 19:32:07', ' ADMIN ', NULL, NULL),
(62, 46, 32, '1', '1', '0', '1', '2020-07-30 19:32:11', ' ADMIN ', NULL, NULL),
(63, 46, 33, '1', '1', '0', '1', '2020-07-30 19:32:14', ' ADMIN ', NULL, NULL),
(64, 46, 34, '1', '1', '0', '1', '2020-07-30 19:32:17', ' ADMIN ', NULL, NULL),
(65, 46, 35, '1', '1', '0', '1', '2020-07-30 19:32:20', ' ADMIN ', NULL, NULL),
(66, 46, 36, '1', '1', '0', '1', '2020-07-30 19:32:23', ' ADMIN ', NULL, NULL),
(67, 46, 37, '1', '1', '0', '1', '2020-07-30 19:32:26', ' ADMIN ', NULL, NULL),
(68, 46, 38, '1', '1', '0', '1', '2020-07-30 19:32:29', ' ADMIN ', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_practica_estudiantes`
--

CREATE TABLE `tbl_practica_estudiantes` (
  `Id_practica` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `Id_docente` bigint(16) NOT NULL,
  `Id_puesto` bigint(16) NOT NULL,
  `Id_empresa` bigint(255) NOT NULL,
  `fecha_inicio` varchar(255) NOT NULL,
  `fecha_finaliza` varchar(255) NOT NULL,
  `horas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_practica_estudiantes`
--

INSERT INTO `tbl_practica_estudiantes` (`Id_practica`, `Id_usuario`, `Id_docente`, `Id_puesto`, `Id_empresa`, `fecha_inicio`, `fecha_finaliza`, `horas`) VALUES
(1, 17, 1, 1, 1, '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_practica_rechazo`
--

CREATE TABLE `tbl_practica_rechazo` (
  `id_practica_rechazo` bigint(20) NOT NULL,
  `Id_usuario` bigint(20) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL,
  `motivo` text NOT NULL,
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_practica_rechazo`
--

INSERT INTO `tbl_practica_rechazo` (`id_practica_rechazo`, `Id_usuario`, `nombre_empresa`, `motivo`, `fecha_creacion`) VALUES
(1, 1, '	UNAH CURLA', ' LO SENTIMOS NO CUMPLE CON LOS REQUISITOS', '2020-06-24 23:37:48'),
(2, 11, '	UNAH CURLA', ' HGBKGB HHGBJGHBJ BHJHHHHH HJJHGJGJG JGJHG JHGHJG', '2020-06-25 00:23:57'),
(3, 1, '	UNAH CURLA', ' VJHV VJHVGHJVH GHGHFHGF FHFHFHF HGFHGF', '2020-06-25 00:25:36'),
(4, 11, '	UNAH CURLA', ' MNSA CSA SBNS NB SBN SCBN CASBNCS', '2020-06-25 00:27:22'),
(5, 11, '	UNAH CURLA', ' PRUEBA DE RECHAZO PRACTICA', '2020-06-25 14:41:58'),
(6, 11, '	UNAH CURLA', ' NO EXISTE EL PERFIL CORRECTO', '2020-06-25 15:19:32');

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
(13, 'PRUEBA PREGUNTA ', 1, '2020-05-13 17:08:09', 'admin', NULL, NULL),
(43, 'PRUEBA DE MSJ', 1, '2020-05-17 21:18:55', 'admin', NULL, NULL),
(52, 'PRUEBAS', 1, '2020-05-24 00:00:00', 'admin', 'ADMIN', '2020-05-24 18:04:18'),
(53, 'PRUEBA', 1, '2020-06-03 21:59:53', 'ADMIN', NULL, NULL),
(54, 'D', 0, '2020-06-03 22:01:58', 'ADMIN', NULL, NULL),
(55, 'S', 0, '2020-06-03 22:02:59', 'ADMIN', NULL, NULL);

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
(6, 'NO', '', 13, 2),
(7, 'SI', '', 43, 1),
(9, 'SI', '', 13, 3),
(10, 'SI', '', 43, 3),
(11, 'SI', '', 52, 3),
(12, 'SI', '', 13, 11),
(13, 'SI', '', 43, 11),
(14, 'SI', '', 52, 11),
(15, 'SI', '', 13, 13),
(16, 'SI', '', 43, 13),
(17, 'SI', '', 52, 13),
(18, 'SA', '', 13, 17),
(19, 'SA', '', 43, 17),
(20, 'SA', '', 52, 17);

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
  `telefono_contacto_institucional` int(8) NOT NULL,
  `correo_contacto_institucional` varchar(255) NOT NULL,
  `cant_beneficiarios` bigint(16) NOT NULL,
  `fecha_inicio_ejecucion` datetime NOT NULL,
  `fecha_final_ejecucion` datetime NOT NULL,
  `fecha_inicio_evaluacion` datetime NOT NULL,
  `fecha_final_evaluacion` datetime NOT NULL,
  `costo` int(10) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
  `Fecha_creación` datetime NOT NULL,
  `Id_asignatura` bigint(16) NOT NULL,
  `Id_tipo_formalizacion` bigint(16) NOT NULL,
  `Id_aporte` bigint(16) NOT NULL,
  `region` varchar(255) NOT NULL,
  `departamento_pais` varchar(255) NOT NULL,
  `municipio` varchar(255) NOT NULL,
  `aldea_caserio` varchar(255) NOT NULL,
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

INSERT INTO `tbl_proyectos` (`Id_proyecto`, `Id_tipo_v`, `Id_modalidad`, `nombre`, `codigo_proyecto`, `estado`, `beneficiarios_directos`, `beneficiarios_indirectos`, `nombre_empresa`, `nombre_contacto_institucional`, `cargo_contacto_institucional`, `telefono_contacto_institucional`, `correo_contacto_institucional`, `cant_beneficiarios`, `fecha_inicio_ejecucion`, `fecha_final_ejecucion`, `fecha_inicio_evaluacion`, `fecha_final_evaluacion`, `costo`, `Id_usuario`, `Fecha_creación`, `Id_asignatura`, `Id_tipo_formalizacion`, `Id_aporte`, `region`, `departamento_pais`, `municipio`, `aldea_caserio`, `barrio_colonia`, `entidad_beneficiaria`, `objetivos_desarrollo`, `objetivos_inmediatos`, `resultados`, `actividades`, `departamento`, `tipo_proyecto`) VALUES
(1, 1, 1, 'mumu', 101, 1, 0, 0, '', '', '', 0, '', 56, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 56, 1, '2020-06-02 00:00:00', 1, 4, 1, '0', '0', '0', '0', '0', '0', '', '', '', '', '', ''),
(2, 1, 1, 'LOL', 123, 1, 2, 3, 'NYNY', 'DDD', 'DS', 5656, 'DSFSDF', 45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12, 1, '2020-06-04 18:03:22', 1, 1, 1, 'GTR', 'FRE', 'S', 'ER', 'FR', 'FFR', 'FF', 'FF', 'FF', 'FDF', 'BB', ''),
(3, 1, 1, 'ff', 5, 1, 1, 1, 'f', 's', 'd', 33, 'dd', 3, '2020-06-06 00:00:00', '2020-06-06 00:00:00', '2020-06-06 00:00:00', '2020-06-06 00:00:00', 4, 1, '2020-06-07 01:08:34', 1, 1, 1, 's', 's', 's', 's', 's', 'd', 'd', 'd', 'd', 'dd', 'd', ''),
(4, 1, 1, 'ff', 5, 1, 1, 1, 'f', 's', 'd', 33, 'dd', 3, '2020-06-06 00:00:00', '2020-06-06 00:00:00', '2020-06-06 00:00:00', '2020-06-06 00:00:00', 4, 1, '2020-06-07 01:12:09', 1, 1, 1, 's', 's', 's', 's', 's', 'd', 'd', 'd', 'd', 'dd', 'd', ''),
(5, 1, 1, 'ff', 5, 1, 1, 1, 'f', 's', 'd', 33, 'dd', 3, '2020-06-06 00:00:00', '2020-06-06 00:00:00', '2020-06-06 00:00:00', '2020-06-06 00:00:00', 4, 1, '2020-06-07 01:17:13', 1, 1, 1, 's', 's', 's', 's', 's', 'd', 'd', 'd', 'd', 'dd', 'd', ''),
(6, 1, 1, 'nombre_', 33, 2, 1, 1, 'nombre_empresa_', 'nombre_contacto_institucional_', 'cargo_contacto_institucional_', 0, 'correo_contacto_institucional_', 1, '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', 3, 3, '2020-06-07 18:37:57', 4, 1, 1, 'region_ ', ' departamento_pais_', '', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'tipo_proyecto_'),
(7, 1, 2, 'nombre_', 33, 2, 1, 1, 'nombre_empresa_', 'nombre_contacto_institucional_', 'cargo_contacto_institucional_', 0, 'correo_contacto_institucional_', 1, '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', 3, 3, '2020-06-07 18:44:57', 4, 1, 1, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'tipo_proyecto_'),
(8, 3, 2, 'YYT', 33, 2, 1, 1, 'nombre_empresa_', 'nombre_contacto_institucional_', 'cargo_contacto_institucional_', 0, 'correo_contacto_institucional_', 1, '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', 3, 3, '2020-06-07 20:02:26', 4, 1, 1, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'tipo_proyecto_'),
(9, 5, 2, 'GH', 546, 1, 1, 1, 'nombre_empresa_', 'nombre_contacto_institucional_', 'cargo_contacto_institucional_', 0, 'correo_contacto_institucional_', 1, '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', 3, 3, '2020-06-07 20:31:49', 4, 1, 1, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'HG'),
(10, 3, 2, 'GF', 45, 1, 54, 4554, '', 'nombre_contacto_institucional_', 'cargo_contacto_institucional_', 0, 'correo_contacto_institucional_', 1, '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', 3, 3, '2020-06-07 20:39:16', 4, 1, 1, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'GF'),
(11, 2, 1, 'GFD', 4554, 1, 54, 45, '', '', '', 0, 'correo_contacto_institucional_', 1, '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', 3, 3, '2020-06-07 20:43:53', 4, 1, 1, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'FG'),
(12, 2, 2, 'IIIII', 456, 1, 65, 65, '', '', '', 0, '', 65, '2020-06-17 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', '2020-06-05 00:00:00', 3, 3, '2020-06-07 20:47:07', 4, 1, 1, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'GF'),
(13, 1, 2, 'JH', 76, 1, 76, 76, '', '', '', 0, '', 767, '2020-06-07 00:00:00', '2020-06-07 00:00:00', '2020-06-07 00:00:00', '2020-06-07 00:00:00', 3, 3, '2020-06-07 20:50:45', 4, 1, 1, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'JH'),
(14, 4, 2, 'ER', 43, 1, 54, 54, '', '', '', 0, '', 453, '2020-06-16 00:00:00', '2020-06-16 00:00:00', '2020-07-04 00:00:00', '2020-07-03 00:00:00', 4554, 1, '2020-06-07 21:17:25', 4, 2, 2, 'region_ ', ' departamento_pais_', 'municipio_ ', ' aldea_caserio_ ', 'barrio_colonia_ ', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'ERRE'),
(15, 3, 2, 'SD', 43, 1, 34, 34, '', '', '', 0, '', 43, '2020-06-18 00:00:00', '2020-06-18 00:00:00', '2020-06-25 00:00:00', '2020-06-03 00:00:00', 34, 1, '2020-06-07 21:21:32', 4, 2, 2, '', 'FGFG', 'FG ', 'GFGF', 'FG', 'entidad_beneficiaria_', 'objetivos_desarrollo_', 'objetivos_inmediatos_', 'resultados', ' actividades', 'departamento_', 'DSF'),
(16, 3, 2, 'FGGF', 45, 1, 56, 65, '', '', '', 0, '', 56, '2020-06-09 00:00:00', '2020-06-12 00:00:00', '2020-06-11 00:00:00', '2020-06-10 00:00:00', 56, 1, '2020-06-07 21:23:50', 4, 3, 2, '', 'H', 'HG ', 'HG', 'GH', 'HGGH', '', ' HG', '', '', '', 'FG'),
(17, 7, 1, 'TT', 77, 1, 77, 77, '', '', '', 0, '', 77, '2020-06-17 00:00:00', '2020-06-09 00:00:00', '2020-06-08 00:00:00', '2020-06-16 00:00:00', 77, 1, '2020-06-07 22:20:57', 4, 3, 1, '', 'OO', 'OO ', 'OO', 'OO', 'OO', '', ' OOO', '', '', '', 'TTT'),
(18, 5, 2, 'NUNI', 4, 1, 56, 56, '', '', '', 0, '', 56, '2020-06-10 00:00:00', '2020-06-18 00:00:00', '2020-06-24 00:00:00', '2020-06-20 00:00:00', 54, 1, '2020-06-07 22:25:31', 4, 2, 1, '', 'G', 'HG ', 'YUGH', 'HGHG', 'HGHG', '', ' YU', ' YU', ' YU', 'YUYU', 'FVG'),
(19, 5, 2, 'JHG', 67, 1, 65, 56, '', '', '', 0, '', 65, '2020-06-25 00:00:00', '2020-06-26 00:00:00', '2020-06-19 00:00:00', '2020-06-17 00:00:00', 65, 1, '2020-06-07 22:49:57', 4, 3, 2, '', 'GHGH', 'HG ', 'HG', 'HG', 'GHGH', '', ' GH', ' GHG', 'GH', 'GH', 'GH'),
(20, 1, 2, 'POPOP', 45, 1, 45, 45, '', '', '', 0, '', 45, '2020-06-09 00:00:00', '2020-06-10 00:00:00', '2020-06-19 00:00:00', '2020-06-12 00:00:00', 54, 1, '2020-06-07 23:11:11', 4, 2, 3, '', 'HG', 'HG ', 'HG', 'HG', 'GHHG', '', ' GHHG', ' VBHHG', ' GH', 'GF', 'GF'),
(21, 1, 2, 'KLOKLO', 45, 1, 45, 45, '', '', '', 0, '', 45, '2020-06-09 00:00:00', '2020-06-10 00:00:00', '2020-06-19 00:00:00', '2020-06-12 00:00:00', 54, 1, '2020-06-07 23:11:32', 4, 2, 3, '', 'HG', 'HG ', 'HG', 'HG', 'GHHG', '', ' GHHG', ' VBHHG', ' GH', 'GF', 'GF'),
(22, 3, 3, 'F', 43, 1, 43, 34, '', 'FD', 'DF', 3444, 'DF', 43, '2020-06-17 00:00:00', '2020-06-04 00:00:00', '2020-06-16 00:00:00', '2020-06-25 00:00:00', 43, 1, '2020-06-07 23:19:49', 4, 2, 1, '', 'T', 'RTR ', 'RT', 'RT', 'R', ' GF', ' GF', ' FG', ' GF', 'EDF', 'FD'),
(23, 3, 3, 'FYHYH', 43, 1, 43, 34, '', 'FD', 'DF', 3444, 'DF', 43, '2020-06-17 00:00:00', '2020-06-04 00:00:00', '2020-06-16 00:00:00', '2020-06-25 00:00:00', 43, 1, '2020-06-07 23:20:14', 4, 2, 1, '', 'T', 'RTR ', 'RT', 'RT', 'R', ' GF', ' GF', ' FG', ' GF', 'EDF', 'FD'),
(24, 3, 3, 'AAAAAAAASD', 43, 1, 43, 34, 'FDR', 'FD', 'DF', 3444, 'DF', 43, '2020-06-17 00:00:00', '2020-06-04 00:00:00', '2020-06-16 00:00:00', '2020-06-25 00:00:00', 43, 1, '2020-06-07 23:25:03', 4, 2, 1, '', 'T', 'RTR ', 'RT', 'RT', 'R', ' GF', ' GF', ' FG', ' GF', 'EDF', 'FD'),
(25, 3, 3, 'FGFGFG', 43, 1, 43, 34, 'FDR', 'FD', 'DF', 3444, 'DF', 43, '2020-06-17 00:00:00', '2020-06-04 00:00:00', '2020-06-16 00:00:00', '2020-06-25 00:00:00', 43, 1, '2020-06-07 23:25:32', 4, 2, 1, '', 'T', 'RTR ', 'RT', 'RT', 'R', ' GF', ' GF', ' FG', ' GF', 'EDF', 'FD'),
(26, 3, 1, 'YUI', 65, 1, 45, 54, 'KJJH', 'GFH', 'FGH', 6555, 'HGG', 54, '2020-06-10 00:00:00', '2020-06-25 00:00:00', '2020-06-17 00:00:00', '2020-06-23 00:00:00', 76, 1, '2020-06-07 23:37:52', 4, 2, 2, '', 'HFH', 'F ', 'HFH', 'FGHF', 'FGH', ' GF', ' F', ' GF', ' FGG', 'HG', 'HG'),
(27, 2, 2, 'HJGHJ', 678, 1, 768, 766, 'HGJG', 'HGJG', 'JHG', 5688, 'HGJ', 76, '2020-06-18 00:00:00', '2020-06-18 00:00:00', '2020-06-12 00:00:00', '2020-07-03 00:00:00', 768, 1, '2020-06-07 23:41:34', 4, 4, 1, '', 'H', 'JHK ', 'HJK', 'KHKJ', 'HJK', ' HKJH', ' JK', ' OKLJH', ' JKH', 'HJGJ', 'GHJG'),
(28, 1, 1, 'RT5', 45, 1, 5, 4554, 'FGHFG', 'GHGF', 'HGF', 5666, 'FGH', 54, '2020-06-24 00:00:00', '2020-06-18 00:00:00', '2020-07-04 00:00:00', '2020-06-19 00:00:00', 544, 1, '2020-06-08 00:25:37', 4, 1, 1, '', 'JKKJL', 'JKL ', 'JJ', 'JHJ', 'JH', ' JHL', ' JHL', ' KJHL', ' JHL', 'TR', 'RT'),
(29, 2, 2, 'UUUUU', 54, 1, 45, 45, 'FGFG', 'FDG', 'DF', 4444, 'DF', 45, '2020-06-14 00:00:00', '2020-06-30 00:00:00', '2020-06-19 00:00:00', '2020-06-25 00:00:00', 45, 1, '2020-06-08 00:44:25', 4, 4, 1, '', 'FGGF', 'F ', 'GFGF', 'GF', 'GFGF', ' FG', ' FG', ' FG', ' FG', 'FG', 'GFGF'),
(30, 2, 2, 'FG', 54, 1, 54, 54, 'HHH', 'GF', 'GF', 4555, 'FGFGG', 54, '2020-07-02 00:00:00', '2020-06-13 00:00:00', '2020-06-28 00:00:00', '2020-06-11 00:00:00', 54, 1, '2020-06-08 11:35:19', 4, 1, 1, '', 'GHH', 'GH ', 'HG', 'GH', 'GH', ' HG', ' GH', ' GH', ' G', 'GF', 'FG'),
(31, 3, 1, 'AAAAAAAAA', 45, 1, 54, 54, 'FG', 'FG', 'FG', 4555, 'VGBGFC', 45, '2020-06-18 00:00:00', '2020-06-25 00:00:00', '2020-06-18 00:00:00', '2020-06-20 00:00:00', 45, 1, '2020-06-08 15:01:15', 4, 3, 2, '', 'GFH', 'GF ', 'GF', 'GF', 'GF', ' FG', ' GF', ' GF', ' GF', 'GFGF', 'GF'),
(32, 2, 2, '', 0, 1, 0, 0, '', '', '', 0, '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 1, '2020-06-08 15:03:58', 4, 2, 2, '', '', ' ', '', '', '', '', '', '', '', 'BNBGHF', ''),
(33, 1, 1, 'JBKJBBDKJ', 988987, 1, 100, 20, 'KJNKJN', 'NKJNKJ', 'JBFBKJBK', 9328, 'KJNDKJ@JBJ.COM', 20991, '2020-06-01 00:00:00', '2020-06-10 00:00:00', '2020-06-01 00:00:00', '2020-06-09 00:00:00', 987443, 1, '2020-06-08 19:31:45', 4, 3, 1, '', 'GJG', 'JHG ', 'JHGJHG', 'JHG', 'JHGH', ' JHVJH', 'JHGJ ', 'JHG ', 'JHG ', 'JKJHWK', 'KJHH'),
(34, 1, 1, 'SASA', 9889872, 1, 100, 20, 'KJNKJN', 'NKJNKJ', 'JBFBKJBK', 9328, 'KJNDKJ@JBJ.COM', 20991, '2020-06-01 00:00:00', '2020-06-10 00:00:00', '2020-06-01 00:00:00', '2020-06-09 00:00:00', 987443, 1, '2020-06-08 19:42:29', 4, 3, 1, 'JBJH', 'GJG', 'JHG ', 'JHGJHG', 'JHG', 'JHGH', ' JHVJH', 'JHGJ ', 'JHG ', 'JHG ', 'JKJHWK', 'KJHH'),
(35, 1, 1, 'SASASA', 988987234, 1, 100, 20, 'KJNKJN', 'NKJNKJ', 'JBFBKJBK', 9328, 'KJNDKJ@JBJ.COM', 20991, '2020-06-01 00:00:00', '2020-06-10 00:00:00', '2020-06-01 00:00:00', '2020-06-09 00:00:00', 987443, 1, '2020-06-08 19:44:27', 4, 3, 1, 'JBJH', 'GJG', 'JHG ', 'JHGJHG', 'JHG', 'JHGH', ' JHVJH', 'JHGJ ', 'JHG ', 'JHG ', 'JKJHWK', 'KJHHE'),
(36, 1, 1, 'SPAE', 988987234, 1, 100, 20, 'KJNKJN', 'NKJNKJ', 'JBFBKJBK', 9328, 'KJNDKJ@JBJ.COM', 20991, '2020-06-01 00:00:00', '2020-06-10 00:00:00', '2020-06-01 00:00:00', '2020-06-09 00:00:00', 987443, 1, '2020-06-08 19:46:05', 4, 3, 1, 'JBJH', 'GJG', 'JHG ', 'JHGJHG', 'JHG', 'JHGH', ' JHVJH', 'JHGJ ', 'JHG ', 'JHG ', 'JKJHWK', 'KJHHE'),
(37, 1, 1, 'KLJKJJ', 9878, 1, 98, 897, 'KJHKJ', 'MNB', 'JKJK', 9797, 'B@KS.COM', 897, '2020-06-10 00:00:00', '2020-06-10 00:00:00', '2020-06-10 00:00:00', '2020-06-30 00:00:00', 987987, 1, '2020-06-08 20:22:33', 4, 4, 1, 'KJHJHH', 'KJHJKH', 'KKJH ', 'KHKJ', 'KJHJ', 'HKH', ' MBB', 'JKJ ', 'JKH ', 'JHJK ', 'JKHJHJH', 'KJHJH'),
(38, 1, 1, 'UGJHKJH', 765, 1, 87, 787, 'HKJHKH', 'KJKJH', 'KHKH', 8789, 'PRUEBA@PCPC.COM', 987, '2020-06-11 00:00:00', '2020-06-16 00:00:00', '2020-06-22 00:00:00', '2020-06-24 00:00:00', 877, 1, '2020-06-08 20:29:37', 4, 2, 2, 'NJJK', 'KJBKJ', 'BBJKBJK ', 'JKBKJB', 'KJBKJB', 'BKJBKJB', ' KJNJK', 'KJJKJ ', ' KJJK', ' JBB', 'JHKJH', 'JH'),
(39, 1, 1, 'JHKJHJ', 8989789, 1, 87678, 876, 'JJ', 'KJHJKH', 'HHJKH', 8788, 'P@SDK.COM', 876, '2020-06-25 00:00:00', '2020-06-16 00:00:00', '2020-06-20 00:00:00', '2020-06-21 00:00:00', 7867, 1, '2020-06-08 20:37:34', 4, 3, 1, 'HJG', 'GJHG', 'HGH ', 'HGJHG', 'JHG', 'GHH', 'HJGHJ ', 'G ', 'HG ', 'JHG ', 'KJHKJHJKH', 'JJKBJK'),
(40, 1, 1, 'DDDDDD', 654, 1, 54, 4545, 'GFFG', 'JJH', 'HG', 6555, 'CHRISTEL_ORDONEZ29@YAHOO.COM', 45, '2020-06-27 00:00:00', '2020-06-23 00:00:00', '2020-06-05 00:00:00', '2020-06-10 00:00:00', 54, 1, '2020-06-08 22:05:31', 4, 4, 1, 'GGF', 'GFGF', 'GFGF ', 'GFGFGFGFGF', 'GFGF', 'GFGFGF', ' GFGF', ' GFGGF', ' GFGFGF', ' GFGFGF', 'GF', 'GF'),
(41, 2, 2, 'AUTOMATIZAR', 5656, 1, 12, 12, 'CLARO', 'NICOLE SEVILLA', 'JEFE', 5454, 'NICOLE@YAHOO.COM', 24, '2020-06-25 00:00:00', '2020-08-25 00:00:00', '2020-07-09 00:00:00', '2020-08-01 00:00:00', 10500, 1, '2020-06-25 14:56:29', 4, 1, 1, 'NORTE', 'FRANCISCO MORAZAN', 'DISTRITO CENTRAL ', 'LAS BRISAS', 'KENEDY', 'CLARO', ' AUTOMATIZAR', ' IMPLEMENTAR', ' UTILIZAR', ' FUNCIONAR', 'VINCULACION', 'SOCIAL');

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
(47, 'PRUEBA', 'PRUEBA', 0, '2020-05-22 23:17:08', 'admin', NULL, NULL),
(48, 'S', 'PRUEBA S', 1, '2020-05-22 23:18:40', 'admin', NULL, NULL),
(49, 'ESTUDIANTE', 'ES ESTUDIANTE', 1, '2020-06-11 00:19:42', 'ADMIN', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_subida_documentacion`
--

CREATE TABLE `tbl_subida_documentacion` (
  `Id_subida` bigint(16) NOT NULL,
  `Id_usuario` bigint(16) NOT NULL,
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

INSERT INTO `tbl_subida_documentacion` (`Id_subida`, `Id_usuario`, `fecha_creacion`, `fecha_vinculacion`, `fecha_coordinacion`, `estado_vinculacion`, `estado_coordinacion`, `observacion_vinculacion`, `motivo_coordinacion`) VALUES
(2, 1, '0000-00-00 00:00:00', '2020-06-25 16:37:41', '2020-06-25 00:25:36', 1, NULL, 'SIN OBSERVACION', ' VJHV VJHVGHJVH GHGHFHGF FHFHFHF HGFHGF'),
(3, 11, '2020-06-25 00:12:14', '2020-06-25 15:19:03', '2020-06-25 15:19:32', 3, NULL, 'SIN OBSERVACION', ' NO EXISTE EL PERFIL CORRECTO'),
(4, 13, '2020-06-25 16:26:50', '2020-06-25 16:35:55', NULL, 0, NULL, 'NO APLICA PORQUE NO CUMPLE LOS REQUISITOS', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_supervisiones`
--

CREATE TABLE `tbl_supervisiones` (
  `Id_supervision` bigint(16) NOT NULL,
  `Id_empresa` bigint(16) NOT NULL,
  `Id_estudiante` bigint(16) NOT NULL,
  `Id_docente` bigint(16) NOT NULL,
  `Id_capacidad` bigint(16) NOT NULL,
  `Id_funcion` bigint(16) NOT NULL,
  `fecha_inicio` varchar(255) NOT NULL,
  `fecha_final` varchar(255) NOT NULL,
  `cant_horas` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `Id_usuario` bigint(16) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Id_rol` bigint(16) NOT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `numero_cuenta` bigint(16) NOT NULL,
  `estado` int(1) NOT NULL,
  `Correo_Electronico` varchar(255) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Intentos` int(15) NOT NULL,
  `Ultima_conexion` datetime NOT NULL,
  `Fec_vence_contrasena` datetime NOT NULL,
  `Fecha_creacion` varchar(255) NOT NULL,
  `Creado_por` varchar(255) DEFAULT NULL,
  `Modificado_por` varchar(255) DEFAULT NULL,
  `Fecha_modificacion` datetime DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `telefono` int(8) NOT NULL,
  `tipo_usuario` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`Id_usuario`, `Usuario`, `Id_rol`, `nombre_completo`, `numero_cuenta`, `estado`, `Correo_Electronico`, `Contrasena`, `Intentos`, `Ultima_conexion`, `Fec_vence_contrasena`, `Fecha_creacion`, `Creado_por`, `Modificado_por`, `Fecha_modificacion`, `direccion`, `cargo`, `telefono`, `tipo_usuario`) VALUES
(1, 'ADMIN', 46, 'christel nicole neumann callejas', 20141012159, 1, 'christel_ordonez29@yahoo.com', 'bktIQjk1OVZFb3FWSHc5NmZ0dkdPdz09', 0, '2020-05-20 00:00:00', '2020-07-26 19:43:21', '2020-05-20', NULL, 'admin', '2020-05-22 20:45:51', 'las brisas', 'programadora', 88985501, 0),
(2, 'DBA', 46, 'HEINZ NEUMANN', 20141011506, 1, 'christel_ordonez29@yahoo.com', 'bktIQjk1OVZFb3FWSHc5NmZ0dkdPdz09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-05-22 23:28:44', ' admin ', 'ADMIN', '2020-06-01 16:52:08', '', '', 0, 0),
(3, 'GH', 48, 'GHJ', 20141011508, 1, 'jn@yAHOO.COM', 'b3VPOVpDcWxUM29KQUIwOUh1SnVtQT09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-05-24 16:52:02', ' ADMIN ', NULL, NULL, '', '', 0, 0),
(10, '565', 49, 'iiiiiiiiiiii', 565, 2, 'ASHLY@YAHOO.COM', 'bktIQjk1OVZFb3FWSHc5NmZ0dkdPdz09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-06-11 23:00:12', NULL, NULL, NULL, '', '', 0, 0),
(11, '20151005561', 49, 'noemi varela', 20151005561, 1, 'noemi@yahoo', 'b3VPOVpDcWxUM29KQUIwOUh1SnVtQT09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-06-24 23:20:28', NULL, NULL, NULL, '', '', 0, 0),
(12, '20201010100', 49, 'rosmery corrales', 20201010100, 2, 'rosmery@yahoo.com', 'b3VPOVpDcWxUM29KQUIwOUh1SnVtQT09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-06-25 15:20:30', NULL, NULL, NULL, '', '', 0, 0),
(13, '20202020200', 49, 'ana sevilla', 20202020200, 1, 'ana@yahoo.com', 'b3VPOVpDcWxUM29KQUIwOUh1SnVtQT09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-06-25 15:49:15', NULL, NULL, NULL, '', '', 0, 0),
(14, '20201010101', 49, 'SOFIA NUÃ‘EZ', 20201010101, 2, 'noemi@yahoo', 'bktIQjk1OVZFb3FWSHc5NmZ0dkdPdz09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-06-30 22:11:44', NULL, NULL, NULL, '', '', 0, 0),
(15, '20141011508', 49, 'lili nuÃ±ez', 20141011508, 2, 'ASHLY@YAHOO.COM', 'bktIQjk1OVZFb3FWSHc5NmZ0dkdPdz09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-06-30 22:18:45', NULL, NULL, NULL, '', '', 0, 0),
(16, '202000000000000', 49, 'ana nuñez', 202000000000000, 2, 'ana@yahoo.com', 'bktIQjk1OVZFb3FWSHc5NmZ0dkdPdz09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-06-30 22:22:15', NULL, NULL, NULL, '', '', 0, 0),
(17, '20131015093', 49, 'helmer calix', 20131015093, 1, 'hcalix92@gmail.com', 'bGFsT0xvQ1JMVjBkUklRaWk5bDNOQT09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-07-30 22:20:01', NULL, NULL, NULL, '', '', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_asignaturas`
--
ALTER TABLE `tbl_asignaturas`
  ADD PRIMARY KEY (`Id_asignatura`);

--
-- Indices de la tabla `tbl_asignaturas_aprobadas`
--
ALTER TABLE `tbl_asignaturas_aprobadas`
  ADD PRIMARY KEY (`Id_asignatura_aprobada`),
  ADD KEY `Id_asignatura` (`Id_asignatura`),
  ADD KEY `Id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_asignatura_canceladas`
--
ALTER TABLE `tbl_asignatura_canceladas`
  ADD PRIMARY KEY (`Id_asig_cancelada`),
  ADD KEY `cod_asignatura` (`Id_asignatura`),
  ADD KEY `cod_estudiante` (`Id_usuario`);

--
-- Indices de la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  ADD PRIMARY KEY (`Id_bitacora`),
  ADD KEY `cod_usuario` (`Id_usuario`,`Id_objeto`),
  ADD KEY `rel_bi_obj` (`Id_objeto`),
  ADD KEY `Id_objeto` (`Id_objeto`);

--
-- Indices de la tabla `tbl_cambio_carrera`
--
ALTER TABLE `tbl_cambio_carrera`
  ADD PRIMARY KEY (`Id_cambio`),
  ADD KEY `fk_estu_cambio` (`Id_usuario`),
  ADD KEY `fk_cambio_centro` (`Id_centro_regional`);

--
-- Indices de la tabla `tbl_cancelar_clases`
--
ALTER TABLE `tbl_cancelar_clases`
  ADD PRIMARY KEY (`Id_cancelar_clases`),
  ADD KEY `id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_capacidades_practica`
--
ALTER TABLE `tbl_capacidades_practica`
  ADD PRIMARY KEY (`Id_capacidad`),
  ADD KEY `cod_evalua_capacidad` (`Id_evalua_capacidad`),
  ADD KEY `cod_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_carreras`
--
ALTER TABLE `tbl_carreras`
  ADD PRIMARY KEY (`Id_carrera`),
  ADD KEY `cod_departamento` (`Id_departamento`);

--
-- Indices de la tabla `tbl_carta_egresado`
--
ALTER TABLE `tbl_carta_egresado`
  ADD PRIMARY KEY (`Id_carta`),
  ADD KEY `fk_estu_cartaegre` (`Id_usuario`);

--
-- Indices de la tabla `tbl_centros_regionales`
--
ALTER TABLE `tbl_centros_regionales`
  ADD PRIMARY KEY (`Id_centro_regional`);

--
-- Indices de la tabla `tbl_charla_practica`
--
ALTER TABLE `tbl_charla_practica`
  ADD PRIMARY KEY (`Id_charla`),
  ADD UNIQUE KEY `Id_charla` (`Id_charla`),
  ADD KEY `cod_estudiante` (`Id_usuario`) USING BTREE;

--
-- Indices de la tabla `tbl_contador_constancia`
--
ALTER TABLE `tbl_contador_constancia`
  ADD PRIMARY KEY (`id_contador`);

--
-- Indices de la tabla `tbl_docentes`
--
ALTER TABLE `tbl_docentes`
  ADD PRIMARY KEY (`Id_docente`);

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
  ADD KEY `cod_usuario` (`Id_usuario`);

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
  ADD KEY `fk_equiva_estudiante` (`Id_usuario`);

--
-- Indices de la tabla `tbl_estudiantes_proyecto`
--
ALTER TABLE `tbl_estudiantes_proyecto`
  ADD PRIMARY KEY (`Id_estudiante_proyecto`),
  ADD KEY `Id_proyecto` (`Id_proyecto`);

--
-- Indices de la tabla `tbl_evaluaciones_capacidad`
--
ALTER TABLE `tbl_evaluaciones_capacidad`
  ADD PRIMARY KEY (`Id_evalua_capacidad`),
  ADD KEY `cod_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_facultades`
--
ALTER TABLE `tbl_facultades`
  ADD PRIMARY KEY (`Id_facultad`),
  ADD KEY `cod_departamento` (`Id_carrera`);

--
-- Indices de la tabla `tbl_finalizacion_practica`
--
ALTER TABLE `tbl_finalizacion_practica`
  ADD PRIMARY KEY (`Id_finalizacion`);

--
-- Indices de la tabla `tbl_funciones_practica`
--
ALTER TABLE `tbl_funciones_practica`
  ADD PRIMARY KEY (`Id_funcion`),
  ADD KEY `cod_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_modalidades_proyecto`
--
ALTER TABLE `tbl_modalidades_proyecto`
  ADD PRIMARY KEY (`Id_modalidad`);

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
  ADD KEY `cod_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_permisos_usuarios`
--
ALTER TABLE `tbl_permisos_usuarios`
  ADD PRIMARY KEY (`Id_permisos_usuario`),
  ADD KEY `cod_rol` (`Id_rol`),
  ADD KEY `cod_objeto` (`Id_objeto`);

--
-- Indices de la tabla `tbl_practica_estudiantes`
--
ALTER TABLE `tbl_practica_estudiantes`
  ADD PRIMARY KEY (`Id_practica`),
  ADD KEY `cod_estudiante` (`Id_usuario`),
  ADD KEY `cod_docente` (`Id_docente`),
  ADD KEY `cod_puesto` (`Id_puesto`),
  ADD KEY `cod_empresa` (`Id_empresa`);

--
-- Indices de la tabla `tbl_practica_rechazo`
--
ALTER TABLE `tbl_practica_rechazo`
  ADD PRIMARY KEY (`id_practica_rechazo`),
  ADD KEY `Id_usuario` (`Id_usuario`);

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
  ADD KEY `Id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  ADD PRIMARY KEY (`Id_proyecto`),
  ADD KEY `cod_tipo_v` (`Id_tipo_v`),
  ADD KEY `cod_modalidad` (`Id_modalidad`),
  ADD KEY `cod_usuario` (`Id_usuario`),
  ADD KEY `cod_asignatura` (`Id_asignatura`),
  ADD KEY `Id_tipo_formalizacion` (`Id_tipo_formalizacion`),
  ADD KEY `Id_aporte` (`Id_aporte`);

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
  ADD KEY `Id_usuario` (`Id_usuario`);

--
-- Indices de la tabla `tbl_supervisiones`
--
ALTER TABLE `tbl_supervisiones`
  ADD PRIMARY KEY (`Id_supervision`),
  ADD KEY `cod_empresa` (`Id_empresa`,`Id_estudiante`,`Id_docente`),
  ADD KEY `cod_docente` (`Id_docente`),
  ADD KEY `cod_estudiante` (`Id_estudiante`),
  ADD KEY `cod_puesto` (`Id_capacidad`),
  ADD KEY `cod_funcion` (`Id_funcion`);

--
-- Indices de la tabla `tbl_tipos_vinculacion`
--
ALTER TABLE `tbl_tipos_vinculacion`
  ADD PRIMARY KEY (`Id_tipo_v`);

--
-- Indices de la tabla `tbl_tipo_formalizacion_proyecto`
--
ALTER TABLE `tbl_tipo_formalizacion_proyecto`
  ADD PRIMARY KEY (`Id_tipo_formalizacion`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`Id_usuario`),
  ADD KEY `cod_rol` (`Id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_asignaturas`
--
ALTER TABLE `tbl_asignaturas`
  MODIFY `Id_asignatura` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `tbl_asignaturas_aprobadas`
--
ALTER TABLE `tbl_asignaturas_aprobadas`
  MODIFY `Id_asignatura_aprobada` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `tbl_asignatura_canceladas`
--
ALTER TABLE `tbl_asignatura_canceladas`
  MODIFY `Id_asig_cancelada` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  MODIFY `Id_bitacora` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1581;

--
-- AUTO_INCREMENT de la tabla `tbl_cambio_carrera`
--
ALTER TABLE `tbl_cambio_carrera`
  MODIFY `Id_cambio` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tbl_cancelar_clases`
--
ALTER TABLE `tbl_cancelar_clases`
  MODIFY `Id_cancelar_clases` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_capacidades_practica`
--
ALTER TABLE `tbl_capacidades_practica`
  MODIFY `Id_capacidad` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_carreras`
--
ALTER TABLE `tbl_carreras`
  MODIFY `Id_carrera` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_carta_egresado`
--
ALTER TABLE `tbl_carta_egresado`
  MODIFY `Id_carta` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tbl_centros_regionales`
--
ALTER TABLE `tbl_centros_regionales`
  MODIFY `Id_centro_regional` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_charla_practica`
--
ALTER TABLE `tbl_charla_practica`
  MODIFY `Id_charla` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_contador_constancia`
--
ALTER TABLE `tbl_contador_constancia`
  MODIFY `id_contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_docentes`
--
ALTER TABLE `tbl_docentes`
  MODIFY `Id_docente` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_egresados`
--
ALTER TABLE `tbl_egresados`
  MODIFY `Id_egresado` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_empresas_practica`
--
ALTER TABLE `tbl_empresas_practica`
  MODIFY `Id_empresa` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_empresa_aporte_proyecto`
--
ALTER TABLE `tbl_empresa_aporte_proyecto`
  MODIFY `Id_aporte` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_equivalencias`
--
ALTER TABLE `tbl_equivalencias`
  MODIFY `Id_equivalencia` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_estudiantes_proyecto`
--
ALTER TABLE `tbl_estudiantes_proyecto`
  MODIFY `Id_estudiante_proyecto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `tbl_evaluaciones_capacidad`
--
ALTER TABLE `tbl_evaluaciones_capacidad`
  MODIFY `Id_evalua_capacidad` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_facultades`
--
ALTER TABLE `tbl_facultades`
  MODIFY `Id_facultad` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_finalizacion_practica`
--
ALTER TABLE `tbl_finalizacion_practica`
  MODIFY `Id_finalizacion` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `tbl_funciones_practica`
--
ALTER TABLE `tbl_funciones_practica`
  MODIFY `Id_funcion` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_modalidades_proyecto`
--
ALTER TABLE `tbl_modalidades_proyecto`
  MODIFY `Id_modalidad` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_objetos`
--
ALTER TABLE `tbl_objetos`
  MODIFY `Id_objeto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `tbl_parametros`
--
ALTER TABLE `tbl_parametros`
  MODIFY `Id_parametro` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos_usuarios`
--
ALTER TABLE `tbl_permisos_usuarios`
  MODIFY `Id_permisos_usuario` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `tbl_practica_estudiantes`
--
ALTER TABLE `tbl_practica_estudiantes`
  MODIFY `Id_practica` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_practica_rechazo`
--
ALTER TABLE `tbl_practica_rechazo`
  MODIFY `id_practica_rechazo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_preguntas`
--
ALTER TABLE `tbl_preguntas`
  MODIFY `Id_pregunta` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `tbl_preguntas_seguridad`
--
ALTER TABLE `tbl_preguntas_seguridad`
  MODIFY `Id_pregunta_seguridad` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  MODIFY `Id_proyecto` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `Id_rol` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tbl_subida_documentacion`
--
ALTER TABLE `tbl_subida_documentacion`
  MODIFY `Id_subida` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_supervisiones`
--
ALTER TABLE `tbl_supervisiones`
  MODIFY `Id_supervision` bigint(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_tipos_vinculacion`
--
ALTER TABLE `tbl_tipos_vinculacion`
  MODIFY `Id_tipo_v` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_formalizacion_proyecto`
--
ALTER TABLE `tbl_tipo_formalizacion_proyecto`
  MODIFY `Id_tipo_formalizacion` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `Id_usuario` bigint(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_asignaturas_aprobadas`
--
ALTER TABLE `tbl_asignaturas_aprobadas`
  ADD CONSTRAINT `rel_asiga_asig` FOREIGN KEY (`Id_asignatura`) REFERENCES `tbl_asignaturas` (`Id_asignatura`),
  ADD CONSTRAINT `rel_asiga_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_bitacora`
--
ALTER TABLE `tbl_bitacora`
  ADD CONSTRAINT `rel_bi_objeto` FOREIGN KEY (`Id_objeto`) REFERENCES `tbl_objetos` (`Id_objeto`),
  ADD CONSTRAINT `rel_bi_user` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_charla_practica`
--
ALTER TABLE `tbl_charla_practica`
  ADD CONSTRAINT `tbl_charla_practica_ibfk_1` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_empresas_practica`
--
ALTER TABLE `tbl_empresas_practica`
  ADD CONSTRAINT `rel_empresa_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_estudiantes_proyecto`
--
ALTER TABLE `tbl_estudiantes_proyecto`
  ADD CONSTRAINT `rel_estudiante_proyecto` FOREIGN KEY (`Id_proyecto`) REFERENCES `tbl_proyectos` (`Id_proyecto`);

--
-- Filtros para la tabla `tbl_parametros`
--
ALTER TABLE `tbl_parametros`
  ADD CONSTRAINT `rel_parametros_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_permisos_usuarios`
--
ALTER TABLE `tbl_permisos_usuarios`
  ADD CONSTRAINT `tbl_permisos_usuarios_ibfk_1` FOREIGN KEY (`Id_objeto`) REFERENCES `tbl_objetos` (`Id_objeto`),
  ADD CONSTRAINT `tbl_permisos_usuarios_ibfk_2` FOREIGN KEY (`Id_rol`) REFERENCES `tbl_roles` (`Id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_practica_rechazo`
--
ALTER TABLE `tbl_practica_rechazo`
  ADD CONSTRAINT `rel_rechazo_usuarios` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_preguntas_seguridad`
--
ALTER TABLE `tbl_preguntas_seguridad`
  ADD CONSTRAINT `rel_pregunta_pregunta` FOREIGN KEY (`Id_pregunta`) REFERENCES `tbl_preguntas` (`Id_pregunta`),
  ADD CONSTRAINT `rel_pregunta_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  ADD CONSTRAINT `rel_proy_aporte` FOREIGN KEY (`Id_aporte`) REFERENCES `tbl_empresa_aporte_proyecto` (`Id_aporte`),
  ADD CONSTRAINT `rel_proy_asig` FOREIGN KEY (`Id_asignatura`) REFERENCES `tbl_asignaturas` (`Id_asignatura`),
  ADD CONSTRAINT `rel_proy_modalidad` FOREIGN KEY (`Id_modalidad`) REFERENCES `tbl_modalidades_proyecto` (`Id_modalidad`),
  ADD CONSTRAINT `rel_proy_tipof` FOREIGN KEY (`Id_tipo_formalizacion`) REFERENCES `tbl_tipo_formalizacion_proyecto` (`Id_tipo_formalizacion`),
  ADD CONSTRAINT `rel_proy_tipov` FOREIGN KEY (`Id_tipo_v`) REFERENCES `tbl_tipos_vinculacion` (`Id_tipo_v`),
  ADD CONSTRAINT `rel_proy_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_subida_documentacion`
--
ALTER TABLE `tbl_subida_documentacion`
  ADD CONSTRAINT `rel_subida_usuario` FOREIGN KEY (`Id_usuario`) REFERENCES `tbl_usuarios` (`Id_usuario`);

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`Id_rol`) REFERENCES `tbl_roles` (`Id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
