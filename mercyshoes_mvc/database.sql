-- MySQL schema for Mercyshoes (XAMPP / MariaDB)
CREATE DATABASE IF NOT EXISTS mercyshoes_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mercyshoes_db;

-- Users (admins)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin') DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Company settings (single row)
CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR(150) NOT NULL,
  company_email VARCHAR(150) NOT NULL,
  company_phone VARCHAR(60) NOT NULL,
  company_address VARCHAR(255) DEFAULT '',
  company_ruc VARCHAR(32) DEFAULT '',
  logo_path VARCHAR(255) DEFAULT ''
);

-- Categories
CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  description TEXT
);

-- Products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NULL,
  name VARCHAR(200) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  stock INT NOT NULL DEFAULT 0,
  image VARCHAR(255) DEFAULT '',
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Orders
CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(200) NOT NULL,
  customer_email VARCHAR(150) NOT NULL,
  customer_phone VARCHAR(60) DEFAULT '',
  customer_address VARCHAR(255) DEFAULT '',
  total DECIMAL(10,2) NOT NULL DEFAULT 0,
  status ENUM('PENDIENTE','PAGADO','ENVIADO','CANCELADO') DEFAULT 'PENDIENTE',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order items
CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

-- Demo data
INSERT INTO users (name,email,password_hash) VALUES
('Admin','admin@mercyshoes.local', '$2y$10$P4nUvZlbrOeWqUu4BzXvVuF5l0iK0u/7bG6mqf0Yc7b5KQx1y0VnG'); -- password: admin123

INSERT INTO categories (name,description) VALUES 
('Tacones','Elegantes y sofisticados'),('Zapatillas','Comodidad para el día a día'),('Sandalias','Ideales para verano');

INSERT INTO products (category_id,name,description,price,stock,image) VALUES
(1,'Stiletto Negro','Tacón fino y punta elegante.',159.90,10,''),
(2,'Zapatilla Urbana','Estilo casual, suela cómoda.',119.00,20,''),
(3,'Sandalia Dorada','Brillo y comodidad.',89.50,15,'');

-- Default settings row
INSERT INTO settings (company_name, company_email, company_phone, company_address, company_ruc, logo_path)
VALUES ('Mercyshoes', 'ventas@mercyshoes.local', '+51 900 000 000', 'Tarapoto, Perú', '00000000000', '');
