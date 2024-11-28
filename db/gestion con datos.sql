-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 14:20:55
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
  `ocupacion` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombres`, `apellidos`, `correo`, `contrasena`, `dni`, `celular`, `fecha_nacimiento`, `direccion`, `ocupacion`, `estado`) VALUES
(1, 'Administrador Principal', 'Administrador Principal', 'admin@gmail.com', '$2b$12$OB3Fvrezebr9.v3c/5roS.Tio0il8fOE5qqLkXRYLlZREyjOLhXvq', '99999999', '666666666', '2000-01-01', 'No hay descripción', 'Administrador Principal', 1),
(2, 'jhonnyyyo', 'jhonnyas', 'jhonny@gmail.com', '$2y$10$6lUT2/cqMifAjjO3CAxGFetAMjZvYu.gHVsF8qD70FnXAlbvATJI2', '88888889', '999999999', '2024-11-17', 'asd', 'asd', 0),
(3, 'jhonny', 'asdsdff', 'arturo@gmail.com', '$2y$10$9uRNRchTO0NirPwupJ7kmO8TT5jdNat8SOyd24kCdcRLpFXdfic.2', '88888887', '999999999', '2024-11-18', 'asd', 'asd', 0),
(4, 'jhonny', 'jhonny', 'jhonnya@gmail.com', '$2y$10$yYFwXbIFpCYYi1mUyXojkO.jmBZWZnOH3i5n.21mbuM3KoLwEiWs.', '88888886', '999999999', '2024-11-17', '123', '123', 0),
(5, 'ar', 'ar', '1@gmail.com', '$2y$10$53.A0zecMl88pXhZ5B2b3.KNSe2YNCgNSWgJ9TDe9qRyeAgVua1nS', '88888881', '999999991', '2024-11-17', 'sad', 'asd', 1),
(6, '1', '1', '2@gmail.com', '$2y$10$l6kpeiCRT7AL7QP7uy4XuOPhu4pls2i5fwG1Oj/PLhNThbEolP4OS', '88888880', '999999990', '2024-11-13', '1', '1', 1),
(7, '12', '2', '3@gmail.com', '$2y$10$yMcQZTRi4fzV9SqPkhXJgelwSyfBn.I2fwPaUUOrGEfHHEnxHd03O', '88883888', '399999999', '2024-11-11', '3', '3', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bienes`
--

CREATE TABLE `bienes` (
  `id` int(11) NOT NULL,
  `descripcion_bien` varchar(255) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `modelo` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `serie_codigo` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `marca` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `estado` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `dimensiones` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `color` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `tipo_material` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `estado_fisico_actual` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `coste` varchar(255) NOT NULL DEFAULT 'Sin datos',
  `observacion` text NOT NULL DEFAULT '\'Sin datos\'',
  `categoria_bien_id` int(11) NOT NULL
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
(1, 'Medicamentos'),
(2, 'Herramientas'),
(3, 'Suministros de Oficina'),
(4, 'Electrodomésticos'),
(5, 'Alimentos y Bebidas'),
(6, 'Ropa y Calzado'),
(7, 'Tecnología'),
(8, 'Automóviles'),
(9, 'Muebles'),
(10, 'Juguetes y Juegos'),
(11, 'Material de Construcción'),
(12, 'Productos de Limpieza'),
(13, 'Equipos de Oficina'),
(14, 'Deportes y Recreación'),
(15, 'Hogar y Jardín'),
(16, 'Belleza y Cuidado Personal'),
(17, 'Accesorios para Celulares'),
(18, 'Lentes y Gafas'),
(19, 'Papelería'),
(20, 'Artículos de Decoración');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_bienes`
--

CREATE TABLE `categorias_bienes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `compras_consumibles`
--

CREATE TABLE `compras_consumibles` (
  `id` int(11) NOT NULL,
  `consumible_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `metodo_pago` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras_consumibles`
--

INSERT INTO `compras_consumibles` (`id`, `consumible_id`, `cantidad`, `costo_unitario`, `total`, `fecha_ingreso`, `fecha_vencimiento`, `metodo_pago`) VALUES
(1, 1, 100, 10.00, 1000.00, '2024-01-10', '2025-01-10', 'Transferencia bancaria'),
(2, 2, 50, 15.50, 775.00, '2024-01-11', '2025-01-11', 'Tarjeta de crédito'),
(3, 3, 30, 350.00, 10500.00, '2024-01-12', '2025-01-12', 'Efectivo'),
(4, 4, 200, 50.00, 10000.00, '2024-01-13', '2025-01-13', 'Transferencia bancaria'),
(5, 5, 40, 120.00, 4800.00, '2024-01-14', '2025-01-14', 'Efectivo'),
(6, 6, 25, 200.00, 5000.00, '2024-01-15', '2025-01-15', 'Tarjeta de crédito'),
(7, 7, 150, 20.00, 3000.00, '2024-01-16', '2025-01-16', 'Transferencia bancaria'),
(8, 8, 500, 1.50, 750.00, '2024-01-17', '2025-01-17', 'Efectivo'),
(9, 9, 20, 900.00, 18000.00, '2024-01-18', '2025-01-18', 'Tarjeta de crédito'),
(10, 10, 100, 5.00, 500.00, '2024-01-19', '2025-01-19', 'Transferencia bancaria'),
(11, 11, 5, 40.00, 200.00, '2024-11-21', '2024-11-21', NULL),
(12, 12, 5, 5.00, 25.00, '2024-11-21', '2024-11-21', NULL),
(13, 13, 5, 5.00, 25.00, '2024-11-21', '2024-11-21', NULL),
(14, 14, 5, 5.00, 25.00, '2024-11-21', '2024-11-21', NULL),
(15, 15, 5, 5.00, 25.00, '2024-11-21', '2024-11-21', NULL),
(16, 16, 1, 1.00, 1.00, '2024-11-21', '2024-11-21', NULL),
(17, 17, 5, 5.00, 25.00, '2024-11-21', '2024-11-21', NULL),
(18, 18, 2, 2.00, 4.00, '2024-11-21', '2024-11-21', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_normales`
--

CREATE TABLE `compras_normales` (
  `id` int(11) NOT NULL,
  `descripcion_compra` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `proveedor` varchar(255) DEFAULT NULL,
  `metodo_pago` varchar(255) NOT NULL,
  `observacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumibles`
--

CREATE TABLE `consumibles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion_consumible` text DEFAULT 'Consumible Compuesto o Sin datos',
  `unidad_medida` varchar(255) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `precio_sugerido` decimal(10,2) DEFAULT 0.00,
  `es_compuesto` tinyint(1) DEFAULT 0,
  `marca` varchar(255) DEFAULT 'Consumible Compuesto o Sin datos',
  `observacion` text DEFAULT 'Consumible Compuesto o Sin datos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumibles`
--

INSERT INTO `consumibles` (`id`, `nombre`, `descripcion_consumible`, `unidad_medida`, `categoria_id`, `precio_sugerido`, `es_compuesto`, `marca`, `observacion`) VALUES
(1, 'Aspirina', 'Medicamento para el dolor y fiebre', 'Caja', 1, 10.00, 0, 'Bayer', 'Consumible para dolor leve'),
(2, 'Destornillador', 'Herramienta para aflojar o apretar tornillos', 'Unidad', 2, 15.50, 0, 'Stanley', 'Herramienta de uso general'),
(3, 'Impresora HP', 'Impresora láser a color', 'Unidad', 3, 350.00, 0, 'HP', 'Ideal para oficina'),
(4, 'Lentes de Sol', 'Lentes para protección solar', 'Par', 18, 50.00, 0, 'Ray-Ban', 'Lentes de calidad premium'),
(5, 'Teclado', 'Teclado mecánico para PC', 'Unidad', 7, 120.00, 0, 'Corsair', 'Teclado gaming'),
(6, 'Silla de Oficina', 'Silla ergonómica para oficina', 'Unidad', 9, 200.00, 0, 'Ikea', 'Silla cómoda para largas jornadas'),
(7, 'Camiseta', 'Camiseta de algodón', 'Unidad', 6, 20.00, 0, 'Nike', 'Ropa casual'),
(8, 'Frituras', 'Bolsa de papas fritas', 'Paquete', 5, 1.50, 0, 'Lays', 'Snack de consumo rápido'),
(9, 'Laptop Dell', 'Laptop portátil con procesador i7', 'Unidad', 7, 900.00, 0, 'Dell', 'Laptop de alto rendimiento'),
(10, 'Papel Higiénico', 'Papel higiénico de 12 rollos', 'Paquete', 12, 5.00, 0, 'Scott', 'Uso diario en el hogar'),
(11, 'Sillas', '', 'u', 15, 0.00, 0, '', ''),
(12, 'sillas#2', '', 'u', 15, 0.00, 0, '', ''),
(13, 'silas#3', '', 'u', 15, 0.00, 0, '', ''),
(14, 'sillas#4', '', 'u', 15, 0.00, 0, '', ''),
(15, 'sillas#4', '', 'u', 15, 0.00, 0, '', ''),
(16, '1', '', 'u', 18, 0.00, 0, '1', ''),
(17, 'sillass#7', '', 'u', 15, 0.00, 0, '', ''),
(18, '2', '', 'u', 18, 0.00, 0, '', '');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `id` int(11) NOT NULL,
  `compras_consumibles_id` int(11) NOT NULL,
  `lote` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo_total` decimal(10,2) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`id`, `compras_consumibles_id`, `lote`, `cantidad`, `costo_total`, `precio_unitario`, `fecha_ingreso`, `fecha_vencimiento`) VALUES
(1, 1, 'Lote001', 100, 1000.00, 10.00, '2024-01-10', '2025-01-10'),
(2, 2, 'Lote002', 50, 775.00, 15.50, '2024-01-11', '2025-01-11'),
(3, 3, 'Lote003', 30, 10500.00, 350.00, '2024-01-12', '2025-01-12'),
(4, 4, 'Lote004', 200, 10000.00, 50.00, '2024-01-13', '2025-01-13'),
(5, 5, 'Lote005', 40, 4800.00, 120.00, '2024-01-14', '2025-01-14'),
(6, 6, 'Lote006', 25, 5000.00, 200.00, '2024-01-15', '2025-01-15'),
(7, 7, 'Lote007', 150, 3000.00, 20.00, '2024-01-16', '2025-01-16'),
(8, 8, 'Lote008', 500, 750.00, 1.50, '2024-01-17', '2025-01-17'),
(9, 9, 'Lote009', 20, 18000.00, 900.00, '2024-01-18', '2025-01-18'),
(10, 10, 'Lote010', 100, 500.00, 5.00, '2024-01-19', '2025-01-19'),
(11, 11, '', 0, 40.00, 40.00, '2024-11-21', '2024-11-21'),
(12, 12, '', 5, 5.00, 5.00, '2024-11-21', '2024-11-21'),
(13, 13, '', 5, 5.00, 5.00, '2024-11-21', '2024-11-21'),
(14, 14, '', 5, 5.00, 5.00, '2024-11-21', '2024-11-21'),
(15, 15, '', 5, 5.00, 5.00, '2024-11-21', '2024-11-21'),
(16, 16, '', 0, 1.00, 1.00, '2024-11-21', '2024-11-21'),
(17, 17, '', 5, 5.00, 5.00, '2024-11-21', '2024-11-21'),
(18, 18, '', 2, 2.00, 2.00, '2024-11-21', '2024-11-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perdidas`
--

CREATE TABLE `perdidas` (
  `id` int(11) NOT NULL,
  `consumible_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 200.00, 'Efectivo', '2024-11-21', '2024-11-21 06:51:27'),
(2, 1.00, 'Efectivo', '2024-11-21', '2024-11-21 12:49:17');

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
(1, 1, 11, 5, 40.00),
(2, 2, 16, 1, 1.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bienes`
--
ALTER TABLE `bienes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_bien_id` (`categoria_bien_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias_bienes`
--
ALTER TABLE `categorias_bienes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras_consumibles`
--
ALTER TABLE `compras_consumibles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumible` (`consumible_id`);

--
-- Indices de la tabla `compras_normales`
--
ALTER TABLE `compras_normales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consumibles`
--
ALTER TABLE `consumibles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Indices de la tabla `consumible_componentes`
--
ALTER TABLE `consumible_componentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consumible_compuesto` (`id_consumible`),
  ADD KEY `fk_componente_simple` (`id_componente`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compras_consumibles` (`compras_consumibles_id`);

--
-- Indices de la tabla `perdidas`
--
ALTER TABLE `perdidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consumible_id` (`consumible_id`);

--
-- Indices de la tabla `renta`
--
ALTER TABLE `renta`
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
  ADD KEY `fk_venta` (`venta_id`),
  ADD KEY `fk_consumible_venta` (`consumible_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `bienes`
--
ALTER TABLE `bienes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `categorias_bienes`
--
ALTER TABLE `categorias_bienes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras_consumibles`
--
ALTER TABLE `compras_consumibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `compras_normales`
--
ALTER TABLE `compras_normales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consumibles`
--
ALTER TABLE `consumibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `consumible_componentes`
--
ALTER TABLE `consumible_componentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `perdidas`
--
ALTER TABLE `perdidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `renta`
--
ALTER TABLE `renta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bienes`
--
ALTER TABLE `bienes`
  ADD CONSTRAINT `bienes_ibfk_1` FOREIGN KEY (`categoria_bien_id`) REFERENCES `categorias_bienes` (`id`);

--
-- Filtros para la tabla `compras_consumibles`
--
ALTER TABLE `compras_consumibles`
  ADD CONSTRAINT `fk_consumible` FOREIGN KEY (`consumible_id`) REFERENCES `consumibles` (`id`);

--
-- Filtros para la tabla `consumibles`
--
ALTER TABLE `consumibles`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
