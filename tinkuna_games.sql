-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-11-2024 a las 12:21:28
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tinkuna_games`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int NOT NULL,
  `usuario_id` int DEFAULT NULL,
  `producto_id` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int NOT NULL,
  `nit` int DEFAULT NULL,
  `nombre` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `direccion` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `dateadd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int NOT NULL,
  `estatus` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nit`, `nombre`, `telefono`, `direccion`, `dateadd`, `usuario_id`, `estatus`) VALUES
(1, 12353535, 'mauri', 63998735, 'A.Ustriz', '2024-10-31 15:55:45', 2, 1),
(2, 323342, 'osmar', 342543545, 'Bolivia-Cochabamba', '2024-10-31 17:22:23', 1, 1),
(3, 1111112, 'jose Zapata', 63998736, 'Bolivia-Cochabamba', '2024-10-31 17:24:54', 9, 1),
(4, 325464, 'ana', 32543535, 'bolivia', '2024-10-31 17:25:34', 9, 1),
(5, 3325343, 'marta', 44534534, 'Bolivia-Cochabamba', '2024-10-31 17:29:00', 9, 1),
(6, 352353, 'lois', 224343243, 'Bolivia-Cochabamba', '2024-10-31 17:29:30', 9, 1),
(7, 35234534, 'jose luis', 4534535, 'Bolivia-Cochabamba', '2024-10-31 17:30:14', 1, 1),
(8, 345453, 'boli', 34543534, 'Bolivia-Cochabamba', '2024-10-31 17:30:41', 1, 1),
(9, 12, 'simon', 4343, 'Bolivia-Cochabamba', '2024-11-06 13:31:44', 9, 1),
(10, 0, 'simon2', 2434, 'Bolivia-Cochabamba', '2024-11-06 13:39:10', 1, 1),
(11, 0, 'simon5', 3434, 'Bolivia-Cochabamba', '2024-11-06 13:48:45', 1, 1),
(12, 34, 'lurdes', 34343, 'Bolivia-Cochabamba', '2024-11-06 13:50:04', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `asunto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `fecha`) VALUES
(1, 'alex', 'daiservicios4@gmail.com', 'hola', 'juegos rpg', '2024-09-28 20:36:19'),
(2, 'Mauricio', 'mauri@gmail.com', 'tarea', 'holaaaaaaa', '2024-10-02 20:37:58'),
(3, 'arke', 'mauri@gmail.com', 'juego', 'holaaaaaa32', '2024-10-02 20:41:25'),
(4, 'mauri', 'mauriciomamaniflores09@gmail.com', 'pruebas unitarias', 'pruebas ', '2024-10-28 19:46:03'),
(5, 'mauri', 'mauriciomamaniflores09@gmail.com', 'pruebas unitarias', 'Pruebas ', '2024-10-28 19:47:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int DEFAULT NULL,
  `codcliente` int DEFAULT NULL,
  `totaltactura` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_de_compra`
--

CREATE TABLE `historial_de_compra` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_de_compra`
--

INSERT INTO `historial_de_compra` (`id`, `usuario_id`, `producto_id`, `cantidad`, `precio`, `fecha_compra`) VALUES
(52, 3, 45, 1, 145.00, '2024-11-12 15:05:22'),
(53, 1, 48, 1, 170.00, '2024-11-12 16:03:25'),
(54, 1, 49, 1, 170.00, '2024-11-12 16:12:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos_de_mesa`
--

CREATE TABLE `juegos_de_mesa` (
  `id_juego` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `categoria` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estatus` tinyint(1) DEFAULT '1',
  `publicado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `juegos_de_mesa`
--

INSERT INTO `juegos_de_mesa` (`id_juego`, `nombre`, `descripcion`, `categoria`, `precio`, `estatus`, `publicado`) VALUES
(5, 'arke123456', 'juego IAao', 'familiar', 145.00, 1, 1),
(6, 'Monopoly 12', 'juego familiar', 'familiar', 300.00, 1, 1),
(7, 'arke', 'juego', 'estatega', 30.00, 1, 1),
(8, 'zombiecide', 'juego', 'apocalictico', 170.00, 1, 1),
(9, 'zombiecide', 'juego12', 'apocalictico1', 30.00, 1, 1),
(10, 'simon', 'juego', 'estatega', 10.00, 1, 1),
(11, 'simon1', 'juego', 'familiar', 170.00, 1, 1),
(12, 'catan', 'juego', 'estratega', 170.00, 1, 1),
(13, 'Ajedrez', 'sadasd', 'Estrategia', 30.00, 1, 0),
(14, 'Ajedrez asdas', 'asdasdadasd', 'Estrategia', 30.00, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `usuario_id` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `fecha`) VALUES
(19, 1, NULL, '2024-10-04 23:15:22'),
(20, 1, 400.00, '2024-10-11 19:00:26'),
(21, 1, 800.00, '2024-10-11 19:01:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `proveedor` int DEFAULT NULL,
  `existencia` int DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_juego` int DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `proveedor`, `existencia`, `date_add`, `id_juego`, `estatus`) VALUES
(31, 'Monopoly 12', 'juego familiar', 300.00, '1731439527_accsesorios.jpeg', NULL, NULL, '2024-11-12 13:53:58', 6, 1),
(32, 'arke', 'juego', 30.00, 'Ark Nova.jpg', NULL, NULL, '2024-11-12 13:56:45', 7, 1),
(41, 'zombiecide', 'juego', 170.00, 'zombicide.jpg', NULL, NULL, '2024-11-12 14:15:22', 8, 1),
(45, 'arke123456', 'juego IAao', 145.00, '1731438233_consola.jpeg', NULL, NULL, '2024-11-12 14:46:43', 5, 1),
(46, 'zombiecide', 'juego12', 30.00, '1731438649_zombicide.jpg', NULL, NULL, '2024-11-12 14:46:48', 9, 1),
(47, 'simon', 'juego', 10.00, 'Logo.jpg', NULL, NULL, '2024-11-12 15:54:39', 10, 1),
(48, 'simon1', 'juego', 170.00, 'video juegos.png', NULL, NULL, '2024-11-12 16:02:22', 11, 1),
(49, 'catan', 'juego', 170.00, 'imagesCATAN.jpeg', NULL, NULL, '2024-11-12 16:04:12', 12, 1),
(50, 'Ajedrez', 'sadasd', 30.00, 'Ajedrez.jpeg', NULL, NULL, '2024-11-13 21:37:49', 13, 1),
(99, 'Producto para Prueba', 'Producto para validar clave foránea', NULL, NULL, NULL, NULL, '2024-11-13 21:49:36', NULL, 1),
(100, 'Producto de Prueba', 'Descripción de prueba', 100.00, NULL, NULL, NULL, '2024-11-13 22:01:41', NULL, 1),
(101, 'Ajedrez asdas', 'asdasdadasd', 30.00, 'Ajedrez.jpeg', NULL, NULL, '2024-11-13 22:03:09', 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int NOT NULL,
  `proveedor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contacto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int NOT NULL,
  `estatus` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`, `date_add`, `usuario_id`, `estatus`) VALUES
(31, 'helado', 'Mauricio Mamani F', 5354354, 'Bolivia-Cochabamba', '2024-11-12 15:46:38', 1, 0),
(32, 'pil', 'Claudia Rosaless', 43545476, 'Bolivia-Cochabamba', '2024-11-12 15:52:50', 1, 1),
(41, 'Ask aaaas', 'Tony Fernandez a', 87664438, 'indefinido', '2024-11-13 22:10:24', 1, 1),
(42, 'Antonio', 'Montana', 1232245, 'Zona Norte', '2024-11-13 22:10:52', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `nombre_rol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`) VALUES
(1, 'admin'),
(2, 'vendedor'),
(3, 'cliente'),
(4, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contraseña` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rol_id` int NOT NULL,
  `estatus` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contraseña`, `fecha_registro`, `rol_id`, `estatus`) VALUES
(1, 'Mauricio', 'mauri@gmail.com', '$2y$10$tm1fx0BfT8hycUg/9nyDhe84MyjigRsR8RsOCoppIRK7otpFF3VIC', '2024-09-28 18:50:48', 1, 1),
(2, 'osmar', 'ormar@gmail.com', '$2y$10$EOtNzWP4yW.prnyw9nl2Kuwn/62vvIyhqTq1yctR3gniu3ATUfWvO', '2024-10-01 12:49:37', 3, 1),
(3, 'juan', 'juan@gmail.com', '$2y$10$r4e7m/v/BpFWtlP7alVBSOqYXu94ecL7iYbro8qwn71MWQcVtLMv.', '2024-10-18 20:38:43', 3, 1),
(4, 'alex', 'alex@gmail.com', '$2y$10$Ou/RO3E5trjaiB1HWvynXO2xvdBRM5zgwbx71Ql9uNDiU8BcTJWQa', '2024-10-18 21:17:39', 3, 0),
(7, 'mauri', 'mauricio@gmail.com', '$2y$10$CR71nBiudchXn2MzyOjAvuOIL2bzPzQMJfsDaz1hPGymIzIzIOt7G', '2024-10-21 20:18:56', 1, 1),
(8, 'ana', 'ana@gmail.com', '$2y$10$kJHnKjePrKRbjXfHN.jO5.MqQ7EpOd4G1I96Jd.rLnbPH6/jGChMK', '2024-10-21 20:21:15', 1, 1),
(9, 'oli', 'oli@gmail.com', '$2y$10$DulAf9Q7YYYMtAKm8W27nez5Tq0Xa62Z4zAO/c76rhCtgLm3vQRLi', '2024-10-21 20:47:06', 2, 1),
(10, 'mauri', 'mauriciomamaniflores09@gmail.com', '$2y$10$i9Z8.q/C9f.oGjJC1oyoxexXK5bwXHIocgvRhi4eparG/spbDZQLi', '2024-10-21 22:02:33', 3, 1),
(11, 'mauri', 'mfmauricio200@gmail.com', '$2y$10$2W7qtFFk2tc1wUCXYnHTie5NgttHJ3bDtkWj7x/yED1FxA.oss486', '2024-10-21 22:25:16', 2, 1),
(12, 'Marta Contreras Cabrera', 'marta@gmail.con', '$2y$10$EdFXSp9g2/mQ.9ouiudvouU.lSOEJ0CJqtF74hNht2VnuGMnZ8wEi', '2024-10-24 21:02:03', 1, 1),
(13, 'joel', 'joel@gmail.com', '$2y$10$dHWP84nAiX3DmkiPlSkmcuI97mYyKlaVe24hSqH8WDcz3xIXHtME6', '2024-10-24 21:03:07', 2, 1),
(14, 'ale', 'ale@gmail.com', '$2y$10$pj/9rMSqSbYlBAeoWrQCEujNJFRVfe8p6vWVn4OgBHqAbAk/mIgR6', '2024-10-24 21:03:58', 3, 1),
(15, 'jhoel', 'jhoel@gmail.com', '$2y$10$xoW3hd0zwAb09qOHy0C7COvOn6P8khquTV07IfLMcasRGQajDC.jm', '2024-10-24 21:27:57', 1, 1),
(16, 'ariel', 'ariel@gmail.com', '$2y$10$OMTXgsNKkU4I1h9ld8rHXOciqzYoqT2yng.xsBkYWluoad7GL0eSW', '2024-10-24 21:28:12', 2, 0),
(17, 'dani', 'dani@gmail.com', '$2y$10$hje8fZugyQDGfKDVoZ/2se7TEZ3RLsGbyaCtpD1pb1E0d/7T4Ogra', '2024-10-24 21:28:35', 3, 1),
(18, 'alan', 'alan@gmail.com', '$2y$10$sLBixczqh0w4/3AKb5Eu0.q32p5b4n.oNO.VUK8bCqJACqmNlGAKq', '2024-10-28 20:13:40', 2, 1),
(19, 'jairo', 'jairo@gmail.com', '$2y$10$WkNZ35U2ep30EHFULXJpjOsq7ZMMzoojXShBh7IfFbRBl8qJT8rqS', '2024-10-29 20:31:25', 1, 1),
(20, 'osmar', 'osmar@host.com', '$2y$10$KuEtjUOnpFU84hHdgQv2L.dDr8AYrtD5TNQIeC21pwoNgsvcRHNGe', '2024-10-29 20:32:24', 2, 1),
(21, 'luis', 'luis@gmail.com', '$2y$10$t/w3m9TS.BGuClkxGUDdgu1Zdk5uZWZi9tv9YtuVCz9SSKN8iYUdq', '2024-10-29 20:32:44', 2, 1),
(22, 'grober', 'grober@gmail.com', '$2y$10$9MrOpq9ALPwn1bG7SO8IFOUR34DImwtQL3EtGnxIBAx0IgQ7vBPn2', '2024-10-29 20:33:10', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `fk_usuario` (`usuario`),
  ADD KEY `fk_cliente` (`codcliente`);

--
-- Indices de la tabla `historial_de_compra`
--
ALTER TABLE `historial_de_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `juegos_de_mesa`
--
ALTER TABLE `juegos_de_mesa`
  ADD PRIMARY KEY (`id_juego`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_juego` (`id_juego`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_de_compra`
--
ALTER TABLE `historial_de_compra`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `juegos_de_mesa`
--
ALTER TABLE `juegos_de_mesa`
  MODIFY `id_juego` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`codcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial_de_compra`
--
ALTER TABLE `historial_de_compra`
  ADD CONSTRAINT `historial_de_compra_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historial_de_compra_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_id_juego` FOREIGN KEY (`id_juego`) REFERENCES `juegos_de_mesa` (`id_juego`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_rol_id` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
