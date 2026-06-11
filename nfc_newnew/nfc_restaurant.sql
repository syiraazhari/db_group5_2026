-- phpMyAdmin SQL Dump
-- NFC Restaurant - Updated Schema
-- Database: `nfc_restaurant`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Table: customer
-- --------------------------------------------------------
CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: menu_category
-- --------------------------------------------------------
CREATE TABLE `menu_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `menu_category` (`category_name`, `display_order`) VALUES
('Burgers', 1),
('Chicken', 2),
('Wraps', 3),
('Beverages', 4);

-- --------------------------------------------------------
-- Table: menu
-- --------------------------------------------------------
CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`menu_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `menu_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `menu` (`menu_name`, `price`, `old_price`, `category_id`, `description`, `image`) VALUES
('Classic Chicken Burger',  8.90, 12.90, 1, 'Crispy chicken fillet served with fresh lettuce and mayonnaise.',     'img/menu/classic_burger.jpg'),
('Spicy Chicken Burger',    9.90, 13.90, 1, 'Crispy spicy fillet topped with mayonnaise.',                          'img/menu/spicy_burger.jpg'),
('Cheese Chicken Burger',  10.90, 14.90, 1, 'Crispy fillet topped with melted cheese.',                             'img/menu/cheese_burger.jpg'),
('BBQ Chicken Burger',     11.90, 15.90, 1, 'Crispy chicken fillet coated with smoky BBQ sauce and lettuce.',       'img/menu/bbq_burger.jpg'),
('2-pc Fried Chicken',     12.90, 16.90, 2, 'Two pieces of crispy golden fried chicken.',                           'img/menu/chicken_2pc.jpg'),
('3-pc Fried Chicken',     16.90, 20.90, 2, 'Three pieces of crispy golden fried chicken.',                         'img/menu/chicken_3pc.jpg'),
('Spicy Fried Chicken',    13.90, 17.90, 2, 'Crispy fried chicken seasoned with spicy herbs and spices.',           'img/menu/chicken_spicy.jpg'),
('Popcorn Chicken',         8.90, 12.90, 2, 'Bite-sized crispy chicken pieces seasoned with flavorful spices.',     'img/menu/popcorn_chicken.jpg'),
('Crispy Chicken Wrap',     9.90, NULL,  3, 'Crispy chicken wrapped with fresh vegetables and sauce.',              'img/menu/crispy_wrap.jpg'),
('Spicy Chicken Wrap',     10.90, NULL,  3, 'Spicy crispy chicken wrapped with lettuce and sauce.',                 'img/menu/spicy_wrap.jpg'),
('Cheese Chicken Wrap',    11.90, NULL,  3, 'Chicken wrapped with fresh vegetables and melted cheese.',             'img/menu/cheese_wrap.jpg'),
('Coca-Cola',               3.90, NULL,  4, 'Iconic refreshing carbonated soft drink served chilled.',              'img/menu/cola.jpg'),
('Sprite',                  3.90, NULL,  4, 'Famous lemon-lime flavored soft drink served chilled.',                'img/menu/sprite.jpg'),
('Iced Lemon Tea',          4.90, NULL,  4, 'Refreshing tea blended with a hint of lemon flavor.',                  'img/menu/lemon_tea.jpg'),
('Mineral Water',           2.50, NULL,  4, 'Pure bottled drinking water.',                                         'img/menu/mineral.jpg');

-- --------------------------------------------------------
-- Table: orders
-- --------------------------------------------------------
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_status` enum('pending','preparing','ready','completed','cancelled') DEFAULT 'pending',
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: order_details
-- --------------------------------------------------------
CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: staff
-- --------------------------------------------------------
CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `staff` (`username`, `password`, `full_name`, `email`, `role`) VALUES
('admin', 'admin123', 'Administrator', 'admin@nfc.com', 'admin'),
('staff', 'staff123', 'Kitchen Staff', 'staff@nfc.com', 'staff');

-- --------------------------------------------------------
-- Table: system_info
-- --------------------------------------------------------
CREATE TABLE `system_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `info_key` varchar(100) NOT NULL,
  `info_value` text DEFAULT NULL,
  PRIMARY KEY (`info_id`),
  UNIQUE KEY `info_key` (`info_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `system_info` (`info_key`, `info_value`) VALUES
('restaurant_name', 'Nandawgs Fried Chicken'),
('restaurant_address', 'No. 12, Jalan Tuanku Abdul Halim, 50480 Kuala Lumpur'),
('restaurant_phone', '+603-2612 3456'),
('restaurant_email', 'hello@nfc.com.my'),
('restaurant_hours', 'Wed-Thu: 9AM-10PM | Fri: 9AM-11PM | Sat: 10AM-11:30PM | Sun: 11AM-9PM'),
('currency', 'RM'),
('tax_rate', '0'),
('footer_text', '© 2026 Nandawgs Fried Chicken. Distributed by Group 4(WP) / 5(DB)');

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
