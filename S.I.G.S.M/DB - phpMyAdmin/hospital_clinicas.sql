-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2026 a las 15:28:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hospital_clinicas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `id` bigint(20) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(50) NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`id`, `usuario_id`, `accion`, `modulo`, `descripcion`, `ip`, `fecha`) VALUES
(1, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-17 18:21:28'),
(2, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-17 18:21:52'),
(3, 2, 'CREAR', 'CATEGORIAS', 'Creó categoría: prueba', '::1', '2026-08-17 18:35:49'),
(4, 2, 'DESACTIVAR', 'CATEGORIAS', 'Categoría ID 7', '::1', '2026-08-17 18:36:10'),
(5, 2, 'CREAR', 'ENCUESTAS', 'Creó encuesta: Atencion', '::1', '2026-08-17 19:08:14'),
(6, 2, 'DESACTIVAR', 'ENCUESTAS', 'Encuesta ID 4', '::1', '2026-08-17 20:35:01'),
(7, 2, 'CREAR', 'ENCUESTAS', 'Creó encuesta: anabel tiene el pelo rojo', '::1', '2026-08-18 01:17:42'),
(8, 2, 'DESACTIVAR', 'ENCUESTAS', 'Encuesta ID 5', '::1', '2026-08-18 01:19:48'),
(9, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: wee', '::1', '2026-08-18 01:26:33'),
(10, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 1', '::1', '2026-08-18 01:27:02'),
(11, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 1', '::1', '2026-08-18 01:28:52'),
(12, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-18 15:01:26'),
(13, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: kANT', '::1', '2026-08-18 15:05:02'),
(14, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 2', '::1', '2026-08-18 15:05:29'),
(15, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 2', '::1', '2026-08-18 15:06:26'),
(16, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '192.168.56.1', '2026-08-18 21:26:42'),
(17, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: pruebaqr', '192.168.56.1', '2026-08-18 21:27:41'),
(18, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: pruebaqr', '192.168.56.1', '2026-08-18 21:40:04'),
(19, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: pruebaqr', '192.168.56.1', '2026-08-18 21:40:13'),
(20, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: pruebaqr', '192.168.56.1', '2026-08-18 21:44:59'),
(21, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: pruebaqr', '192.168.56.1', '2026-08-18 21:50:51'),
(22, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: pruebaqr', '192.168.56.1', '2026-08-18 21:53:22'),
(23, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-19 00:02:28'),
(24, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 8', '::1', '2026-08-19 00:03:01'),
(25, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 7', '::1', '2026-08-19 00:03:03'),
(26, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '10.209.173.16', '2026-08-19 12:23:31'),
(27, 2, 'ACTIVAR', 'DOCUMENTOS', 'Documento ID 7', '10.209.173.16', '2026-08-19 12:23:41'),
(28, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-19 15:36:30'),
(29, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-19 19:31:39'),
(30, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-19 22:06:43'),
(31, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-20 16:52:12'),
(32, 2, 'DESACTIVAR', 'CATEGORIAS', 'Categoría ID 1', '::1', '2026-08-20 16:52:32'),
(33, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '192.168.110.126', '2026-08-21 00:23:08'),
(34, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '192.168.110.14', '2026-08-21 00:24:55'),
(35, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 7', '192.168.110.14', '2026-08-21 00:25:30'),
(36, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: p', '192.168.110.14', '2026-08-21 00:25:54'),
(37, 2, 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID 9', '192.168.110.14', '2026-08-21 00:26:30'),
(38, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-21 01:09:39'),
(39, 2, 'ACTIVAR', 'CATEGORIAS', 'Categoría ID 1', '::1', '2026-08-21 01:09:46'),
(40, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: Prueba', '::1', '2026-08-21 01:10:50'),
(41, 2, 'EDITAR', 'DOCUMENTOS', 'Documento ID 10 actualizado', '::1', '2026-08-21 01:14:11'),
(42, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-21 01:27:35'),
(43, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-21 17:37:35'),
(44, 2, 'CREAR', 'DOCUMENTOS', 'Creó documento: w', '::1', '2026-08-21 17:40:24'),
(45, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 20:57:06'),
(46, 2, 'CREAR', 'USUARIOS', 'Creó usuario: jose', '::1', '2026-08-26 20:59:20'),
(47, 3, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 21:00:16'),
(48, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 21:09:19'),
(49, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 21:09:42'),
(50, 3, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 21:57:56'),
(51, 3, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 22:24:06'),
(52, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 22:24:22'),
(53, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 22:30:04'),
(54, 3, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-26 22:30:27'),
(55, 3, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-27 11:17:31'),
(56, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-27 11:18:41'),
(57, 2, 'ACTIVAR', 'ENCUESTAS', 'Encuesta ID 5', '::1', '2026-08-27 17:21:57'),
(58, 3, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-27 17:39:04'),
(59, 3, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-27 18:13:25'),
(60, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-08-27 18:14:07'),
(61, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-09-02 00:32:42'),
(62, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-09-02 21:37:55'),
(63, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-09-02 22:53:00'),
(64, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-09-02 23:16:01'),
(65, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-09-02 23:27:29'),
(66, 2, 'LOGIN', 'AUTH', 'Inicio de sesión correcto', '::1', '2026-09-02 23:30:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'Cardiología', 'Indicaciones y documentación de cardiología', 1),
(2, 'Nefrología y Trasplante', 'Documentación de nefrología y trasplante', 1),
(3, 'Enfermería', 'Indicaciones y cuidados de enfermería', 1),
(4, 'Estudios e Imagenología', 'Preparación e indicaciones para estudios', 1),
(5, 'Información General', 'Información general para pacientes', 1),
(6, 'Otros', 'Otros documentos del hospital', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(180) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `archivo` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `version_actual` int(11) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `titulo`, `descripcion`, `archivo`, `categoria_id`, `activo`, `version_actual`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(10, 'Prueba', '', '933750514ecad87d188a3f1b.pdf', 1, 1, 1, '2026-08-21 01:10:50', '2026-08-21 01:14:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(180) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `segmento` varchar(100) NOT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `titulo`, `descripcion`, `segmento`, `activa`, `fecha_creacion`) VALUES
(1, 'Encuesta estándar de satisfacción', 'Encuesta anónima de satisfacción general.', 'General', 1, '2026-08-14 17:43:03'),
(2, 'Encuesta de satisfacción del usuario trasplantado', 'Encuesta anónima para usuarios trasplantados.', 'Trasplante', 1, '2026-08-14 17:43:03'),
(3, 'Encuesta sobre evolución de los programas', 'Encuesta relacionada con la evolución de los programas del Fondo Nacional de Recursos.', 'FNR', 1, '2026-08-14 17:43:03'),
(4, 'Atencion', 'prueba', 'General', 0, '2026-08-17 19:08:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_encuesta`
--

CREATE TABLE `preguntas_encuesta` (
  `id` int(11) NOT NULL,
  `encuesta_id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `tipo` enum('opciones','texto','si_no') NOT NULL DEFAULT 'opciones',
  `orden` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas_encuesta`
--

INSERT INTO `preguntas_encuesta` (`id`, `encuesta_id`, `pregunta`, `tipo`, `orden`) VALUES
(1, 1, '¿Cómo calificaría la atención recibida?', 'opciones', 1),
(2, 1, '¿La información brindada fue clara?', 'opciones', 2),
(3, 2, '¿Cómo calificaría la atención recibida en el área de trasplante?', 'opciones', 1),
(4, 2, '¿La información brindada fue clara?', 'opciones', 2),
(5, 3, '¿Cómo valora la evolución del programa?', 'opciones', 1),
(6, 4, 'Si', 'si_no', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_encuesta`
--

CREATE TABLE `respuestas_encuesta` (
  `id` int(11) NOT NULL,
  `encuesta_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `respuesta` varchar(500) NOT NULL,
  `fecha_respuesta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `respuestas_encuesta`
--

INSERT INTO `respuestas_encuesta` (`id`, `encuesta_id`, `pregunta_id`, `respuesta`, `fecha_respuesta`) VALUES
(1, 2, 3, 'Muy buena', '2026-08-17 18:38:19'),
(2, 2, 4, 'Muy buena', '2026-08-17 18:38:19'),
(3, 3, 5, 'Mala', '2026-08-21 16:20:18'),
(4, 1, 1, 'Muy mala', '2026-08-27 17:27:05'),
(5, 1, 2, 'Muy mala', '2026-08-27 17:27:05'),
(6, 1, 1, 'Muy buena', '2026-08-27 17:27:36'),
(7, 1, 2, 'Muy buena', '2026-08-27 17:27:36'),
(8, 1, 1, 'Muy mala', '2026-08-27 17:31:23'),
(9, 1, 2, 'Muy mala', '2026-08-27 17:31:23'),
(10, 1, 1, 'Muy mala', '2026-08-27 17:33:52'),
(11, 1, 2, 'Muy mala', '2026-08-27 17:33:52'),
(12, 2, 3, 'Mala', '2026-08-27 18:12:58'),
(13, 2, 4, 'Regular', '2026-08-27 18:12:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('administrador','funcionario') NOT NULL DEFAULT 'funcionario',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `rol`, `activo`, `fecha_creacion`) VALUES
(2, 'Emiliano Rodríguez', 'emiliano123', '$2y$10$hPFt6NLU0hjhppbZu/Qs1.NKLtqYyykEUt/4ADd9R1p7H9o9Cg3DO', 'administrador', 1, '2026-08-17 18:21:07'),
(3, 'jose', 'jose', '$2y$10$r2Nk0Ip2dQ9CYHBH8yJBFuK60GB1vFiZIhUXvbgNIvNXJSr78mMD6', 'funcionario', 1, '2026-08-26 20:59:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_auditoria_usuario` (`usuario_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documentos_categoria` (`categoria_id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas_encuesta`
--
ALTER TABLE `preguntas_encuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_preguntas_encuesta` (`encuesta_id`);

--
-- Indices de la tabla `respuestas_encuesta`
--
ALTER TABLE `respuestas_encuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_respuesta_encuesta` (`encuesta_id`),
  ADD KEY `fk_respuesta_pregunta` (`pregunta_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `preguntas_encuesta`
--
ALTER TABLE `preguntas_encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `respuestas_encuesta`
--
ALTER TABLE `respuestas_encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `fk_auditoria_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `fk_documentos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `preguntas_encuesta`
--
ALTER TABLE `preguntas_encuesta`
  ADD CONSTRAINT `fk_preguntas_encuesta` FOREIGN KEY (`encuesta_id`) REFERENCES `encuestas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuestas_encuesta`
--
ALTER TABLE `respuestas_encuesta`
  ADD CONSTRAINT `fk_respuesta_encuesta` FOREIGN KEY (`encuesta_id`) REFERENCES `encuestas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respuesta_pregunta` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas_encuesta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
