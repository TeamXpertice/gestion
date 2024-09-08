-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2024 a las 04:40:41
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
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` text NOT NULL,
  `ocupacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombres`, `apellidos`, `correo`, `contrasena`, `dni`, `celular`, `fecha_nacimiento`, `direccion`, `ocupacion`) VALUES
(1, 'Administrador Principal', 'Administrador Principal', 'admin@gmail.com', 'admin', '99999999', '666666666', '2000-01-01', 'No hay descripción', 'Administrador Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bienes`
--

CREATE TABLE `bienes` (
  `id` int(11) NOT NULL,
  `descripcion_bien` varchar(255) NOT NULL,
  `nombre_proveedor` varchar(255) DEFAULT 'Sin Registro',
  `modelo` varchar(255) DEFAULT NULL,
  `serie_codigo` varchar(255) DEFAULT 'Sin Registro',
  `marca` varchar(255) DEFAULT NULL,
  `estado` varchar(255) NOT NULL,
  `dimensiones` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `tipo_material` varchar(255) NOT NULL,
  `estado_fisico_actual` varchar(255) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `coste` decimal(10,2) NOT NULL DEFAULT 0.00,
  `observacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Pastel'),
(2, 'Agua'),
(7, 'Menu'),
(8, 'Mueble'),
(9, 'Pastel'),
(10, 'a'),
(11, 'a2'),
(12, 'Pastel2'),
(13, 'ASASAS'),
(14, 'asasas'),
(15, 'Mueble');

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
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `descripcion_compra` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_compra` date DEFAULT curdate(),
  `proveedor` varchar(255) DEFAULT 'Sin Registro',
  `metodo_pago` enum('Efectivo','Visa','Yape','Plin') DEFAULT 'Efectivo',
  `observacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `descripcion_compra`, `cantidad`, `costo_unitario`, `total`, `fecha_compra`, `proveedor`, `metodo_pago`, `observacion`) VALUES
(0, 'tijeras', 2, 12.00, 24.00, '2024-08-24', '12', 'Efectivo', 'ninguna'),
(0, 'tijeras V2', 2, 40.00, 80.00, '2024-08-24', 's/d', 'Visa', 'Ninguna'),
(0, 'Pastel de Fresa', 1, 20.00, 20.00, '2024-08-31', '', 'Efectivo', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumibles`
--

CREATE TABLE `consumibles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion_consumible` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `unidad_medida` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `fecha_compra` date DEFAULT curdate(),
  `fecha_vencimiento` date DEFAULT NULL,
  `coste` decimal(10,2) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumibles`
--

INSERT INTO `consumibles` (`id`, `nombre`, `descripcion_consumible`, `stock`, `unidad_medida`, `marca`, `observacion`, `fecha_compra`, `fecha_vencimiento`, `coste`, `precio`) VALUES
(1, 'Pastel de Fresa', 'pastel', 0, 'u', 'S/D', 'ninguna', '2024-08-24', '2024-08-24', 20.00, 20.00),
(2, 'Pastel deChocolate', 'Pastel de Cholate', 0, 'u', 'S/D', 'Ninguna', '2024-08-24', '2024-08-24', 20.00, 3.00),
(3, 'Pastel de Fresa 2', '12', 11, 'u', 'as', '12', '2024-09-05', '2024-09-05', 12.00, 0.00),
(4, 'Pastel deChocolate2', 'sa', 7, 'u', 'S/D', 'as', '2024-09-05', '2024-09-05', 20.00, 20.00),
(5, 'Hanburguesa', 'as', 10, 'u', 'S/D', 'as', '2024-09-06', '2024-09-06', 20.00, 20.00),
(6, 'Hanburguesa2', 'as', 11, 'u', 'as', 'as', '2024-09-06', '2024-09-06', 20.00, 20.00),
(7, 'jggjh', '68', 6, 'u', 'S/D', '68', '2024-09-06', '2024-09-06', 78.00, 76.00);

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
(1, 1),
(2, 1),
(3, 8),
(4, 1),
(5, 10),
(6, 1),
(7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumible_componentes`
--

CREATE TABLE `consumible_componentes` (
  `id` int(11) NOT NULL,
  `id_consumible` int(11) NOT NULL,
  `id_componente` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumible_componentes`
--

INSERT INTO `consumible_componentes` (`id`, `id_consumible`, `id_componente`, `cantidad`) VALUES
(1, 4, 2, 1.00);

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
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` enum('Efectivo','Visa','Yape','Plin') NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `total`, `metodo_pago`, `fecha`, `created_at`) VALUES
(1, 20.00, 'Efectivo', '2024-08-24', '2024-08-24 14:49:45'),
(2, 20.00, 'Efectivo', '2024-08-24', '2024-08-24 16:08:06'),
(3, 20.00, 'Efectivo', '2024-08-24', '2024-08-24 16:08:21'),
(4, 20.00, 'Efectivo', '2024-08-24', '2024-08-24 16:09:07'),
(5, 20.00, 'Efectivo', '2024-08-24', '2024-08-24 16:13:16'),
(6, 20.00, 'Efectivo', '2024-08-24', '2024-08-24 17:28:44'),
(7, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 15:22:23'),
(8, 23.00, 'Efectivo', '2024-08-31', '2024-08-31 15:22:52'),
(9, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 15:36:11'),
(10, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 15:36:21'),
(11, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 16:08:00'),
(12, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 16:15:40'),
(13, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 16:18:02'),
(14, 23.00, 'Efectivo', '2024-08-31', '2024-08-31 16:19:20'),
(15, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 16:27:42'),
(16, 23.00, 'Efectivo', '2024-08-31', '2024-08-31 16:27:54'),
(17, 46.00, 'Efectivo', '2024-08-31', '2024-08-31 16:28:10'),
(21, 20.00, 'Efectivo', '2024-08-31', '2024-08-31 16:39:21'),
(23, 20.00, 'Visa', '2024-08-31', '2024-08-31 16:42:07'),
(24, 0.00, 'Efectivo', '2024-09-05', '2024-09-05 16:16:40'),
(25, 20.00, 'Efectivo', '2024-09-05', '2024-09-05 16:16:45'),
(26, 20.00, 'Efectivo', '2024-09-05', '2024-09-05 16:18:54'),
(27, 20.00, 'Efectivo', '2024-09-05', '2024-09-05 16:22:01'),
(28, 119.00, 'Efectivo', '2024-09-06', '2024-09-06 18:11:14'),
(29, 9.00, 'Efectivo', '2024-09-06', '2024-09-06 18:24:10');

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
(1, 0, 1, 1, 20.00),
(2, 0, 1, 1, 20.00),
(3, 0, 1, 1, 20.00),
(4, 0, 1, 1, 20.00),
(5, 0, 1, 1, 20.00),
(6, 0, 1, 1, 20.00),
(7, 0, 1, 1, 20.00),
(8, 0, 1, 1, 20.00),
(9, 0, 2, 1, 3.00),
(10, 0, 1, 1, 20.00),
(11, 0, 1, 1, 20.00),
(12, 0, 1, 1, 20.00),
(13, 0, 1, 1, 20.00),
(14, 0, 1, 1, 20.00),
(15, 0, 2, 1, 3.00),
(16, 0, 1, 1, 20.00),
(17, 15, 1, 1, 20.00),
(18, 16, 2, 1, 3.00),
(19, 16, 1, 1, 20.00),
(20, 17, 1, 2, 20.00),
(21, 17, 2, 2, 3.00),
(22, 21, 1, 1, 20.00),
(23, 23, 1, 1, 20.00),
(24, 24, 3, 1, 0.00),
(25, 25, 1, 1, 20.00),
(26, 26, 4, 1, 20.00),
(27, 27, 4, 1, 20.00),
(28, 28, 2, 1, 3.00),
(29, 28, 4, 1, 20.00),
(30, 28, 6, 1, 20.00),
(31, 28, 7, 1, 76.00),
(32, 29, 2, 3, 3.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
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
  ADD PRIMARY KEY (`consumible_id`,`categoria_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `consumible_componentes`
--
ALTER TABLE `consumible_componentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_consumible` (`id_consumible`),
  ADD KEY `id_componente` (`id_componente`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `consumibles`
--
ALTER TABLE `consumibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `consumible_componentes`
--
ALTER TABLE `consumible_componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
-- Filtros para la tabla `consumible_componentes`
--
ALTER TABLE `consumible_componentes`
  ADD CONSTRAINT `consumible_componentes_ibfk_1` FOREIGN KEY (`id_consumible`) REFERENCES `consumibles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consumible_componentes_ibfk_2` FOREIGN KEY (`id_componente`) REFERENCES `consumibles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
