SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bibliotecauni`
--
CREATE DATABASE bdbibliocbta;
USE bdbibliocbta;

-- drop database bdbibliocbta;

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuario` (
  `usuario_id` INT NOT NULL,
  `usuario_dni` VARCHAR(20) CHARACTER SET latin1 NOT NULL,
  `usuario_nombre` VARCHAR(50) CHARACTER SET latin1 NOT NULL,
  `usuario_apellido` VARCHAR(50) CHARACTER SET latin1 NOT NULL,
  `usuario_telefono` VARCHAR(20) CHARACTER SET latin1 NOT NULL,
  `usuario_direccion` VARCHAR(200) CHARACTER SET latin1 NOT NULL,
  `usuario_email` VARCHAR(150) CHARACTER SET latin1 NOT NULL,
  `usuario_usuario` VARCHAR(50) CHARACTER SET latin1 NOT NULL,
  `usuario_clave` VARCHAR(535) CHARACTER SET latin1 NOT NULL,
  `usuario_estado` VARCHAR(17) CHARACTER SET latin1 NOT NULL,
  `usuario_privilegio` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuario` (`usuario_id`, `usuario_dni`, `usuario_nombre`, `usuario_apellido`,`usuario_telefono`,
 `usuario_direccion`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_estado`, `usuario_privilegio`)
 VALUES (1, '2034332', 'Administrador', 'Principal', '9543321122', 'conocida', 'exampe@gmail.com', 'admin',
 'Uk1mMFhkMkZOUjlkbWtEZ0JVcnY4dz09', 'Activa', 1);

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` INT NOT NULL PRIMARY KEY auto_increment,
  `nombre_categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` INT NOT NULL,
  `foto` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 NOT NULL,
  `descripcion` varchar(255) CHARACTER SET latin1 NOT NULL,
  `disponible` varchar(2) CHARACTER SET latin1 NOT NULL,
  `id_categoria` int(10) NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `archivo_pdf` varchar(50) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);
  
  --
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_categoria` (`id_categoria`);

-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` INT NOT NULL AUTO_INCREMENT;

  --
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` INT NOT NULL AUTO_INCREMENT;

-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
