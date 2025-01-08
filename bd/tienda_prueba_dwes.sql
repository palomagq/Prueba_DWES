-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-01-2025 a las 13:20:37
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
-- Base de datos: `tienda_prueba_dwes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `confirmado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `item_id`, `quantity`, `confirmado`) VALUES
(1, 5, 2, 1, 1),
(2, 5, 2, 1, 1),
(3, 5, 3, 1, 1),
(4, 5, 4, 1, 1),
(5, 5, 2, 1, 1),
(6, 5, 3, 1, 1),
(7, 5, 3, 1, 1),
(8, 5, 2, 1, 1),
(9, 5, 4, 1, 1),
(10, 5, 2, 1, 1),
(11, 5, 2, 1, 1),
(12, 5, 3, 1, 1),
(13, 5, 3, 1, 1),
(14, 5, 3, 1, 1),
(15, 5, 2, 1, 1),
(16, 5, 4, 1, 1),
(17, 5, 3, 1, 1),
(18, 5, 2, 1, 1),
(19, 5, 2, 1, 1),
(20, 5, 4, 1, 1),
(21, 5, 4, 1, 1),
(22, 5, 4, 1, 1),
(23, 5, 3, 1, 1),
(24, 5, 4, 1, 1),
(25, 5, 3, 1, 1),
(26, 5, 3, 1, 1),
(27, 5, 4, 1, 1),
(28, 5, 4, 1, 1),
(29, 5, 4, 1, 1),
(30, 5, 2, 1, 1),
(31, 5, 3, 1, 1),
(32, 5, 5, 1, 1),
(33, 5, 4, 1, 1),
(34, 5, 3, 1, 1),
(35, 5, 5, 1, 1),
(36, 5, 4, 1, 1),
(37, 5, 2, 1, 1),
(38, 5, 3, 1, 1),
(39, 5, 3, 1, 1),
(40, 5, 4, 1, 1),
(41, 5, 5, 1, 1),
(42, 5, 3, 1, 1),
(43, 5, 5, 1, 1),
(44, 5, 4, 1, 1),
(45, 5, 2, 1, 1),
(46, 5, 4, 1, 1),
(47, 5, 5, 1, 1),
(48, 5, 4, 1, 1),
(49, 5, 2, 1, 1),
(50, 6, 4, 1, 1),
(51, 6, 3, 1, 1),
(52, 6, 2, 1, 1),
(53, 6, 2, 1, 1),
(54, 6, 4, 1, 1),
(55, 6, 5, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `description`) VALUES
(2, 'laptop', 560.00, 'laptop 15\"'),
(3, 'deportivas', 35.00, 'zapatos'),
(4, 'collar', 6.00, 'accesorio'),
(5, 'chaqueton', 57.00, 'ropa abrigo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` int(20) DEFAULT NULL,
  `role` enum('admin','cliente','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `telephone`, `role`) VALUES
(5, 'ana', 'aaaaaa', 'anam@gmail.com', '$2y$10$mAoHtdX7aJ8IAF5d94UFkeiE.vnpGwh6cwIj7DBRdLuW1AVZ.EpZ6', 666666666, 'cliente'),
(6, 'ana', 'martin', 'ana@gmail.com', '$2y$10$jEcPHx5FvcZWziR2T.TKzuAXtGT/l.UuSIpvmS1smBAqqLEHBjUG2', 0, 'cliente'),
(7, 'admin', 'ad', 'admin@gmail.com', '$2y$10$jEcPHx5FvcZWziR2T.TKzuAXtGT/l.UuSIpvmS1smBAqqLEHBjUG2', NULL, 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
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
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
