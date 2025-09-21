-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para inventory_mvc
CREATE DATABASE IF NOT EXISTS `inventory_mvc` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `inventory_mvc`;

-- Volcando estructura para tabla inventory_mvc.inventario
CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `oficina_id` int(11) DEFAULT NULL,
  `estado` enum('DISPONIBLE','AGOTADO') NOT NULL DEFAULT 'DISPONIBLE',
  `estante` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `fk_inv_oficina` (`oficina_id`),
  CONSTRAINT `fk_inv_oficina` FOREIGN KEY (`oficina_id`) REFERENCES `oficinas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla inventory_mvc.inventario: ~6 rows (aproximadamente)
INSERT INTO `inventario` (`id`, `codigo`, `nombre`, `descripcion`, `cantidad`, `oficina_id`, `estado`, `estante`, `created_at`, `updated_at`) VALUES
	(1, 'HD-001', 'Disco Duro 1TB', 'WD Blue', 13, 1, 'DISPONIBLE', 'E1', '2025-09-05 14:50:11', '2025-09-18 15:21:30'),
	(2, 'SSD-256', 'SSD 256GB', 'SATA 2.5"', 5, 2, 'DISPONIBLE', 'E2', '2025-09-05 14:50:11', NULL),
	(3, '173264', 'LAPTOP', 'FDSFSDFSDF', 0, 2, 'AGOTADO', '1', '2025-09-05 15:13:59', '2025-09-12 14:59:11'),
	(4, 'SAMU123', 'SAMUEL', 'erewrew', 12, 1, 'DISPONIBLE', 'e1', '2025-09-18 16:03:29', '2025-09-18 16:03:29'),
	(5, '3212', 'DSFDFSDF', 'FDDSFSDF', 32, 1, 'DISPONIBLE', 'DF', '2025-09-18 16:06:00', '2025-09-18 16:06:00'),
	(7, 'sdsd3', 'dadasd', 'aasd', 23, 3, 'DISPONIBLE', 'cs2', '2025-09-18 16:07:22', '2025-09-18 16:07:22');

-- Volcando estructura para tabla inventory_mvc.movimientos
CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventario_id` int(11) NOT NULL,
  `tipo` enum('ENTRADA','SALIDA') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `motivo` text DEFAULT NULL,
  `oficina_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_mov_inv` (`inventario_id`),
  KEY `fk_mov_ofi` (`oficina_id`),
  KEY `fk_mov_user` (`user_id`),
  CONSTRAINT `fk_mov_inv` FOREIGN KEY (`inventario_id`) REFERENCES `inventario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mov_ofi` FOREIGN KEY (`oficina_id`) REFERENCES `oficinas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_mov_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla inventory_mvc.movimientos: ~8 rows (aproximadamente)
INSERT INTO `movimientos` (`id`, `inventario_id`, `tipo`, `cantidad`, `motivo`, `oficina_id`, `user_id`, `created_at`) VALUES
	(1, 1, 'SALIDA', 2, 'INSTALAR EN OFICINA DE DIRECCION', NULL, 3, '2025-09-05 15:13:21'),
	(2, 3, 'ENTRADA', 2, 'Registro inicial', 2, 3, '2025-09-05 15:13:59'),
	(3, 3, 'SALIDA', 1, 'Uso/Salida de stock', 1, 3, '2025-09-05 15:14:19'),
	(4, 3, 'SALIDA', 1, 'AREA', 1, 3, '2025-09-12 14:59:11'),
	(5, 1, 'SALIDA', 5, 'khdfhksdhfkshdlkfhsdfsdf', 2, 3, '2025-09-18 15:21:30'),
	(6, 4, 'ENTRADA', 12, 'Registro inicial', 1, 3, '2025-09-18 16:03:29'),
	(7, 5, 'ENTRADA', 32, 'Registro inicial', 1, 3, '2025-09-18 16:06:00'),
	(8, 7, 'ENTRADA', 23, 'Registro inicial', 3, 3, '2025-09-18 16:07:22');

-- Volcando estructura para tabla inventory_mvc.oficinas
CREATE TABLE IF NOT EXISTS `oficinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla inventory_mvc.oficinas: ~3 rows (aproximadamente)
INSERT INTO `oficinas` (`id`, `nombre`, `descripcion`, `estado`, `created_at`) VALUES
	(1, 'Almacén Central', 'Oficina principal de almacenamiento', 1, '2025-09-05 14:50:11'),
	(2, 'Oficina de Sistemas', 'Área de TI', 1, '2025-09-05 14:50:11'),
	(3, 'LABORATIO 1', '', 1, '2025-09-05 16:18:08');

-- Volcando estructura para tabla inventory_mvc.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla inventory_mvc.users: ~2 rows (aproximadamente)
INSERT INTO `users` (`id`, `username`, `password_hash`, `nombre`, `estado`, `created_at`) VALUES
	(3, 'admin', '$2y$10$cSt/Z1VHfKeMtFmbO9lq7Oo.AANCe6FwKnC7T3afn1Y4h.nKtmli.', 'Administrador', 1, '2025-09-05 14:56:01'),
	(4, 'jefe', '$2y$10$Wq6b1v3kQeT0aVYJ4v5xseKgh3GQ5rj8k4QvH1uBWk9bH3l8M3n1K', 'Jefe de Inventario', 1, '2025-09-05 14:59:49');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
