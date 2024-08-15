-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-08-2024 a las 16:28:52
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
(7, '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12'),
(8, '2', '2', '2', '2', '1', '1', '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Electrónicos'),
(2, 'Papel'),
(3, 'Alimentos'),
(4, 'Galleta'),
(5, 'prueba1');

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
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion_consumible` text DEFAULT NULL,
  `nombre_proveedor` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `serie_codigo` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `unidad_medida` varchar(255) DEFAULT NULL,
  `tamano` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `estado_fisico_actual` varchar(255) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `lote` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumibles`
--

INSERT INTO `consumibles` (`id`, `nombre`, `descripcion_consumible`, `nombre_proveedor`, `modelo`, `serie_codigo`, `marca`, `unidad_medida`, `tamano`, `color`, `estado_fisico_actual`, `observacion`, `fecha_vencimiento`, `lote`, `stock`, `precio`) VALUES
(8, 'Galletas oreo', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2024-08-16', '1', 995, 100.00),
(9, 'Maquina de crey', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '2024-08-21', '12', 10, 12.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumibles_categorias`
--

CREATE TABLE `consumibles_categorias` (
  `consumible_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumibles_categorias`
--

INSERT INTO `consumibles_categorias` (`consumible_id`, `categoria_id`) VALUES
(8, 4),
(9, 5);

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
(1, 'admin', 'admin', 'Juan', 'Pérez', '12345678', '999999999', '1980-01-01', 'admin@base.com', 'Calle Falsa 123', 'Ingeniero'),
(2, 'usuario2', 'password2', 'María', 'Gómez', '87654321', '888888888', '1990-02-02', 'maria.gomez@example.com', 'Avenida Siempre Viva 456', 'Doctora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `total`, `fecha`, `created_at`) VALUES
(2, 100.00, '2024-08-09', '2024-08-09 19:06:01'),
(3, 100.00, '2024-08-09', '2024-08-09 19:07:36'),
(4, 100.00, '2024-08-09', '2024-08-09 20:57:49'),
(5, 100.00, '2024-08-09', '2024-08-09 20:59:15'),
(6, 100.00, '2024-08-09', '2024-08-10 02:26:27'),
(7, 12.00, '2024-08-10', '2024-08-11 02:28:12'),
(8, 12.00, '2024-08-14', '2024-08-15 01:26:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalles`
--

CREATE TABLE `ventas_detalles` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `consumible_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_detalles`
--

INSERT INTO `ventas_detalles` (`id`, `venta_id`, `consumible_id`, `cantidad`, `precio_unitario`) VALUES
(3, 2, 8, 1, 100.00),
(4, 3, 8, 1, 100.00),
(5, 4, 8, 1, 100.00),
(6, 5, 8, 1, 100.00),
(7, 6, 8, 1, 100.00),
(8, 7, 9, 1, 12.00),
(9, 8, 9, 1, 12.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bienes`
--
ALTER TABLE `bienes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
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
-- Indices de la tabla `consumibles_categorias`
--
ALTER TABLE `consumibles_categorias`
  ADD KEY `consumible_id` (`consumible_id`),
  ADD KEY `categoria_id` (`categoria_id`);

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
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `consumible_id` (`consumible_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bienes`
--
ALTER TABLE `bienes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consumibles`
--
ALTER TABLE `consumibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consumibles_categorias`
--
ALTER TABLE `consumibles_categorias`
  ADD CONSTRAINT `consumibles_categorias_ibfk_1` FOREIGN KEY (`consumible_id`) REFERENCES `consumibles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consumibles_categorias_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  ADD CONSTRAINT `ventas_detalles_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `ventas_detalles_ibfk_2` FOREIGN KEY (`consumible_id`) REFERENCES `consumibles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
