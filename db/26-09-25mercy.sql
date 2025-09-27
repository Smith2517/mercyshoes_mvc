-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para mercyshoes_db
CREATE DATABASE IF NOT EXISTS `mercyshoes_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `mercyshoes_db`;

-- Volcando estructura para tabla mercyshoes_db.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla mercyshoes_db.categories: ~9 rows (aproximadamente)
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'Tacones', 'Elegantes y sofisticados'),
	(2, 'Zapatillas', 'Comodidad para el día a día'),
	(3, 'Sandalias', 'Ideales para verano'),
	(4, 'Tacones de vestir', ''),
	(5, 'Sandalias Urbanas', 'Sandalias cómodas y modernas para lucir fresca y elegante en cualquier ocasión. Diseños versátiles que combinan estilo y confort'),
	(6, 'Tacones de vestir ', 'Eleva tu look con nuestra colección de tacones chic y sofisticados para cada ocasión'),
	(7, 'Tacones de cristal', 'Nuestra colección acrílica con efecto transparente que combina glamour, comodidad y estilo para destacar en cada ocasión especial.'),
	(8, 'Botines tren', 'Nuestra colección Botines Gram combina estilo, comodidad y tendencia. Diseños versátiles y modernos que te acompañen desde looks casuales hasta hasta looks elegantes, dándote un toque único en cada paso.'),
	(9, 'Resorte Mariposa', ''),
	(10, 'Estiletos Elegantes', 'Tacón fino y acabado impecable que transforman tu outfit en pura elegancia'),
	(11, 'Confort Base', 'El Equilibrio perfecto entre diseño y comodidad para tus pies');

-- Volcando estructura para tabla mercyshoes_db.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(200) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_phone` varchar(60) DEFAULT '',
  `customer_address` varchar(255) DEFAULT '',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('PENDIENTE','PAGADO','ENVIADO','CANCELADO') DEFAULT 'PENDIENTE',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla mercyshoes_db.orders: ~0 rows (aproximadamente)
INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total`, `status`, `created_at`) VALUES
	(1, 'ruth mercy carrasco alarcon', 'ruthmercycarrascoalarcon@gmail.com', '910760921', 'nueva cajamarca', 89.50, 'ENVIADO', '2025-09-21 03:27:00');

-- Volcando estructura para tabla mercyshoes_db.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla mercyshoes_db.order_items: ~0 rows (aproximadamente)
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
	(1, 1, 3, 1, 89.50, 89.50);

-- Volcando estructura para tabla mercyshoes_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla mercyshoes_db.products: ~48 rows (aproximadamente)
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `image`) VALUES
	(1, 4, 'Astrid Nude', 'Alto 5 CM\r\nCharol Importado\r\n35-36-37', 85.00, 3, 'public/uploads/1758658227_XVF077721.jpg'),
	(2, 4, 'Elsa Blanco', 'Alto 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 85.00, 6, 'public/uploads/1758658073_XVF077652.jpg'),
	(3, 4, 'Flavia blanco', 'Alto 7CM\r\nCuero Importado \r\n35-36-37\r\nblanco con acabado brillante', 85.00, 2, 'public/uploads/1758425029_XVF07747.jpg'),
	(4, 5, 'sweet Bow', 'Colección Mediterránea\r\nTaco 1CM\r\n35-36-37-38-39', 45.00, 5, 'public/uploads/1758424991_XVF077841.jpg'),
	(5, 4, 'Eva blanco', 'Alto 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 98.00, 0, 'public/uploads/1758658618_XVF07744.jpg'),
	(6, 4, 'Brisa Negro', 'Nueva Colección \r\nAlto 9 CM\r\nCharol Importado\r\n35-36-37-38-39', 95.00, 5, 'public/uploads/1758658881_XVF077602.jpg'),
	(7, 4, 'Coquette Negro y Rosado', 'New Colección \r\nAlto 7 CM\r\nCuero Importado\r\n35-36-37-38', 95.00, 8, 'public/uploads/1758659664_XVF07739.jpg'),
	(8, 7, 'Brillo Negro', 'Colección Disco\r\nAlto 9 CM\r\nCuero Importado\r\n35-36-37-38-39', 108.00, 8, 'public/uploads/1758660521_WhatsAppImage2025-09-23at3.47.47PM2.jpeg'),
	(9, 7, 'Anastacia Negro', 'Colección Disco\r\nAlto 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 108.00, 10, 'public/uploads/1758660674_dc76a6d0-dae6-4b15-ab21-50bb6bdd8401.jpg'),
	(10, 7, 'Libertad Negro', 'Colección Disco\r\nAlto 9 CM\r\nAcrílico Importado\r\n35-36-37-38-39\r\n', 108.00, 10, 'public/uploads/1758660810_f4360304-9f11-4952-a6a5-bed0f0c36419.jpg'),
	(11, 7, 'Candela Dorado', 'Colección Disco\r\nAlto 9 CM\r\nAcrílico Importado\r\n35-36-37-38-39', 108.00, 10, 'public/uploads/1758661070_b8ef0ed2-43be-4078-93a4-1db526786909.jpg'),
	(12, 9, 'Mariposa', 'Colección Disco\r\nAlto 7 CM\r\nCuero Negro Importado\r\n35-36-37-38-39', 108.00, 8, 'public/uploads/1758661275_XVF07749.jpg'),
	(13, 9, 'Rocio Blanco', 'Alto 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 95.00, 6, 'public/uploads/1758661588_WhatsAppImage2025-09-23at3.58.21PM.jpeg'),
	(14, 7, 'Linda Besh', 'Alto 5 CM\r\nAcrilico \r\n35-36-37-38-39', 98.00, 5, 'public/uploads/1758661707_bd54f7cf-1793-444a-bb01-ad094d23312d.jpg'),
	(15, 7, 'Linda Blanco', 'Colección Mediterranea\r\nAlto 9 CM\r\n35-36-37-38-39', 98.00, 5, 'public/uploads/1758661837_63bb99b1-7d42-488c-8ca6-505e029832b4.jpg'),
	(16, 7, 'ST23-Negro y Plateado', 'Colección Disco\r\nAlto 9 CM\r\nAcrilico\r\n35-36-37-38-39', 108.00, 6, 'public/uploads/1758662040_374087fa-5488-4fa8-817d-f4aad10733b9.jpg'),
	(17, 7, 'Cenicienta Acrilico', 'Colección Disco \r\nAlto 7 CM\r\n35-36-37-38-39', 105.00, 5, 'public/uploads/1758664132_XVF07743.jpg'),
	(18, 7, 'Dafne Transparente', 'Colección Disco \r\nAlto 7 CM\r\nAcrílico\r\n35-36-37-38-39', 98.00, 5, 'public/uploads/1758664236_XVF07770.jpg'),
	(19, 4, 'Laura Rosado', 'Alto 9 CM \r\nCuero Importado\r\n35-36-37-38-39', 85.00, 8, 'public/uploads/1758664653_9b1a487e-4f8f-41f1-bae9-afbbe82d6d91.jpg'),
	(20, 4, 'Cami Negro', 'Alto 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 95.00, 7, 'public/uploads/1758664760_0d3b790e-3d77-4015-9e82-61f10732b2b5.jpg'),
	(21, 4, 'scarlett - Lila', 'Alto 5 CM\r\nCuero Importado\r\n35-36-37-38-39', 95.00, 8, 'public/uploads/1758664954_d519d50d-d1d4-49b1-9082-d6797af7b19e.jpg'),
	(22, 4, 'Anni Beis', 'Alto 9 CM\r\nCuero suéter\r\n35-36-37', 85.00, 5, 'public/uploads/1758665129_876f317b-c3be-474d-810e-c7f75c963687.jpg'),
	(23, 4, 'Makarena Negro', 'Alto 7 CM \r\nCuero Importado\r\n35-36-37-38-39', 85.00, 6, 'public/uploads/1758665273_f78151f7-6793-4d13-a263-dc76b0fb6f44.jpg'),
	(24, 4, 'Bordado Beis', 'Alto 7 CM\r\nSuéter Importado\r\n35-36-37-38-39', 85.00, 8, 'public/uploads/1758665478_c33b5a58-5663-4716-bb03-d7851d65fa0b.jpg'),
	(25, 4, 'Aurora-10', 'Colección Mediterránea\r\nAlto 9 CM\r\nCuero Importado\r\n35-36-37-38-39', 0.00, 0, 'public/uploads/1758665774_0d80e37b-83a8-4fdd-bdf2-ba7ffa8264e3.jpg'),
	(26, 4, 'Burbuja Pink', 'Alto 5 CM\r\nCuero Importado\r\n35-36-37-38-39', 95.00, 10, 'public/uploads/1758665901_515f6437-422d-4966-b9a9-e3fc517ed63c.jpg'),
	(27, 4, 'Asucena Blanco', 'Alto 5 CM\r\nCuero Importado\r\n35-36-37-38-39', 95.00, 10, 'public/uploads/1758666126_fd04d35c-c1a6-4399-8de5-78ada2ae4002.jpg'),
	(28, 11, 'Luisa Negro', 'Colección Mediterranea\r\nAlto 11CM\r\nCuero Importado\r\n36-37-39', 95.00, 4, 'public/uploads/1758742963_473252ba-4067-4b0e-be1d-a7f5c6176e4a.jpg'),
	(29, 11, 'Catrina Beis', 'Alto 11 CM\r\nQuiebre 7 Cm\r\nCuero Importado\r\n36-37', 95.00, 3, 'public/uploads/1758743091_460ece2e-ce62-4b3f-a5d3-f0f76bf2091b.jpg'),
	(30, 11, 'Eloisa Rojo', 'Colección Mediterranea\r\nAlto 11 CM\r\nQuiebre 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 98.00, 7, 'public/uploads/1758743421_5872e421-3fb2-4a87-b083-f01763f2bf39.jpg'),
	(31, 11, 'Fantasia Jean', 'Colección Mediterranea\r\nAlto 11 CM\r\nQuiebre 7 CM\r\nCuero Importado\r\n36-37-38', 98.00, 4, 'public/uploads/1758743725_2d84b9d3-53ae-46b5-9b35-111b6c065f35.jpg'),
	(32, 11, 'S 10 Blanco Charol', 'Nueva Colección\r\nAlto 7 CM\r\nCharol Importado \r\n35-36-37', 98.00, 6, 'public/uploads/1758743929_9d7253e4-ebf7-4f4e-8fd2-7f129676864a.jpg'),
	(33, 11, 'Adriana Blanco', 'Alto 9 CM\r\nCuero Importado \r\n35-36-37-38-39', 98.00, 5, 'public/uploads/1758744091_8df22f7d-2cfe-43de-a581-0004706b0282.jpg'),
	(34, 10, 'Gaby Chanel', 'Nueva Colección \r\nAlto 9 CM\r\nCuero Importado\r\n36-37-39', 110.00, 5, 'public/uploads/1758744206_5d514e72-a8ca-4edc-8d21-3e1c9e697bbe.jpg'),
	(35, 10, 'Mirian Denin ', 'Alto 9 CM\r\nCuero Importado\r\n37-37-38', 110.00, 6, 'public/uploads/1758744319_867677a0-e7b7-458e-84f3-e7741122b23a.jpg'),
	(36, 10, 'Ariel Blanco', 'Nueva Colección\r\nAlto 9 CM\r\nCuero Importado\r\n35-36-37-38-39', 110.00, 10, 'public/uploads/1758744609_5b5dc3f6-081a-4481-9735-3f5bcfcc9b56.jpg'),
	(37, 10, 'Yandi Negro', 'Nueva Colección \r\nAlto 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 110.00, 10, 'public/uploads/1758744752_04c37461-6384-4ded-b470-dee1ed383dce.jpg'),
	(38, 10, 'Lazo Vino', 'Nueva Colección\r\nAlto 9 cm\r\nCharol Importado\r\n35-36-37-38-39', 110.00, 12, 'public/uploads/1758744930_b9b26cee-a225-4bc1-8d23-a6150b0ac303.jpg'),
	(39, 10, 'Rubi Beis', 'Nueva Colección\r\nAlto  7 CM\r\nCuero Importado\r\n35-36-37-38-39', 110.00, 10, 'public/uploads/1758745141_65f0dfb9-29e4-49fe-9fac-e80fc163a6ec.jpg'),
	(40, 10, 'Rubi Denim', 'Nueva Colección\r\nAlto 7 CM\r\nCuero Importado\r\n35-36-37-38-39', 110.00, 8, 'public/uploads/1758745299_5c8253f4-41bc-496e-83cd-3f4b39c4766a.jpg'),
	(41, 5, 'Zoe Blanco', 'Alto 1 cm\r\nCuero Importado\r\n35-37-38', 45.00, 3, 'public/uploads/1758745676_XVF07775.jpg'),
	(42, 5, 'Trenza Blanco', 'Alto 1 CM\r\nCuero Importado\r\n35-36-37', 45.00, 4, 'public/uploads/1758745878_XVF077792.jpg'),
	(43, 5, 'Trenza Negro', 'Alto 1 CM\r\nCuero Importado\r\n35-36-37', 45.00, 3, 'public/uploads/1758746073_XVF07786.jpg'),
	(44, 5, 'Catalina Jean', 'Alto 1 CM\r\nCuero  Importado\r\n37', 45.00, 1, 'public/uploads/1758746229_XVF07790.jpg'),
	(45, 8, 'Nile Marron', 'Nueva Colección\r\n Alto 9 CM\r\nCuero Importado\r\n35-36-37-38-39', 105.00, 8, 'public/uploads/1758746616_56fc09ae-762e-4920-ac5e-2d98d3a9a8ef.jpg'),
	(46, 8, 'Monarco Negro', 'Nueva Colección \r\nAlto 9 CM\r\nCuero Importado\r\n35-36-37-38-39', 105.00, 6, 'public/uploads/1758746808_7ac089e9-b242-458b-8bd6-9b6f9333d0f8.jpg'),
	(47, 8, 'Amaranto Beis', 'Nueva Colección\r\nAlto 9 CM\r\nCuero Importado\r\n35-36-37-38-39', 105.00, 6, 'public/uploads/1758747056_32a509e4-82ed-49d9-a248-a680831b1c73.jpg'),
	(48, 8, 'Tex- 015 Blanco', 'Nueva colección\r\nAlto 7 CM\r\nCuero Importado\r\n35-36-37-38', 105.00, 4, 'public/uploads/1758747275_8bf2462d-c0fb-4609-bab7-4c2a833d1665.jpg'),
	(49, 5, 'Ada Rojo', 'Colección Mediterranea\r\nAlto 1 CM\r\n35-36-37-38-39', 45.00, 6, 'public/uploads/1758747538_60363056-9ec7-4c63-b97d-bd72a7e1632d.jpg'),
	(50, 5, 'Erika Dorado', 'Colección Mediterranea\r\nAlto 1 CM\r\nCuero Importado\r\n36-37-38-39', 45.00, 4, 'public/uploads/1758747732_d9a48bef-da47-4777-a009-9d8e5a422007.jpg');

-- Volcando estructura para tabla mercyshoes_db.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) NOT NULL,
  `company_email` varchar(150) NOT NULL,
  `company_phone` varchar(60) NOT NULL,
  `company_address` varchar(255) DEFAULT '',
  `company_ruc` varchar(32) DEFAULT '',
  `logo_path` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla mercyshoes_db.settings: ~0 rows (aproximadamente)
INSERT INTO `settings` (`id`, `company_name`, `company_email`, `company_phone`, `company_address`, `company_ruc`, `logo_path`) VALUES
	(1, 'Mercyshoes', 'ventas@mercyshoes.local', '+51 900 000 000', 'Tarapoto, Perú', '00000000000', '');

-- Volcando estructura para tabla mercyshoes_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla mercyshoes_db.users: ~0 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
	(1, 'Admin', 'admin@mercyshoes.local', '$2y$10$0e34e1uwoFQ5E5mJYGZ9m.gNKdHnKTLhT18FseLmgU2ddR83utvdG', 'admin', '2025-09-21 03:05:36');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
