-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2026 a las 04:06:24
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
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `raza` varchar(100) NOT NULL,
  `nom_mascota` varchar(100) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Aceptada','Cancelada') NOT NULL DEFAULT 'Pendiente',
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `id_usuario`, `fecha`, `hora`, `raza`, `nom_mascota`, `motivo`, `estado`, `telefono`) VALUES
(5, 6, '2026-05-30', '10:00:00', 'Mastin Napolitano ', 'Mr.Rockstar', 'Vomito', 'Aceptada', '9995432345'),
(6, 9, '2026-06-02', '10:00:00', 'Mastin Napolitano ', 'Mr.Rockstar', 'Sintomas raros,dolores raros', 'Pendiente', '1234567890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `fecha`, `hora`, `disponible`) VALUES
(1, '2026-05-22', '09:00:00', 1),
(2, '2026-05-22', '10:00:00', 1),
(3, '2026-05-22', '11:00:00', 1),
(4, '2026-05-23', '09:00:00', 1),
(5, '2026-05-23', '15:00:00', 1),
(6, '2026-05-24', '10:00:00', 1),
(7, '2026-05-24', '16:00:00', 1),
(8, '2026-05-30', '10:00:00', 0),
(9, '2026-06-01', '22:00:00', 1),
(10, '2026-06-01', '21:00:00', 1),
(11, '2026-05-23', '00:00:00', 1),
(12, '2026-05-31', '10:00:00', 1),
(13, '2026-06-02', '10:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `categoria` enum('medicina','comida','juguete') NOT NULL,
  `imagen` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `cantidad`, `categoria`, `imagen`) VALUES
(1, 'Frontline Plus', 'Antipulgas y garrapatas spot-on', 320.00, 15, 'medicina', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1778621315/300f3589-6e3b-4165-9e57-ba8780258397.png'),
(2, 'Drontal Plus', 'Desparasitante interno para perros', 180.00, 19, 'medicina', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1778621966/4f8b0f49-5db3-41fc-887d-dd8371bd5eaa.png'),
(3, 'Royal Canin Maxi', 'Croquetas para razas grandes adultas 15kg', 950.00, 9, 'comida', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1778621110/071c7b1f-6c55-4bf7-8deb-741a5bc9afbd.png'),
(4, 'Premios', 'Premios para perros', 380.00, 10, 'comida', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1778621216/790c7108-811f-4f9c-9c2e-d47bacd05600.png'),
(5, 'Kong Classic', 'Juguete rellenable resistente talla L', 280.00, 30, 'juguete', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1778621255/f046ef79-81fb-42c0-83c2-8b389189405f.png'),
(6, 'Pelota de hule', 'Pelota de rebote resistente a mordidas', 95.00, 35, 'juguete', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1778621293/3c4d3352-7e66-4b13-b265-f39e2629c889.png'),
(7, 'Medicamento', 'Para el dolor de los huesos ', 400.00, 20, 'medicina', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1779395782/yrntdvd1exiwciawpa0u.webp'),
(10, 'Croquetas', 'Alimento perro', 500.00, 30, 'comida', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1779412112/mztpkukffkplncnhcns8.avif'),
(11, 'Croquetas', 'Alimento perro', 500.00, 5, 'comida', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1779413654/asc1rxnklqta6e9dusio.avif'),
(12, 'alimento gato', 'alimento para gato cuida sus riñones', 1500.00, 10, 'comida', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1779476515/zrej2icc4pfhn46dqlhf.webp'),
(13, 'Galletas', 'Premios para perro ', 30.00, 50, 'comida', 'https://res.cloudinary.com/dwj052lw2/image/upload/v1779492992/thwm4ojugilvf4srt2is.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `role`) VALUES
(1, 'Administrador', 'pedrito@gmail.com', 'JustRide12', 'admin'),
(2, 'Cliente Demo', 'cloudcloudsec@gmail.com', 'JustRide12', 'admin'),
(3, 'Giovanni', 'gio@gmail.com', '1234', 'user'),
(4, 'raul', 'raul@gmail.com', '1234', 'user'),
(5, 'Pedro', 'ale@gmail.com', '1234', 'user'),
(6, 'Giovanni', 'g@gmail.com', '1234', 'user'),
(7, 'M', 'M@gmail.com', '1234', 'user'),
(8, 'Javier', 'J@gmail.com', 'Liz12', 'user'),
(9, 'Giovanni ', 'g1@gmail.com', '1234', 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_usuario`, `id_producto`, `cantidad`, `total`, `fecha`) VALUES
(1, 2, 4, 5, 1900.00, '2026-05-21 14:43:00'),
(2, 2, 1, 1, 320.00, '2026-05-21 16:13:01'),
(3, 2, 1, 1, 320.00, '2026-05-21 16:13:03'),
(4, 2, 1, 1, 320.00, '2026-05-21 16:16:13'),
(5, 2, 5, 1, 280.00, '2026-05-21 16:16:26'),
(6, 2, 1, 1, 320.00, '2026-05-21 16:16:26'),
(7, 2, 1, 11, 3520.00, '2026-05-21 18:36:39'),
(8, 5, 5, 1, 280.00, '2026-05-21 19:04:52'),
(9, 5, 1, 1, 320.00, '2026-05-21 19:04:52'),
(10, 6, 4, 13, 4940.00, '2026-05-21 19:29:59'),
(11, 6, 1, 3, 960.00, '2026-05-22 12:59:50'),
(12, 6, 3, 1, 950.00, '2026-05-22 13:42:41'),
(13, 6, 2, 1, 180.00, '2026-05-22 13:42:41'),
(14, 9, 1, 16, 5120.00, '2026-05-22 17:37:34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_horario` (`fecha`,`hora`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
