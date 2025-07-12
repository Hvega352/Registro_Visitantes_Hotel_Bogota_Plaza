-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2025 a las 22:27:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registro_visitantes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `tipo_visitante` enum('Visitante','Proveedor','Contratista') NOT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `hora_ingreso` time NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `destino` varchar(100) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `registrado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `telefono` varchar(20) DEFAULT NULL COMMENT 'Número de teléfono',
  `correo_electronico` varchar(100) DEFAULT NULL COMMENT 'Correo electrónico',
  `autoriza` varchar(100) DEFAULT NULL,
  `otro_destino` varchar(100) DEFAULT NULL,
  `area_visitada` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `visitantes`
--

INSERT INTO `visitantes` (`id`, `nombre_completo`, `documento`, `tipo_visitante`, `empresa`, `fecha_ingreso`, `hora_ingreso`, `fecha_salida`, `hora_salida`, `destino`, `observaciones`, `registrado_en`, `telefono`, `correo_electronico`, `autoriza`, `otro_destino`, `area_visitada`) VALUES
(1, 'Jaime Antonio Vega Hernandez', '1014178963', 'Visitante', 'Casas.ltda', '2025-06-23', '12:16:00', '2025-06-23', '14:19:00', 'Seguridad', 'Analisis de Seguridad', '2025-06-23 17:16:54', '3114568795', 'javh85@gmail.com', 'Hernando Vega', '', NULL),
(2, 'Javier Diaz', '245658', 'Visitante', 'Grasss', '2025-06-25', '12:20:00', '2025-06-26', '12:20:00', 'Tecnología', 'Trabajos internos', '2025-06-25 17:20:38', '12456', 'herngo.ckiinb@gmail.com', 'Diana Galindo', '', NULL),
(3, 'CESAR STEVEN CHURTA CAICEDO', '1222', 'Proveedor', 'HDSADHA', '2025-03-12', '21:03:00', '2025-06-25', '03:12:00', 'Tecnología', 'TRABAJO OFI', '2025-06-25 21:27:02', '301718391', 'ASDASD@GMAIL.COM', 'VEGA', '', NULL),
(4, 'Belizario Jose Bustamante Rangel', '25489756', 'Contratista', 'Cableadoya Ltda', '2025-06-27', '06:44:00', '2025-06-27', '16:45:00', 'Mantenimiento', 'Inicio de trabajos en el área del sótano, lo acompaña personal de mantenimiento', '2025-06-28 23:46:02', '2457894569', 'cable.25@cableadoyo.com', 'Julio Dominguez', '', NULL),
(5, 'Matias Vega Hernandez', '6585698', 'Visitante', 'Casas.ltda', '2025-07-08', '17:50:00', '2025-07-08', '17:52:00', 'Gerencia', 'Entrega Proyecto', '2025-07-08 22:51:11', '21254789', 'mati@gmail.com', 'Alberto Rolnik', '', NULL),
(6, 'Hernan Serna', '12456879', 'Proveedor', 'Whash.S.A', '2025-07-09', '20:47:00', '0000-00-00', '00:00:00', 'Recepción', 'Entrega material', '2025-07-10 01:47:32', '232456987', 'serna.no@gmail.com', 'Carlos Dias', '', NULL),
(7, 'Jairo', '2455697', 'Proveedor', 'Asus ltda', '2025-07-09', '21:14:00', '2025-07-10', '21:20:00', 'Oficina del Maitre', 'Trabajo', '2025-07-10 02:19:08', '21254789', 'ja.mju@gmail.com', 'Josefa', NULL, NULL),
(8, 'Andrea Milena Hernandez ', '12456987', 'Contratista', 'bachue SAS', '2025-07-09', '21:22:00', '2025-07-09', '23:26:00', 'Seguridad', 'Entrega pedido', '2025-07-10 02:22:54', '325465897', 'amljhy.b@gmail.com', 'Hernando Vega', NULL, NULL),
(9, 'Sandra Reyes', '4589789', 'Visitante', 'Asus ltda', '2025-07-09', '09:27:00', '2025-07-12', '15:03:18', 'Calidad', 'Revisa Zapatos', '2025-07-10 02:27:54', '21254789', 'ja.mju@gmail.com', 'Jesus Tulo', NULL, NULL),
(10, 'Aurelio Cheveroni', '42352522', 'Contratista', 'Diverkids', '2025-07-08', '00:29:00', '2025-07-12', '20:46:41', 'Eventos', 'NInguna', '2025-07-10 02:30:10', '324234324', 'nhj25.10@gmail.com', 'Josefa', NULL, NULL),
(11, 'Tatiana Ariza', '5487965489', 'Proveedor', 'colyave', '2025-07-09', '23:55:00', '2025-07-09', '12:56:00', 'Reservas', 'Revisa trabajo', '2025-07-10 04:55:56', '3114568795', 'herngo.ckiinb@gmail.com', 'Julio Jasos', NULL, NULL),
(13, 'Clara Santamaria', '4578965', 'Contratista', 'carnet SAS', '2025-07-12', '10:09:00', '2025-07-12', '10:30:00', 'Seguridad', 'Revisión de los carnets nuevos', '2025-07-12 15:09:46', '312546589', 'clara.co@gmail.com', 'Hernando Vega', NULL, NULL),
(14, 'Javier Diaz', '245658', 'Visitante', 'Asus ltda', '2025-07-12', '11:52:00', '2025-07-12', '20:47:54', 'Almacén', 'Enytrega pedido', '2025-07-12 16:52:58', '21254789', 'ja.mju@gmail.com', 'Arbey', NULL, NULL),
(15, 'Juan Esteban Blanco', '12456987', 'Proveedor', 'Junjun.ltda', '2025-07-12', '21:13:34', '2025-07-12', '15:15:33', 'Ama de llaves', 'Entrega', '2025-07-12 19:13:34', '32445678956', 'jun@jun.net', 'Juan Salas', NULL, NULL),
(16, 'Pedro Jose Salas Aldarriaga', '12456789', 'Contratista', 'Piedras del sol', '2025-07-12', '14:17:22', NULL, NULL, 'Mantenimiento', 'Entrega piedras', '2025-07-12 19:17:22', '325456789', 'pjsa@gmail.com', 'Julio Gomez', NULL, NULL),
(17, 'Marly Valenzuela', '12456789', 'Visitante', 'Vidrios S.A', '2025-07-12', '14:21:02', NULL, NULL, 'Restaurante Macuira', 'Entrega', '2025-07-12 19:21:02', '1023123456', '', 'Eliecer', NULL, NULL),
(18, 'Jeremias ', '2325456', 'Visitante', 'Vidrios S.A', '2025-07-12', '14:24:46', '2025-07-12', '14:25:20', 'Contabilidad', 'Entrega', '2025-07-12 19:24:46', '21254789', 'ja.mju@gmail.com', 'Diana Galindo', NULL, NULL),
(19, 'Harold Tarazona', '23456987', 'Visitante', 'Vidrios S.A', '2025-07-12', '14:28:59', NULL, NULL, 'Ama de llaves', 'Trabajo', '2025-07-12 19:28:59', '21254789', 'ja.mju@gmail.com', 'Eliecer', NULL, NULL),
(20, 'Jordan Salazar', '2345698758', 'Proveedor', 'Asus ltda', '2025-07-12', '14:32:19', '2025-07-12', '14:32:39', 'Mantenimiento', 'Trabajos ', '2025-07-12 19:32:19', '21254789', 'herngo.ckiinb@gmail.com', 'Eliecer', NULL, NULL),
(21, 'Belizario Jose Bustamante Rangel', '22222222', 'Visitante', 'Asus ltda', '2025-07-12', '14:38:16', '2025-07-12', '14:39:53', 'Ama de llaves', 'Trabajo', '2025-07-12 19:38:16', '21254789', 'ja.mju@gmail.com', 'Eliecer', NULL, NULL),
(22, 'Belizario Rojas Bustamante', '1041256458', 'Contratista', 'Tritri ltda', '2025-07-12', '14:39:42', NULL, NULL, 'Calidad', 'Rojas', '2025-07-12 19:39:42', '2345645789', 'hgj@gmail.com', 'Diana Galindo', NULL, NULL),
(23, 'Tereza Gonzales', '22222222', 'Visitante', 'Asus ltda', '2025-07-12', '14:46:22', '2025-07-12', '15:04:19', 'Contabilidad', 'Trabajo', '2025-07-12 19:46:22', '3114568795', 'mati@gmail.com', 'Eliecer', NULL, NULL),
(24, 'Tereza Gonzales', '22222222', 'Visitante', 'Asus ltda', '2025-07-12', '14:52:02', '2025-07-12', '15:09:29', 'Tecnología', 'Trabajo', '2025-07-12 19:52:02', '32456987456', 'ja.mju@gmail.com', 'Eliecer', NULL, NULL),
(25, 'Tereza Gonzales', '22222222', 'Visitante', 'Asus ltda', '2025-07-12', '14:53:12', '2025-07-12', '14:54:03', 'Steward', 'Saludar', '2025-07-12 19:53:12', '21254789', 'ja.mju@gmail.com', 'Hernando Vega', NULL, NULL),
(26, 'Jenaro Clemente Salazar', '5465897', 'Visitante', 'Asus ltda', '2025-07-12', '15:16:35', '2025-07-12', '15:18:57', 'Contabilidad', 'Trabajo', '2025-07-12 20:16:35', '21254789', 'ja.mju@gmail.com', 'Arbey', NULL, NULL),
(27, 'Jenaro Clemente Salazar', '5465897', 'Visitante', 'Asus ltda', '2025-07-12', '15:24:30', NULL, NULL, 'Contabilidad', 'Trabajo', '2025-07-12 20:24:30', '21254789', 'ja.mju@gmail.com', 'Arbey', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_documento` (`documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
