-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2026 a las 16:13:51
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
-- Base de datos: `pnk_inmobiliaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_propiedades`
--

CREATE TABLE `fotos_propiedades` (
  `id` int(11) NOT NULL,
  `id_propiedad` int(11) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `principal` tinyint(1) DEFAULT 0,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos_propiedades`
--

INSERT INTO `fotos_propiedades` (`id`, `id_propiedad`, `ruta`, `principal`, `fecha_subida`) VALUES
(1, 21, 'uploads/propiedades/1783137438_0_7332.png', 1, '2026-07-04 03:57:18'),
(2, 21, 'uploads/propiedades/1783137438_1_8141.png', 0, '2026-07-04 03:57:18'),
(3, 21, 'uploads/propiedades/1783137438_2_6343.png', 0, '2026-07-04 03:57:18'),
(4, 21, 'uploads/propiedades/1783137438_3_9092.png', 0, '2026-07-04 03:57:18'),
(5, 21, 'uploads/propiedades/1783137438_4_8073.png', 0, '2026-07-04 03:57:18'),
(6, 21, 'uploads/propiedades/1783137438_5_7164.png', 0, '2026-07-04 03:57:18'),
(7, 21, 'uploads/propiedades/1783137438_6_2619.png', 0, '2026-07-04 03:57:18'),
(8, 21, 'uploads/propiedades/1783137438_7_8698.png', 0, '2026-07-04 03:57:18'),
(9, 21, 'uploads/propiedades/1783137438_8_9902.jpeg', 0, '2026-07-04 03:57:18'),
(10, 21, 'uploads/propiedades/1783137438_9_2499.jpg', 0, '2026-07-04 03:57:18'),
(11, 22, 'uploads/propiedades/1783150939_0_3405.png', 0, '2026-07-04 07:42:19'),
(12, 22, 'uploads/propiedades/1783150939_1_5227.png', 1, '2026-07-04 07:42:19'),
(13, 22, 'uploads/propiedades/1783150939_2_5904.png', 0, '2026-07-04 07:42:19'),
(14, 22, 'uploads/propiedades/1783150939_3_6253.png', 0, '2026-07-04 07:42:19'),
(15, 22, 'uploads/propiedades/1783150939_4_6143.png', 0, '2026-07-04 07:42:19'),
(16, 22, 'uploads/propiedades/1783150939_5_5170.png', 0, '2026-07-04 07:42:19'),
(17, 22, 'uploads/propiedades/1783150939_6_9548.png', 0, '2026-07-04 07:42:19'),
(18, 22, 'uploads/propiedades/1783150939_7_5728.png', 0, '2026-07-04 07:42:19'),
(19, 22, 'uploads/propiedades/1783150939_8_4008.jpeg', 0, '2026-07-04 07:42:19'),
(20, 22, 'uploads/propiedades/1783150939_9_3507.jpg', 0, '2026-07-04 07:42:19'),
(21, 23, 'uploads/propiedades/1783176141_0_2291.png', 1, '2026-07-04 14:42:21'),
(22, 23, 'uploads/propiedades/1783176141_1_8899.png', 0, '2026-07-04 14:42:21'),
(23, 23, 'uploads/propiedades/1783176141_2_1583.png', 0, '2026-07-04 14:42:21'),
(24, 23, 'uploads/propiedades/1783176141_3_1350.png', 0, '2026-07-04 14:42:21'),
(25, 23, 'uploads/propiedades/1783176141_4_3971.png', 0, '2026-07-04 14:42:21'),
(26, 23, 'uploads/propiedades/1783176141_5_9830.png', 0, '2026-07-04 14:42:21'),
(27, 23, 'uploads/propiedades/1783176141_6_4278.png', 0, '2026-07-04 14:42:21'),
(28, 23, 'uploads/propiedades/1783176141_7_7799.png', 0, '2026-07-04 14:42:21'),
(29, 23, 'uploads/propiedades/1783176141_8_8576.jpeg', 0, '2026-07-04 14:42:21'),
(30, 23, 'uploads/propiedades/1783176141_9_6749.jpg', 0, '2026-07-04 14:42:21'),
(31, 24, 'uploads/propiedades/1783181309_0_6288.png', 1, '2026-07-04 16:08:30'),
(32, 24, 'uploads/propiedades/1783181310_1_8688.png', 0, '2026-07-04 16:08:30'),
(33, 24, 'uploads/propiedades/1783181310_2_3629.png', 0, '2026-07-04 16:08:30'),
(34, 24, 'uploads/propiedades/1783181310_3_4704.png', 0, '2026-07-04 16:08:30'),
(35, 24, 'uploads/propiedades/1783181310_4_8519.png', 0, '2026-07-04 16:08:30'),
(36, 24, 'uploads/propiedades/1783181310_5_2979.png', 0, '2026-07-04 16:08:30'),
(37, 24, 'uploads/propiedades/1783181310_6_1913.png', 0, '2026-07-04 16:08:30'),
(38, 24, 'uploads/propiedades/1783181310_7_3873.png', 0, '2026-07-04 16:08:30'),
(39, 24, 'uploads/propiedades/1783181310_8_9045.jpeg', 0, '2026-07-04 16:08:30'),
(40, 24, 'uploads/propiedades/1783181310_9_7967.jpg', 0, '2026-07-04 16:08:30'),
(41, 25, 'uploads/propiedades/1783370973_0_8235.png', 1, '2026-07-06 20:49:33'),
(42, 25, 'uploads/propiedades/1783370973_1_1626.png', 0, '2026-07-06 20:49:33'),
(43, 25, 'uploads/propiedades/1783370973_2_9297.png', 0, '2026-07-06 20:49:33'),
(44, 25, 'uploads/propiedades/1783370973_3_3193.png', 0, '2026-07-06 20:49:33'),
(45, 25, 'uploads/propiedades/1783370973_4_5141.png', 0, '2026-07-06 20:49:33'),
(46, 25, 'uploads/propiedades/1783370973_5_5396.png', 0, '2026-07-06 20:49:33'),
(47, 25, 'uploads/propiedades/1783370973_6_5149.png', 0, '2026-07-06 20:49:33'),
(48, 25, 'uploads/propiedades/1783370973_7_3373.png', 0, '2026-07-06 20:49:33'),
(49, 25, 'uploads/propiedades/1783370973_8_2294.jpeg', 0, '2026-07-06 20:49:33'),
(50, 25, 'uploads/propiedades/1783370973_9_5361.jpg', 0, '2026-07-06 20:49:33'),
(51, 26, 'uploads/propiedades/1783374879_0_8625.png', 1, '2026-07-06 21:54:39'),
(52, 26, 'uploads/propiedades/1783374879_1_2956.png', 0, '2026-07-06 21:54:39'),
(53, 26, 'uploads/propiedades/1783374879_2_9908.png', 0, '2026-07-06 21:54:39'),
(54, 26, 'uploads/propiedades/1783374879_3_3969.png', 0, '2026-07-06 21:54:39'),
(55, 26, 'uploads/propiedades/1783374879_4_2173.png', 0, '2026-07-06 21:54:39'),
(56, 26, 'uploads/propiedades/1783374879_5_2404.png', 0, '2026-07-06 21:54:39'),
(57, 26, 'uploads/propiedades/1783374879_6_6182.png', 0, '2026-07-06 21:54:39'),
(58, 26, 'uploads/propiedades/1783374879_7_2787.png', 0, '2026-07-06 21:54:39'),
(59, 26, 'uploads/propiedades/1783374879_8_5916.jpeg', 0, '2026-07-06 21:54:39'),
(60, 26, 'uploads/propiedades/1783374879_9_5001.jpg', 0, '2026-07-06 21:54:39'),
(61, 27, 'uploads/propiedades/1783433156_0_4745.png', 1, '2026-07-07 14:05:56'),
(62, 27, 'uploads/propiedades/1783433156_1_9588.png', 0, '2026-07-07 14:05:56'),
(63, 27, 'uploads/propiedades/1783433156_2_6456.png', 0, '2026-07-07 14:05:56'),
(64, 27, 'uploads/propiedades/1783433156_3_2380.png', 0, '2026-07-07 14:05:56'),
(65, 27, 'uploads/propiedades/1783433156_4_6599.png', 0, '2026-07-07 14:05:56'),
(66, 27, 'uploads/propiedades/1783433156_5_3651.png', 0, '2026-07-07 14:05:56'),
(67, 27, 'uploads/propiedades/1783433156_6_3681.png', 0, '2026-07-07 14:05:56'),
(68, 27, 'uploads/propiedades/1783433156_7_4217.png', 0, '2026-07-07 14:05:56'),
(69, 27, 'uploads/propiedades/1783433156_8_8685.jpeg', 0, '2026-07-07 14:05:56'),
(70, 27, 'uploads/propiedades/1783433156_9_5203.jpg', 0, '2026-07-07 14:05:56'),
(71, 28, 'uploads/propiedades/1783433257_0_2483.png', 1, '2026-07-07 14:07:37'),
(72, 28, 'uploads/propiedades/1783433257_1_7144.png', 0, '2026-07-07 14:07:37'),
(73, 28, 'uploads/propiedades/1783433257_2_9304.png', 0, '2026-07-07 14:07:37'),
(74, 28, 'uploads/propiedades/1783433257_3_3152.png', 0, '2026-07-07 14:07:37'),
(75, 28, 'uploads/propiedades/1783433257_4_9103.png', 0, '2026-07-07 14:07:37'),
(76, 28, 'uploads/propiedades/1783433257_5_8699.png', 0, '2026-07-07 14:07:37'),
(77, 28, 'uploads/propiedades/1783433257_6_3947.png', 0, '2026-07-07 14:07:37'),
(78, 28, 'uploads/propiedades/1783433257_7_2774.png', 0, '2026-07-07 14:07:37'),
(79, 28, 'uploads/propiedades/1783433257_8_5868.jpeg', 0, '2026-07-07 14:07:37'),
(80, 28, 'uploads/propiedades/1783433257_9_7615.jpg', 0, '2026-07-07 14:07:37'),
(81, 29, 'uploads/propiedades/1783434050_0_9245.png', 1, '2026-07-07 14:20:50'),
(82, 29, 'uploads/propiedades/1783434050_1_9054.png', 0, '2026-07-07 14:20:50'),
(83, 29, 'uploads/propiedades/1783434050_2_7202.png', 0, '2026-07-07 14:20:50'),
(84, 29, 'uploads/propiedades/1783434050_3_3315.png', 0, '2026-07-07 14:20:50'),
(85, 29, 'uploads/propiedades/1783434050_4_2955.png', 0, '2026-07-07 14:20:50'),
(86, 29, 'uploads/propiedades/1783434050_5_4655.png', 0, '2026-07-07 14:20:50'),
(87, 29, 'uploads/propiedades/1783434050_6_3191.png', 0, '2026-07-07 14:20:50'),
(88, 29, 'uploads/propiedades/1783434050_7_8625.png', 0, '2026-07-07 14:20:50'),
(91, 30, 'uploads/propiedades/1783565453_0_6111.png', 1, '2026-07-09 02:50:53'),
(92, 30, 'uploads/propiedades/1783565453_1_1437.png', 0, '2026-07-09 02:50:53'),
(93, 30, 'uploads/propiedades/1783565453_2_5188.png', 0, '2026-07-09 02:50:53'),
(94, 30, 'uploads/propiedades/1783565453_3_8647.png', 0, '2026-07-09 02:50:53'),
(95, 30, 'uploads/propiedades/1783565453_4_9111.png', 0, '2026-07-09 02:50:53'),
(96, 30, 'uploads/propiedades/1783565453_5_4657.png', 0, '2026-07-09 02:50:53'),
(97, 30, 'uploads/propiedades/1783565453_6_9737.png', 0, '2026-07-09 02:50:53'),
(98, 30, 'uploads/propiedades/1783565453_7_7532.png', 0, '2026-07-09 02:50:53'),
(99, 30, 'uploads/propiedades/1783565453_8_8228.jpeg', 0, '2026-07-09 02:50:53'),
(100, 30, 'uploads/propiedades/1783565453_9_7333.jpg', 0, '2026-07-09 02:50:53'),
(101, 31, 'uploads/propiedades/1783571984_0_5355.png', 0, '2026-07-09 04:39:44'),
(102, 31, 'uploads/propiedades/1783571984_1_7589.png', 1, '2026-07-09 04:39:44'),
(103, 31, 'uploads/propiedades/1783571984_2_3339.png', 0, '2026-07-09 04:39:44'),
(104, 31, 'uploads/propiedades/1783571984_3_8906.png', 0, '2026-07-09 04:39:44'),
(105, 31, 'uploads/propiedades/1783571984_4_2193.png', 0, '2026-07-09 04:39:44'),
(106, 31, 'uploads/propiedades/1783571984_5_2120.png', 0, '2026-07-09 04:39:44'),
(107, 31, 'uploads/propiedades/1783571984_6_2183.png', 0, '2026-07-09 04:39:44'),
(108, 31, 'uploads/propiedades/1783571984_7_8961.png', 0, '2026-07-09 04:39:44'),
(109, 31, 'uploads/propiedades/1783571984_8_3364.jpeg', 0, '2026-07-09 04:39:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestores`
--

CREATE TABLE `gestores` (
  `id` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `certificado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gestores`
--

INSERT INTO `gestores` (`id`, `rut`, `nombre`, `fechaNacimiento`, `correo`, `password`, `sexo`, `telefono`, `certificado`) VALUES
(13, '11.111.111-1', 'Cesar', '2026-07-02', 'gestor2066@cfn.cl', '$2y$10$g5Pslda03Vf4Y6Jwef/9D.EmAzvDvEE9jaT8YV/FcLx9OFj/OzsMu', 'Masculino', '930673693', '1783605020_NAC_500704768420_29364373.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE `propiedades` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `dormitorios` int(11) DEFAULT NULL,
  `banos` int(11) DEFAULT NULL,
  `precio` decimal(12,2) DEFAULT NULL,
  `precioUF` decimal(10,2) DEFAULT NULL,
  `areaConstruida` int(11) DEFAULT NULL,
  `areaTerreno` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `visita` varchar(10) DEFAULT NULL,
  `caracteristicas` text DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'Publicada',
  `comuna` varchar(100) DEFAULT NULL,
  `sector` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `tipo`, `descripcion`, `dormitorios`, `banos`, `precio`, `precioUF`, `areaConstruida`, `areaTerreno`, `fecha`, `visita`, `caracteristicas`, `id_usuario`, `estado`, `comuna`, `sector`) VALUES
(23, 'Terreno', 'Probando3', 6, 2, 450000.00, 5.76, 50000, 10000, '2026-07-08', 'No', 'Bodega, Estacionamiento, Cocina Amoblada, Antejardín', 38, 'Publicada', 'serena', 'el milagro'),
(24, 'Terreno', 'Probando3', 6, 2, 45000000.00, 575.76, 10000, 250, '2026-07-15', 'No', 'Estacionamiento, Antejardín', 38, 'Publicada', 'serena', 'cuatro esquina'),
(26, 'Terreno', 'PRUEBA123', 5, 2, 5000000.00, 63.97, 50000, 10000, '2026-07-30', 'No', 'Bodega, Estacionamiento, Logia, Cocina Amoblada', 27, 'Publicada', 'ovalle', 'LAS AGUAS'),
(27, 'Casa', 'Los olivos', 5, 2, 45000000.00, 575.76, 50000, 1000, '2026-08-07', 'No', 'Bodega, Estacionamiento, Cocina Amoblada', 38, 'Publicada', 'serena', 'aeropuerto'),
(29, 'Casa', 'Probando2026', 7, 5, 45000000.00, 575.76, 3000, 400, '2026-07-02', 'Sí', 'Bodega, Estacionamiento, Logia', 38, 'Publicada', 'serena', 'los larrines'),
(31, 'Departamento', 'DepartamentoPrueba', 5, 1, 45000000.00, 575.76, 250, 0, '2026-07-17', 'No', 'Bodega, Estacionamiento, Logia, Cocina Amoblada', 38, 'Publicada', 'ovalle', 'tambillos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietarios`
--

CREATE TABLE `propietarios` (
  `id` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `propiedad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propietarios`
--

INSERT INTO `propietarios` (`id`, `rut`, `nombre`, `fecha`, `correo`, `password`, `sexo`, `telefono`, `propiedad`) VALUES
(12, '26.120.582-3', 'Cesarr', '2026-06-02', 'cesar@gmail.com', '$2y$10$hDJGTzNxYLN2SoPRTlez1.20X2EaidhE.5Bnz2L1q.RWFDgZZzeAS', 'Masculino', '930673693', '215'),
(15, '26.120.587-6', 'PruebaPropietarios', '2026-06-04', 'Propietario@cfn.cl', '$2y$10$M3dzMGiJGi.EtLLwIDCBn.WwevLq0KbjfRJs77vkUmIqLI3sxH7ji', 'Masculino', '930673693', '215'),
(16, '26.120.582-2', 'Cesar1955', '2026-06-03', 'ingresa@cfn.cl', '$2y$10$NlQLj3tNc7N3caxv3ilKkuG6nmy0D6bWw9NcnpxSui5M/jkXhf4fu', 'Masculino', '930673693', '215'),
(18, '26.120.582-3', 'Cesar', '2026-06-03', 'ingresa2@cfn.cl', '$2y$10$mnJSVW9./tkFprgQoAigP.feu0D4PvkxWLBz48gbFJOK.losRElg.', 'Femenino', '930673693', '215'),
(20, '11.111.111-1', 'Probando', '2026-06-03', 'probando3@cfn.cl', '$2y$10$xFx9TZG74Q3fxaJCXv/gauqGNFkrVBeWsmr1vCcXmFEJpAIHhLC..', 'Masculino', '930673693', '215'),
(21, '15.318.152-6', 'Diego', '2026-06-10', 'diego@cfn.cl', '$2y$10$Vn1TG1cyxcpQ7/pmLBUAWe5z84hz8izmF9durNYzeaKSfD2kDPzAC', 'Otro', '930673693', '215'),
(22, '26.120.582-3', 'Prueba1', '2026-07-01', 'prueba1995@cfn.cl', '$2y$10$3K84l22Rgc9APiRhekHB1e7vF9vnQFuLUqcWTokvynr1eLD4a20da', 'Masculino', '930673693', '215'),
(23, '26.120.582-3', 'Prueba1955', '2026-07-08', 'Propietario1955@cfn.cl', '$2y$10$qOmy5C./8s97RYj2O4rwG.A/brAmlxjOvnKSsVIqVGtVcFRkY1V/a', 'Femenino', '930673693', '215'),
(24, '11.111.111-1', 'katherine', '2026-07-13', 'Propietariokathe@cfn.cl', '$2y$10$1a7IToEXuObqNBjavDqIZuxzdvVHrMZ6yDxy719DzM.SLDT0.q3fK', 'Masculino', '930673693', '215'),
(25, '18.316.138-5', 'katherine', '2026-07-01', 'Pruebakathe@cfn.cl', '$2y$10$V8YOkVxuufI96ccFo2br6eGNycpsfHf0xOFWLUa3Elnu.GgDgkZFe', 'Masculino', '930673693', '215'),
(26, '26.120.582-3', 'ddadadsad', '2026-07-01', 'cesar@cfn.cl', '$2y$10$tkya8B.DSk39hCm32loLCuewd7pZqSdCepYc3PVKG1bqf0D7zZBXG', 'Masculino', '930673693', '215');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Pendiente',
  `rol` varchar(20) NOT NULL DEFAULT 'Propietario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rut`, `nombre`, `correo`, `tipo`, `password`, `estado`, `rol`) VALUES
(25, '26.120.582-3', 'Prueba5', 'prueba@gmail.com', 'Propietario', '$2y$10$nTXFW7njPzDh07nfLK8LUu7ynd1sQMHorLiZmq05Ffuacm6rYwtAm', 'Activo', 'Propietario'),
(27, '11.111.111-1', 'Cesar Administrador', 'admin@pnk.cl', 'Administrador', '$2y$10$tYU6XUuS0Ly5lhW2l7HnAOSND0I8k.1PNfNr4kTsw6Cqe5ZoHShPC', 'Activo', 'Administrador'),
(28, '11.111.111-5', 'Cesar Administrador', 'admin@pnk.cl', 'Administrador', '$2y$10$04MOBjiEqnAz22YsbCYEmOgb9xS1nqoCK/q1dE0lR/IOWCHRAzbNS', 'Activo', 'Administrador'),
(29, '26.120.582-2', 'Cesar1955', 'ingresa@cfn.cl', 'Propietario', '$2y$10$NlQLj3tNc7N3caxv3ilKkuG6nmy0D6bWw9NcnpxSui5M/jkXhf4fu', 'Activo', 'Propietario'),
(31, '26.120.582-3', 'Cesar', 'ingresa2@cfn.cl', 'Propietario', '$2y$10$mnJSVW9./tkFprgQoAigP.feu0D4PvkxWLBz48gbFJOK.losRElg.', 'Pendiente', 'Propietario'),
(35, '11.111.111-1', 'Probando', 'probando3@cfn.cl', 'Propietario', '$2y$10$xFx9TZG74Q3fxaJCXv/gauqGNFkrVBeWsmr1vCcXmFEJpAIHhLC..', 'Activo', 'Propietario'),
(38, '15.318.152-6', 'Diego', 'diego@cfn.cl', 'Propietario', '$2y$10$Vn1TG1cyxcpQ7/pmLBUAWe5z84hz8izmF9durNYzeaKSfD2kDPzAC', 'Activo', 'Propietario'),
(42, '26.120.582-3', 'Prueba1', 'prueba1995@cfn.cl', 'Propietario', '$2y$10$3K84l22Rgc9APiRhekHB1e7vF9vnQFuLUqcWTokvynr1eLD4a20da', 'Activo', 'Propietario'),
(54, '26.120.582-3', 'ddadadsad', 'cesar@cfn.cl', 'Propietario', '$2y$10$tkya8B.DSk39hCm32loLCuewd7pZqSdCepYc3PVKG1bqf0D7zZBXG', 'Pendiente', 'Propietario'),
(55, '11.111.111-1', 'Cesar', 'gestor2066@cfn.cl', 'Gestor', '$2y$10$g5Pslda03Vf4Y6Jwef/9D.EmAzvDvEE9jaT8YV/FcLx9OFj/OzsMu', 'Activo', 'Gestor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fotos_propiedades`
--
ALTER TABLE `fotos_propiedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gestores`
--
ALTER TABLE `gestores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `propietarios`
--
ALTER TABLE `propietarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fotos_propiedades`
--
ALTER TABLE `fotos_propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `gestores`
--
ALTER TABLE `gestores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `propietarios`
--
ALTER TABLE `propietarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
