CREATE TABLE `tbl_voae_ambitos` (
  `id_ambito` int NOT NULL,
  `nombre_ambito` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Nombre del ámbito',
  `descripcion_ambito` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Descripción del ámbito, con ejemplos de alguna actividad relacionada.',
  PRIMARY KEY (`id_ambito`),
  UNIQUE KEY `id_ambito_UNIQUE` (`id_ambito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar los tipos de ámbitos al que puede pertenecer una actividad del CVE-VOAE.'



CREATE TABLE `tbl_voae_estados` (
  `id_estado` int NOT NULL,
  `nombre_estado` varchar(25) NOT NULL COMMENT 'Nombre que identifica el estado de una actividad.',
  `descripcion_estado` varchar(200) NOT NULL COMMENT 'Resumen que describe el estado de una actividad.',
  PRIMARY KEY (`id_estado`),
  UNIQUE KEY `id_estado_UNIQUE` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabala para describir el estado de una actividad VOAE del CVE.'



--
CREATE TABLE `tbl_voae_tipos_repositorios` (
  `id_tipo` int NOT NULL,
  `nombre` varchar(25) NOT NULL COMMENT 'Nombre que hace referencia al tipo de repositorio.',
  `descripcion` varchar(200) NOT NULL COMMENT 'Detalla las carateristicas del tipo de repositorio.',
  PRIMARY KEY (`id_tipo`),
  UNIQUE KEY `id_tipo_UNIQUE` (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Define los tipos de repositorios que se utilizan para identificar la relación con el archivo que se importe al repositorio.'



CREATE TABLE `tbl_voae_tipos_faltas` (
  `id_falta` int NOT NULL,
  `nombre_falta` varchar(25) NOT NULL COMMENT 'Nombre que identifica el tipo de la falta.',
  `descripcion_falta` varchar(200) NOT NULL COMMENT 'Resumen de el tipo de comportamiento que describe la falta.',
  PRIMARY KEY (`id_falta`),
  UNIQUE KEY `id_falta_UNIQUE` (`id_falta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para enlistar los tipos de faltas que pudiera n existir en la conducta de los estudiantes.'


--Prodedimiento de Insertar Tipo de Falta
DROP procedure IF EXISTS `proc_insertar_tipo_falta`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_insertar_tipo_falta`(`n_tipo` VARCHAR(45), `descripcion_tipo` VARCHAR(200))
BEGIN
INSERT INTO  tbl_voae_tipos_faltas(nombre_falta, descripcion_falta)
VALUES (n_tipo, descripcion_tipo);
END$$
DELIMITER ;
