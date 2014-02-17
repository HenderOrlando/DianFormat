-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-02-2014 a las 22:23:09
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `puerto_udes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aduana`
--

CREATE TABLE IF NOT EXISTS `aduana` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lugar` bigint(20) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CAE74A8F4974AAAC` (`lugar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bulto`
--

CREATE TABLE IF NOT EXISTS `bulto` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fechaCreado` datetime NOT NULL,
  `marca` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clase` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `bulto`
--

INSERT INTO `bulto` (`id`, `fechaCreado`, `marca`, `clase`, `nombre`) VALUES
(1, '2013-11-16 04:23:55', 'S/M', 'Caja', ''),
(2, '2013-12-07 11:49:58', 'M/S', 'Barril', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga`
--

CREATE TABLE IF NOT EXISTS `carga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naturaleza` bigint(20) DEFAULT NULL,
  `formato` bigint(20) NOT NULL,
  `lugar_carga` bigint(20) DEFAULT NULL,
  `num_precintos` int(11) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL,
  `lugar_descarga` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DC567A76C3C7DA41` (`naturaleza`),
  KEY `IDX_DC567A7619BDE673` (`formato`),
  KEY `IDX_DC567A76993141CC` (`lugar_carga`),
  KEY `IDX_DC567A765862802E` (`lugar_descarga`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `carga`
--

INSERT INTO `carga` (`id`, `naturaleza`, `formato`, `lugar_carga`, `num_precintos`, `fecha_creado`, `lugar_descarga`) VALUES
(1, 6, 1, 5, -1, '2013-11-15 13:42:29', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga_unidad_carga`
--

CREATE TABLE IF NOT EXISTS `carga_unidad_carga` (
  `id_unidad_carga` bigint(20) NOT NULL,
  `id_carga` bigint(20) NOT NULL,
  PRIMARY KEY (`id_unidad_carga`,`id_carga`),
  KEY `IDX_36E65DF84E36F84F` (`id_unidad_carga`),
  KEY `IDX_36E65DF832D33B46` (`id_carga`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `carga_unidad_carga`
--

INSERT INTO `carga_unidad_carga` (`id_unidad_carga`, `id_carga`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion`
--

CREATE TABLE IF NOT EXISTS `condicion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formato_id` bigint(20) NOT NULL,
  `tipo_id` bigint(20) NOT NULL,
  `condicion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7018E7658D02887B` (`formato_id`),
  KEY `IDX_7018E765A9276E6C` (`tipo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `condicion`
--

INSERT INTO `condicion` (`id`, `formato_id`, `tipo_id`, `condicion`, `fecha_creado`) VALUES
(1, 6, 10, 'xxxxxx', '2013-11-24 15:55:36'),
(9, 6, 11, 'xxxxxxx', '2013-11-24 16:58:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductor`
--

CREATE TABLE IF NOT EXISTS `conductor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pais` bigint(20) NOT NULL,
  `numero_licencia` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `numero_libreta_tripulante` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `claseLicencia` bigint(20) DEFAULT NULL,
  `usuario_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D5F7F18ADB38439E` (`usuario_id`),
  KEY `IDX_D5F7F18AAB894D27` (`claseLicencia`),
  KEY `IDX_D5F7F18A7E5D2EFF` (`pais`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `conductor`
--

INSERT INTO `conductor` (`id`, `pais`, `numero_licencia`, `numero_libreta_tripulante`, `claseLicencia`, `usuario_id`) VALUES
(1, 12, '22928178', '', NULL, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenedor`
--

CREATE TABLE IF NOT EXISTS `contenedor` (
  `id` bigint(20) NOT NULL,
  `num` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` decimal(4,2) NOT NULL,
  `sigla_numero` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenedor_mercancia_formato`
--

CREATE TABLE IF NOT EXISTS `contenedor_mercancia_formato` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formato` bigint(20) NOT NULL,
  `mercancia` bigint(20) DEFAULT NULL,
  `contenedor` bigint(20) DEFAULT NULL,
  `bulto` bigint(20) NOT NULL,
  `peso_bruto` decimal(10,4) DEFAULT NULL,
  `peso_neto` decimal(10,4) DEFAULT NULL,
  `volumen` decimal(10,4) DEFAULT NULL,
  `fechaCreado` datetime NOT NULL,
  `numero_bultos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volumenOtro` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84773C019BDE673` (`formato`),
  KEY `IDX_84773C09D094AE0` (`mercancia`),
  KEY `IDX_84773C0E6B58BB1` (`contenedor`),
  KEY `IDX_84773C0AEA271E1` (`bulto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `contenedor_mercancia_formato`
--

INSERT INTO `contenedor_mercancia_formato` (`id`, `formato`, `mercancia`, `contenedor`, `bulto`, `peso_bruto`, `peso_neto`, `volumen`, `fechaCreado`, `numero_bultos`, `volumenOtro`) VALUES
(1, 6, 1, NULL, 1, 16.5000, 14.3400, NULL, '2013-11-16 04:25:13', '1723', NULL),
(3, 8, 3, NULL, 1, 4425.0800, 900.0000, 0.0000, '2013-11-29 14:39:32', '20', NULL),
(4, 9, 4, NULL, 1, 120.0010, 120.0000, NULL, '2013-11-29 16:25:19', '10', NULL),
(7, 9, 6, NULL, 2, 50.0009, 45.0090, NULL, '2013-12-07 12:55:37', '20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_mercancias_formato`
--

CREATE TABLE IF NOT EXISTS `datos_mercancias_formato` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formato_id` bigint(20) NOT NULL,
  `lugar_id` bigint(20) DEFAULT NULL,
  `tipo_id` bigint(20) NOT NULL,
  `fecha_creado` datetime NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D7494848D02887B` (`formato_id`),
  KEY `IDX_9D749484B5A3803B` (`lugar_id`),
  KEY `IDX_9D749484A9276E6C` (`tipo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `datos_mercancias_formato`
--

INSERT INTO `datos_mercancias_formato` (`id`, `formato_id`, `lugar_id`, `tipo_id`, `fecha_creado`, `fecha`) VALUES
(1, 6, 5, 7, '2013-11-21 17:36:24', '2013-02-25 17:36:24'),
(2, 6, 5, 9, '2013-11-21 18:10:12', '2013-02-25 18:10:12'),
(3, 6, 4, 8, '2013-11-21 18:15:16', '1969-12-31 19:00:00'),
(4, 6, 4, 13, '2013-11-25 23:47:38', '2013-02-25 23:47:38'),
(5, 9, 6, 7, '2013-11-29 16:37:39', '2013-12-08 16:18:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE IF NOT EXISTS `documento` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formato` bigint(20) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `url` varchar(140) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6B12EC719BDE673` (`formato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE IF NOT EXISTS `entidad` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `certificado_idoneidad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario_id` bigint(20) DEFAULT NULL,
  `lugar_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4587B0CBDB38439E` (`usuario_id`),
  KEY `IDX_4587B0CBB5A3803B` (`lugar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `entidad`
--

INSERT INTO `entidad` (`id`, `certificado_idoneidad`, `usuario_id`, `lugar_id`) VALUES
(1, '123456', 1, NULL),
(2, 'CI-CO-215-04', 15, 4),
(3, NULL, 17, 6),
(4, NULL, 18, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato`
--

CREATE TABLE IF NOT EXISTS `formato` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo` bigint(20) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `completo` tinyint(1) NOT NULL,
  `numero` int(11) NOT NULL,
  `padre` bigint(20) DEFAULT NULL,
  `id_transportista` bigint(20) DEFAULT NULL,
  `incoterm` bigint(20) DEFAULT NULL,
  `instrucciones` longtext COLLATE utf8_unicode_ci,
  `observaciones` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_19BDE673702D1D47` (`tipo`),
  KEY `IDX_19BDE673D3656AEB` (`padre`),
  KEY `id_transportista` (`id_transportista`),
  KEY `IDX_19BDE6736046F6B8` (`incoterm`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `formato`
--

INSERT INTO `formato` (`id`, `tipo`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `completo`, `numero`, `padre`, `id_transportista`, `incoterm`, `instrucciones`, `observaciones`) VALUES
(1, 1, 'Manifiesto de Carga Internacional', 'manifiesto-de-carga-internacional', 'Formato para almacenar el Manifiesto de Carga Internacional 1', '2013-11-03 20:05:20', 0, 6, NULL, 2, NULL, NULL, NULL),
(2, 1, 'Manifiesto de Carga Internacional 2', 'manifiesto-de-carga-internacional-2', '', '2013-11-08 08:02:00', 0, 5, NULL, NULL, NULL, NULL, NULL),
(6, 2, 'Carta de Porte Internacional por Carretera de ', 'carta-de-porte-internacional-por-carretera-de-', NULL, '2013-11-16 04:25:13', 0, 55149, 1, 2, 4, 'Mercancía con destino a Bodegas de Suppla en Cúcuta', NULL),
(8, 2, 'Carta de Porte Internacional por Carretera de', 'carta-de-porte-internacional-por-carretera-de', NULL, '2013-11-29 14:39:31', 0, 55150, 1, 2, NULL, NULL, NULL),
(9, 2, 'Carta de Porte Internacional por Carretera de', 'carta-de-porte-internacional-por-carretera-de', NULL, '2013-11-29 16:25:19', 0, 876, 1, 2, 4, 'Instrucciones', NULL),
(10, 2, 'Carta de Porte Internacional por Carretera 6', 'carta-de-porte-internacional-por-carretera-6', NULL, '2013-12-11 00:16:11', 0, 123456, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'Manifiesto de Carga Internacional 7', 'manifiesto-de-carga-internacional-7', NULL, '2013-12-11 00:19:31', 0, 1234567, NULL, NULL, NULL, NULL, NULL),
(12, 1, 'Manifiesto de Carga Internacional 8', 'manifiesto-de-carga-internacional-8', NULL, '2013-12-11 00:24:26', 0, 12345678, NULL, NULL, NULL, NULL, NULL),
(13, 1, 'Manifiesto de Carga Internacional 9', 'manifiesto-de-carga-internacional-9', NULL, '2013-12-11 00:25:19', 0, 123456789, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_aduana`
--

CREATE TABLE IF NOT EXISTS `formato_aduana` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aduana` bigint(20) NOT NULL,
  `formato` bigint(20) NOT NULL,
  `nivel` bigint(20) NOT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EB0F4B95CAE74A8F` (`aduana`),
  KEY `IDX_EB0F4B9519BDE673` (`formato`),
  KEY `IDX_EB0F4B95AAFC20CB` (`nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_conductor`
--

CREATE TABLE IF NOT EXISTS `formato_conductor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formato` bigint(20) NOT NULL,
  `conductor` bigint(20) DEFAULT NULL,
  `vehiculo` bigint(20) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL,
  `auxiliar` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A3B779C619BDE673` (`formato`),
  KEY `IDX_A3B779C6D5F7F18A` (`conductor`),
  KEY `IDX_A3B779C6C9FA1603` (`vehiculo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `formato_conductor`
--

INSERT INTO `formato_conductor` (`id`, `formato`, `conductor`, `vehiculo`, `fecha_creado`, `auxiliar`) VALUES
(1, 1, 1, 1, '2013-11-15 10:26:20', 0),
(2, 2, NULL, 1, '2013-12-09 01:08:03', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_usuario`
--

CREATE TABLE IF NOT EXISTS `formato_usuario` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario` bigint(20) NOT NULL,
  `formato` bigint(20) NOT NULL,
  `rol` bigint(20) NOT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DF26A1262265B05D` (`usuario`),
  KEY `IDX_DF26A12619BDE673` (`formato`),
  KEY `IDX_DF26A126E553F37` (`rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `formato_usuario`
--

INSERT INTO `formato_usuario` (`id`, `usuario`, `formato`, `rol`, `fecha_creado`) VALUES
(1, 1, 1, 1, '2013-11-03 20:05:49'),
(2, 15, 1, 3, '2013-11-14 16:44:28'),
(8, 17, 6, 4, '2013-11-26 19:54:18'),
(9, 18, 6, 1, '2013-11-27 00:27:14'),
(10, 17, 6, 2, '2013-11-27 00:27:17'),
(11, 17, 6, 5, '2013-11-27 01:17:17'),
(12, 18, 9, 5, '2013-11-29 16:37:44'),
(13, 17, 9, 1, '2013-11-29 16:41:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_grupo`
--

CREATE TABLE IF NOT EXISTS `fos_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `docente_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AACF42CD5E237E06` (`name`),
  KEY `IDX_AACF42CD94E27525` (`docente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `fos_grupo`
--

INSERT INTO `fos_grupo` (`id`, `name`, `roles`, `docente_id`) VALUES
(1, 'Grupo 1', 'a:0:{}', NULL),
(2, 'Grupo 2', 'a:0:{}', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479DB38439E` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `fos_user`
--

INSERT INTO `fos_user` (`id`, `usuario_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 1, 'usuario0', 'usuario0', 'fray959@gmail.com', 'fray959@gmail.com', 1, '91cn3ecvlucc88gw4woogk0k0o0kwo0', 'a2HVU4d8+9n61GzXEh1PY4VLkeuIA0vAB6bfwPaR/bQodezImj+nVea7iSogkUvER60OCQAGWijUe1e1DIVtjQ==', '2014-02-16 22:17:25', 0, 0, NULL, NULL, NULL, 'a:3:{i:0;s:16:"ROLE_SUPER_ADMIN";i:1;s:15:"ROLE_ESTUDIANTE";i:2;s:12:"ROLE_DOCENTE";}', 0, NULL),
(2, 19, 'Estudiante 1', 'estudiante 1', 'email1@email.com', 'email1@email.com', 1, '3e23ibls34is8csgo4wggoo8o8s4ggs', 'ETipl9CrEco+MRoSC89T9TmxWUYIe+ANvnddzuPUDKG4B6fHmWOt+bOp84NZopaNh/ZRjDJ1cGgNdNeXwwUy4w==', '2013-11-29 15:19:32', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user_group`
--

CREATE TABLE IF NOT EXISTS `fos_user_group` (
  `usuario_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`grupo_id`),
  KEY `IDX_583D1F3EDB38439E` (`usuario_id`),
  KEY `IDX_583D1F3E9C833003` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `fos_user_group`
--

INSERT INTO `fos_user_group` (`usuario_id`, `grupo_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto`
--

CREATE TABLE IF NOT EXISTS `gasto` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario` bigint(20) DEFAULT NULL,
  `formato` bigint(20) NOT NULL,
  `fecha_creado` datetime NOT NULL,
  `moneda` bigint(20) DEFAULT NULL,
  `rol_usuario` bigint(20) DEFAULT NULL,
  `valor` decimal(10,4) NOT NULL,
  `concepto` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AE43DA142265B05D` (`usuario`),
  KEY `IDX_AE43DA1419BDE673` (`formato`),
  KEY `IDX_AE43DA14B00B2B2D` (`moneda`),
  KEY `IDX_AE43DA14648388D0` (`concepto`),
  KEY `IDX_AE43DA14647DF9DA` (`rol_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `gasto`
--

INSERT INTO `gasto` (`id`, `usuario`, `formato`, `fecha_creado`, `moneda`, `rol_usuario`, `valor`, `concepto`) VALUES
(1, NULL, 6, '2013-11-25 18:42:13', 3, NULL, 9959.2800, 12),
(2, 18, 6, '2013-11-26 00:22:13', 3, 1, 0.0000, 14),
(3, 17, 6, '2013-11-27 14:03:43', 3, 2, 150.0000, 14),
(4, 17, 6, '2013-11-27 18:51:14', 3, 2, 199.8000, 16),
(5, 18, 6, '2013-11-27 18:52:15', 3, 1, 0.0000, 15),
(6, 17, 6, '2013-11-27 18:52:18', 3, 2, 0.0000, 15),
(7, 18, 6, '2013-11-27 18:52:50', 3, 1, 0.0000, 16),
(8, NULL, 9, '2013-11-29 16:39:20', 3, NULL, 150.0000, 12),
(9, 17, 9, '2013-12-08 13:06:13', 3, 1, 400.0000, 14),
(10, NULL, 9, '2013-12-08 13:06:55', 3, 2, 900.0000, 14),
(11, NULL, 9, '2013-12-08 13:07:24', 3, 2, 100.0000, 15),
(12, 17, 9, '2013-12-08 13:07:33', 3, 1, 400.0000, 15),
(13, NULL, 9, '2013-12-08 13:43:22', 3, 2, 90.0000, 16),
(14, 17, 9, '2013-12-08 13:43:25', 3, 1, 200.3500, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incoterm`
--

CREATE TABLE IF NOT EXISTS `incoterm` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `sigla` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `categoria` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `anio` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `incoterm`
--

INSERT INTO `incoterm` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `sigla`, `categoria`, `anio`) VALUES
(1, 'Ex Works', 'ex-works', 'El vendedor pone las mercancías a disposición del comprador en los propios locales del vendedor; esto es, una entrega directa a la salida.', '2013-11-25 10:47:26', 'EXW', 'E', 2010),
(2, 'Free Alongside Ship', 'free-alongside-ship', 'El vendedor entrega la mercancía en el muelle pactado del puerto de carga convenido; esto es, al lado del barco. El incoterm FAS es propio de mercancías de carga a granel o de carga voluminosa porque se depositan en terminales del puerto especializadas, que están situadas en el muelle.\r\nEl vendedor es responsable de las gestiones y costes de la aduana de exportación (en las versiones anteriores a Incoterms 2000, el comprador organizaba el despacho aduanero de exportación).\r\nEl incoterm FAS sólo se utiliza para transporte en barco, ya sea marítimo o fluvial.', '2013-11-25 10:49:30', 'FAS', 'F', 2010),
(3, 'Free On Board', 'free-on-board', 'El vendedor entrega la mercancía sobre el buque. El comprador se hace cargo de designar y reservar el transporte principal (buque)\r\nEl incoterm FOB es uno de los más usados en el comercio internacional. Se debe utilizar para carga general (bidones, bobinas, contenedores, etc.) de mercancías, no utilizable para granel.\r\nEl incoterm FOB se utiliza exclusivamente para transporte en barco, ya sea marítimo o fluvial.', '2013-11-25 10:50:05', 'FOB', 'F', 2010),
(4, 'Free Carrier', 'free-carrier', 'El vendedor se compromete a entregar la mercancía en un punto acordado dentro del país de origen, que pueden ser los locales de un transitario, una estación ferroviaria... (este lugar convenido para entregar la mercancía suele estar relacionado con los espacios del transportista). Se hace cargo de los costes hasta que la mercancía está situada en ese punto convenido; entre otros, la aduana en el país de origen.\r\nEl incoterm FCA se puede utilizar con cualquier tipo de transporte: transporte aéreo, ferroviario, por carretera y en contenedores/transporte multimodal. Sin embargo, es un incoterm poco usado.', '2013-11-25 22:12:07', 'FCA', 'F', 2010);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE IF NOT EXISTS `lugar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pais` bigint(20) DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4974AAAC7E5D2EFF` (`pais`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`id`, `pais`, `nombre`, `canonical`, `descripcion`, `fecha_creado`) VALUES
(4, 7, 'Cúcuta', 'cucuta', NULL, '2013-11-14 16:44:28'),
(5, 12, 'Ureña', 'urena', NULL, '2013-11-15 18:28:39'),
(6, 7, 'Bogotá', 'bogota', NULL, '2013-11-17 20:22:50'),
(7, 7, 'Medellín', 'medellin', NULL, '2013-11-29 16:47:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mercancia`
--

CREATE TABLE IF NOT EXISTS `mercancia` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `mercancia`
--

INSERT INTO `mercancia` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`) VALUES
(1, NULL, NULL, 'Articulos de Vidrio Ref. Varias: Vaso Whisky, Copa Coctel, Copa Champañera, Copa Vino, Jarra para Agua, Ref. Varias', '2013-11-16 04:23:55'),
(2, NULL, NULL, 'Fibra Acrílica 3,3 / 25mm DTEX Bright', '2013-11-29 14:04:06'),
(3, NULL, NULL, 'Fibra Acrílica 3.3 / 25mm DTEX Bright', '2013-11-29 14:39:31'),
(4, NULL, NULL, 'Fila de Prueba', '2013-11-29 16:25:19'),
(6, NULL, NULL, 'Fila de Prueba 3', '2013-12-07 11:49:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE IF NOT EXISTS `moneda` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `abreviacion` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `abreviacion`) VALUES
(1, 'Peso Colombiano', 'peso-colombiano', 'Peso Colombiano', '2013-11-25 18:36:36', 'COP'),
(2, 'Unidad de Valor Real Colombiana', 'unidad-de-valor-real-colombiana', 'Unidad de valor real colombiana (añadida al COP)', '2013-11-25 18:37:16', 'COU'),
(3, 'Dólar Estadounidense', 'dolar-estadounidense', 'Dólar Estadounidense', '2013-11-25 18:37:51', 'USD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `nacionalidad` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `nacionalidad`) VALUES
(7, 'Colombia', 'colombia', NULL, '2013-11-14 16:44:28', 'Colombiana'),
(12, 'Venezuela', 'venezuela', NULL, '2013-11-15 10:26:20', 'Venezolana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_presenta_servicio`
--

CREATE TABLE IF NOT EXISTS `permiso_presenta_servicio` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `permiso_presenta_servicio`
--

INSERT INTO `permiso_presenta_servicio` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`) VALUES
(1, 'PPS-VE-0108-09', 'pps-ve-0108-09', NULL, '2013-11-14 18:50:01'),
(3, 'PPS-EC-1010-09', 'pps-ec-1010-09', NULL, '2013-11-14 22:03:26'),
(4, 'este', 'este', NULL, '2013-11-14 23:08:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_presenta_servicio_entidad`
--

CREATE TABLE IF NOT EXISTS `permiso_presenta_servicio_entidad` (
  `entidad` bigint(20) NOT NULL,
  `permiso_presenta_servicio` bigint(20) NOT NULL,
  PRIMARY KEY (`entidad`,`permiso_presenta_servicio`),
  KEY `IDX_5E47AA3D4587B0CB` (`entidad`),
  KEY `IDX_5E47AA3D58E15D14` (`permiso_presenta_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permiso_presenta_servicio_entidad`
--

INSERT INTO `permiso_presenta_servicio_entidad` (`entidad`, `permiso_presenta_servicio`) VALUES
(2, 1),
(2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `_aplicable_a` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `_aplicable_a`) VALUES
(1, 'Remitente', 'remitente', 'Rol Remitente de la Entidad', '2013-11-03 19:42:44', 'FormatoUsuario'),
(2, 'Destinatario', 'destinatario', 'Rol Destinatario de la Entidad', '2013-11-03 19:42:44', 'FormatoUsuario'),
(3, 'Transportista', 'transportista', NULL, '2013-11-03 19:42:44', 'FormatoUsuario'),
(4, 'Consignatario', 'consignatario', NULL, '2013-11-03 19:42:44', 'FormatoUsuario'),
(5, 'Notificado', 'notificado', NULL, '2013-11-03 19:42:55', 'FormatoUsuario'),
(6, 'Estudiante', 'estudiante', NULL, '2013-11-04 12:27:47', 'Usuario'),
(7, 'Docente', 'docente', NULL, '2013-11-04 12:27:47', 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE IF NOT EXISTS `rol_usuario` (
  `usuario_id` bigint(20) NOT NULL,
  `rol_id` bigint(20) NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`),
  KEY `IDX_647DF9DADB38439E` (`usuario_id`),
  KEY `IDX_647DF9DA4BAB96C` (`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`usuario_id`, `rol_id`) VALUES
(1, 6),
(1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `_aplicable_a` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abreviacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `_aplicable_a`, `abreviacion`) VALUES
(1, 'Manifiesto de Carga Internacional', 'manifiesto-de-carga-internacional', 'Formato de tipo Manifiesto de Carga Internacional', '2013-11-03 20:04:20', 'Formato', 'mci'),
(2, 'Carta de Porte Internacional por Carretera', 'carta-de-porte-internacional-por-carretera', 'Formato de tipo Carta de Porte Internacional', '2013-11-03 20:04:20', 'Formato', 'cpic'),
(3, 'Peligrosa', 'peligrosa', 'Naturaleza Peligrosa de la Carga', '2013-11-15 19:02:00', 'Carga', 'peligro'),
(4, 'Sustancias Químicas o Precursoras', 'sustancias-quimicas-o-precursoras', 'Naturaleza Química de la Carga', '2013-11-15 19:03:14', 'Carga', 'sustancia quimica'),
(5, 'Perecibles', 'perecibles', 'Naturaleza Perecible de la Carga', '2013-11-15 19:03:43', 'Carga', 'perecible'),
(6, 'Fácil Manejo', 'facil-manejo', NULL, '2013-11-15 19:18:48', 'Carga', 'fácil manejo'),
(7, 'Recibe', 'recibe', 'Datos en que el transportista recibe las mercancías', '2013-11-21 00:00:00', 'datosMercancias', 'recibe'),
(8, 'Entrega', 'entrega', 'Datos convenidos para la Entrega de las mercancías', '2013-11-21 00:00:00', 'datosMercancias', 'entrega'),
(9, 'Embarque', 'embarque', 'Datos Embarque de las mercancías', '2013-11-21 00:00:00', 'datosMercancias', 'embarque'),
(10, 'Transporte', 'transporte', 'Tipo de Condición', '2013-11-24 14:57:21', 'Condicion', 'transp.'),
(11, 'Pago', 'pago', 'Tipo de Condición', '2013-11-24 14:57:21', 'Condicion', 'pago'),
(12, 'Mercancia', 'mercancia', NULL, '2013-11-25 18:31:52', 'Gasto', 'Mercancia'),
(13, 'Emisión', 'emision', 'Datos Emisión del Formato', '2013-11-21 00:00:00', 'datosMercancias', 'emisión'),
(14, 'Valor Del Flete', 'valor-del-flete', NULL, '2013-11-26 00:20:18', 'Gasto', 'Valor Del Flete'),
(15, 'Otros Gastos Suplementarios', 'otros-gastos-suplementarios', NULL, '2013-11-27 18:35:51', 'Gasto', 'Otros Gastos Suplementarios'),
(16, 'Seguro', 'seguro', NULL, '2013-11-27 18:47:51', 'Gasto', 'Seguro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_carga`
--

CREATE TABLE IF NOT EXISTS `unidad_carga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pais` bigint(20) NOT NULL,
  `marca` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `anio_fabrica` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `placa` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6DF78D3D7E5D2EFF` (`pais`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `unidad_carga`
--

INSERT INTO `unidad_carga` (`id`, `pais`, `marca`, `anio_fabrica`, `placa`, `fecha_creado`) VALUES
(1, 12, 'Bateas JM', '2007', '55N-SAL', '2013-11-15 13:42:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `direccion` longtext COLLATE utf8_unicode_ci,
  `telefono` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doc_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_doc_id` bigint(20) DEFAULT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2265B05D1CEFBEA4` (`tipo_doc_id`),
  KEY `IDX_2265B05D9C833003` (`grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `direccion`, `telefono`, `doc_id`, `tipo_doc_id`, `apellido`, `grupo_id`) VALUES
(1, 'Usuario 0', 'usuario-0', 'Usuario Super-Administrador', '2013-11-03 02:23:54', NULL, NULL, '1524857521', NULL, NULL, NULL),
(15, 'Transporte Carvajal Internacional y Cia. Ltda.', 'transporte-carvajal-internacional-y-cia.-ltda.', NULL, '2013-11-14 16:44:28', 'Av. 6N° 18N 42-46 Zona Industrial detrás del ICA', '5791461', '807.009.216-2', NULL, NULL, NULL),
(16, 'Victor', 'victor', NULL, '2013-11-15 17:38:47', NULL, NULL, '22.928.178', NULL, 'Perez', NULL),
(17, 'Aluminio Recor SAS', 'aluminio-recor-sas', NULL, '2013-11-17 19:36:58', 'CRR 21 N° 164-74 Toberín', NULL, '830.035.141-2', NULL, NULL, NULL),
(18, 'Materiales la Castellana IIC.A.', 'materiales-la-castellana-iic.a.', NULL, '2013-11-25 23:40:20', 'Cll 2 con Carr 3 y 4 # 3-27 Of. 3 B. Plaza Vieja', NULL, '123456-2', NULL, NULL, NULL),
(19, 'Estudiante 1', 'estudiante-1', 'Estudiante 1', '2013-11-29 15:26:20', NULL, NULL, '99991', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE IF NOT EXISTS `vehiculo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pais` bigint(20) NOT NULL,
  `marca` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `anio_fabrica` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `placa` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creado` datetime NOT NULL,
  `num_serie_chasis` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `certifica_habilita` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C9FA16037E5D2EFF` (`pais`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id`, `pais`, `marca`, `anio_fabrica`, `placa`, `fecha_creado`, `num_serie_chasis`, `certifica_habilita`) VALUES
(1, 12, 'Internacional', '1997', '54D-GAI', '2013-11-15 10:26:20', '1HTSHAAR2VH474998', 'CO-0919-12');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aduana`
--
ALTER TABLE `aduana`
  ADD CONSTRAINT `FK_CAE74A8F4974AAAC` FOREIGN KEY (`lugar`) REFERENCES `lugar` (`id`);

--
-- Filtros para la tabla `carga`
--
ALTER TABLE `carga`
  ADD CONSTRAINT `FK_DC567A7619BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_DC567A765862802E` FOREIGN KEY (`lugar_descarga`) REFERENCES `lugar` (`id`),
  ADD CONSTRAINT `FK_DC567A76993141CC` FOREIGN KEY (`lugar_carga`) REFERENCES `lugar` (`id`),
  ADD CONSTRAINT `FK_DC567A76C3C7DA41` FOREIGN KEY (`naturaleza`) REFERENCES `tipo` (`id`);

--
-- Filtros para la tabla `carga_unidad_carga`
--
ALTER TABLE `carga_unidad_carga`
  ADD CONSTRAINT `FK_36E65DF832D33B46` FOREIGN KEY (`id_carga`) REFERENCES `carga` (`id`),
  ADD CONSTRAINT `FK_36E65DF84E36F84F` FOREIGN KEY (`id_unidad_carga`) REFERENCES `unidad_carga` (`id`);

--
-- Filtros para la tabla `condicion`
--
ALTER TABLE `condicion`
  ADD CONSTRAINT `FK_7018E7658D02887B` FOREIGN KEY (`formato_id`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_7018E765A9276E6C` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`);

--
-- Filtros para la tabla `conductor`
--
ALTER TABLE `conductor`
  ADD CONSTRAINT `FK_D5F7F18A7E5D2EFF` FOREIGN KEY (`pais`) REFERENCES `pais` (`id`),
  ADD CONSTRAINT `FK_D5F7F18AAB894D27` FOREIGN KEY (`claseLicencia`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `FK_D5F7F18ADB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `contenedor_mercancia_formato`
--
ALTER TABLE `contenedor_mercancia_formato`
  ADD CONSTRAINT `FK_84773C019BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_84773C09D094AE0` FOREIGN KEY (`mercancia`) REFERENCES `mercancia` (`id`),
  ADD CONSTRAINT `FK_84773C0AEA271E1` FOREIGN KEY (`bulto`) REFERENCES `bulto` (`id`),
  ADD CONSTRAINT `FK_84773C0E6B58BB1` FOREIGN KEY (`contenedor`) REFERENCES `contenedor` (`id`);

--
-- Filtros para la tabla `datos_mercancias_formato`
--
ALTER TABLE `datos_mercancias_formato`
  ADD CONSTRAINT `FK_9D7494848D02887B` FOREIGN KEY (`formato_id`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_9D749484A9276E6C` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `FK_9D749484B5A3803B` FOREIGN KEY (`lugar_id`) REFERENCES `lugar` (`id`);

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `FK_B6B12EC719BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`);

--
-- Filtros para la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD CONSTRAINT `FK_4587B0CBB5A3803B` FOREIGN KEY (`lugar_id`) REFERENCES `lugar` (`id`),
  ADD CONSTRAINT `FK_4587B0CBDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `formato`
--
ALTER TABLE `formato`
  ADD CONSTRAINT `FK_19BDE6736046F6B8` FOREIGN KEY (`incoterm`) REFERENCES `incoterm` (`id`),
  ADD CONSTRAINT `FK_19BDE6736E53D850` FOREIGN KEY (`id_transportista`) REFERENCES `entidad` (`id`),
  ADD CONSTRAINT `FK_19BDE673702D1D47` FOREIGN KEY (`tipo`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `FK_19BDE673D3656AEB` FOREIGN KEY (`padre`) REFERENCES `formato` (`id`);

--
-- Filtros para la tabla `formato_aduana`
--
ALTER TABLE `formato_aduana`
  ADD CONSTRAINT `FK_EB0F4B9519BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_EB0F4B95AAFC20CB` FOREIGN KEY (`nivel`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `FK_EB0F4B95CAE74A8F` FOREIGN KEY (`aduana`) REFERENCES `aduana` (`id`);

--
-- Filtros para la tabla `formato_conductor`
--
ALTER TABLE `formato_conductor`
  ADD CONSTRAINT `FK_A3B779C619BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_A3B779C6C9FA1603` FOREIGN KEY (`vehiculo`) REFERENCES `vehiculo` (`id`),
  ADD CONSTRAINT `FK_A3B779C6D5F7F18A` FOREIGN KEY (`conductor`) REFERENCES `conductor` (`id`);

--
-- Filtros para la tabla `formato_usuario`
--
ALTER TABLE `formato_usuario`
  ADD CONSTRAINT `FK_DF26A12619BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_DF26A1262265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_DF26A126E553F37` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`);

--
-- Filtros para la tabla `fos_grupo`
--
ALTER TABLE `fos_grupo`
  ADD CONSTRAINT `FK_AACF42CD94E27525` FOREIGN KEY (`docente_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `fos_user`
--
ALTER TABLE `fos_user`
  ADD CONSTRAINT `FK_957A6479DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `fos_user_group`
--
ALTER TABLE `fos_user_group`
  ADD CONSTRAINT `FK_583D1F3E9C833003` FOREIGN KEY (`grupo_id`) REFERENCES `fos_grupo` (`id`),
  ADD CONSTRAINT `FK_583D1F3EDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `fos_user` (`id`);

--
-- Filtros para la tabla `gasto`
--
ALTER TABLE `gasto`
  ADD CONSTRAINT `FK_AE43DA1419BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_AE43DA142265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_AE43DA14647DF9DA` FOREIGN KEY (`rol_usuario`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `FK_AE43DA14648388D0` FOREIGN KEY (`concepto`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `FK_AE43DA14B00B2B2D` FOREIGN KEY (`moneda`) REFERENCES `moneda` (`id`);

--
-- Filtros para la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD CONSTRAINT `FK_4974AAAC7E5D2EFF` FOREIGN KEY (`pais`) REFERENCES `pais` (`id`);

--
-- Filtros para la tabla `permiso_presenta_servicio_entidad`
--
ALTER TABLE `permiso_presenta_servicio_entidad`
  ADD CONSTRAINT `FK_5E47AA3D4587B0CB` FOREIGN KEY (`entidad`) REFERENCES `entidad` (`id`),
  ADD CONSTRAINT `FK_5E47AA3D58E15D14` FOREIGN KEY (`permiso_presenta_servicio`) REFERENCES `permiso_presenta_servicio` (`id`);

--
-- Filtros para la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD CONSTRAINT `FK_647DF9DA4BAB96C` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `FK_647DF9DADB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `unidad_carga`
--
ALTER TABLE `unidad_carga`
  ADD CONSTRAINT `FK_6DF78D3D7E5D2EFF` FOREIGN KEY (`pais`) REFERENCES `pais` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_2265B05D1CEFBEA4` FOREIGN KEY (`tipo_doc_id`) REFERENCES `tipo` (`id`),
  ADD CONSTRAINT `FK_2265B05D9C833003` FOREIGN KEY (`grupo_id`) REFERENCES `fos_grupo` (`id`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `FK_C9FA16037E5D2EFF` FOREIGN KEY (`pais`) REFERENCES `pais` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
