-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-03-2025 a las 12:33:05
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
-- Base de datos: `warflexbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `armas`
--

CREATE TABLE `armas` (
  `Id_armas` bigint(20) NOT NULL,
  `nom_arma` char(30) NOT NULL,
  `cant_balas` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `Id_tipo_arma` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `armas`
--

INSERT INTO `armas` (`Id_armas`, `nom_arma`, `cant_balas`, `foto`, `Id_tipo_arma`) VALUES
(1, 'puño', 0, 'mano.png', 1),
(2, 'Pistola Pesada', 13, 'pistola_pesada.png', 2),
(3, 'Pistola Doble', 15, 'pistola_doble.png', 2),
(4, 'Pistola Mecha', 14, 'pistola_mecha.png', 2),
(5, 'Francotirador Pesado', 15, 'franco_pesado.png', 3),
(6, 'Francotirador Storm Scout', 25, 'franco_storm_scout', 3),
(7, 'Francotirador Dragons Breath', 35, 'franco_dragons_breath', 3),
(8, 'Ametralladora Ligera', 33, 'ametralladora_ligera.png', 4),
(9, 'Ametralladora Minigun', 40, 'ametralladora_minigun', 4),
(10, 'Ametralladora Sideways', 50, 'ametralladora_sideways.png', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `Id_avatar` bigint(20) NOT NULL,
  `Nom_avatar` char(30) DEFAULT NULL,
  `Foto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`Id_avatar`, `Nom_avatar`, `Foto`) VALUES
(1, 'Peely', 'peely.png'),
(2, 'Laguna', 'laguna.png'),
(3, 'Raven', 'raven.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_sala`
--

CREATE TABLE `detalle_sala` (
  `Id_detalle` bigint(20) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `id_sala` bigint(20) DEFAULT NULL,
  `id_batalla` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadistica`
--

CREATE TABLE `estadistica` (
  `id_estadistica` bigint(20) NOT NULL,
  `daño_total` int(11) DEFAULT NULL,
  `puntos_acumu` int(11) DEFAULT NULL,
  `daño` int(11) DEFAULT NULL,
  `id_tipo_arma` bigint(20) DEFAULT NULL,
  `id_batalla` bigint(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `Id_estado` bigint(20) NOT NULL,
  `Nom_estado` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`Id_estado`, `Nom_estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Ocupada'),
(4, 'Libre'),
(5, 'bloqueado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_batalla` bigint(20) NOT NULL,
  `Fecha_ini` datetime DEFAULT NULL,
  `Fecha_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_sesion`
--

CREATE TABLE `historial_sesion` (
  `Id_historial` bigint(20) NOT NULL,
  `fech_sesion` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `id_estado` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mundo`
--

CREATE TABLE `mundo` (
  `Id_mundo` bigint(20) NOT NULL,
  `Nom_mundo` char(30) DEFAULT NULL,
  `Foto` varchar(50) DEFAULT NULL,
  `nivel` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mundo`
--

INSERT INTO `mundo` (`Id_mundo`, `Nom_mundo`, `Foto`, `nivel`) VALUES
(1, 'Athenea', 'athenea.png', 1),
(2, 'Helios', 'helios.png', 2),
(3, 'Artemis', 'artemis.png', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `Id_nivel` bigint(20) NOT NULL,
  `nom_nivel` char(30) DEFAULT NULL,
  `Puntos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`Id_nivel`, `nom_nivel`, `Puntos`) VALUES
(1, 'Nivel 1', 0),
(2, 'Nivel 2', 500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id_rol` bigint(20) NOT NULL,
  `Nom_rol` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id_rol`, `Nom_rol`) VALUES
(1, 'Usuario'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `Id_sala` bigint(20) NOT NULL,
  `Id_mundo` bigint(20) DEFAULT NULL,
  `id_estado` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_arma`
--

CREATE TABLE `tipo_arma` (
  `Id_tipo_arma` bigint(20) NOT NULL,
  `nom_tipo_arma` char(30) DEFAULT NULL,
  `daño` int(11) DEFAULT NULL,
  `nivel` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_arma`
--

INSERT INTO `tipo_arma` (`Id_tipo_arma`, `nom_tipo_arma`, `daño`, `nivel`) VALUES
(1, 'mano', 1, 1),
(2, 'pistola', 2, 1),
(3, 'francotirador', 20, 2),
(4, 'ametralladora', 10, 2),
(5, 'mano', 1, 2),
(6, 'pistola', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `username` varchar(50) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `Contraseña` varchar(100) DEFAULT NULL,
  `vida` int(11) DEFAULT NULL,
  `puntos` int(11) DEFAULT NULL,
  `Id_avatar` bigint(20) DEFAULT NULL,
  `Id_nivel` bigint(20) DEFAULT NULL,
  `Id_Estado` bigint(20) DEFAULT NULL,
  `Id_rol` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`username`, `correo`, `Contraseña`, `vida`, `puntos`, `Id_avatar`, `Id_nivel`, `Id_Estado`, `Id_rol`) VALUES
('Alan123', 'alambrito@gmail.com', '12345', NULL, NULL, NULL, NULL, NULL, 2),
('gaby', 'gabidmarin06@gmail.com', '$2y$10$GAVzEYB6foYF6beMSHvT0uIr.ezk8TvZSUooYLxbyI8tJJbCTm.nS', 100, 250, 1, NULL, 1, 1),
('gaby123', 'gabrieladeviamarin@gmail.com', '$2y$10$ktKeaO8c1CqsFyaE98GRGuL/m2fZ3KkSoPs7IskCBjDltXwgI.KRi', 100, 0, 1, NULL, 1, 1),
('noviodgaby', 'miguelparraduran926@gmail.com', '$2y$10$HzkV/JQZyXbQNNnaxH4xz.kj.0egEFz5OXm.5.dPT.NeSGoQtutVu', 100, 0, 1, NULL, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`Id_armas`),
  ADD KEY `tipo_arma` (`Id_tipo_arma`);

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`Id_avatar`);

--
-- Indices de la tabla `detalle_sala`
--
ALTER TABLE `detalle_sala`
  ADD PRIMARY KEY (`Id_detalle`),
  ADD KEY `batalla` (`id_batalla`),
  ADD KEY `username` (`username`),
  ADD KEY `sala` (`id_sala`);

--
-- Indices de la tabla `estadistica`
--
ALTER TABLE `estadistica`
  ADD PRIMARY KEY (`id_estadistica`),
  ADD KEY `id_tipo_arma` (`id_tipo_arma`),
  ADD KEY `id_batalla` (`id_batalla`),
  ADD KEY `username` (`username`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`Id_estado`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_batalla`);

--
-- Indices de la tabla `historial_sesion`
--
ALTER TABLE `historial_sesion`
  ADD PRIMARY KEY (`Id_historial`);

--
-- Indices de la tabla `mundo`
--
ALTER TABLE `mundo`
  ADD PRIMARY KEY (`Id_mundo`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`Id_nivel`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id_rol`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`Id_sala`),
  ADD KEY `mundo` (`Id_mundo`);

--
-- Indices de la tabla `tipo_arma`
--
ALTER TABLE `tipo_arma`
  ADD PRIMARY KEY (`Id_tipo_arma`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`username`),
  ADD KEY `Rol` (`Id_rol`),
  ADD KEY `Avatar` (`Id_avatar`),
  ADD KEY `Estado` (`Id_Estado`),
  ADD KEY `Nivel` (`Id_nivel`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `armas`
--
ALTER TABLE `armas`
  MODIFY `Id_armas` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `Id_avatar` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_sala`
--
ALTER TABLE `detalle_sala`
  MODIFY `Id_detalle` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadistica`
--
ALTER TABLE `estadistica`
  MODIFY `id_estadistica` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `Id_estado` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_batalla` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_sesion`
--
ALTER TABLE `historial_sesion`
  MODIFY `Id_historial` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mundo`
--
ALTER TABLE `mundo`
  MODIFY `Id_mundo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `Id_nivel` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id_rol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `Id_sala` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_arma`
--
ALTER TABLE `tipo_arma`
  MODIFY `Id_tipo_arma` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `armas`
--
ALTER TABLE `armas`
  ADD CONSTRAINT `tipo_arma` FOREIGN KEY (`id_tipo_arma`) REFERENCES `tipo_arma` (`Id_tipo_arma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_sala`
--
ALTER TABLE `detalle_sala`
  ADD CONSTRAINT `batalla` FOREIGN KEY (`id_batalla`) REFERENCES `eventos` (`id_batalla`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sala` FOREIGN KEY (`id_sala`) REFERENCES `sala` (`Id_sala`) ON UPDATE CASCADE,
  ADD CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `usuario` (`username`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `estadistica`
--
ALTER TABLE `estadistica`
  ADD CONSTRAINT `estadistica_ibfk_1` FOREIGN KEY (`id_tipo_arma`) REFERENCES `tipo_arma` (`Id_tipo_arma`),
  ADD CONSTRAINT `estadistica_ibfk_2` FOREIGN KEY (`id_batalla`) REFERENCES `eventos` (`id_batalla`),
  ADD CONSTRAINT `estadistica_ibfk_3` FOREIGN KEY (`username`) REFERENCES `usuario` (`username`);

--
-- Filtros para la tabla `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `mundo` FOREIGN KEY (`Id_mundo`) REFERENCES `mundo` (`Id_mundo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `Avatar` FOREIGN KEY (`Id_avatar`) REFERENCES `avatar` (`Id_avatar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Estado` FOREIGN KEY (`Id_Estado`) REFERENCES `estado` (`Id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Nivel` FOREIGN KEY (`Id_nivel`) REFERENCES `niveles` (`Id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Rol` FOREIGN KEY (`Id_rol`) REFERENCES `rol` (`Id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
