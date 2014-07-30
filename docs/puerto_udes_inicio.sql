-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-07-2014 a las 08:47:15
-- Versión del servidor: 5.5.38-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `puerto_udes_inicio`
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
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fechaCreado` datetime NOT NULL,
  `marca` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clase` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga`
--

CREATE TABLE IF NOT EXISTS `carga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `naturaleza` bigint(20) DEFAULT NULL,
  `formato` bigint(20) NOT NULL,
  `lugar_carga` bigint(20) DEFAULT NULL,
  `lugar_descarga` bigint(20) DEFAULT NULL,
  `num_precintos` int(11) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DC567A76C3C7DA41` (`naturaleza`),
  KEY `IDX_DC567A7619BDE673` (`formato`),
  KEY `IDX_DC567A76993141CC` (`lugar_carga`),
  KEY `IDX_DC567A765862802E` (`lugar_descarga`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductor`
--

CREATE TABLE IF NOT EXISTS `conductor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint(20) DEFAULT NULL,
  `pais` bigint(20) NOT NULL,
  `numero_licencia` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `numero_libreta_tripulante` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `claseLicencia` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D5F7F18ADB38439E` (`usuario_id`),
  KEY `IDX_D5F7F18AAB894D27` (`claseLicencia`),
  KEY `IDX_D5F7F18A7E5D2EFF` (`pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenedor`
--

CREATE TABLE IF NOT EXISTS `contenedor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `num` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` decimal(10,2) NOT NULL,
  `sigla_numero` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  `volumenOtro` decimal(10,4) DEFAULT NULL,
  `fechaCreado` datetime NOT NULL,
  `numero_bultos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84773C019BDE673` (`formato`),
  KEY `IDX_84773C09D094AE0` (`mercancia`),
  KEY `IDX_84773C0E6B58BB1` (`contenedor`),
  KEY `IDX_84773C0AEA271E1` (`bulto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_mercancias_formato`
--

CREATE TABLE IF NOT EXISTS `datos_mercancias_formato` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formato_id` bigint(20) NOT NULL,
  `lugar_id` bigint(20) DEFAULT NULL,
  `tipo_id` bigint(20) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D7494848D02887B` (`formato_id`),
  KEY `IDX_9D749484B5A3803B` (`lugar_id`),
  KEY `IDX_9D749484A9276E6C` (`tipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  `usuario_id` bigint(20) DEFAULT NULL,
  `lugar_id` bigint(20) DEFAULT NULL,
  `certificado_idoneidad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4587B0CBDB38439E` (`usuario_id`),
  KEY `IDX_4587B0CBB5A3803B` (`lugar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato`
--

CREATE TABLE IF NOT EXISTS `formato` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_transportista` bigint(20) DEFAULT NULL,
  `padre` bigint(20) DEFAULT NULL,
  `tipo` bigint(20) NOT NULL,
  `incoterm` bigint(20) DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `completo` tinyint(1) NOT NULL,
  `numero` int(11) NOT NULL,
  `instrucciones` longtext COLLATE utf8_unicode_ci,
  `observaciones` longtext COLLATE utf8_unicode_ci,
  `fecha_emision` datetime NOT NULL,
  `autor` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_19BDE6736E53D850` (`id_transportista`),
  KEY `IDX_19BDE673D3656AEB` (`padre`),
  KEY `IDX_19BDE673702D1D47` (`tipo`),
  KEY `IDX_19BDE6736046F6B8` (`incoterm`),
  KEY `IDX_19BDE67331075EBA` (`autor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  KEY `IDX_738C8C0619BDE673` (`formato`),
  KEY `IDX_738C8C06D5F7F18A` (`conductor`),
  KEY `IDX_738C8C06C9FA1603` (`vehiculo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `fos_user`
--

INSERT INTO `fos_user` (`id`, `usuario_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 1, 'usuario0', 'usuario0', 'usuario0@email.com', 'usuario0@email.com', 1, 'b7nn6z5zcxwkkwkc0soo4w4004kg88o', 'm8I8WntZUI/84JlK5VB2in0A4nw13YAiZ9W0OIqIz6J0thRdRSjjgKgSIcMKo6mZ9fMgacQyUm7Z2PTdWjHu8w==', '2014-03-13 15:35:41', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto`
--

CREATE TABLE IF NOT EXISTS `gasto` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario` bigint(20) DEFAULT NULL,
  `rol_usuario` bigint(20) DEFAULT NULL,
  `formato` bigint(20) NOT NULL,
  `concepto` bigint(20) NOT NULL,
  `moneda` bigint(20) DEFAULT NULL,
  `fecha_creado` datetime NOT NULL,
  `valor` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AE43DA142265B05D` (`usuario`),
  KEY `IDX_AE43DA14647DF9DA` (`rol_usuario`),
  KEY `IDX_AE43DA1419BDE673` (`formato`),
  KEY `IDX_AE43DA14648388D0` (`concepto`),
  KEY `IDX_AE43DA14B00B2B2D` (`moneda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `docente_id` bigint(20) DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8C0E9BD394E27525` (`docente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `incoterm`
--

INSERT INTO `incoterm` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `sigla`, `categoria`, `anio`) VALUES
(1, 'Free Carrier (named place) → ‘Libre transportista (lugar convenido)’', 'free-carrier-(named-place)-r-rlibre-transportista-(lugar-convenido)r', 'El vendedor se compromete a entregar la mercancía en un punto acordado dentro del país de origen, que pueden ser los locales de un transitario, una estación ferroviaria... (este lugar convenido para entregar la mercancía suele estar relacionado con los espacios del transportista). Se hace cargo de los costes hasta que la mercancía está situada en ese punto convenido; entre otros, la aduana en el país de origen.\r\nEl incoterm FCA se puede utilizar con cualquier tipo de transporte: transporte aéreo, ferroviario, por carretera y en contenedores/transporte multimodal. Sin embargo, es un incoterm poco usado', '2014-02-21 00:38:51', 'FCA', 'F', 2010),
(2, 'Free On Board (named loading port) → Libre a bordo (puerto de carga convenido)', 'free-on-board-(named-loading-port)-r-libre-a-bordo-(puerto-de-carga-convenido)', 'El vendedor entrega la mercancía sobre el buque. El comprador se hace cargo de designar y reservar el transporte principal (buque)\r\nEl incoterm FOB es uno de los más usados en el comercio internacional. Se debe utilizar para carga general (bidones, bobinas, contenedores, etc.) de mercancías, no utilizable para granel.\r\nEl incoterm FOB se utiliza exclusivamente para transporte en barco, ya sea marítimo o fluvial.', '2014-02-21 00:52:57', 'FOB', 'F', 2010),
(3, 'Free Alongside Ship (named loading port) → Libre al costado del buque (puerto de carga convenido)', 'free-alongside-ship-(named-loading-port)-r-libre-al-costado-del-buque-(puerto-de-carga-convenido)', 'El vendedor entrega la mercancía en el muelle pactado del puerto de carga convenido; esto es, al lado del barco. El incoterm FAS es propio de mercancías de carga a granel o de carga voluminosa porque se depositan en terminales del puerto especializadas, que están situadas en el muelle.\r\nEl vendedor es responsable de las gestiones y costes de la aduana de exportación (en las versiones anteriores a Incoterms 2000, el comprador organizaba el despacho aduanero de exportación).\r\nEl incoterm FAS sólo se utiliza para transporte en barco, ya sea marítimo o fluvial.', '2014-02-21 00:54:26', 'FAS', 'F', 2011);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`id`, `pais`, `nombre`, `canonical`, `descripcion`, `fecha_creado`) VALUES
(1, 3, 'Ureña', 'urena', NULL, '2014-02-20 07:53:50'),
(2, 1, 'Cúcuta', 'cucuta', NULL, '2014-02-20 07:54:03'),
(3, 1, 'Cartagena', 'cartagena', NULL, '2014-02-20 23:13:01'),
(4, 4, 'Quito', 'quito', NULL, '2014-02-20 23:20:37'),
(5, 4, 'Guayaquíl', 'guayaquil', NULL, '2014-02-20 23:34:32'),
(6, 1, 'Pamplona', 'pamplona', NULL, '2014-02-21 00:58:03'),
(7, 3, 'San Antonio', 'san-antonio', NULL, '2014-02-21 00:59:38'),
(8, 1, 'Bogotá', 'bogota', NULL, '2014-02-21 18:38:33');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
(1, 'Pesos Colombianos', 'pesos-colombianos', 'Pesos Colombianos', '2014-02-21 00:22:54', 'COP'),
(2, 'Dólares Norteamericanos', 'dolares-norteamericanos', 'Dólares Norteamericanos', '2014-02-21 00:23:24', 'USD'),
(3, 'Bolívares Fuertes', 'bolivares-fuertes', 'Bolívares Fuertes', '2014-02-21 00:23:48', 'BFs');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `nacionalidad`) VALUES
(1, 'Colombia', 'colombia', NULL, '2014-02-20 07:37:58', 'Colombiano(a)'),
(3, 'Venezuela', 'venezuela', NULL, '2014-02-20 07:53:50', 'Venezolano(a)'),
(4, 'Ecuador', 'ecuador', NULL, '2014-02-20 23:20:37', 'Ecuatoriano(a)');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `_aplicable_a`) VALUES
(1, 'Super Administrador', 'super-administrador', NULL, '2014-02-19 10:56:46', 'Usuario'),
(2, 'Administrador', 'administrador', NULL, '2014-02-19 10:57:03', 'Usuario'),
(3, 'Estudiante', 'estudiante', NULL, '2014-02-19 10:57:11', 'Usuario'),
(4, 'Docente', 'docente', NULL, '2014-02-19 10:57:18', 'Usuario'),
(5, 'Entidad', 'entidad', NULL, '2014-02-19 10:57:25', 'Usuario'),
(6, 'Remitente', 'remitente', NULL, '2014-02-19 10:57:31', 'Usuario'),
(7, 'Destinatario', 'destinatario', NULL, '2014-02-19 10:57:39', 'Usuario'),
(8, 'Transportista', 'transportista', NULL, '2014-02-19 10:57:48', 'Usuario'),
(9, 'Consignatario', 'consignatario', NULL, '2014-02-19 10:57:55', 'Usuario'),
(10, 'Notificado', 'notificado', NULL, '2014-02-19 10:58:02', 'Usuario'),
(11, 'Autor', 'autor', NULL, '2014-02-19 10:58:02', 'Usuario');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `_aplicable_a`, `abreviacion`) VALUES
(3, 'Manifiesto de Carga Internacional', 'manifiesto-de-carga-internacional', NULL, '2014-02-16 22:04:06', 'Formato', 'mci'),
(5, 'Carta de Porte Internacional por Carretera', 'carta-de-porte-internacional-por-carretera', NULL, '2014-02-16 22:53:31', 'Formato', 'cpic'),
(6, 'A1', 'a1', 'Motocicletas con cilindrada hasta 125 c.c.', '2014-02-19 10:44:47', 'Conductor', 'a1'),
(7, 'A2', 'a2', 'Motocicletas, motocicletas y mototriciclos con cilindrada mayor a 125 c.c.', '2014-02-19 10:45:33', 'Conductor', 'a2'),
(8, 'B1', 'b1', 'Automoviles, motocarros, cuatrimotos, camperos, camionetas y microbuses de servicio particular.', '2014-02-19 10:45:54', 'Conductor', 'b1'),
(9, 'B2', 'b2', 'Camiones rigidos, busetas y buses de servicio particular.', '2014-02-19 10:46:14', 'Conductor', 'b2'),
(10, 'B3', 'b3', 'Vehiculos articulados servicio particular.', '2014-02-19 10:46:40', 'Conductor', 'b3'),
(11, 'C1', 'c1', 'Automoviles, camperos, camionetas y microbuses de servicio publico.', '2014-02-19 10:46:55', 'Conductor', 'c1'),
(12, 'C2', 'c2', 'Camiones rigidos, busetas y buses de servicio publico.', '2014-02-19 10:47:21', 'Conductor', 'c2'),
(13, 'C3', 'c3', 'Vehiculos articulados servicio publico.', '2014-02-19 10:47:40', 'Conductor', 'c3'),
(14, 'Partida', 'partida', NULL, '2014-02-19 11:03:49', 'Aduana', 'part'),
(15, 'Cruce de Frontera', 'cruce-de-frontera', NULL, '2014-02-19 11:03:57', 'Aduana', 'cc'),
(16, 'Destino', 'destino', NULL, '2014-02-19 11:04:03', 'Aduana', 'dest'),
(17, 'Fácil Manejo', 'facil-manejo', NULL, '2014-02-20 07:54:32', 'Carga', 'ff'),
(18, 'Peligrosa', 'peligrosa', NULL, '2014-02-20 22:19:14', 'Carga', 'peli'),
(19, 'Recibe', 'recibe', 'Datos de mercancía para Recibir', '2014-02-20 23:18:44', 'datosMercancias', 'Recibe'),
(20, 'Embarque', 'embarque', 'Datos de Mercancía para el Embarque', '2014-02-20 23:19:28', 'datosMercancias', 'Embarque'),
(21, 'Entrega', 'entrega', 'Datos de Mercancía para Entrega', '2014-02-20 23:20:26', 'datosMercancias', 'Entrega'),
(22, 'Valor Del Flete', 'valor-del-flete', NULL, '2014-02-21 00:19:50', 'Gasto', 'Valor Del Flete'),
(23, 'Otros Gastos Suplementarios', 'otros-gastos-suplementarios', NULL, '2014-02-21 00:24:02', 'Gasto', 'Otros Gastos Suplementarios'),
(24, 'Seguro', 'seguro', NULL, '2014-02-21 00:24:43', 'Gasto', 'Seguro'),
(25, 'Emisión', 'emision', 'Datos de Mercancía para Emisión', '2014-02-21 00:35:38', 'datosMercancias', 'Emisión'),
(26, 'Mercancia', 'mercancia', NULL, '2014-02-21 00:38:57', 'Gasto', 'Mercancia'),
(27, 'Sustancia Química o Precursoras', 'sustancia-quimica-o-precursoras', NULL, '2014-03-11 09:05:59', 'Carga', 'sss');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo_doc_id` bigint(20) DEFAULT NULL,
  `grupo_id` bigint(20) DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canonical` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci,
  `fecha_creado` datetime NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8_unicode_ci,
  `telefono` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doc_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2265B05D1CEFBEA4` (`tipo_doc_id`),
  KEY `IDX_2265B05D9C833003` (`grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `tipo_doc_id`, `grupo_id`, `nombre`, `canonical`, `descripcion`, `fecha_creado`, `apellido`, `direccion`, `telefono`, `doc_id`) VALUES
(1, NULL, NULL, 'Usuario', 'usuario', NULL, '2014-02-19 11:05:25', NULL, NULL, NULL, '123');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  ADD CONSTRAINT `FK_19BDE67331075EBA` FOREIGN KEY (`autor`) REFERENCES `usuario` (`id`),
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
  ADD CONSTRAINT `FK_738C8C0619BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_738C8C06C9FA1603` FOREIGN KEY (`vehiculo`) REFERENCES `vehiculo` (`id`),
  ADD CONSTRAINT `FK_738C8C06D5F7F18A` FOREIGN KEY (`conductor`) REFERENCES `conductor` (`id`);

--
-- Filtros para la tabla `formato_usuario`
--
ALTER TABLE `formato_usuario`
  ADD CONSTRAINT `FK_DF26A12619BDE673` FOREIGN KEY (`formato`) REFERENCES `formato` (`id`),
  ADD CONSTRAINT `FK_DF26A1262265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_DF26A126E553F37` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`);

--
-- Filtros para la tabla `fos_user`
--
ALTER TABLE `fos_user`
  ADD CONSTRAINT `FK_957A6479DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

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
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `FK_8C0E9BD394E27525` FOREIGN KEY (`docente_id`) REFERENCES `usuario` (`id`);

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
  ADD CONSTRAINT `FK_2265B05D9C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `FK_C9FA16037E5D2EFF` FOREIGN KEY (`pais`) REFERENCES `pais` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
