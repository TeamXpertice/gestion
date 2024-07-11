-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2024 a las 19:23:18
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
-- Base de datos: `gestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bienes`
--

CREATE TABLE `bienes` (
  `id` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `serie_codigo` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `descripcion_bien` varchar(255) NOT NULL,
  `unidad_medida` varchar(255) NOT NULL,
  `tamano` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `tipo_material` varchar(255) NOT NULL,
  `estado_fisico_actual` varchar(255) NOT NULL,
  `observacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bienes`
--

INSERT INTO `bienes` (`id`, `nombre_proveedor`, `nombre`, `modelo`, `serie_codigo`, `marca`, `descripcion_bien`, `unidad_medida`, `tamano`, `color`, `tipo_material`, `estado_fisico_actual`, `observacion`) VALUES
(6, '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12'),
(7, '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `descipcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumibles`
--

CREATE TABLE `consumibles` (
  `id` int(11) NOT NULL,
  `fecha_adquisicion` date DEFAULT NULL,
  `nombre_proveedor` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `serie_codigo` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `descripcion_consumible` text DEFAULT NULL,
  `unidad_medida` varchar(255) DEFAULT NULL,
  `tamano` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `velocidad` varchar(255) DEFAULT NULL,
  `tipo_material` varchar(255) DEFAULT NULL,
  `valor_adquisicion` decimal(10,2) DEFAULT NULL,
  `estado_fisico_actual` varchar(255) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `lote` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumibles`
--

INSERT INTO `consumibles` (`id`, `fecha_adquisicion`, `nombre_proveedor`, `nombre`, `modelo`, `serie_codigo`, `marca`, `descripcion_consumible`, `unidad_medida`, `tamano`, `color`, `velocidad`, `tipo_material`, `valor_adquisicion`, `estado_fisico_actual`, `observacion`, `fecha_vencimiento`, `lote`) VALUES
(2, NULL, '12', '12', '12', '12', '12', '12', '12', '12', '12', NULL, '12', NULL, '12', '12', '2024-07-11', '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `renta`
--

CREATE TABLE `renta` (
  `id` int(11) NOT NULL,
  `descipcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `correo` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `ocupacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nombres`, `apellidos`, `dni`, `celular`, `fecha_nacimiento`, `correo`, `direccion`, `ocupacion`) VALUES
(1, 'admin', 'admin', 'Juan', 'Pérez', '12345678', '999999999', '1980-01-01', 'juan.perez@example.com', 'Calle Falsa 123', 'Ingeniero'),
(2, 'usuario2', 'password2', 'María', 'Gómez', '87654321', '888888888', '1990-02-02', 'maria.gomez@example.com', 'Avenida Siempre Viva 456', 'Doctora');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bienes`
--
ALTER TABLE `bienes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consumibles`
--
ALTER TABLE `consumibles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `renta`
--
ALTER TABLE `renta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bienes`
--
ALTER TABLE `bienes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consumibles`
--
ALTER TABLE `consumibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `renta`
--
ALTER TABLE `renta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
