-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 04, 2022 at 10:30 PM
-- Server version: 10.5.15-MariaDB-0+deb11u1
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bodega`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL,
  `descripcion_categoria` varchar(255) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion_categoria`, `date_added`) VALUES
(30, 'Herramientas', '', '2022-08-02'),
(31, 'Material', '', '2022-08-02');

-- --------------------------------------------------------

--
-- Table structure for table `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nota` varchar(255) NOT NULL,
  `referencia` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tipo` varchar(1) DEFAULT NULL COMMENT '0- Add, 1- Descargo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `historial`
--

INSERT INTO `historial` (`id_historial`, `id_producto`, `user_id`, `fecha`, `nota`, `referencia`, `cantidad`, `tipo`) VALUES
(192, 80, 1, '2022-08-02', 'Franklin agrego 2 producto(s) al inventario', '1', 2, '0'),
(193, 81, 1, '2022-08-02', 'Franklin agrego 100 producto(s) al inventario', '312', 100, '0'),
(194, 80, 1, '2022-08-03', 'Franklin descargo 1 producto(s) del inventario', '072517', 1, '1'),
(195, 80, 1, '2022-08-03', 'Franklin agrego 1 producto(s) al inventario', '072517', 1, '0'),
(196, 80, 1, '2022-08-03', 'Franklin descargo 1 producto(s) del inventario', '072517', 1, '1'),
(197, 80, 1, '2022-08-03', 'Franklin descargo 1 producto(s) del inventario', '072517', 1, '1'),
(198, 80, 1, '2022-08-03', 'Franklin agrego 1 producto(s) al inventario', '072517', 1, '0'),
(199, 80, 1, '2022-08-03', 'Franklin descargo 1 producto(s) del inventario', '072517', 1, '1'),
(200, 80, 1, '2022-08-03', 'Franklin agrego 2 producto(s) al inventario', '072517', 2, '0'),
(201, 81, 1, '2022-08-04', 'Franklin descargo 1 producto(s) del inventario', '312', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` char(20) NOT NULL,
  `nombre_producto` char(255) NOT NULL,
  `date_added` date NOT NULL,
  `precio_producto` double NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `entrada_producto` int(50) DEFAULT NULL,
  `salida_producto` int(50) DEFAULT NULL,
  `imagen_producto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_producto`, `codigo_producto`, `nombre_producto`, `date_added`, `precio_producto`, `stock`, `id_categoria`, `entrada_producto`, `salida_producto`, `imagen_producto`) VALUES
(80, '072517', 'TALADRO', '2022-08-02', 90, 2, 30, 6, 4, '/02-08-22-14-24-34-taladro.jpg'),
(81, '312', 'TORNILLOS', '2022-08-02', 0.3, 99, 31, 100, 1, '/02-08-22-14-41-52-tornillos.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `firstname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `date_added` date NOT NULL,
  `tipo_usuario` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '1- Admin,     0- Normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `user_name`, `user_password_hash`, `user_email`, `date_added`, `tipo_usuario`) VALUES
(1, 'Franklin', 'Torres', 'root', '$2y$10$Q4JpU0BtU5Ljoxbciuy86euqrsYUcQ9NUiZQ/KoikeGWN6KER8Tb.', 'franklintorres13620@gmail.com', '2022-04-11', 'Admin'),
(3, 'Enoc', 'Amayaa', 'enoc', '$2y$10$rCo2GbCGcDNM4lJr1h34w.E0nFQUNATombqaY0uuImhH4kLBTzHY2', 'enoc@gmail.com', '2022-08-02', 'Personal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `products` (`id_producto`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
