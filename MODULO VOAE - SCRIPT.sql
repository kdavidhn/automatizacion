CREATE TABLE `tbl_voae_ambitos` (
	`id_ambito` BIGINT NOT NULL AUTO_INCREMENT,
	`nombre_ambito` VARCHAR(25) NOT NULL COMMENT 'Nombre del ámbito' COLLATE 'utf8_general_ci',
	`descripcion_ambito` VARCHAR(200) NOT NULL COMMENT 'Descripción del ámbito, con ejemplos de alguna actividad relacionada.' COLLATE 'utf8_general_ci',
	`condicion` TINYINT(4) NULL DEFAULT NULL,
	PRIMARY KEY (`id_ambito`) USING BTREE,
	UNIQUE INDEX `id_ambito_UNIQUE` (`id_ambito`) USING BTREE,
	UNIQUE INDEX `nombre_ambito` (`nombre_ambito`) USING BTREE
)
COMMENT='Tabla para almacenar los tipos de ámbitos al que puede pertenecer una actividad del CVE-VOAE.'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `tbl_voae_estados` (
	`id_estado` BIGINT NOT NULL AUTO_INCREMENT,
	`nombre_estado` VARCHAR(25) NOT NULL COMMENT 'Nombre que identifica el estado de una actividad.' COLLATE 'utf8_general_ci',
	`descripcion_estado` VARCHAR(200) NOT NULL COMMENT 'Resumen que describe el estado de una actividad.' COLLATE 'utf8_general_ci',
	`condicion` TINYINT(4) NULL DEFAULT NULL,
	PRIMARY KEY (`id_estado`) USING BTREE,
	UNIQUE INDEX `id_estado_UNIQUE` (`id_estado`) USING BTREE,
	UNIQUE INDEX `nombre_estado_unico` (`nombre_estado`) USING BTREE
)
COMMENT='Tabala para describir el estado de una actividad VOAE del CVE.'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `tbl_voae_tipos_faltas` (
	`id_falta` BIGINT NOT NULL AUTO_INCREMENT,
	`nombre_falta` VARCHAR(25) NOT NULL COMMENT 'Nombre que identifica el tipo de la falta.' COLLATE 'utf8_general_ci',
	`descripcion_falta` VARCHAR(200) NOT NULL COMMENT 'Resumen de el tipo de comportamiento que describe la falta.' COLLATE 'utf8_general_ci',
	`condicion` TINYINT(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id_falta`) USING BTREE,
	UNIQUE INDEX `id_falta_UNIQUE` (`id_falta`) USING BTREE,
	UNIQUE INDEX `nombre_tipo_falta_unico` (`nombre_falta`) USING BTREE
)
COMMENT='Tabla para enlistar los tipos de faltas que pudiera n existir en la conducta de los estudiantes.'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `tbl_voae_tipos_repositorios` (
	`id_repositorio` BIGINT NOT NULL AUTO_INCREMENT,
	`nombre_repositorio` VARCHAR(25) NOT NULL COMMENT 'Nombre que hace referencia al tipo de repositorio.' COLLATE 'utf8_general_ci',
	`descripcion_repositorio` VARCHAR(200) NOT NULL COMMENT 'Detalla las carateristicas del tipo de repositorio.' COLLATE 'utf8_general_ci',
	`condicion` TINYINT(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id_tipo`) USING BTREE,
	UNIQUE INDEX `id_tipo_UNIQUE` (`id_tipo`) USING BTREE,
	UNIQUE INDEX `nombre_tipo_repositorio_unico` (`nombre`) USING BTREE
)
COMMENT='Define los tipos de repositorios que se utilizan para identificar la relación con el archivo que se importe al repositorio.'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



CREATE TABLE `tbl_voae_actividades` (
	`id_actividad_voae` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Campo llave - índice de la tabla',
	`no_aprobacion` INT(11) NULL DEFAULT NULL COMMENT 'Asignación de Número de Actividad aprobada',
	`fch_solicitud` DATETIME NOT NULL,
	`nombre_actividad` VARCHAR(45) NOT NULL COLLATE 'utf8mb4_general_ci',
	`ubicacion` VARCHAR(50) NOT NULL COMMENT 'Ubicación del lugar donde se desarollará la Actividad' COLLATE 'utf8mb4_general_ci',
	`fch_inicial_actividad` DATETIME NOT NULL COMMENT 'Fecha y hora que da inicio la actividad que se está registrando',
	`fch_final_actividad` DATETIME NOT NULL COMMENT 'Fecha y hora que finaliza la actividad que se está registrando',
	`descripcion` VARCHAR(200) NOT NULL COMMENT 'Detalles sobre la actividad que se registra.' COLLATE 'utf8mb4_general_ci',
	`poblacion_objetivo` VARCHAR(50) NOT NULL COMMENT 'Detalla el público objetivo de la actividad' COLLATE 'utf8mb4_general_ci',
	`presupuesto` DECIMAL(10,0) NOT NULL COMMENT 'Monto presupuestado requerido para el desarrollo de la actividad.',
	`staff_alumnos` VARCHAR(100) NOT NULL COMMENT 'Listado de Estudiantes que colaboran en la organizacion de la actividad.' COLLATE 'utf8mb4_general_ci',
	`observaciones` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Comentarios extras a considerar en el regitro de la actividad.' COLLATE 'utf8mb4_general_ci',
	`id_estado` BIGINT(20) NOT NULL DEFAULT '0' COMMENT 'FK - indice que hace referencia l PK de la tabla de estados',
	`id_usuario_registro` BIGINT(20) NOT NULL DEFAULT '0' COMMENT 'FK - indice que hace referencia al PK de la tabla de usuarios para identificar el usuario que realiza el registro.',
	`id_ambito` BIGINT(20) NOT NULL DEFAULT '0' COMMENT 'FK - indice que hace referencia al PK de la tabla de ambitos.',
	PRIMARY KEY (`id_actividad_voae`) USING BTREE,
	INDEX `FK1_tbl_actividades_voae_tbl_estados` (`id_estado`) USING BTREE,
	INDEX `FK2_tbl_actividades_voae_tbl_usuarios` (`id_usuario_registro`) USING BTREE,
	INDEX `FK3_tbl_actividades_voae_tbl_ambitos` (`id_ambito`) USING BTREE,
	CONSTRAINT `FK1_tbl_actividades_voae_tbl_estados` FOREIGN KEY (`id_estado`) REFERENCES `automatizacion`.`tbl_voae_estados` (`id_estado`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK2_tbl_actividades_voae_tbl_usuarios` FOREIGN KEY (`id_usuario_registro`) REFERENCES `automatizacion`.`tbl_usuarios` (`Id_usuario`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK3_tbl_actividades_voae_tbl_ambitos` FOREIGN KEY (`id_ambito`) REFERENCES `automatizacion`.`tbl_voae_ambitos` (`id_ambito`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Tabla que registra las actividades VOAE del Comite de Vida Estudiantil'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB

;



CREATE TABLE `tbl_voae_faltas_conductas` (
	`id_falta` BIGINT NOT NULL AUTO_INCREMENT,
	`id_tipo_falta` BIGINT(20) NOT NULL COMMENT 'FK del índice de la tabla que hace referencia al tipo de falta.',
	`fch_falta` DATE NOT NULL COMMENT 'Fecha en que se sucitó la insidencia / falta',
	`id_usuario_alumno` BIGINT(20) NOT NULL COMMENT 'KF indice de referencia a la tabla que contiene el registro del estudiante.',
	`descripcion` VARCHAR(200) NOT NULL COMMENT 'Descripción detallada de la falta cometida.' COLLATE 'utf8mb4_general_ci',
	`id_usuario_registro` BIGINT(20) NOT NULL,
	`fch_registro` DATE NOT NULL COMMENT 'Fecha en que se registró la falta en el sistema.',
	PRIMARY KEY (`id_falta`) USING BTREE,
	INDEX `FK1_tbl_faltas_tbl_usuario_alumno` (`id_usuario_alumno`) USING BTREE,
	INDEX `FK2_tbl_faltas_tbl_usuario_registro` (`id_usuario_registro`) USING BTREE,
	INDEX `FK3_tbl_faltas_tbl_tipo_falta` (`id_tipo_falta`) USING BTREE,
	CONSTRAINT `FK1_tbl_faltas_tbl_usuario_alumno` FOREIGN KEY (`id_usuario_alumno`) REFERENCES `automatizacion`.`tbl_usuarios` (`Id_usuario`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK2_tbl_faltas_tbl_usuario_registro` FOREIGN KEY (`id_usuario_registro`) REFERENCES `automatizacion`.`tbl_usuarios` (`Id_usuario`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK3_tbl_faltas_tbl_tipo_falta` FOREIGN KEY (`id_tipo_falta`) REFERENCES `automatizacion`.`tbl_voae_tipos_faltas` (`id_falta`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Tabla que registra las faltas de conducta de los estudiantes de la carrera de Informática Administrativa.'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `tbl_voae_asistencias` (
	`id_asistencia` BIGINT NOT NULL AUTO_INCREMENT,
	`id_usuario_alumno` BIGINT(20) NOT NULL COMMENT 'Identificador del usuario que asistió a la actividad',
	`id_actividad_voae` BIGINT(20) NOT NULL COMMENT 'Identificador de la actividad que se está asignando asistencia.',
	`cant_horas` DECIMAL(10,0) NOT NULL COMMENT 'Cantidad de horas que se le asignan al alumno por participar en la actividad.',
	PRIMARY KEY (`id_asistencia`) USING BTREE,
	INDEX `FK1_tbl_asistencias_tbl_usuario` (`id_usuario_alumno`) USING BTREE,
	INDEX `FK2_tbl_asistencias_tbl_actividad_voae` (`id_actividad_voae`) USING BTREE,
	CONSTRAINT `FK1_tbl_asistencias_tbl_usuario` FOREIGN KEY (`id_usuario_alumno`) REFERENCES `automatizacion`.`tbl_usuarios` (`Id_usuario`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK2_tbl_asistencias_tbl_actividad_voae` FOREIGN KEY (`id_actividad_voae`) REFERENCES `automatizacion`.`tbl_voae_actividades` (`id_actividad_voae`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Tabla para llevar registro de las asistencias de los estudiantes a las actividades del CVE'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `tbl_voae_informes` (
	`id_informe` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'indice de la tabla - identificador',
	`id_actividad` BIGINT(20) NOT NULL COMMENT 'Campo identificador de la actividad',
	`introduccion` VARCHAR(100) NOT NULL COMMENT 'Introducción del Informe' COLLATE 'utf8mb4_general_ci',
	`objetivos` VARCHAR(100) NOT NULL COMMENT 'Objetivos del Informe' COLLATE 'utf8mb4_general_ci',
	`desarrollo` VARCHAR(250) NOT NULL COMMENT 'Desarollo del Informe' COLLATE 'utf8mb4_general_ci',
	`conclusiones` VARCHAR(100) NOT NULL COMMENT 'Conclusiones del Informe' COLLATE 'utf8mb4_general_ci',
	`fch_informe` DATE NOT NULL COMMENT 'Fecha del Informe',
	`id_usuario_registro` BIGINT(20) NOT NULL,
	PRIMARY KEY (`id_informe`) USING BTREE,
	INDEX `FK1_tbl_informes_tbl_actividades` (`id_actividad`) USING BTREE,
	INDEX `FK2_tbl_informes_tbl_usuarios` (`id_usuario_registro`) USING BTREE,
	CONSTRAINT `FK1_tbl_informes_tbl_actividades` FOREIGN KEY (`id_actividad`) REFERENCES `automatizacion`.`tbl_voae_actividades` (`id_actividad_voae`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK2_tbl_informes_tbl_usuarios` FOREIGN KEY (`id_usuario_registro`) REFERENCES `automatizacion`.`tbl_usuarios` (`Id_usuario`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Tabla que registrará los informes de las actividades VOAE que se realizan por el CVE'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `tbl_voae_repositorios` (
	`id_repositorio` BIGINT NOT NULL AUTO_INCREMENT COMMENT 'Identificador o indice de la tabla',
	`id_tipo_repositorio` BIGINT(20) NOT NULL COMMENT 'Identificador del tipo de repositorio que corresponde al repositorio que se registra',
	`id_actividad` BIGINT(20) NOT NULL COMMENT 'Identificador de la Actividad que corresponde al repositorio que se registra',
	`dir_repositorio` VARCHAR(150) NOT NULL COMMENT 'Dirección de la ubicación del archivo guardado en el repositorio.' COLLATE 'utf8mb4_general_ci',
	`fecha_carga` DATETIME NOT NULL,
	`id_usuario_registro` BIGINT(20) NOT NULL,
	PRIMARY KEY (`id_repositorio`) USING BTREE,
	INDEX `FK1_tbl_repositorios_tbl_tipos_repositorios` (`id_tipo_repositorio`) USING BTREE,
	INDEX `FK2_tbl_repositorios_tbl_actividades` (`id_actividad`) USING BTREE,
	INDEX `FK3_tbl_repositorios_tbl_usuarios` (`id_usuario_registro`) USING BTREE,
	CONSTRAINT `FK1_tbl_repositorios_tbl_tipos_repositorios` FOREIGN KEY (`id_tipo_repositorio`) REFERENCES `automatizacion`.`tbl_voae_tipos_repositorios` (`id_tipo`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK2_tbl_repositorios_tbl_actividades` FOREIGN KEY (`id_actividad`) REFERENCES `automatizacion`.`tbl_voae_actividades` (`id_actividad_voae`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK3_tbl_repositorios_tbl_usuarios` FOREIGN KEY (`id_usuario_registro`) REFERENCES `automatizacion`.`tbl_usuarios` (`Id_usuario`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Tabla para registrar las direcciones de los archivos que documentan las actividades VOAE del CVE almacenados en repositorio.'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `tbl_voae_memorandums` (
	`id_memo` BIGINT NOT NULL AUTO_INCREMENT,
	`no_memo` VARCHAR(10) NOT NULL COLLATE 'utf8mb4_general_ci',
	`id_actividad` BIGINT(20) NULL DEFAULT NULL,
	`remitente` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`destinatario` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`fecha` DATE NOT NULL,
	`contenido` VARCHAR(250) NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id_memo`) USING BTREE,
	INDEX `FK1_tbl_memorandums_tbl_actividades` (`id_actividad`) USING BTREE,
	CONSTRAINT `FK1_tbl_memorandums_tbl_actividades` FOREIGN KEY (`id_actividad`) REFERENCES `automatizacion`.`tbl_voae_actividades` (`id_actividad_voae`) ON UPDATE CASCADE ON DELETE CASCADE
)
COMMENT='Tabla para registrar la elaboración de memorandums necesarios para la remision de las actividades VOAE del CVE'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;