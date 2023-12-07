-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2023 a las 07:16:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `audiora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albumartistas`
--

CREATE TABLE `albumartistas` (
  `AlbumArtistaID` int(11) NOT NULL,
  `CancionID` int(11) DEFAULT NULL,
  `ArtistaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

CREATE TABLE `artistas` (
  `ArtistaID` int(11) NOT NULL,
  `NombreArtista` varchar(255) NOT NULL,
  `RutaImagenArtista` varchar(255) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `CancionID` int(11) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `RutaArchivo` varchar(255) NOT NULL,
  `FechaCreacion` date NOT NULL,
  `Duracion` time NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `ArtistaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialreproduccion`
--

CREATE TABLE `historialreproduccion` (
  `HistorialID` int(11) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `CancionID` int(11) DEFAULT NULL,
  `FechaReproduccion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioID` int(11) NOT NULL,
  `NombreUsuario` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `albumartistas`
--
ALTER TABLE `albumartistas`
  ADD PRIMARY KEY (`AlbumArtistaID`),
  ADD KEY `CancionID` (`CancionID`),
  ADD KEY `ArtistaID` (`ArtistaID`);

--
-- Indices de la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`ArtistaID`),
  ADD KEY `UsuarioID` (`UsuarioID`);

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`CancionID`),
  ADD KEY `UsuarioID` (`UsuarioID`),
  ADD KEY `ArtistaID` (`ArtistaID`);

--
-- Indices de la tabla `historialreproduccion`
--
ALTER TABLE `historialreproduccion`
  ADD PRIMARY KEY (`HistorialID`),
  ADD KEY `UsuarioID` (`UsuarioID`),
  ADD KEY `CancionID` (`CancionID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `albumartistas`
--
ALTER TABLE `albumartistas`
  MODIFY `AlbumArtistaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `artistas`
--
ALTER TABLE `artistas`
  MODIFY `ArtistaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `CancionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historialreproduccion`
--
ALTER TABLE `historialreproduccion`
  MODIFY `HistorialID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albumartistas`
--
ALTER TABLE `albumartistas`
  ADD CONSTRAINT `albumartistas_ibfk_1` FOREIGN KEY (`CancionID`) REFERENCES `canciones` (`CancionID`),
  ADD CONSTRAINT `albumartistas_ibfk_2` FOREIGN KEY (`ArtistaID`) REFERENCES `artistas` (`ArtistaID`);

--
-- Filtros para la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD CONSTRAINT `artistas_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`);

--
-- Filtros para la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD CONSTRAINT `canciones_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `canciones_ibfk_2` FOREIGN KEY (`ArtistaID`) REFERENCES `artistas` (`ArtistaID`);

--
-- Filtros para la tabla `historialreproduccion`
--
ALTER TABLE `historialreproduccion`
  ADD CONSTRAINT `historialreproduccion_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `historialreproduccion_ibfk_2` FOREIGN KEY (`CancionID`) REFERENCES `canciones` (`CancionID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
