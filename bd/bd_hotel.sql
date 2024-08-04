-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2024 a las 00:08:48
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
-- Base de datos: `bd_hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `clientes_id` int(11) NOT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `dni` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallestransaccion`
--

CREATE TABLE `detallestransaccion` (
  `detalle_id` int(11) NOT NULL,
  `reservas_id` int(11) DEFAULT NULL,
  `servicios_adicionales_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` date NOT NULL,
  `metodo_de_pago` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `habitaciones_id` int(11) NOT NULL,
  `numero_habitacion` varchar(50) DEFAULT NULL,
  `tipo_habitacion_id` int(11) DEFAULT NULL,
  `disponibilidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`habitaciones_id`, `numero_habitacion`, `tipo_habitacion_id`, `disponibilidad`) VALUES
(1, 'H1', 1, 'disponible'),
(2, 'H2', 1, 'disponible'),
(3, 'H3', 1, 'disponible'),
(4, 'H4', 1, 'disponible'),
(5, 'H5', 2, 'disponible'),
(6, 'H6', 2, 'disponible'),
(7, 'H7', 2, 'disponible'),
(8, 'H8', 2, 'disponible'),
(9, 'H9', 3, 'disponible'),
(10, 'H10', 3, 'disponible'),
(11, 'H11', 3, 'disponible'),
(12, 'H12', 3, 'disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `personal_id` int(11) NOT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `dni` varchar(50) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `horario_trabajo` varchar(255) DEFAULT NULL,
  `contraseña` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`personal_id`, `nombres`, `apellidos`, `dni`, `correo`, `rol`, `horario_trabajo`, `contraseña`) VALUES
(1, 'admin', NULL, 'admin', 'admin@sereniaoasis.com', 'administrador', 'noche', 123456),
(2, 'Joaquin Hernan', 'Pomayay Sobero', '12345678', 'joaquinpomayay@sereniaoasis.com', 'empleado', 'mañana', 123456);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `reservas_id` int(11) NOT NULL,
  `clientes_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `habitaciones_id` int(11) DEFAULT NULL,
  `personal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas_pendientes`
--

CREATE TABLE `reservas_pendientes` (
  `reserva_id` int(11) NOT NULL,
  `clientes_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `habitaciones_id` int(11) NOT NULL,
  `estado` varchar(20) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciosadicionales`
--

CREATE TABLE `serviciosadicionales` (
  `servicios_adicionales_id` int(11) NOT NULL,
  `tipo_servicio_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `personal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipohabitacion`
--

CREATE TABLE `tipohabitacion` (
  `tipo_habitacion_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipohabitacion`
--

INSERT INTO `tipohabitacion` (`tipo_habitacion_id`, `nombre`, `descripcion`, `precio`) VALUES
(1, 'Habitacion Individual', 'Diseñada para una persona, con una cama individual.', 40.00),
(2, 'Habitacion Doble', 'Con capacidad para dos personas, ya sea con una cama doble o dos camas individuales.', 60.00),
(3, 'Habitacion Matrimonial', 'Similar a la habitación doble, pero con una cama de matrimonio para parejas.', 90.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposervicio`
--

CREATE TABLE `tiposervicio` (
  `tipo_servicio_id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tiposervicio`
--

INSERT INTO `tiposervicio` (`tipo_servicio_id`, `nombre`, `descripcion`, `precio`) VALUES
(1, 'Alquiler de equipos electronicos', 'Pueden incluir cargadores, adaptadores de corriente, o incluso dispositivos.', 20.00),
(2, 'Bebidas y snacks en la habitacion', 'Puedes ordenar comida y bebida para ser entregados directamente a tu habitación.', 15.00),
(3, 'Servicios de masajes', 'Masajes a tu habitación.', 25.00),
(4, 'Kits de bienestar', 'Pueden incluir artículos como batas, zapatillas, o productos de cuidado personal y ser entregados en la habitación.', 10.00),
(5, 'Servicio de desayunos', 'El hotel puede ofrecer servicios de entrega de opciones de desayuno en la habitación.', 10.00),
(6, 'Ninguno', '', 0.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`clientes_id`);

--
-- Indices de la tabla `detallestransaccion`
--
ALTER TABLE `detallestransaccion`
  ADD PRIMARY KEY (`detalle_id`),
  ADD KEY `servicios_adicionales_id` (`servicios_adicionales_id`),
  ADD KEY `reservas_id` (`reservas_id`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`habitaciones_id`),
  ADD KEY `tipo_habitacion_id` (`tipo_habitacion_id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`personal_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`reservas_id`),
  ADD KEY `clientes_id` (`clientes_id`),
  ADD KEY `habitaciones_id` (`habitaciones_id`),
  ADD KEY `personal_id` (`personal_id`);

--
-- Indices de la tabla `reservas_pendientes`
--
ALTER TABLE `reservas_pendientes`
  ADD PRIMARY KEY (`reserva_id`),
  ADD KEY `clientes_id` (`clientes_id`),
  ADD KEY `habitaciones_id` (`habitaciones_id`);

--
-- Indices de la tabla `serviciosadicionales`
--
ALTER TABLE `serviciosadicionales`
  ADD PRIMARY KEY (`servicios_adicionales_id`),
  ADD KEY `personal_id` (`personal_id`),
  ADD KEY `tipo_servicio_id` (`tipo_servicio_id`);

--
-- Indices de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  ADD PRIMARY KEY (`tipo_habitacion_id`);

--
-- Indices de la tabla `tiposervicio`
--
ALTER TABLE `tiposervicio`
  ADD PRIMARY KEY (`tipo_servicio_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `clientes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallestransaccion`
--
ALTER TABLE `detallestransaccion`
  MODIFY `detalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `habitaciones_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `personal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `reservas_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas_pendientes`
--
ALTER TABLE `reservas_pendientes`
  MODIFY `reserva_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `serviciosadicionales`
--
ALTER TABLE `serviciosadicionales`
  MODIFY `servicios_adicionales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipohabitacion`
--
ALTER TABLE `tipohabitacion`
  MODIFY `tipo_habitacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tiposervicio`
--
ALTER TABLE `tiposervicio`
  MODIFY `tipo_servicio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallestransaccion`
--
ALTER TABLE `detallestransaccion`
  ADD CONSTRAINT `detallestransaccion_ibfk_2` FOREIGN KEY (`servicios_adicionales_id`) REFERENCES `serviciosadicionales` (`servicios_adicionales_id`),
  ADD CONSTRAINT `detallestransaccion_ibfk_3` FOREIGN KEY (`reservas_id`) REFERENCES `reservas` (`reservas_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD CONSTRAINT `habitaciones_ibfk_1` FOREIGN KEY (`tipo_habitacion_id`) REFERENCES `tipohabitacion` (`tipo_habitacion_id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`clientes_id`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`habitaciones_id`) REFERENCES `habitaciones` (`habitaciones_id`),
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`personal_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas_pendientes`
--
ALTER TABLE `reservas_pendientes`
  ADD CONSTRAINT `reservas_pendientes_ibfk_1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`clientes_id`),
  ADD CONSTRAINT `reservas_pendientes_ibfk_2` FOREIGN KEY (`habitaciones_id`) REFERENCES `habitaciones` (`habitaciones_id`);

--
-- Filtros para la tabla `serviciosadicionales`
--
ALTER TABLE `serviciosadicionales`
  ADD CONSTRAINT `serviciosadicionales_ibfk_1` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`personal_id`),
  ADD CONSTRAINT `serviciosadicionales_ibfk_2` FOREIGN KEY (`tipo_servicio_id`) REFERENCES `tiposervicio` (`tipo_servicio_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
